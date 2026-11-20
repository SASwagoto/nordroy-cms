<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\GalleryAlbum;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\VideoGallery;
use App\Services\MediaStorageService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Video Gallery | Corporate CMS')]
class VideoGalleryManager extends Component
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

    // Video State
    public bool $isVideoModalOpen = false;
    public ?int $editingVideoId = null;
    public array $videoTitle = [];
    public string $videoTitleEn = '';
    public string $videoTitleBn = '';
    public string $videoYoutubeUrl = '';
    public ?int $videoAlbumId = null;
    public ?int $videoThumbnailId = null;
    public ?string $videoThumbnailUrl = null;
    public array $videoDescription = [];
    public string $videoDescriptionEn = '';
    public string $videoDescriptionBn = '';
    public int $videoOrder = 0;
    public bool $videoIsActive = true;

    // Album State
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
    public string $deleteType = ''; // 'video' or 'album'
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

    public function getYoutubePreviewIdProperty(): ?string
    {
        return VideoGallery::extractYoutubeId($this->videoYoutubeUrl);
    }

    public function openCreateVideoModal(): void
    {
        $this->editingVideoId = null;
        $this->videoTitle = [];
        $this->videoDescription = [];
        foreach ($this->languages as $lang) {
            $this->videoTitle[$lang->code] = '';
            $this->videoDescription[$lang->code] = '';
        }
        $this->videoTitleEn = '';
        $this->videoTitleBn = '';
        $this->videoDescriptionEn = '';
        $this->videoDescriptionBn = '';
        $this->videoYoutubeUrl = '';
        $this->videoAlbumId = $this->selectedAlbumId;
        $this->videoThumbnailId = null;
        $this->videoThumbnailUrl = null;
        $this->videoOrder = (int) VideoGallery::max('order') + 1;
        $this->videoIsActive = true;
        $this->activeLocale = 'en';

        $this->isVideoModalOpen = true;
    }

    public function openEditVideoModal(int $id): void
    {
        $this->editVideo($id);
    }

    public function editVideo(int $id): void
    {
        $video = VideoGallery::with(['thumbnail'])->findOrFail($id);
        $this->editingVideoId = $video->id;

        $rawTitle = $video->title ?? [];
        $rawTitle = is_array($rawTitle) ? $rawTitle : (json_decode($rawTitle, true) ?? ['en' => (string) $rawTitle]);

        $rawDesc = $video->description ?? [];
        $rawDesc = is_array($rawDesc) ? $rawDesc : (json_decode($rawDesc, true) ?? ['en' => (string) $rawDesc]);

        $this->videoTitle = [];
        $this->videoDescription = [];
        foreach ($this->languages as $lang) {
            $this->videoTitle[$lang->code] = $rawTitle[$lang->code] ?? ($lang->code === 'en' ? (reset($rawTitle) ?: '') : '');
            $this->videoDescription[$lang->code] = $rawDesc[$lang->code] ?? ($lang->code === 'en' ? (reset($rawDesc) ?: '') : '');
        }

        $this->videoTitleEn = $this->videoTitle['en'] ?? '';
        $this->videoTitleBn = $this->videoTitle['bn'] ?? '';
        $this->videoDescriptionEn = $this->videoDescription['en'] ?? '';
        $this->videoDescriptionBn = $this->videoDescription['bn'] ?? '';

        $this->videoYoutubeUrl = $video->youtube_url;
        $this->videoAlbumId = $video->album_id;
        $this->videoThumbnailId = $video->thumbnail_id;
        $this->videoThumbnailUrl = $video->thumbnail?->url;
        $this->videoOrder = (int) $video->order;
        $this->videoIsActive = (bool) $video->is_active;

        $this->isVideoModalOpen = true;
    }

    public function saveVideo(): void
    {
        if (!empty($this->videoTitleEn)) {
            $this->videoTitle['en'] = $this->videoTitleEn;
        }
        if (!empty($this->videoDescriptionEn)) {
            $this->videoDescription['en'] = $this->videoDescriptionEn;
        }

        $defaultTitle = $this->videoTitle['en'] ?? reset($this->videoTitle) ?? '';
        if (empty(trim($defaultTitle))) {
            $this->addError('videoTitleEn', 'English title is required.');
            return;
        }

        if (empty(trim($this->videoYoutubeUrl))) {
            $this->addError('videoYoutubeUrl', 'A valid YouTube URL is required.');
            return;
        }

        $ytId = VideoGallery::extractYoutubeId($this->videoYoutubeUrl);
        if (!$ytId) {
            $this->addError('videoYoutubeUrl', 'Could not detect YouTube video ID from URL.');
            return;
        }

        $titleData = [];
        $descData = [];
        if (count($this->languages) > 0) {
            foreach ($this->languages as $lang) {
                $t = trim($this->videoTitle[$lang->code] ?? '');
                $titleData[$lang->code] = !empty($t) ? $t : $defaultTitle;

                $d = trim($this->videoDescription[$lang->code] ?? '');
                $descData[$lang->code] = !empty($d) ? $d : ($this->videoDescriptionEn ?: '');
            }
        } else {
            $titleData = ['en' => $defaultTitle];
            if (!empty($this->videoTitleBn)) $titleData['bn'] = $this->videoTitleBn;
            $descData = ['en' => $this->videoDescriptionEn ?: ''];
            if (!empty($this->videoDescriptionBn)) $descData['bn'] = $this->videoDescriptionBn;
        }

        $payload = [
            'album_id'     => $this->videoAlbumId,
            'title'        => $titleData,
            'youtube_url'  => trim($this->videoYoutubeUrl),
            'youtube_id'   => $ytId,
            'thumbnail_id' => $this->videoThumbnailId,
            'description'  => $descData,
            'order'        => (int) $this->videoOrder,
            'is_active'    => (bool) $this->videoIsActive,
        ];

        if ($this->editingVideoId) {
            VideoGallery::findOrFail($this->editingVideoId)->update($payload);
            session()->flash('message', "Video '{$defaultTitle}' updated.");
        } else {
            VideoGallery::create($payload);
            session()->flash('message', "New video '{$defaultTitle}' added to gallery.");
        }

        $this->isVideoModalOpen = false;
        $this->editingVideoId = null;
    }

    public function toggleVideoActive(int $id): void
    {
        $video = VideoGallery::findOrFail($id);
        $video->is_active = !$video->is_active;
        $video->save();
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
            'type'           => 'video',
            'order'          => (int) $this->albumOrder,
            'is_active'      => (bool) $this->albumIsActive,
        ];

        if ($this->editingAlbumId) {
            GalleryAlbum::findOrFail($this->editingAlbumId)->update($payload);
            session()->flash('message', "Video album '{$defaultName}' updated.");
        } else {
            GalleryAlbum::create($payload);
            session()->flash('message', "New video album '{$defaultName}' created.");
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
        } elseif ($targetField === 'video_thumbnail') {
            $this->videoThumbnailId = $assetId;
            $this->videoThumbnailUrl = $assetUrl;
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
            $last = MediaAsset::find(end($uploadedIds));
            if ($field === 'album_cover' && $last) {
                $this->selectAsset($last->id, $last->url, 'album_cover');
            } elseif ($field === 'video_thumbnail' && $last) {
                $this->selectAsset($last->id, $last->url, 'video_thumbnail');
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
        if ($this->deleteType === 'video' && $this->deleteId) {
            VideoGallery::find($this->deleteId)?->delete();
            session()->flash('message', 'Video removed from gallery.');
        } elseif ($this->deleteType === 'album' && $this->deleteId) {
            GalleryAlbum::find($this->deleteId)?->delete();
            if ($this->selectedAlbumId === $this->deleteId) {
                $this->selectedAlbumId = null;
            }
            session()->flash('message', 'Video album deleted.');
        }

        $this->isDeleteModalOpen = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $albums = GalleryAlbum::withCount('videos')
            ->whereIn('type', ['all', 'video'])
            ->orderBy('order')
            ->get();

        $videosQuery = VideoGallery::with(['thumbnail', 'album']);
        if ($this->selectedAlbumId) {
            $videosQuery->where('album_id', $this->selectedAlbumId);
        }
        if (!empty(trim($this->search))) {
            $q = trim($this->search);
            $videosQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('youtube_url', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }
        $videos = $videosQuery->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(12);

        return view('livewire.admin.gallery.video-gallery-manager', [
            'albums' => $albums,
            'videos' => $videos,
        ]);
    }
}
