<x-layouts.frontend :title="\App\Models\Setting::get('services_hero_title', 'Precision Overhaul Services & Dynamic Balancing')">
    
    @php
        $bgStyle = \App\Models\Setting::get('services_header_bg', 'transparent');
        $frostedOpacity = max(10, min(90, (int) \App\Models\Setting::get('services_header_frosted_opacity', 80)));
        $opacityDecimal = $frostedOpacity / 100;

        $customLightBg = \App\Models\Setting::get('services_header_light_bg', '#ffffff');
        $customDarkBg = \App\Models\Setting::get('services_header_dark_bg', '#07131e');
        $customLightText = \App\Models\Setting::get('services_header_light_text', '#0f172a');
        $customDarkText = \App\Models\Setting::get('services_header_dark_text', '#f8fafc');

        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'header-frosted-services backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            'custom'   => 'header-custom-services',
            default    => 'bg-transparent',
        };

        $colsSetting = \App\Models\Setting::get('services_grid_cols', '1');
        $perPage = \App\Models\Setting::get('services_per_page', '12');
        $showQuoteBtn = (bool) \App\Models\Setting::get('services_show_quote_btn', true);
        $showScopeBtn = (bool) \App\Models\Setting::get('services_show_scope_btn', true);

        $query = \App\Models\Service::with('featuredImage')
            ->where('is_active', true)
            ->orderBy('order', 'asc');

        if ($perPage !== 'all') {
            $query->take((int) $perPage);
        }
        $services = $query->get();
    @endphp

    @if($bgStyle === 'frosted')
        <style>
            .header-frosted-services { background-color: rgba(255, 255, 255, {{ $opacityDecimal }}); }
            .dark .header-frosted-services { background-color: rgba(7, 19, 30, {{ $opacityDecimal }}); }
        </style>
    @elseif($bgStyle === 'custom')
        <style>
            .header-custom-services { background-color: {{ $customLightBg }}; color: {{ $customLightText }}; }
            .header-custom-services h1, .header-custom-services p { color: {{ $customLightText }}; }
            .dark .header-custom-services { background-color: {{ $customDarkBg }}; color: {{ $customDarkText }}; }
            .dark .header-custom-services h1, .dark .header-custom-services p { color: {{ $customDarkText }}; }
        </style>
    @endif

    <!-- Hero Header -->
    <div class="py-16 sm:py-24 {{ $headerBgClasses }} border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 shadow-2xs">
                {{ \App\Models\Setting::get('services_badge', 'Technical Capabilities') }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-slate-900 dark:text-white mt-4 leading-tight drop-shadow-xs">
                {{ \App\Models\Setting::get('services_hero_title', 'Precision Overhaul Services & Port Flying Squads.') }}
            </h1>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl mt-4 leading-relaxed font-medium">
                {{ \App\Models\Setting::get('services_hero_subtitle', 'Operating with calibrated German balancing rigs and certified marine engineers to guarantee that every turbocharger overhaul achieves maximum boost pressure and zero vibration.') }}
            </p>
        </div>
    </div>

    <!-- Overhaul Services Detailed Grid -->
    <section class="py-20 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            @if($colsSetting === '1')
                <!-- 1 Column: Detailed Full-Width Split Cards (Default) -->
                <div class="space-y-12">
                    @forelse ($services as $index => $service)
                        <div id="{{ $service->slug }}" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm">
                            <div class="lg:col-span-8 space-y-4">
                                <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-wider">
                                    {{ sprintf('%02d', $index + 1) }} &bull; {{ strtoupper(str_replace('-', ' ', explode('-', $service->slug)[0] ?? 'OVERHAUL')) }}
                                </span>
                                <h2 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">
                                    <a href="{{ route('service.details', $service->slug) }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">
                                        {{ $service->display_title }}
                                    </a>
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                    {{ $service->display_content ?: $service->display_summary }}
                                </p>
                                @if($showScopeBtn || $showQuoteBtn)
                                    <div class="pt-2 flex items-center gap-3">
                                        @if($showScopeBtn)
                                            <a href="{{ route('service.details', $service->slug) }}" 
                                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 hover:bg-[#024a6d] shadow-sm transition-all">
                                                <span>Technical Procedure &amp; Scope &rarr;</span>
                                            </a>
                                        @endif
                                        @if($showQuoteBtn)
                                            <a href="{{ route('contact') }}#rfq" 
                                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                                                <span>Request Quotation</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="lg:col-span-4 flex justify-center">
                                @if ($service->featuredImage)
                                    <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-md aspect-video w-full">
                                        <img src="{{ $service->featuredImage->url }}" alt="{{ $service->display_title }}" class="w-full h-full object-cover" />
                                    </div>
                                @else
                                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shadow-inner">
                                        <x-icon :name="$service->icon ?: 'solid:wrench'" class="w-14 h-14" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400">
                            <p class="text-sm">No active services currently published.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <!-- Multi-Column Grid (2 or 3 Columns) -->
                @php
                    $multiGridClass = ($colsSetting === '2') ? 'grid-cols-1 md:grid-cols-2 gap-8' : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';
                @endphp
                <div class="grid {{ $multiGridClass }}">
                    @forelse ($services as $index => $service)
                        <div id="{{ $service->slug }}" class="group rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 p-6 shadow-sm hover:shadow-xl transition-all flex flex-col justify-between space-y-5">
                            <div class="space-y-4">
                                @if ($service->featuredImage)
                                    <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xs aspect-video w-full">
                                        <img src="{{ $service->featuredImage->url }}" alt="{{ $service->display_title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                    </div>
                                @endif
                                <span class="text-[11px] font-mono font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-wider block">
                                    {{ sprintf('%02d', $index + 1) }} &bull; {{ strtoupper(str_replace('-', ' ', explode('-', $service->slug)[0] ?? 'SERVICE')) }}
                                </span>
                                <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors">
                                    <a href="{{ route('service.details', $service->slug) }}">
                                        {{ $service->display_title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                    {{ $service->display_summary ?: strip_tags($service->display_content) }}
                                </p>
                            </div>

                            @if($showScopeBtn || $showQuoteBtn)
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                                    @if($showScopeBtn)
                                        <a href="{{ route('service.details', $service->slug) }}" 
                                           class="px-3.5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 hover:bg-[#024a6d] shadow-2xs transition-all inline-flex items-center gap-1">
                                            <span>Details</span>
                                            <x-icon name="solid:arrow-right" class="w-3 h-3" />
                                        </a>
                                    @endif
                                    @if($showQuoteBtn)
                                        <a href="{{ route('contact') }}#rfq" 
                                           class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                                            <span>Quote</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full p-12 text-center text-slate-400">
                            <p class="text-sm">No active services currently published.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </section>

    <!-- Bottom CTA -->
    <div class="py-16 bg-white/90 dark:bg-[#07131e]/90 text-center">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">Need an Emergency Port Squad or Overhaul Quotation?</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                Submit your vessel particulars and our duty marine superintendent will get back to you immediately.
            </p>
            <div class="pt-2">
                <a href="{{ route('contact') }}#rfq" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs shadow-lg hover:shadow-xl transition-all">
                    <span>Contact Port Desk Now &rarr;</span>
                </a>
            </div>
        </div>
    </div>

</x-layouts.frontend>
