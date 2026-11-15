<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Theme\ThemeStudio;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ThemeStudioHeaderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_theme_studio_renders_header_tab_and_cta_destination_controls(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ThemeStudio::class)
            ->set('activeTab', 'header')
            ->assertSee('Header Call to Action (CTA) Button')
            ->assertSee('Button Destination Link')
            ->assertSee('Header Background Color')
            ->assertSee('Header Text & Navigation Links Color')
            ->assertSee('Topbar Background Color')
            ->assertSee('Theme Default')
            ->assertSee('Custom Dual Mode');
    }

    public function test_theme_studio_custom_header_color_and_cta_can_be_saved(): void
    {
        $customColor = [
            'mode'    => 'custom',
            'light'   => '#10b981',
            'dark'    => '#064e3b',
            'opacity' => 90,
        ];

        $customTextColor = [
            'mode'    => 'custom',
            'light'   => '#ffffff',
            'dark'    => '#10b981',
            'opacity' => 100,
        ];

        $customTopbar = [
            'enabled'           => true,
            'badge_text'        => 'Custom Marine Squad 24/7',
            'subtext'           => 'Turbocharger Emergency Hotline',
            'show_badge'        => true,
            'show_phone'        => true,
            'phone'             => '+880 1999-111222',
            'show_email'        => true,
            'email'             => 'duty@nordroy.com',
            'show_social'       => true,
            'show_custom_link'  => true,
            'custom_link_text'  => 'Track Vessel',
            'custom_link_url'   => 'https://nordroy.com/track',
            'custom_link_blank' => true,
            'admin_link'        => true,
            'alignment'         => 'between',
            'density'           => 'compact',
            'bg_color'          => ['mode' => 'custom', 'light' => '#f1f5f9', 'dark' => '#0f172a', 'opacity' => 95],
            'text_color'        => ['mode' => 'custom', 'light' => '#0f172a', 'dark' => '#f8fafc', 'opacity' => 100],
        ];

        $customCta = [
            'enabled'   => true,
            'label'     => 'Get Custom Quote',
            'link'      => [
                'type'         => 'internal',
                'page'         => 'contact',
                'section'      => 'rfq',
                'target_blank' => false,
            ],
            'show_icon' => true,
        ];

        Livewire::actingAs($this->admin)
            ->test(ThemeStudio::class)
            ->set('headerBgColor', $customColor)
            ->set('headerTextColor', $customTextColor)
            ->set('headerTopbar', $customTopbar)
            ->set('headerCta', $customCta)
            ->call('saveThemeTokens')
            ->assertHasNoErrors();

        $savedColor = Setting::getJson('header_bg_color');
        $this->assertEquals('custom', $savedColor['mode']);
        $this->assertEquals('#10b981', $savedColor['light']);
        $this->assertEquals('#064e3b', $savedColor['dark']);
        $this->assertEquals(90, $savedColor['opacity']);

        $savedTextColor = Setting::getJson('header_text_color');
        $this->assertEquals('custom', $savedTextColor['mode']);
        $this->assertEquals('#ffffff', $savedTextColor['light']);
        $this->assertEquals('#10b981', $savedTextColor['dark']);

        $savedTopbar = Setting::getJson('header_topbar');
        $this->assertEquals('Custom Marine Squad 24/7', $savedTopbar['badge_text']);
        $this->assertEquals('+880 1999-111222', $savedTopbar['phone']);
        $this->assertEquals('Track Vessel', $savedTopbar['custom_link_text']);

        $savedCta = Setting::getJson('header_cta');
        $this->assertEquals('Get Custom Quote', $savedCta['label']);
        $this->assertEquals('contact', $savedCta['link']['page']);
        $this->assertEquals('rfq', $savedCta['link']['section']);
    }

    public function test_frontend_renders_custom_header_bg_css_variables_and_cta(): void
    {
        Setting::set('header_bg_color', [
            'mode'    => 'custom',
            'light'   => '#123456',
            'dark'    => '#654321',
            'opacity' => 85,
        ], 'header', 'json');

        Setting::set('header_text_color', [
            'mode'    => 'custom',
            'light'   => '#fafafa',
            'dark'    => '#112233',
            'opacity' => 100,
        ], 'header', 'json');

        Setting::set('header_topbar', [
            'enabled'           => true,
            'badge_text'        => 'Global Vessel Hotline 24/7',
            'subtext'           => 'Overhaul Squads',
            'show_badge'        => true,
            'show_phone'        => true,
            'phone'             => '+880 1700-000000',
            'show_email'        => true,
            'email'             => 'marine@nordroy.com',
            'show_social'       => false,
            'show_custom_link'  => true,
            'custom_link_text'  => 'Vessel Portal',
            'custom_link_url'   => 'https://example.com/vessel',
            'custom_link_blank' => true,
            'admin_link'        => true,
            'alignment'         => 'between',
            'density'           => 'standard',
            'bg_color'          => ['mode' => 'theme'],
            'text_color'        => ['mode' => 'theme'],
        ], 'header', 'json');

        Setting::set('header_cta', [
            'enabled'   => true,
            'label'     => 'Request Instant RFQ',
            'link'      => ['type' => 'internal', 'page' => 'contact', 'section' => 'rfq', 'target_blank' => false],
            'show_icon' => true,
        ], 'header', 'json');

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('--header-bg-light:');
        $response->assertSee('--header-bg-dark:');
        $response->assertSee('--header-text-light:');
        $response->assertSee('--header-text-dark:');
        $response->assertSee('smart-custom-header-bg');
        $response->assertSee('smart-custom-header-text');
        $response->assertSee('Global Vessel Hotline 24/7');
        $response->assertSee('Vessel Portal');
        $response->assertSee('Request Instant RFQ');
    }

    public function test_theme_studio_renders_footer_tab_and_box_model_controls(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ThemeStudio::class)
            ->set('activeTab', 'footer')
            ->assertSee('Footer Colors & Appearance')
            ->assertSee('Footer Background Color')
            ->assertSee('Footer Text & Links Color')
            ->assertSee('Footer Box Model & Spacing Engine')
            ->assertSee('Footer Columns & Content Modules')
            ->assertSee('Show Social Media Icons')
            ->assertSee('Show Business Units Column')
            ->assertSee('Show Technical Services Column');
    }

    public function test_theme_studio_saves_topbar_box_model_footer_and_section_box_model(): void
    {
        $customTopbarBox = [
            'padding' => [
                'mode' => 'axis',
                'y'    => '10px',
                'x'    => '20px',
            ],
            'border' => [
                'enabled' => true,
                'width'   => '2px',
                'side'    => 'bottom',
                'style'   => 'solid',
                'color'   => '#0ea5e9',
            ],
        ];

        $customFooterBg = [
            'mode'    => 'custom',
            'light'   => '#0f172a',
            'dark'    => '#020617',
            'opacity' => 95,
        ];

        $customFooterBox = [
            'padding' => [
                'mode' => 'axis',
                'y'    => '72px',
                'x'    => '32px',
            ],
            'border' => [
                'enabled' => true,
                'width'   => '1px',
                'side'    => 'top',
                'style'   => 'solid',
                'color'   => '#334155',
            ],
        ];

        $customSectionBox = [
            'padding' => [
                'mode' => 'axis',
                'y'    => '112px',
                'x'    => '32px',
            ],
            'width' => '1600px',
        ];

        Livewire::actingAs($this->admin)
            ->test(ThemeStudio::class)
            ->set('topbarBoxModel', $customTopbarBox)
            ->set('footerBgColor', $customFooterBg)
            ->set('footerBoxModel', $customFooterBox)
            ->set('sectionBoxModel', $customSectionBox)
            ->call('saveThemeTokens')
            ->assertHasNoErrors();

        $savedTopbarBox = Setting::getJson('topbar_box_model');
        $this->assertEquals('10px', $savedTopbarBox['padding']['y']);
        $this->assertEquals('20px', $savedTopbarBox['padding']['x']);

        $savedFooterBg = Setting::getJson('footer_bg_color');
        $this->assertEquals('custom', $savedFooterBg['mode']);
        $this->assertEquals('#0f172a', $savedFooterBg['light']);

        $savedFooterBox = Setting::getJson('footer_box_model');
        $this->assertEquals('72px', $savedFooterBox['padding']['y']);

        $savedSectionBox = Setting::getJson('section_box_model');
        $this->assertEquals('112px', $savedSectionBox['padding']['y']);
        $this->assertEquals('1600px', Setting::get('theme_container_width'));
        $this->assertEquals('112px', Setting::get('theme_section_padding'));
    }

    public function test_frontend_renders_full_viewport_seamless_video_backdrop_and_footer_custom_styles(): void
    {
        Setting::set('site_bg_video_enabled', '1');
        Setting::set('theme_hero_backdrop', 'frosted');
        Setting::set('footer_bg_color', [
            'mode'    => 'custom',
            'light'   => '#1e293b',
            'dark'    => '#0b131f',
            'opacity' => 95,
        ], 'footer', 'json');

        Setting::set('footer_text_color', [
            'mode'    => 'custom',
            'light'   => '#ffffff',
            'dark'    => '#e2e8f0',
            'opacity' => 100,
        ], 'footer', 'json');

        $response = $this->get('/');
        $response->assertStatus(200);
        // Seamless video glaze is rendered directly on video container
        $response->assertSee('backdrop-blur-md');
        // Footer custom colors
        $response->assertSee('--footer-bg-light:');
        $response->assertSee('--footer-bg-dark:');
        $response->assertSee('--footer-text-light:');
        $response->assertSee('--footer-text-dark:');
        $response->assertSee('smart-custom-footer-bg');
    }
}
