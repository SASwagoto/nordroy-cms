@php
    $partnersEnabled = (bool) \App\Models\Setting::get('home_partners_enabled', true);
    if (!$partnersEnabled) return;

    $partnersTagline = \App\Models\Setting::get('home_partners_tagline', 'Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms');
    $partnersMode = \App\Models\Setting::get('home_partners_mode', 'static');
    $partnersSpeed = \App\Models\Setting::get('home_partners_speed', 'normal');

    $speedClass = match($partnersSpeed) {
        'slow' => 'style="animation-duration: 48s;"',
        'fast' => 'style="animation-duration: 18s;"',
        default => 'style="animation-duration: 32s;"',
    };

    // Determine brands
    $brands = [];
    if ($partnersMode === 'dynamic') {
        try {
            $brands = \App\Models\Brand::where('is_active', true)->pluck('name')->toArray();
        } catch (\Throwable $e) {
            $brands = [];
        }
    }
    if (empty($brands)) {
        $storedList = \App\Models\Setting::get('home_partners_brands_list');
        if ($storedList) {
            $brands = array_filter(array_map('trim', explode(',', $storedList)));
        }
    }
    if (empty($brands)) {
        $brands = [
            'Accelleron (ABB)',
            'MAN Energy Solutions',
            'KBB Kompressorenbau',
            'Napier Turbochargers',
            'Mitsubishi Heavy Industries (MET)',
            'PBS Turbo',
            'INNIO Waukesha',
            'Ariel Compressors',
        ];
    }
@endphp

<!-- =====================================================================
     OEM MULTI-BRAND PARTNER TICKER (Turbo Internacional Style)
     ===================================================================== -->
<x-section-styler-wrap sectionKey="partners" id="partners">
    <div class="mb-4 text-center">
        <span class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
            {{ __($partnersTagline) }}
        </span>
    </div>
    
    <div class="relative overflow-hidden py-3">
        <div class="flex items-center space-x-12 animate-infinite-scroll whitespace-nowrap" {!! $speedClass !!}>
            @foreach(array_merge($brands, $brands) as $b)
                <div class="flex items-center space-x-2 font-mono font-bold text-xs uppercase tracking-wider text-slate-700 dark:text-slate-300 px-4 py-2 rounded-xl bg-slate-200/50 dark:bg-slate-800/50 border border-slate-300/60 dark:border-slate-700/60 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-[#003C58] dark:bg-cyan-400 inline-block"></span>
                    <span>{{ $b }}</span>
                </div>
            @endforeach
        </div>
    </div>
</x-section-styler-wrap>