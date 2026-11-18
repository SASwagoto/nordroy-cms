<?php

namespace App\Livewire\Admin\Languages;

use App\Models\Language;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class LanguageManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $isFormModalOpen = false;
    public ?int $editingLanguageId = null;

    // Form fields
    public string $name = '';
    public string $code = '';
    public string $native_name = '';
    public string $direction = 'ltr';
    public string $flag_icon = '🌐';
    public bool $is_default = false;
    public bool $is_active = true;
    public int $order = 0;

    // Delete confirmation state
    public bool $isDeleteModalOpen = false;
    public ?int $languageIdToDelete = null;

    protected function rules(): array
    {
        return [
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|min:2|max:10|regex:/^[a-z0-9_-]+$/|unique:languages,code,' . ($this->editingLanguageId ?? 'NULL') . ',id',
            'native_name' => 'required|string|max:100',
            'direction'   => 'required|in:ltr,rtl',
            'flag_icon'   => 'nullable|string|max:50',
            'is_default'  => 'boolean',
            'is_active'   => 'boolean',
            'order'       => 'integer|min:0',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function createLanguage(): void
    {
        $this->resetValidation();
        $this->editingLanguageId = null;
        $this->name = '';
        $this->code = '';
        $this->native_name = '';
        $this->direction = 'ltr';
        $this->flag_icon = '🌐';
        $this->is_default = false;
        $this->is_active = true;
        $this->order = (int) (Language::max('order') ?? 0) + 1;

        $this->isFormModalOpen = true;
    }

    public function editLanguage(int $id): void
    {
        $this->resetValidation();
        $lang = Language::findOrFail($id);

        $this->editingLanguageId = $lang->id;
        $this->name = $lang->name;
        $this->code = $lang->code;
        $this->native_name = $lang->native_name;
        $this->direction = $lang->direction;
        $this->flag_icon = $lang->flag_icon ?? '🌐';
        $this->is_default = (bool) $lang->is_default;
        $this->is_active = (bool) $lang->is_active;
        $this->order = (int) $lang->order;

        $this->isFormModalOpen = true;
    }

    public function saveLanguage(): void
    {
        $this->code = strtolower(trim($this->code));
        $this->validate();

        if ($this->is_default) {
            $this->is_active = true;
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        $payload = [
            'name'        => trim($this->name),
            'code'        => $this->code,
            'native_name' => trim($this->native_name),
            'direction'   => $this->direction,
            'flag_icon'   => trim($this->flag_icon) ?: '🌐',
            'is_default'  => $this->is_default,
            'is_active'   => $this->is_active,
            'order'       => $this->order,
        ];

        if ($this->editingLanguageId) {
            $lang = Language::findOrFail($this->editingLanguageId);
            $lang->update($payload);
            session()->flash('message', "Language '{$lang->name}' updated successfully.");
        } else {
            Language::create($payload);
            session()->flash('message', "Language '{$this->name}' added successfully.");
        }

        $this->closeModal();
    }

    public function toggleActive(int $id): void
    {
        $lang = Language::findOrFail($id);

        if ($lang->is_default && $lang->is_active) {
            session()->flash('error', 'Cannot deactivate the default language. Set another language as default first.');
            return;
        }

        $lang->update(['is_active' => ! $lang->is_active]);
        session()->flash('message', "Status for '{$lang->name}' toggled successfully.");
    }

    public function setDefault(int $id): void
    {
        $lang = Language::findOrFail($id);

        Language::where('is_default', true)->update(['is_default' => false]);
        $lang->update([
            'is_default' => true,
            'is_active'  => true,
        ]);

        session()->flash('message', "'{$lang->name}' is now set as the primary default language.");
    }

    public function confirmDelete(int $id): void
    {
        $lang = Language::findOrFail($id);

        if ($lang->is_default) {
            session()->flash('error', 'Cannot delete the system default language.');
            return;
        }

        $this->languageIdToDelete = $lang->id;
        $this->isDeleteModalOpen = true;
    }

    public function deleteLanguage(): void
    {
        if ($this->languageIdToDelete) {
            $lang = Language::findOrFail($this->languageIdToDelete);

            if ($lang->is_default) {
                session()->flash('error', 'Cannot delete the system default language.');
                $this->isDeleteModalOpen = false;
                return;
            }

            $name = $lang->name;
            $lang->delete();
            session()->flash('message', "Language '{$name}' deleted successfully.");
        }

        $this->isDeleteModalOpen = false;
        $this->languageIdToDelete = null;
    }

    public function closeModal(): void
    {
        $this->isFormModalOpen = false;
        $this->editingLanguageId = null;
    }

    public function render()
    {
        $query = Language::query();

        if (!empty(trim($this->search))) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('code', 'like', $term)
                  ->orWhere('native_name', 'like', $term);
            });
        }

        $languages = $query->orderBy('order', 'asc')->orderBy('id', 'asc')->paginate(15);

        $stats = [
            'total'   => Language::count(),
            'active'  => Language::where('is_active', true)->count(),
            'default' => Language::where('is_default', true)->first()?->name ?? 'English',
        ];

        return view('livewire.admin.languages.language-manager', [
            'languages' => $languages,
            'stats'     => $stats,
        ]);
    }
}
