<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Pages\PageContentManager;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PageContentManagerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Administrator']);
        $perms = ['settings.manage', 'enquiries.view'];
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

    public function test_page_content_manager_is_accessible_by_admin(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.pages.content'));
        $response->assertStatus(200);
        $response->assertSee('Static Page Content Studio', false);
    }

    public function test_admin_can_update_about_page_content_and_see_it_on_frontend(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('content.about_hero_title', 'Custom Corporate Heritage Title 2026')
            ->set('content.about_overview_title', 'High-Pressure Precision Testing Benchmark')
            ->set('content.about_stat1_value', '120k RPM')
            ->call('saveContent')
            ->assertHasNoErrors();

        $this->assertEquals('Custom Corporate Heritage Title 2026', Setting::get('about_hero_title'));
        $this->assertEquals('120k RPM', Setting::get('about_stat1_value'));

        // Visit public /about page
        $response = $this->get(route('about'));
        $response->assertStatus(200);
        $response->assertSee('Custom Corporate Heritage Title 2026');
        $response->assertSee('120k RPM');
    }

    public function test_admin_can_update_contact_page_content(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageContentManager::class)
            ->call('setPage', 'contact')
            ->set('content.contact_port_title', 'Chattogram Advanced Marine Turbine Yard')
            ->set('content.contact_port_phone', '+880 1899-999999')
            ->call('saveContent');

        $this->assertEquals('Chattogram Advanced Marine Turbine Yard', Setting::get('contact_port_title'));

        // Visit public /contact page
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Chattogram Advanced Marine Turbine Yard');
        $response->assertSee('+880 1899-999999');
    }

    public function test_admin_can_update_careers_and_home_page_content(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageContentManager::class)
            ->call('setPage', 'careers')
            ->set('content.careers_hero_title', 'Join Global Turbomachinery Elite')
            ->call('saveContent');

        $this->assertEquals('Join Global Turbomachinery Elite', Setting::get('careers_hero_title'));

        $response = $this->get(route('careers'));
        $response->assertStatus(200);
        $response->assertSee('Join Global Turbomachinery Elite');

        // Test home page
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'home')
            ->set('content.home_hero_title', 'Next-Gen Marine Propulsion Overhauls')
            ->call('saveContent');

        $this->assertEquals('Next-Gen Marine Propulsion Overhauls', Setting::get('home_hero_title'));

        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Next-Gen Marine Propulsion Overhauls');
    }

    public function test_admin_can_manage_partners_repeater_and_reset_defaults(): void
    {
        $this->actingAs($this->admin);

        // Add a new partner
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('newPartnerBrand', 'Napier Turbochargers')
            ->set('newPartnerModels', 'NA 297, NA 357 heavy series')
            ->call('addPartner')
            ->call('saveContent');

        $partners = Setting::getJson('about_partners_list');
        $this->assertNotEmpty($partners);
        $this->assertEquals('Napier Turbochargers', end($partners)['brand']);

        // Reset to defaults
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->call('resetToDefaults');

        $resetPartners = Setting::getJson('about_partners_list');
        $this->assertCount(4, $resetPartners);
    }
}
