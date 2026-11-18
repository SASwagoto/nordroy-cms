<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MediaAsset;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    // Search and Filters
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'category')]
    public string $categoryFilter = 'all';

    #[Url(as: 'brand')]
    public string $brandFilter = 'all';

    #[Url(as: 'status')]
    public string $statusFilter = 'all';

    // Form Modal State
    public bool $isFormModalOpen = false;
    public ?int $editingProductId = null;
    public string $activeLocale = 'en';

    // Multi-Language Form Fields (Dynamic array keyed by language code)
    public array $title = [];
    public array $summary = [];
    public array $description = [];

    // Legacy sync variables for backwards compatibility & tests
    public string $title_en = '';
    public string $title_bn = '';
    public string $summary_en = '';
    public string $summary_bn = '';
    public string $description_en = '';
    public string $description_bn = '';

    public string $slug = '';
    public string $part_number = '';
    public ?int $category_id = null;
    public ?int $brand_id = null;
    public string $category = 'Rotor Assemblies';
    public string $brand = 'MAN Energy Solutions';

    // Instant Quick-Add Taxonomy State (On-the-fly inside product form)
    public bool $showQuickCategoryModal = false;
    public string $newCategoryName = '';
    public bool $showQuickBrandModal = false;
    public string $newBrandName = '';

    // Full Taxonomy Management Modal State
    public bool $showManageTaxonomiesModal = false;
    public string $taxonomyActiveTab = 'categories';
    public string $taxonomyNewName = '';
    public string $compatible_models = '';
    public string $condition = 'Genuine New OEM';
    public string $stock_status = 'In Stock (Central Warehouse)';
    public string $lead_time = 'Immediate Port Dispatch (24h)';
    public string $warranty = '12 Months Marine Warranty';
    public array $specs = []; // [['key' => '...', 'value' => '...']]
    public ?int $featured_image_id = null;
    public ?string $featured_image_url = null;
    public ?int $brochure_media_id = null;
    public ?string $brochure_media_url = null;
    public bool $is_active = true;

    // Delete Confirmation State
    public bool $isDeleteModalOpen = false;
    public ?int $productIdToDelete = null;
    public ?string $productNameToDelete = null;

    // Media Library Picker Integration
    public bool $isMediaPickerOpen = false;
    public string $mediaPickerTarget = 'featured_image'; // 'featured_image' or 'brochure'
    public $uploads = [];
    public string $uploadFolder = 'products';
    public bool $autoCompress = true;

    public function getLanguagesProperty()
    {
        $langs = \App\Models\Language::where('is_active', true)->orderBy('order')->get();
        if ($langs->isEmpty()) {
            return collect([
                (object) ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag_icon' => '🇬🇧', 'is_default' => true, 'direction' => 'ltr'],
                (object) ['code' => 'bn', 'name' => 'Bengali', 'native_name' => 'বাংলা', 'flag_icon' => '🇧🇩', 'is_default' => false, 'direction' => 'ltr'],
            ]);
        }
        return $langs;
    }

    public function getActiveLanguageDirectionProperty(): string
    {
        $lang = $this->languages->firstWhere('code', $this->activeLocale);
        return $lang->direction ?? 'ltr';
    }

    public function setLocale(string $locale): void
    {
        $this->activeLocale = $locale;
    }

    protected function rules(): array
    {
        return [
            'slug'              => 'required|string|max:255|unique:products,slug,' . $this->editingProductId,
            'part_number'       => 'nullable|string|max:100',
            'category'          => 'required|string|max:100',
            'brand'             => 'required|string|max:100',
            'compatible_models' => 'nullable|string|max:255',
            'condition'         => 'required|string|max:100',
            'stock_status'      => 'required|string|max:100',
            'lead_time'         => 'nullable|string|max:100',
            'warranty'          => 'nullable|string|max:100',
            'specs'             => 'nullable|array',
            'specs.*.key'       => 'nullable|string|max:100',
            'specs.*.value'     => 'nullable|string|max:255',
            'featured_image_id' => 'nullable|integer|exists:media_assets,id',
            'brochure_media_id' => 'nullable|integer|exists:media_assets,id',
            'is_active'         => 'boolean',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingBrandFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTitleEn(string $value): void
    {
        $this->title['en'] = $value;
        if (!$this->editingProductId || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedTitle($value, $key): void
    {
        if ($key === 'en') {
            $this->title_en = $value;
            if (!$this->editingProductId || empty($this->slug)) {
                $this->slug = Str::slug($value);
            }
        } elseif ($key === 'bn') {
            $this->title_bn = $value;
        }
    }

    public function createProduct()
    {
        return redirect()->route('admin.products.create');
    }

    public function editProduct(int $id)
    {
        return redirect()->route('admin.products.edit', $id);
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

    public function saveProduct(): void
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

        if ($this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update($payload);
            session()->flash('message', "Spare part '{$defaultTitle}' successfully updated.");
        } else {
            Product::create($payload);
            session()->flash('message', "New spare part '{$defaultTitle}' successfully added to catalog.");
        }

        $this->isFormModalOpen = false;
        $this->editingProductId = null;
    }

    public function duplicateProduct(int $id): void
    {
        $source = Product::findOrFail($id);
        $newTitleEn = ($source->display_title ?: 'Spare Part') . ' (Copy)';
        $newSlug = Str::slug($source->slug . '-copy-' . Str::random(4));

        $newPart = $source->replicate();
        $title = $source->title;
        if (is_array($title)) {
            $title['en'] = $newTitleEn;
            $newPart->title = $title;
        } else {
            $newPart->title = ['en' => $newTitleEn, 'bn' => $newTitleEn];
        }
        $newPart->slug = $newSlug;
        if ($newPart->part_number) {
            $newPart->part_number = $newPart->part_number . '-CPY';
        }
        $newPart->save();

        session()->flash('message', "Spare part successfully duplicated as '{$newTitleEn}'.");
    }

    public function toggleStatus(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        session()->flash('message', "Status for '{$product->display_title}' updated.");
    }

    public function confirmDelete(int $id): void
    {
        $product = Product::findOrFail($id);
        $this->productIdToDelete = $product->id;
        $this->productNameToDelete = $product->display_title;
        $this->isDeleteModalOpen = true;
    }

    public function deleteProduct(): void
    {
        if ($this->productIdToDelete) {
            $product = Product::findOrFail($this->productIdToDelete);
            $name = $product->display_title;
            $product->delete();
            session()->flash('message', "Spare part '{$name}' was deleted.");
        }

        $this->isDeleteModalOpen = false;
        $this->productIdToDelete = null;
        $this->productNameToDelete = null;
    }

    // Media Modal Methods
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
        session()->flash('taxonomy_quick_success', "Brand '{$brand->name}' created and selected!");
    }

    // ==================== FULL TAXONOMY MANAGEMENT METHODS ====================

    public function openManageTaxonomiesModal(string $tab = 'categories'): void
    {
        $this->taxonomyActiveTab = $tab;
        $this->taxonomyNewName = '';
        $this->showManageTaxonomiesModal = true;
    }

    public function closeManageTaxonomiesModal(): void
    {
        $this->showManageTaxonomiesModal = false;
        $this->taxonomyNewName = '';
        $this->resetValidation(['taxonomyNewName']);
    }

    public function addTaxonomyItem(): void
    {
        $name = trim($this->taxonomyNewName);
        if (empty($name)) {
            $this->addError('taxonomyNewName', 'Item name is required.');
            return;
        }

        $slug = Str::slug($name) ?: 'item-' . time();

        if ($this->taxonomyActiveTab === 'categories') {
            Category::firstOrCreate(
                ['name' => $name],
                [
                    'slug'      => $slug,
                    'order'     => (int) (Category::max('order') ?? 0) + 1,
                    'is_active' => true,
                ]
            );
        } else {
            Brand::firstOrCreate(
                ['name' => $name],
                [
                    'slug'      => $slug,
                    'order'     => (int) (Brand::max('order') ?? 0) + 1,
                    'is_active' => true,
                ]
            );
        }

        $this->taxonomyNewName = '';
        session()->flash('taxonomy_manager_success', ucfirst($this->taxonomyActiveTab) . " updated successfully.");
    }

    public function deleteCategory(int $id): void
    {
        $cat = Category::find($id);
        if ($cat) {
            $name = $cat->name;
            $cat->delete();
            session()->flash('taxonomy_manager_success', "Category '{$name}' deleted.");
        }
    }

    public function deleteBrand(int $id): void
    {
        $brand = Brand::find($id);
        if ($brand) {
            $name = $brand->name;
            $brand->delete();
            session()->flash('taxonomy_manager_success', "Brand '{$name}' deleted.");
        }
    }

    public function render()
    {
        $query = Product::query()->with(['featuredImage', 'brochure']);

        // Search Filter
        if (!empty(trim($this->search))) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('part_number', 'like', $term)
                  ->orWhere('slug', 'like', $term)
                  ->orWhere('technical_specifications', 'like', $term);
            });
        }

        // Category Filter
        if ($this->categoryFilter !== 'all') {
            $query->where('technical_specifications', 'like', '%"category":"' . $this->categoryFilter . '"%');
        }

        // Brand Filter
        if ($this->brandFilter !== 'all') {
            $query->where('technical_specifications', 'like', '%"brand":"' . $this->brandFilter . '"%');
        }

        // Status Filter
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);

        // Pre-computed Stats
        $totalCount = Product::count();
        $activeCount = Product::where('is_active', true)->count();
        $inStockCount = Product::where('technical_specifications', 'like', '%In Stock%')->count();

        // Dynamic categories and brands queried from Database
        $categoriesList = Category::active()->pluck('name')->toArray();
        if (empty($categoriesList)) {
            $categoriesList = [
                'Rotor Assemblies',
                'Cartridges (CHRA)',
                'Nozzle Rings & Shrouds',
                'Bearings & Seals',
                'Turbine Blading',
                'Compressor Impellers',
                'Casing & Liners',
            ];
        }

        $brandsList = Brand::active()->pluck('name')->toArray();
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

        $allCategories = Category::orderBy('order')->orderBy('name')->get();
        $allBrands = Brand::orderBy('order')->orderBy('name')->get();

        return view('livewire.admin.products.product-manager', [
            'products'        => $products,
            'totalCount'      => $totalCount,
            'activeCount'     => $activeCount,
            'inStockCount'    => $inStockCount,
            'categoriesList'  => $categoriesList,
            'brandsList'      => $brandsList,
            'allCategories'   => $allCategories,
            'allBrands'       => $allBrands,
            'mediaAssets'     => MediaAsset::latest()->take(24)->get(),
        ]);
    }
}
