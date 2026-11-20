<div>
    @if ($isSubmitted)
        <!-- SUCCESS CONFIRMATION STATE -->
        <div class="p-8 sm:p-10 rounded-3xl bg-emerald-50/80 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 text-center space-y-6 transition-all duration-300">
            <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 mx-auto flex items-center justify-center border border-emerald-500/20">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-mono font-bold bg-emerald-600 text-white shadow-sm">
                    <span>APPLICATION ID:</span>
                    <span class="tracking-wider">{{ $referenceCode }}</span>
                </span>
                <h3 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white pt-2">
                    {{ __('Application Successfully Submitted') }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-lg mx-auto leading-relaxed">
                    {{ __('Our marine superintendents and talent acquisition team have received your credentials. Qualified candidates are contacted within 3 to 5 business days.') }}
                </p>
            </div>

            <!-- Position Target Info -->
            @if($job)
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <x-icon name="solid:briefcase" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span>Applied for: <strong>{{ $job->title }}</strong> ({{ $job->department }})</span>
                </div>
            @endif

            <div class="pt-2">
                <button type="button" 
                        wire:click="resetForm" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-slate-950 hover:opacity-90 transition-all cursor-pointer shadow-sm">
                    <x-icon name="solid:arrow-path" class="w-3.5 h-3.5" />
                    <span>{{ __('Submit Another Application') }}</span>
                </button>
            </div>
        </div>

    @else
        <!-- ACTIVE DYNAMIC JOB APPLICATION FORM -->
        <form wire:submit.prevent="submitApplication" class="space-y-4">
            
            <!-- Honeypot -->
            <div class="hidden" aria-hidden="true">
                <input type="text" wire:model="extra_honey" tabindex="-1" autocomplete="off" />
            </div>

            <!-- Dynamic 12-Column Responsive Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @foreach($fields as $field)
                    @php
                        $colSpan = match((int) $field->width) {
                            3 => 'col-span-1 md:col-span-3',
                            4 => 'col-span-1 md:col-span-4',
                            6 => 'col-span-1 md:col-span-6',
                            default => 'col-span-1 md:col-span-12',
                        };
                        $errorKey = ($field->type === 'file') ? 'resumeFile' : ('formData.' . $field->name);
                    @endphp

                    <div wire:key="job-input-{{ $field->id }}" class="{{ $colSpan }}">
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

                        @elseif($field->type === 'file')
                            <div class="relative">
                                <label class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border @error('resumeFile') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-600 dark:text-slate-400 cursor-pointer hover:border-[#003C58] dark:hover:border-cyan-500 transition-colors">
                                    <div class="flex items-center gap-2 truncate">
                                        <x-icon name="solid:paperclip" class="w-4 h-4 text-[#003C58] dark:text-cyan-400 shrink-0" />
                                        @if($resumeFile)
                                            <span class="font-bold text-slate-900 dark:text-white truncate">{{ $resumeFile->getClientOriginalName() }}</span>
                                        @else
                                            <span class="truncate">{{ $field->placeholder ?: __('Choose PDF / Word Resume...') }}</span>
                                        @endif
                                    </div>
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 shrink-0">
                                        Browse
                                    </span>
                                    <input type="file" wire:model="resumeFile" accept=".pdf,.doc,.docx" class="hidden" />
                                </label>
                                
                                <div wire:loading wire:target="resumeFile" class="text-[10px] text-cyan-600 dark:text-cyan-400 pt-1 font-semibold flex items-center gap-1">
                                    <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>Uploading resume file...</span>
                                </div>
                            </div>

                        @elseif($field->type === 'radio')
                            <div class="flex flex-wrap gap-4 pt-1.5">
                                @foreach($field->options ?? [] as $opt)
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-slate-700 dark:text-slate-300">
                                        <input type="radio" wire:model="formData.{{ $field->name }}" value="{{ $opt['value'] }}" class="text-[#003C58] focus:ring-0">
                                        <span>{{ $opt['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($field->type === 'checkbox')
                            <div class="pt-2">
                                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-slate-700 dark:text-slate-300">
                                    <input type="checkbox" wire:model="formData.{{ $field->name }}" class="rounded text-[#003C58] focus:ring-0">
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
                    
                    <span wire:loading.remove wire:target="submitApplication, resumeFile" class="inline-flex items-center justify-center gap-2 whitespace-nowrap">
                        <x-icon name="solid:paper-airplane" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" />
                        <span>{{ __('Submit Application to Nordroy Engineering Team') }}</span>
                    </span>

                    <span wire:loading.inline-flex wire:target="submitApplication, resumeFile" class="items-center justify-center gap-2 whitespace-nowrap" style="display: none;">
                        <svg class="w-4 h-4 shrink-0 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('Processing & Transmitting Credentials...') }}</span>
                    </span>
                </button>
            </div>
        </form>
    @endif
</div>
