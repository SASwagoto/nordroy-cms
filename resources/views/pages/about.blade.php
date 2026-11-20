<x-layouts.frontend :title="\App\Models\Setting::get('about_hero_title', 'About Our Conglomerate & Engineering Heritage')">
    
    <!-- Hero Header (Transparent so background video is visible behind the title) -->
    <div class="py-16 sm:py-24 bg-transparent border-b border-slate-200/80 dark:border-slate-800 transition-colors">
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
    <section id="overview" class="py-20 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
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
                    @php
                        $partners = \App\Models\Setting::getJson('about_partners_list', [
                            ['brand' => 'Accelleron (ABB)', 'models' => 'VTR, TPL, TPS, A100 & TPR series overhauls.'],
                            ['brand' => 'MAN Energy Solutions', 'models' => 'NR, NA, TCR, TCA & radial designs.'],
                            ['brand' => 'KBB', 'models' => 'M40, R-series, and HPR industrial compressors.'],
                            ['brand' => 'Mitsubishi Heavy Industries', 'models' => 'MET-SR, MET-SC & MET-MA models.'],
                        ]);
                    @endphp
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
        </div>
    </section>

    <!-- Mission & Vision -->
    <section id="mission" class="py-20 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
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
        </div>
    </section>

    <!-- Quality Standards -->
    <section id="certifications" class="py-20 bg-white dark:bg-[#07131e]">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 text-center space-y-6">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400">
                {{ \App\Models\Setting::get('about_cert_badge', 'Quality Framework') }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                {{ \App\Models\Setting::get('about_cert_title', 'International Accreditations') }}
            </h2>
            @php
                $certList = \App\Models\Setting::getJson('about_cert_list', [
                    'ISO 9001:2015 CERTIFIED',
                    'DNV CLASSIFIED FACILITY',
                    'ASNT LEVEL III NDT BENCH',
                    "LLOYD'S REGISTER STANDARDS",
                ]);
            @endphp
            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                @foreach($certList as $cert)
                    <span class="px-6 py-3 rounded-2xl bg-slate-100 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-xs font-bold font-mono">
                        {{ $cert }}
                    </span>
                @endforeach
            </div>
        </div>
    </section>

</x-layouts.frontend>
