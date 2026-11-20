<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.enquiries') }}" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Back to Inquiries">
                    <x-icon name="solid:arrow-left" class="w-4 h-4" />
                </a>
                <h1 class="text-xl font-bold font-heading text-slate-900 dark:text-white">RFQ &amp; Inquiry Form Builder</h1>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20">
                    {{ $fields->count() }} FIELDS
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Customize what fields appear on the public RFQ form, set widths (100%, 50%, 33%, 25%), select dropdown options, placeholders, and validation rules.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.enquiries') }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors inline-flex items-center gap-1.5 cursor-pointer">
                <x-icon name="solid:inbox" class="w-3.5 h-3.5" />
                <span>Duty Desk Leads</span>
            </a>

            <button type="button" 
                    wire:click="resetToDefaults" 
                    wire:confirm="Are you sure you want to restore the recommended Marine Turbocharger default fields? Any custom fields will be replaced."
                    class="px-3 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-1.5 cursor-pointer"
                    title="Restore default marine engineering form fields">
                <x-icon name="solid:arrow-path" class="w-3.5 h-3.5" />
                <span>Restore Defaults</span>
            </button>

            <button type="button" 
                    wire:click="openCreateFieldModal" 
                    class="px-3.5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-1.5 cursor-pointer">
                <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                <span>Add Form Field</span>
            </button>
        </div>
    </div>

    <!-- Flash Alert -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs flex items-center justify-between transition-all">
            <div class="flex items-center gap-2">
                <x-icon name="solid:check-circle" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
                <span>{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Main Builder Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Field Structure & Ordering Table (7 cols) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="bg-white dark:bg-[#07131e] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
                <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">Configured Form Fields</h2>
                        <p class="text-[11px] text-slate-400">Order determines top-to-bottom layout sequence on the frontend.</p>
                    </div>
                    <span class="text-xs font-mono text-slate-400">{{ $fields->where('is_active', true)->count() }} Active</span>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($fields as $index => $field)
                        <div wire:key="field-item-{{ $field->id }}" 
                             class="p-4 flex items-center justify-between gap-4 hover:bg-slate-50/60 dark:hover:bg-slate-900/40 transition-colors {{ !$field->is_active ? 'opacity-50 bg-slate-50/40 dark:bg-slate-950/20' : '' }}">
                            
                            <!-- Left: Order controls + Field Info -->
                            <div class="flex items-center gap-3.5 min-w-0">
                                <!-- Reorder Buttons -->
                                <div class="flex flex-col gap-0.5 shrink-0 text-slate-400">
                                    <button type="button" 
                                            wire:click="moveUp({{ $field->id }})" 
                                            class="p-0.5 hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-pointer disabled:opacity-30"
                                            @if($loop->first) disabled @endif
                                            title="Move Up">
                                        <x-icon name="solid:chevron-up" class="w-3.5 h-3.5" />
                                    </button>
                                    <button type="button" 
                                            wire:click="moveDown({{ $field->id }})" 
                                            class="p-0.5 hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-pointer disabled:opacity-30"
                                            @if($loop->last) disabled @endif
                                            title="Move Down">
                                        <x-icon name="solid:chevron-down" class="w-3.5 h-3.5" />
                                    </button>
                                </div>

                                <!-- Field Details -->
                                <div class="min-w-0 space-y-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                            {{ $field->label }}
                                        </span>
                                        @if($field->is_required)
                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                                Required
                                            </span>
                                        @else
                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-500">
                                                Optional
                                            </span>
                                        @endif

                                        <!-- Type Badge -->
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-mono font-semibold uppercase bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20">
                                            {{ $field->type }}
                                        </span>

                                        <!-- Width Badge -->
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-mono bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20">
                                            @if($field->width == 12) 100% Full @elseif($field->width == 6) 50% Half @elseif($field->width == 4) 33% (1/3) @else 25% (1/4) @endif
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3 text-[11px] text-slate-400 font-mono">
                                        <span>key: <strong class="text-slate-600 dark:text-slate-300">{{ $field->name }}</strong></span>
                                        @if(!empty($field->placeholder))
                                            <span class="truncate max-w-[200px]" title="{{ $field->placeholder }}">placeholder: "{{ $field->placeholder }}"</span>
                                        @endif
                                        @if(in_array($field->type, ['select', 'radio', 'checkbox']) && !empty($field->options))
                                            <span class="text-indigo-500 dark:text-indigo-400 font-semibold">({{ count($field->options) }} options)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Actions -->
                            <div class="flex items-center gap-1.5 shrink-0">
                                <!-- Active Toggle -->
                                <button type="button" 
                                        wire:click="toggleFieldActive({{ $field->id }})" 
                                        class="px-2 py-1 rounded-lg text-[11px] font-semibold transition-colors cursor-pointer {{ $field->is_active ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 border border-slate-200 dark:border-slate-700' }}"
                                        title="{{ $field->is_active ? 'Click to deactivate' : 'Click to activate' }}">
                                    {{ $field->is_active ? 'Active' : 'Disabled' }}
                                </button>

                                <!-- Edit -->
                                <button type="button" 
                                        wire:click="editField({{ $field->id }})" 
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                                        title="Edit field settings">
                                    <x-icon name="solid:pencil-square" class="w-4 h-4" />
                                </button>

                                <!-- Delete -->
                                <button type="button" 
                                        wire:click="confirmDelete({{ $field->id }})" 
                                        class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                        title="Delete field">
                                    <x-icon name="solid:trash" class="w-4 h-4" />
                                </button>
                            </div>

                        </div>
                    @empty
                        <div class="p-12 text-center text-xs text-slate-400 space-y-3">
                            <x-icon name="solid:adjustments-horizontal" class="w-8 h-8 mx-auto text-slate-300 dark:text-slate-700" />
                            <p>No form fields currently configured.</p>
                            <button type="button" wire:click="resetToDefaults" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#003C58] text-white">
                                Load Recommended Marine RFQ Template
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Live Visual Preview of Form (5 cols) -->
        <div class="lg:col-span-5 space-y-4 sticky top-6">
            <div class="bg-white dark:bg-[#07131e] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Live Form Preview</h3>
                    </div>
                    <span class="text-[10px] text-slate-400 font-mono">Frontend Real-time Sync</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/80 dark:bg-slate-950/60 border border-slate-200/60 dark:border-slate-800/80 space-y-4">
                    <div class="grid grid-cols-12 gap-3">
                        @foreach($fields->where('is_active', true) as $f)
                            @php
                                $colSpan = match((int) $f->width) {
                                    3 => 'col-span-3',
                                    4 => 'col-span-4',
                                    6 => 'col-span-6',
                                    default => 'col-span-12',
                                };
                            @endphp
                            <div class="{{ $colSpan }} space-y-1">
                                <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 truncate">
                                    {{ $f->label }}
                                    @if($f->is_required) <span class="text-rose-500">*</span> @endif
                                </label>

                                @if($f->type === 'textarea')
                                    <textarea disabled rows="2" placeholder="{{ $f->placeholder }}" class="w-full px-2.5 py-1.5 rounded-lg text-[11px] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 resize-none opacity-80"></textarea>
                                @elseif($f->type === 'select')
                                    <select disabled class="w-full px-2.5 py-1.5 rounded-lg text-[11px] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 opacity-80">
                                        <option>{{ $f->placeholder ?: 'Select ' . $f->label }}</option>
                                        @foreach($f->options ?? [] as $opt)
                                            <option>{{ $opt['label'] }}</option>
                                        @endforeach
                                    </select>
                                @elseif($f->type === 'radio')
                                    <div class="flex flex-wrap gap-2 pt-1 text-[10px] text-slate-500">
                                        @foreach($f->options ?? [] as $opt)
                                            <label class="inline-flex items-center gap-1 opacity-80">
                                                <input type="radio" disabled>
                                                <span>{{ $opt['label'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif($f->type === 'checkbox')
                                    <label class="inline-flex items-center gap-1.5 pt-1 text-[11px] text-slate-600 dark:text-slate-400 opacity-80">
                                        <input type="checkbox" disabled class="rounded">
                                        <span>{{ $f->placeholder ?: $f->label }}</span>
                                    </label>
                                @else
                                    <input type="{{ $f->type }}" disabled placeholder="{{ $f->placeholder }}" value="{{ $f->default_value }}" class="w-full px-2.5 py-1.5 rounded-lg text-[11px] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 opacity-80" />
                                @endif

                                @if(!empty($f->help_text))
                                    <span class="text-[9px] text-slate-400 block truncate">{{ $f->help_text }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button type="button" disabled class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-[#003C58] dark:bg-cyan-600 opacity-70 cursor-not-allowed">
                        Transmit RFQ to Duty Desk &rarr;
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ==================== FIELD CREATE / EDIT MODAL ==================== -->
    @if ($isFieldModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto"
             role="dialog">
            
            <div class="w-full max-w-2xl bg-white dark:bg-[#07131e] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden my-8"
                 @click.outside="$wire.set('isFieldModalOpen', false)">
                
                <!-- Modal Header -->
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $editingFieldId ? 'Edit Form Field' : 'Add New Form Field' }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Configure field input type, width span, placeholder, and dropdown selection options.
                        </p>
                    </div>
                    <button type="button" wire:click="$set('isFieldModalOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <x-icon name="solid:xmark" class="w-5 h-5" />
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="saveField" class="p-6 space-y-5">
                    
                    <!-- Row 1: Label & Machine Key -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Field Display Label <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="label" 
                                   placeholder="e.g. Vessel IMO Number" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border @error('label') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                            @error('label')
                                <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Field Key / Machine Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="name" 
                                   placeholder="e.g. vessel_imo_number" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs font-mono bg-slate-50 dark:bg-slate-900 border @error('name') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Lowercase alphanumeric and underscores (e.g. engine_kw).</span>
                            @error('name')
                                <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 2: Field Type & Width Span -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Field Input Type <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model.live="type" 
                                    class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none">
                                <option value="text">Text (Single-Line Input)</option>
                                <option value="email">Email Address</option>
                                <option value="tel">Telephone / WhatsApp</option>
                                <option value="number">Numeric Input</option>
                                <option value="textarea">Textarea (Multi-Line Text)</option>
                                <option value="select">Select Dropdown (Choose One)</option>
                                <option value="radio">Radio Buttons (Exclusive Choice)</option>
                                <option value="checkbox">Single Checkbox (True/False)</option>
                                <option value="date">Date Picker</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Field Width (12-Column Grid Span) <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-4 gap-1.5 pt-0.5">
                                <button type="button" wire:click="$set('width', 12)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $width == 12 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100' }}">
                                    100% (Full)
                                </button>
                                <button type="button" wire:click="$set('width', 6)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $width == 6 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100' }}">
                                    50% (Half)
                                </button>
                                <button type="button" wire:click="$set('width', 4)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $width == 4 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100' }}">
                                    33% (1/3)
                                </button>
                                <button type="button" wire:click="$set('width', 3)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $width == 3 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100' }}">
                                    25% (1/4)
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Placeholder & Default Value -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Placeholder Text
                            </label>
                            <input type="text" 
                                   wire:model="placeholder" 
                                   placeholder="e.g. Enter vessel IMO number..." 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Default Value (Optional)
                            </label>
                            <input type="text" 
                                   wire:model="default_value" 
                                   placeholder="e.g. Chattogram Port" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Row 4: Help Text & Ordering -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Help / Guidance Note (Optional)
                            </label>
                            <input type="text" 
                                   wire:model="help_text" 
                                   placeholder="e.g. Located on the engine builder certificate." 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Sort Order
                            </label>
                            <input type="number" 
                                   wire:model="order" 
                                   min="0"
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Row 5: Switches (Required, Active) -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between gap-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="is_required" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Required Field</span>
                                <span class="text-[10px] text-slate-400">User cannot submit form without filling this field.</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="w-4 h-4 rounded text-emerald-600 focus:ring-0">
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Active Status</span>
                                <span class="text-[10px] text-slate-400">Visible and active on public form.</span>
                            </div>
                        </label>
                    </div>

                    <!-- Dynamic Options Manager (For Select, Radio, Checkbox) -->
                    @if(in_array($type, ['select', 'radio', 'checkbox']))
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                                    <x-icon name="solid:list-bullet" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                                    <span>Dropdown / Radio Options ({{ count($options) }})</span>
                                </h4>
                                <span class="text-[10px] text-slate-400">Configure selectable values</span>
                            </div>

                            <!-- Options List -->
                            @if(count($options) > 0)
                                <div class="space-y-1.5 max-h-48 overflow-y-auto no-scrollbar pr-1">
                                    @foreach($options as $idx => $opt)
                                        <div wire:key="opt-row-{{ $idx }}" class="flex items-center justify-between gap-2 p-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs">
                                            <div class="flex items-center gap-2 truncate">
                                                <span class="w-5 h-5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 font-mono text-[10px] flex items-center justify-center shrink-0">{{ $idx + 1 }}</span>
                                                <span class="font-bold text-slate-800 dark:text-slate-200 truncate">{{ $opt['label'] }}</span>
                                                <span class="text-[10px] text-slate-400 font-mono">({{ $opt['value'] }})</span>
                                            </div>
                                            <button type="button" wire:click="removeOption({{ $idx }})" class="p-1 text-rose-500 hover:text-rose-700 cursor-pointer" title="Remove option">
                                                <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-slate-400 text-center py-2 italic">No options defined yet. Add choices below.</p>
                            @endif

                            <!-- Add New Option Row -->
                            <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center gap-2">
                                <input type="text" 
                                       wire:model="newOptionLabel" 
                                       wire:keydown.enter.prevent="addOption"
                                       placeholder="Option Label (e.g. Urgent Port Call)" 
                                       class="flex-1 px-3 py-1.5 rounded-xl text-xs bg-white dark:bg-slate-950 border @error('newOptionLabel') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white" />
                                
                                <input type="text" 
                                       wire:model="newOptionValue" 
                                       wire:keydown.enter.prevent="addOption"
                                       placeholder="Value (optional)" 
                                       class="w-36 px-3 py-1.5 rounded-xl text-xs bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono" />

                                <button type="button" 
                                        wire:click="addOption" 
                                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 hover:opacity-90 shrink-0 cursor-pointer">
                                    + Add
                                </button>
                            </div>
                            @error('newOptionLabel')
                                <span class="text-[11px] text-rose-500 block">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                        <button type="button" 
                                wire:click="$set('isFieldModalOpen', false)" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all cursor-pointer">
                            {{ $editingFieldId ? 'Update Field' : 'Save & Add Field' }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

    <!-- ==================== DELETE CONFIRMATION MODAL ==================== -->
    @if ($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs" role="dialog">
            <div class="w-full max-w-md bg-white dark:bg-[#07131e] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4"
                 @click.outside="$wire.set('isDeleteModalOpen', false)">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto">
                    <x-icon name="solid:trash" class="w-6 h-6" />
                </div>
                <div class="text-center space-y-1">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete Form Field</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Are you sure you want to permanently delete field <strong class="text-slate-800 dark:text-slate-200">"{{ $deleteFieldName }}"</strong>?
                        It will no longer appear on the public RFQ form.
                    </p>
                </div>
                <div class="pt-3 flex items-center justify-center gap-3">
                    <button type="button" wire:click="$set('isDeleteModalOpen', false)" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 cursor-pointer">
                        Cancel
                    </button>
                    <button type="button" wire:click="executeDelete" class="px-5 py-2 rounded-xl text-xs font-bold bg-rose-600 text-white hover:bg-rose-700 cursor-pointer shadow-sm">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
