<?php

namespace App\Livewire\Frontend;

use App\Models\Enquiry;
use App\Models\RfqFormField;
use Livewire\Component;

class RfqLeadForm extends Component
{
    /**
     * Dynamic Form Data State indexed by field key
     */
    public array $formData = [];

    /**
     * Anti-bot honeypot field
     */
    public string $extra_honey = '';

    public bool $isSubmitted = false;
    public ?string $referenceCode = null;
    public ?array $submittedData = null;
    public ?string $service = null;

    public function mount(?string $service = null): void
    {
        $this->service = $service;
        RfqFormField::seedDefaultsIfEmpty();

        $fields = RfqFormField::active()->get();
        foreach ($fields as $field) {
            $default = $field->default_value ?? '';
            
            // If service passed into component, prefill matching service/product field
            if ($service && in_array($field->name, ['service_required', 'service', 'product'])) {
                $default = $service;
            }

            if ($field->type === 'checkbox') {
                $this->formData[$field->name] = (bool) $default;
            } else {
                $this->formData[$field->name] = $default;
            }
        }
    }

    protected function rules(): array
    {
        $fields = RfqFormField::active()->get();
        $rules = [];

        foreach ($fields as $field) {
            $key = 'formData.' . $field->name;
            $r = [];

            if ($field->is_required) {
                $r[] = 'required';
            } else {
                $r[] = 'nullable';
            }

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
        $fields = RfqFormField::active()->get();
        $attrs = [];
        foreach ($fields as $field) {
            $attrs['formData.' . $field->name] = $field->label;
        }
        return $attrs;
    }

    public function submitRfq(): void
    {
        // Silent bot drop
        if (!empty($this->extra_honey)) {
            $this->isSubmitted = true;
            $this->referenceCode = 'NRQ-' . date('Y') . '-0001';
            return;
        }

        $this->validate();

        $fields = RfqFormField::active()->get();

        // Extract primary contact fields for the core columns in enquiries table
        $fullName = $this->formData['full_name'] 
            ?? $this->formData['name'] 
            ?? $this->formData['contact_person'] 
            ?? 'Valued Maritime Client';

        $email = $this->formData['email'] 
            ?? $this->formData['contact_email'] 
            ?? 'inquiry@nordroy.com';

        $phone = $this->formData['phone'] 
            ?? $this->formData['whatsapp'] 
            ?? $this->formData['tel'] 
            ?? 'N/A';

        $company = $this->formData['company'] 
            ?? $this->formData['organization'] 
            ?? '';

        $message = $this->formData['message'] 
            ?? $this->formData['comments'] 
            ?? $this->formData['symptoms'] 
            ?? 'Technical RFQ Inquiry transmitted via web portal.';

        $serviceRequired = $this->formData['service_required'] 
            ?? $this->formData['service'] 
            ?? ($this->service ?: 'Marine Engineering Overhaul');

        $vessel = $this->formData['vessel_plant_name'] 
            ?? $this->formData['vessel_name'] 
            ?? '';

        $model = $this->formData['turbocharger_model'] 
            ?? $this->formData['equipment_model'] 
            ?? '';

        // Formulate dynamic subject
        $subject = "RFQ: {$serviceRequired}";
        if (!empty($vessel)) {
            $subject .= " - {$vessel}";
        }
        if (!empty($model)) {
            $subject .= " ({$model})";
        }

        // Build structured dynamic payload
        $payloadFields = [];
        foreach ($fields as $f) {
            $val = $this->formData[$f->name] ?? null;
            $payloadFields[] = [
                'name'  => $f->name,
                'label' => $f->label,
                'type'  => $f->type,
                'value' => $val,
            ];
        }

        $payload = [
            'fields'             => $payloadFields,
            'raw'                => $this->formData,
            'vessel_plant_name'  => $vessel,
            'turbocharger_model' => $model,
            'port_location'      => $this->formData['port_location'] ?? 'Chattogram Port',
            'service_required'   => $serviceRequired,
            'urgency'            => $this->formData['urgency'] ?? 'Standard Scheduled Maintenance',
            'submitted_at'       => now()->toIso8601String(),
        ];

        $enquiry = Enquiry::create([
            'type'       => 'quotation',
            'full_name'  => trim($fullName),
            'email'      => trim(strtolower($email)),
            'phone'      => trim($phone),
            'company'    => trim($company),
            'subject'    => trim($subject),
            'message'    => trim($message),
            'payload'    => $payload,
            'ip_address' => request()->ip(),
            'status'     => 'new',
        ]);

        $this->referenceCode = sprintf('NRQ-%s-%04d', date('Y'), $enquiry->id);
        $this->submittedData = $payloadFields;
        $this->isSubmitted = true;
    }

    public function resetForm(): void
    {
        $this->isSubmitted = false;
        $this->referenceCode = null;
        $this->submittedData = null;
        $this->extra_honey = '';
        
        $fields = RfqFormField::active()->get();
        foreach ($fields as $field) {
            $default = $field->default_value ?? '';
            if ($this->service && in_array($field->name, ['service_required', 'service', 'product'])) {
                $default = $this->service;
            }
            $this->formData[$field->name] = ($field->type === 'checkbox') ? (bool)$default : $default;
        }

        $this->resetValidation();
    }

    public function render()
    {
        $fields = RfqFormField::active()->get();

        return view('livewire.frontend.rfq-lead-form', [
            'fields' => $fields,
        ]);
    }
}
