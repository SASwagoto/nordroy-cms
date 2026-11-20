<x-layouts.frontend title="{{ __('Careers & Marine Engineering Vacancies') }} | Nordroy Marine">

    <!-- Alpine Container for Filter & Detail Drawer / Modal -->
    <div x-data="{
            activeDept: 'all',
            selectedJob: null,
            isModalOpen: false,

            openJobModal(job) {
                this.selectedJob = job;
                this.isModalOpen = true;
                if (window.Livewire) {
                    window.Livewire.dispatch('set-job-id', { id: job.id });
                }
            },

            closeJobModal() {
                this.isModalOpen = false;
                this.selectedJob = null;
            }
         }"
         @keydown.escape.window="closeJobModal()">

        <!-- Hero Header -->
        <section class="pt-24 pb-14 sm:pt-28 sm:pb-18 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-6">
                
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">{{ __('Home') }}</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-slate-800 dark:text-slate-200 font-bold">{{ __('Careers') }}</span>
                </nav>

                <div class="max-w-4xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20">
                            {{ __('Talent & Engineering Careers') }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                            &bull; {{ $jobs->count() }} {{ __('Open Vacancies') }}
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
                        {{ __('Build Your Career in High-Precision Turbomachinery') }}
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                        {{ __('Join our world-class marine engineering team in Chattogram & Dhaka. Operate hard-bearing dynamic balancing benches up to 100,000 RPM, board international ocean-going vessels at outer anchorage, and service heavy multi-brand industrial turbochargers.') }}
                    </p>
                </div>

                <!-- Engineering Culture Highlights -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-1">
                        <x-icon name="solid:cpu-chip" class="w-5 h-5 text-[#003C58] dark:text-cyan-400" />
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white">{{ __('Precision Instruments') }}</h4>
                        <p class="text-[11px] text-slate-500">{{ __('Schenck balancing, NDT testing & 5-axis CAD/CAM benches.') }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-1">
                        <x-icon name="solid:lifebuoy" class="w-5 h-5 text-rose-500" />
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white">{{ __('Offshore Flying Squads') }}</h4>
                        <p class="text-[11px] text-slate-500">{{ __('Deep sea anchorage interventions with safety per-diem allowances.') }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-1">
                        <x-icon name="solid:academic-cap" class="w-5 h-5 text-emerald-500" />
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white">{{ __('OEM Certifications') }}</h4>
                        <p class="text-[11px] text-slate-500">{{ __('Continuous training programs on ABB, MAN, and Napier series.') }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 space-y-1">
                        <x-icon name="solid:shield-check" class="w-5 h-5 text-indigo-500" />
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white">{{ __('Health & Safety (HSE)') }}</h4>
                        <p class="text-[11px] text-slate-500">{{ __('Full medical coverage, offshore insurance, and performance bonuses.') }}</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Main Open Positions Showcase -->
        <section class="py-12 sm:py-16 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-8">
                
                <!-- Filter Pills -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white">
                            {{ __('Active Job Openings') }}
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            {{ __('Explore available roles across our port workshops, engineering headquarters, and offshore flying squads.') }}
                        </p>
                    </div>

                    <!-- Department Filter Pills -->
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                        <button type="button" @click="activeDept = 'all'"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                                :class="activeDept === 'all' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800'">
                            {{ __('All Roles') }} ({{ $jobs->count() }})
                        </button>

                        @foreach($departments as $dept)
                            <button type="button" @click="activeDept = '{{ $dept }}'"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap"
                                    :class="activeDept === '{{ $dept }}' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800'">
                                {{ $dept }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Job Cards Grid -->
                @if($jobs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($jobs as $job)
                            <div wire:key="public-job-{{ $job->id }}"
                                 x-show="activeDept === 'all' || activeDept === '{{ $job->department }}'"
                                 class="group rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 p-6 shadow-xs hover:shadow-xl transition-all flex flex-col justify-between space-y-5">
                                
                                <div class="space-y-4">
                                    <!-- Badges -->
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/10 dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20 truncate">
                                            {{ $job->department }}
                                        </span>

                                        @if($job->is_featured)
                                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center gap-1">
                                                <x-icon name="solid:star" class="w-3 h-3 fill-current" />
                                                <span>{{ __('Featured') }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Job Title & Meta -->
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors">
                                            {{ $job->title }}
                                        </h3>
                                        
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 pt-2.5 text-xs text-slate-500 dark:text-slate-400">
                                            <span class="flex items-center gap-1.5">
                                                <x-icon name="solid:map-pin" class="w-3.5 h-3.5 text-slate-400" />
                                                <span>{{ $job->location }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <x-icon name="solid:clock" class="w-3.5 h-3.5 text-slate-400" />
                                                <span>{{ $job->employment_type }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <x-icon name="solid:academic-cap" class="w-3.5 h-3.5 text-slate-400" />
                                                <span>{{ $job->experience_level }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Description Excerpt -->
                                    <div class="text-xs text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($job->description), 140) }}
                                    </div>
                                </div>

                                <!-- Card Footer: Salary & Apply Trigger -->
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-slate-400 block uppercase">{{ __('Remuneration:') }}</span>
                                        <span class="text-xs font-bold text-[#003C58] dark:text-cyan-400">
                                            {{ $job->salary_range ?: __('Competitive / Negotiable') }}
                                        </span>
                                    </div>

                                    <button type="button" 
                                            @click="openJobModal(@js($job))"
                                            class="px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-2xs transition-all cursor-pointer inline-flex items-center gap-1.5">
                                        <span>{{ __('View & Apply') }}</span>
                                        <x-icon name="solid:arrow-right" class="w-3 h-3" />
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-slate-400 text-xs">
                        {{ __('No current vacancies match your search criteria.') }}
                    </div>
                @endif

            </div>
        </section>

        <!-- General Talent Pool / Spontaneous Application Section -->
        <section class="py-14 sm:py-20 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-4xl mx-auto px-4 sm:px-8 space-y-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
                    <x-icon name="solid:user-plus" class="w-3.5 h-3.5" />
                    <span>{{ __('Spontaneous Application') }}</span>
                </div>

                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-4xl font-black font-heading text-slate-900 dark:text-white">
                        {{ __('Don\'t See Your Specific Maritime Specialty?') }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed">
                        {{ __('We are continuously recruiting certified marine superintendents, non-destructive testing (NDT) metallurgists, and sea-going flying squad fitters. Submit your CV directly to our general engineering talent pool.') }}
                    </p>
                </div>

                <div class="p-6 sm:p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-left shadow-xs">
                    <div class="pb-4 mb-4 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ __('Submit General Candidate Credentials') }}</h3>
                        <p class="text-xs text-slate-400">{{ __('Complete the form below to enter Nordroy Marine talent repository.') }}</p>
                    </div>

                    <livewire:frontend.job-application-form :job-id="null" />
                </div>
            </div>
        </section>

        <!-- ==================== JOB DETAILS & DIRECT APPLY MODAL ==================== -->
        <div x-show="isModalOpen" 
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm overflow-y-auto"
             style="display: none;"
             role="dialog">
            
            <div class="w-full max-w-4xl bg-white dark:bg-[#07131e] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden my-8"
                 @click.outside="closeJobModal()">
                
                <!-- Modal Header -->
                <div class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-800 flex items-start justify-between gap-4">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/10 dark:text-cyan-400"
                                  x-text="selectedJob?.department"></span>
                            <span class="text-xs text-slate-400 font-semibold" x-text="selectedJob?.employment_type"></span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-heading" x-text="selectedJob?.title"></h2>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                            <span class="flex items-center gap-1">
                                <x-icon name="solid:map-pin" class="w-3.5 h-3.5" />
                                <span x-text="selectedJob?.location"></span>
                            </span>
                            <span class="flex items-center gap-1">
                                <x-icon name="solid:academic-cap" class="w-3.5 h-3.5" />
                                <span x-text="selectedJob?.experience_level"></span>
                            </span>
                            <span class="font-bold text-[#003C58] dark:text-cyan-400" x-text="selectedJob?.salary_range ? selectedJob?.salary_range : 'Negotiable'"></span>
                        </div>
                    </div>

                    <button type="button" @click="closeJobModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <x-icon name="solid:xmark" class="w-6 h-6" />
                    </button>
                </div>

                <!-- Modal Body: Tabs between Overview and Apply Form -->
                <div class="p-6 sm:p-8 space-y-8 max-h-[70vh] overflow-y-auto">
                    
                    <!-- Job Description -->
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">{{ __('Role Overview & Responsibilities:') }}</h4>
                        <div class="prose prose-sm dark:prose-invert text-xs text-slate-600 dark:text-slate-300 leading-relaxed" x-html="selectedJob?.description"></div>
                    </div>

                    <!-- Requirements -->
                    <template x-if="selectedJob?.requirements">
                        <div class="space-y-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">{{ __('Candidate Requirements & Qualifications:') }}</h4>
                            <div class="prose prose-sm dark:prose-invert text-xs text-slate-600 dark:text-slate-300 leading-relaxed" x-html="selectedJob?.requirements"></div>
                        </div>
                    </template>

                    <!-- Benefits -->
                    <template x-if="selectedJob?.benefits">
                        <div class="space-y-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">{{ __('Compensation & Benefits:') }}</h4>
                            <div class="prose prose-sm dark:prose-invert text-xs text-slate-600 dark:text-slate-300 leading-relaxed" x-html="selectedJob?.benefits"></div>
                        </div>
                    </template>

                    <!-- Interactive Application Form Section -->
                    <div class="pt-6 border-t-2 border-slate-200 dark:border-slate-800 space-y-4">
                        <div class="p-4 rounded-2xl bg-[#003C58]/5 dark:bg-cyan-500/5 border border-[#003C58]/10 dark:border-cyan-500/10">
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <x-icon name="solid:paper-airplane" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span>{{ __('Apply for this Position') }}</span>
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ __('Fill in your technical background and upload your latest CV.') }}
                            </p>
                        </div>

                        <div class="mt-4">
                            <livewire:frontend.job-application-form wire:key="modal-job-apply-form" />
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</x-layouts.frontend>
