<x-layouts.frontend :title="\App\Models\Setting::get('contact_hero_title', 'Contact & 24/7 Port Duty Desk')">
    
    @php
        $bgStyle = \App\Models\Setting::get('contact_header_bg', 'transparent');
        $frostedOpacity = max(10, min(90, (int) \App\Models\Setting::get('contact_header_frosted_opacity', 80)));
        $opacityDecimal = $frostedOpacity / 100;

        $customLightBg = \App\Models\Setting::get('contact_header_light_bg', '#ffffff');
        $customDarkBg = \App\Models\Setting::get('contact_header_dark_bg', '#07131e');
        $customLightText = \App\Models\Setting::get('contact_header_light_text', '#0f172a');
        $customDarkText = \App\Models\Setting::get('contact_header_dark_text', '#f8fafc');

        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'header-frosted-contact backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            'custom'   => 'header-custom-contact',
            default    => 'bg-transparent',
        };

        // Load Dynamic Facilities (Fallback to legacy keys if array not populated yet)
        $rawFacilities = \App\Models\Setting::getJson('contact_facilities_list', [
            [
                'id'        => 'facility_port',
                'badge'     => \App\Models\Setting::get('contact_port_badge', 'Primary Workshop Facility'),
                'title'     => \App\Models\Setting::get('contact_port_title', 'Chattogram Port Workshop'),
                'address'   => \App\Models\Setting::get('contact_port_address', 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.'),
                'desc'      => \App\Models\Setting::get('contact_port_desc', 'Equipped with heavy overhead gantry cranes, Schenck dynamic balancing benches, and ultrasonic clean bays.'),
                'phone'     => \App\Models\Setting::get('contact_port_phone', '+880 1800-000000'),
                'email'     => \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com'),
                'emergency' => '',
                'is_active' => (bool) \App\Models\Setting::get('contact_show_port_facility', true),
            ],
            [
                'id'        => 'facility_hq',
                'badge'     => \App\Models\Setting::get('contact_hq_badge', 'Corporate Headquarters'),
                'title'     => \App\Models\Setting::get('contact_hq_title', 'Dhaka Corporate HQ'),
                'address'   => \App\Models\Setting::get('contact_hq_address', 'Gulshan Industrial Area, Dhaka, Bangladesh.'),
                'desc'      => '',
                'phone'     => \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000'),
                'email'     => \App\Models\Setting::get('contact_hq_email', 'operations@nordroy.com'),
                'emergency' => \App\Models\Setting::get('contact_emergency_note', '24/7 Port Helpline & Deep Anchorage Flying Squad Available Worldwide.'),
                'is_active' => (bool) \App\Models\Setting::get('contact_show_hq_facility', true),
            ],
        ]);

        $activeFacilities = collect($rawFacilities)->filter(function($fac) {
            return !empty($fac['is_active']) && $fac['is_active'] !== '0' && $fac['is_active'] !== false;
        })->values();

        $facilityCount = $activeFacilities->count();
        $showEmergency = (bool) \App\Models\Setting::get('contact_show_emergency', true);
        $showRFQ = (bool) \App\Models\Setting::get('contact_show_rfq_form', true);
    @endphp

    @if($bgStyle === 'frosted')
        <style>
            .header-frosted-contact { background-color: rgba(255, 255, 255, {{ $opacityDecimal }}); }
            .dark .header-frosted-contact { background-color: rgba(7, 19, 30, {{ $opacityDecimal }}); }
        </style>
    @elseif($bgStyle === 'custom')
        <style>
            .header-custom-contact { background-color: {{ $customLightBg }}; color: {{ $customLightText }}; }
            .header-custom-contact h1, .header-custom-contact p { color: {{ $customLightText }}; }
            .dark .header-custom-contact { background-color: {{ $customDarkBg }}; color: {{ $customDarkText }}; }
            .dark .header-custom-contact h1, .dark .header-custom-contact p { color: {{ $customDarkText }}; }
        </style>
    @endif

    <!-- Hero Header -->
    <div class="py-16 sm:py-24 {{ $headerBgClasses }} border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 shadow-2xs">
                {{ \App\Models\Setting::get('contact_badge', 'Port Response & Headquarters') }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-slate-900 dark:text-white mt-4 leading-tight drop-shadow-xs">
                {{ \App\Models\Setting::get('contact_hero_title', 'Contact & 24/7 Marine Duty Desk.') }}
            </h1>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl mt-4 leading-relaxed font-medium">
                {{ \App\Models\Setting::get('contact_hero_subtitle', 'Connect directly with our port superintendent engineers for immediate vessel assistance, dynamic balancing bookings, and genuine spare parts quotes.') }}
            </p>
        </div>
    </div>

    <!-- Contact & RFQ Grid (Adaptive Gapless Layout) -->
    @if($facilityCount > 0 || $showRFQ)
        <section id="rfq" class="py-20 bg-slate-50 dark:bg-[#06121d]">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
                
                @if($facilityCount > 0 && $showRFQ)
                    <!-- Standard 2-Column Split: Facilities on Left (5 cols), RFQ on Right (7 cols) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                        
                        <!-- Left: Facilities List (Supports any number of offices!) -->
                        <div class="lg:col-span-5 space-y-6">
                            @foreach($activeFacilities as $fac)
                                <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                    @if(!empty($fac['badge']))
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                            {{ $fac['badge'] }}
                                        </span>
                                    @endif
                                    <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ $fac['title'] }}
                                    </h3>
                                    @if(!empty($fac['address']) || !empty($fac['desc']))
                                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                            @if(!empty($fac['address']))
                                                {{ $fac['address'] }}<br>
                                            @endif
                                            @if(!empty($fac['desc']))
                                                {{ $fac['desc'] }}
                                            @endif
                                        </p>
                                    @endif
                                    @if(!empty($fac['phone']) || !empty($fac['email']))
                                        <div class="pt-2 text-xs space-y-2 font-mono">
                                            @if(!empty($fac['phone']))
                                                <div class="text-[#003C58] dark:text-cyan-400 font-bold">
                                                    Duty Superintendent: <a href="tel:{{ $fac['phone'] }}" class="hover:underline">{{ $fac['phone'] }}</a>
                                                </div>
                                            @endif
                                            @if(!empty($fac['email']))
                                                <div class="text-slate-500">
                                                    Email: <a href="mailto:{{ $fac['email'] }}" class="hover:underline">{{ $fac['email'] }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if($showEmergency && !empty($fac['emergency']))
                                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] text-amber-600 dark:text-amber-400 font-semibold">
                                            &bull; {{ $fac['emergency'] }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Right: RFQ Form (7 cols) -->
                        <div class="lg:col-span-7">
                            <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">Instant Inquiry</span>
                                    <h3 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Request Quotation / Port Squad</h3>
                                </div>

                                <livewire:frontend.rfq-lead-form />
                            </div>
                        </div>

                    </div>

                @elseif($facilityCount > 0 && !$showRFQ)
                    <!-- Gapless Adaptive Layout: Facilities Only (Centered, No Blank Right Column!) -->
                    @php
                        $colsClass = match(true) {
                            $facilityCount === 1 => 'max-w-2xl mx-auto grid-cols-1',
                            $facilityCount === 2 => 'max-w-5xl mx-auto grid-cols-1 md:grid-cols-2',
                            default              => 'max-w-6xl mx-auto grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
                        };
                    @endphp

                    <div class="grid {{ $colsClass }} gap-8">
                        @foreach($activeFacilities as $fac)
                            <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                @if(!empty($fac['badge']))
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                        {{ $fac['badge'] }}
                                    </span>
                                @endif
                                <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                    {{ $fac['title'] }}
                                </h3>
                                @if(!empty($fac['address']) || !empty($fac['desc']))
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                        @if(!empty($fac['address']))
                                            {{ $fac['address'] }}<br>
                                        @endif
                                        @if(!empty($fac['desc']))
                                            {{ $fac['desc'] }}
                                        @endif
                                    </p>
                                @endif
                                @if(!empty($fac['phone']) || !empty($fac['email']))
                                    <div class="pt-2 text-xs space-y-2 font-mono">
                                        @if(!empty($fac['phone']))
                                            <div class="text-[#003C58] dark:text-cyan-400 font-bold">
                                                Duty Superintendent: <a href="tel:{{ $fac['phone'] }}" class="hover:underline">{{ $fac['phone'] }}</a>
                                            </div>
                                        @endif
                                        @if(!empty($fac['email']))
                                            <div class="text-slate-500">
                                                Email: <a href="mailto:{{ $fac['email'] }}" class="hover:underline">{{ $fac['email'] }}</a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if($showEmergency && !empty($fac['emergency']))
                                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] text-amber-600 dark:text-amber-400 font-semibold">
                                        &bull; {{ $fac['emergency'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                @else
                    <!-- Gapless Adaptive Layout: RFQ Lead Form Only (Centered, No Blank Left Column!) -->
                    <div class="max-w-3xl mx-auto">
                        <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                            <div class="text-center">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">Instant Inquiry</span>
                                <h3 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white mt-1">Request Quotation / Port Squad</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Submit your turbocharger inquiry or flying squad dispatch request directly.</p>
                            </div>

                            <livewire:frontend.rfq-lead-form />
                        </div>
                    </div>
                @endif

            </div>
        </section>
    @endif

</x-layouts.frontend>
