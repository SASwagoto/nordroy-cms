@php
    $metricsEnabled = (bool) \App\Models\Setting::get('home_metrics_enabled', true);
    if (!$metricsEnabled) return;

    $metric1Val = \App\Models\Setting::get('home_metrics_stat1_val', '30+');
    $metric1Lbl = \App\Models\Setting::get('home_metrics_stat1_lbl', 'Years of Excellence');

    $metric2Val = \App\Models\Setting::get('home_metrics_stat2_val', '1,450+');
    $metric2Lbl = \App\Models\Setting::get('home_metrics_stat2_lbl', 'Turbomachines Overhauled');

    $metric3Val = \App\Models\Setting::get('home_metrics_stat3_val', '12+');
    $metric3Lbl = \App\Models\Setting::get('home_metrics_stat3_lbl', 'Global Ports Covered');

    $metric4Val = \App\Models\Setting::get('home_metrics_stat4_val', '100%');
    $metric4Lbl = \App\Models\Setting::get('home_metrics_stat4_lbl', 'Calibrated Schenck Testing');
@endphp

<!-- =====================================================================
     PROVEN PERFORMANCE METRICS
     ===================================================================== -->
<section id="metrics" class="reveal-init reveal-fade-up py-16 bg-slate-100 dark:bg-[#0b1b2b] border-b border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            
            <div class="reveal-init reveal-fade-up reveal-delay-100">
                <span class="block text-4xl sm:text-5xl font-black font-heading text-[#003C58] dark:text-cyan-400">{{ __($metric1Val) }}</span>
                <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">{{ __($metric1Lbl) }}</span>
            </div>

            <div class="reveal-init reveal-fade-up reveal-delay-200">
                <span class="block text-4xl sm:text-5xl font-black font-heading text-slate-900 dark:text-white">{{ __($metric2Val) }}</span>
                <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">{{ __($metric2Lbl) }}</span>
            </div>

            <div class="reveal-init reveal-fade-up reveal-delay-300">
                <span class="block text-4xl sm:text-5xl font-black font-heading text-[#003C58] dark:text-cyan-400">{{ __($metric3Val) }}</span>
                <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">{{ __($metric3Lbl) }}</span>
            </div>

            <div class="reveal-init reveal-fade-up reveal-delay-400">
                <span class="block text-4xl sm:text-5xl font-black font-heading text-emerald-600 dark:text-emerald-400">{{ __($metric4Val) }}</span>
                <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">{{ __($metric4Lbl) }}</span>
            </div>

        </div>
    </div>
</section>
