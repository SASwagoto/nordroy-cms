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
            ->assertSee('হেডার কল-টু-অ্যাকশন (CTA) বাটন')
            ->assertSee('বাটনের গন্তব্য লিঙ্ক (Button Destination Link)')
            ->assertSee('Header Background Color')
            ->assertSee('Theme Default (থিম ডিফল্ট)')
            ->assertSee('Custom Color (কাস্টম মোড)');
    }

    public function test_theme_studio_custom_header_color_and_cta_can_be_saved(): void
    {
        $customColor = [
            'mode'    => 'custom',
            'light'   => '#10b981',
            'dark'    => '#064e3b',
            'opacity' => 90,
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
            ->set('headerCta', $customCta)
            ->call('saveThemeTokens')
            ->assertHasNoErrors();

        $savedColor = Setting::getJson('header_bg_color');
        $this->assertEquals('custom', $savedColor['mode']);
        $this->assertEquals('#10b981', $savedColor['light']);
        $this->assertEquals('#064e3b', $savedColor['dark']);
        $this->assertEquals(90, $savedColor['opacity']);

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
        $response->assertSee('smart-custom-header-bg');
        $response->assertSee('Request Instant RFQ');
    }
}
