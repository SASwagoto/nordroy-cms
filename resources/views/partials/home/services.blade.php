@php
    $servicesEnabled = (bool) \App\Models\Setting::get('home_services_enabled', true);
    if (!$servicesEnabled) return;

    $servicesBadge = \App\Models\Setting::get('home_services_badge', 'Workshop & Port Capabilities');
    $servicesTitle = \App\Models\Setting::get('home_services_title', 'Precision Overhaul Services');
    $servicesSubtitle = \App\Models\Setting::get('home_services_subtitle', 'Engineered according to manufacturer tolerance protocols with calibrated German Schenck balancing rigs.');
    $servicesMode = \App\Models\Setting::get('home_services_mode', 'static');
    $servicesLimit = (int) \App\Models\Setting::get('home_services_limit', 6);

    $dynamicServices = collect();
    if ($servicesMode === 'dynamic') {
        try {
            $dynamicServices = \App\Models\Service::where('is_active', true)->take($servicesLimit)->get();
        } catch (\Throwable $e) {
            $dynamicServices = collect();
        }
    }
@endphp

<!-- =====================================================================
     PRECISION OVERHAUL SERVICES (Turbo Internacional Style)
     ===================================================================== -->
<section id="services" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                {{ __($servicesBadge) }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                {{ __($servicesTitle) }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __($servicesSubtitle) }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if($servicesMode === 'dynamic' && $dynamicServices->isNotEmpty())
                @foreach($dynamicServices as $idx => $svc)
                    <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx % 3 + 1) * 100 }} p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">0{{ $idx + 1 }} / {{ strtoupper($svc->category ?? 'CAPABILITY') }}</span>
                                <x-icon :name="$svc->icon ?: 'solid:wrench'" class="w-5 h-5 text-slate-400" />
                            </div>
                            <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">{{ $svc->title }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ Str::limit($svc->excerpt ?? $svc->description, 140) }}
                            </p>
                        </div>
                        <a href="{{ route('service.details', $svc->slug) }}" class="pt-2 text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline flex items-center gap-1">
                            <span>Details &rarr;</span>
                        </a>
                    </div>
                @endforeach
            @else
                <!-- Service 1 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">01 / BALANCING</span>
                        <x-icon name="solid:gauge" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Dynamic Rotor Balancing (100k RPM)</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Elimination of micro-vibrations with computerized dynamic balancing up to 100,000 RPM, certified with comprehensive tolerance test sheets.
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">02 / WELDING</span>
                        <x-icon name="solid:fire-flame-curved" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Turbine Blading &amp; TIG Welding</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Precision laser and micro-TIG rebuilding of eroded turbine blade profiles, shroud rings, and metallurgical crack restoration.
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="reveal-init reveal-fade-up reveal-delay-300 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">03 / CHRA</span>
                        <x-icon name="solid:arrows-rotate" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Cartridge (CHRA) Exchange</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pre-assembled, factory-balanced cartridge replacement modules for rapid turnaround times during tight vessel port calls.
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">04 / CHEMICAL</span>
                        <x-icon name="solid:spray-can" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Ultrasonic Chemical De-Carbonization</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Multi-stage heated ultrasonic bath cleaning to remove stubborn heavy fuel oil carbon glaze without damaging parent metal tolerances.
                    </p>
                </div>

                <!-- Service 5 -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">05 / FLYING SQUAD</span>
                        <x-icon name="solid:truck-fast" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">24/7 Port Emergency Flying Squads</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Marine engineers equipped with mobile inspection tools ready to board vessels at Chattogram, Mongla, or international outer anchorages.
                    </p>
                </div>

                <!-- Service 6 -->
                <div class="reveal-init reveal-fade-up reveal-delay-300 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">06 / RETROFIT</span>
                        <x-icon name="solid:wrench" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Retrofit &amp; Modernization Upgrades</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Replacement of outdated, obsolete turbochargers with modern, high-efficiency models for reduced fuel consumption and lower IMO emissions.
                    </p>
                </div>
            @endif
        </div>

    </div>
</section>
