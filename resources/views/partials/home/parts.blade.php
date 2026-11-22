@php
    $partsEnabled = (bool) \App\Models\Setting::get('home_parts_enabled', true);
    if (!$partsEnabled) return;

    $partsBadge = \App\Models\Setting::get('home_parts_badge', 'OEM Replacement Inventory');
    $partsTitle = \App\Models\Setting::get('home_parts_title', 'Genuine Spare Parts Catalog');
    $partsSubtitle = \App\Models\Setting::get('home_parts_subtitle', 'Traceable serial numbers with mill test certificates ready for immediate dispatch.');
    $partsMode = \App\Models\Setting::get('home_parts_mode', 'static');
    $partsLimit = (int) \App\Models\Setting::get('home_parts_limit', 6);

    $dynamicParts = collect();
    if ($partsMode === 'dynamic') {
        try {
            $dynamicParts = \App\Models\Product::where('is_active', true)->take($partsLimit)->get();
        } catch (\Throwable $e) {
            $dynamicParts = collect();
        }
    }
@endphp

<!-- =====================================================================
     GENUINE SPARE PARTS CATALOG (Turbo Internacional Style)
     ===================================================================== -->
<section id="parts" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
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
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:fan" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Turbine Blades</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Nimonic 80A / 90</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-150 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:circle-notch" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Rotor Shafts</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Forged Alloy Steel</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-200 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:ring" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Nozzle Rings</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">High-Temp Resistant</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-250 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:compact-disc" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Bearing Bushes</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Hydrodynamic Squeeze</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-300 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:asterisk" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Impellers</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Milled Titanium / Al</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-350 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:shield" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Seal Kits</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Gas &amp; Oil Labyrinth</span>
                </div>
            @endif
        </div>

    </div>
</section>
