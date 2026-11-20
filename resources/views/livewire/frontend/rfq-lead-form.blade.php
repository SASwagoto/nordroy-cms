<div>
    @if ($isSubmitted)
        <!-- SUCCESS CONFIRMATION STATE -->
        <div class="p-8 sm:p-10 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 text-center space-y-6 transition-all duration-300">
            <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 mx-auto flex items-center justify-center border border-emerald-500/20">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-mono font-bold bg-emerald-600 text-white shadow-sm">
                    <span>REFERENCE CODE:</span>
                    <span class="tracking-wider">{{ $referenceCode }}</span>
                </span>
                <h3 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white pt-2">
                    {{ __('Technical RFQ Successfully Transmitted') }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-lg mx-auto leading-relaxed">
                    {{ __('Our duty marine engineering superintendents and flying squad coordinators at Chattogram & Mongla have received your inquiry.') }}
                </p>
            </div>

            <!-- Dynamic Response SLA & Transmission Summary -->
            <div class="max-w-xl mx-auto p-4 sm:p-5 rounded-xl bg-white/90 dark:bg-slate-900/90 border border-slate-200/80 dark:border-slate-800 text-left space-y-3 text-xs shadow-xs">
                <div class="flex items-center justify-between text-[11px] font-mono pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-slate-500 dark:text-slate-400 uppercase font-semibold">{{ __('Duty Desk Protocol:') }}</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        {{ __('Response within 45 Mins') }}
                    </span>
                </div>

                @if(!empty($submittedData))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 font-mono text-[11px]">
                        @foreach($submittedData as $item)
                            @if(!empty($item['value']) && $item['type'] !== 'textarea')
                                <div class="p-2 rounded-lg bg-slate-50 dark:bg-slate-950/40 border border-slate-100 dark:border-slate-800">
                                    <span class="text-slate-400 block text-[10px] uppercase truncate">{{ $item['label'] }}:</span>
                                    <span class="font-bold text-slate-800 dark:text-slate-200 truncate block">
                                        {{ is_bool($item['value']) ? ($item['value'] ? 'Yes' : 'No') : $item['value'] }}
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="pt-2">
                <button type="button" 
                        wire:click="resetForm" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-slate-950 hover:opacity-90 transition-all cursor-pointer shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>{{ __('Submit Another Inquiry') }}</span>
                </button>
            </div>
        </div>

    @else
        <!-- ACTIVE DYNAMIC FORM -->
        <form wire:submit.prevent="submitRfq" class="space-y-4">
            
            <!-- Honeypot -->
            <div class="hidden" aria-hidden="true">
                <input type="text" wire:model="extra_honey" tabindex="-1" autocomplete="off" />
            </div>

            <!-- Dynamic 12-Column Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @foreach($fields as $field)
                    @php
                        $colSpan = match((int) $field->width) {
                            3 => 'col-span-1 md:col-span-3',
                            4 => 'col-span-1 md:col-span-4',
                            6 => 'col-span-1 md:col-span-6',
                            default => 'col-span-1 md:col-span-12',
                        };
                        $errorKey = 'formData.' . $field->name;
                    @endphp

                    <div wire:key="rfq-input-{{ $field->id }}" class="{{ $colSpan }}">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $field->label }}
                            @if($field->is_required)
                                <span class="text-rose-500">*</span>
                            @endif
                        </label>

                        @if($field->type === 'textarea')
                            <textarea wire:model="formData.{{ $field->name }}" 
                                      rows="3" 
                                      placeholder="{{ $field->placeholder }}" 
                                      class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border @error($errorKey) border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none transition-colors"></textarea>

                        @elseif($field->type === 'select')
                            <select wire:model="formData.{{ $field->name }}" 
                                    class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border @error($errorKey) border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none transition-colors">
                                <option value="">{{ $field->placeholder ?: 'Select ' . $field->label }}</option>
                                @foreach($field->options ?? [] as $opt)
                                    <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                @endforeach
                            </select>

                        @elseif($field->type === 'radio')
                            <div class="flex flex-wrap gap-4 pt-1.5">
                                @foreach($field->options ?? [] as $opt)
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-slate-700 dark:text-slate-300">
                                        <input type="radio" 
                                               wire:model="formData.{{ $field->name }}" 
                                               value="{{ $opt['value'] }}" 
                                               class="text-[#003C58] focus:ring-0">
                                        <span>{{ $opt['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($field->type === 'checkbox')
                            <div class="pt-2">
                                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-slate-700 dark:text-slate-300">
                                    <input type="checkbox" 
                                           wire:model="formData.{{ $field->name }}" 
                                           class="rounded text-[#003C58] focus:ring-0">
                                    <span>{{ $field->placeholder ?: $field->label }}</span>
                                </label>
                            </div>

                        @else
                            <input type="{{ $field->type }}" 
                                   wire:model="formData.{{ $field->name }}" 
                                   placeholder="{{ $field->placeholder }}" 
                                   class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border @error($errorKey) border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none transition-colors" />
                        @endif

                        @error($errorKey)
                            <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror

                        @if(!empty($field->help_text))
                            <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $field->help_text }}</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        wire:loading.attr="disabled" 
                        class="w-full py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white shadow-md active:scale-95 transition-all cursor-pointer flex items-center justify-center gap-2 group disabled:opacity-70"
                        style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                    
                    <span wire:loading.remove wire:target="submitRfq" class="inline-flex items-center justify-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                        <span>{{ __('Transmit RFQ to 24/7 Port Duty Desk') }}</span>
                    </span>

                    <span wire:loading.inline-flex wire:target="submitRfq" class="items-center justify-center gap-2 whitespace-nowrap" style="display: none;">
                        <svg class="w-4 h-4 shrink-0 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('Encoding & Transmitting Inquiry...') }}</span>
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
