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

    public function test_header_builder_renders_master_section_and_three_rows(): void
    {
        Livewire::actingAs($this->admin)
            ->test(HeaderFooterBuilder::class)
            ->assertSet('activeMode', 'header')
            ->assertSee('Main Outer Header Section (Master Wrapper)')
            ->assertSee('Master Header Section Box Model &amp; Spacing', false)
            ->assertSee('Master Header Section Background')
            ->call('selectHeaderRow', 'row1')
            ->assertSee('Row 1: Top Emergency &amp; Information Strip', false)
            ->assertSee('Topbar Layout &amp; Box Model (Independent Row 1)', false)
            ->call('selectHeaderRow', 'row2')
            ->assertSee('Row 2: Main Header Navbar')
            ->assertSee('Header Navbar Layout &amp; Box Model (Independent Row 2)', false)
            ->call('selectHeaderRow', 'row3')
            ->assertSee('Row 3: Bottom Sub-Header Bar')
            ->assertSee('Sub-Header Layout &amp; Box Model (Independent Row 3)', false);
    }

    public function test_footer_builder_renders_master_section_and_three_rows(): void
    {
        Livewire::actingAs($this->admin)
            ->test(HeaderFooterBuilder::class)
            ->set('activeMode', 'footer')
            ->assertSee('Main Outer Footer Section (Master Wrapper)')
            ->assertSee('Master Footer Section Box Model &amp; Spacing', false)
            ->assertSee('Master Footer Section Background')
            ->call('selectFooterRow', 'row1')
            ->assertSee('Row 1: Top Pre-Footer Callout Bar')
            ->assertSee('Pre-Footer Layout &amp; Box Model (Independent Row 1)', false)
            ->call('selectFooterRow', 'row2')
            ->assertSee('Row 2: Main Modular Footer Columns')
            ->assertSee('Main Footer Layout &amp; Box Model (Independent Row 2)', false)
            ->call('selectFooterRow', 'row3')
            ->assertSee('Row 3: Bottom Sub-Footer / Copyright Strip')
            ->assertSee('Sub-Footer Layout &amp; Box Model (Independent Row 3)', false);
    }

    public function test_header_footer_builder_saves_master_sections_and_independent_rows(): void
    {
        $customHeaderSectionBox = [
            'width'   => '100%',
            'padding' => ['mode' => 'axis', 'y' => '4px', 'x' => '0px'],
        ];

        $customHeaderSectionBg = [
            'mode'    => 'custom',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#050f18',
            'opacity' => 100,
        ];

        $customFooterSectionBox = [
            'width'   => '100%',
            'padding' => ['mode' => 'axis', 'y' => '8px', 'x' => '0px'],
        ];

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

        Livewire::actingAs($this->admin)
            ->test(HeaderFooterBuilder::class)
            ->set('headerSectionBoxModel', $customHeaderSectionBox)
            ->set('headerSectionBgColor', $customHeaderSectionBg)
            ->set('footerSectionBoxModel', $customFooterSectionBox)
            ->set('topbarBoxModel', $customTopbarBox)
            ->set('headerBoxModel', $customHeaderBox)
            ->set('footerBoxModel', $customFooterBox)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Header and Footer configuration successfully synchronized and published across the website.');

        $this->assertEquals('100%', Setting::getJson('header_section_box_model')['width']);
        $this->assertEquals('#050f18', Setting::getJson('header_section_bg_color')['dark']);
        $this->assertEquals('100%', Setting::getJson('footer_section_box_model')['width']);
        $this->assertEquals('100%', Setting::getJson('topbar_box_model')['width']);
        $this->assertEquals('1440px', Setting::getJson('header_box_model')['width']);
        $this->assertEquals('1280px', Setting::getJson('footer_box_model')['width']);
    }
}
