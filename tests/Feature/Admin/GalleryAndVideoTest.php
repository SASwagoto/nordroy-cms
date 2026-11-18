<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Gallery\GalleryManager;
use App\Livewire\Admin\Products\ProductEditor;
use App\Livewire\Admin\Services\ServiceEditor;
use App\Models\GalleryAlbum;
use App\Models\MediaAsset;
use App\Models\PhotoGallery;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Models\VideoGallery;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\RoleAndAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GalleryAndVideoTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Administrator']);
        $perms = ['services.view', 'products.view', 'media.view', 'settings.manage'];
        foreach ($perms as $p) {
            $perm = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $p]);
            $role->givePermissionTo($perm);
        }

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        foreach ($perms as $p) {
            $this->admin->givePermissionTo($p);
        }
    }

    public function test_service_editor_create_and_edit_page_is_accessible(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.services.create'));
        $response->assertStatus(200);

        $service = Service::create([
            'title' => ['en' => 'Dynamic Balancing Service', 'bn' => 'ডাইনামিক ব্যালেন্সিং সার্ভিস'],
            'slug' => 'dynamic-balancing-service',
            'order' => 1,
            'is_active' => true,
        ]);

        $responseEdit = $this->get(route('admin.services.edit', $service->id));
        $responseEdit->assertStatus(200);
    }

    public function test_service_editor_can_create_service_with_youtube_video(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(ServiceEditor::class)
            ->set('title_en', 'High-Speed Balancing Rotor Test')
            ->set('title_bn', 'হাই-স্পিড ব্যালেন্সিং রোটর টেস্ট')
            ->set('slug', 'high-speed-balancing-rotor-test')
            ->set('short_summary_en', 'Dynamic balancing bench calibration at 20,000 RPM.')
            ->set('content_en', '<p>Full precision procedure adhering to ISO 1940 Grade G1.0.</p>')
            ->set('video_url', 'https://www.youtube.com/watch?v=9No-FiEInLA')
            ->call('save')
            ->assertRedirect(route('admin.services'));

        $this->assertDatabaseHas('services', [
            'slug' => 'high-speed-balancing-rotor-test',
            'video_url' => 'https://www.youtube.com/watch?v=9No-FiEInLA',
        ]);

        $created = Service::where('slug', 'high-speed-balancing-rotor-test')->first();
        $this->assertEquals('9No-FiEInLA', $created->youtube_id);
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/9No-FiEInLA', $created->youtube_embed_url);
    }

    public function test_product_editor_can_save_youtube_video_and_details_page_embeds_it(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(ProductEditor::class)
            ->set('title_en', 'Marine Turbocharger Shaft 5-Axis')
            ->set('slug', 'marine-turbocharger-shaft-5-axis')
            ->set('part_number', 'NR-34-SHAFT-99')
            ->set('category', 'Rotor Assemblies')
            ->set('brand', 'MAN Energy Solutions')
            ->set('video_url', 'https://youtu.be/kJQP7kiw5Fk')
            ->call('save')
            ->assertRedirect(route('admin.products'));

        $product = Product::where('slug', 'marine-turbocharger-shaft-5-axis')->firstOrFail();
        $this->assertEquals('kJQP7kiw5Fk', $product->youtube_id);
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/kJQP7kiw5Fk', $product->youtube_embed_url);

        // Test public details page embeds the video showcase
        $response = $this->get(route('product.details', $product->slug));
        $response->assertStatus(200);
        $response->assertSee('kJQP7kiw5Fk');
        $response->assertSee('Video Showcase');
    }

    public function test_gallery_manager_accessible_and_manages_albums_photos_and_videos(): void
    {
        $this->actingAs($this->admin);

        // 1. Gallery Manager is accessible
        $response = $this->get(route('admin.gallery'));
        $response->assertStatus(200);

        // 2. Create Album
        Livewire::test(GalleryManager::class)
            ->call('openCreateAlbumModal')
            ->set('albumNameEn', 'Workshop Rigging')
            ->set('albumNameBn', 'ওয়ার্কশপ রিগিং')
            ->set('albumSlug', 'workshop-rigging')
            ->call('saveAlbum');

        $this->assertDatabaseHas('gallery_albums', [
            'slug' => 'workshop-rigging',
        ]);

        $album = GalleryAlbum::where('slug', 'workshop-rigging')->firstOrFail();

        // 3. Create Video Gallery Item
        Livewire::test(GalleryManager::class)
            ->call('openCreateVideoModal')
            ->set('videoYoutubeUrl', 'https://www.youtube.com/watch?v=9No-FiEInLA')
            ->set('videoTitleEn', 'Emergency Cartridge Extraction Video')
            ->set('videoTitleBn', 'ইমার্জেন্সি কার্ত্রিজ এক্সট্রাকশন ভিডিও')
            ->set('videoDescriptionEn', '<p>Onboard ship footage at outer anchorage.</p>')
            ->set('videoAlbumId', $album->id)
            ->call('saveVideo');

        $this->assertDatabaseHas('video_galleries', [
            'youtube_id' => '9No-FiEInLA',
            'album_id'   => $album->id,
        ]);

        // 4. Batch Add Photos to Album
        $asset1 = MediaAsset::create([
            'file_name'     => 'shaft-test-01.jpg',
            'file_path'     => 'gallery/shaft-test-01.jpg',
            'disk'          => 'public',
            'mime_type'     => 'image/jpeg',
            'file_size'     => 1024,
            'file_hash'     => 'gallery-hash-01',
            'folder'        => 'gallery',
            'title'         => ['en' => 'Shaft Test 01'],
            'alt_text'      => ['en' => 'Shaft Test 01 Alt'],
        ]);

        $asset2 = MediaAsset::create([
            'file_name'     => 'shaft-test-02.jpg',
            'file_path'     => 'gallery/shaft-test-02.jpg',
            'disk'          => 'public',
            'mime_type'     => 'image/jpeg',
            'file_size'     => 2048,
            'file_hash'     => 'gallery-hash-02',
            'folder'        => 'gallery',
            'title'         => ['en' => 'Shaft Test 02'],
            'alt_text'      => ['en' => 'Shaft Test 02 Alt'],
        ]);

        Livewire::test(GalleryManager::class)
            ->set('selectedAlbumId', $album->id)
            ->call('selectMultipleAssets', [$asset1->id, $asset2->id]);

        $this->assertEquals(2, PhotoGallery::where('album_id', $album->id)->count());

        // 5. Public /gallery route renders albums, photos, and videos with lightbox
        $publicResponse = $this->get(route('gallery'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Workshop Rigging');
        $publicResponse->assertSee('Emergency Cartridge Extraction Video');
    }
}
