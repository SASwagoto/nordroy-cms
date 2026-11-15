<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Theme\HeaderFooterBuilder;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HeaderFooterBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $role = Role::firstOrCreate(['name' => 'Super Administrator']);
        $permission = Permission::firstOrCreate(['name' => 'theme.manage']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        $this->admin->givePermissionTo('theme.manage');
    }

    public function test_header_footer_builder_page_is_accessible_to_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.header-footer'));
        $response->assertStatus(200);
        $response->assertSee('Header &amp; Footer Builder', false);
        $response->assertSee('Header Builder (3 Rows)');
        $response->assertSee('Footer Builder (3 Rows)');
    }

    public function test_header_builder_renders_three_independent_rows_and_box_models(): void
    {
        Livewire::actingAs($this->admin)
            ->test(HeaderFooterBuilder::class)
            ->assertSet('activeMode', 'header')
            ->assertSee('Row 1: Top Emergency &amp; Information Strip', false)
            ->assertSee('Row 2: Main Header Navbar')
            ->assertSee('Row 3: Bottom Sub-Header Bar')
            ->assertSee('Topbar Layout & Box Model (Independent Row 1)')
            ->assertSee('Header Navbar Layout & Box Model (Independent Row 2)')
            ->set('headerBottom.enabled', true)
            ->assertSee('Sub-Header Layout & Box Model (Independent Row 3)');
    }

    public function test_footer_builder_renders_three_independent_rows_and_modular_columns(): void
    {
        Livewire::actingAs($this->admin)
            ->test(HeaderFooterBuilder::class)
            ->set('activeMode', 'footer')
            ->assertSee('Row 1: Top Pre-Footer Callout Bar')
            ->assertSee('Row 2: Main Modular Footer Columns')
            ->assertSee('Row 3: Bottom Sub-Footer / Copyright Strip')
            ->assertSee('Pre-Footer Layout & Box Model (Independent Row 1)')
            ->assertSee('Main Footer Layout & Box Model (Independent Row 2)')
            ->assertSee('Sub-Footer Layout & Box Model (Independent Row 3)');
    }

    public function test_header_footer_builder_saves_independent_widths_and_colors(): void
    {
        $customTopbarBox = [
            'padding' => ['mode' => 'axis', 'y' => '12px', 'x' => '32px'],
            'width'   => '100%',
        ];

        $customHeaderBox = [
            'padding' => ['mode' => 'axis', 'y' => '0px', 'x' => '40px'],
            'width'   => '1440px',
        ];

        $customFooterBox = [
            'padding' => ['mode' => 'axis', 'y' => '80px', 'x' => '32px'],
            'width'   => '1280px',
        ];

        $customHeaderBg = [
            'mode'    => 'custom',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#0c1e30',
            'opacity' => 95,
        ];

        Livewire::actingAs($this->admin)
            ->test(HeaderFooterBuilder::class)
            ->set('topbarBoxModel', $customTopbarBox)
            ->set('headerBoxModel', $customHeaderBox)
            ->set('footerBoxModel', $customFooterBox)
            ->set('headerBgColor', $customHeaderBg)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Header and Footer configuration successfully synchronized and published across the website.');

        $this->assertEquals('100%', Setting::getJson('topbar_box_model')['width']);
        $this->assertEquals('1440px', Setting::getJson('header_box_model')['width']);
        $this->assertEquals('1280px', Setting::getJson('footer_box_model')['width']);
        $this->assertEquals('#0c1e30', Setting::getJson('header_bg_color')['dark']);
    }
}
