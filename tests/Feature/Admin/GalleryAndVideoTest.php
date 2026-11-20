<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Gallery\GalleryManager;
use App\Livewire\Admin\Gallery\PhotoGalleryManager;
use App\Livewire\Admin\Gallery\VideoGalleryManager;
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

        $this->seed(LanguageSeeder::class);
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

    public function test_admin_photo_gallery_manages_albums_and_photos(): void
    {
        $this->actingAs($this->admin);

        // 1. Photo Gallery Manager route is accessible
        $response = $this->get(route('admin.photo-gallery'));
        $response->assertStatus(200);

        // 2. Create Album in Photo Gallery Manager
        Livewire::test(PhotoGalleryManager::class)
            ->call('openCreateAlbumModal')
            ->set('albumNameEn', 'Rotor Balancing Workshops')
            ->set('albumNameBn', 'রোটর ব্যালেন্সিং ওয়ার্কশপ')
            ->set('albumSlug', 'rotor-balancing-workshops')
            ->call('saveAlbum');

        $this->assertDatabaseHas('gallery_albums', [
            'slug' => 'rotor-balancing-workshops',
            'type' => 'photo',
        ]);

        $album = GalleryAlbum::where('slug', 'rotor-balancing-workshops')->firstOrFail();

        // 3. Batch Add Photos to Album from MediaAsset
        $asset1 = MediaAsset::create([
            'file_name' => 'photo-01.jpg',
            'file_path' => 'gallery/photo-01.jpg',
            'disk'      => 'public',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'file_hash' => 'hash-photo-01',
            'folder'    => 'gallery',
            'title'     => ['en' => 'Turbine Blading Bay'],
        ]);

        $asset2 = MediaAsset::create([
            'file_name' => 'photo-02.jpg',
            'file_path' => 'gallery/photo-02.jpg',
            'disk'      => 'public',
            'mime_type' => 'image/jpeg',
            'file_size' => 2048,
            'file_hash' => 'hash-photo-02',
            'folder'    => 'gallery',
            'title'     => ['en' => 'Ultrasonic Cleaning Bath'],
        ]);

        Livewire::test(PhotoGalleryManager::class)
            ->set('selectedAlbumId', $album->id)
            ->call('selectMultipleAssets', [$asset1->id, $asset2->id]);

        $this->assertEquals(2, PhotoGallery::where('album_id', $album->id)->count());

        // 4. Update Photo Title & Caption
        $photo = PhotoGallery::where('album_id', $album->id)->firstOrFail();
        Livewire::test(PhotoGalleryManager::class)
            ->call('openEditPhotoModal', $photo->id)
            ->set('photoTitleEn', 'Updated Turbine Rotor View')
            ->set('photoCaptionEn', 'Precision balanced at 18,000 RPM')
            ->call('savePhoto');

        $this->assertEquals('Updated Turbine Rotor View', $photo->fresh()->display_title);
    }

    public function test_admin_video_gallery_manages_albums_and_videos(): void
    {
        $this->actingAs($this->admin);

        // 1. Video Gallery Manager route is accessible
        $response = $this->get(route('admin.video-gallery'));
        $response->assertStatus(200);

        // 2. Create Video Album
        Livewire::test(VideoGalleryManager::class)
            ->call('openCreateAlbumModal')
            ->set('albumNameEn', 'Offshore Field Operations')
            ->set('albumNameBn', 'অফশোর ফিল্ড অপারেশনস')
            ->set('albumSlug', 'offshore-field-operations')
            ->call('saveAlbum');

        $this->assertDatabaseHas('gallery_albums', [
            'slug' => 'offshore-field-operations',
            'type' => 'video',
        ]);

        $album = GalleryAlbum::where('slug', 'offshore-field-operations')->firstOrFail();

        // 3. Create Video Entry with YouTube ID Extraction & Quill HTML Description
        Livewire::test(VideoGalleryManager::class)
            ->call('openCreateVideoModal')
            ->set('videoYoutubeUrl', 'https://www.youtube.com/watch?v=kJQP7kiw5Fk')
            ->set('videoTitleEn', '2.5MW Power Plant Turbine Overhaul')
            ->set('videoTitleBn', '২.৫ মেগাওয়াট পাওয়ার প্লান্ট টারবাইন ওভারহল')
            ->set('videoDescriptionEn', '<p>Complete procedure including dynamic balancing and thermal crack repair.</p>')
            ->set('videoAlbumId', $album->id)
            ->call('saveVideo');

        $this->assertDatabaseHas('video_galleries', [
            'youtube_id' => 'kJQP7kiw5Fk',
            'album_id'   => $album->id,
        ]);

        $video = VideoGallery::where('youtube_id', 'kJQP7kiw5Fk')->firstOrFail();
        $this->assertEquals('kJQP7kiw5Fk', $video->youtube_id);
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/kJQP7kiw5Fk', $video->embed_url);
        $this->assertStringContainsString('hqdefault.jpg', $video->thumbnail_url);
    }

    public function test_public_dedicated_photo_and_video_gallery_routes(): void
    {
        // 1. Create photo album and item
        $photoAlbum = GalleryAlbum::create([
            'name'      => ['en' => 'Shipyard Workshop Snaps'],
            'slug'      => 'shipyard-workshop-snaps',
            'type'      => 'photo',
            'is_active' => true,
        ]);

        $asset = MediaAsset::create([
            'file_name' => 'snap-01.jpg',
            'file_path' => 'gallery/snap-01.jpg',
            'disk'      => 'public',
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'file_hash' => 'hash-snap-01',
            'folder'    => 'gallery',
            'title'     => ['en' => 'Workshop Crane Lift'],
        ]);

        PhotoGallery::create([
            'album_id'  => $photoAlbum->id,
            'media_id'  => $asset->id,
            'title'     => ['en' => 'Workshop Crane Heavy Lift'],
            'is_active' => true,
        ]);

        // 2. Create video album and item
        $videoAlbum = GalleryAlbum::create([
            'name'      => ['en' => 'Anchorage Flying Squads'],
            'slug'      => 'anchorage-flying-squads',
            'type'      => 'video',
            'is_active' => true,
        ]);

        VideoGallery::create([
            'album_id'    => $videoAlbum->id,
            'youtube_url' => 'https://www.youtube.com/watch?v=9No-FiEInLA',
            'youtube_id'  => '9No-FiEInLA',
            'title'       => ['en' => 'Emergency Deep Sea Boarding'],
            'description' => ['en' => '<p>Boarding offshore bulk carrier via tugboat.</p>'],
            'is_active'   => true,
        ]);

        // 3. Test dedicated /photo-gallery route
        $photoResponse = $this->get(route('photo-gallery'));
        $photoResponse->assertStatus(200);
        $photoResponse->assertSee('Shipyard Workshop Snaps');
        $photoResponse->assertSee('Workshop Crane Heavy Lift');

        // 4. Test dedicated /video-gallery route
        $videoResponse = $this->get(route('video-gallery'));
        $videoResponse->assertStatus(200);
        $videoResponse->assertSee('Anchorage Flying Squads');
        $videoResponse->assertSee('Emergency Deep Sea Boarding');
        $videoResponse->assertSee('9No-FiEInLA');

        // 5. Test legacy /gallery redirect
        $legacyRedirect = $this->get('/gallery');
        $legacyRedirect->assertRedirect(route('photo-gallery'));
    }
}
