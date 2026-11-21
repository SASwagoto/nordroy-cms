<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Pages\HomepageBuilder;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HomepageBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'Super Administrator']);
        $perms = [
            'settings.manage',
            'theme.manage',
            'media.view',
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

    public function test_admin_can_access_homepage_builder(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.homepage.builder'));
        $response->assertStatus(200);
        $response->assertSee('Homepage Builder');
        $response->assertSee('Header (Topbar &amp; Navbar)', false);
        $response->assertSee('LOCKED');
        $response->assertSee('1 Active Section');
        // Future sections should NOT be in the sidebar
        $response->assertDontSee('8 Sections');
        $response->assertDontSee('OEM Partner Ticker');
    }

    public function test_header_section_is_locked_and_selected_by_default(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->assertSet('selectedSection', 'header')
            ->call('selectSection', 'hero')
            ->assertSet('selectedSection', 'header');
    }

    public function test_admin_can_update_topbar_configuration_and_see_it_on_frontend(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('topbar_badge_text', '24/7 Rapid Outer Anchorage Duty')
            ->set('topbar_badge_icon', 'solid:shield-check')
            ->set('topbar_phone', '+880 1999-888777')
            ->set('topbar_email', 'flying.squad@nordroy.com')
            ->set('topbar_width', 'fluid')
            ->set('topbar_bg_type', 'gradient')
            ->set('topbar_gradient_dir', 'to right')
            ->set('topbar_gradient_from', '#003C58')
            ->set('topbar_gradient_to', '#0e7490')
            ->call('saveHeader')
            ->assertHasNoErrors();

        $this->assertEquals('24/7 Rapid Outer Anchorage Duty', Setting::get('header_topbar_badge_text'));
        $this->assertEquals('+880 1999-888777', Setting::get('header_topbar_phone'));
        $this->assertEquals('flying.squad@nordroy.com', Setting::get('header_topbar_email'));
        $this->assertEquals('fluid', Setting::get('header_topbar_width'));
        $this->assertEquals('gradient', Setting::get('header_topbar_bg_type'));

        // Verify on frontend
        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('24/7 Rapid Outer Anchorage Duty');
        $frontendResponse->assertSee('+880 1999-888777');
        $frontendResponse->assertSee('flying.squad@nordroy.com');
        $frontendResponse->assertSee('linear-gradient(to right, #003C58, #0e7490)', false);
    }

    public function test_admin_can_toggle_topbar_off_and_frontend_hides_topbar(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('topbar_enabled', false)
            ->call('saveHeader')
            ->assertHasNoErrors();

        $this->assertEquals('0', Setting::get('header_topbar_enabled'));

        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertDontSee('id="corporate-topbar"', false);
    }

    public function test_admin_can_update_navbar_styling_and_cta(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('header_sticky', false)
            ->set('header_bg_type', 'glass')
            ->set('header_glass_opacity', 70)
            ->set('header_cta_text', 'Deploy Flying Squad')
            ->set('header_cta_url', '/contact#squad')
            ->set('header_cta_icon', 'solid:bolt')
            ->call('saveHeader')
            ->assertHasNoErrors();

        $this->assertEquals('0', Setting::get('header_sticky'));
        $this->assertEquals('70', Setting::get('header_glass_opacity'));
        $this->assertEquals('Deploy Flying Squad', Setting::get('header_cta_text'));
        $this->assertEquals('/contact#squad', Setting::get('header_cta_url'));

        // Verify on frontend
        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('Deploy Flying Squad');
        $frontendResponse->assertSee('/contact#squad');
    }

    public function test_frosted_glass_opacity_is_clamped_between_10_and_90(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('header_glass_opacity', 2)
            ->set('topbar_glass_opacity', 99)
            ->call('saveHeader')
            ->assertSet('header_glass_opacity', 10)
            ->assertSet('topbar_glass_opacity', 90);

        $this->assertEquals('10', Setting::get('header_glass_opacity'));
        $this->assertEquals('90', Setting::get('header_topbar_glass_opacity'));
    }

    public function test_custom_topbar_items_repeater(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('topbar_enabled', true)
            ->set('newCustomZone', 'left')
            ->set('newCustomText', 'DNV Certified Workshop')
            ->set('newCustomIcon', 'solid:award')
            ->set('newCustomUrl', '/about#certifications')
            ->call('addCustomTopbarItem')
            ->call('saveHeader')
            ->assertHasNoErrors();

        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('DNV Certified Workshop');
        $frontendResponse->assertSee('/about#certifications');
    }

    public function test_restore_production_design_restores_exact_real_data(): void
    {
        $this->actingAs($this->admin);

        // Intentionally pollute settings
        Setting::set('header_topbar_badge_text', 'Bogus Text 123');
        Setting::set('header_brand_title', 'Fake Marine');

        Livewire::test(HomepageBuilder::class)
            ->call('restoreProductionDesign')
            ->assertSet('topbar_badge_text', '24/7 Port Call & Emergency Squads')
            ->assertSet('header_brand_title', 'Nordroy Marine')
            ->assertDispatched('flash-message');

        $this->assertEquals('24/7 Port Call & Emergency Squads', Setting::get('header_topbar_badge_text'));
        $this->assertEquals('Nordroy Marine', Setting::get('header_brand_title'));
    }
}
