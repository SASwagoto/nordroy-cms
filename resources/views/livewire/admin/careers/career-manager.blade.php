<div class="space-y-6">

    <!-- Top Action Bar & Studio Navigation Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Careers &amp; Talent Acquisition Desk</h1>
                @if ($appCounts['new'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500 text-white animate-pulse">
                        {{ $appCounts['new'] }} NEW CANDIDATES
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Post marine engineering vacancies, evaluate incoming candidate CVs, and configure custom application form fields.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('careers') }}" target="_blank"
               class="px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors inline-flex items-center gap-1.5 cursor-pointer">
                <x-icon name="solid:arrow-top-right-on-square" class="w-3.5 h-3.5" />
                <span>Live Careers Page</span>
            </a>

            @if($activeTab === 'jobs')
                <button type="button" 
                        wire:click="openCreateJobModal" 
                        class="px-3.5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-1.5 cursor-pointer">
                    <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                    <span>Post New Vacancy</span>
                </button>
            @elseif($activeTab === 'applications')
                <button type="button" 
                        wire:click="exportCsv" 
                        class="px-3.5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-1.5 cursor-pointer">
                    <x-icon name="solid:arrow-down-tray" class="w-3.5 h-3.5" />
                    <span>Export Candidates CSV</span>
                </button>
            @elseif($activeTab === 'builder')
                <button type="button" 
                        wire:click="openCreateFieldModal" 
                        class="px-3.5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-1.5 cursor-pointer">
                    <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                    <span>Add Application Field</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Flash Alert Feedback -->
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

    <!-- Studio Navigation Tabs (Segmented Control) -->
    <div class="flex items-center gap-2 p-1 rounded-2xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 w-fit">
        <button type="button" 
                wire:click="setTab('jobs')" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-2 {{ $activeTab === 'jobs' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <x-icon name="solid:briefcase" class="w-3.5 h-3.5" />
            <span>Job Vacancies</span>
            <span class="px-1.5 py-0.2 rounded-md text-[10px] {{ $activeTab === 'jobs' ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                {{ $jobs->total() }}
            </span>
        </button>

        <button type="button" 
                wire:click="setTab('applications')" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-2 {{ $activeTab === 'applications' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <x-icon name="solid:user-group" class="w-3.5 h-3.5" />
            <span>Received Candidates</span>
            @if($appCounts['new'] > 0)
                <span class="px-1.5 py-0.2 rounded-md text-[10px] font-bold bg-rose-500 text-white">
                    {{ $appCounts['new'] }} NEW
                </span>
            @else
                <span class="px-1.5 py-0.2 rounded-md text-[10px] {{ $activeTab === 'applications' ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                    {{ $appCounts['all'] }}
                </span>
            @endif
        </button>

        <button type="button" 
                wire:click="setTab('builder')" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-2 {{ $activeTab === 'builder' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
            <x-icon name="solid:adjustments-horizontal" class="w-3.5 h-3.5" />
            <span>Application Form Builder</span>
            <span class="px-1.5 py-0.2 rounded-md text-[10px] {{ $activeTab === 'builder' ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                {{ $fields->count() }} Fields
            </span>
        </button>
    </div>

    <!-- ============================================================= -->
    <!-- TAB 1: JOB VACANCIES MANAGER                                  -->
    <!-- ============================================================= -->
    @if ($activeTab === 'jobs')
        <div class="space-y-4">
            <!-- Filter Bar -->
            <div class="p-4 rounded-2xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3 w-full sm:w-auto flex-1">
                    <div class="relative flex-1 sm:max-w-xs">
                        <x-icon name="solid:magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input type="text" 
                               wire:model.live.debounce.300ms="searchJob" 
                               placeholder="Search vacancies by title, department, location..." 
                               class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                    </div>

                    <select wire:model.live="filterDepartment" 
                            class="px-3 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        <option value="all">All Departments</option>
                        @foreach($allDepartments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Job Cards Grid -->
            @if ($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($jobs as $job)
                        <div wire:key="admin-job-{{ $job->id }}" 
                             class="group rounded-3xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 p-5 shadow-xs hover:shadow-lg transition-all flex flex-col justify-between space-y-4 {{ !$job->is_active ? 'opacity-60 bg-slate-50/50 dark:bg-slate-950/20' : '' }}">
                            
                            <div class="space-y-3">
                                <!-- Badges & Status Controls -->
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/10 dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20 truncate">
                                        {{ $job->department }}
                                    </span>

                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <!-- Featured Toggle -->
                                        <button type="button" 
                                                wire:click="toggleJobFeatured({{ $job->id }})" 
                                                class="p-1 rounded-lg transition-colors cursor-pointer {{ $job->is_featured ? 'text-amber-500 hover:text-amber-600' : 'text-slate-300 dark:text-slate-700 hover:text-slate-500' }}"
                                                title="Toggle Featured Vacancy">
                                            <x-icon name="solid:star" class="w-4 h-4" />
                                        </button>

                                        <!-- Active / Open Status -->
                                        <button type="button" 
                                                wire:click="toggleJobActive({{ $job->id }})" 
                                                class="px-2 py-0.5 rounded-md text-[10px] font-bold transition-colors cursor-pointer {{ $job->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-slate-200 dark:bg-slate-800 text-slate-500' }}">
                                            {{ $job->is_active ? 'OPEN' : 'CLOSED' }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Title & Key Meta -->
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-2 group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors">
                                        {{ $job->title }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 pt-2 text-[11px] text-slate-500 dark:text-slate-400">
                                        <span class="flex items-center gap-1">
                                            <x-icon name="solid:map-pin" class="w-3 h-3 text-slate-400" />
                                            <span>{{ $job->location }}</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <x-icon name="solid:clock" class="w-3 h-3 text-slate-400" />
                                            <span>{{ $job->employment_type }}</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Salary & Experience -->
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-800 text-[11px] flex items-center justify-between">
                                    <span class="text-slate-500 dark:text-slate-400">Exp: <strong class="text-slate-800 dark:text-slate-200">{{ $job->experience_level }}</strong></span>
                                    @if($job->salary_range)
                                        <span class="font-bold text-[#003C58] dark:text-cyan-400">{{ $job->salary_range }}</span>
                                    @else
                                        <span class="text-slate-400 italic">Negotiable</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer: Candidates Counter & Action Buttons -->
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                                <button type="button" 
                                        wire:click="$set('filterAppJob', '{{ $job->id }}'); $set('activeTab', 'applications')" 
                                        class="font-bold text-slate-600 dark:text-slate-300 hover:text-[#003C58] dark:hover:text-cyan-400 flex items-center gap-1.5 cursor-pointer">
                                    <x-icon name="solid:user-group" class="w-3.5 h-3.5 text-slate-400" />
                                    <span>{{ $job->applications_count }} Candidates</span>
                                </button>

                                <div class="flex items-center gap-1">
                                    <button type="button" 
                                            wire:click="editJob({{ $job->id }})" 
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                                            title="Edit vacancy details">
                                        <x-icon name="solid:pencil-square" class="w-4 h-4" />
                                    </button>
                                    <button type="button" 
                                            wire:click="confirmDelete('job', {{ $job->id }}, '{{ addslashes($job->title) }}')" 
                                            class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                            title="Delete vacancy">
                                        <x-icon name="solid:trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="pt-2">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="p-12 text-center rounded-3xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 text-slate-400 text-xs space-y-3">
                    <x-icon name="solid:briefcase" class="w-8 h-8 mx-auto text-slate-300 dark:text-slate-700" />
                    <p>No job postings match your current filter.</p>
                    <button type="button" wire:click="openCreateJobModal" class="px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white">
                        Post Your First Vacancy
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- ============================================================= -->
    <!-- TAB 2: RECEIVED CANDIDATES / APPLICATIONS DESK               -->
    <!-- ============================================================= -->
    @if ($activeTab === 'applications')
        <div class="space-y-4">
            
            <!-- Filter Bar: Search, Status Tabs & Job Select -->
            <div class="space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <!-- Status Filter Tabs -->
                    <div class="flex items-center gap-1 overflow-x-auto no-scrollbar pb-1">
                        <button type="button" wire:click="$set('filterAppStatus', 'all')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer {{ $filterAppStatus === 'all' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            All ({{ $appCounts['all'] }})
                        </button>
                        <button type="button" wire:click="$set('filterAppStatus', 'new')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer {{ $filterAppStatus === 'new' ? 'bg-rose-500 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            New ({{ $appCounts['new'] }})
                        </button>
                        <button type="button" wire:click="$set('filterAppStatus', 'reviewing')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer {{ $filterAppStatus === 'reviewing' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            In Review ({{ $appCounts['reviewing'] }})
                        </button>
                        <button type="button" wire:click="$set('filterAppStatus', 'shortlisted')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer {{ $filterAppStatus === 'shortlisted' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            Shortlisted ({{ $appCounts['shortlisted'] }})
                        </button>
                        <button type="button" wire:click="$set('filterAppStatus', 'interview')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer {{ $filterAppStatus === 'interview' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            Interview ({{ $appCounts['interview'] }})
                        </button>
                        <button type="button" wire:click="$set('filterAppStatus', 'hired')" 
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap cursor-pointer {{ $filterAppStatus === 'hired' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            Hired ({{ $appCounts['hired'] }})
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <select wire:model.live="filterAppJob" 
                                class="px-3 py-1.5 rounded-xl text-xs bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200">
                            <option value="all">All Job Vacancies</option>
                            @foreach($allJobPostings as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="relative">
                    <x-icon name="solid:magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchApp" 
                           placeholder="Search candidates by applicant name, email, phone..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                </div>
            </div>

            <!-- Applications Table -->
            <div class="rounded-3xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-800 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="py-3.5 px-4">Candidate</th>
                                <th class="py-3.5 px-4">Applied Position</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4">CV / Resume</th>
                                <th class="py-3.5 px-4">Applied Date</th>
                                <th class="py-3.5 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @forelse($applications as $app)
                                <tr wire:key="app-row-{{ $app->id }}" class="hover:bg-slate-50/60 dark:hover:bg-slate-900/40 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="space-y-0.5">
                                            <span class="font-bold text-slate-900 dark:text-white block">
                                                {{ $app->full_name }}
                                            </span>
                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                                <span>{{ $app->email }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $app->phone }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        <span class="font-semibold text-slate-800 dark:text-slate-200 block truncate max-w-[220px]">
                                            {{ $app->jobPosting?->title ?? 'General Marine Engineering Pool' }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            {{ $app->jobPosting?->department ?? 'General Application' }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @php
                                            $statusColors = match($app->status) {
                                                'new'         => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20',
                                                'reviewing'   => 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border-cyan-500/20',
                                                'shortlisted' => 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-500/20',
                                                'interview'   => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
                                                'hired'       => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                                                'rejected'    => 'bg-slate-200 dark:bg-slate-800 text-slate-500 border-slate-300 dark:border-slate-700',
                                                default       => 'bg-slate-100 text-slate-600 border-slate-200',
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusColors }}">
                                            {{ $app->status }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @if($app->resume_url)
                                            <a href="{{ $app->resume_url }}" target="_blank" 
                                               class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/10 dark:text-cyan-400 hover:underline inline-flex items-center gap-1.5">
                                                <x-icon name="solid:document-arrow-down" class="w-3.5 h-3.5" />
                                                <span>Open CV</span>
                                            </a>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">No file</span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-4 text-slate-500 text-[11px] whitespace-nowrap">
                                        {{ $app->created_at->format('M d, Y') }}
                                        <span class="block text-[10px] text-slate-400">{{ $app->created_at->diffForHumans() }}</span>
                                    </td>

                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button type="button" 
                                                    wire:click="viewApplication({{ $app->id }})" 
                                                    class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition-colors cursor-pointer">
                                                Evaluate
                                            </button>
                                            <button type="button" 
                                                    wire:click="confirmDelete('application', {{ $app->id }}, '{{ addslashes($app->full_name) }}')" 
                                                    class="p-1.5 text-rose-500 hover:text-rose-700 cursor-pointer"
                                                    title="Remove application">
                                                <x-icon name="solid:trash" class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-xs text-slate-400 space-y-2">
                                        <x-icon name="solid:inbox" class="w-8 h-8 mx-auto text-slate-300 dark:text-slate-700" />
                                        <p>No job applications received yet for this criteria.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($applications->hasPages())
                    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>

        </div>
    @endif

    <!-- ============================================================= -->
    <!-- TAB 3: APPLICATION FORM BUILDER                              -->
    <!-- ============================================================= -->
    @if ($activeTab === 'builder')
        <div class="space-y-4">
            <div class="p-4 rounded-2xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 flex items-center justify-between shadow-xs">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Job Application Template Fields</h3>
                    <p class="text-[11px] text-slate-400">These fields dynamically render when candidates click "Apply" on the careers page.</p>
                </div>
                <button type="button" 
                        wire:click="resetFieldsToDefault" 
                        wire:confirm="Restore recommended default maritime job application fields?"
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-1.5 cursor-pointer">
                    <x-icon name="solid:arrow-path" class="w-3.5 h-3.5" />
                    <span>Reset to Default Template</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Field Structure List (7 cols) -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="bg-white dark:bg-[#07131e] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
                        <div class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @forelse($fields as $field)
                                <div wire:key="career-field-{{ $field->id }}" 
                                     class="p-4 flex items-center justify-between gap-4 hover:bg-slate-50/60 dark:hover:bg-slate-900/40 transition-colors {{ !$field->is_active ? 'opacity-50 bg-slate-50/40 dark:bg-slate-950/20' : '' }}">
                                    
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <!-- Reorder Controls -->
                                        <div class="flex flex-col gap-0.5 shrink-0 text-slate-400">
                                            <button type="button" wire:click="moveUp({{ $field->id }})" class="p-0.5 hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-pointer" title="Move Up">
                                                <x-icon name="solid:chevron-up" class="w-3.5 h-3.5" />
                                            </button>
                                            <button type="button" wire:click="moveDown({{ $field->id }})" class="p-0.5 hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-pointer" title="Move Down">
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

                                                <span class="px-1.5 py-0.2 rounded text-[10px] font-mono font-semibold uppercase bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20">
                                                    {{ $field->type }}
                                                </span>

                                                <span class="px-1.5 py-0.2 rounded text-[10px] font-mono bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20">
                                                    @if($field->width == 12) 100% Full @elseif($field->width == 6) 50% Half @elseif($field->width == 4) 33% (1/3) @else 25% (1/4) @endif
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-3 text-[11px] text-slate-400 font-mono">
                                                <span>key: <strong class="text-slate-600 dark:text-slate-300">{{ $field->name }}</strong></span>
                                                @if(!empty($field->placeholder))
                                                    <span class="truncate max-w-[180px]">"{{ $field->placeholder }}"</span>
                                                @endif
                                                @if(in_array($field->type, ['select', 'radio', 'checkbox']) && !empty($field->options))
                                                    <span class="text-indigo-500 dark:text-indigo-400 font-semibold">({{ count($field->options) }} options)</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <button type="button" 
                                                wire:click="toggleFieldActive({{ $field->id }})" 
                                                class="px-2 py-1 rounded-lg text-[11px] font-semibold transition-colors cursor-pointer {{ $field->is_active ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                                            {{ $field->is_active ? 'Active' : 'Disabled' }}
                                        </button>

                                        <button type="button" wire:click="editField({{ $field->id }})" class="p-1.5 text-slate-500 hover:text-slate-900 dark:hover:text-white cursor-pointer" title="Edit field">
                                            <x-icon name="solid:pencil-square" class="w-4 h-4" />
                                        </button>

                                        <button type="button" wire:click="confirmDelete('field', {{ $field->id }}, '{{ addslashes($field->label) }}')" class="p-1.5 text-rose-500 hover:text-rose-700 cursor-pointer" title="Delete field">
                                            <x-icon name="solid:trash" class="w-4 h-4" />
                                        </button>
                                    </div>

                                </div>
                            @empty
                                <div class="p-8 text-center text-xs text-slate-400">
                                    No application fields configured.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Live Application Form Preview (5 cols) -->
                <div class="lg:col-span-5 space-y-4 sticky top-6">
                    <div class="bg-white dark:bg-[#07131e] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Live Application Preview</h3>
                            </div>
                            <span class="text-[10px] text-slate-400 font-mono">Candidate Form</span>
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
                                        @elseif($f->type === 'file')
                                            <div class="p-2 rounded-lg bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 text-center text-[10px] text-slate-400">
                                                <x-icon name="solid:cloud-arrow-up" class="w-4 h-4 mx-auto mb-1 text-slate-400" />
                                                <span>{{ $f->placeholder ?: 'Choose PDF / DOCX' }}</span>
                                            </div>
                                        @else
                                            <input type="{{ $f->type }}" disabled placeholder="{{ $f->placeholder }}" class="w-full px-2.5 py-1.5 rounded-lg text-[11px] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 opacity-80" />
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" disabled class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-[#003C58] dark:bg-cyan-600 opacity-70 cursor-not-allowed">
                                Submit Job Application &rarr;
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- ==================== CREATE / EDIT JOB MODAL ==================== -->
    @if ($isJobModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto" role="dialog">
            <div class="w-full max-w-3xl bg-white dark:bg-[#07131e] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden my-8"
                 @click.outside="$wire.set('isJobModalOpen', false)">
                
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $editingJobId ? 'Edit Vacancy' : 'Post New Job Vacancy' }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Provide role title, department, technical scope, and candidate prerequisites.
                        </p>
                    </div>
                    <button type="button" wire:click="$set('isJobModalOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <x-icon name="solid:xmark" class="w-5 h-5" />
                    </button>
                </div>

                <form wire:submit.prevent="saveJob" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                    <!-- Title & Slug -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Position Title <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.live.debounce.300ms="jobTitle" placeholder="e.g. Lead Marine Turbocharger Overhaul Engineer" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border @error('jobTitle') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                            @error('jobTitle') <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                URL Slug <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="jobSlug" placeholder="e.g. lead-marine-turbocharger-overhaul-engineer" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs font-mono bg-slate-50 dark:bg-slate-900 border @error('jobSlug') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none" />
                            @error('jobSlug') <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Department & Employment Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Department <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="jobDepartment" placeholder="e.g. Marine Engineering" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Employment Type <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model="jobEmploymentType" class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                <option value="Full-Time">Full-Time</option>
                                <option value="Contract">Contract</option>
                                <option value="Offshore Rotation">Offshore Rotation</option>
                                <option value="Internship">Internship</option>
                                <option value="Part-Time">Part-Time</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Experience Level <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model="jobExperienceLevel" class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                <option value="Entry Level">Entry Level</option>
                                <option value="1-3 Years">1-3 Years</option>
                                <option value="3-5 Years">3-5 Years</option>
                                <option value="5+ Years Senior">5+ Years Senior</option>
                                <option value="Chief Superintendent">Chief Superintendent</option>
                            </select>
                        </div>
                    </div>

                    <!-- Location & Salary & Deadline -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Location / Facility <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="jobLocation" placeholder="e.g. Chattogram Port Workshop" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Salary / Remuneration (Optional)
                            </label>
                            <input type="text" wire:model="jobSalaryRange" placeholder="e.g. BDT 100,000 - 140,000" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Application Deadline (Optional)
                            </label>
                            <input type="date" wire:model="jobDeadline" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Role Description &amp; Responsibilities <span class="text-rose-500">*</span>
                        </label>
                        <textarea wire:model="jobDescription" rows="4" placeholder="Detailed technical description of day-to-day duties..." 
                                  class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border @error('jobDescription') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/30 focus:outline-none"></textarea>
                        @error('jobDescription') <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Requirements & Benefits -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Candidate Requirements &amp; Qualifications
                            </label>
                            <textarea wire:model="jobRequirements" rows="3" placeholder="Key certifications, sea discharge books, academic degrees..." 
                                      class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Benefits &amp; Perks
                            </label>
                            <textarea wire:model="jobBenefits" rows="3" placeholder="Medical insurance, offshore allowances, bonus..." 
                                      class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                    </div>

                    <!-- Switches: Featured, Active -->
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="jobIsFeatured" class="w-4 h-4 rounded text-amber-500 focus:ring-0">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Highlight as Featured Vacancy</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="jobIsActive" class="w-4 h-4 rounded text-emerald-600 focus:ring-0">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active (Accepting Applications)</span>
                        </label>
                    </div>

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                        <button type="button" wire:click="$set('isJobModalOpen', false)" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm cursor-pointer">
                            {{ $editingJobId ? 'Update Vacancy' : 'Publish Vacancy' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif

    <!-- ==================== CANDIDATE EVALUATION MODAL ==================== -->
    @if ($selectedApplication)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto" role="dialog">
            <div class="w-full max-w-2xl bg-white dark:bg-[#07131e] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden my-8"
                 @click.outside="$wire.set('selectedApplication', null)">
                
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $selectedApplication->full_name }}</h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/10 dark:text-cyan-400">
                                {{ $selectedApplication->jobPosting?->title ?? 'General Marine Engineering Pool' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">Applied on {{ $selectedApplication->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <button type="button" wire:click="$set('selectedApplication', null)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <x-icon name="solid:xmark" class="w-5 h-5" />
                    </button>
                </div>

                <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto text-xs">
                    
                    <!-- Quick Direct Action Strip -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                        <div class="space-y-0.5">
                            <span class="text-[10px] font-mono uppercase text-slate-400">Direct Contact:</span>
                            <div class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-3">
                                <a href="mailto:{{ $selectedApplication->email }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 underline">{{ $selectedApplication->email }}</a>
                                <span>&bull;</span>
                                <a href="tel:{{ $selectedApplication->phone }}" class="hover:text-[#003C58] dark:hover:text-cyan-400">{{ $selectedApplication->phone }}</a>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($selectedApplication->resume_url)
                                <a href="{{ $selectedApplication->resume_url }}" target="_blank" download
                                   class="px-3.5 py-1.5 rounded-xl font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 flex items-center gap-1.5 shadow-sm">
                                    <x-icon name="solid:document-arrow-down" class="w-3.5 h-3.5" />
                                    <span>Download Resume</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Dynamic Form Submitted Fields -->
                    @if(isset($selectedApplication->payload['fields']) && is_array($selectedApplication->payload['fields']))
                        <div class="space-y-2">
                            <h4 class="font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Candidate Technical Profile:</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($selectedApplication->payload['fields'] as $fld)
                                    @if(isset($fld['value']) && $fld['value'] !== '' && !in_array($fld['type'] ?? '', ['textarea', 'file']))
                                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800">
                                            <span class="block text-[10px] font-mono uppercase text-slate-400 truncate">{{ $fld['label'] ?? $fld['name'] }}:</span>
                                            <span class="font-bold text-slate-900 dark:text-white mt-0.5 block truncate">
                                                {{ is_bool($fld['value']) ? ($fld['value'] ? 'Yes' : 'No') : $fld['value'] }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Cover Summary -->
                    @if($selectedApplication->cover_letter)
                        <div class="space-y-1.5">
                            <h4 class="font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Candidate Summary / Cover Scope:</h4>
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 whitespace-pre-wrap leading-relaxed text-slate-800 dark:text-slate-200">
                                {{ $selectedApplication->cover_letter }}
                            </div>
                        </div>
                    @endif

                    <!-- Internal Admin Evaluation Notes -->
                    <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <label class="block font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Interview Evaluation &amp; Internal Notes:
                        </label>
                        <div class="flex gap-2">
                            <textarea wire:model="adminNoteText" rows="2" placeholder="e.g. Cleared technical screening; scheduled for workshop dynamic balancing practical on Thursday..." 
                                      class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                            <button type="button" wire:click="saveAdminNote" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white dark:bg-white dark:text-slate-950 self-end shrink-0 cursor-pointer">
                                Save Note
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Footer Status Switcher Controls -->
                <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/40 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="font-semibold text-slate-500 mr-1">Status:</span>

                        <button type="button" wire:click="updateAppStatus({{ $selectedApplication->id }}, 'new')" 
                                class="px-2.5 py-1 rounded-lg font-semibold {{ $selectedApplication->status === 'new' ? 'bg-rose-500 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }} cursor-pointer">
                            New
                        </button>
                        <button type="button" wire:click="updateAppStatus({{ $selectedApplication->id }}, 'reviewing')" 
                                class="px-2.5 py-1 rounded-lg font-semibold {{ $selectedApplication->status === 'reviewing' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }} cursor-pointer">
                            Reviewing
                        </button>
                        <button type="button" wire:click="updateAppStatus({{ $selectedApplication->id }}, 'shortlisted')" 
                                class="px-2.5 py-1 rounded-lg font-semibold {{ $selectedApplication->status === 'shortlisted' ? 'bg-indigo-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }} cursor-pointer">
                            Shortlist
                        </button>
                        <button type="button" wire:click="updateAppStatus({{ $selectedApplication->id }}, 'interview')" 
                                class="px-2.5 py-1 rounded-lg font-semibold {{ $selectedApplication->status === 'interview' ? 'bg-amber-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }} cursor-pointer">
                            Interview
                        </button>
                        <button type="button" wire:click="updateAppStatus({{ $selectedApplication->id }}, 'hired')" 
                                class="px-2.5 py-1 rounded-lg font-semibold {{ $selectedApplication->status === 'hired' ? 'bg-emerald-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }} cursor-pointer">
                            Hired
                        </button>
                        <button type="button" wire:click="updateAppStatus({{ $selectedApplication->id }}, 'rejected')" 
                                class="px-2.5 py-1 rounded-lg font-semibold {{ $selectedApplication->status === 'rejected' ? 'bg-slate-700 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }} cursor-pointer">
                            Reject
                        </button>
                    </div>

                    <button type="button" wire:click="$set('selectedApplication', null)" class="px-4 py-1.5 rounded-xl font-bold bg-slate-200 dark:bg-slate-800 text-slate-800 dark:text-white cursor-pointer">
                        Close
                    </button>
                </div>

            </div>
        </div>
    @endif

    <!-- ==================== APPLICATION FIELD CREATE / EDIT MODAL ==================== -->
    @if ($isFieldModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto" role="dialog">
            <div class="w-full max-w-2xl bg-white dark:bg-[#07131e] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden my-8"
                 @click.outside="$wire.set('isFieldModalOpen', false)">
                
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $editingFieldId ? 'Edit Application Field' : 'Add Application Field' }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Customize candidate form inputs, grid width spans, file upload rules, and dropdown choices.
                        </p>
                    </div>
                    <button type="button" wire:click="$set('isFieldModalOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <x-icon name="solid:xmark" class="w-5 h-5" />
                    </button>
                </div>

                <form wire:submit.prevent="saveField" class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Display Label <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.live.debounce.300ms="fieldLabel" placeholder="e.g. Sea Discharge Book (CDC) Number" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border @error('fieldLabel') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white" />
                            @error('fieldLabel') <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Field Key (Machine Name) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="fieldName" placeholder="e.g. cdc_number" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs font-mono bg-slate-50 dark:bg-slate-900 border @error('fieldName') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white" />
                            @error('fieldName') <span class="text-[11px] text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Input Type <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model.live="fieldType" class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                <option value="text">Text (Single-Line)</option>
                                <option value="email">Email Address</option>
                                <option value="tel">Phone / WhatsApp</option>
                                <option value="number">Numeric</option>
                                <option value="textarea">Textarea (Multi-Line)</option>
                                <option value="file">File Upload (CV / Certificate)</option>
                                <option value="select">Select Dropdown</option>
                                <option value="radio">Radio Options</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="date">Date</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Grid Width (12-Col Span) <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-4 gap-1.5 pt-0.5">
                                <button type="button" wire:click="$set('fieldWidth', 12)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $fieldWidth == 12 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400' }}">
                                    100%
                                </button>
                                <button type="button" wire:click="$set('fieldWidth', 6)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $fieldWidth == 6 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400' }}">
                                    50%
                                </button>
                                <button type="button" wire:click="$set('fieldWidth', 4)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $fieldWidth == 4 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400' }}">
                                    33%
                                </button>
                                <button type="button" wire:click="$set('fieldWidth', 3)" 
                                        class="px-2 py-2 rounded-xl text-xs font-bold border transition-all cursor-pointer text-center {{ $fieldWidth == 3 ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 border-transparent shadow-xs' : 'bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400' }}">
                                    25%
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Placeholder Text
                            </label>
                            <input type="text" wire:model="fieldPlaceholder" placeholder="e.g. Enter details..." 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Help / Guidance Note
                            </label>
                            <input type="text" wire:model="fieldHelpText" placeholder="e.g. PDF or DOC format, max 10MB" 
                                   class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white" />
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="fieldIsRequired" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Required Field</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="fieldIsActive" class="w-4 h-4 rounded text-emerald-600 focus:ring-0">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active</span>
                        </label>
                    </div>

                    <!-- Dynamic Options for Select, Radio, Checkbox -->
                    @if(in_array($fieldType, ['select', 'radio', 'checkbox']))
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                                    <x-icon name="solid:list-bullet" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                                    <span>Selectable Options ({{ count($fieldOptions) }})</span>
                                </h4>
                            </div>

                            @if(count($fieldOptions) > 0)
                                <div class="space-y-1.5 max-h-40 overflow-y-auto no-scrollbar">
                                    @foreach($fieldOptions as $idx => $opt)
                                        <div wire:key="opt-row-{{ $idx }}" class="flex items-center justify-between gap-2 p-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs">
                                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $opt['label'] }}</span>
                                            <button type="button" wire:click="removeOption({{ $idx }})" class="text-rose-500 hover:text-rose-700 cursor-pointer">
                                                <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center gap-2">
                                <input type="text" wire:model="newOptionLabel" wire:keydown.enter.prevent="addOption" placeholder="Option Label (e.g. 3-5 Years)" 
                                       class="flex-1 px-3 py-1.5 rounded-xl text-xs bg-white dark:bg-slate-950 border @error('newOptionLabel') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror text-slate-900 dark:text-white" />
                                <button type="button" wire:click="addOption" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">
                                    + Add
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                        <button type="button" wire:click="$set('isFieldModalOpen', false)" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm cursor-pointer">
                            {{ $editingFieldId ? 'Update Field' : 'Save Field' }}
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
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Confirm Deletion</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Are you sure you want to permanently delete <strong class="text-slate-800 dark:text-slate-200">"{{ $deleteName }}"</strong>?
                    </p>
                </div>
                <div class="pt-2 flex items-center justify-center gap-3">
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
