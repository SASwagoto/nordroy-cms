<?php

namespace App\Livewire\Admin\Products;

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

    // Form Fields
    public string $title_en = '';
    public string $title_bn = '';
    public string $slug = '';
    public string $part_number = '';
    public string $category = 'Rotor Assemblies';
    public string $brand = 'MAN Energy Solutions';
    public string $compatible_models = '';
    public string $condition = 'Genuine New OEM';
    public string $stock_status = 'In Stock (Central Warehouse)';
    public string $lead_time = 'Immediate Port Dispatch (24h)';
    public string $warranty = '12 Months Marine Warranty';
    public string $summary_en = '';
    public string $summary_bn = '';
    public string $description_en = '';
    public string $description_bn = '';
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

    protected function rules(): array
    {
        return [
            'title_en'          => 'required|string|max:255',
            'title_bn'          => 'nullable|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug,' . $this->editingProductId,
            'part_number'       => 'nullable|string|max:100',
            'category'          => 'required|string|max:100',
            'brand'             => 'required|string|max:100',
            'compatible_models' => 'nullable|string|max:255',
            'condition'         => 'required|string|max:100',
            'stock_status'      => 'required|string|max:100',
            'lead_time'         => 'nullable|string|max:100',
            'warranty'          => 'nullable|string|max:100',
            'summary_en'        => 'nullable|string|max:1000',
            'summary_bn'        => 'nullable|string|max:1000',
            'description_en'    => 'nullable|string',
            'description_bn'    => 'nullable|string',
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
        if (!$this->editingProductId || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function createProduct(): void
    {
        $this->resetValidation();
        $this->editingProductId = null;

        $this->title_en = '';
        $this->title_bn = '';
        $this->slug = '';
        $this->part_number = '';
        $this->category = 'Rotor Assemblies';
        $this->brand = 'MAN Energy Solutions';
        $this->compatible_models = '';
        $this->condition = 'Genuine New OEM';
        $this->stock_status = 'In Stock (Central Warehouse)';
        $this->lead_time = 'Immediate Port Dispatch (24h)';
        $this->warranty = '12 Months Marine Warranty';
        $this->summary_en = '';
        $this->summary_bn = '';
        $this->description_en = '';
        $this->description_bn = '';
        $this->specs = [
            ['key' => 'Max Speed', 'value' => '45,000 RPM'],
            ['key' => 'Balancing Quality', 'value' => 'ISO 1940-1 Grade G1.0'],
            ['key' => 'Metallurgy', 'value' => 'Inconel 713C / Titanium'],
            ['key' => 'Class Approvals', 'value' => 'DNV, Lloyd\'s Register, ABS'],
        ];
        $this->featured_image_id = null;
        $this->featured_image_url = null;
        $this->brochure_media_id = null;
        $this->brochure_media_url = null;
        $this->is_active = true;

        $this->isFormModalOpen = true;
    }

    public function editProduct(int $id): void
    {
        $this->resetValidation();
        $product = Product::with(['featuredImage', 'brochure'])->findOrFail($id);
        $this->editingProductId = $product->id;

        $title = $product->title ?? [];
        $this->title_en = is_array($title) ? ($title['en'] ?? reset($title) ?? '') : (string) $title;
        $this->title_bn = is_array($title) ? ($title['bn'] ?? '') : '';
        $this->slug = $product->slug;
        $this->part_number = $product->part_number ?? '';

        $specsJson = $product->technical_specifications ?? [];
        $this->category = $specsJson['category'] ?? 'Rotor Assemblies';
        $this->brand = $specsJson['brand'] ?? 'MAN Energy Solutions';
        $this->compatible_models = $specsJson['compatible_models'] ?? '';
        $this->condition = $specsJson['condition'] ?? 'Genuine New OEM';
        $this->stock_status = $specsJson['stock_status'] ?? 'In Stock';
        $this->lead_time = $specsJson['lead_time'] ?? '24-48 Hours';
        $this->warranty = $specsJson['warranty'] ?? '12 Months';

        $summary = $specsJson['summary'] ?? ($specsJson['short_description'] ?? '');
        $this->summary_en = is_array($summary) ? ($summary['en'] ?? reset($summary) ?? '') : (string) $summary;
        $this->summary_bn = is_array($summary) ? ($summary['bn'] ?? '') : '';

        $desc = $specsJson['description'] ?? '';
        $this->description_en = is_array($desc) ? ($desc['en'] ?? reset($desc) ?? '') : (string) $desc;
        $this->description_bn = is_array($desc) ? ($desc['bn'] ?? '') : '';

        $this->specs = $specsJson['specs'] ?? [];
        if (empty($this->specs)) {
            $this->specs = [
                ['key' => 'Max Speed', 'value' => '45,000 RPM'],
                ['key' => 'Balancing Quality', 'value' => 'ISO 1940-1 Grade G1.0'],
            ];
        }

        $this->featured_image_id = $product->featured_image_id;
        $this->featured_image_url = $product->featuredImage?->url;
        $this->brochure_media_id = $product->brochure_media_id;
        $this->brochure_media_url = $product->brochure?->url;
        $this->is_active = (bool) $product->is_active;

        $this->isFormModalOpen = true;
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
        $this->validate();

        $filteredSpecs = array_values(array_filter($this->specs, function ($item) {
            return !empty(trim($item['key'] ?? '')) || !empty(trim($item['value'] ?? ''));
        }));

        $techSpecsPayload = [
            'category'          => $this->category,
            'brand'             => $this->brand,
            'compatible_models' => $this->compatible_models,
            'condition'         => $this->condition,
            'stock_status'      => $this->stock_status,
            'lead_time'         => $this->lead_time,
            'warranty'          => $this->warranty,
            'summary'           => [
                'en' => $this->summary_en,
                'bn' => $this->summary_bn,
            ],
            'description'       => [
                'en' => $this->description_en,
                'bn' => $this->description_bn,
            ],
            'specs'             => $filteredSpecs,
        ];

        $payload = [
            'title' => [
                'en' => $this->title_en,
                'bn' => $this->title_bn ?: $this->title_en,
            ],
            'slug'                     => Str::slug($this->slug),
            'part_number'              => trim($this->part_number),
            'technical_specifications' => $techSpecsPayload,
            'featured_image_id'        => $this->featured_image_id,
            'brochure_media_id'        => $this->brochure_media_id,
            'is_active'                => $this->is_active,
        ];

        if ($this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update($payload);
            session()->flash('message', "Spare part '{$this->title_en}' successfully updated.");
        } else {
            Product::create($payload);
            session()->flash('message', "New spare part '{$this->title_en}' successfully added to catalog.");
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

        // Unique categories and brands for filter bars
        $categoriesList = [
            'Rotor Assemblies',
            'Cartridges (CHRA)',
            'Nozzle Rings & Shrouds',
            'Bearings & Seals',
            'Turbine Blading',
            'Compressor Impellers',
            'Casing & Liners',
        ];

        $brandsList = [
            'MAN Energy Solutions',
            'ABB / Accelleron',
            'Mitsubishi Heavy Industries (MHI)',
            'Napier Turbochargers',
            'KBB Turbochargers',
            'Garrett / Honeywell',
        ];

        return view('livewire.admin.products.product-manager', [
            'products'        => $products,
            'totalCount'      => $totalCount,
            'activeCount'     => $activeCount,
            'inStockCount'    => $inStockCount,
            'categoriesList'  => $categoriesList,
            'brandsList'      => $brandsList,
            'mediaAssets'     => MediaAsset::latest()->take(24)->get(),
        ]);
    }
}
