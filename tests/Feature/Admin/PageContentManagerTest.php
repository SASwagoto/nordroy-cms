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
        // Home tab should not be present
        $response->assertDontSee('Homepage (/home)', false);
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

    public function test_admin_can_toggle_about_sections_and_render_gapless_layout(): void
    {
        $this->actingAs($this->admin);

        // Turn off OEM Partners
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('content.about_show_partners', false)
            ->set('content.about_show_vision', false)
            ->call('saveContent');

        $this->assertFalse((bool) Setting::get('about_show_partners'));
        $this->assertFalse((bool) Setting::get('about_show_vision'));

        $response = $this->get(route('about'));
        $response->assertStatus(200);
        // OEM Partners box title should NOT be seen
        $response->assertDontSee('Authorized OEM Partnerships');
        // Vision 2030 should NOT be seen
        $response->assertDontSee('Vision 2030');
        // Mission should still be present in single centered card
        $response->assertSee('Our Corporate Mission');
    }

    public function test_admin_can_manage_contact_facilities_repeater_and_toggle_real_time(): void
    {
        $this->actingAs($this->admin);

        // Add 3rd facility and toggle 1st facility
        $comp = Livewire::test(PageContentManager::class)
            ->call('setPage', 'contact')
            ->set('newFacilityBadge', 'Middle East Hub')
            ->set('newFacilityTitle', 'Dubai Maritime Port Facility')
            ->set('newFacilityAddress', 'Dubai Maritime City, UAE')
            ->set('newFacilityPhone', '+971 4000-0000')
            ->set('newFacilityEmail', 'dubai.desk@nordroy.com')
            ->call('addFacility')
            ->call('toggleFacility', 0) // Real-time toggle off Port Workshop
            ->call('saveContent');

        $facilities = Setting::getJson('contact_facilities_list');
        $this->assertCount(3, $facilities);
        $this->assertFalse((bool) $facilities[0]['is_active']);
        $this->assertEquals('Dubai Maritime Port Facility', $facilities[2]['title']);

        // Check on frontend /contact
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Dubai Maritime Port Facility');
        $response->assertSee('+971 4000-0000');
        // The first toggled off workshop email should not be rendered
        $response->assertDontSee('port.ops@nordroy.com');

        // Test hiding RFQ form on contact page
        $comp->set('content.contact_show_rfq_form', false)
            ->call('saveContent');

        $this->assertFalse((bool) Setting::get('contact_show_rfq_form'));

        $responseNoRFQ = $this->get(route('contact'));
        $responseNoRFQ->assertStatus(200);
        $responseNoRFQ->assertDontSee('Request Quotation / Port Squad');
        $responseNoRFQ->assertSee('Dubai Maritime Port Facility');
    }

    public function test_frosted_glass_opacity_is_clamped_and_never_zero_or_hundred(): void
    {
        $this->actingAs($this->admin);

        // Test 0 gets clamped to 10
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('content.about_header_bg', 'frosted')
            ->set('content.about_header_frosted_opacity', 0)
            ->call('saveContent');

        $this->assertEquals(10, (int) Setting::get('about_header_frosted_opacity'));

        // Test 100 gets clamped to 90
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('content.about_header_frosted_opacity', 100)
            ->call('saveContent');

        $this->assertEquals(90, (int) Setting::get('about_header_frosted_opacity'));

        // Test safe value (e.g. 65)
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('content.about_header_frosted_opacity', 65)
            ->call('saveContent');

        $this->assertEquals(65, (int) Setting::get('about_header_frosted_opacity'));

        $response = $this->get(route('about'));
        $response->assertStatus(200);
        $response->assertSee('rgba(255, 255, 255, 0.65)');
    }

    public function test_admin_can_manage_careers_dynamic_pillars_and_colors(): void
    {
        $this->actingAs($this->admin);

        $testComponent = Livewire::test(PageContentManager::class)
            ->call('setPage', 'careers')
            ->set('newPillarTitle', 'Autonomous Robotics Bench')
            ->set('newPillarDesc', 'Robotic micro-plasma welding and automated balancing.')
            ->set('newPillarColor', 'emerald')
            ->set('newPillarIcon', 'solid:cog')
            ->call('addPillar')
            ->call('saveContent');

        $pillars = Setting::getJson('careers_culture_cards');
        $this->assertCount(5, $pillars);
        $this->assertEquals('Autonomous Robotics Bench', $pillars[4]['title']);
        $this->assertEquals('emerald', $pillars[4]['color']);

        // Check on public careers page
        $response = $this->get(route('careers'));
        $response->assertStatus(200);
        $response->assertSee('Autonomous Robotics Bench');
        $response->assertSee('Robotic micro-plasma welding and automated balancing.');

        // Toggle 2nd pillar off and verify it disappears without leaving broken slot
        $testComponent->call('togglePillar', 1)
            ->call('saveContent');

        $updatedPillars = Setting::getJson('careers_culture_cards');
        $this->assertFalse((bool) $updatedPillars[1]['is_active']);

        $responseAfterToggle = $this->get(route('careers'));
        $responseAfterToggle->assertStatus(200);
        // The toggled off pillar was 'Offshore Flying Squads'
        $responseAfterToggle->assertDontSee('Offshore Flying Squads');
        $responseAfterToggle->assertSee('Autonomous Robotics Bench');
    }

    public function test_admin_can_customize_header_background_styles(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('content.about_header_bg', 'frosted')
            ->call('saveContent')
            ->call('setPage', 'careers')
            ->set('content.careers_header_bg', 'slate')
            ->call('saveContent');

        $this->assertEquals('frosted', Setting::get('about_header_bg'));
        $this->assertEquals('slate', Setting::get('careers_header_bg'));

        $aboutResponse = $this->get(route('about'));
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('backdrop-blur-md');

        $careersResponse = $this->get(route('careers'));
        $careersResponse->assertStatus(200);
        $careersResponse->assertSee('bg-slate-100');
    }

    public function test_admin_can_configure_services_products_and_gallery_settings(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageContentManager::class)
            ->call('setPage', 'services')
            ->set('content.services_grid_cols', '2')
            ->set('content.services_per_page', '6')
            ->set('content.services_show_quote_btn', false)
            ->call('saveContent')
            ->call('setPage', 'products')
            ->set('content.products_grid_cols', '3')
            ->set('content.products_per_page', '8')
            ->set('content.products_show_search', false)
            ->call('saveContent')
            ->call('setPage', 'gallery')
            ->set('content.photo_gallery_grid_cols', '3')
            ->set('content.video_gallery_grid_cols', '2')
            ->call('saveContent');

        $this->assertEquals('2', Setting::get('services_grid_cols'));
        $this->assertEquals('6', Setting::get('services_per_page'));
        $this->assertFalse((bool) Setting::get('services_show_quote_btn'));

        $this->assertEquals('3', Setting::get('products_grid_cols'));
        $this->assertEquals('8', Setting::get('products_per_page'));
        $this->assertFalse((bool) Setting::get('products_show_search'));

        $this->assertEquals('3', Setting::get('photo_gallery_grid_cols'));
        $this->assertEquals('2', Setting::get('video_gallery_grid_cols'));

        // Visit /products page and verify search bar is hidden
        $productsResp = $this->get(route('products'));
        $productsResp->assertStatus(200);
        $productsResp->assertDontSee('Search by Part # or Model...');
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

    public function test_admin_can_manage_about_spec_stats_repeater_and_mission_vision_configuration(): void
    {
        $this->actingAs($this->admin);

        // Add 3rd spec stat and customize Mission & Vision
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'about')
            ->set('newStatValue', '99.98% Precision')
            ->set('newStatLabel', 'ISO Dynamic Balancing Grade')
            ->set('newStatColor', 'rose')
            ->call('addStat')
            ->call('toggleStat', 0) // Disable 1st default stat (100k RPM)
            ->set('content.about_mission_vision_align', 'center')
            ->set('content.about_mission_vision_style', 'bordered')
            ->set('content.about_mission_badge', 'Operational Doctrine')
            ->set('content.about_mission_icon', 'solid:rocket')
            ->set('content.about_vision_badge', 'Global Footprint 2030')
            ->call('saveContent')
            ->assertHasNoErrors();

        $stats = Setting::getJson('about_stats_list');
        $this->assertCount(3, $stats);
        $this->assertFalse((bool) $stats[0]['is_active']);
        $this->assertEquals('99.98% Precision', $stats[2]['value']);
        $this->assertEquals('rose', $stats[2]['color']);

        $this->assertEquals('center', Setting::get('about_mission_vision_align'));
        $this->assertEquals('bordered', Setting::get('about_mission_vision_style'));
        $this->assertEquals('Operational Doctrine', Setting::get('about_mission_badge'));

        // Visit public /about page
        $response = $this->get(route('about'));
        $response->assertStatus(200);
        $response->assertSee('99.98% Precision');
        $response->assertSee('ISO Dynamic Balancing Grade');
        $response->assertSee('Operational Doctrine');
        $response->assertSee('Global Footprint 2030');
        // The disabled 1st stat should NOT be visible
        $response->assertDontSee('Balancing Rig Capacity');
    }
}
