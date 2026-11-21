<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SystemHealthCheckTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'Super Administrator']);
        $perms = [
            'settings.manage',
            'enquiries.view',
            'services.view',
            'services.manage',
            'products.view',
            'products.manage',
            'media.view',
            'media.manage',
        ];
        foreach ($perms as $p) {
            $perm = Permission::firstOrCreate(['name' => $p]);
            $role->givePermissionTo($perm);
        }

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        foreach ($perms as $p) {
            $this->admin->givePermissionTo($p);
        }

        $this->seed(LanguageSeeder::class);
    }

    public function test_all_public_routes_render_without_errors(): void
    {
        $publicRoutes = [
            'home'          => '/',
            'about'         => '/about',
            'services'      => '/services',
            'products'      => '/products',
            'contact'       => '/contact',
            'careers'       => '/careers',
            'photo-gallery' => '/photo-gallery',
            'video-gallery' => '/video-gallery',
            'login'         => '/login',
        ];

        foreach ($publicRoutes as $name => $uri) {
            $response = $this->get($uri);
            $this->assertEquals(200, $response->getStatusCode(), "Public route [{$name}: {$uri}] failed with status {$response->getStatusCode()}");
        }
    }

    public function test_all_admin_management_routes_render_without_errors(): void
    {
        $this->actingAs($this->admin);

        $adminRoutes = [
            'admin.dashboard'              => route('admin.dashboard'),
            'admin.homepage.builder'       => route('admin.homepage.builder'),
            'admin.pages.content'          => route('admin.pages.content'),
            'admin.enquiries'              => route('admin.enquiries'),
            'admin.enquiries.form-builder' => route('admin.enquiries.form-builder'),
            'admin.careers'                => route('admin.careers'),
            'admin.media'                  => route('admin.media'),
            'admin.services'               => route('admin.services'),
            'admin.services.create'        => route('admin.services.create'),
            'admin.products'               => route('admin.products'),
            'admin.products.create'        => route('admin.products.create'),
            'admin.photo-gallery'          => route('admin.photo-gallery'),
            'admin.video-gallery'          => route('admin.video-gallery'),
            'admin.languages'              => route('admin.languages'),
            'admin.icons.manifest'         => route('admin.icons.manifest'),
        ];

        foreach ($adminRoutes as $name => $url) {
            $response = $this->get($url);
            $this->assertEquals(200, $response->getStatusCode(), "Admin route [{$name}: {$url}] failed with status {$response->getStatusCode()}");
        }
    }

    public function test_icon_manifest_api_returns_valid_vector_collection(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.icons.manifest'));
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
    }

    public function test_page_title_renders_clean_ampersand_without_html_entity_escaping(): void
    {
        // Set a site name and title containing ampersand
        \App\Models\Setting::set('site_name', 'Nordroy & Co Marine');
        \App\Models\Setting::set('contact_hero_title', 'Contact & 24/7 Port Duty Desk');

        $response = $this->get('/contact');
        $response->assertStatus(200);

        $html = $response->getContent();
        preg_match('/<title>(.*?)<\/title>/s', $html, $matches);
        $this->assertNotEmpty($matches, 'Title tag should exist in HTML response');

        $titleContent = $matches[1];
        // Title should contain literal '&' and NOT encoded '&amp;'
        $this->assertStringContainsString('&', $titleContent);
        $this->assertStringNotContainsString('&amp;', $titleContent);

        // Test admin title with ampersand
        $this->actingAs($this->admin);
        $adminResponse = $this->get(route('admin.careers'));
        $adminResponse->assertStatus(200);

        $adminHtml = $adminResponse->getContent();
        preg_match('/<title>(.*?)<\/title>/s', $adminHtml, $adminMatches);
        $this->assertNotEmpty($adminMatches, 'Admin title tag should exist');
        $this->assertStringNotContainsString('&amp;', $adminMatches[1]);
    }
}
