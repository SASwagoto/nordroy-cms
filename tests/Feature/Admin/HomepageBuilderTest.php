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
        $response->assertSee('Hero Banner');
        $response->assertSee('LOCKED');
        $response->assertSee('Body Sections (Reorderable)');
        $response->assertSee('Corporate Footer Studio');
    }

    public function test_header_and_hero_sections_are_locked_and_can_be_selected(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->assertSet('selectedSection', 'header')
            ->call('selectSection', 'hero')
            ->assertSet('selectedSection', 'hero')
            ->call('selectSection', 'services')
            ->assertSet('selectedSection', 'services')
            ->call('selectSection', 'footer')
            ->assertSet('selectedSection', 'footer')
            ->call('selectSection', 'invalid_unknown_section') // Should reject invalid sections
            ->assertSet('selectedSection', 'footer')
            ->call('selectSection', 'header')
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

    public function test_topbar_and_navbar_width_and_background_are_completely_independent(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('topbar_width', 'fluid')
            ->set('header_width', 'narrow')
            ->assertSet('topbar_width', 'fluid')
            ->assertSet('header_width', 'narrow')
            ->set('topbar_bg_type', 'solid_custom')
            ->set('header_bg_type', 'glass')
            ->assertSet('topbar_bg_type', 'solid_custom')
            ->assertSet('header_bg_type', 'glass')
            ->call('saveHeader')
            ->assertHasNoErrors();

        $this->assertEquals('fluid', Setting::get('header_topbar_width'));
        $this->assertEquals('narrow', Setting::get('header_width'));
        $this->assertEquals('solid_custom', Setting::get('header_topbar_bg_type'));
        $this->assertEquals('glass', Setting::get('header_bg_type'));

        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('max-w-6xl mx-auto px-4 sm:px-8');
    }

    public function test_admin_can_update_hero_banner_layout_and_backdrop(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->call('selectSection', 'hero')
            ->assertSet('selectedSection', 'hero')
            ->set('hero_width', 'ultrawide')
            ->set('hero_padding', 'compact')
            ->set('hero_bg_type', 'gradient')
            ->set('hero_gradient_dir', '135deg')
            ->set('hero_gradient_from', '#001122')
            ->set('hero_gradient_via', '')
            ->set('hero_gradient_to', '#334455')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('ultrawide', Setting::get('home_hero_width'));
        $this->assertEquals('compact', Setting::get('home_hero_padding'));
        $this->assertEquals('gradient', Setting::get('home_hero_bg_type'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('max-w-[1728px]');
        $frontend->assertSee('py-12 sm:py-16 lg:py-20');
        $frontend->assertSee('linear-gradient(135deg, #001122, #334455)', false);
    }

    public function test_admin_can_update_hero_content_and_badges(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_title_highlight_enabled', false)
            ->set('hero_badge1_text', 'Premier Turbocharger Center')
            ->set('hero_badge1_icon', 'solid:shield-check')
            ->set('hero_title', 'World Class Marine Engineering')
            ->set('hero_subtitle', 'Advanced rotating machinery diagnostics and dynamic balancing.')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('Premier Turbocharger Center', Setting::get('home_hero_badge1'));
        $this->assertEquals('World Class Marine Engineering', Setting::get('home_hero_title'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('Premier Turbocharger Center');
        $frontend->assertSee('World Class Marine Engineering');
        $frontend->assertSee('Advanced rotating machinery diagnostics and dynamic balancing.');
    }

    public function test_admin_can_update_hero_ctas_and_metrics(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_cta1_text', 'Get Urgent Quote')
            ->set('hero_cta1_url', '/contact#emergency')
            ->set('hero_metric1_value', '88,000')
            ->set('hero_metric1_label', 'High-Speed Balancing')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('Get Urgent Quote', Setting::get('home_hero_cta1_text'));
        $this->assertEquals('/contact#emergency', Setting::get('home_hero_cta1_url'));
        $this->assertEquals('88,000', Setting::get('home_metric1_value'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('Get Urgent Quote');
        $frontend->assertSee('/contact#emergency');
        $frontend->assertSee('88,000');
        $frontend->assertSee('High-Speed Balancing');
    }

    public function test_admin_can_update_hero_tachometer_and_hud(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_tacho_top', '0° / TEST_RPM')
            ->set('hero_hud_l1_val', 'TEST TURBINE UNIT')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('0° / TEST_RPM', Setting::get('home_hero_tacho_top'));
        $this->assertEquals('TEST TURBINE UNIT', Setting::get('home_hero_hud_l1_val'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('0° / TEST_RPM');
        $frontend->assertSee('TEST TURBINE UNIT');
    }

    public function test_admin_can_update_hero_column_split_order_and_alignment(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_column_split', '6_6')
            ->set('hero_column_order', 'visual_first')
            ->set('hero_alignment', 'center')
            ->set('home_scroll_animations', true)
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('6_6', Setting::get('home_hero_column_split'));
        $this->assertEquals('visual_first', Setting::get('home_hero_column_order'));
        $this->assertEquals('center', Setting::get('home_hero_alignment'));
        $this->assertEquals('1', Setting::get('theme_scroll_animations'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('lg:col-span-6');
        $frontend->assertSee('order-2');
        $frontend->assertSee('text-center');
        $frontend->assertSee('reveal-init');
    }

    public function test_admin_can_update_hero_multicolor_headline(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_title_highlight_enabled', true)
            ->set('hero_title_prefix', 'Next-Gen Turbochargers &')
            ->set('hero_title_highlight', 'Deep-Sea Marine Power')
            ->set('hero_title_suffix', 'Engineering Systems.')
            ->set('hero_title_highlight_style', 'gradient_amber')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('1', Setting::get('home_hero_title_highlight_enabled'));
        $this->assertEquals('Next-Gen Turbochargers &', Setting::get('home_hero_title_prefix'));
        $this->assertEquals('Deep-Sea Marine Power', Setting::get('home_hero_title_highlight'));
        $this->assertEquals('Engineering Systems.', Setting::get('home_hero_title_suffix'));
        $this->assertEquals('gradient_amber', Setting::get('home_hero_title_highlight_style'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('Next-Gen Turbochargers &');
        $frontend->assertSee('Deep-Sea Marine Power');
        $frontend->assertSee('Engineering Systems.');
        $frontend->assertSee('from-amber-400');
    }

    public function test_admin_can_update_extra_bullets_and_emergency_notice(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_bullets_enabled', true)
            ->set('hero_bullet1_enabled', true)
            ->set('hero_bullet1_text', 'Class-Certified Overhauls (DNV / Lloyd)')
            ->set('hero_notice_enabled', true)
            ->set('hero_notice_text', 'SPECIAL NOTICE: 24/7 Deep Sea Flying Squad Alert')
            ->set('hero_notice_url', '/contact#squad')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('1', Setting::get('home_hero_bullets_enabled'));
        $this->assertEquals('Class-Certified Overhauls (DNV / Lloyd)', Setting::get('home_hero_bullet1_text'));
        $this->assertEquals('1', Setting::get('home_hero_notice_enabled'));
        $this->assertEquals('SPECIAL NOTICE: 24/7 Deep Sea Flying Squad Alert', Setting::get('home_hero_notice_text'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('Class-Certified Overhauls (DNV / Lloyd)');
        $frontend->assertSee('SPECIAL NOTICE: 24/7 Deep Sea Flying Squad Alert');
        $frontend->assertSee('/contact#squad');
    }

    public function test_admin_can_update_turbine_visual_size_speed_and_readouts(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_visual_size', 'extra_large')
            ->set('hero_visual_bg_style', 'ambient_glow')
            ->set('hero_tacho_speed', 'boost')
            ->set('hero_tacho_direction', 'reverse')
            ->set('hero_tacho_center_enabled', true)
            ->set('hero_tacho_center_val', '120K')
            ->set('hero_tacho_center_label', 'PEAK SPEED')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('extra_large', Setting::get('home_hero_visual_size'));
        $this->assertEquals('ambient_glow', Setting::get('home_hero_visual_bg_style'));
        $this->assertEquals('boost', Setting::get('home_hero_tacho_speed'));
        $this->assertEquals('reverse', Setting::get('home_hero_tacho_direction'));
        $this->assertEquals('120K', Setting::get('home_hero_tacho_center_val'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('turbine-speed-boost');
        $frontend->assertSee('turbine-reverse');
        $frontend->assertSee('120K');
        $frontend->assertSee('PEAK SPEED');
    }

    public function test_admin_can_customize_hero_headline_typography_and_custom_gradient(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_title_size', 'extra_large')
            ->set('hero_title_weight', 'extrabold')
            ->set('hero_title_glow', 'cyan')
            ->set('hero_title_highlight_enabled', true)
            ->set('hero_title_prefix', 'Authorized')
            ->set('hero_title_highlight', 'Propulsion Overhauls')
            ->set('hero_title_suffix', 'Engineering')
            ->set('hero_title_highlight_style', 'gradient_custom')
            ->set('hero_title_grad_dir', 'to right')
            ->set('hero_title_grad_from', '#ff0077')
            ->set('hero_title_grad_via', '#7928ca')
            ->set('hero_title_grad_to', '#00dfd8')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('extra_large', Setting::get('home_hero_title_size'));
        $this->assertEquals('extrabold', Setting::get('home_hero_title_weight'));
        $this->assertEquals('cyan', Setting::get('home_hero_title_glow'));
        $this->assertEquals('gradient_custom', Setting::get('home_hero_title_highlight_style'));
        $this->assertEquals('to right', Setting::get('home_hero_title_grad_dir'));
        $this->assertEquals('#ff0077', Setting::get('home_hero_title_grad_from'));
        $this->assertEquals('#7928ca', Setting::get('home_hero_title_grad_via'));
        $this->assertEquals('#00dfd8', Setting::get('home_hero_title_grad_to'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('text-4xl sm:text-6xl lg:text-8xl');
        $frontend->assertSee('font-extrabold');
        $frontend->assertSee('drop-shadow-[0_4px_24px_rgba(6,182,212,0.45)]');
        $frontend->assertSee('linear-gradient(to right, #ff0077, #7928ca, #00dfd8)');
    }

    public function test_admin_can_customize_turbine_box_padding_and_notice_route_picker(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('hero_visual_padding', 'extra_spacious')
            ->set('hero_notice_enabled', true)
            ->set('hero_notice_text', 'Active Port Anchorage Alert')
            ->set('hero_notice_link_type', 'internal')
            ->set('hero_notice_url', '/contact')
            ->call('saveHero')
            ->assertHasNoErrors();

        $this->assertEquals('extra_spacious', Setting::get('home_hero_visual_padding'));
        $this->assertEquals('internal', Setting::get('home_hero_notice_link_type'));
        $this->assertEquals('/contact', Setting::get('home_hero_notice_url'));

        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('p-8 sm:p-12');
        $frontend->assertSee('Active Port Anchorage Alert');
        $frontend->assertSee('href="/contact"', false);
    }

    public function test_restore_production_design_restores_hero_banner_defaults(): void
    {
        $this->actingAs($this->admin);

        // Intentionally pollute hero settings
        Setting::set('home_hero_title', 'Polluted Title');
        Setting::set('home_metric1_value', '999');
        Setting::set('home_hero_column_split', '5_7');
        Setting::set('home_hero_visual_size', 'compact');
        Setting::set('home_hero_title_size', 'compact');
        Setting::set('home_hero_visual_padding', 'none');

        Livewire::test(HomepageBuilder::class)
            ->call('restoreProductionDesign')
            ->assertSet('hero_title', 'Precision Turbocharger Overhauls & Marine Propulsion Support.')
            ->assertSet('hero_metric1_value', '100,000')
            ->assertSet('hero_column_split', '7_5')
            ->assertSet('hero_visual_size', 'standard')
            ->assertSet('hero_title_size', 'standard')
            ->assertSet('hero_visual_padding', 'spacious');

        $this->assertEquals('Precision Turbocharger Overhauls & Marine Propulsion Support.', Setting::get('home_hero_title'));
        $this->assertEquals('100,000', Setting::get('home_metric1_value'));
        $this->assertEquals('7_5', Setting::get('home_hero_column_split'));
        $this->assertEquals('standard', Setting::get('home_hero_visual_size'));
        $this->assertEquals('standard', Setting::get('home_hero_title_size'));
        $this->assertEquals('spacious', Setting::get('home_hero_visual_padding'));
    }

    public function test_admin_can_reorder_homepage_sections_and_reset_order(): void
    {
        $this->actingAs($this->admin);

        $defaultOrder = HomepageBuilder::DEFAULT_SECTIONS_ORDER;
        $this->assertEquals('partners', $defaultOrder[0]);
        $this->assertEquals('about', $defaultOrder[1]);

        // Move partners down -> swap with about
        Livewire::test(HomepageBuilder::class)
            ->call('moveSectionDown', 'partners')
            ->assertSet('sectionsOrder.0', 'about')
            ->assertSet('sectionsOrder.1', 'partners');

        $stored = json_decode(Setting::get('home_sections_order'), true);
        $this->assertEquals('about', $stored[0]);
        $this->assertEquals('partners', $stored[1]);

        // Move partners back up -> restore order
        Livewire::test(HomepageBuilder::class)
            ->call('moveSectionUp', 'partners')
            ->assertSet('sectionsOrder.0', 'partners')
            ->assertSet('sectionsOrder.1', 'about');

        // Reset order
        Livewire::test(HomepageBuilder::class)
            ->call('resetSectionsOrder')
            ->assertSet('sectionsOrder', $defaultOrder);

        $storedAfterReset = json_decode(Setting::get('home_sections_order'), true);
        $this->assertEquals($defaultOrder, $storedAfterReset);
    }

    public function test_admin_can_toggle_section_visibility(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->assertSet('sectionsEnabled.partners', true)
            ->call('toggleSectionEnabled', 'partners')
            ->assertSet('sectionsEnabled.partners', false)
            ->assertSet('partners_enabled', false);

        $this->assertEquals('0', Setting::get('home_partners_enabled'));

        // Toggle back on
        Livewire::test(HomepageBuilder::class)
            ->call('toggleSectionEnabled', 'partners')
            ->assertSet('sectionsEnabled.partners', true)
            ->assertSet('partners_enabled', true);

        $this->assertEquals('1', Setting::get('home_partners_enabled'));
    }

    public function test_admin_can_customize_body_sections_and_footer(): void
    {
        $this->actingAs($this->admin);

        // Customize Partners & Services & Footer
        Livewire::test(HomepageBuilder::class)
            ->set('partners_tagline', 'Specialized Marine Turbocharger Engineering Alliance')
            ->set('partners_speed', 'fast')
            ->call('savePartners')
            ->set('services_badge', 'Advanced Port Services')
            ->set('services_title', 'Master Class Dynamic Overhauls')
            ->call('saveServices')
            ->set('footer_bio', 'Global Leader in Precision Maritime Turbomachinery Solutions.')
            ->set('footer_cert_text', 'ISO 9001:2015 & Lloyd\'s Register Approved')
            ->call('saveFooter');

        $this->assertEquals('Specialized Marine Turbocharger Engineering Alliance', Setting::get('home_partners_tagline'));
        $this->assertEquals('fast', Setting::get('home_partners_speed'));
        $this->assertEquals('Advanced Port Services', Setting::get('home_services_badge'));
        $this->assertEquals('Master Class Dynamic Overhauls', Setting::get('home_services_title'));
        $this->assertEquals('Global Leader in Precision Maritime Turbomachinery Solutions.', Setting::get('home_footer_bio'));
        $this->assertEquals('ISO 9001:2015 & Lloyd\'s Register Approved', Setting::get('home_footer_cert_text'));

        // Verify on frontend
        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('Specialized Marine Turbocharger Engineering Alliance');
        $frontend->assertSee('Advanced Port Services');
        $frontend->assertSee('Master Class Dynamic Overhauls');
        $frontend->assertSee('Global Leader in Precision Maritime Turbomachinery Solutions.');
        $frontend->assertSee('ISO 9001:2015 & Lloyd\'s Register Approved');
    }

    public function test_admin_can_toggle_dynamic_vs_static_content_modes(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('services_title', 'Precision Overhaul Services')
            ->set('services_mode', 'dynamic')
            ->set('services_limit', 4)
            ->call('saveServices');

        $this->assertEquals('dynamic', Setting::get('home_services_mode'));
        $this->assertEquals('4', Setting::get('home_services_limit'));

        // When dynamic table is empty, frontend still renders without 500 error
        $frontend = $this->get('/');
        $frontend->assertStatus(200);
        $frontend->assertSee('Precision Overhaul Services');
    }

    public function test_restore_production_design_restores_all_sections_and_footer(): void
    {
        $this->actingAs($this->admin);

        // Intentionally pollute multiple sections
        Setting::set('home_partners_tagline', 'Polluted Partners');
        Setting::set('home_services_title', 'Polluted Services');
        Setting::set('home_footer_bio', 'Polluted Footer');

        Livewire::test(HomepageBuilder::class)
            ->call('restoreProductionDesign')
            ->assertSet('partners_tagline', 'Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms')
            ->assertSet('services_title', 'Precision Overhaul Services')
            ->assertSet('footer_cert_text', 'ISO 9001:2015 & DNV Certified');

        $this->assertEquals('Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms', Setting::get('home_partners_tagline'));
        $this->assertEquals('Precision Overhaul Services', Setting::get('home_services_title'));
        $this->assertEquals('ISO 9001:2015 & DNV Certified', Setting::get('home_footer_cert_text'));
    }

    public function test_admin_can_configure_universal_section_styler(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('sectionStylers.services.bg_type', 'gradient')
            ->set('sectionStylers.services.gradient_dir', 'to bottom right')
            ->set('sectionStylers.services.gradient_from', '#003C58')
            ->set('sectionStylers.services.gradient_to', '#0f172a')
            ->set('sectionStylers.services.width', 'narrow')
            ->set('sectionStylers.services.padding', 'spacious')
            ->set('sectionStylers.services.align', 'center')
            ->call('saveServices')
            ->assertHasNoErrors();

        $this->assertEquals('gradient', Setting::get('home_services_bg_type'));
        $this->assertEquals('to bottom right', Setting::get('home_services_gradient_dir'));
        $this->assertEquals('#003C58', Setting::get('home_services_gradient_from'));
        $this->assertEquals('#0f172a', Setting::get('home_services_gradient_to'));
        $this->assertEquals('narrow', Setting::get('home_services_width'));
        $this->assertEquals('spacious', Setting::get('home_services_padding'));
        $this->assertEquals('center', Setting::get('home_services_align'));

        // Frontend renders with styling
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('to bottom right');
    }

    public function test_admin_can_manage_static_items_repeaters(): void
    {
        $this->actingAs($this->admin);

        $testComponent = Livewire::test(HomepageBuilder::class)
            ->call('addStaticService')
            ->set('services_static_items.6.title', 'Subsea Dynamic Balancing')
            ->set('services_static_items.6.category', 'SUBSEA')
            ->set('services_static_items.6.excerpt', 'Specialized underwater high-speed balancing services.')
            ->call('saveServices');

        $savedServices = Setting::getJson('home_services_static_items');
        $this->assertCount(7, $savedServices);
        $this->assertEquals('Subsea Dynamic Balancing', $savedServices[6]['title']);

        // Remove item
        $testComponent->call('removeStaticService', 6)
            ->call('saveServices');

        $savedAfterRemoval = Setting::getJson('home_services_static_items');
        $this->assertCount(6, $savedAfterRemoval);

        // Parts static items
        $testComponent->call('addStaticPart')
            ->set('parts_static_items.6.name', 'Ceramic Bearing Set')
            ->set('parts_static_items.6.part_number', 'CR-9000-X')
            ->call('saveParts');

        $savedParts = Setting::getJson('home_parts_static_items');
        $this->assertCount(7, $savedParts);
        $this->assertEquals('Ceramic Bearing Set', $savedParts[6]['name']);
    }

    public function test_admin_can_create_customize_and_delete_custom_sections(): void
    {
        $this->actingAs($this->admin);

        $test = Livewire::test(HomepageBuilder::class)
            ->call('openAddSectionModal')
            ->assertSet('showAddSectionModal', true)
            ->set('newSectionType', 'cta_banner')
            ->set('newSectionTitle', 'Emergency Flying Squad Standby')
            ->call('addCustomSection')
            ->assertSet('showAddSectionModal', false);

        $customSections = Setting::getJson('home_custom_sections');
        $this->assertCount(1, $customSections);
        $secId = array_key_first($customSections);
        $this->assertEquals('Emergency Flying Squad Standby', $customSections[$secId]['title']);
        $this->assertEquals('cta_banner', $customSections[$secId]['type']);

        // Check it was added to sections order
        $order = Setting::getJson('home_sections_order');
        $this->assertContains($secId, $order);

        // Customize the custom section
        $test->set("customSections.{$secId}.badge", 'IMMEDIATE DISPATCH')
            ->set("customSections.{$secId}.button1_text", 'Call Duty Engineer')
            ->call('saveCustomSection', $secId);

        $updatedCustom = Setting::getJson('home_custom_sections');
        $this->assertEquals('IMMEDIATE DISPATCH', $updatedCustom[$secId]['badge']);
        $this->assertEquals('Call Duty Engineer', $updatedCustom[$secId]['button1_text']);

        // Frontend renders custom section
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Emergency Flying Squad Standby');
        $response->assertSee('IMMEDIATE DISPATCH');

        // Delete custom section
        $test->call('removeCustomSection', $secId);

        $afterDelete = Setting::getJson('home_custom_sections');
        $this->assertEmpty($afterDelete);

        $orderAfterDelete = Setting::getJson('home_sections_order');
        $this->assertNotContains($secId, $orderAfterDelete);
    }

    public function test_admin_can_configure_enhanced_corporate_footer(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomepageBuilder::class)
            ->set('footer_show_logo', true)
            ->set('footer_logo_type', 'site')
            ->set('footer_logo_height', 48)
            ->set('footer_col1_enabled', true)
            ->set('footer_col2_enabled', true)
            ->set('footer_col2_title', 'Engine Components')
            ->set('footer_col2_mode', 'custom')
            ->set('footer_col2_links', [
                ['label' => 'Rotor Assemblies', 'url' => '/products#rotors'],
                ['label' => 'Nozzle Rings', 'url' => '/products#nozzles'],
            ])
            ->set('footer_col3_enabled', false)
            ->set('footer_col4_enabled', true)
            ->set('footer_show_phone', true)
            ->set('footer_phone', '+880 1711-223344')
            ->set('footer_show_email', true)
            ->set('footer_email', 'superintendent@nordroy.com')
            ->call('saveFooter')
            ->assertHasNoErrors();

        $this->assertEquals('48', Setting::get('home_footer_logo_height'));
        $this->assertEquals('Engine Components', Setting::get('home_footer_col2_title'));
        $this->assertEquals('0', Setting::get('home_footer_col3_enabled'));
        $this->assertEquals('+880 1711-223344', Setting::get('home_footer_phone'));
        $this->assertEquals('superintendent@nordroy.com', Setting::get('home_footer_email'));

        // Frontend verification
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Engine Components');
        $response->assertSee('Rotor Assemblies');
        $response->assertSee('Nozzle Rings');
        $response->assertSee('+880 1711-223344');
        $response->assertSee('superintendent@nordroy.com');
    }

    public function test_settings_are_cached_in_memory_and_cleared_on_update(): void
    {
        $this->actingAs($this->admin);

        // Initial fetch primes cache
        $val1 = Setting::get('site_name', 'Nordroy Marine');
        $this->assertEquals('Nordroy Marine', $val1);

        // Update via Setting::set() automatically flushes cache
        Setting::set('site_name', 'Nordroy Global Marine');
        $val2 = Setting::get('site_name');
        $this->assertEquals('Nordroy Global Marine', $val2);
    }
}
