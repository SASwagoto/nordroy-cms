<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Theme\ThemeStudio;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ModularFooterTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_theme_studio_renders_modular_footer_builder(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ThemeStudio::class)
            ->set('activeTab', 'footer')
            ->assertSee('Footer Columns & Content Modules')
            ->assertSee('Sub-Footer & Copyright Bar Architecture')
            ->assertSee('Add Column')
            ->assertSee('Presets:');
    }

    public function test_modular_footer_columns_can_be_added_modified_and_saved(): void
    {
        $customColumns = [
            [
                'id'       => 'col_info',
                'title'    => 'Nordroy Engineering',
                'type'     => 'company_info',
                'span'     => 2,
                'content'  => [
                    'show_logo'   => true,
                    'bio'         => 'Specialized marine turbocharger overhaul group.',
                    'show_social' => true,
                    'show_phone'  => true,
                ],
            ],
            [
                'id'       => 'col_links',
                'title'    => 'Quick Links',
                'type'     => 'static_list',
                'span'     => 1,
                'content'  => [
                    'items' => [
                        ['text' => 'Custom Services', 'url' => '/services'],
                        ['text' => 'Direct Hotline', 'url' => '/contact'],
                    ],
                ],
            ],
            [
                'id'       => 'col_news',
                'title'    => 'Newsletter Bulletin',
                'type'     => 'newsletter',
                'span'     => 1,
                'content'  => [
                    'description' => 'Subscribe to technical maritime bulletins',
                    'placeholder' => 'Enter maritime email...',
                    'button_text' => 'Join Now',
                ],
            ],
        ];

        $customBottomColumns = [
            [
                'id'      => 'bot_copy',
                'type'    => 'copyright',
                'content' => [
                    'text' => '© {year} {site_name}. Custom Modular Footer Test.',
                ],
            ],
            [
                'id'      => 'bot_badge',
                'type'    => 'badges',
                'content' => [
                    'iso_text'   => 'DNV Class A Certified',
                    'show_login' => true,
                    'login_text' => 'Admin Access',
                ],
            ],
        ];

        Livewire::actingAs($this->admin)
            ->test(ThemeStudio::class)
            ->set('footerColumns', $customColumns)
            ->set('footerBottomColumns', $customBottomColumns)
            ->set('headerBorderWidth', '2px')
            ->set('headerBorderSpan', 'full')
            ->set('headerBorderColor', '#0ea5e9')
            ->call('saveThemeTokens')
            ->assertHasNoErrors();

        $savedColumns = Setting::getJson('footer_columns');
        $this->assertCount(3, $savedColumns);
        $this->assertEquals('Nordroy Engineering', $savedColumns[0]['title']);
        $this->assertEquals('company_info', $savedColumns[0]['type']);
        $this->assertEquals(2, $savedColumns[0]['span']);
        $this->assertEquals('Newsletter Bulletin', $savedColumns[2]['title']);

        $savedBottom = Setting::getJson('footer_bottom_columns');
        $this->assertCount(2, $savedBottom);
        $this->assertEquals('copyright', $savedBottom[0]['type']);

        $this->assertEquals('2px', Setting::get('header_border_width'));
        $this->assertEquals('full', Setting::get('header_border_span'));
        $this->assertEquals('#0ea5e9', Setting::get('header_border_color'));
    }

    public function test_frontend_renders_modular_footer_widgets(): void
    {
        Setting::set('site_name', 'Nordroy Marine Group');
        Setting::set('footer_columns', [
            [
                'id'       => 'col_test',
                'title'    => 'Modular Port Workshop',
                'type'     => 'contact_offices',
                'span'     => 1,
                'content'  => [
                    'port_title'     => 'Dockside Facility:',
                    'port_address'   => 'Berth 12, Chattogram Drydock',
                    'show_emergency' => true,
                ],
            ],
            [
                'id'       => 'col_list',
                'title'    => 'Direct Navigation',
                'type'     => 'static_list',
                'span'     => 1,
                'content'  => [
                    'items' => [
                        ['text' => 'Emergency Squad Protocol', 'url' => '/protocol'],
                    ],
                ],
            ],
        ], 'footer', 'json');

        Setting::set('footer_bottom_columns', [
            [
                'id'      => 'bot_test',
                'type'    => 'copyright',
                'content' => [
                    'text' => 'Copyright {year} {site_name}. Tested Output.',
                ],
            ],
        ], 'footer', 'json');

        $response = $this->get('/');
        $response->assertStatus(200);

        // Main modular columns
        $response->assertSee('Modular Port Workshop');
        $response->assertSee('Dockside Facility:');
        $response->assertSee('Berth 12, Chattogram Drydock');
        $response->assertSee('Direct Navigation');
        $response->assertSee('Emergency Squad Protocol');

        // Sub-footer token replacement
        $currentYear = date('Y');
        $response->assertSee("Copyright {$currentYear} Nordroy Marine Group. Tested Output.");
    }
}
