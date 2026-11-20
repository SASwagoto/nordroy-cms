<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Careers\CareerManager;
use App\Livewire\Frontend\JobApplicationForm;
use App\Models\JobApplication;
use App\Models\JobFormField;
use App\Models\JobPosting;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CareerManagerTest extends TestCase
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

    public function test_careers_page_and_admin_manager_accessible(): void
    {
        // Public careers page
        $response = $this->get(route('careers'));
        $response->assertStatus(200);
        $response->assertSee('Talent &amp; Engineering Careers', false);

        // Admin Careers Manager
        $this->actingAs($this->admin);
        $adminResponse = $this->get(route('admin.careers'));
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Careers &amp; Talent Acquisition', false);
    }

    public function test_admin_can_create_update_toggle_and_delete_job_posting(): void
    {
        $this->actingAs($this->admin);

        // Create a new job vacancy
        Livewire::test(CareerManager::class)
            ->call('openCreateJobModal')
            ->set('jobTitle', 'Lead Marine Dynamic Balancing Engineer')
            ->set('jobDepartment', 'Workshop Operations')
            ->set('jobLocation', 'Chattogram Port Workshop')
            ->set('jobEmploymentType', 'Full-Time')
            ->set('jobExperienceLevel', '5-8 Years')
            ->set('jobSalaryRange', '$2,500 - $3,500 / month')
            ->set('jobDescription', 'Oversee high-speed dynamic balancing operations up to 100k RPM.')
            ->set('jobRequirements', "B.Sc in Marine Engineering\n5+ years turbocharger experience")
            ->set('jobBenefits', "Health Insurance\nPort Accommodation")
            ->set('jobIsActive', true)
            ->set('jobIsFeatured', true)
            ->call('saveJob');

        $this->assertDatabaseHas('job_postings', [
            'title'            => 'Lead Marine Dynamic Balancing Engineer',
            'department'       => 'Workshop Operations',
            'location'         => 'Chattogram Port Workshop',
            'is_active'        => true,
            'is_featured'      => true,
        ]);

        $job = JobPosting::where('title', 'Lead Marine Dynamic Balancing Engineer')->firstOrFail();

        // Edit the job vacancy
        Livewire::test(CareerManager::class)
            ->call('editJob', $job->id)
            ->set('jobTitle', 'Senior Marine Dynamic Balancing Engineer')
            ->call('saveJob');

        $job->refresh();
        $this->assertEquals('Senior Marine Dynamic Balancing Engineer', $job->title);

        // Toggle active status
        Livewire::test(CareerManager::class)
            ->call('toggleJobActive', $job->id);

        $job->refresh();
        $this->assertFalse($job->is_active);

        // Delete the job vacancy
        Livewire::test(CareerManager::class)
            ->call('confirmDeleteJob', $job->id)
            ->call('executeDelete');

        $this->assertDatabaseMissing('job_postings', [
            'id' => $job->id,
        ]);
    }

    public function test_admin_can_manage_custom_career_form_fields(): void
    {
        $this->actingAs($this->admin);

        // Seed default fields if empty
        JobFormField::seedDefaultsIfEmpty();

        // Add a new unique custom field
        Livewire::test(CareerManager::class)
            ->call('openCreateFieldModal')
            ->set('fieldLabel', 'Offshore Travel Willingness')
            ->set('fieldName', 'offshore_travel_willingness')
            ->set('fieldType', 'select')
            ->set('fieldWidth', 4)
            ->set('fieldPlaceholder', 'Select willingness')
            ->set('fieldIsRequired', true)
            ->set('newOptionLabel', '100% Ready for Anchorage Boarding')
            ->set('newOptionValue', 'ready_100')
            ->call('addOption')
            ->set('newOptionLabel', 'Port Workshop Only')
            ->set('newOptionValue', 'workshop_only')
            ->call('addOption')
            ->call('saveField');

        $this->assertDatabaseHas('job_form_fields', [
            'name'        => 'offshore_travel_willingness',
            'label'       => 'Offshore Travel Willingness',
            'type'        => 'select',
            'width'       => 4,
            'is_required' => true,
        ]);

        $field = JobFormField::where('name', 'offshore_travel_willingness')->firstOrFail();
        $this->assertCount(2, $field->options);

        // Toggle field active status
        Livewire::test(CareerManager::class)
            ->call('toggleFieldActive', $field->id);

        $field->refresh();
        $this->assertFalse($field->is_active);

        // Delete field
        Livewire::test(CareerManager::class)
            ->call('confirmDeleteField', $field->id)
            ->call('executeDelete');

        $this->assertDatabaseMissing('job_form_fields', [
            'id' => $field->id,
        ]);
    }

    public function test_candidate_can_submit_application_with_resume_and_dynamic_fields(): void
    {
        Storage::fake('public');

        JobFormField::seedDefaultsIfEmpty();

        $job = JobPosting::create([
            'title'           => 'Turbocharger Reconditioning Technician',
            'slug'            => 'turbocharger-reconditioning-technician',
            'department'      => 'Overhaul Services',
            'location'        => 'Chattogram Port',
            'employment_type' => 'Full-time',
            'experience_level'=> '3-5 Years',
            'description'     => 'Reconditioning of CHRA cartridges and rotor assemblies.',
            'is_active'       => true,
        ]);

        $fakePdf = UploadedFile::fake()->create('marine_cv.pdf', 500, 'application/pdf');

        Livewire::test(JobApplicationForm::class, ['jobId' => $job->id])
            ->set('formData.full_name', 'Capt. Tahmid Rahman')
            ->set('formData.email', 'tahmid.rahman@maritime.com')
            ->set('formData.phone', '+8801712345678')
            ->set('formData.current_city', 'Chattogram')
            ->set('formData.years_of_experience', '6')
            ->set('resumeFile', $fakePdf)
            ->call('submitApplication')
            ->assertHasNoErrors()
            ->assertSet('isSubmitted', true);

        $this->assertDatabaseHas('job_applications', [
            'job_posting_id' => $job->id,
            'full_name'      => 'Capt. Tahmid Rahman',
            'email'          => 'tahmid.rahman@maritime.com',
            'phone'          => '+8801712345678',
            'status'         => 'new',
        ]);

        $application = JobApplication::where('email', 'tahmid.rahman@maritime.com')->firstOrFail();
        $this->assertNotNull($application->resume_path);
        Storage::disk('public')->assertExists($application->resume_path);
    }

    public function test_admin_can_evaluate_application_and_change_status(): void
    {
        $this->actingAs($this->admin);

        $job = JobPosting::create([
            'title'           => 'NDT Inspection Specialist',
            'slug'            => 'ndt-inspection-specialist',
            'department'      => 'Quality Assurance',
            'location'        => 'Dhaka HQ',
            'employment_type' => 'Full-time',
            'experience_level'=> '5+ Years',
            'description'     => 'Level II dye penetrant and ultrasonic non-destructive testing.',
            'is_active'       => true,
        ]);

        $app = JobApplication::create([
            'job_posting_id'  => $job->id,
            'full_name'       => 'Engineer Rafiqul Islam',
            'email'           => 'rafiqul.ndt@example.com',
            'phone'           => '+8801811223344',
            'status'          => 'new',
            'payload'         => ['raw' => ['full_name' => 'Engineer Rafiqul Islam']],
        ]);

        // Evaluate application: update status and save notes
        Livewire::test(CareerManager::class)
            ->call('viewApplication', $app->id)
            ->call('updateAppStatus', $app->id, 'shortlisted')
            ->set('adminNoteText', 'Candidate holds Level II NDT certification. Interview scheduled next Monday.')
            ->call('saveAdminNote');

        $app->refresh();
        $this->assertEquals('shortlisted', $app->status);
        $this->assertStringContainsString('Level II NDT certification', $app->admin_notes);

        // Delete application
        Livewire::test(CareerManager::class)
            ->call('confirmDeleteApplication', $app->id)
            ->call('executeDelete');

        $this->assertDatabaseMissing('job_applications', [
            'id' => $app->id,
        ]);
    }
}
