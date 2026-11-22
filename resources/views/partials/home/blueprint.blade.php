@php
    $blueprintEnabled = (bool) \App\Models\Setting::get('home_blueprint_enabled', true);
    if (!$blueprintEnabled) return;

    $blueprintBadge = \App\Models\Setting::get('home_blueprint_badge', 'Corporate Blueprint');
    $blueprintTitle = \App\Models\Setting::get('home_blueprint_title', 'Mission, Vision & Core Values');
    $blueprintSubtitle = \App\Models\Setting::get('home_blueprint_subtitle', 'Guiding principles that define our commitment to global shipowners, captive power operators, and heavy industries.');

    $missionIcon = \App\Models\Setting::get('home_blueprint_mission_icon', 'solid:bullseye');
    $missionTitle = \App\Models\Setting::get('home_blueprint_mission_title', 'Our Mission');
    $missionDesc = \App\Models\Setting::get('home_blueprint_mission_desc', 'To eliminate engine downtime by delivering certified, multi-brand turbocharger overhauls, high-speed dynamic balancing, and genuine OEM parts with unmatched turnaround speed, metallurgical precision, and total engineering transparency.');

    $visionIcon = \App\Models\Setting::get('home_blueprint_vision_icon', 'solid:eye');
    $visionTitle = \App\Models\Setting::get('home_blueprint_vision_title', 'Our Vision 2030');
    $visionDesc = \App\Models\Setting::get('home_blueprint_vision_desc', 'To be the premier independent maritime turbomachinery conglomerate in South Asia and global waters, recognized by international classification societies as the benchmark for quality, technical integrity, and decarbonization retrofits.');

    $valuesIcon = \App\Models\Setting::get('home_blueprint_values_icon', 'solid:shield-halved');
    $valuesTitle = \App\Models\Setting::get('home_blueprint_values_title', 'Core Values');
    $value1 = \App\Models\Setting::get('home_blueprint_value1', 'Zero-Defect Quality: Strict adherence to ISO 9001 protocols.');
    $value2 = \App\Models\Setting::get('home_blueprint_value2', 'Rapid Port Agility: 24/7 readiness for urgent port calls.');
    $value3 = \App\Models\Setting::get('home_blueprint_value3', 'Technical Rigor: Calibrated testing and certified reports.');
@endphp

<!-- =====================================================================
     COMPANY MISSION, VISION & STRATEGIC VALUES
     ===================================================================== -->
<section id="blueprint" class="py-20 lg:py-28 bg-slate-50 dark:bg-[#06121d] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                {{ __($blueprintBadge) }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                {{ __($blueprintTitle) }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __($blueprintSubtitle) }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Mission Card -->
            <div class="reveal-init reveal-fade-up reveal-delay-100 p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                    <x-icon :name="$missionIcon" class="w-6 h-6" />
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">{{ __($missionTitle) }}</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __($missionDesc) }}
                </p>
            </div>

            <!-- Vision Card -->
            <div class="reveal-init reveal-fade-up reveal-delay-200 p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                    <x-icon :name="$visionIcon" class="w-6 h-6" />
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">{{ __($visionTitle) }}</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __($visionDesc) }}
                </p>
            </div>

            <!-- Core Values Card -->
            <div class="reveal-init reveal-fade-up reveal-delay-300 p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                    <x-icon :name="$valuesIcon" class="w-6 h-6" />
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">{{ __($valuesTitle) }}</h3>
                <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-2">
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400 shrink-0"></span><span>{{ __($value1) }}</span></li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400 shrink-0"></span><span>{{ __($value2) }}</span></li>
                    <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400 shrink-0"></span><span>{{ __($value3) }}</span></li>
                </ul>
            </div>

        </div>

    </div>
</section>
