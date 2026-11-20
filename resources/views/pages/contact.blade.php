<x-layouts.frontend :title="\App\Models\Setting::get('contact_hero_title', 'Contact & 24/7 Port Duty Desk')">
    
    <!-- Hero Header (Transparent so background video is visible behind the title) -->
    <div class="py-16 sm:py-24 bg-transparent border-b border-slate-200/80 dark:border-slate-800 transition-colors">
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
    <section id="rfq" class="py-20 bg-slate-50 dark:bg-[#06121d]">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Left: Offices & Hotlines (5 cols) -->
                <div class="lg:col-span-5 space-y-6">
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
                        @if($emergencyNote = \App\Models\Setting::get('contact_emergency_note'))
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-[11px] text-amber-600 dark:text-amber-400 font-semibold">
                                &bull; {{ $emergencyNote }}
                            </div>
                        @endif
                    </div>
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
        </div>
    </section>

</x-layouts.frontend>
