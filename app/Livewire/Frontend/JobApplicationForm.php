<?php

namespace App\Livewire\Frontend;

use App\Models\JobApplication;
use App\Models\JobFormField;
use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithFileUploads;

class JobApplicationForm extends Component
{
    use WithFileUploads;

    public ?int $jobId = null;
    public ?JobPosting $job = null;

    /**
     * Dynamic Form Values indexed by field key
     */
    public array $formData = [];

    /**
     * File upload state
     */
    public $resumeFile = null;

    /**
     * Anti-bot honeypot
     */
    public string $extra_honey = '';

    public bool $isSubmitted = false;
    public ?string $referenceCode = null;
    public ?array $submittedData = null;

    #[\Livewire\Attributes\On('set-job-id')]
    public function setJobId(?int $id): void
    {
        $this->jobId = $id;
        $this->job = $id ? JobPosting::find($id) : null;
    }

    public function mount(?int $jobId = null): void
    {
        $this->jobId = $jobId;
        if ($jobId) {
            $this->job = JobPosting::find($jobId);
        }

        JobFormField::seedDefaultsIfEmpty();

        $fields = JobFormField::active()->get();
        foreach ($fields as $field) {
            if ($field->type !== 'file') {
                $this->formData[$field->name] = ($field->type === 'checkbox') 
                    ? (bool) $field->default_value 
                    : ($field->default_value ?? '');
            }
        }
    }

    protected function rules(): array
    {
        $fields = JobFormField::active()->get();
        $rules = [];

        foreach ($fields as $field) {
            if ($field->type === 'file') {
                $fileRule = ($field->is_required ? 'required' : 'nullable') . '|file|max:10240|mimes:pdf,doc,docx';
                $rules['resumeFile'] = $fileRule;
                continue;
            }

            $key = 'formData.' . $field->name;
            $r = [];
            $r[] = $field->is_required ? 'required' : 'nullable';

            match ($field->type) {
                'email'    => $r[] = 'email:filter|max:150',
                'number'   => $r[] = 'numeric',
                'date'     => $r[] = 'date',
                'textarea' => $r[] = 'string|min:5|max:5000',
                'tel'      => $r[] = 'string|min:6|max:50',
                'checkbox' => $r[] = 'boolean',
                default    => $r[] = 'string|max:255',
            };

            $rules[$key] = implode('|', $r);
        }

        return $rules;
    }

    protected function validationAttributes(): array
    {
        $fields = JobFormField::active()->get();
        $attrs = [
            'resumeFile' => 'Resume / Curriculum Vitae',
        ];

        foreach ($fields as $field) {
            if ($field->type !== 'file') {
                $attrs['formData.' . $field->name] = $field->label;
            }
        }

        return $attrs;
    }

    public function submitApplication(): void
    {
        // Silent bot drop
        if (!empty($this->extra_honey)) {
            $this->isSubmitted = true;
            $this->referenceCode = 'NCA-' . date('Y') . '-0001';
            return;
        }

        $this->validate();

        $fields = JobFormField::active()->get();

        // Handle Resume Upload
        $resumePath = null;
        if ($this->resumeFile) {
            $resumePath = $this->resumeFile->store('resumes', 'public');
        }

        $fullName = $this->formData['full_name'] 
            ?? $this->formData['name'] 
            ?? 'Candidate';

        $email = $this->formData['email'] 
            ?? 'candidate@example.com';

        $phone = $this->formData['phone'] 
            ?? 'N/A';

        $coverLetter = $this->formData['cover_letter'] 
            ?? $this->formData['summary'] 
            ?? null;

        // Structured payload with all custom fields
        $payloadFields = [];
        foreach ($fields as $f) {
            $val = ($f->type === 'file') ? $resumePath : ($this->formData[$f->name] ?? null);
            $payloadFields[] = [
                'name'  => $f->name,
                'label' => $f->label,
                'type'  => $f->type,
                'value' => $val,
            ];
        }

        $application = JobApplication::create([
            'job_posting_id' => $this->jobId,
            'full_name'      => trim($fullName),
            'email'          => trim(strtolower($email)),
            'phone'          => trim($phone),
            'resume_path'    => $resumePath,
            'cover_letter'   => $coverLetter ? trim($coverLetter) : null,
            'payload'        => [
                'fields'       => $payloadFields,
                'raw'          => $this->formData,
                'submitted_at' => now()->toIso8601String(),
            ],
            'status'         => 'new',
            'ip_address'     => request()->ip(),
        ]);

        $this->referenceCode = sprintf('NCA-%s-%04d', date('Y'), $application->id);
        $this->submittedData = $payloadFields;
        $this->isSubmitted = true;
    }

    public function resetForm(): void
    {
        $this->isSubmitted = false;
        $this->referenceCode = null;
        $this->submittedData = null;
        $this->resumeFile = null;
        $this->extra_honey = '';

        $fields = JobFormField::active()->get();
        foreach ($fields as $field) {
            if ($field->type !== 'file') {
                $this->formData[$field->name] = ($field->type === 'checkbox') 
                    ? (bool) $field->default_value 
                    : ($field->default_value ?? '');
            }
        }

        $this->resetValidation();
    }

    public function render()
    {
        $fields = JobFormField::active()->get();

        return view('livewire.frontend.job-application-form', [
            'fields' => $fields,
        ]);
    }
}
