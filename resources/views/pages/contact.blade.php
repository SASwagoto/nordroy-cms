<x-layouts.frontend :title="\App\Models\Setting::get('contact_hero_title', 'Contact & 24/7 Port Duty Desk')">
    
    @php
        $bgStyle = \App\Models\Setting::get('contact_header_bg', 'transparent');
        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'bg-white/80 dark:bg-[#07131e]/80 backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            default    => 'bg-transparent',
        };

        $showPort = (bool) \App\Models\Setting::get('contact_show_port_facility', true);
        $showHQ = (bool) \App\Models\Setting::get('contact_show_hq_facility', true);
        $showEmergency = (bool) \App\Models\Setting::get('contact_show_emergency', true);
        $showRFQ = (bool) \App\Models\Setting::get('contact_show_rfq_form', true);
        $hasOffices = ($showPort || $showHQ);
    @endphp

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

    <!-- Contact & RFQ Grid -->
    @if($hasOffices || $showRFQ)
        <section id="rfq" class="py-20 bg-slate-50 dark:bg-[#06121d]">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
                
                @if($hasOffices && $showRFQ)
                    <!-- Standard 2-Column Split: Offices on Left (5 cols), RFQ on Right (7 cols) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                        
                        <!-- Left: Offices & Hotlines -->
                        <div class="lg:col-span-5 space-y-6">
                            @if($showPort)
                                <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                        {{ \App\Models\Setting::get('contact_port_badge', 'Primary Workshop Facility') }}
                                    </span>
                                    <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ \App\Models\Setting::get('contact_port_title', 'Chattogram Port Workshop') }}
                                    </h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ \App\Models\Setting::get('contact_port_address', 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.') }}<br>
                                        {{ \App\Models\Setting::get('contact_port_desc', 'Equipped with heavy overhead gantry cranes, Schenck dynamic balancing benches, and ultrasonic clean bays.') }}
                                    </p>
                                    <div class="pt-2 text-xs space-y-2 font-mono">
                                        <div class="text-[#003C58] dark:text-cyan-400 font-bold">
                                            Duty Superintendent: <a href="tel:{{ \App\Models\Setting::get('contact_port_phone', '+880 1800-000000') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_port_phone', '+880 1800-000000') }}</a>
                                        </div>
                                        <div class="text-slate-500">
                                            Email: <a href="mailto:{{ \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($showHQ)
                                <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                    <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                        {{ \App\Models\Setting::get('contact_hq_badge', 'Corporate Headquarters') }}
                                    </span>
                                    <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                        {{ \App\Models\Setting::get('contact_hq_title', 'Dhaka Corporate HQ') }}
                                    </h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ \App\Models\Setting::get('contact_hq_address', \App\Models\Setting::get('company_address', 'Gulshan Industrial Area, Dhaka, Bangladesh.')) }}
                                    </p>
                                    <div class="pt-2 text-xs space-y-2 font-mono">
                                        <div class="text-slate-700 dark:text-slate-300">
                                            Desk: <a href="tel:{{ \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000') }}</a>
                                        </div>
                                        <div class="text-slate-500">
                                            Email: <a href="mailto:{{ \App\Models\Setting::get('contact_hq_email', \App\Models\Setting::get('contact_email', 'operations@nordroy.com')) }}" class="hover:underline">{{ \App\Models\Setting::get('contact_hq_email', \App\Models\Setting::get('contact_email', 'operations@nordroy.com')) }}</a>
                                        </div>
                                    </div>
                                    @if($showEmergency && ($emergencyNote = \App\Models\Setting::get('contact_emergency_note')))
                                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] text-amber-600 dark:text-amber-400 font-semibold">
                                            &bull; {{ $emergencyNote }}
                                        </div>
                                    @endif
                                </div>
                            @endif
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

                @elseif($hasOffices && !$showRFQ)
                    <!-- Gapless Adaptive Layout: Offices Only (Centered, No Blank Right Column!) -->
                    @if($showPort && $showHQ)
                        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Port Card -->
                            <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                    {{ \App\Models\Setting::get('contact_port_badge', 'Primary Workshop Facility') }}
                                </span>
                                <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                    {{ \App\Models\Setting::get('contact_port_title', 'Chattogram Port Workshop') }}
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                    {{ \App\Models\Setting::get('contact_port_address', 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.') }}<br>
                                    {{ \App\Models\Setting::get('contact_port_desc', 'Equipped with heavy overhead gantry cranes, Schenck dynamic balancing benches, and ultrasonic clean bays.') }}
                                </p>
                                <div class="pt-2 text-xs space-y-2 font-mono">
                                    <div class="text-[#003C58] dark:text-cyan-400 font-bold">
                                        Duty Superintendent: <a href="tel:{{ \App\Models\Setting::get('contact_port_phone', '+880 1800-000000') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_port_phone', '+880 1800-000000') }}</a>
                                    </div>
                                    <div class="text-slate-500">
                                        Email: <a href="mailto:{{ \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com') }}</a>
                                    </div>
                                </div>
                            </div>

                            <!-- HQ Card -->
                            <div class="p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                    {{ \App\Models\Setting::get('contact_hq_badge', 'Corporate Headquarters') }}
                                </span>
                                <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                    {{ \App\Models\Setting::get('contact_hq_title', 'Dhaka Corporate HQ') }}
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                    {{ \App\Models\Setting::get('contact_hq_address', \App\Models\Setting::get('company_address', 'Gulshan Industrial Area, Dhaka, Bangladesh.')) }}
                                </p>
                                <div class="pt-2 text-xs space-y-2 font-mono">
                                    <div class="text-slate-700 dark:text-slate-300">
                                        Desk: <a href="tel:{{ \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000') }}</a>
                                    </div>
                                    <div class="text-slate-500">
                                        Email: <a href="mailto:{{ \App\Models\Setting::get('contact_hq_email', \App\Models\Setting::get('contact_email', 'operations@nordroy.com')) }}" class="hover:underline">{{ \App\Models\Setting::get('contact_hq_email', \App\Models\Setting::get('contact_email', 'operations@nordroy.com')) }}</a>
                                    </div>
                                </div>
                                @if($showEmergency && ($emergencyNote = \App\Models\Setting::get('contact_emergency_note')))
                                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] text-amber-600 dark:text-amber-400 font-semibold">
                                        &bull; {{ $emergencyNote }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif($showPort)
                        <div class="max-w-2xl mx-auto p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                            <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                {{ \App\Models\Setting::get('contact_port_badge', 'Primary Workshop Facility') }}
                            </span>
                            <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('contact_port_title', 'Chattogram Port Workshop') }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ \App\Models\Setting::get('contact_port_address', 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.') }}<br>
                                {{ \App\Models\Setting::get('contact_port_desc', 'Equipped with heavy overhead gantry cranes, Schenck dynamic balancing benches, and ultrasonic clean bays.') }}
                            </p>
                            <div class="pt-2 text-xs space-y-2 font-mono">
                                <div class="text-[#003C58] dark:text-cyan-400 font-bold">
                                    Duty Superintendent: <a href="tel:{{ \App\Models\Setting::get('contact_port_phone', '+880 1800-000000') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_port_phone', '+880 1800-000000') }}</a>
                                </div>
                                <div class="text-slate-500">
                                    Email: <a href="mailto:{{ \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_port_email', 'port.ops@nordroy.com') }}</a>
                                </div>
                            </div>
                        </div>
                    @elseif($showHQ)
                        <div class="max-w-2xl mx-auto p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                            <span class="text-xs font-bold uppercase tracking-widest text-[#003C58] dark:text-cyan-400">
                                {{ \App\Models\Setting::get('contact_hq_badge', 'Corporate Headquarters') }}
                            </span>
                            <h3 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                {{ \App\Models\Setting::get('contact_hq_title', 'Dhaka Corporate HQ') }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ \App\Models\Setting::get('contact_hq_address', \App\Models\Setting::get('company_address', 'Gulshan Industrial Area, Dhaka, Bangladesh.')) }}
                            </p>
                            <div class="pt-2 text-xs space-y-2 font-mono">
                                <div class="text-slate-700 dark:text-slate-300">
                                    Desk: <a href="tel:{{ \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000') }}" class="hover:underline">{{ \App\Models\Setting::get('contact_hq_phone', '+880 1700-000000') }}</a>
                                </div>
                                <div class="text-slate-500">
                                    Email: <a href="mailto:{{ \App\Models\Setting::get('contact_hq_email', \App\Models\Setting::get('contact_email', 'operations@nordroy.com')) }}" class="hover:underline">{{ \App\Models\Setting::get('contact_hq_email', \App\Models\Setting::get('contact_email', 'operations@nordroy.com')) }}</a>
                                </div>
                            </div>
                            @if($showEmergency && ($emergencyNote = \App\Models\Setting::get('contact_emergency_note')))
                                <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] text-amber-600 dark:text-amber-400 font-semibold">
                                    &bull; {{ $emergencyNote }}
                                </div>
                            @endif
                        </div>
                    @endif

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