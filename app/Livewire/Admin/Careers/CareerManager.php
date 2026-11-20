<?php

namespace App\Livewire\Admin\Careers;

use App\Models\JobApplication;
use App\Models\JobFormField;
use App\Models\JobPosting;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.layouts.admin')]
#[Title('Careers & Talent Acquisition | Corporate CMS')]
class CareerManager extends Component
{
    use WithPagination;

    #[Url(as: 'tab')]
    public string $activeTab = 'jobs'; // 'jobs', 'applications', 'builder'

    // ==========================================
    // 1. JOB POSTINGS STATE
    // ==========================================
    public string $searchJob = '';
    public string $filterDepartment = 'all';

    public bool $isJobModalOpen = false;
    public ?int $editingJobId = null;
    public string $jobTitle = '';
    public string $jobSlug = '';
    public string $jobDepartment = 'Marine Engineering';
    public string $jobEmploymentType = 'Full-Time';
    public string $jobLocation = 'Chattogram Port Workshop';
    public string $jobExperienceLevel = '3-5 Years';
    public ?string $jobSalaryRange = '';
    public string $jobDescription = '';
    public ?string $jobRequirements = '';
    public ?string $jobBenefits = '';
    public ?string $jobDeadline = '';
    public bool $jobIsFeatured = false;
    public bool $jobIsActive = true;

    // ==========================================
    // 2. APPLICATIONS DESK STATE
    // ==========================================
    public string $searchApp = '';
    public string $filterAppJob = 'all';
    public string $filterAppStatus = 'all';

    public ?int $selectedAppId = null;
    public ?JobApplication $selectedApplication = null;
    public string $adminNoteText = '';

    // ==========================================
    // 3. FORM BUILDER STATE
    // ==========================================
    public bool $isFieldModalOpen = false;
    public ?int $editingFieldId = null;
    public string $fieldLabel = '';
    public string $fieldName = '';
    public string $fieldType = 'text';
    public ?string $fieldPlaceholder = '';
    public int $fieldWidth = 12;
    public bool $fieldIsRequired = false;
    public ?string $fieldDefaultValue = '';
    public ?string $fieldHelpText = '';
    public int $fieldOrder = 0;
    public bool $fieldIsActive = true;
    public array $fieldOptions = [];
    public string $newOptionLabel = '';
    public string $newOptionValue = '';

    // Shared Delete Modal
    public bool $isDeleteModalOpen = false;
    public ?string $deleteType = null; // 'job', 'application', 'field'
    public ?int $deleteId = null;
    public string $deleteName = '';

    public function mount(): void
    {
        JobFormField::seedDefaultsIfEmpty();
    }

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['jobs', 'applications', 'builder'])) {
            $this->activeTab = $tab;
            $this->resetPage();
        }
    }

    // ==========================================
    // JOB POSTING METHODS
    // ==========================================
    public function openCreateJobModal(): void
    {
        $this->resetJobForm();
        $this->isJobModalOpen = true;
    }

    public function updatedJobTitle(string $val): void
    {
        if (!$this->editingJobId && empty(trim($this->jobSlug))) {
            $this->jobSlug = Str::slug($val);
        }
    }

    public function editJob(int $id): void
    {
        $job = JobPosting::findOrFail($id);
        $this->editingJobId = $job->id;
        $this->jobTitle = $job->title;
        $this->jobSlug = $job->slug;
        $this->jobDepartment = $job->department;
        $this->jobEmploymentType = $job->employment_type;
        $this->jobLocation = $job->location;
        $this->jobExperienceLevel = $job->experience_level;
        $this->jobSalaryRange = $job->salary_range ?? '';
        $this->jobDescription = $job->description;
        $this->jobRequirements = $job->requirements ?? '';
        $this->jobBenefits = $job->benefits ?? '';
        $this->jobDeadline = $job->deadline ? $job->deadline->format('Y-m-d') : '';
        $this->jobIsFeatured = (bool) $job->is_featured;
        $this->jobIsActive = (bool) $job->is_active;

        $this->resetValidation();
        $this->isJobModalOpen = true;
    }

    public function saveJob(): void
    {
        $this->jobSlug = Str::slug($this->jobSlug ?: $this->jobTitle);

        $rules = [
            'jobTitle'           => 'required|string|min:3|max:190',
            'jobSlug'            => 'required|string|min:3|max:190|unique:job_postings,slug,' . ($this->editingJobId ?? 'NULL'),
            'jobDepartment'      => 'required|string|max:100',
            'jobEmploymentType'  => 'required|string|max:100',
            'jobLocation'        => 'required|string|max:150',
            'jobExperienceLevel' => 'required|string|max:100',
            'jobSalaryRange'     => 'nullable|string|max:100',
            'jobDescription'     => 'required|string|min:10',
            'jobRequirements'    => 'nullable|string',
            'jobBenefits'        => 'nullable|string',
            'jobDeadline'        => 'nullable|date',
            'jobIsFeatured'      => 'boolean',
            'jobIsActive'        => 'boolean',
        ];

        $this->validate($rules);

        $data = [
            'title'            => trim($this->jobTitle),
            'slug'             => trim($this->jobSlug),
            'department'       => trim($this->jobDepartment),
            'employment_type'  => trim($this->jobEmploymentType),
            'location'         => trim($this->jobLocation),
            'experience_level' => trim($this->jobExperienceLevel),
            'salary_range'     => trim($this->jobSalaryRange ?: ''),
            'description'      => trim($this->jobDescription),
            'requirements'     => trim($this->jobRequirements ?: ''),
            'benefits'         => trim($this->jobBenefits ?: ''),
            'deadline'         => !empty($this->jobDeadline) ? $this->jobDeadline : null,
            'is_featured'      => (bool) $this->jobIsFeatured,
            'is_active'        => (bool) $this->jobIsActive,
        ];

        if ($this->editingJobId) {
            $job = JobPosting::findOrFail($this->editingJobId);
            $job->update($data);
            session()->flash('message', "Vacancy '{$this->jobTitle}' updated successfully.");
        } else {
            $maxOrder = JobPosting::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
            JobPosting::create($data);
            session()->flash('message', "New vacancy '{$this->jobTitle}' successfully published.");
        }

        $this->isJobModalOpen = false;
        $this->resetJobForm();
    }

    public function toggleJobActive(int $id): void
    {
        $job = JobPosting::findOrFail($id);
        $job->update(['is_active' => !$job->is_active]);
        $status = $job->is_active ? 'opened' : 'closed';
        session()->flash('message', "Job posting '{$job->title}' is now {$status}.");
    }

    public function toggleJobFeatured(int $id): void
    {
        $job = JobPosting::findOrFail($id);
        $job->update(['is_featured' => !$job->is_featured]);
    }

    private function resetJobForm(): void
    {
        $this->editingJobId = null;
        $this->jobTitle = '';
        $this->jobSlug = '';
        $this->jobDepartment = 'Marine Engineering';
        $this->jobEmploymentType = 'Full-Time';
        $this->jobLocation = 'Chattogram Port Workshop';
        $this->jobExperienceLevel = '3-5 Years';
        $this->jobSalaryRange = '';
        $this->jobDescription = '';
        $this->jobRequirements = '';
        $this->jobBenefits = '';
        $this->jobDeadline = '';
        $this->jobIsFeatured = false;
        $this->jobIsActive = true;
        $this->resetValidation();
    }

    // ==========================================
    // APPLICATIONS DESK METHODS
    // ==========================================
    public function viewApplication(int $id): void
    {
        $app = JobApplication::with('jobPosting')->findOrFail($id);
        if ($app->status === 'new') {
            $app->update(['status' => 'reviewing']);
        }
        $this->selectedAppId = $id;
        $this->selectedApplication = $app->fresh();
        $this->adminNoteText = $app->admin_notes ?? '';
    }

    public function updateAppStatus(int $id, string $status): void
    {
        if (!in_array($status, ['new', 'reviewing', 'shortlisted', 'interview', 'rejected', 'hired'])) {
            return;
        }

        $app = JobApplication::findOrFail($id);
        $app->update(['status' => $status]);
        if ($this->selectedApplication && $this->selectedApplication->id === $id) {
            $this->selectedApplication = $app->fresh();
        }
        session()->flash('message', "Candidate application status changed to " . ucfirst($status) . ".");
    }

    public function saveAdminNote(): void
    {
        if ($this->selectedApplication) {
            $this->selectedApplication->update(['admin_notes' => trim($this->adminNoteText)]);
            session()->flash('message', "Internal evaluation note saved.");
        }
    }

    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="nordroy_job_candidates_' . date('Y-m-d_His') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Application ID', 'Applied Date', 'Position Applied', 'Status',
                'Candidate Name', 'Email', 'Phone', 'Resume URL', 'Cover Summary', 'Custom Fields'
            ]);

            $query = JobApplication::with('jobPosting')->latest();
            if ($this->filterAppStatus !== 'all') {
                $query->where('status', $this->filterAppStatus);
            }
            if ($this->filterAppJob !== 'all') {
                $query->where('job_posting_id', $this->filterAppJob);
            }

            $query->chunk(100, function ($apps) use ($handle) {
                foreach ($apps as $a) {
                    $payload = is_array($a->payload) ? $a->payload : [];
                    $customDetails = '';
                    if (isset($payload['fields']) && is_array($payload['fields'])) {
                        $parts = [];
                        foreach ($payload['fields'] as $fld) {
                            if (isset($fld['value']) && $fld['value'] !== '' && ($fld['type'] ?? '') !== 'textarea') {
                                $v = is_bool($fld['value']) ? ($fld['value'] ? 'Yes' : 'No') : $fld['value'];
                                $parts[] = "{$fld['label']}: {$v}";
                            }
                        }
                        $customDetails = implode('; ', $parts);
                    }

                    fputcsv($handle, [
                        $a->id,
                        $a->created_at->format('Y-m-d H:i:s'),
                        $a->jobPosting?->title ?? 'General Maritime Engineering Pool',
                        ucfirst($a->status),
                        $a->full_name,
                        $a->email,
                        $a->phone,
                        $a->resume_url ?? 'N/A',
                        $a->cover_letter ?? '',
                        $customDetails,
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    // ==========================================
    // APPLICATION FORM BUILDER METHODS
    // ==========================================
    public function openCreateFieldModal(): void
    {
        $this->resetFieldForm();
        $max = JobFormField::max('order') ?? 0;
        $this->fieldOrder = $max + 1;
        $this->isFieldModalOpen = true;
    }

    public function updatedFieldLabel(string $val): void
    {
        if (!$this->editingFieldId && empty(trim($this->fieldName))) {
            $this->fieldName = Str::snake(Str::slug($val, '_'));
        }
    }

    public function editField(int $id): void
    {
        $field = JobFormField::findOrFail($id);
        $this->editingFieldId = $field->id;
        $this->fieldLabel = $field->label;
        $this->fieldName = $field->name;
        $this->fieldType = $field->type;
        $this->fieldPlaceholder = $field->placeholder ?? '';
        $this->fieldWidth = (int) $field->width;
        $this->fieldIsRequired = (bool) $field->is_required;
        $this->fieldDefaultValue = $field->default_value ?? '';
        $this->fieldHelpText = $field->help_text ?? '';
        $this->fieldOrder = (int) $field->order;
        $this->fieldIsActive = (bool) $field->is_active;
        $this->fieldOptions = is_array($field->options) ? $field->options : [];
        $this->newOptionLabel = '';
        $this->newOptionValue = '';

        $this->resetValidation();
        $this->isFieldModalOpen = true;
    }

    public function addOption(): void
    {
        $label = trim($this->newOptionLabel);
        $value = trim($this->newOptionValue) ?: $label;

        if (empty($label)) {
            $this->addError('newOptionLabel', 'Option label is required.');
            return;
        }

        $this->fieldOptions[] = [
            'label' => $label,
            'value' => $value,
        ];

        $this->newOptionLabel = '';
        $this->newOptionValue = '';
        $this->resetErrorBag(['newOptionLabel', 'newOptionValue']);
    }

    public function removeOption(int $index): void
    {
        if (isset($this->fieldOptions[$index])) {
            unset($this->fieldOptions[$index]);
            $this->fieldOptions = array_values($this->fieldOptions);
        }
    }

    public function saveField(): void
    {
        $this->fieldName = Str::snake(Str::slug(trim($this->fieldName), '_'));

        $rules = [
            'fieldLabel'         => 'required|string|min:2|max:150',
            'fieldName'          => 'required|string|min:2|max:50|alpha_dash|unique:job_form_fields,name,' . ($this->editingFieldId ?? 'NULL'),
            'fieldType'          => 'required|string|in:text,email,tel,number,textarea,select,file,date,radio,checkbox',
            'fieldWidth'         => 'required|integer|in:3,4,6,12',
            'fieldPlaceholder'   => 'nullable|string|max:200',
            'fieldDefaultValue'  => 'nullable|string|max:200',
            'fieldHelpText'      => 'nullable|string|max:255',
            'fieldOrder'         => 'required|integer|min:0',
            'fieldIsRequired'    => 'boolean',
            'fieldIsActive'      => 'boolean',
        ];

        $this->validate($rules);

        $cleanOptions = null;
        if (in_array($this->fieldType, ['select', 'radio', 'checkbox'])) {
            $cleanOptions = array_values(array_filter($this->fieldOptions, function ($opt) {
                return !empty(trim($opt['label'] ?? '')) && !empty(trim($opt['value'] ?? ''));
            }));
        }

        $data = [
            'label'         => trim($this->fieldLabel),
            'name'          => trim($this->fieldName),
            'type'          => $this->fieldType,
            'width'         => (int) $this->fieldWidth,
            'placeholder'   => trim($this->fieldPlaceholder ?: ''),
            'default_value' => trim($this->fieldDefaultValue ?: ''),
            'help_text'     => trim($this->fieldHelpText ?: ''),
            'order'         => (int) $this->fieldOrder,
            'is_required'   => (bool) $this->fieldIsRequired,
            'is_active'     => (bool) $this->fieldIsActive,
            'options'       => $cleanOptions,
        ];

        if ($this->editingFieldId) {
            $field = JobFormField::findOrFail($this->editingFieldId);
            $field->update($data);
            session()->flash('message', "Field '{$this->fieldLabel}' updated.");
        } else {
            JobFormField::create($data);
            session()->flash('message', "Field '{$this->fieldLabel}' added to application form.");
        }

        $this->isFieldModalOpen = false;
        $this->resetFieldForm();
    }

    public function toggleFieldActive(int $id): void
    {
        $field = JobFormField::findOrFail($id);
        $field->update(['is_active' => !$field->is_active]);
    }

    public function moveUp(int $id): void
    {
        $field = JobFormField::findOrFail($id);
        $prev = JobFormField::where('order', '<', $field->order)->orderBy('order', 'desc')->first();
        if ($prev) {
            $curr = $field->order;
            $field->update(['order' => $prev->order]);
            $prev->update(['order' => $curr]);
        }
    }

    public function moveDown(int $id): void
    {
        $field = JobFormField::findOrFail($id);
        $next = JobFormField::where('order', '>', $field->order)->orderBy('order', 'asc')->first();
        if ($next) {
            $curr = $field->order;
            $field->update(['order' => $next->order]);
            $next->update(['order' => $curr]);
        }
    }

    public function resetFieldsToDefault(): void
    {
        JobFormField::truncate();
        foreach (JobFormField::getDefaultFields() as $field) {
            JobFormField::create($field);
        }
        session()->flash('message', 'Application form fields restored to default maritime engineering hiring template.');
    }

    private function resetFieldForm(): void
    {
        $this->editingFieldId = null;
        $this->fieldLabel = '';
        $this->fieldName = '';
        $this->fieldType = 'text';
        $this->fieldPlaceholder = '';
        $this->fieldWidth = 12;
        $this->fieldIsRequired = false;
        $this->fieldDefaultValue = '';
        $this->fieldHelpText = '';
        $this->fieldOrder = 0;
        $this->fieldIsActive = true;
        $this->fieldOptions = [];
        $this->newOptionLabel = '';
        $this->newOptionValue = '';
        $this->resetValidation();
    }

    // ==========================================
    // GENERAL DELETE MODAL
    // ==========================================
    public function confirmDeleteJob(int $id): void
    {
        $job = JobPosting::find($id);
        $this->confirmDelete('job', $id, $job?->title ?? 'Job Posting');
    }

    public function confirmDeleteField(int $id): void
    {
        $field = JobFormField::find($id);
        $this->confirmDelete('field', $id, $field?->label ?? 'Form Field');
    }

    public function confirmDeleteApplication(int $id): void
    {
        $app = JobApplication::find($id);
        $this->confirmDelete('application', $id, $app?->full_name ?? 'Candidate Application');
    }

    public function confirmDelete(string $type, int $id, string $name = ''): void
    {
        $this->deleteType = $type;
        $this->deleteId = $id;
        $this->deleteName = $name;
        $this->isDeleteModalOpen = true;
    }

    public function executeDelete(): void
    {
        if (!$this->deleteId || !$this->deleteType) {
            $this->isDeleteModalOpen = false;
            return;
        }

        if ($this->deleteType === 'job') {
            JobPosting::find($this->deleteId)?->delete();
            session()->flash('message', "Vacancy deleted successfully.");
        } elseif ($this->deleteType === 'application') {
            JobApplication::find($this->deleteId)?->delete();
            if ($this->selectedAppId === $this->deleteId) {
                $this->selectedAppId = null;
                $this->selectedApplication = null;
            }
            session()->flash('message', "Candidate application removed.");
        } elseif ($this->deleteType === 'field') {
            JobFormField::find($this->deleteId)?->delete();
            session()->flash('message', "Form field removed from application template.");
        }

        $this->isDeleteModalOpen = false;
        $this->deleteType = null;
        $this->deleteId = null;
        $this->deleteName = '';
    }

    public function render()
    {
        // 1. Jobs query
        $jobsQuery = JobPosting::withCount('applications');
        if (!empty(trim($this->searchJob))) {
            $q = trim($this->searchJob);
            $jobsQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('department', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }
        if ($this->filterDepartment !== 'all') {
            $jobsQuery->where('department', $this->filterDepartment);
        }
        $jobs = $jobsQuery->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(12, ['*'], 'jobsPage');

        // 2. Applications query
        $appsQuery = JobApplication::with('jobPosting');
        if (!empty(trim($this->searchApp))) {
            $q = trim($this->searchApp);
            $appsQuery->where(function ($sub) use ($q) {
                $sub->where('full_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }
        if ($this->filterAppStatus !== 'all') {
            $appsQuery->where('status', $this->filterAppStatus);
        }
        if ($this->filterAppJob !== 'all') {
            $appsQuery->where('job_posting_id', $this->filterAppJob);
        }
        $applications = $appsQuery->latest()->paginate(15, ['*'], 'appsPage');

        // 3. Form fields
        $fields = JobFormField::orderBy('order', 'asc')->get();

        // 4. Counts & Departments list
        $allDepartments = JobPosting::pluck('department')->unique()->filter()->values();
        $allJobPostings = JobPosting::select('id', 'title')->orderBy('title')->get();

        $appCounts = [
            'all'         => JobApplication::count(),
            'new'         => JobApplication::where('status', 'new')->count(),
            'reviewing'   => JobApplication::where('status', 'reviewing')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'interview'   => JobApplication::where('status', 'interview')->count(),
            'hired'       => JobApplication::where('status', 'hired')->count(),
            'rejected'    => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('livewire.admin.careers.career-manager', [
            'jobs'           => $jobs,
            'applications'   => $applications,
            'fields'         => $fields,
            'allDepartments' => $allDepartments,
            'allJobPostings' => $allJobPostings,
            'appCounts'      => $appCounts,
        ]);
    }
}
