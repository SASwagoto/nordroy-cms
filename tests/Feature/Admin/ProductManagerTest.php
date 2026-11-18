<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Products\ProductEditor;
use App\Livewire\Admin\Products\ProductManager;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductManagerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'Super Administrator']);
        $permission = Permission::firstOrCreate(['name' => 'products.view']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        $this->admin->givePermissionTo('products.view');
    }

    public function test_products_manager_page_is_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products'));
        $response->assertStatus(200);
        $response->assertSee('Products &amp; Spare Parts', false);
        $response->assertSee('Add Spare Part');
    }

    public function test_products_manager_lists_and_searches_products(): void
    {
        Product::create([
            'title' => ['en' => 'MAN NR24 Rotor Assembly', 'bn' => 'ম্যান NR24 রটার'],
            'slug' => 'man-nr24-rotor-assembly-test',
            'part_number' => 'MAN-NR24-TEST-01',
            'technical_specifications' => [
                'category' => 'Rotor Assemblies',
                'brand' => 'MAN Energy Solutions',
                'stock_status' => 'In Stock',
                'specs' => [
                    ['key' => 'Max Speed', 'value' => '48,000 RPM'],
                ],
            ],
            'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ProductManager::class)
            ->assertSee('MAN-NR24-TEST-01')
            ->assertSee('MAN NR24 Rotor Assembly')
            ->set('search', 'MAN-NR24-TEST-01')
            ->assertSee('MAN-NR24-TEST-01')
            ->set('search', 'NONEXISTENTPART')
            ->assertDontSee('MAN-NR24-TEST-01')
            ->assertSee('No spare parts found');
    }

    public function test_product_editor_page_is_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products.create'));
        $response->assertStatus(200);
        $response->assertSee('Create New Spare Part');
        $response->assertSee('Back to Products');
    }

    public function test_product_editor_can_create_new_spare_part(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProductEditor::class)
            ->set('title_en', 'ABB TPL 77 Core Cartridge')
            ->set('slug', 'abb-tpl77-cartridge')
            ->set('part_number', 'ABB-TPL77-CRT-TEST')
            ->set('category', 'Cartridges (CHRA)')
            ->set('brand', 'ABB / Accelleron')
            ->set('condition', 'Genuine New OEM')
            ->set('stock_status', 'In Stock (Central Warehouse)')
            ->set('specs', [
                ['key' => 'Max RPM', 'value' => '22,000 RPM'],
            ])
            ->call('saveProduct')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.products'));

        $this->assertDatabaseHas('products', [
            'slug' => 'abb-tpl77-cartridge',
            'part_number' => 'ABB-TPL77-CRT-TEST',
        ]);
    }

    public function test_product_editor_can_edit_existing_spare_part(): void
    {
        $part = Product::create([
            'title' => ['en' => 'Napier NA297 Casing', 'bn' => 'নেপিয়ার কেসিং'],
            'slug' => 'napier-na297-casing',
            'part_number' => 'NAP-297-CSG',
            'technical_specifications' => [
                'category' => 'Rotor Assemblies',
                'brand' => 'Napier Turbochargers',
            ],
            'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ProductEditor::class, ['id' => $part->id])
            ->assertSet('title_en', 'Napier NA297 Casing')
            ->set('title_en', 'Napier NA297 Casing Series II')
            ->set('part_number', 'NAP-297-CSG-V2')
            ->call('saveProduct')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.products'));

        $this->assertDatabaseHas('products', [
            'id' => $part->id,
            'part_number' => 'NAP-297-CSG-V2',
        ]);
    }

    public function test_public_product_catalog_and_details_page_render_successfully(): void
    {
        $part = Product::create([
            'title' => ['en' => 'Mitsubishi MET 33SC Nozzle Ring', 'bn' => 'মিতসুবিশি MET 33SC নজল রিং'],
            'slug' => 'mitsubishi-met-33sc-nozzle-ring-test',
            'part_number' => 'MET-33SC-NOZ-TEST',
            'technical_specifications' => [
                'category' => 'Nozzle Rings & Shrouds',
                'brand' => 'Mitsubishi Heavy Industries (MHI)',
                'stock_status' => 'In Stock',
                'specs' => [
                    ['key' => 'Material', 'value' => 'Stainless Steel 310S'],
                ],
            ],
            'is_active' => true,
        ]);

        // Catalog Page
        $resCatalog = $this->get(route('products'));
        $resCatalog->assertStatus(200);
        $resCatalog->assertSee('Marine Turbocharger Spare Parts &amp; Assemblies.', false);
        $resCatalog->assertSee('MET-33SC-NOZ-TEST');

        // Details Page
        $resDetails = $this->get(route('product.details', $part->slug));
        $resDetails->assertStatus(200);
        $resDetails->assertSee('Mitsubishi MET 33SC Nozzle Ring');
        $resDetails->assertSee('MET-33SC-NOZ-TEST');
        $resDetails->assertSee('Stainless Steel 310S');
        $resDetails->assertSee('Request Quotation (RFQ)');
    }

    public function test_public_service_details_page_renders_successfully(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Dynamic Rotor Balancing 100k RPM', 'bn' => 'ডায়নামিক রটার ব্যালেন্সিং'],
            'slug' => 'dynamic-rotor-balancing-test',
            'icon' => 'solid:gauge',
            'short_summary' => ['en' => 'Elimination of micro-vibrations with computerized dynamic balancing.'],
            'content' => ['en' => 'Complete dynamic rotor balancing up to 100,000 RPM on Schenck balancing bench.'],
            'order' => 1,
            'is_active' => true,
        ]);

        $resServiceDetails = $this->get(route('service.details', $service->slug));
        $resServiceDetails->assertStatus(200);
        $resServiceDetails->assertSee('Dynamic Rotor Balancing 100k RPM');
        $resServiceDetails->assertSee('Class-Certified 5-Phase Overhaul Methodology');
        $resServiceDetails->assertSee('Request Overhaul RFQ');
    }

    public function test_product_editor_can_quick_create_category_and_brand_instantly(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProductEditor::class)
            ->call('openQuickCategoryModal')
            ->assertSet('showQuickCategoryModal', true)
            ->set('newCategoryName', 'Turbine Casings')
            ->call('saveQuickCategory')
            ->assertSet('showQuickCategoryModal', false)
            ->assertSet('category', 'Turbine Casings')
            ->call('openQuickBrandModal')
            ->assertSet('showQuickBrandModal', true)
            ->set('newBrandName', 'KBB Turbochargers')
            ->call('saveQuickBrand')
            ->assertSet('showQuickBrandModal', false)
            ->assertSet('brand', 'KBB Turbochargers')
            ->set('title_en', 'KBB HPR4000 Turbine Casing')
            ->set('slug', 'kbb-hpr4000-turbine-casing')
            ->set('part_number', 'KBB-HPR-4000-CSG')
            ->call('saveProduct')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.products'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Turbine Casings',
        ]);

        $this->assertDatabaseHas('brands', [
            'name' => 'KBB Turbochargers',
        ]);

        $product = Product::where('slug', 'kbb-hpr4000-turbine-casing')->first();
        $this->assertNotNull($product);
        $this->assertEquals('Turbine Casings', $product->category);
        $this->assertEquals('KBB Turbochargers', $product->brand);
        $this->assertNotNull($product->category_id);
        $this->assertNotNull($product->brand_id);
    }

    public function test_media_picker_opens_without_htmlspecialchars_error_and_supports_gallery(): void
    {
        // Create media asset with array alt_text as stored in production
        $asset = \App\Models\MediaAsset::create([
            'disk' => 'public',
            'file_path' => 'uploads/test-rotor.jpg',
            'file_name' => 'test-rotor.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 102400,
            'file_hash' => 'hash-test-rotor-01',
            'alt_text' => ['en' => 'Test Rotor Blade', 'bn' => 'রটার ব্লেড'],
            'title' => ['en' => 'Test Rotor'],
        ]);

        $galleryAsset = \App\Models\MediaAsset::create([
            'disk' => 'public',
            'file_path' => 'uploads/test-rotor-angle-2.jpg',
            'file_name' => 'test-rotor-angle-2.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 102400,
            'file_hash' => 'hash-test-rotor-02',
            'alt_text' => ['en' => 'Angle 2', 'bn' => 'অ্যাঙ্গেল ২'],
        ]);

        // Test opening media picker for featured image does not crash
        Livewire::actingAs($this->admin)
            ->test(ProductEditor::class)
            ->call('openMediaPicker', 'featured_image')
            ->assertSet('isMediaPickerOpen', true)
            ->assertSee('test-rotor.jpg')
            ->call('selectAsset', $asset->id, $asset->url)
            ->assertSet('featured_image_id', $asset->id)
            ->assertSet('isMediaPickerOpen', false)
            ->call('openMediaPicker', 'gallery')
            ->assertSet('isMediaPickerOpen', true)
            ->call('selectAsset', $galleryAsset->id, $galleryAsset->url)
            ->assertCount('gallery_images', 1)
            ->set('title_en', 'Multi Image Rotor Part')
            ->set('slug', 'multi-image-rotor-part')
            ->set('part_number', 'MIR-001')
            ->call('saveProduct')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.products'));

        $savedProduct = Product::where('slug', 'multi-image-rotor-part')->first();
        $this->assertNotNull($savedProduct);
        $this->assertEquals($asset->id, $savedProduct->featured_image_id);
        $this->assertContains($galleryAsset->id, $savedProduct->gallery_image_ids);
        $this->assertCount(1, $savedProduct->gallery_images);

        // Verify public details page renders both images in the gallery
        $res = $this->get(route('product.details', $savedProduct->slug));
        $res->assertStatus(200);
        $res->assertSee($asset->url);
        $res->assertSee($galleryAsset->url);
    }
}
