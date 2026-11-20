<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Enquiries\EnquiryManager;
use App\Livewire\Admin\Enquiries\RfqFormBuilder;
use App\Livewire\Frontend\RfqLeadForm;
use App\Models\Enquiry;
use App\Models\RfqFormField;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RfqFormBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Administrator']);
        $perms = ['enquiries.view', 'settings.manage'];
        foreach ($perms as $p) {
            $perm = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $p]);
            $role->givePermissionTo($perm);
        }

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Super Administrator');
        foreach ($perms as $p) {
            $this->admin->givePermissionTo($p);
        }

        $this->seed(LanguageSeeder::class);
    }

    public function test_rfq_form_builder_page_is_accessible_by_admin(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.enquiries.form-builder'));
        $response->assertStatus(200);
        $response->assertSee('RFQ & Inquiry Form Builder');
    }

    public function test_admin_can_add_custom_field_with_options_and_width(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(RfqFormBuilder::class)
            ->call('openCreateFieldModal')
            ->set('label', 'Vessel IMO Number')
            ->set('name', 'vessel_imo')
            ->set('type', 'text')
            ->set('width', 6)
            ->set('placeholder', 'e.g. IMO 9123456')
            ->set('is_required', true)
            ->call('saveField');

        $this->assertDatabaseHas('rfq_form_fields', [
            'name'        => 'vessel_imo',
            'label'       => 'Vessel IMO Number',
            'type'        => 'text',
            'width'       => 6,
            'is_required' => true,
        ]);

        // Add a dropdown select field with options
        Livewire::test(RfqFormBuilder::class)
            ->call('openCreateFieldModal')
            ->set('label', 'Budget Bracket')
            ->set('name', 'budget_bracket')
            ->set('type', 'select')
            ->set('width', 4)
            ->set('newOptionLabel', '$10,000 - $25,000')
            ->set('newOptionValue', '10k-25k')
            ->call('addOption')
            ->set('newOptionLabel', '$25,000 - $50,000')
            ->set('newOptionValue', '25k-50k')
            ->call('addOption')
            ->call('saveField');

        $this->assertDatabaseHas('rfq_form_fields', [
            'name' => 'budget_bracket',
            'type' => 'select',
        ]);

        $created = RfqFormField::where('name', 'budget_bracket')->firstOrFail();
        $this->assertCount(2, $created->options);
        $this->assertEquals('$10,000 - $25,000', $created->options[0]['label']);
    }

    public function test_admin_can_edit_toggle_and_reorder_fields(): void
    {
        $this->actingAs($this->admin);

        $field = RfqFormField::create([
            'name'        => 'classification_society',
            'label'       => 'Class Society',
            'type'        => 'text',
            'width'       => 6,
            'order'       => 100,
            'is_active'   => true,
            'is_required' => false,
        ]);

        // 1. Edit field
        Livewire::test(RfqFormBuilder::class)
            ->call('editField', $field->id)
            ->set('label', 'Classification Society (DNV / Lloyd / ABS)')
            ->set('placeholder', 'Enter IACS Class')
            ->call('saveField');

        $this->assertEquals('Classification Society (DNV / Lloyd / ABS)', $field->fresh()->label);
        $this->assertEquals('Enter IACS Class', $field->fresh()->placeholder);

        // 2. Toggle active
        Livewire::test(RfqFormBuilder::class)
            ->call('toggleFieldActive', $field->id);

        $this->assertFalse($field->fresh()->is_active);

        // 3. Delete field
        Livewire::test(RfqFormBuilder::class)
            ->call('confirmDelete', $field->id)
            ->call('executeDelete');

        $this->assertDatabaseMissing('rfq_form_fields', ['id' => $field->id]);
    }

    public function test_frontend_rfq_lead_form_renders_dynamic_fields_and_submits(): void
    {
        // 1. Create a custom field
        RfqFormField::create([
            'name'        => 'engine_running_hours',
            'label'       => 'Engine Running Hours',
            'type'        => 'number',
            'width'       => 6,
            'is_required' => true,
            'order'       => 1,
            'is_active'   => true,
        ]);

        // 2. Test livewire frontend component loads and accepts input
        $test = Livewire::test(RfqLeadForm::class);

        $test->set('formData.full_name', 'Capt. Robert Lang')
            ->set('formData.email', 'lang.r@shipping.com')
            ->set('formData.phone', '+880 1700-112233')
            ->set('formData.vessel_plant_name', 'M/V Nordroy Atlantic')
            ->set('formData.turbocharger_model', 'ABB TPL 77-B')
            ->set('formData.port_location', 'Chattogram Port')
            ->set('formData.service_required', 'Complete Overhaul & Dynamic Balancing')
            ->set('formData.urgency', 'Standard Scheduled Maintenance')
            ->set('formData.message', 'Vibration detected at 12,000 RPM. Urgent balance requested.')
            ->set('formData.engine_running_hours', 18500)
            ->call('submitRfq');

        $test->assertSet('isSubmitted', true);

        // 3. Verify enquiry stored in DB
        $this->assertDatabaseHas('enquiries', [
            'email'     => 'lang.r@shipping.com',
            'full_name' => 'Capt. Robert Lang',
        ]);

        $enquiry = Enquiry::where('email', 'lang.r@shipping.com')->firstOrFail();
        $this->assertIsArray($enquiry->payload);
        $this->assertArrayHasKey('fields', $enquiry->payload);

        // Verify the custom field was captured in payload
        $capturedValues = collect($enquiry->payload['fields'])->pluck('value', 'name')->toArray();
        $this->assertEquals(18500, $capturedValues['engine_running_hours']);

        // 4. Test admin enquiry manager views this dynamic submission
        $this->actingAs($this->admin);

        Livewire::test(EnquiryManager::class)
            ->call('viewEnquiry', $enquiry->id)
            ->assertSee('Engine Running Hours')
            ->assertSee('18500');
    }
}
