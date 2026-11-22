@php
    $projectsEnabled = (bool) \App\Models\Setting::get('home_projects_enabled', true);
    if (!$projectsEnabled) return;

    $projectsBadge = \App\Models\Setting::get('home_projects_badge', 'Execution Proven Track Record');
    $projectsTitle = \App\Models\Setting::get('home_projects_title', 'Featured Industrial & Marine Projects');
    $projectsSubtitle = \App\Models\Setting::get('home_projects_subtitle', 'A glimpse of recent turn-key overhauls completed on commercial ships and captive power plants.');

    $align = \App\Models\Setting::get('home_projects_align', 'center');
    $headerAlignClass = match($align) {
        'left' => 'text-left mr-auto ml-0 items-start justify-start',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-center mx-auto items-center justify-center',
    };
@endphp

<!-- =====================================================================
     OUR PROJECTS PORTFOLIO (Dana Group Style)
     ===================================================================== -->
<x-section-styler-wrap sectionKey="projects" id="projects">
    
    <div class="max-w-3xl space-y-3 mb-16 {{ $headerAlignClass }}">
        <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 inline-block">
            {{ __($projectsBadge) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
            {{ __($projectsTitle) }}
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            {{ __($projectsSubtitle) }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Project 1 -->
        <div class="reveal-init reveal-fade-up reveal-delay-100 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition-all group">
            <div class="h-60 bg-slate-100 dark:bg-slate-900 relative overflow-hidden flex items-center justify-center">
                <img src="{{ asset('assets/images/gallery/gallery-plant.webp') }}" alt="7.2 MW Plant Overhaul" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div class="absolute bottom-3 left-4 right-4 bg-white/90 dark:bg-[#07131e]/90 backdrop-blur-md px-4 py-2 rounded-xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs shadow-sm">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#003C58] text-white font-bold uppercase tracking-wider text-[10px]">Captive Power</span>
                    <span class="text-[#003C58] dark:text-cyan-400 font-mono font-bold">7.2 MW Plant Overhaul</span>
                </div>
            </div>
            <div class="p-6 space-y-3">
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">7.2 MW Waukesha Gas Generator Turbocharger Rebuild</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Complete disassembly, ultrasonic de-carbonization, and Schenck dynamic balancing for eight Waukesha gas engines at a major export spinning mill conglomerate.
                </p>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                    <span>Client: Export Spinning Mills Ltd.</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold">Zero Downtime</span>
                </div>
            </div>
        </div>

        <!-- Project 2 -->
        <div class="reveal-init reveal-fade-up reveal-delay-200 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition-all group">
            <div class="h-60 bg-slate-100 dark:bg-slate-900 relative overflow-hidden flex items-center justify-center">
                <img src="{{ asset('assets/images/gallery/gallery-turbine.webp') }}" alt="CHRA Cartridge Exchange" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div class="absolute bottom-3 left-4 right-4 bg-white/90 dark:bg-[#07131e]/90 backdrop-blur-md px-4 py-2 rounded-xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs shadow-sm">
                    <span class="px-2.5 py-0.5 rounded-md bg-[#003C58] text-white font-bold uppercase tracking-wider text-[10px]">Maritime Vessel</span>
                    <span class="text-[#003C58] dark:text-cyan-400 font-mono font-bold">45,000 DWT Bulk Carrier</span>
                </div>
            </div>
            <div class="p-6 space-y-3">
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">Emergency CHRA Cartridge Exchange at Chattogram Port</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Rapid 18-hour emergency response for an international bulk carrier experiencing high turbine vibrations, replacing the entire CHRA cartridge during cargo discharging.
                </p>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                    <span>Location: Chattogram Outer Anchorage</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold">18h Turnaround</span>
                </div>
            </div>
        </div>

    </div>

</x-section-styler-wrap>