@php
    $aboutEnabled = (bool) \App\Models\Setting::get('home_about_enabled', true);
    if (!$aboutEnabled) return;

    $aboutBadge = \App\Models\Setting::get('home_about_badge', 'Conglomerate Heritage & Vision');
    $aboutTitle = \App\Models\Setting::get('home_about_title', 'A Heritage of Heavy Industrial Power, Maritime Integrity, & Turn-Key Engineering.');
    $aboutDescription = \App\Models\Setting::get('home_about_description', 'Operating under the high standards of global marine engineering, Nordroy Marine & Turbochargers unites heavy mechanical overhaul workshops, non-destructive metallurgical testing (NDT), dynamic rotor calibration, and comprehensive spare parts logistics under one unified corporate umbrella.');

    // 3 Strategic Pillars
    $aboutP1Icon = \App\Models\Setting::get('home_about_p1_icon', 'solid:anchor');
    $aboutP1Title = \App\Models\Setting::get('home_about_p1_title', 'Global Port Reach');
    $aboutP1Desc = \App\Models\Setting::get('home_about_p1_desc', '24/7 flying squads equipped for anchorage and berth call overhauls.');

    $aboutP2Icon = \App\Models\Setting::get('home_about_p2_icon', 'solid:gauge-high');
    $aboutP2Title = \App\Models\Setting::get('home_about_p2_title', 'Calibrated Precision');
    $aboutP2Desc = \App\Models\Setting::get('home_about_p2_desc', 'Computerized Schenck dynamic balancing up to 100,000 RPM.');

    $aboutP3Icon = \App\Models\Setting::get('home_about_p3_icon', 'solid:certificate');
    $aboutP3Title = \App\Models\Setting::get('home_about_p3_title', 'OEM Alliances');
    $aboutP3Desc = \App\Models\Setting::get('home_about_p3_desc', 'Direct access to genuine replacement parts and calibrated drawings.');

    // Quote Box
    $aboutQuoteText = \App\Models\Setting::get('home_about_quote_text', '"In maritime logistics and heavy power generation, downtime is measured in thousands of dollars per hour. Our mission is to restore engine efficiency with zero deviation from OEM tolerances."');
    $aboutQuoteAuthor = \App\Models\Setting::get('home_about_quote_author', 'Technical Operations');
    $aboutQuoteRole = \App\Models\Setting::get('home_about_quote_role', 'Turbomachinery Overhaul Division');
    $aboutQuoteInitials = \App\Models\Setting::get('home_about_quote_initials', 'NR');
@endphp

<!-- =====================================================================
     CONGLOMERATE OVERVIEW & CORPORATE PILLARS (Dana Group Style)
     ===================================================================== -->
<section id="about" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: Corporate Presentation (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-800">
                    {{ __($aboutBadge) }}
                </div>
                
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white font-heading leading-tight">
                    {{ __($aboutTitle) }}
                </h2>
                
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __($aboutDescription) }}
                </p>

                <!-- 3 Strategic Pillars -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                    <div class="reveal-init reveal-fade-up reveal-delay-100 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-xl bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center text-[#003C58] dark:text-cyan-400 mb-3">
                            <x-icon :name="$aboutP1Icon" class="w-5 h-5" />
                        </div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">{{ __($aboutP1Title) }}</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">{{ __($aboutP1Desc) }}</p>
                    </div>

                    <div class="reveal-init reveal-fade-up reveal-delay-200 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-xl bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center text-[#003C58] dark:text-cyan-400 mb-3">
                            <x-icon :name="$aboutP2Icon" class="w-5 h-5" />
                        </div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">{{ __($aboutP2Title) }}</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">{{ __($aboutP2Desc) }}</p>
                    </div>

                    <div class="reveal-init reveal-fade-up reveal-delay-300 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-xl bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center text-[#003C58] dark:text-cyan-400 mb-3">
                            <x-icon :name="$aboutP3Icon" class="w-5 h-5" />
                        </div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">{{ __($aboutP3Title) }}</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">{{ __($aboutP3Desc) }}</p>
                    </div>
                </div>

            </div>

            <!-- Right: Executive Leadership Quote Box (Dana Group inspired) (5 cols) -->
            <div class="lg:col-span-5 reveal-init reveal-scale reveal-delay-200">
                <div class="p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-lg relative space-y-6">
                    <div class="text-[#003C58] dark:text-cyan-400 opacity-30 text-5xl font-serif leading-none">&ldquo;</div>
                    <blockquote class="text-sm sm:text-base text-slate-700 dark:text-slate-300 italic leading-relaxed">
                        {{ __($aboutQuoteText) }}
                    </blockquote>
                    <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#003C58] text-white flex items-center justify-center font-bold text-sm">
                            {{ $aboutQuoteInitials }}
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">{{ __($aboutQuoteAuthor) }}</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ __($aboutQuoteRole) }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
