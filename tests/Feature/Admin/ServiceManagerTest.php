<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Services\ServiceManager;
use App\Models\Language;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ServiceManagerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'Super Administrator']);
        $permission = Permission::firstOrCreate(['name' => 'services.view']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        $this->admin->givePermissionTo('services.view');

        Language::firstOrCreate(['code' => 'en'], [
            'name' => 'English',
            'native_name' => 'English',
            'direction' => 'ltr',
            'is_default' => true,
            'is_active' => true,
            'order' => 1,
        ]);
        Language::firstOrCreate(['code' => 'bn'], [
            'name' => 'Bengali',
            'native_name' => 'বাংলা',
            'direction' => 'ltr',
            'is_default' => false,
            'is_active' => true,
            'order' => 2,
        ]);
    }

    public function test_services_manager_page_is_accessible(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.services'));
        $response->assertStatus(200);
        $response->assertSee('Services &amp; Precision Overhauls', false);
        $response->assertSee('Add New Service');
    }

    public function test_services_manager_can_create_new_service_with_dynamic_languages(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ServiceManager::class)
            ->call('createService')
            ->set('title.en', 'Ultrasonic Chemical Cleaning')
            ->set('title.bn', 'আল্ট্রাসনিক কেমিক্যাল ক্লিনিং')
            ->set('slug', 'ultrasonic-chemical-cleaning-test')
            ->set('icon', 'solid:sparkles')
            ->set('short_summary.en', 'Specialized ultrasonic immersion decarbonization tanks.')
            ->set('short_summary.bn', 'বিশেষায়িত আল্ট্রাসনিক ট্যাঙ্ক দ্বারা ডিকার্বনাইজেশন।')
            ->set('content.en', 'Full ultrasonic cleaning process details.')
            ->set('order', 5)
            ->call('saveService')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('services', [
            'slug' => 'ultrasonic-chemical-cleaning-test',
            'icon' => 'solid:sparkles',
            'order' => 5,
        ]);

        $service = Service::where('slug', 'ultrasonic-chemical-cleaning-test')->first();
        $this->assertNotNull($service);
        $this->assertEquals('Ultrasonic Chemical Cleaning', $service->getTranslation('title', 'en'));
        $this->assertEquals('আল্ট্রাসনিক কেমিক্যাল ক্লিনিং', $service->getTranslation('title', 'bn'));
    }

    public function test_services_manager_can_edit_existing_service(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Turbine Blading Refit', 'bn' => 'টারবাইন ব্লেডিং রিফিট'],
            'slug' => 'turbine-blading-refit',
            'icon' => 'solid:cog',
            'short_summary' => ['en' => 'Precision rotor blade repairs.'],
            'content' => ['en' => 'Rotor blading overhaul content.'],
            'order' => 2,
            'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ServiceManager::class)
            ->call('editService', $service->id)
            ->set('title.en', 'Turbine Blading Refit & Precision Inspection')
            ->call('saveService')
            ->assertHasNoErrors();

        $service->refresh();
        $this->assertEquals('Turbine Blading Refit & Precision Inspection', $service->getTranslation('title', 'en'));
    }
}
