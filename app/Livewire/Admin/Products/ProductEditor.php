<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Spare Part Editor | Corporate CMS')]
class ProductEditor extends Component
{
    public ?int $productId = null;
    public bool $isEditing = false;

    // Configured Languages
    public $languages = [];
    public string $activeLocale = 'en';

    // Localized fields
    public array $title = [];
    public array $summary = [];
    public array $description = [];

    // Direct two-way binding fallbacks
    public string $title_en = '';
    public string $title_bn = '';
    public string $summary_en = '';
    public string $summary_bn = '';
    public string $description_en = '';
    public string $description_bn = '';

    // Core Part Identifiers
    public string $slug = '';
    public string $part_number = '';
    public ?int $category_id = null;
    public ?int $brand_id = null;
    public string $category = 'Rotor Assemblies';
    public string $brand = 'MAN Energy Solutions';

    // Technical Specifications
    public string $compatible_models = '';
    public string $condition = 'Genuine New OEM';
    public string $stock_status = 'In Stock (Central Warehouse)';
    public string $lead_time = 'Immediate Port Dispatch (24h)';
    public string $warranty = '12 Months Marine Warranty';
    public array $specs = []; // [['key' => '...', 'value' => '...']]

    // Media Assets
    public ?int $featured_image_id = null;
    public ?string $featured_image_url = null;
    public ?int $brochure_media_id = null;
    public ?string $brochure_media_url = null;
    public bool $is_active = true;

    // Instant Quick-Add Taxonomy State
    public bool $showQuickCategoryModal = false;
    public string $newCategoryName = '';
    public bool $showQuickBrandModal = false;
    public string $newBrandName = '';

    // Media Library Picker Modal
    public bool $isMediaPickerOpen = false;
    public string $mediaPickerTarget = 'featured_image';

    protected function rules(): array
    {
        return [
            'slug'        => 'required|string|max:255',
            'part_number' => 'nullable|string|max:100',
            'category'    => 'required|string|max:150',
            'brand'       => 'required|string|max:150',
            'specs'       => 'nullable|array',
        ];
    }

    public function mount(?int $id = null): void
    {
        $this->languages = Language::active()->orderBy('order')->get();
        if ($this->languages->isEmpty()) {
            $this->languages = collect([
                (object) ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag_icon' => '🇬🇧'],
                (object) ['code' => 'bn', 'name' => 'Bengali', 'native_name' => 'বাংলা', 'flag_icon' => '🇧🇩'],
            ]);
        }

        if ($id) {
            $this->productId = $id;
            $this->isEditing = true;
            $this->loadProduct($id);
        } else {
            $this->specs = [
                ['key' => 'Max Speed', 'value' => '45,000 RPM'],
                ['key' => 'Balancing Quality', 'value' => 'ISO 1940-1 Grade G1.0'],
            ];

            foreach ($this->languages as $lang) {
                $this->title[$lang->code] = '';
                $this->summary[$lang->code] = '';
                $this->description[$lang->code] = '';
            }
        }
    }

    public function loadProduct(int $id): void
    {
        $product = Product::with(['featuredImage', 'brochure', 'category', 'brand'])->findOrFail($id);

        $this->slug = $product->slug;
        $this->part_number = $product->part_number ?? '';
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->category = $product->category;
        $this->brand = $product->brand;
        $this->is_active = (bool) $product->is_active;

        $specsJson = $product->technical_specifications ?? [];
        $this->compatible_models = $specsJson['compatible_models'] ?? '';
        $this->condition = $specsJson['condition'] ?? 'Genuine New OEM';
        $this->stock_status = $specsJson['stock_status'] ?? 'In Stock (Central Warehouse)';
        $this->lead_time = $specsJson['lead_time'] ?? 'Immediate Port Dispatch (24h)';
        $this->warranty = $specsJson['warranty'] ?? '12 Months Marine Warranty';

        $this->specs = $specsJson['specs'] ?? [];
        if (empty($this->specs)) {
            $this->specs = [
                ['key' => 'Max Speed', 'value' => '45,000 RPM'],
                ['key' => 'Balancing Quality', 'value' => 'ISO 1940-1 Grade G1.0'],
            ];
        }

        foreach ($this->languages as $lang) {
            $code = $lang->code;
            $tVal = $product->getTranslation('title', $code);
            $this->title[$code] = is_string($tVal) ? $tVal : ($tVal[$code] ?? '');

            $sVal = $specsJson['summary'] ?? ($specsJson['short_description'] ?? '');
            $this->summary[$code] = is_array($sVal) ? ($sVal[$code] ?? '') : (string) $sVal;

            $dVal = $specsJson['description'] ?? '';
            $this->description[$code] = is_array($dVal) ? ($dVal[$code] ?? '') : (string) $dVal;
        }

        $this->title_en = $this->title['en'] ?? '';
        $this->title_bn = $this->title['bn'] ?? '';
        $this->summary_en = $this->summary['en'] ?? '';
        $this->summary_bn = $this->summary['bn'] ?? '';
        $this->description_en = $this->description['en'] ?? '';
        $this->description_bn = $this->description['bn'] ?? '';

        $this->featured_image_id = $product->featured_image_id;
        $this->featured_image_url = $product->featuredImage?->url;
        $this->brochure_media_id = $product->brochure_media_id;
        $this->brochure_media_url = $product->brochure?->url;
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

    public function setLocale(string $locale): void
    {
        $this->activeLocale = $locale;
    }

    public function addSpecItem(): void
    {
        $this->specs[] = ['key' => '', 'value' => ''];
    }

    public function removeSpecItem(int $index): void
    {
        unset($this->specs[$index]);
        $this->specs = array_values($this->specs);
    }

    // ==================== INSTANT QUICK-ADD TAXONOMY METHODS ====================

    public function openQuickCategoryModal(): void
    {
        $this->resetValidation(['newCategoryName']);
        $this->newCategoryName = '';
        $this->showQuickCategoryModal = true;
    }

    public function closeQuickCategoryModal(): void
    {
        $this->showQuickCategoryModal = false;
        $this->newCategoryName = '';
        $this->resetValidation(['newCategoryName']);
    }

    public function saveQuickCategory(): void
    {
        $name = trim($this->newCategoryName);
        if (empty($name)) {
            $this->addError('newCategoryName', 'Please enter a valid category name.');
            return;
        }

        $slug = Str::slug($name) ?: 'cat-' . time();

        $cat = Category::firstOrCreate(
            ['name' => $name],
            [
                'slug'      => $slug,
                'order'     => (int) (Category::max('order') ?? 0) + 1,
                'is_active' => true,
            ]
        );

        $this->category = $cat->name;
        $this->category_id = $cat->id;
        $this->showQuickCategoryModal = false;
        $this->newCategoryName = '';
        session()->flash('taxonomy_quick_success', "Category '{$cat->name}' created and selected!");
    }

    public function openQuickBrandModal(): void
    {
        $this->resetValidation(['newBrandName']);
        $this->newBrandName = '';
        $this->showQuickBrandModal = true;
    }

    public function closeQuickBrandModal(): void
    {
        $this->showQuickBrandModal = false;
        $this->newBrandName = '';
        $this->resetValidation(['newBrandName']);
    }

    public function saveQuickBrand(): void
    {
        $name = trim($this->newBrandName);
        if (empty($name)) {
            $this->addError('newBrandName', 'Please enter a valid manufacturer/brand name.');
            return;
        }

        $slug = Str::slug($name) ?: 'brand-' . time();

        $brand = Brand::firstOrCreate(
            ['name' => $name],
            [
                'slug'      => $slug,
                'order'     => (int) (Brand::max('order') ?? 0) + 1,
                'is_active' => true,
            ]
        );

        $this->brand = $brand->name;
        $this->brand_id = $brand->id;
        $this->showQuickBrandModal = false;
        $this->newBrandName = '';
        session()->flash('taxonomy_quick_success', "Manufacturer '{$brand->name}' created and selected!");
    }

    // ==================== MEDIA PICKER METHODS ====================

    public function openMediaPicker(string $target = 'featured_image'): void
    {
        $this->mediaPickerTarget = $target;
        $this->isMediaPickerOpen = true;
    }

    public function selectAsset(int $id, string $url): void
    {
        if ($this->mediaPickerTarget === 'featured_image') {
            $this->featured_image_id = $id;
            $this->featured_image_url = $url;
        } else {
            $this->brochure_media_id = $id;
            $this->brochure_media_url = $url;
        }
        $this->isMediaPickerOpen = false;
    }

    public function removeAsset(string $target): void
    {
        if ($target === 'featured_image') {
            $this->featured_image_id = null;
            $this->featured_image_url = null;
        } else {
            $this->brochure_media_id = null;
            $this->brochure_media_url = null;
        }
    }

    // ==================== SAVE METHOD ====================

    public function saveProduct()
    {
        if (!empty($this->title_en) && empty($this->title['en'])) {
            $this->title['en'] = $this->title_en;
        }
        if (!empty($this->title['en'])) {
            $this->title_en = $this->title['en'];
        }

        $defaultTitle = $this->title['en'] ?? reset($this->title) ?? '';
        if (empty(trim($defaultTitle))) {
            $this->addError('title.en', 'The primary product title in English is required.');
            $this->activeLocale = 'en';
            return;
        }

        $this->validate();

        $filteredSpecs = array_values(array_filter($this->specs, function ($item) {
            return !empty(trim($item['key'] ?? '')) || !empty(trim($item['value'] ?? ''));
        }));

        $titlePayload = [];
        $summaryPayload = [];
        $descPayload = [];
        foreach ($this->languages as $lang) {
            $tVal = trim($this->title[$lang->code] ?? '');
            $titlePayload[$lang->code] = !empty($tVal) ? $tVal : $defaultTitle;

            $sVal = trim($this->summary[$lang->code] ?? '');
            $summaryPayload[$lang->code] = !empty($sVal) ? $sVal : ($this->summary['en'] ?? '');

            $dVal = trim($this->description[$lang->code] ?? '');
            $descPayload[$lang->code] = !empty($dVal) ? $dVal : ($this->description['en'] ?? '');
        }

        $techSpecsPayload = [
            'category'          => $this->category,
            'brand'             => $this->brand,
            'compatible_models' => $this->compatible_models,
            'condition'         => $this->condition,
            'stock_status'      => $this->stock_status,
            'lead_time'         => $this->lead_time,
            'warranty'          => $this->warranty,
            'summary'           => $summaryPayload,
            'description'       => $descPayload,
            'specs'             => $filteredSpecs,
        ];

        if (!empty($this->category)) {
            $catRecord = Category::firstOrCreate(
                ['name' => trim($this->category)],
                [
                    'slug'      => Str::slug($this->category) ?: 'category-' . time(),
                    'order'     => (int) (Category::max('order') ?? 0) + 1,
                    'is_active' => true,
                ]
            );
            $this->category_id = $catRecord->id;
        }

        if (!empty($this->brand)) {
            $brandRecord = Brand::firstOrCreate(
                ['name' => trim($this->brand)],
                [
                    'slug'      => Str::slug($this->brand) ?: 'brand-' . time(),
                    'order'     => (int) (Brand::max('order') ?? 0) + 1,
                    'is_active' => true,
                ]
            );
            $this->brand_id = $brandRecord->id;
        }

        $payload = [
            'title'                    => $titlePayload,
            'slug'                     => Str::slug($this->slug),
            'part_number'              => trim($this->part_number),
            'technical_specifications' => $techSpecsPayload,
            'category_id'              => $this->category_id,
            'brand_id'                 => $this->brand_id,
            'featured_image_id'        => $this->featured_image_id,
            'brochure_media_id'        => $this->brochure_media_id,
            'is_active'                => $this->is_active,
        ];

        if ($this->isEditing && $this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update($payload);
            session()->flash('message', "Spare part '{$defaultTitle}' successfully updated.");
        } else {
            Product::create($payload);
            session()->flash('message', "New spare part '{$defaultTitle}' successfully added to catalog.");
        }

        return redirect()->route('admin.products');
    }

    public function render()
    {
        $categoriesList = Category::active()->orderBy('name')->pluck('name')->toArray();
        if (empty($categoriesList)) {
            $categoriesList = [
                'Rotor Assemblies',
                'Cartridges (CHRA)',
                'Nozzle Rings & Shrouds',
                'Bearings & Seals',
                'Turbine Blading',
                'Compressor Impellers',
            ];
        }

        $brandsList = Brand::active()->orderBy('name')->pluck('name')->toArray();
        if (empty($brandsList)) {
            $brandsList = [
                'MAN Energy Solutions',
                'ABB / Accelleron',
                'Mitsubishi Heavy Industries (MHI)',
                'Napier Turbochargers',
                'KBB Turbochargers',
                'Garrett / Honeywell',
            ];
        }

        return view('livewire.admin.products.product-editor', [
            'categoriesList' => $categoriesList,
            'brandsList'     => $brandsList,
            'mediaAssets'    => MediaAsset::latest()->take(36)->get(),
        ]);
    }
}
