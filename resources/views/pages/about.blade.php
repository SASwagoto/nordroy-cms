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

        // Dynamic Overview Spec Stats
        $rawStats = \App\Models\Setting::getJson('about_stats_list', null);
        if ($rawStats === null) {
            $rawStats = [
                ['value' => \App\Models\Setting::get('about_stat1_value', '100k RPM'), 'label' => \App\Models\Setting::get('about_stat1_label', 'Balancing Rig Capacity'), 'color' => 'cyan', 'is_active' => true],
                ['value' => \App\Models\Setting::get('about_stat2_value', '± 0.005mm'), 'label' => \App\Models\Setting::get('about_stat2_label', 'Shaft Run-Out Accuracy'), 'color' => 'emerald', 'is_active' => true],
            ];
        }
        $activeStats = collect($rawStats)->filter(fn($s) => !empty($s['is_active']) && $s['is_active'] !== '0' && $s['is_active'] !== false)->values();
        $statCount = $activeStats->count();

        $statColorClasses = [
            'cyan'    => 'text-[#003C58] dark:text-cyan-400',
            'emerald' => 'text-emerald-600 dark:text-emerald-400',
            'rose'    => 'text-rose-600 dark:text-rose-400',
            'amber'   => 'text-amber-600 dark:text-amber-400',
            'indigo'  => 'text-indigo-600 dark:text-indigo-400',
            'blue'    => 'text-blue-600 dark:text-blue-400',
            'purple'  => 'text-purple-600 dark:text-purple-400',
        ];

        // Mission & Vision Configuration
        $mvAlign = \App\Models\Setting::get('about_mission_vision_align', 'left'); // 'left', 'center', 'horizontal'
        $mvStyle = \App\Models\Setting::get('about_mission_vision_style', 'modern'); // 'modern', 'bordered', 'gradient'

        $missionBadge = \App\Models\Setting::get('about_mission_badge', 'Strategic Purpose');
        $missionTitle = \App\Models\Setting::get('about_mission_title', 'Our Corporate Mission');
        $missionText  = \App\Models\Setting::get('about_mission_text', 'To protect commercial maritime operations and heavy industrial power grids from catastrophic machinery downtime by delivering rapid, certified, and fully calibrated turbocharger overhauls with complete engineering integrity.');
        $missionIcon  = \App\Models\Setting::get('about_mission_icon', 'solid:bullseye');
        $missionColor = \App\Models\Setting::get('about_mission_color', 'cyan');

        $visionBadge = \App\Models\Setting::get('about_vision_badge', 'Horizon 2030');
        $visionTitle = \App\Models\Setting::get('about_vision_title', 'Vision 2030');
        $visionText  = \App\Models\Setting::get('about_vision_text', "To serve as South Asia's pre-eminent center of excellence for turbomachinery dynamics, setting new industry standards in decarbonization retrofits, bio-fuel turbine adaptations, and robotic welding restoration.");
        $visionIcon  = \App\Models\Setting::get('about_vision_icon', 'solid:eye');
        $visionColor = \App\Models\Setting::get('about_vision_color', 'emerald');

        $colorThemes = [
            'cyan' => [
                'badge'   => 'bg-cyan-500/10 text-cyan-700 dark:text-cyan-300 border border-cyan-500/20',
                'icon_bg' => 'bg-[#003C58]/10 dark:bg-cyan-500/15 text-[#003C58] dark:text-cyan-400 border border-cyan-500/20 shadow-xs',
                'top_bar' => 'before:bg-cyan-500',
            ],
            'emerald' => [
                'badge'   => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-500/20',
                'icon_bg' => 'bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 shadow-xs',
                'top_bar' => 'before:bg-emerald-500',
            ],
            'indigo' => [
                'badge'   => 'bg-indigo-500/10 text-indigo-700 dark:text-indigo-300 border border-indigo-500/20',
                'icon_bg' => 'bg-indigo-500/10 dark:bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 shadow-xs',
                'top_bar' => 'before:bg-indigo-500',
            ],
            'blue' => [
                'badge'   => 'bg-blue-500/10 text-blue-700 dark:text-blue-300 border border-blue-500/20',
                'icon_bg' => 'bg-blue-500/10 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 border border-blue-500/20 shadow-xs',
                'top_bar' => 'before:bg-blue-500',
            ],
            'purple' => [
                'badge'   => 'bg-purple-500/10 text-purple-700 dark:text-purple-300 border border-purple-500/20',
                'icon_bg' => 'bg-purple-500/10 dark:bg-purple-500/15 text-purple-600 dark:text-purple-400 border border-purple-500/20 shadow-xs',
                'top_bar' => 'before:bg-purple-500',
            ],
            'amber' => [
                'badge'   => 'bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-500/20',
                'icon_bg' => 'bg-amber-500/10 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/20 shadow-xs',
                'top_bar' => 'before:bg-amber-500',
            ],
            'rose' => [
                'badge'   => 'bg-rose-500/10 text-rose-700 dark:text-rose-300 border border-rose-500/20',
                'icon_bg' => 'bg-rose-500/10 dark:bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/20 shadow-xs',
                'top_bar' => 'before:bg-rose-500',
            ],
        ];

        $missionTheme = $colorThemes[$missionColor] ?? $colorThemes['cyan'];
        $visionTheme = $colorThemes[$visionColor] ?? $colorThemes['emerald'];
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
                            @if($activeStats->isNotEmpty())
                                <div class="grid {{ $statCount === 1 ? 'grid-cols-1' : ($statCount === 2 ? 'grid-cols-2' : ($statCount === 3 ? 'grid-cols-1 sm:grid-cols-3' : 'grid-cols-2')) }} gap-4 pt-2">
                                    @foreach($activeStats as $stat)
                                        @php
                                            $cKey = $stat['color'] ?? 'cyan';
                                            $valColorClass = $statColorClasses[$cKey] ?? 'text-[#003C58] dark:text-cyan-400';
                                        @endphp
                                        <div class="p-4 rounded-xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-2xs">
                                            <span class="block text-2xl font-black {{ $valColorClass }} tracking-tight">
                                                {{ $stat['value'] }}
                                            </span>
                                            <span class="text-[11px] text-slate-500 font-medium block mt-0.5">
                                                {{ $stat['label'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
                        @if($activeStats->isNotEmpty())
                            @php
                                $expandedContainerClass = match(true) {
                                    $statCount === 1 => 'max-w-xs mx-auto grid-cols-1',
                                    $statCount === 2 => 'max-w-xl mx-auto grid-cols-1 sm:grid-cols-2',
                                    $statCount === 3 => 'max-w-3xl mx-auto grid-cols-1 sm:grid-cols-3',
                                    $statCount === 4 => 'max-w-4xl mx-auto grid-cols-2 sm:grid-cols-4',
                                    default          => 'max-w-5xl mx-auto grid-cols-2 sm:grid-cols-3 lg:grid-cols-4',
                                };
                            @endphp
                            <div class="grid {{ $expandedContainerClass }} gap-6 pt-2">
                                @foreach($activeStats as $stat)
                                    @php
                                        $cKey = $stat['color'] ?? 'cyan';
                                        $valColorClass = $statColorClasses[$cKey] ?? 'text-[#003C58] dark:text-cyan-400';
                                    @endphp
                                    <div class="p-6 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center shadow-2xs">
                                        <span class="block text-3xl font-black {{ $valColorClass }} tracking-tight">
                                            {{ $stat['value'] }}
                                        </span>
                                        <span class="text-xs text-slate-500 font-medium mt-1 block">
                                            {{ $stat['label'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Mission & Vision -->
    @if($showMission || $showVision)
        @php
            $cardBaseStyle = match($mvStyle) {
                'bordered' => 'relative bg-white dark:bg-[#081726] border-2 border-slate-200 dark:border-slate-700/80 shadow-md overflow-hidden before:absolute before:top-0 before:left-0 before:right-0 before:h-1.5',
                'gradient' => 'bg-gradient-to-br from-slate-50 via-white to-cyan-50/20 dark:from-[#0b1b2b] dark:via-[#091827] dark:to-[#042035] border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md transition-all',
                default    => 'bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all',
            };

            $missionCardClass = "p-8 rounded-3xl {$cardBaseStyle} " . ($mvStyle === 'bordered' ? $missionTheme['top_bar'] : '');
            $visionCardClass  = "p-8 rounded-3xl {$cardBaseStyle} " . ($mvStyle === 'bordered' ? $visionTheme['top_bar'] : '');
        @endphp

        <section id="mission" class="py-20 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
                <div class="{{ ($showMission && $showVision) ? 'grid grid-cols-1 lg:grid-cols-2 gap-8' : 'max-w-3xl mx-auto' }}">
                    
                    {{-- Mission Card --}}
                    @if($showMission)
                        <div class="{{ $missionCardClass }}">
                            @if($mvAlign === 'center')
                                <div class="space-y-4 text-center flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-2xl {{ $missionTheme['icon_bg'] }} flex items-center justify-center">
                                        <x-icon :name="$missionIcon" class="w-7 h-7" />
                                    </div>
                                    @if(!empty($missionBadge))
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full {{ $missionTheme['badge'] }}">
                                            {{ $missionBadge }}
                                        </span>
                                    @endif
                                    <h3 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ $missionTitle }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-xl mx-auto">
                                        {{ $missionText }}
                                    </p>
                                </div>
                            @elseif($mvAlign === 'horizontal')
                                <div class="flex flex-col sm:flex-row items-start gap-5">
                                    <div class="w-14 h-14 rounded-2xl {{ $missionTheme['icon_bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                                        <x-icon :name="$missionIcon" class="w-7 h-7" />
                                    </div>
                                    <div class="space-y-2 flex-1">
                                        @if(!empty($missionBadge))
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $missionTheme['badge'] }} inline-block">
                                                {{ $missionBadge }}
                                            </span>
                                        @endif
                                        <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                            {{ $missionTitle }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                            {{ $missionText }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                {{-- Left Aligned (Default) --}}
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl {{ $missionTheme['icon_bg'] }} flex items-center justify-center shrink-0">
                                            <x-icon :name="$missionIcon" class="w-6 h-6" />
                                        </div>
                                        @if(!empty($missionBadge))
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $missionTheme['badge'] }}">
                                                {{ $missionBadge }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ $missionTitle }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ $missionText }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Vision Card --}}
                    @if($showVision)
                        <div class="{{ $visionCardClass }}">
                            @if($mvAlign === 'center')
                                <div class="space-y-4 text-center flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-2xl {{ $visionTheme['icon_bg'] }} flex items-center justify-center">
                                        <x-icon :name="$visionIcon" class="w-7 h-7" />
                                    </div>
                                    @if(!empty($visionBadge))
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full {{ $visionTheme['badge'] }}">
                                            {{ $visionBadge }}
                                        </span>
                                    @endif
                                    <h3 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ $visionTitle }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-xl mx-auto">
                                        {{ $visionText }}
                                    </p>
                                </div>
                            @elseif($mvAlign === 'horizontal')
                                <div class="flex flex-col sm:flex-row items-start gap-5">
                                    <div class="w-14 h-14 rounded-2xl {{ $visionTheme['icon_bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                                        <x-icon :name="$visionIcon" class="w-7 h-7" />
                                    </div>
                                    <div class="space-y-2 flex-1">
                                        @if(!empty($visionBadge))
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $visionTheme['badge'] }} inline-block">
                                                {{ $visionBadge }}
                                            </span>
                                        @endif
                                        <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                            {{ $visionTitle }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                            {{ $visionText }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                {{-- Left Aligned (Default) --}}
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl {{ $visionTheme['icon_bg'] }} flex items-center justify-center shrink-0">
                                            <x-icon :name="$visionIcon" class="w-6 h-6" />
                                        </div>
                                        @if(!empty($visionBadge))
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $visionTheme['badge'] }}">
                                                {{ $visionBadge }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ $visionTitle }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ $visionText }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
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