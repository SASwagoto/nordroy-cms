<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Pages\PageBuilder;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PageBuilderTest extends TestCase
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

    public function test_builder_page_is_accessible_to_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.builder'));
        $response->assertStatus(200);
        $response->assertSee('Storefront Customizer &amp; Sections CMS', false);
        $response->assertSee('Header (Global Multi-Row)');
        $response->assertSee('Global Store Footer');
    }

    public function test_builder_renders_left_panel_sections_and_fixed_cards(): void
    {
        Livewire::actingAs($this->admin)
            ->test(PageBuilder::class)
            ->assertSet('selectedSectionId', 'header')
            ->assertSee('Header (Global Multi-Row)')
            ->assertSee('FIXED')
            ->assertSee('Hero Banner')
            ->assertSee('Global Store Footer')
            ->assertSee('Add New Section');
    }

    public function test_builder_can_switch_between_header_hero_section_and_footer(): void
    {
        $component = Livewire::actingAs($this->admin)
            ->test(PageBuilder::class)
            ->assertSet('selectedSectionId', 'header')
            ->assertSee('Global Website Header')
            ->call('selectSection', 'hero')
            ->assertSet('selectedSectionId', 'hero')
            ->assertSee('Hero Layout &amp; Ambient Surface', false)
            ->call('selectSection', 'footer')
            ->assertSet('selectedSectionId', 'footer')
            ->assertSee('Global Website Footer');

        // Select first body section if exists
        $sections = $component->get('sections');
        if (!empty($sections)) {
            $firstId = (string)$sections[0]['id'];
            $component->call('selectSection', $firstId)
                ->assertSet('selectedSectionId', $firstId)
                ->assertSee('Universal Layout &amp; Surface', false);
        }
    }

    public function test_builder_can_toggle_section_visibility(): void
    {
        $component = Livewire::actingAs($this->admin)
            ->test(PageBuilder::class)
            ->assertSet('heroEnabled', true)
            ->call('toggleSectionStatus', 'hero')
            ->assertSet('heroEnabled', false)
            ->call('toggleSectionStatus', 'hero')
            ->assertSet('heroEnabled', true);
    }

    public function test_builder_can_add_and_delete_a_section(): void
    {
        $component = Livewire::actingAs($this->admin)
            ->test(PageBuilder::class);

        $initialCount = count($component->get('sections'));

        $component->call('openCreateModal')
            ->assertSet('showCreateModal', true)
            ->set('newSectionType', 'faq')
            ->set('newSectionTitle', 'Custom Marine Questions')
            ->call('addSection')
            ->assertSet('showCreateModal', false);

        $newCount = count($component->get('sections'));
        $this->assertEquals($initialCount + 1, $newCount);

        // Delete newly added section
        $sections = $component->get('sections');
        $lastSec = end($sections);
        $component->call('deleteSection', (string)$lastSec['id']);

        $afterDeleteCount = count($component->get('sections'));
        $this->assertEquals($initialCount, $afterDeleteCount);
    }

    public function test_builder_can_save_and_persist_settings(): void
    {
        Livewire::actingAs($this->admin)
            ->test(PageBuilder::class)
            ->set('headerStyle', 'glass')
            ->set('heroTitle', 'Nordroy Extreme Marine Turbochargers')
            ->call('save')
            ->assertSee('Page sections and theme architecture saved and published successfully.');

        $this->assertEquals('glass', Setting::get('theme_header_style'));
        $heroData = Setting::getJson('hero_banner_settings');
        $this->assertEquals('Nordroy Extreme Marine Turbochargers', $heroData['title'] ?? '');
    }
}
