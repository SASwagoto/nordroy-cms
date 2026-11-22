@php
    $partnersEnabled = (bool) \App\Models\Setting::get('home_partners_enabled', true);
    if (!$partnersEnabled) return;

    $partnersTagline = \App\Models\Setting::get('home_partners_tagline', 'Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms');
    $partnersMode = \App\Models\Setting::get('home_partners_mode', 'static');
    $partnersSpeed = \App\Models\Setting::get('home_partners_speed', 'normal');
    $partnersBgStyle = \App\Models\Setting::get('home_partners_bg_style', 'theme_default');

    $speedClass = match($partnersSpeed) {
        'slow' => 'style="animation-duration: 48s;"',
        'fast' => 'style="animation-duration: 18s;"',
        default => 'style="animation-duration: 32s;"',
    };

    $bgClass = match($partnersBgStyle) {
        'clean_white' => 'bg-white dark:bg-[#07131e]',
        'transparent' => 'bg-transparent',
        default => 'bg-slate-100 dark:bg-[#06121d]',
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
<section id="partners" class="reveal-init reveal-fade py-8 {{ $bgClass }} border-b border-slate-200 dark:border-slate-800 overflow-hidden text-slate-600 dark:text-slate-400 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-4 text-center">
        <span class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
            {{ __($partnersTagline) }}
        </span>
    </div>
    
    <div class="relative w-full overflow-hidden flex items-center">
        <div class="animate-ticker flex items-center gap-12 sm:gap-20 text-slate-700 dark:text-slate-300 font-heading font-extrabold text-sm sm:text-base tracking-widest uppercase" {!! $speedClass !!}>
            @foreach($brands as $brand)
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default whitespace-nowrap">{{ $brand }}</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
            @endforeach
            <!-- Duplicate for seamless infinite loop -->
            @foreach($brands as $brand)
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default whitespace-nowrap">{{ $brand }}</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
            @endforeach
        </div>
    </div>
</section>
