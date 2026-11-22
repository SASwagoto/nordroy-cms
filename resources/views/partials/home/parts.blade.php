@php
    $partsEnabled = (bool) \App\Models\Setting::get('home_parts_enabled', true);
    if (!$partsEnabled) return;

    $partsBadge = \App\Models\Setting::get('home_parts_badge', 'OEM Replacement Inventory');
    $partsTitle = \App\Models\Setting::get('home_parts_title', 'Genuine Spare Parts Catalog');
    $partsSubtitle = \App\Models\Setting::get('home_parts_subtitle', 'Traceable serial numbers with mill test certificates ready for immediate dispatch.');
    $partsMode = \App\Models\Setting::get('home_parts_mode', 'static');
    $partsLimit = (int) \App\Models\Setting::get('home_parts_limit', 6);

    $align = \App\Models\Setting::get('home_parts_align', 'center');
    $headerAlignClass = match($align) {
        'left' => 'text-left mr-auto ml-0 items-start justify-start',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-center mx-auto items-center justify-center',
    };

    $dynamicParts = collect();
    if ($partsMode === 'dynamic') {
        try {
            $dynamicParts = \App\Models\Product::where('is_active', true)->take($partsLimit)->get();
        } catch (\Throwable $e) {
            $dynamicParts = collect();
        }
    }

    $staticParts = \App\Models\Setting::getJson('home_parts_static_items', []);
    if (empty($staticParts)) {
        $staticParts = [
            ['name' => 'Turbine Blades', 'part_number' => 'Nimonic 80A / 90', 'icon' => 'solid:fan', 'url' => '/products'],
            ['name' => 'Rotor Shafts', 'part_number' => 'Forged Alloy Steel', 'icon' => 'solid:circle-notch', 'url' => '/products'],
            ['name' => 'Nozzle Rings', 'part_number' => 'High-Temp Resistant', 'icon' => 'solid:ring', 'url' => '/products'],
            ['name' => 'Bearing Bushes', 'part_number' => 'Hydrodynamic Squeeze', 'icon' => 'solid:compact-disc', 'url' => '/products'],
            ['name' => 'Impellers', 'part_number' => 'Milled Titanium / Al', 'icon' => 'solid:asterisk', 'url' => '/products'],
            ['name' => 'Seal Kits', 'part_number' => 'Gas & Oil Labyrinth', 'icon' => 'solid:shield', 'url' => '/products'],
        ];
    }
@endphp

<!-- =====================================================================
     GENUINE SPARE PARTS CATALOG (Turbo Internacional Style)
     ===================================================================== -->
<x-section-styler-wrap sectionKey="parts" id="parts">
    
    <div class="max-w-3xl space-y-3 mb-16 {{ $headerAlignClass }}">
        <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 inline-block">
            {{ __($partsBadge) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
            {{ __($partsTitle) }}
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            {{ __($partsSubtitle) }}
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @if($partsMode === 'dynamic' && $dynamicParts->isNotEmpty())
            @foreach($dynamicParts as $idx => $p)
                <a href="{{ route('product.details', $p->slug) }}" 
                   class="reveal-init reveal-fade-up reveal-delay-{{ ($idx % 6 + 1) * 50 }} p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all block group">
                    <x-icon :name="$p->icon ?: 'solid:gears'" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400 group-hover:scale-110 transition-transform" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white truncate">{{ $p->name }}</h4>
                    <span class="text-[10px] text-slate-500 font-mono block truncate">{{ $p->part_number ?? 'OEM Certified' }}</span>
                </a>
            @endforeach
        @else
            @foreach($staticParts as $idx => $p)
                <a href="{{ $p['url'] ?? '/products' }}" class="reveal-init reveal-fade-up reveal-delay-{{ ($idx % 6 + 1) * 50 }} p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all block group">
                    <x-icon :name="$p['icon'] ?? 'solid:gears'" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400 group-hover:scale-110 transition-transform" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white truncate">{{ $p['name'] ?? 'Spare Part' }}</h4>
                    <span class="text-[10px] text-slate-500 font-mono block truncate">{{ $p['part_number'] ?? 'OEM Certified' }}</span>
                </a>
            @endforeach
        @endif
    </div>

</x-section-styler-wrap>