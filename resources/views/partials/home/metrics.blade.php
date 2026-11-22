@php
    $metricsEnabled = (bool) \App\Models\Setting::get('home_metrics_enabled', true);
    if (!$metricsEnabled) return;

    $metricsItems = \App\Models\Setting::getJson('home_metrics_items', []);
    if (empty($metricsItems)) {
        $metricsItems = [
            ['value' => \App\Models\Setting::get('home_metrics_stat1_val', '30+'), 'label' => \App\Models\Setting::get('home_metrics_stat1_lbl', 'Years of Excellence'), 'color' => '#003C58'],
            ['value' => \App\Models\Setting::get('home_metrics_stat2_val', '1,450+'), 'label' => \App\Models\Setting::get('home_metrics_stat2_lbl', 'Turbomachines Overhauled'), 'color' => '#0f172a'],
            ['value' => \App\Models\Setting::get('home_metrics_stat3_val', '12+'), 'label' => \App\Models\Setting::get('home_metrics_stat3_lbl', 'Global Ports Covered'), 'color' => '#003C58'],
            ['value' => \App\Models\Setting::get('home_metrics_stat4_val', '100%'), 'label' => \App\Models\Setting::get('home_metrics_stat4_lbl', 'Calibrated Schenck Testing'), 'color' => '#059669'],
        ];
    }
@endphp

<!-- =====================================================================
     PROVEN PERFORMANCE METRICS
     ===================================================================== -->
<x-section-styler-wrap sectionKey="metrics" id="metrics">
    <div class="grid grid-cols-2 lg:grid-cols-{{ count($metricsItems) > 4 ? 4 : (count($metricsItems) ?: 4) }} gap-8 text-center">
        @foreach($metricsItems as $idx => $item)
            <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx + 1) * 100 }}">
                <span class="block text-4xl sm:text-5xl font-black font-heading text-[#003C58] dark:text-cyan-400" @if(!empty($item['color'])) style="color: {{ $item['color'] }};" @endif>
                    {{ __($item['value'] ?? '') }}
                </span>
                <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">
                    {{ __($item['label'] ?? '') }}
                </span>
            </div>
        @endforeach
    </div>
</x-section-styler-wrap>