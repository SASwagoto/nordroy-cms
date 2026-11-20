<x-layouts.frontend :title="\App\Models\Setting::get('about_hero_title', 'About Our Conglomerate & Engineering Heritage')">
    
    @php
        $bgStyle = \App\Models\Setting::get('about_header_bg', 'transparent');
        $frostedOpacity = max(10, min(90, (int) \App\Models\Setting::get('about_header_frosted_opacity', 80)));
        $opacityDecimal = $frostedOpacity / 100;

        $customLightBg = \App\Models\Setting::get('about_header_light_bg', '#ffffff');
        $customDarkBg = \App\Models\Setting::get('about_header_dark_bg', '#07131e');
        $customLightText = \App\Models\Setting::get('about_header_light_text', '#0f172a');
        $customDarkText = \App\Models\Setting::get('about_header_dark_text', '#f8fafc');

        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'header-frosted-about backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            'custom'   => 'header-custom-about',
            default    => 'bg-transparent',
        };

        $showOverview = (bool) \App\Models\Setting::get('about_show_overview', true);
        $showPartners = (bool) \App\Models\Setting::get('about_show_partners', true);
        $rawPartners = \App\Models\Setting::getJson('about_partners_list', [
            ['brand' => 'Accelleron (ABB)', 'models' => 'VTR, TPL, TPS, A100 & TPR series overhauls.', 'is_active' => true],
            ['brand' => 'MAN Energy Solutions', 'models' => 'NR, NA, TCR, TCA & radial designs.', 'is_active' => true],
            ['brand' => 'KBB', 'models' => 'M40, R-series, and HPR industrial compressors.', 'is_active' => true],
            ['brand' => 'Mitsubishi Heavy Industries', 'models' => 'MET-SR, MET-SC & MET-MA models.', 'is_active' => true],
        ]);
        $partners = collect($rawPartners)->filter(fn($p) => !empty($p['is_active']) && $p['is_active'] !== '0' && $p['is_active'] !== false)->values();
        $hasPartners = $showPartners && $partners->isNotEmpty();

        $showMission = (bool) \App\Models\Setting::get('about_show_mission', true);
        $showVision = (bool) \App\Models\Setting::get('about_show_vision', true);
        $showCerts = (bool) \App\Models\Setting::get('about_show_certifications', true);
        $certList = \App\Models\Setting::getJson('about_cert_list', [
            'ISO 9001:2015 CERTIFIED',
            'DNV CLASSIFIED FACILITY',
            'ASNT LEVEL III NDT BENCH',
            "LLOYD'S REGISTER STANDARDS",
        ]);
    @endphp

    @if($bgStyle === 'frosted')
        <style>
            .header-frosted-about { background-color: rgba(255, 255, 255, {{ $opacityDecimal }}); }
            .dark .header-frosted-about { background-color: rgba(7, 19, 30, {{ $opacityDecimal }}); }
        </style>
    @elseif($bgStyle === 'custom')
        <style>
            .header-custom-about { background-color: {{ $customLightBg }}; color: {{ $customLightText }}; }
            .header-custom-about h1, .header-custom-about p { color: {{ $customLightText }}; }
            .dark .header-custom-about { background-color: {{ $customDarkBg }}; color: {{ $customDarkText }}; }
            .dark .header-custom-about h1, .dark .header-custom-about p { color: {{ $customDarkText }}; }
        </style>
    @endif

    <!-- Hero Header -->
    <div class="py-16 sm:py-24 {{ $headerBgClasses }} border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 shadow-2xs">
                {{ \App\Models\Setting::get('about_badge', 'About Nordroy Group') }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-slate-900 dark:text-white mt-4 leading-tight drop-shadow-xs">
                {{ \App\Models\Setting::get('about_hero_title', 'A Legacy of Maritime Precision & Heavy Industrial Power.') }}
            </h1>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl mt-4 leading-relaxed font-medium">
                {{ \App\Models\Setting::get('about_hero_subtitle', 'Operating at the nexus of international shipping lanes and heavy industrial power utilities, Nordroy Marine & Turbochargers delivers certified multi-brand turbomachinery maintenance, NDT metallurgical verification, and prompt port dispatch.') }}
            </p>
        </div>
    </div>

    <!-- Corporate Overview & Pillars -->
    @if($showOverview)
        <section id="overview" class="py-20 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
                @if($hasPartners)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="space-y-6">
                            <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('about_overview_title', 'Engineered for High-Pressure Environments') }}
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ \App\Models\Setting::get('about_overview_p1', 'Modern exhaust gas turbochargers spin upwards of 100,000 RPM at temperatures exceeding 650°C. Even microscopic unbalance or metallurgical fatigue can trigger catastrophic engine failure and vessel arrest at port.') }}
                            </p>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ \App\Models\Setting::get('about_overview_p2', 'Our specialized engineering facilities in Chattogram Port and Dhaka are equipped with German Schenck computerized balancing rigs, ultrasonic chemical cleaning lines, and ASNT Level III non-destructive testing benches to ensure that every overhauled component operates at zero deviation from OEM tolerances.') }}
                            </p>
                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div class="p-4 rounded-xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                                    <span class="block text-2xl font-black text-[#003C58] dark:text-cyan-400">
                                        {{ \App\Models\Setting::get('about_stat1_value', '100k RPM') }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 font-medium">
                                        {{ \App\Models\Setting::get('about_stat1_label', 'Balancing Rig Capacity') }}
                                    </span>
                                </div>
                                <div class="p-4 rounded-xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                                    <span class="block text-2xl font-black text-emerald-600 dark:text-emerald-400">
                                        {{ \App\Models\Setting::get('about_stat2_value', '± 0.005mm') }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 font-medium">
                                        {{ \App\Models\Setting::get('about_stat2_label', 'Shaft Run-Out Accuracy') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-lg space-y-6">
                            <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('about_partners_title', 'Authorized OEM Partnerships') }}
                            </h3>
                            <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-3">
                                @foreach($partners as $partner)
                                    <li class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                        <span><strong>{{ $partner['brand'] }}:</strong> {{ $partner['models'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <!-- Gapless Adaptive Expanded Layout when OEM Partners are hidden -->
                    <div class="max-w-4xl mx-auto space-y-8">
                        <div class="space-y-4 text-center">
                            <h2 class="text-2xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('about_overview_title', 'Engineered for High-Pressure Environments') }}
                            </h2>
                            <p class="text-xs sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed max-w-3xl mx-auto">
                                {{ \App\Models\Setting::get('about_overview_p1', 'Modern exhaust gas turbochargers spin upwards of 100,000 RPM at temperatures exceeding 650°C. Even microscopic unbalance or metallurgical fatigue can trigger catastrophic engine failure and vessel arrest at port.') }}
                            </p>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-3xl mx-auto">
                                {{ \App\Models\Setting::get('about_overview_p2', 'Our specialized engineering facilities in Chattogram Port and Dhaka are equipped with German Schenck computerized balancing rigs, ultrasonic chemical cleaning lines, and ASNT Level III non-destructive testing benches to ensure that every overhauled component operates at zero deviation from OEM tolerances.') }}
                            </p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto pt-2">
                            <div class="p-6 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center">
                                <span class="block text-3xl font-black text-[#003C58] dark:text-cyan-400">
                                    {{ \App\Models\Setting::get('about_stat1_value', '100k RPM') }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium mt-1 block">
                                    {{ \App\Models\Setting::get('about_stat1_label', 'Balancing Rig Capacity') }}
                                </span>
                            </div>
                            <div class="p-6 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center">
                                <span class="block text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                    {{ \App\Models\Setting::get('about_stat2_value', '± 0.005mm') }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium mt-1 block">
                                    {{ \App\Models\Setting::get('about_stat2_label', 'Shaft Run-Out Accuracy') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Mission & Vision -->
    @if($showMission || $showVision)
        <section id="mission" class="py-20 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
                @if($showMission && $showVision)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                                <x-icon name="solid:bullseye" class="w-6 h-6" />
                            </div>
                            <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('about_mission_title', 'Our Corporate Mission') }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ \App\Models\Setting::get('about_mission_text', 'To protect commercial maritime operations and heavy industrial power grids from catastrophic machinery downtime by delivering rapid, certified, and fully calibrated turbocharger overhauls with complete engineering integrity.') }}
                            </p>
                        </div>

                        <div class="p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                                <x-icon name="solid:eye" class="w-6 h-6" />
                            </div>
                            <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('about_vision_title', 'Vision 2030') }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ \App\Models\Setting::get('about_vision_text', "To serve as South Asia's pre-eminent center of excellence for turbomachinery dynamics, setting new industry standards in decarbonization retrofits, bio-fuel turbine adaptations, and robotic welding restoration.") }}
                            </p>
                        </div>
                    </div>
                @elseif($showMission)
                    <div class="max-w-3xl mx-auto p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                            <x-icon name="solid:bullseye" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                            {{ \App\Models\Setting::get('about_mission_title', 'Our Corporate Mission') }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ \App\Models\Setting::get('about_mission_text', 'To protect commercial maritime operations and heavy industrial power grids from catastrophic machinery downtime by delivering rapid, certified, and fully calibrated turbocharger overhauls with complete engineering integrity.') }}
                        </p>
                    </div>
                @elseif($showVision)
                    <div class="max-w-3xl mx-auto p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                            <x-icon name="solid:eye" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                            {{ \App\Models\Setting::get('about_vision_title', 'Vision 2030') }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ \App\Models\Setting::get('about_vision_text', "To serve as South Asia's pre-eminent center of excellence for turbomachinery dynamics, setting new industry standards in decarbonization retrofits, bio-fuel turbine adaptations, and robotic welding restoration.") }}
                        </p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Quality Standards -->
    @if($showCerts && !empty($certList))
        <section id="certifications" class="py-20 bg-white dark:bg-[#07131e]">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 text-center space-y-6">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400">
                    {{ \App\Models\Setting::get('about_cert_badge', 'Quality Framework') }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                    {{ \App\Models\Setting::get('about_cert_title', 'International Accreditations') }}
                </h2>
                <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                    @foreach($certList as $cert)
                        <span class="px-6 py-3 rounded-2xl bg-slate-100 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-xs font-bold font-mono">
                            {{ $cert }}
                        </span>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.frontend>