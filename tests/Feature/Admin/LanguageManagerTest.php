<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Languages\LanguageManager;
use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LanguageManagerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'Super Administrator']);
        $permission = Permission::firstOrCreate(['name' => 'settings.manage']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        $this->admin->givePermissionTo('settings.manage');

        Language::firstOrCreate(['code' => 'en'], [
            'name' => 'English',
            'native_name' => 'English',
            'direction' => 'ltr',
            'flag_icon' => '🇬🇧',
            'is_default' => true,
            'is_active' => true,
            'order' => 1,
        ]);
        Language::firstOrCreate(['code' => 'bn'], [
            'name' => 'Bengali',
            'native_name' => 'বাংলা',
            'direction' => 'ltr',
            'flag_icon' => '🇧🇩',
            'is_default' => false,
            'is_active' => true,
            'order' => 2,
        ]);
    }

    public function test_languages_manager_page_is_accessible_by_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.languages'));
        $response->assertStatus(200);
        $response->assertSee('Localization &amp; Languages', false);
        $response->assertSee('Add New Language');
    }

    public function test_admin_can_create_new_language(): void
    {
        Livewire::actingAs($this->admin)
            ->test(LanguageManager::class)
            ->call('createLanguage')
            ->set('name', 'Arabic')
            ->set('code', 'ar')
            ->set('native_name', 'العربية')
            ->set('direction', 'rtl')
            ->set('flag_icon', '🇸🇦')
            ->set('is_active', true)
            ->call('saveLanguage')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('languages', [
            'code' => 'ar',
            'name' => 'Arabic',
            'direction' => 'rtl',
            'flag_icon' => '🇸🇦',
        ]);
    }

    public function test_admin_can_toggle_language_status(): void
    {
        $bn = Language::where('code', 'bn')->first();
        $this->assertTrue((bool) $bn->is_active);

        Livewire::actingAs($this->admin)
            ->test(LanguageManager::class)
            ->call('toggleActive', $bn->id)
            ->assertHasNoErrors();

        $bn->refresh();
        $this->assertFalse((bool) $bn->is_active);
    }

    public function test_admin_can_set_default_language(): void
    {
        $bn = Language::where('code', 'bn')->first();
        $en = Language::where('code', 'en')->first();

        $this->assertTrue((bool) $en->is_default);
        $this->assertFalse((bool) $bn->is_default);

        Livewire::actingAs($this->admin)
            ->test(LanguageManager::class)
            ->call('setDefault', $bn->id)
            ->assertHasNoErrors();

        $bn->refresh();
        $en->refresh();

        $this->assertTrue((bool) $bn->is_default);
        $this->assertFalse((bool) $en->is_default);
    }

    public function test_public_language_switcher_route_works(): void
    {
        $response = $this->get(route('language.switch', 'bn'));
        $response->assertRedirect();
        $response->assertSessionHas('locale', 'bn');

        // Subsequent request sets locale to 'bn' and renders Bengali navigation
        $homeResponse = $this->withSession(['locale' => 'bn'])->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('হোম');
        $homeResponse->assertSee('আমাদের সম্পর্কে');
    }
}
