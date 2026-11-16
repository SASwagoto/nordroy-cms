<x-layouts.frontend title="{{ $service->display_title }} | Marine Services | Nordroy Marine">

    <!-- Hero Header -->
    <section class="pt-24 pb-8 sm:pt-28 sm:pb-12 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-4">
            
            <!-- Breadcrumbs Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors shrink-0">Home</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('services') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors shrink-0">Services</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-800 dark:text-slate-200 truncate font-bold">{{ $service->display_title }}</span>
            </nav>

            <!-- Badges & Title -->
            <div class="space-y-3 pt-2">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20">
                        Marine Engineering Service
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                        ISO 9001:2015 &amp; DNV Certified
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800">
                        24/7 Port Call Mobilization
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center shrink-0">
                        <x-icon :name="$service->icon ?: 'solid:wrench'" class="w-6 h-6" />
                    </div>
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
                        {{ $service->display_title }}
                    </h1>
                </div>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-4xl leading-relaxed">
                    {{ $service->display_summary }}
                </p>
            </div>

        </div>
    </section>

    <!-- Main Content Section: Left 8 cols scope / Right 4 cols Lead Card -->
    <section class="py-12 sm:py-16 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left Column (8 cols): Detailed Engineering Procedure -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Featured Image / Workshop Visual -->
                    @if($service->featuredImage)
                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-lg aspect-16/9 w-full bg-black">
                            <img src="{{ $service->featuredImage->url }}" alt="{{ $service->display_title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Detailed Technical Scope -->
                    <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Engineering Scope</span>
                            <h2 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white mt-1">
                                Technical Overview &amp; Execution Protocols
                            </h2>
                        </div>

                        <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed space-y-4">
                            <p>{{ $service->display_content ?: $service->display_summary }}</p>
                        </div>
                    </div>

                    <!-- 5-Phase Step-by-Step Procedure -->
                    <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Workflow Standard</span>
                            <h2 class="text-xl sm:text-2xl font-bold font-heading text-slate-900 dark:text-white mt-1">
                                Class-Certified 5-Phase Overhaul Methodology
                            </h2>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                <span class="w-8 h-8 rounded-xl bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs flex items-center justify-center shrink-0">01</span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Emergency Disassembly &amp; Diagnostic Inspection</h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Heavy rigging extraction inside ship engine room, dimensional run-out checks with dial indicators, and logging initial vibration profile.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                <span class="w-8 h-8 rounded-xl bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs flex items-center justify-center shrink-0">02</span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Ultrasonic Chemical De-Carbonization</h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Complete immersion in heated alkaline ultrasonic chemical tanks to dissolve stubborn heavy fuel oil carbon deposits without abrasive mechanical damage.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                <span class="w-8 h-8 rounded-xl bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs flex items-center justify-center shrink-0">03</span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">NDT Fluorescent Penetrant Crack Detection</h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">High-sensitivity FPI under ultraviolet light inspecting turbine blade roots, shaft transitions, and nozzle ring vanes to eliminate fatigue cracks.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                <span class="w-8 h-8 rounded-xl bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs flex items-center justify-center shrink-0">04</span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">High-Speed Computerized Dynamic Balancing</h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Dual-plane phase balancing on Schenck balancing bench conforming to ISO 1940-1 Grade G1.0 tolerance down to 0.42 mm/s residual vibration.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                                <span class="w-8 h-8 rounded-xl bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs flex items-center justify-center shrink-0">05</span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Cartridge Assembly &amp; Sea-Trial Load Sign-Off</h4>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Installation with new genuine OEM bearing kits, hydrodynamic oil pressure verification, and onboard sea-trial load testing with marine surveyor sign-off.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column (4 cols): Lead Form & Quick Hotline -->
                <div class="lg:col-span-4 space-y-6 sticky top-28">
                    
                    <!-- Instant RFQ Card -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Direct Inquiries</span>
                            <h3 class="text-lg font-black font-heading text-slate-900 dark:text-white mt-0.5">
                                Request Overhaul RFQ
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Service: <strong>{{ $service->display_title }}</strong>
                            </p>
                        </div>

                        <!-- Embedded Lead Form -->
                        <livewire:frontend.rfq-lead-form :service="$service->display_title" />
                    </div>

                    <!-- 24/7 Duty Desk Card -->
                    <div class="p-6 rounded-3xl bg-[#003C58] dark:bg-[#040e17] text-white space-y-4 shadow-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center shrink-0">
                                <x-icon name="solid:phone-volume" class="w-5 h-5" />
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-400 block">Port Emergency Flying Squad</span>
                                <h4 class="text-sm font-bold">Immediate Port Attendance</h4>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Duty Marine Superintendents are on standby 24 hours a day for emergency boarding at Chittagong Port, Mongla, and outer anchorage lightering points.
                        </p>
                        <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+8801819318488') }}" 
                           class="block text-center py-2.5 px-4 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition-colors shadow-sm">
                            Call Hotline: {{ \App\Models\Setting::get('contact_phone', '+880 1819-318488') }}
                        </a>
                    </div>

                </div>

            </div>

            <!-- Related Overhaul Services -->
            @if($relatedServices->count() > 0)
                <div class="mt-20 pt-12 border-t border-slate-200 dark:border-slate-800 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Comprehensive Solutions</span>
                            <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-900 dark:text-white">Other Marine Services</h2>
                        </div>
                        <a href="{{ route('services') }}" class="text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                            View All Services &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($relatedServices as $rel)
                            <a href="{{ route('service.details', $rel->slug) }}" 
                               class="rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 p-5 space-y-3 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all shadow-xs block group">
                                <div class="w-10 h-10 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <x-icon :name="$rel->icon ?: 'solid:wrench'" class="w-5 h-5" />
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-cyan-500 transition-colors line-clamp-1">
                                    {{ $rel->display_title }}
                                </h4>
                                <p class="text-[11px] text-slate-500 line-clamp-2">
                                    {{ $rel->display_summary }}
                                </p>
                                <span class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 inline-flex items-center gap-1">
                                    <span>Learn more</span>
                                    <x-icon name="solid:arrow-right" class="w-2.5 h-2.5" />
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

</x-layouts.frontend>
