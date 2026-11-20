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

    public function test_admin_can_update_contact_page_and_toggle_rfq_and_offices(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(PageContentManager::class)
            ->call('setPage', 'contact')
            ->set('content.contact_port_title', 'Chattogram Advanced Marine Turbine Yard')
            ->set('content.contact_port_phone', '+880 1899-999999')
            ->call('saveContent');

        $this->assertEquals('Chattogram Advanced Marine Turbine Yard', Setting::get('contact_port_title'));

        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Chattogram Advanced Marine Turbine Yard');
        $response->assertSee('+880 1899-999999');

        // Test hiding RFQ form on contact page
        Livewire::test(PageContentManager::class)
            ->call('setPage', 'contact')
            ->set('content.contact_show_rfq_form', false)
            ->call('saveContent');

        $this->assertFalse((bool) Setting::get('contact_show_rfq_form'));

        $responseNoRFQ = $this->get(route('contact'));
        $responseNoRFQ->assertStatus(200);
        $responseNoRFQ->assertDontSee('Request Quotation / Port Squad');
        $responseNoRFQ->assertSee('Chattogram Advanced Marine Turbine Yard');
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
