<?php

namespace App\Livewire\Admin\Enquiries;

use App\Models\RfqFormField;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('RFQ & Inquiry Form Builder | Corporate CMS')]
class RfqFormBuilder extends Component
{
    // Field Modal State
    public bool $isFieldModalOpen = false;
    public ?int $editingFieldId = null;

    // Form Field Attributes
    public string $label = '';
    public string $name = '';
    public string $type = 'text';
    public ?string $placeholder = '';
    public int $width = 12; // 12 (100%), 6 (50%), 4 (33%), 3 (25%)
    public bool $is_required = false;
    public ?string $default_value = '';
    public ?string $help_text = '';
    public int $order = 0;
    public bool $is_active = true;

    // Options for select, radio, checkbox
    public array $options = [];
    public string $newOptionLabel = '';
    public string $newOptionValue = '';

    // Delete Confirmation State
    public bool $isDeleteModalOpen = false;
    public ?int $deleteFieldId = null;
    public string $deleteFieldName = '';

    public function mount(): void
    {
        // Seed recommended default marine RFQ fields if none exist
        RfqFormField::seedDefaultsIfEmpty();
    }

    public function openCreateFieldModal(): void
    {
        $this->resetFieldForm();
        $this->editingFieldId = null;
        $maxOrder = RfqFormField::max('order') ?? 0;
        $this->order = $maxOrder + 1;
        $this->isFieldModalOpen = true;
    }

    public function editField(int $id): void
    {
        $field = RfqFormField::findOrFail($id);
        $this->editingFieldId = $field->id;
        $this->label = $field->label;
        $this->name = $field->name;
        $this->type = $field->type;
        $this->placeholder = $field->placeholder ?? '';
        $this->width = (int) $field->width;
        $this->is_required = (bool) $field->is_required;
        $this->default_value = $field->default_value ?? '';
        $this->help_text = $field->help_text ?? '';
        $this->order = (int) $field->order;
        $this->is_active = (bool) $field->is_active;
        $this->options = is_array($field->options) ? $field->options : [];
        $this->newOptionLabel = '';
        $this->newOptionValue = '';

        $this->resetValidation();
        $this->isFieldModalOpen = true;
    }

    public function updatedLabel(string $val): void
    {
        // If creating a new field and name hasn't been manually set, auto-slug it
        if (!$this->editingFieldId && empty(trim($this->name))) {
            $this->name = Str::snake(Str::slug($val, '_'));
        }
    }

    public function addOption(): void
    {
        $label = trim($this->newOptionLabel);
        $value = trim($this->newOptionValue);

        if (empty($label)) {
            $this->addError('newOptionLabel', 'Option label is required.');
            return;
        }

        if (empty($value)) {
            $value = $label;
        }

        $this->options[] = [
            'label' => $label,
            'value' => $value,
        ];

        $this->newOptionLabel = '';
        $this->newOptionValue = '';
        $this->resetErrorBag(['newOptionLabel', 'newOptionValue']);
    }

    public function removeOption(int $index): void
    {
        if (isset($this->options[$index])) {
            unset($this->options[$index]);
            $this->options = array_values($this->options);
        }
    }

    public function saveField(): void
    {
        $this->name = Str::snake(Str::slug(trim($this->name), '_'));

        $rules = [
            'label'         => 'required|string|min:2|max:150',
            'name'          => 'required|string|min:2|max:50|alpha_dash|unique:rfq_form_fields,name,' . ($this->editingFieldId ?? 'NULL'),
            'type'          => 'required|string|in:text,email,tel,number,textarea,select,radio,checkbox,date',
            'width'         => 'required|integer|in:3,4,6,12',
            'placeholder'   => 'nullable|string|max:200',
            'default_value' => 'nullable|string|max:200',
            'help_text'     => 'nullable|string|max:255',
            'order'         => 'required|integer|min:0',
            'is_required'   => 'boolean',
            'is_active'     => 'boolean',
        ];

        $this->validate($rules);

        // Sanitize options if select/radio/checkbox
        $cleanOptions = null;
        if (in_array($this->type, ['select', 'radio', 'checkbox'])) {
            $cleanOptions = array_values(array_filter($this->options, function ($opt) {
                return !empty(trim($opt['label'] ?? '')) && !empty(trim($opt['value'] ?? ''));
            }));
        }

        $data = [
            'label'         => trim($this->label),
            'name'          => trim($this->name),
            'type'          => $this->type,
            'width'         => (int) $this->width,
            'placeholder'   => trim($this->placeholder ?: ''),
            'default_value' => trim($this->default_value ?: ''),
            'help_text'     => trim($this->help_text ?: ''),
            'order'         => (int) $this->order,
            'is_required'   => (bool) $this->is_required,
            'is_active'     => (bool) $this->is_active,
            'options'       => $cleanOptions,
        ];

        if ($this->editingFieldId) {
            $field = RfqFormField::findOrFail($this->editingFieldId);
            $field->update($data);
            session()->flash('message', "Field '{$this->label}' updated successfully.");
        } else {
            RfqFormField::create($data);
            session()->flash('message', "Field '{$this->label}' added to RFQ form.");
        }

        $this->isFieldModalOpen = false;
        $this->resetFieldForm();
    }

    public function toggleFieldActive(int $id): void
    {
        $field = RfqFormField::findOrFail($id);
        $field->update(['is_active' => !$field->is_active]);
        $status = $field->is_active ? 'activated' : 'deactivated';
        session()->flash('message', "Field '{$field->label}' has been {$status}.");
    }

    public function moveUp(int $id): void
    {
        $field = RfqFormField::findOrFail($id);
        $previous = RfqFormField::where('order', '<', $field->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previous) {
            $currentOrder = $field->order;
            $field->update(['order' => $previous->order]);
            $previous->update(['order' => $currentOrder]);
        }
    }

    public function moveDown(int $id): void
    {
        $field = RfqFormField::findOrFail($id);
        $next = RfqFormField::where('order', '>', $field->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($next) {
            $currentOrder = $field->order;
            $field->update(['order' => $next->order]);
            $next->update(['order' => $currentOrder]);
        }
    }

    public function confirmDelete(int $id): void
    {
        $field = RfqFormField::findOrFail($id);
        $this->deleteFieldId = $field->id;
        $this->deleteFieldName = $field->label;
        $this->isDeleteModalOpen = true;
    }

    public function executeDelete(): void
    {
        if ($this->deleteFieldId) {
            $field = RfqFormField::find($this->deleteFieldId);
            if ($field) {
                $name = $field->label;
                $field->delete();
                session()->flash('message', "Field '{$name}' deleted from RFQ form.");
            }
        }

        $this->isDeleteModalOpen = false;
        $this->deleteFieldId = null;
        $this->deleteFieldName = '';
    }

    public function resetToDefaults(): void
    {
        RfqFormField::truncate();
        foreach (RfqFormField::getDefaultFields() as $field) {
            RfqFormField::create($field);
        }

        session()->flash('message', 'RFQ form fields have been restored to the default marine engineering template.');
    }

    private function resetFieldForm(): void
    {
        $this->editingFieldId = null;
        $this->label = '';
        $this->name = '';
        $this->type = 'text';
        $this->placeholder = '';
        $this->width = 12;
        $this->is_required = false;
        $this->default_value = '';
        $this->help_text = '';
        $this->order = 0;
        $this->is_active = true;
        $this->options = [];
        $this->newOptionLabel = '';
        $this->newOptionValue = '';
        $this->resetValidation();
    }

    public function render()
    {
        $fields = RfqFormField::orderBy('order', 'asc')->get();

        return view('livewire.admin.enquiries.rfq-form-builder', [
            'fields' => $fields,
        ]);
    }
}
