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

    $align = \App\Models\Setting::get('home_services_align', 'left');
    $headerAlignClass = match($align) {
        'center' => 'text-center mx-auto items-center justify-center',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-left mr-auto ml-0 items-start justify-start',
    };

    $staticItems = \App\Models\Setting::getJson('home_services_static_items', []);
    if (empty($staticItems)) {
        $staticItems = [
            ['title' => 'Dynamic Rotor Balancing (100k RPM)', 'category' => 'BALANCING', 'icon' => 'solid:gauge', 'excerpt' => 'Elimination of micro-vibrations with computerized dynamic balancing up to 100,000 RPM, certified with comprehensive tolerance test sheets.', 'url' => '/services#balancing'],
            ['title' => 'Turbine Blading & TIG Welding', 'category' => 'WELDING', 'icon' => 'solid:fire-flame-curved', 'excerpt' => 'Precision laser and micro-TIG rebuilding of eroded turbine blade profiles, shroud rings, and metallurgical crack restoration.', 'url' => '/services#overhaul'],
            ['title' => 'Cartridge (CHRA) Exchange', 'category' => 'CHRA', 'icon' => 'solid:arrows-rotate', 'excerpt' => 'Pre-assembled, factory-balanced cartridge replacement modules for rapid turnaround times during tight vessel port calls.', 'url' => '/services#cartridge'],
            ['title' => 'Ultrasonic Chemical Cleaning', 'category' => 'CHEMICAL', 'icon' => 'solid:spray-can', 'excerpt' => 'Multi-stage heated ultrasonic bath cleaning to remove stubborn heavy fuel oil carbon glaze without damaging parent metal tolerances.', 'url' => '/services#ultrasonic'],
            ['title' => 'Bearing Journal Micro-Polishing', 'category' => 'MACHINING', 'icon' => 'solid:microchip', 'excerpt' => 'Superfinishing and micro-polishing of journal shaft bearing journals to mirror finish, ensuring hydrodynamic oil film integrity.', 'url' => '/services#bearing'],
            ['title' => '24/7 Port Emergency Flying Squads', 'category' => 'EMERGENCY', 'icon' => 'solid:helicopter', 'excerpt' => 'Marine engineers equipped with mobile inspection tools ready to board vessels at Chattogram, Mongla, or international outer anchorages.', 'url' => '/contact#emergency'],
        ];
    }
@endphp

<!-- =====================================================================
     PRECISION OVERHAUL SERVICES
     ===================================================================== -->
<x-section-styler-wrap sectionKey="services" id="services">
    
    <div class="max-w-3xl space-y-3 mb-16 {{ $headerAlignClass }}">
        <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 inline-block">
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
            @foreach($staticItems as $idx => $sItem)
                <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx % 3 + 1) * 100 }} p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">0{{ $idx + 1 }} / {{ strtoupper($sItem['category'] ?? 'CAPABILITY') }}</span>
                            <x-icon :name="$sItem['icon'] ?? 'solid:wrench'" class="w-5 h-5 text-slate-400" />
                        </div>
                        <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">{{ $sItem['title'] ?? 'Precision Overhaul' }}</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $sItem['excerpt'] ?? '' }}
                        </p>
                    </div>
                    @if(!empty($sItem['url']))
                    <a href="{{ $sItem['url'] }}" class="pt-2 text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline flex items-center gap-1">
                        <span>Details &rarr;</span>
                    </a>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</x-section-styler-wrap>
