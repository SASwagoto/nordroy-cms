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
    }

    public function test_header_section_is_locked_and_selected_by_default(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->assertSet('selectedSection', 'header')
            ->call('selectSection', 'hero')
            ->assertSet('selectedSection', 'header')
            ->assertDispatched('flash-message');
    }

    public function test_admin_can_update_topbar_configuration_and_see_it_on_frontend(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('topbar_badge_text', '24/7 Rapid Outer Anchorage Duty')
            ->set('topbar_badge_icon', 'solid:shield-check')
            ->set('topbar_phone', '+880 1999-888777')
            ->set('topbar_email', 'flying.squad@nordroy.com')
            ->call('saveHeader')
            ->assertHasNoErrors();

        $this->assertEquals('24/7 Rapid Outer Anchorage Duty', Setting::get('header_topbar_badge_text'));
        $this->assertEquals('+880 1999-888777', Setting::get('header_topbar_phone'));
        $this->assertEquals('flying.squad@nordroy.com', Setting::get('header_topbar_email'));

        // Verify on frontend
        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('24/7 Rapid Outer Anchorage Duty');
        $frontendResponse->assertSee('+880 1999-888777');
        $frontendResponse->assertSee('flying.squad@nordroy.com');
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
        $frontendResponse->assertDontSee('TOP CORPORATE EMERGENCY & STATS STRIP');
    }

    public function test_admin_can_update_navbar_styling_and_cta(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('header_sticky', false)
            ->set('header_bg_style', 'frosted')
            ->set('header_frosted_opacity', 70)
            ->set('header_cta_text', 'Deploy Flying Squad')
            ->set('header_cta_url', '/contact#squad')
            ->set('header_cta_icon', 'solid:bolt')
            ->call('saveHeader')
            ->assertHasNoErrors();

        $this->assertEquals('0', Setting::get('header_sticky'));
        $this->assertEquals('70', Setting::get('header_frosted_opacity'));
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
            ->set('header_frosted_opacity', 2)
            ->call('saveHeader')
            ->assertSet('header_frosted_opacity', 10);

        $this->assertEquals('10', Setting::get('header_frosted_opacity'));

        Livewire::test(HomepageBuilder::class)
            ->set('header_frosted_opacity', 100)
            ->call('saveHeader')
            ->assertSet('header_frosted_opacity', 90);

        $this->assertEquals('90', Setting::get('header_frosted_opacity'));
    }

    public function test_admin_can_reset_header_defaults(): void
    {
        $this->actingAs($this->admin);

        Setting::set('header_topbar_badge_text', 'Custom Overwritten Text');

        Livewire::test(HomepageBuilder::class)
            ->call('resetDefaults')
            ->assertSet('topbar_badge_text', '24/7 Port Call & Emergency Squads');

        $this->assertEquals('24/7 Port Call & Emergency Squads', Setting::get('header_topbar_badge_text'));
    }
}
