<x-layouts.frontend>
    @php
        $heroSettings = \App\Models\Setting::getJson('hero_banner_settings') ?: [];
        $heroSlides   = \App\Models\Setting::getJson('hero_banner_slides') ?: [];
        $heroCards    = \App\Models\Setting::getJson('hero_banner_cards') ?: [];
        $heroEnabled  = $heroSettings['enabled'] ?? true;
        $heroLayout   = $heroSettings['layout'] ?? [];
        $heroStyle    = $heroLayout['hero_style'] ?? 'split';

        // Load Homepage Sections from DB or Safe Fallbacks
        $dbSections = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('pages') && \Illuminate\Support\Facades\Schema::hasTable('page_sections')) {
            try {
                $homepage = \App\Models\Page::where('slug', 'home')->first();
                $dbSections = $homepage
                    ? \App\Models\PageSection::where('page_id', $homepage->id)->where('is_active', true)->orderBy('order')->get()
                    : \App\Models\PageSection::where('is_active', true)->orderBy('order')->get();
            } catch (\Throwable $e) {}
        }

        if ($dbSections->isEmpty()) {
            $dbSections = collect([
                (object)[
                    'section_type' => 'grid',
                    'title' => 'Marine & Industrial Turbocharger Services',
                    'settings' => [
                        'title_settings' => [
                            'show' => true,
                            'title' => 'Marine & Industrial Turbocharger Services',
                            'subtitle' => 'Authorized multi-brand overhauls, dynamic rotor balancing, and ultrasonic decarbonization.',
                            'align' => 'center',
                            'show_badge' => true,
                            'badge_text' => 'Certified Capabilities',
                            'badge_icon' => 'solid:certificate',
                        ],
                        'layout' => [
                            'width' => 'container-xl',
                            'bg_type' => 'transparent',
                            'padding_top' => '64px',
                            'padding_bottom' => '64px',
                        ],
                    ],
                    'content' => [
                        'source_type' => 'model',
                        'model' => 'services',
                        'columns' => 3,
                        'card_style' => 'service_card',
                        'limit' => 6,
                        'show_cta' => true,
                        'cta_label' => 'Explore All Services',
                        'cta_url' => '/services',
                    ],
                ],
                (object)[
                    'section_type' => 'banner',
                    'title' => 'Dynamic Balancing Facility',
                    'settings' => [
                        'title_settings' => ['show' => false],
                        'layout' => [
                            'width' => 'container-xl',
                            'bg_type' => 'transparent',
                            'padding_top' => '32px',
                            'padding_bottom' => '64px',
                        ],
                    ],
                    'content' => [
                        'layout_variant' => 'split_right',
                        'eyebrow' => 'Precision Engineering',
                        'headline' => 'Authorized Turbocharger Dynamic Balancing Facility',
                        'description' => 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for commercial vessels and power plants.',
                        'bullet_points' => [
                            'Schenck CAB 920 High-Speed Balancing',
                            'ISO 1940 Grade G1.0 Certification',
                            '24/7 Port Flying Squad Deployment',
                            'Calibrated OEM Clearances & Tolerances',
                        ],
                        'btn1_text' => 'Request Overhaul Service',
                        'btn1_url' => '/#inquiry',
                        'btn2_text' => 'Technical Specs',
                        'btn2_url' => '/services',
                    ],
                ],
                (object)[
                    'section_type' => 'stats',
                    'title' => 'Operating Metrics & Turnaround',
                    'settings' => [
                        'title_settings' => [
                            'show' => true,
                            'title' => 'Proven Maritime Performance',
                            'subtitle' => 'Delivering precision turnaround and class-approved reliability at major ports.',
                            'align' => 'center',
                        ],
                        'layout' => [
                            'width' => 'container-xl',
                            'bg_type' => 'transparent',
                            'padding_top' => '48px',
                            'padding_bottom' => '64px',
                        ],
                    ],
                    'content' => [
                        'items' => [
                            ['number' => '100,000', 'label' => 'Max Balancing RPM', 'detail' => 'ISO 1940 Grade G1.0'],
                            ['number' => '24/7', 'label' => 'Port Flying Squad', 'detail' => 'Direct anchorage access'],
                            ['number' => '1,850+', 'label' => 'Rotors Balanced', 'detail' => 'Zero vibration defects'],
                            ['number' => '100%', 'label' => 'OEM Calibrated', 'detail' => 'Class compliance assured'],
                        ],
                    ],
                ],
                (object)[
                    'section_type' => 'faq',
                    'title' => 'Frequently Asked Questions',
                    'settings' => [
                        'title_settings' => [
                            'show' => true,
                            'title' => 'Frequently Asked Questions',
                            'subtitle' => 'Clear answers to port attendance, overhaul turnarounds, and balancing standards.',
                            'align' => 'center',
                        ],
                        'layout' => [
                            'width' => 'container-xl',
                            'bg_type' => 'transparent',
                            'padding_top' => '48px',
                            'padding_bottom' => '64px',
                        ],
                    ],
                    'content' => [
                        'items' => [
                            ['q' => 'What is your turnaround time for port anchorage overhauls?', 'a' => 'Our 24/7 flying squad boards within 2-4 hours of vessel berthing or outer anchorage clearance. Standard routine overhauls and dynamic balancing are typically completed within 12 to 24 hours to prevent port demurrage.'],
                            ['q' => 'Which turbocharger brands do you support?', 'a' => 'We service ABB / Accelleron (VTR, TPS, TPL, A100), Mitsubishi MET, MAN / Napier, Garrett, and KBB units with genuine OEM specification parts.'],
                            ['q' => 'Do you provide dynamic balancing certification?', 'a' => 'Yes. Every balanced rotor receives an official computerized Schenck CAB 920 balancing report verifying residual unbalance conforms to ISO 1940 Grade G1.0 or G2.5.'],
                        ],
                    ],
                ],
                (object)[
                    'section_type' => 'form',
                    'title' => 'Emergency Dispatch & Instant RFQ',
                    'settings' => [
                        'title_settings' => [
                            'show' => true,
                            'title' => 'Direct Engineering Attendance & RFQ',
                            'subtitle' => 'Dispatch certified engineers to port or request immediate technical consultation.',
                            'align' => 'center',
                        ],
                        'layout' => [
                            'width' => 'container-xl',
                            'bg_type' => 'transparent',
                            'padding_top' => '48px',
                            'padding_bottom' => '80px',
                        ],
                    ],
                    'content' => [],
                ],
            ]);
        }
    @endphp

    {{-- ========================================================================= --}}
    {{-- SECTION 1: HERO BANNER (DYNAMIC BY HERO PRESENTATION STYLE)               --}}
    {{-- ========================================================================= --}}
    @if ($heroEnabled)
        @php
            $heroWidth = $heroLayout['width'] ?? 'container-panoramic';
            $heroContainerClass = match($heroWidth) {
                'container-fluid' => 'w-full px-4 sm:px-8',
                'container-panoramic' => 'max-w-[1680px] mx-auto px-4 sm:px-8',
                'container-lg' => 'max-w-5xl mx-auto px-4 sm:px-6',
                default => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
            };

            $heroBgType = $heroLayout['bg_type'] ?? 'frosted';
            $heroTextColor = $heroLayout['text_color'] ?? '';
            $heroPTop = $heroLayout['padding_top'] ?? '64px';
            $heroPBottom = $heroLayout['padding_bottom'] ?? '80px';
            $firstSlide = $heroSlides[0] ?? [
                'headline'  => 'Precision Turbocharger Overhauls & Marine Propulsion Support.',
                'subtitle'  => 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil & gas terminals.',
                'tag'       => 'Authorized Multi-Brand Turbocharger Engineering',
                'badge'     => 'ISO 9001:2015 • DNV Certified',
                'cta1_text' => 'Explore Overhaul Services',
                'cta1_url'  => '/services',
                'cta2_text' => 'Request Instant RFQ',
                'cta2_url'  => '/#inquiry',
            ];
        @endphp

        <!-- HERO PRESENTATION: SPLIT (INDUSTRIAL SHOWCASE WITH INSTRUMENT DIAL) -->
        @if ($heroStyle === 'split')
            <section class="relative overflow-hidden text-slate-900 dark:text-white border-b border-slate-200/90 dark:border-slate-800 transition-colors duration-200"
                     style="padding-top: {{ $heroPTop }}; padding-bottom: {{ $heroPBottom }}; {{ $heroTextColor ? "color: {$heroTextColor};" : '' }}">
                
                <!-- Subtle Industrial Geometric Grid Background -->
                <div class="absolute inset-0 opacity-[0.025] dark:opacity-[0.04] pointer-events-none bg-[radial-gradient(#003C58_1px,transparent_1px)] dark:bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>

                <div class="{{ $heroContainerClass }} relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
                        
                        <!-- Left Column: Copy & Actions (7 cols) -->
                        <div class="lg:col-span-7 space-y-6 sm:space-y-8 p-6 sm:p-8 lg:p-0 rounded-3xl bg-white/85 dark:bg-[#07131e]/75 lg:bg-transparent lg:dark:bg-transparent backdrop-blur-xs lg:backdrop-blur-none border border-white/60 dark:border-slate-800/60 lg:border-none">
                            
                            <!-- Badges -->
                            <div class="flex flex-wrap items-center gap-2.5">
                                @if(!empty($firstSlide['tag']))
                                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-800 shadow-2xs">
                                        {{ $firstSlide['tag'] }}
                                    </span>
                                @endif
                                @if(!empty($firstSlide['badge']))
                                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-white dark:bg-[#0a1926] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                        {{ $firstSlide['badge'] }}
                                    </span>
                                @endif
                            </div>

                            <!-- Main Headline -->
                            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.12] tracking-tight font-heading text-slate-900 dark:text-white drop-shadow-xs">
                                {{ $firstSlide['headline'] ?? 'Precision Turbocharger Overhauls & Marine Propulsion Support.' }}
                            </h1>

                            <!-- Technical Subtitle -->
                            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl font-body font-medium">
                                {{ $firstSlide['subtitle'] ?? 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics.' }}
                            </p>

                            <!-- Dual Call-to-Action Buttons -->
                            <div class="flex flex-wrap items-center gap-4 pt-2">
                                <a href="{{ $firstSlide['cta1_url'] ?? '/services' }}" 
                                   class="inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-white shadow-lg active:scale-95 transition-all bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950">
                                    <span>{{ $firstSlide['cta1_text'] ?? 'Explore Overhaul Services' }}</span>
                                    <x-icon name="solid:arrow-right" class="w-4 h-4" />
                                </a>

                                <a href="{{ $firstSlide['cta2_url'] ?? '/#inquiry' }}" 
                                   class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 hover:bg-slate-100 dark:hover:bg-slate-800 active:scale-95 transition-all">
                                    <span>{{ $firstSlide['cta2_text'] ?? 'Request Instant RFQ' }}</span>
                                </a>
                            </div>

                            <!-- Key Technical Highlights Strip -->
                            <div class="pt-6 border-t border-slate-200/80 dark:border-slate-800 grid grid-cols-3 gap-4 text-xs">
                                <div>
                                    <span class="block text-2xl sm:text-3xl font-black text-[#003C58] dark:text-cyan-400 font-heading">100,000</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">RPM Dynamic Balancing</span>
                                </div>
                                <div>
                                    <span class="block text-2xl sm:text-3xl font-black text-slate-800 dark:text-white font-heading">24/7/365</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Flying Squads to Port</span>
                                </div>
                                <div>
                                    <span class="block text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 font-heading">100%</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Calibrated OEM Specs</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Precision Rotor Visual Dial or Background Image (5 cols) -->
                        <div class="lg:col-span-5 relative">
                            @if (!empty($firstSlide['image_url'] ?? $firstSlide['image'] ?? ''))
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800">
                                    <img src="{{ $firstSlide['image_url'] ?? $firstSlide['image'] }}" class="w-full h-[440px] object-cover" alt="Hero Showcase">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                                        <div class="text-white space-y-1">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-cyan-500 text-slate-950 uppercase">Authorized Facility</span>
                                            <p class="text-sm font-bold">{{ $firstSlide['headline'] ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Precision Turbine Instrument Dial -->
                                <div class="relative rounded-3xl p-6 sm:p-8 bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl transition-all">
                                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                            <span class="text-xs font-mono font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Turbine Test Bench</span>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-mono font-bold bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20">SCHENCK CAB 920</span>
                                    </div>
                                    <div class="py-8 flex flex-col items-center justify-center text-center">
                                        <div class="relative w-48 h-48 sm:w-56 sm:h-56 rounded-full border-4 border-slate-100 dark:border-slate-800 flex items-center justify-center bg-slate-50 dark:bg-slate-900/50 shadow-inner">
                                            <div class="w-36 h-36 rounded-full border-2 border-dashed border-[#003C58]/30 dark:border-cyan-400/30 flex items-center justify-center animate-spin [animation-duration:20s]">
                                                <x-icon name="solid:fan" class="w-16 h-16 text-[#003C58] dark:text-cyan-400" />
                                            </div>
                                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                                <span class="text-2xl sm:text-3xl font-black font-mono text-slate-900 dark:text-white">99.8%</span>
                                                <span class="text-[9px] uppercase tracking-wider font-bold text-emerald-500">ISO 1940 G1.0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100 dark:border-slate-800 text-xs">
                                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                            <span class="block text-[10px] text-slate-400 font-mono">Max Journal Diameter</span>
                                            <span class="font-bold text-slate-800 dark:text-slate-200">Up to 3,200 mm</span>
                                        </div>
                                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                            <span class="block text-[10px] text-slate-400 font-mono">Rotor Weight Capacity</span>
                                            <span class="font-bold text-slate-800 dark:text-slate-200">5.5 Metric Tons</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </section>

        <!-- HERO PRESENTATION: FULLSCREEN CAROUSEL SLIDER -->
        @elseif ($heroStyle === 'slider')
            <section class="relative overflow-hidden text-white bg-slate-950" x-data="{ currentSlide: 0, total: {{ count($heroSlides) ?: 1 }} }">
                @foreach ($heroSlides as $hIdx => $hSlide)
                    <div x-show="currentSlide === {{ $hIdx }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-98" x-transition:enter-end="opacity-100 scale-100"
                         class="relative min-h-[560px] flex items-center py-20 bg-cover bg-center"
                         style="background-image: url('{{ $hSlide['image_url'] ?? $hSlide['image'] ?? 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1600' }}');">
                        <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-2xs"></div>
                        <div class="{{ $heroContainerClass }} relative z-10 max-w-4xl text-left space-y-6">
                            @if(!empty($hSlide['tag']))
                                <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-cyan-500 text-slate-950">
                                    {{ $hSlide['tag'] }}
                                </span>
                            @endif
                            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading leading-tight drop-shadow-md">
                                {{ $hSlide['headline'] ?? '' }}
                            </h1>
                            <p class="text-base sm:text-lg text-slate-200 leading-relaxed font-medium">
                                {{ $hSlide['subtitle'] ?? '' }}
                            </p>
                            <div class="flex flex-wrap items-center gap-4 pt-2">
                                <a href="{{ $hSlide['cta1_url'] ?? '/services' }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-cyan-400 hover:bg-cyan-300 shadow-lg transition-all">
                                    {{ $hSlide['cta1_text'] ?? 'Explore Services' }} &rarr;
                                </a>
                                @if(!empty($hSlide['cta2_text']))
                                    <a href="{{ $hSlide['cta2_url'] ?? '/#inquiry' }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-white border border-white/40 hover:bg-white/10 transition-all">
                                        {{ $hSlide['cta2_text'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Slide Navigation Dots -->
                @if (count($heroSlides) > 1)
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                        @foreach ($heroSlides as $hIdx => $hSlide)
                            <button type="button" @click="currentSlide = {{ $hIdx }}"
                                    class="w-3 h-3 rounded-full transition-all cursor-pointer"
                                    :class="currentSlide === {{ $hIdx }} ? 'bg-cyan-400 w-8' : 'bg-white/40'"></button>
                        @endforeach
                    </div>
                @endif
            </section>

        <!-- HERO PRESENTATION: AMBIENT VIDEO BACKGROUND -->
        @elseif ($heroStyle === 'video')
            <section class="relative overflow-hidden text-white bg-slate-950 min-h-[580px] flex items-center py-24">
                <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-40">
                    <source src="{{ $heroLayout['video_url'] ?? asset('assets/videos/ambient.mp4') }}" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-950/80"></div>
                <div class="{{ $heroContainerClass }} relative z-10 max-w-4xl mx-auto text-center space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-cyan-500/20 text-cyan-300 border border-cyan-500/40">
                        <x-icon name="solid:satellite-dish" class="w-3.5 h-3.5 animate-pulse text-cyan-400" />
                        <span>24/7 Port Emergency Engineering Hotline</span>
                    </div>
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading leading-tight drop-shadow-md">
                        {{ $firstSlide['headline'] ?? 'High-Precision Marine Propulsion & Turbocharger Engineering' }}
                    </h1>
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto font-medium">
                        {{ $firstSlide['subtitle'] ?? 'Direct dockside attendance, certified balancing, and genuine spare parts across all ports.' }}
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                        <a href="{{ $firstSlide['cta1_url'] ?? '/services' }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-cyan-400 hover:bg-cyan-300 shadow-lg transition-all">
                            {{ $firstSlide['cta1_text'] ?? 'Explore Capabilities' }} &rarr;
                        </a>
                        <a href="{{ $firstSlide['cta2_url'] ?? '/#inquiry' }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-white border border-white/40 hover:bg-white/10 transition-all">
                            {{ $firstSlide['cta2_text'] ?? 'Request Instant RFQ' }}
                        </a>
                    </div>
                </div>
            </section>

        <!-- HERO PRESENTATION: MINIMAL CLEAN CENTERED -->
        @else
            <section class="relative overflow-hidden text-slate-900 dark:text-white border-b border-slate-200/80 dark:border-slate-800 py-20 sm:py-28">
                <div class="{{ $heroContainerClass }} max-w-4xl mx-auto text-center space-y-6">
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                        {{ $firstSlide['tag'] ?? 'Certified Maritime Capabilities' }}
                    </span>
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight font-heading text-slate-900 dark:text-white">
                        {{ $firstSlide['headline'] ?? 'Precision Marine Propulsion Support.' }}
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed font-medium max-w-2xl mx-auto">
                        {{ $firstSlide['subtitle'] ?? 'Specialized multi-brand maintenance, dynamic rotor balancing, and global OEM spare parts logistics.' }}
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                        <a href="{{ $firstSlide['cta1_url'] ?? '/services' }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:text-slate-950 shadow-md transition-all">
                            {{ $firstSlide['cta1_text'] ?? 'Explore Services' }}
                        </a>
                        <a href="{{ $firstSlide['cta2_url'] ?? '/#inquiry' }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                            {{ $firstSlide['cta2_text'] ?? 'Contact Desk' }}
                        </a>
                    </div>
                </div>
            </section>
        @endif
    @endif

    {{-- ========================================================================= --}}
    {{-- SECTION 2+: DYNAMIC HOMEPAGE SECTIONS LOOP                                --}}
    {{-- ========================================================================= --}}
    @foreach ($dbSections as $sec)
        @php
            $sType = $sec->section_type;
            $sSettings = $sec->settings ?? [];
            $sContent = $sec->content ?? [];
            $sLayout = $sSettings['layout'] ?? [];
            $sTitle = $sSettings['title_settings'] ?? [];

            // Compute Container Width
            $cWidth = $sLayout['width'] ?? 'container-xl';
            $containerClass = match($cWidth) {
                'container-fluid' => 'w-full px-4 sm:px-8',
                'container-panoramic' => 'max-w-[1680px] mx-auto px-4 sm:px-8',
                'container-lg' => 'max-w-5xl mx-auto px-4 sm:px-6',
                default => 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
            };

            // Compute Surface & Box Model Styles
            $pTop = $sLayout['padding_top'] ?? '64px';
            $pBottom = $sLayout['padding_bottom'] ?? '64px';
            $mTop = $sLayout['margin_top'] ?? '0px';
            $mBottom = $sLayout['margin_bottom'] ?? '0px';
            $textColor = $sLayout['text_color'] ?? '';
            $bgType = $sLayout['bg_type'] ?? 'transparent';
            $bgColor = $sLayout['bg_color'] ?? '#ffffff';
            $gradAngle = $sLayout['gradient_angle'] ?? '135deg';
            $grad1 = $sLayout['gradient_stop1'] ?? '#f8fafc';
            $grad2 = $sLayout['gradient_stop2'] ?? '#e2e8f0';
            $bgImage = $sLayout['bg_image'] ?? '';
            $overlayOpacity = ($sLayout['bg_overlay_opacity'] ?? 60) / 100;
            $bStyle = $sLayout['border_style'] ?? 'none';
            $bWidth = ($sLayout['border_width'] ?? 1) . 'px';
            $bColor = $sLayout['border_color'] ?? 'transparent';
            $bRadius = $sLayout['border_radius'] ?? '0px';
            $sShadow = ($sLayout['shadow_mode'] ?? 'none') === 'preset' ? match($sLayout['shadow_preset'] ?? 'md') {
                'sm' => 'shadow-xs',
                'lg' => 'shadow-lg',
                'xl' => 'shadow-2xl',
                default => 'shadow-md',
            } : '';
        @endphp

        <section class="relative transition-colors duration-200 {{ $sShadow }}"
                 style="padding-top: {{ $pTop }}; padding-bottom: {{ $pBottom }}; margin-top: {{ $mTop }}; margin-bottom: {{ $mBottom }}; border-style: {{ $bStyle }}; border-width: {{ $bWidth }}; border-color: {{ $bColor }}; border-radius: {{ $bRadius }}; {{ $bgType === 'color' ? "background-color: {$bgColor};" : ($bgType === 'gradient' ? "background: linear-gradient({$gradAngle}, {$grad1}, {$grad2});" : '') }} {{ $textColor ? "color: {$textColor};" : '' }}">

            @if ($bgType === 'image' && $bgImage)
                <div class="absolute inset-0 bg-cover bg-center -z-10" style="background-image: url('{{ $bgImage }}');">
                    <div class="absolute inset-0 bg-slate-950" style="opacity: {{ $overlayOpacity }};"></div>
                </div>
            @endif

            <div class="{{ $containerClass }}">
                {{-- SECTION TITLE HEADER --}}
                @if ($sTitle['show'] ?? true)
                    <div class="mb-12 {{ ($sTitle['align'] ?? 'center') === 'center' ? 'text-center max-w-3xl mx-auto' : (($sTitle['align'] ?? 'center') === 'end' ? 'text-right' : 'text-left') }}">
                        @if ($sTitle['show_badge'] ?? false)
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/30 mb-3">
                                @if (!empty($sTitle['badge_icon']))
                                    <x-icon :name="$sTitle['badge_icon']" class="w-3.5 h-3.5" />
                                @endif
                                <span>{{ $sTitle['badge_text'] ?? 'Featured' }}</span>
                            </div>
                        @endif

                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight font-heading text-slate-900 dark:text-white"
                            style="{{ !empty($sTitle['title_size']) ? 'font-size: ' . $sTitle['title_size'] . 'px;' : '' }}">
                            {{ $sTitle['title'] ?? $sec->title }}
                        </h2>

                        @if (!empty($sTitle['subtitle']))
                            <p class="mt-3 text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                                {{ $sTitle['subtitle'] }}
                            </p>
                        @endif
                    </div>
                @endif

                {{-- ==================== COMPONENT TYPE 1: GRID SHOWCASE ==================== --}}
                @if ($sType === 'grid')
                    @php
                        $cols = (int)($sContent['columns'] ?? 3);
                        $gridColsClass = match($cols) {
                            2 => 'grid-cols-1 md:grid-cols-2',
                            4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
                            6 => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-6',
                            default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
                        };
                        $gap = $sContent['gap'] ?? '24px';
                        $cardStyle = $sContent['card_style'] ?? 'service_card';
                        $isEqualHeight = (bool)($sContent['equal_height'] ?? true);

                        // Dynamic Model Feeds
                        $sourceType = $sContent['source_type'] ?? 'model';
                        $targetModel = $sContent['model'] ?? 'services';
                        $limit = (int)($sContent['limit'] ?? 6);
                        $filterScope = $sContent['filter_scope'] ?? 'all';

                        $items = [];
                        if ($sourceType === 'model') {
                            try {
                                if ($targetModel === 'services' && \Illuminate\Support\Facades\Schema::hasTable('services')) {
                                    $query = \App\Models\Service::query()->where('is_active', true);
                                    if ($filterScope === 'featured') $query->where('is_featured', true);
                                    $items = $query->take($limit)->get()->map(fn($s) => [
                                        'title'    => $s->title,
                                        'subtitle' => 'ISO 9001:2015 Workshop Scope',
                                        'desc'     => $s->short_summary,
                                        'badge'    => $s->is_featured ? 'Featured Capability' : 'Authorized Scope',
                                        'image'    => $s->featuredImage?->url ?? '',
                                        'icon'     => $s->icon ?: 'solid:wrench',
                                        'link'     => route('services.show', $s->slug),
                                        'link_text'=> 'View Overhaul Details',
                                    ])->toArray();
                                } elseif ($targetModel === 'products' && \Illuminate\Support\Facades\Schema::hasTable('products')) {
                                    $query = \App\Models\Product::query()->where('is_active', true);
                                    if ($filterScope === 'featured') $query->where('is_featured', true);
                                    $items = $query->take($limit)->get()->map(fn($p) => [
                                        'title'    => $p->title,
                                        'subtitle' => 'Part No: ' . ($p->part_number ?: 'OEM-STANDARD'),
                                        'desc'     => 'Genuine calibrated replacement turbocharger rotor and dynamic assembly.',
                                        'badge'    => 'Ready Stock',
                                        'image'    => $p->featuredImage?->url ?? '',
                                        'icon'     => 'solid:gear',
                                        'link'     => route('contact') . '#rfq',
                                        'link_text'=> 'Request Quote',
                                    ])->toArray();
                                } elseif ($targetModel === 'divisions' && \Illuminate\Support\Facades\Schema::hasTable('business_units')) {
                                    $items = \App\Models\BusinessUnit::query()->take($limit)->get()->map(fn($u) => [
                                        'title'    => $u->title,
                                        'subtitle' => 'Est. ' . ($u->establishment_year ?: '2008'),
                                        'desc'     => $u->overview,
                                        'badge'    => 'Strategic Unit',
                                        'image'    => $u->coverImage?->url ?? '',
                                        'icon'     => 'solid:building',
                                        'link'     => $u->website_url ?: route('about'),
                                        'link_text'=> 'Explore Division',
                                    ])->toArray();
                                }
                            } catch (\Throwable $e) {}
                        } else {
                            $items = $sContent['items'] ?? [];
                        }

                        // Robust fallback static items if empty
                        if (empty($items)) {
                            $items = [
                                [
                                    'title'    => 'High-Speed Dynamic Balancing',
                                    'subtitle' => 'ISO 1940 Grade G1.0',
                                    'desc'     => 'Precision computerized dynamic rotor balancing up to 100,000 RPM using Schenck CAB 920 instrumentation.',
                                    'badge'    => 'Core Capability',
                                    'icon'     => 'solid:fan',
                                    'link'     => '/services',
                                    'link_text'=> 'Explore Service',
                                ],
                                [
                                    'title'    => 'Complete Overhauls & Cartridge Rebuilds',
                                    'subtitle' => 'ABB • MET • MAN • Napier',
                                    'desc'     => 'Ultrasonic chemical decarbonization, precision micro-journal machining, labyrinth seal restoration, and blade NDT inspection.',
                                    'badge'    => 'Turnkey Overhaul',
                                    'icon'     => 'solid:wrench',
                                    'link'     => '/services',
                                    'link_text'=> 'Explore Service',
                                ],
                                [
                                    'title'    => '24/7 Port Emergency Flying Squad',
                                    'subtitle' => 'Anchorage & Berth Attendance',
                                    'desc'     => 'Rapid deployment of certified marine engineers and technicians to all ports and anchorages within 2-4 hours.',
                                    'badge'    => '24/7 Emergency',
                                    'icon'     => 'solid:truck-fast',
                                    'link'     => '/#inquiry',
                                    'link_text'=> 'Dispatch Engineer',
                                ],
                            ];
                        }
                    @endphp

                    <div class="grid {{ $gridColsClass }}" style="gap: {{ $gap }};">
                        @foreach ($items as $card)
                            <!-- DEDICATED CARD ARCHETYPES -->
                            @if ($cardStyle === 'service_card')
                                <div class="group relative rounded-2xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800/80 p-6 flex flex-col justify-between hover:border-cyan-500/50 hover:shadow-xl transition-all duration-300 {{ $isEqualHeight ? 'h-full' : '' }}">
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="w-12 h-12 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                                <x-icon name="{{ $card['icon'] ?? 'solid:wrench' }}" class="w-6 h-6" />
                                            </span>
                                            @if(!empty($card['badge']))
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 uppercase tracking-wider">
                                                    {{ $card['badge'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-base sm:text-lg font-bold font-heading text-slate-900 dark:text-white group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors">
                                                {{ $card['title'] ?? '' }}
                                            </h3>
                                            @if(!empty($card['subtitle']))
                                                <span class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 block mt-0.5">{{ $card['subtitle'] }}</span>
                                            @endif
                                        </div>
                                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                            {{ $card['desc'] ?? '' }}
                                        </p>
                                    </div>
                                    <div class="pt-5 mt-4 border-t border-slate-100 dark:border-slate-800/80">
                                        <a href="{{ $card['link'] ?? '#' }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#003C58] dark:text-cyan-400 group-hover:gap-2.5 transition-all">
                                            <span>{{ $card['link_text'] ?? 'Read Full Scope' }}</span>
                                            <x-icon name="solid:arrow-right" class="w-3.5 h-3.5" />
                                        </a>
                                    </div>
                                </div>

                            @elseif ($cardStyle === 'part_card')
                                <div class="group relative rounded-2xl bg-white dark:bg-[#07131e] border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col justify-between hover:shadow-xl transition-all duration-300 {{ $isEqualHeight ? 'h-full' : '' }}">
                                    <div class="relative h-48 bg-slate-100 dark:bg-slate-900 overflow-hidden flex items-center justify-center">
                                        @if (!empty($card['image']))
                                            <img src="{{ $card['image'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $card['title'] ?? '' }}">
                                        @else
                                            <x-icon name="solid:gear" class="w-16 h-16 text-slate-300 dark:text-slate-700" />
                                        @endif
                                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-950/80 text-white backdrop-blur-xs">
                                            {{ $card['subtitle'] ?? 'OEM' }}
                                        </span>
                                    </div>
                                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                                        <div class="space-y-1">
                                            <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $card['title'] ?? '' }}</h3>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">{{ $card['desc'] ?? '' }}</p>
                                        </div>
                                        <a href="{{ $card['link'] ?? '#' }}" class="w-full py-2 rounded-xl text-center text-xs font-bold bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:text-slate-950 text-white shadow-xs transition-colors">
                                            {{ $card['link_text'] ?? 'Request RFQ' }}
                                        </a>
                                    </div>
                                </div>

                            @else
                                <!-- Standard Elevated / Frosted Corporate Card -->
                                <div class="group p-6 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-lg transition-all {{ $isEqualHeight ? 'h-full flex flex-col justify-between' : '' }}">
                                    <div class="space-y-3">
                                        <span class="w-10 h-10 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center">
                                            <x-icon name="{{ $card['icon'] ?? 'solid:cube' }}" class="w-5 h-5" />
                                        </span>
                                        <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $card['title'] ?? '' }}</h3>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $card['desc'] ?? '' }}</p>
                                    </div>
                                    @if(!empty($card['link']))
                                        <div class="pt-4 mt-3 border-t border-slate-100 dark:border-slate-800">
                                            <a href="{{ $card['link'] }}" class="text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                                {{ $card['link_text'] ?? 'Learn More' }} &rarr;
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if ($sContent['show_cta'] ?? true)
                        <div class="text-center mt-10">
                            <a href="{{ $sContent['cta_url'] ?? '/services' }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 shadow-md transition-all">
                                <span>{{ $sContent['cta_label'] ?? 'View All Items' }}</span>
                                <x-icon name="solid:arrow-right" class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    @endif

                {{-- ==================== COMPONENT TYPE 2: PROMOTIONAL BANNER ==================== --}}
                @elseif ($sType === 'banner')
                    @php
                        $layoutVar = $sContent['layout_variant'] ?? 'split_right';
                    @endphp
                    <div class="p-8 sm:p-12 rounded-3xl bg-slate-100 dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 shadow-xl">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                            @if ($layoutVar === 'split_left' && !empty($sContent['image_url'] ?? $sContent['image'] ?? ''))
                                <div class="lg:col-span-5 rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700">
                                    <img src="{{ $sContent['image_url'] ?? $sContent['image'] }}" class="w-full h-80 object-cover" alt="Banner visual">
                                </div>
                            @endif

                            <div class="{{ in_array($layoutVar, ['split_left', 'split_right']) ? 'lg:col-span-7' : 'lg:col-span-12 text-center max-w-3xl mx-auto' }} space-y-5">
                                @if(!empty($sContent['eyebrow']))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                        {{ $sContent['eyebrow'] }}
                                    </span>
                                @endif
                                <h3 class="text-2xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white leading-tight">
                                    {{ $sContent['headline'] ?? 'Authorized Turbocharger Dynamic Balancing Facility' }}
                                </h3>
                                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                                    {{ $sContent['description'] ?? 'Precision computerized balancing up to 100,000 RPM with complete ISO 1940 vibration certification.' }}
                                </p>

                                @if(!empty($sContent['bullet_points']))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2">
                                        @foreach($sContent['bullet_points'] as $bp)
                                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500 shrink-0" />
                                                <span>{{ $bp }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex flex-wrap items-center gap-3 pt-3 {{ in_array($layoutVar, ['fullwidth', 'boxed']) ? 'justify-center' : '' }}">
                                    @if(!empty($sContent['btn1_text']))
                                        <a href="{{ $sContent['btn1_url'] ?? '#' }}" class="px-6 py-3 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:text-slate-950 shadow-md transition-all">
                                            {{ $sContent['btn1_text'] }}
                                        </a>
                                    @endif
                                    @if(!empty($sContent['btn2_text']))
                                        <a href="{{ $sContent['btn2_url'] ?? '#' }}" class="px-6 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition-all">
                                            {{ $sContent['btn2_text'] }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if ($layoutVar === 'split_right' && !empty($sContent['image_url'] ?? $sContent['image'] ?? ''))
                                <div class="lg:col-span-5 rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700">
                                    <img src="{{ $sContent['image_url'] ?? $sContent['image'] }}" class="w-full h-80 object-cover" alt="Banner visual">
                                </div>
                            @endif
                        </div>
                    </div>

                {{-- ==================== COMPONENT TYPE 3: PERFORMANCE STATS ==================== --}}
                @elseif ($sType === 'stats')
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($sContent['items'] ?? [] as $st)
                            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-center space-y-2 shadow-xs">
                                <span class="text-3xl sm:text-4xl font-black font-mono text-[#003C58] dark:text-cyan-400 block">
                                    {{ $st['number'] ?? '100+' }}
                                </span>
                                <strong class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                    {{ $st['label'] ?? '' }}
                                </strong>
                                @if(!empty($st['detail']))
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 block">{{ $st['detail'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                {{-- ==================== COMPONENT TYPE 4: FAQ ACCORDION ==================== --}}
                @elseif ($sType === 'faq')
                    <div class="max-w-3xl mx-auto space-y-3" x-data="{ active: null }">
                        @foreach ($sContent['items'] ?? [] as $fIdx => $faq)
                            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-2xs">
                                <button type="button" @click="active = (active === {{ $fIdx }} ? null : {{ $fIdx }})"
                                        class="w-full p-4 sm:p-5 text-left font-bold text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4 cursor-pointer">
                                    <span>{{ $faq['q'] ?? '' }}</span>
                                    <x-icon name="solid:chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                            ::class="active === {{ $fIdx }} ? 'rotate-180 text-cyan-500' : ''" />
                                </button>
                                <div x-show="active === {{ $fIdx }}" x-cloak class="px-5 pb-5 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800/60 pt-3">
                                    {{ $faq['a'] ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                {{-- ==================== COMPONENT TYPE 5: INTERACTIVE RFQ FORM ==================== --}}
                @elseif ($sType === 'form')
                    <div id="inquiry" class="max-w-3xl mx-auto rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-10 shadow-xl">
                        @if (class_exists(\App\Livewire\Frontend\RfqLeadForm::class))
                            <livewire:frontend.rfq-lead-form />
                        @endif
                    </div>

                {{-- ==================== COMPONENT TYPE 6: TESTIMONIALS ==================== --}}
                @elseif ($sType === 'testimonials')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($sContent['items'] ?? [] as $tst)
                            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col justify-between space-y-4 shadow-xs">
                                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 italic leading-relaxed">
                                    &ldquo;{{ $tst['quote'] ?? '' }}&rdquo;
                                </p>
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <strong class="block text-xs font-bold text-slate-900 dark:text-white">{{ $tst['client'] ?? '' }}</strong>
                                    <span class="text-[11px] text-slate-500">{{ $tst['company'] ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                {{-- ==================== COMPONENT TYPE 7: STEP LIST ==================== --}}
                @elseif ($sType === 'list')
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @foreach ($sContent['items'] ?? [] as $li)
                            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                                <span class="text-xs font-mono font-black text-cyan-600 dark:text-cyan-400 uppercase">Step {{ $li['step'] ?? '' }}</span>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">{{ $li['title'] ?? '' }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $li['desc'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>

                {{-- ==================== COMPONENT TYPE 8: RAW HTML ==================== --}}
                @elseif ($sType === 'custom_html')
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $sContent['html'] ?? '' !!}
                    </div>

                {{-- ==================== COMPONENT TYPE 9: EDITORIAL TEXT ==================== --}}
                @else
                    <div class="max-w-3xl mx-auto space-y-4 text-center">
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $sContent['title'] ?? $sec->title }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $sContent['desc'] ?? '' }}</p>
                    </div>
                @endif

            </div>
        </section>
    @endforeach

</x-layouts.frontend>
