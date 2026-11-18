<?php

namespace App\Livewire\Admin\Services;

use App\Models\CustomIcon;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\Service;
use App\Services\IconRegistry;
use App\Services\MediaStorageService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Service Editor | Corporate CMS')]
class ServiceEditor extends Component
{
    use WithFileUploads;

    public ?int $serviceId = null;
    public bool $isEditing = false;

    // Configured Languages
    public $languages = [];
    public string $activeLocale = 'en';

    // Localized fields
    public array $title = [];
    public array $short_summary = [];
    public array $content = [];

    // Direct two-way binding fallbacks
    public string $title_en = '';
    public string $title_bn = '';
    public string $short_summary_en = '';
    public string $short_summary_bn = '';
    public string $content_en = '';
    public string $content_bn = '';

    // Core Properties
    public string $slug = '';
    public string $icon = 'solid:wrench';
    public ?int $featured_image_id = null;
    public ?string $featured_image_url = null;
    public ?string $video_url = '';
    public int $order = 0;
    public bool $is_featured = false;
    public bool $is_active = true;

    // Icon Picker Modal State
    public ?string $modalTargetField = 'icon';
    public ?int $modalTargetIndex = null;
    public string $modalCustomIconTitle = '';
    public $modalUploadedFile = null;
    public string $modalRawSvgCode = '';

    // Media Modal File Upload State (Enables in-modal upload like Settings)
    public $uploads = [];
    public string $uploadFolder = 'services';
    public bool $autoCompress = true;

    protected function rules(): array
    {
        $slugRule = 'required|string|max:255|unique:services,slug' . ($this->serviceId ? (',' . $this->serviceId) : '');

        return [
            'slug'              => $slugRule,
            'icon'              => 'nullable|string|max:100',
            'video_url'         => 'nullable|string|max:500',
            'order'             => 'required|integer|min:0',
            'featured_image_id' => 'nullable|exists:media_assets,id',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
        ];
    }

    public function mount(?int $id = null): void
    {
        $this->languages = Language::active()->orderBy('order')->get();
        if ($this->languages->isEmpty()) {
            $this->languages = collect([
                (object) ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag_icon' => '🇬🇧', 'is_default' => true, 'direction' => 'ltr'],
                (object) ['code' => 'bn', 'name' => 'Bengali', 'native_name' => 'বাংলা', 'flag_icon' => '🇧🇩', 'is_default' => false, 'direction' => 'ltr'],
            ]);
        }

        foreach ($this->languages as $lang) {
            $this->title[$lang->code] = '';
            $this->short_summary[$lang->code] = '';
            $this->content[$lang->code] = '';
        }

        if ($id) {
            $this->serviceId = $id;
            $this->isEditing = true;
            $this->loadService($id);
        } else {
            $this->isEditing = false;
            $maxOrder = (int) Service::max('order');
            $this->order = $maxOrder + 1;
        }
    }

    public function loadService(int $id): void
    {
        $service = Service::with('featuredImage')->findOrFail($id);

        $this->slug = $service->slug;
        $this->icon = $service->icon ?: 'solid:wrench';
        $this->order = (int) $service->order;
        $this->is_featured = (bool) $service->is_featured;
        $this->is_active = (bool) $service->is_active;
        $this->video_url = $service->video_url ?? '';

        $rawTitle = $service->title ?? [];
        $rawTitle = is_array($rawTitle) ? $rawTitle : (json_decode($rawTitle, true) ?? ['en' => (string) $rawTitle]);

        $rawSummary = $service->short_summary ?? [];
        $rawSummary = is_array($rawSummary) ? $rawSummary : (json_decode($rawSummary, true) ?? ['en' => (string) $rawSummary]);

        $rawContent = $service->content ?? [];
        $rawContent = is_array($rawContent) ? $rawContent : (json_decode($rawContent, true) ?? ['en' => (string) $rawContent]);

        foreach ($this->languages as $lang) {
            $code = $lang->code;
            $this->title[$code] = $rawTitle[$code] ?? ($code === 'en' ? (reset($rawTitle) ?: '') : '');
            $this->short_summary[$code] = $rawSummary[$code] ?? ($code === 'en' ? (reset($rawSummary) ?: '') : '');
            $this->content[$code] = $rawContent[$code] ?? ($code === 'en' ? (reset($rawContent) ?: '') : '');
        }

        $this->title_en = $this->title['en'] ?? '';
        $this->title_bn = $this->title['bn'] ?? '';
        $this->short_summary_en = $this->short_summary['en'] ?? '';
        $this->short_summary_bn = $this->short_summary['bn'] ?? '';
        $this->content_en = $this->content['en'] ?? '';
        $this->content_bn = $this->content['bn'] ?? '';

        $this->featured_image_id = $service->featured_image_id;
        $this->featured_image_url = $service->featuredImage?->url;
    }

    public function updatedTitleEn(string $value): void
    {
        $this->title['en'] = $value;
        if (!$this->isEditing && empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedTitle(string $value, string $key): void
    {
        if ($key === 'en') {
            $this->title_en = $value;
            if (!$this->isEditing && empty($this->slug)) {
                $this->slug = Str::slug($value);
            }
        }
    }

    public function getYoutubeIdProperty(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, trim($this->video_url), $match)) {
            return $match[1];
        }
        return null;
    }

    public function setLocale(string $locale): void
    {
        $this->activeLocale = $locale;
    }

    // =========================================================================
    // ICON PICKER INTEGRATION
    // =========================================================================
    public function selectIconAsset(?string $targetField, ?int $targetIndex, string $iconId, ?string $targetTypeField = null): void
    {
        $this->icon = $iconId;
    }

    public function uploadCustomIcon(?string $targetField = null, ?int $targetIndex = null, ?string $targetTypeField = null, ?string $customTitle = null): void
    {
        $this->validate([
            'modalUploadedFile'    => 'required|file|max:5120',
            'modalCustomIconTitle' => 'nullable|string|max:50',
        ], [
            'modalUploadedFile.required' => 'Please select an image or vector icon file first.',
            'modalUploadedFile.file'     => 'The selected file is not a valid upload.',
            'modalUploadedFile.max'      => 'The icon file size must not exceed 5MB.',
        ]);

        $ext = strtolower($this->modalUploadedFile->getClientOriginalExtension());
        if (!in_array($ext, ['svg', 'png', 'webp', 'jpg', 'jpeg', 'ico', 'gif'])) {
            $this->addError('modalUploadedFile', 'Supported formats: SVG, PNG, WebP, JPG, ICO, GIF.');
            return;
        }

        $dir = storage_path('app/public/custom-icons');
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $count = CustomIcon::count();
        $passedTitle = !empty(trim($customTitle ?? '')) ? trim($customTitle) : trim($this->modalCustomIconTitle ?? '');

        if (!empty($passedTitle)) {
            $readableTitle = $passedTitle;
            $baseName = Str::slug($readableTitle);
        } else {
            $original = Str::slug(pathinfo($this->modalUploadedFile->getClientOriginalName(), PATHINFO_FILENAME));
            $baseName = !empty($original) ? $original : 'icon_' . ($count + 1);
            $readableTitle = ucwords(str_replace(['-', '_'], ' ', $baseName));
        }

        $cleanFileName = "{$baseName}.{$ext}";
        $counter = 1;
        while (File::exists($dir . DIRECTORY_SEPARATOR . $cleanFileName)) {
            $cleanFileName = "{$baseName}_{$counter}.{$ext}";
            $counter++;
        }

        $this->modalUploadedFile->storeAs('custom-icons', $cleanFileName, 'public');
        $storedPath = 'storage/custom-icons/' . $cleanFileName;

        $rawSvg = null;
        $isSvg = ($ext === 'svg');
        if ($isSvg) {
            $fullPath = storage_path('app/public/custom-icons/' . $cleanFileName);
            if (File::exists($fullPath)) {
                $rawSvg = File::get($fullPath);
            }
        }

        $icon = CustomIcon::create([
            'title'     => $readableTitle,
            'file_name' => $cleanFileName,
            'file_path' => $storedPath,
            'raw_svg'   => $rawSvg,
            'format'    => $ext,
        ]);

        $this->icon = (string) $icon->id;

        $this->modalUploadedFile = null;
        $this->modalCustomIconTitle = '';

        $this->dispatch(
            'custom-icon-saved',
            iconId: (string) $icon->id,
            iconTitle: $readableTitle,
            iconPath: $storedPath,
            rawSvg: $isSvg && $rawSvg ? IconRegistry::cleanSvgMarkup($rawSvg, 'w-6 h-6') : null
        );

        IconRegistry::flushCache($icon->id);
        session()->flash('message', "Custom Icon '{$readableTitle}' saved and selected!");
    }

    public function saveRawSvgIcon(?string $targetField = null, ?int $targetIndex = null, ?string $targetTypeField = null, ?string $customTitle = null, ?string $svgMarkup = null): void
    {
        $rawSvg = !empty(trim($svgMarkup ?? '')) ? trim($svgMarkup) : trim($this->modalRawSvgCode ?? '');

        if (empty($rawSvg)) {
            $this->addError('modalRawSvgCode', 'Please paste valid SVG markup code.');
            return;
        }

        if (!str_contains($rawSvg, '<svg')) {
            $this->addError('modalRawSvgCode', 'Invalid SVG: Missing <svg> root element.');
            return;
        }

        $count = CustomIcon::count();
        $passedTitle = !empty(trim($customTitle ?? '')) ? trim($customTitle) : trim($this->modalCustomIconTitle ?? '');
        $readableTitle = !empty($passedTitle) ? $passedTitle : 'Vector Icon ' . ($count + 1);

        $icon = CustomIcon::create([
            'title'     => $readableTitle,
            'file_name' => Str::slug($readableTitle) . '.svg',
            'file_path' => 'raw_svg:' . Str::random(12),
            'raw_svg'   => $rawSvg,
            'format'    => 'svg',
        ]);

        $this->icon = (string) $icon->id;
        $this->modalRawSvgCode = '';
        $this->modalCustomIconTitle = '';

        $this->dispatch(
            'custom-icon-saved',
            iconId: (string) $icon->id,
            iconTitle: $readableTitle,
            iconPath: "raw_svg:{$icon->id}",
            rawSvg: IconRegistry::cleanSvgMarkup($rawSvg, 'w-6 h-6')
        );

        IconRegistry::flushCache($icon->id);
        session()->flash('message', "Raw Vector '{$readableTitle}' saved and applied!");
    }

    public function deleteCustomIcon(int $id): void
    {
        $icon = CustomIcon::find($id);
        if ($icon) {
            $path = $icon->file_path;
            if ($path && !str_starts_with($path, 'raw_svg:') && !str_starts_with($path, 'http')) {
                $clean = str_replace('storage/', '', $path);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($clean);
            }
            $icon->delete();
            IconRegistry::flushCache($id);
            $this->dispatch('custom-icon-deleted', iconId: $id, iconPath: "raw_svg:{$id}");
            session()->flash('message', 'Custom icon deleted from library.');
        }
    }

    // =========================================================================
    // MEDIA ASSET PICKER & IN-MODAL UPLOADS
    // =========================================================================
    #[On('asset-selected')]
    public function onAssetSelected(array $payload): void
    {
        $targetField = $payload['targetField'] ?? 'featured_image';
        $assetId = (int) ($payload['assetId'] ?? 0);
        $assetUrl = $payload['assetUrl'] ?? '';

        if ($targetField === 'featured_image' && $assetId > 0) {
            $this->featured_image_id = $assetId;
            $this->featured_image_url = $assetUrl;
        }
    }

    public function selectAsset(int $assetId, string $assetUrl, ?string $targetField = null, ?int $targetIndex = null): void
    {
        $this->featured_image_id = $assetId;
        $this->featured_image_url = $assetUrl;
        $this->dispatch('close-media-modal');
    }

    public function removeAsset(string $target = 'featured_image'): void
    {
        if ($target === 'featured_image') {
            $this->featured_image_id = null;
            $this->featured_image_url = null;
        }
    }

    public function uploadFiles(?string $targetField = null, ?int $targetIndex = null): void
    {
        if (empty($this->uploads) || !is_array($this->uploads)) {
            $this->addError('uploads', 'Please select at least one file to upload.');
            return;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf', 'gif', 'ico'];
        $service = app(MediaStorageService::class);
        $lastAsset = null;
        $successCount = 0;

        foreach ($this->uploads as $file) {
            if ($file) {
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, $allowedExtensions)) {
                    continue;
                }

                $folder = $this->uploadFolder ?: 'services';
                $lastAsset = $service->store($file, $folder, null, $this->autoCompress);
                $successCount++;

                $this->dispatch('media-asset-uploaded', [
                    'id'       => $lastAsset->id,
                    'name'     => $lastAsset->getTranslation('title', 'en') ?: $lastAsset->file_name,
                    'url'      => $lastAsset->url,
                    'is_image' => in_array(strtolower(pathinfo($lastAsset->file_name, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','svg','gif','ico']),
                    'size'     => $lastAsset->human_size,
                    'folder'   => $lastAsset->folder,
                ]);
            }
        }

        $this->uploads = [];

        if ($successCount > 0 && $lastAsset) {
            $this->selectAsset($lastAsset->id, $lastAsset->url, 'featured_image');
            session()->flash('message', "{$successCount} asset(s) successfully uploaded and attached.");
            $this->dispatch('close-media-modal');
        }
    }

    public function processUploads(?string $targetField = null, ?int $targetIndex = null): void
    {
        $this->uploadFiles($targetField, $targetIndex);
    }

    // =========================================================================
    // SAVE SERVICE ACTION
    // =========================================================================
    public function save()
    {
        if (!empty($this->title_en) && empty($this->title['en'])) {
            $this->title['en'] = $this->title_en;
        }
        if (!empty($this->title['en'])) {
            $this->title_en = $this->title['en'];
        }

        $defaultTitle = $this->title['en'] ?? reset($this->title) ?? '';
        if (empty(trim($defaultTitle))) {
            $this->addError('title_en', 'The primary service title in English is required.');
            $this->activeLocale = 'en';
            return;
        }

        $this->validate();

        $titleData = [];
        $summaryData = [];
        $contentData = [];
        foreach ($this->languages as $lang) {
            $t = trim($this->title[$lang->code] ?? '');
            $titleData[$lang->code] = !empty($t) ? $t : $defaultTitle;

            $s = trim($this->short_summary[$lang->code] ?? '');
            $summaryData[$lang->code] = !empty($s) ? $s : ($this->short_summary['en'] ?? '');

            $c = trim($this->content[$lang->code] ?? '');
            $contentData[$lang->code] = !empty($c) ? $c : ($this->content['en'] ?? '');
        }

        $payload = [
            'title'             => $titleData,
            'slug'              => Str::slug($this->slug),
            'icon'              => $this->icon ?: 'solid:wrench',
            'short_summary'     => $summaryData,
            'content'           => $contentData,
            'featured_image_id' => $this->featured_image_id,
            'video_url'         => trim($this->video_url) ?: null,
            'order'             => (int) $this->order,
            'is_featured'       => (bool) $this->is_featured,
            'is_active'         => (bool) $this->is_active,
        ];

        if ($this->isEditing && $this->serviceId) {
            $service = Service::findOrFail($this->serviceId);
            $service->update($payload);
            session()->flash('message', "Service '{$defaultTitle}' successfully updated.");
        } else {
            Service::create($payload);
            session()->flash('message', "New service '{$defaultTitle}' successfully created.");
        }

        return redirect()->route('admin.services');
    }

    public function render()
    {
        return view('livewire.admin.services.service-editor');
    }
}
