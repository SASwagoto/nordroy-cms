<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\GalleryAlbum;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\PhotoGallery;
use App\Services\MediaStorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Photo Gallery | Corporate CMS')]
class PhotoGalleryManager extends Component
{
    use WithPagination, WithFileUploads;

    #[Url(as: 'album')]
    public ?int $selectedAlbumId = null;

    #[Url(as: 'q')]
    public string $search = '';

    // Languages
    public $languages = [];
    public string $activeLocale = 'en';

    // In-Modal File Upload Support (for <x-media-picker-modal />)
    public $uploads = [];
    public string $uploadFolder = 'gallery';
    public bool $autoCompress = true;
    public ?string $modalTargetField = null;
    public ?int $modalTargetIndex = null;

    // Photo Edit State
    public bool $isPhotoModalOpen = false;
    public ?int $editingPhotoId = null;
    public array $photoTitle = [];
    public string $photoTitleEn = '';
    public string $photoTitleBn = '';
    public array $photoCaption = [];
    public string $photoCaptionEn = '';
    public string $photoCaptionBn = '';
    public ?int $photoAlbumId = null;
    public int $photoOrder = 0;
    public bool $photoIsActive = true;

    // Album Management State
    public bool $isAlbumModalOpen = false;
    public ?int $editingAlbumId = null;
    public array $albumName = [];
    public string $albumNameEn = '';
    public string $albumNameBn = '';
    public string $albumSlug = '';
    public array $albumDescription = [];
    public string $albumDescriptionEn = '';
    public string $albumDescriptionBn = '';
    public ?int $albumCoverImageId = null;
    public ?string $albumCoverImageUrl = null;
    public int $albumOrder = 0;
    public bool $albumIsActive = true;

    // Delete Confirmation
    public bool $isDeleteModalOpen = false;
    public string $deleteType = ''; // 'photo' or 'album'
    public ?int $deleteId = null;
    public string $deleteName = '';

    public function mount(): void
    {
        $this->languages = Language::active()->orderBy('order')->get();
        if ($this->languages->isEmpty()) {
            $this->languages = collect([
                (object) ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag_icon' => '🇬🇧', 'is_default' => true],
                (object) ['code' => 'bn', 'name' => 'Bengali', 'native_name' => 'বাংলা', 'flag_icon' => '🇧🇩', 'is_default' => false],
            ]);
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedAlbumId(): void
    {
        $this->resetPage();
    }

    public function setLocale(string $locale): void
    {
        $this->activeLocale = $locale;
    }

    // ==========================================
    // BATCH & SINGLE PHOTO SELECTION
    // ==========================================
    public function selectMultipleAssets(array $ids, ?string $targetField = null): void
    {
        if (empty($ids)) {
            return;
        }

        $albumId = $this->selectedAlbumId;
        $maxOrder = (int) PhotoGallery::where('album_id', $albumId)->max('order');
        $addedCount = 0;

        foreach ($ids as $assetId) {
            $asset = MediaAsset::find($assetId);
            if (!$asset) continue;

            $maxOrder++;
            $title = [
                'en' => $asset->getTranslation('title', 'en') ?: pathinfo($asset->file_name, PATHINFO_FILENAME),
                'bn' => $asset->getTranslation('title', 'bn') ?: '',
            ];

            PhotoGallery::create([
                'album_id'  => $albumId,
                'media_id'  => $asset->id,
                'title'     => $title,
                'caption'   => ['en' => '', 'bn' => ''],
                'order'     => $maxOrder,
                'is_active' => true,
            ]);
            $addedCount++;
        }

        session()->flash('message', "{$addedCount} photo(s) successfully added to photo gallery.");
    }

    public function openEditPhotoModal(int $id): void
    {
        $this->editPhoto($id);
    }

    public function editPhoto(int $id): void
    {
        $photo = PhotoGallery::with('media')->findOrFail($id);
        $this->editingPhotoId = $photo->id;

        $rawTitle = $photo->title ?? [];
        $rawTitle = is_array($rawTitle) ? $rawTitle : (json_decode($rawTitle, true) ?? ['en' => (string) $rawTitle]);

        $rawCaption = $photo->caption ?? [];
        $rawCaption = is_array($rawCaption) ? $rawCaption : (json_decode($rawCaption, true) ?? ['en' => (string) $rawCaption]);

        $this->photoTitle = [];
        $this->photoCaption = [];
        foreach ($this->languages as $lang) {
            $this->photoTitle[$lang->code] = $rawTitle[$lang->code] ?? ($lang->code === 'en' ? (reset($rawTitle) ?: '') : '');
            $this->photoCaption[$lang->code] = $rawCaption[$lang->code] ?? ($lang->code === 'en' ? (reset($rawCaption) ?: '') : '');
        }

        $this->photoTitleEn = $this->photoTitle['en'] ?? '';
        $this->photoTitleBn = $this->photoTitle['bn'] ?? '';
        $this->photoCaptionEn = $this->photoCaption['en'] ?? '';
        $this->photoCaptionBn = $this->photoCaption['bn'] ?? '';

        $this->photoAlbumId = $photo->album_id;
        $this->photoOrder = (int) $photo->order;
        $this->photoIsActive = (bool) $photo->is_active;

        $this->isPhotoModalOpen = true;
    }

    public function savePhoto(): void
    {
        if (!$this->editingPhotoId) return;

        $photo = PhotoGallery::findOrFail($this->editingPhotoId);

        if (!empty($this->photoTitleEn)) {
            $this->photoTitle['en'] = $this->photoTitleEn;
        }
        if (!empty($this->photoTitleBn)) {
            $this->photoTitle['bn'] = $this->photoTitleBn;
        }
        if (!empty($this->photoCaptionEn)) {
            $this->photoCaption['en'] = $this->photoCaptionEn;
        }
        if (!empty($this->photoCaptionBn)) {
            $this->photoCaption['bn'] = $this->photoCaptionBn;
        }

        $titleData = [];
        $captionData = [];
        if (count($this->languages) > 0) {
            foreach ($this->languages as $lang) {
                $t = trim($this->photoTitle[$lang->code] ?? '');
                $titleData[$lang->code] = !empty($t) ? $t : ($this->photoTitleEn ?: '');

                $c = trim($this->photoCaption[$lang->code] ?? '');
                $captionData[$lang->code] = !empty($c) ? $c : ($this->photoCaptionEn ?: '');
            }
        } else {
            $titleData = [
                'en' => $this->photoTitleEn ?: ($this->photoTitle['en'] ?? ''),
                'bn' => $this->photoTitleBn ?: ($this->photoTitle['bn'] ?? ''),
            ];
            $captionData = [
                'en' => $this->photoCaptionEn ?: ($this->photoCaption['en'] ?? ''),
                'bn' => $this->photoCaptionBn ?: ($this->photoCaption['bn'] ?? ''),
            ];
        }

        $photo->update([
            'album_id'  => $this->photoAlbumId,
            'title'     => $titleData,
            'caption'   => $captionData,
            'order'     => (int) $this->photoOrder,
            'is_active' => (bool) $this->photoIsActive,
        ]);

        $this->isPhotoModalOpen = false;
        $this->editingPhotoId = null;
        session()->flash('message', 'Photo details updated successfully.');
    }

    public function togglePhotoActive(int $id): void
    {
        $photo = PhotoGallery::findOrFail($id);
        $photo->is_active = !$photo->is_active;
        $photo->save();
    }

    // ==========================================
    // ALBUM MANAGEMENT
    // ==========================================
    public function openCreateAlbumModal(): void
    {
        $this->editingAlbumId = null;
        $this->albumName = [];
        $this->albumDescription = [];
        foreach ($this->languages as $lang) {
            $this->albumName[$lang->code] = '';
            $this->albumDescription[$lang->code] = '';
        }
        $this->albumNameEn = '';
        $this->albumNameBn = '';
        $this->albumSlug = '';
        $this->albumDescriptionEn = '';
        $this->albumDescriptionBn = '';
        $this->albumCoverImageId = null;
        $this->albumCoverImageUrl = null;
        $this->albumOrder = (int) GalleryAlbum::max('order') + 1;
        $this->albumIsActive = true;
        $this->activeLocale = 'en';

        $this->isAlbumModalOpen = true;
    }

    public function editAlbum(int $id): void
    {
        $album = GalleryAlbum::with('coverImage')->findOrFail($id);
        $this->editingAlbumId = $album->id;

        $rawName = $album->name ?? [];
        $rawName = is_array($rawName) ? $rawName : (json_decode($rawName, true) ?? ['en' => (string) $rawName]);

        $rawDesc = $album->description ?? [];
        $rawDesc = is_array($rawDesc) ? $rawDesc : (json_decode($rawDesc, true) ?? ['en' => (string) $rawDesc]);

        $this->albumName = [];
        $this->albumDescription = [];
        foreach ($this->languages as $lang) {
            $this->albumName[$lang->code] = $rawName[$lang->code] ?? ($lang->code === 'en' ? (reset($rawName) ?: '') : '');
            $this->albumDescription[$lang->code] = $rawDesc[$lang->code] ?? ($lang->code === 'en' ? (reset($rawDesc) ?: '') : '');
        }

        $this->albumNameEn = $this->albumName['en'] ?? '';
        $this->albumNameBn = $this->albumName['bn'] ?? '';
        $this->albumSlug = $album->slug;
        $this->albumDescriptionEn = $this->albumDescription['en'] ?? '';
        $this->albumDescriptionBn = $this->albumDescription['bn'] ?? '';
        $this->albumCoverImageId = $album->cover_image_id;
        $this->albumCoverImageUrl = $album->coverImage?->url;
        $this->albumOrder = (int) $album->order;
        $this->albumIsActive = (bool) $album->is_active;

        $this->isAlbumModalOpen = true;
    }

    public function updatedAlbumNameEn(string $val): void
    {
        $this->albumName['en'] = $val;
        if (!$this->editingAlbumId && empty($this->albumSlug)) {
            $this->albumSlug = Str::slug($val);
        }
    }

    public function saveAlbum(): void
    {
        if (!empty($this->albumNameEn)) {
            $this->albumName['en'] = $this->albumNameEn;
        }

        $defaultName = $this->albumName['en'] ?? reset($this->albumName) ?? '';
        if (empty(trim($defaultName))) {
            $this->addError('albumNameEn', 'Album name in English is required.');
            return;
        }

        $slug = Str::slug($this->albumSlug ?: $defaultName);

        $nameData = [];
        $descData = [];
        foreach ($this->languages as $lang) {
            $n = trim($this->albumName[$lang->code] ?? '');
            $nameData[$lang->code] = !empty($n) ? $n : $defaultName;

            $d = trim($this->albumDescription[$lang->code] ?? '');
            $descData[$lang->code] = !empty($d) ? $d : ($this->albumDescriptionEn ?: '');
        }

        $payload = [
            'name'           => $nameData,
            'slug'           => $slug,
            'description'    => $descData,
            'cover_image_id' => $this->albumCoverImageId,
            'type'           => 'photo',
            'order'          => (int) $this->albumOrder,
            'is_active'      => (bool) $this->albumIsActive,
        ];

        if ($this->editingAlbumId) {
            GalleryAlbum::findOrFail($this->editingAlbumId)->update($payload);
            session()->flash('message', "Photo album '{$defaultName}' updated.");
        } else {
            GalleryAlbum::create($payload);
            session()->flash('message', "New photo album '{$defaultName}' created.");
        }

        $this->isAlbumModalOpen = false;
        $this->editingAlbumId = null;
    }

    // ==========================================
    // MEDIA PICKER INTEGRATION & IN-MODAL UPLOADS
    // ==========================================
    public function selectAsset(int $assetId, string $assetUrl, ?string $targetField = null, ?int $targetIndex = null): void
    {
        if ($targetField === 'album_cover') {
            $this->albumCoverImageId = $assetId;
            $this->albumCoverImageUrl = $assetUrl;
        } elseif ($targetField === 'gallery_photos') {
            $this->selectMultipleAssets([$assetId], $targetField);
        }

        $this->dispatch('close-media-modal');
    }

    public function uploadFiles(?string $targetField = null, ?int $targetIndex = null): void
    {
        if (empty($this->uploads) || !is_array($this->uploads)) {
            $this->addError('uploads', 'Please select at least one file to upload.');
            return;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
        $service = app(MediaStorageService::class);
        $uploadedIds = [];

        foreach ($this->uploads as $file) {
            if ($file) {
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, $allowedExtensions)) {
                    continue;
                }

                $folder = 'gallery';
                $asset = $service->store($file, $folder, null, $this->autoCompress);
                $uploadedIds[] = $asset->id;

                $this->dispatch('media-asset-uploaded', [
                    'id'       => $asset->id,
                    'name'     => $asset->getTranslation('title', 'en') ?: $asset->file_name,
                    'url'      => $asset->url,
                    'is_image' => true,
                    'size'     => $asset->human_size,
                    'folder'   => 'gallery',
                ]);
            }
        }

        $this->uploads = [];

        if (!empty($uploadedIds)) {
            $field = $targetField ?: $this->modalTargetField;
            if ($field === 'album_cover' && count($uploadedIds) > 0) {
                $last = MediaAsset::find(end($uploadedIds));
                if ($last) $this->selectAsset($last->id, $last->url, 'album_cover');
            } else {
                $this->selectMultipleAssets($uploadedIds, $field);
            }
            $this->dispatch('close-media-modal');
        }
    }

    public function processUploads(?string $targetField = null, ?int $targetIndex = null): void
    {
        $this->uploadFiles($targetField, $targetIndex);
    }

    // ==========================================
    // DELETE ACTIONS
    // ==========================================
    public function confirmDelete(string $type, int $id, string $name = ''): void
    {
        $this->deleteType = $type;
        $this->deleteId = $id;
        $this->deleteName = $name;
        $this->isDeleteModalOpen = true;
    }

    public function executeDelete(): void
    {
        if ($this->deleteType === 'photo' && $this->deleteId) {
            PhotoGallery::find($this->deleteId)?->delete();
            session()->flash('message', 'Photo removed from gallery.');
        } elseif ($this->deleteType === 'album' && $this->deleteId) {
            GalleryAlbum::find($this->deleteId)?->delete();
            if ($this->selectedAlbumId === $this->deleteId) {
                $this->selectedAlbumId = null;
            }
            session()->flash('message', 'Photo album deleted.');
        }

        $this->isDeleteModalOpen = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $albums = GalleryAlbum::withCount('photos')
            ->whereIn('type', ['all', 'photo'])
            ->orderBy('order')
            ->get();

        $photosQuery = PhotoGallery::with(['media', 'album']);
        if ($this->selectedAlbumId) {
            $photosQuery->where('album_id', $this->selectedAlbumId);
        }
        if (!empty(trim($this->search))) {
            $q = trim($this->search);
            $photosQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('caption', 'like', "%{$q}%");
            });
        }
        $photos = $photosQuery->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(24);

        return view('livewire.admin.gallery.photo-gallery-manager', [
            'albums' => $albums,
            'photos' => $photos,
        ]);
    }
}
