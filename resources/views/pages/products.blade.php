<x-layouts.frontend :title="\App\Models\Setting::get('products_hero_title', __('Marine Turbocharger Spare Parts & Industrial Products'))">

    @php
        $bgStyle = \App\Models\Setting::get('products_header_bg', 'transparent');
        $frostedOpacity = max(10, min(90, (int) \App\Models\Setting::get('products_header_frosted_opacity', 80)));
        $opacityDecimal = $frostedOpacity / 100;

        $customLightBg = \App\Models\Setting::get('products_header_light_bg', '#ffffff');
        $customDarkBg = \App\Models\Setting::get('products_header_dark_bg', '#07131e');
        $customLightText = \App\Models\Setting::get('products_header_light_text', '#0f172a');
        $customDarkText = \App\Models\Setting::get('products_header_dark_text', '#f8fafc');

        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'header-frosted-products backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            'custom'   => 'header-custom-products',
            default    => 'bg-transparent',
        };

        // Layout & Display Controls
        $colsSetting = \App\Models\Setting::get('products_grid_cols', '4');
        $perPage = \App\Models\Setting::get('products_per_page', '16');
        $showCategoryFilter = (bool) \App\Models\Setting::get('products_show_category_filter', true);
        $showSearch = (bool) \App\Models\Setting::get('products_show_search', true);
        $showBrochureBtn = (bool) \App\Models\Setting::get('products_show_brochure_btn', true);
        $showInquiryBtn = (bool) \App\Models\Setting::get('products_show_inquiry_btn', true);

        $gridColsClass = match($colsSetting) {
            '2'     => 'grid-cols-1 sm:grid-cols-2',
            '3'     => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
            '6'     => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
            default => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
        };

        $selectedCat = request('category', 'all');
        $searchQ = request('q', '');

        $query = \App\Models\Product::with(['featuredImage', 'brochure'])->where('is_active', true);

        if (!empty($searchQ)) {
            $term = '%' . $searchQ . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('part_number', 'like', $term)
                  ->orWhere('technical_specifications', 'like', $term);
            });
        }

        if ($selectedCat !== 'all') {
            $query->where(function ($q) use ($selectedCat) {
                $q->whereHas('category', function ($cq) use ($selectedCat) {
                    $cq->where('name', $selectedCat)->orWhere('slug', $selectedCat);
                })->orWhere('technical_specifications', 'like', '%"category":"' . $selectedCat . '"%');
            });
        }

        if ($perPage !== 'all') {
            $query->take((int) $perPage);
        }

        $allProducts = $query->orderBy('id', 'desc')->get();

        $dbCategories = \App\Models\Category::active()->orderBy('name')->pluck('name', 'name')->toArray();
        if (empty($dbCategories)) {
            $dbCategories = [
                'Rotor Assemblies'      => 'Rotor Assemblies',
                'Cartridges (CHRA)'     => 'Cartridges (CHRA)',
                'Nozzle Rings & Shrouds'=> 'Nozzle Rings',
                'Bearings & Seals'      => 'Bearings & Seals',
                'Turbine Blading'       => 'Turbine Blades',
                'Compressor Impellers'  => 'Compressor Wheels',
            ];
        }
        $categories = array_merge(['all' => __('All Spare Parts')], $dbCategories);
    @endphp

    @if($bgStyle === 'frosted')
        <style>
            .header-frosted-products { background-color: rgba(255, 255, 255, {{ $opacityDecimal }}); }
            .dark .header-frosted-products { background-color: rgba(7, 19, 30, {{ $opacityDecimal }}); }
        </style>
    @elseif($bgStyle === 'custom')
        <style>
            .header-custom-products { background-color: {{ $customLightBg }}; color: {{ $customLightText }}; }
            .header-custom-products h1, .header-custom-products p { color: {{ $customLightText }}; }
            .dark .header-custom-products { background-color: {{ $customDarkBg }}; color: {{ $customDarkText }}; }
            .dark .header-custom-products h1, .dark .header-custom-products p { color: {{ $customDarkText }}; }
        </style>
    @endif

    <!-- Hero Header -->
    <div class="py-16 sm:py-24 {{ $headerBgClasses }} border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 shadow-2xs">
                {{ \App\Models\Setting::get('products_badge', __('Genuine OEM & Precision Parts')) }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold font-heading text-slate-900 dark:text-white mt-4 leading-tight">
                {{ \App\Models\Setting::get('products_hero_title', __('Marine Turbocharger Spare Parts & Assemblies.')) }}
            </h1>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl mt-4 leading-relaxed font-medium">
                {{ \App\Models\Setting::get('products_hero_subtitle', __('Comprehensive inventory of genuine OEM turbocharger spare parts, complete factory-balanced rotating cartridges (CHRA), turbine blades, and high-precision nozzle rings backed by 12 months marine class warranty.')) }}
            </p>
        </div>
    </div>

    <!-- Catalog Section with Filter Strip -->
    <section class="py-12 sm:py-16 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors"
             x-data="{ activeCat: '{{ $selectedCat }}' }">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-8">
            
            <!-- Filter Bar & Search (Conditional) -->
            @if($showCategoryFilter || $showSearch)
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-4 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm">
                    @if($showCategoryFilter)
                        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar w-full md:w-auto pb-2 md:pb-0">
                            @foreach($categories as $cKey => $cLabel)
                                <a href="{{ route('products', array_filter(['category' => $cKey === 'all' ? null : $cKey, 'q' => $searchQ])) }}"
                                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer {{ $selectedCat === $cKey ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                                    {{ $cLabel }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if($showSearch)
                        <form action="{{ route('products') }}" method="GET" class="w-full md:w-72 relative">
                            @if($selectedCat !== 'all')
                                <input type="hidden" name="category" value="{{ $selectedCat }}">
                            @endif
                            <input type="text" name="q" value="{{ $searchQ }}" placeholder="{{ __('Search by Part # or Model...') }}"
                                   class="w-full pl-9 pr-4 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                            <x-icon name="solid:magnifying-glass" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                            @if(!empty($searchQ))
                                <a href="{{ route('products', array_filter(['category' => $selectedCat === 'all' ? null : $selectedCat])) }}" 
                                   class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-slate-600">&times;</a>
                            @endif
                        </form>
                    @endif
                </div>
            @endif

            <!-- Products Grid (Industrial Corporate Part Cards) -->
            <div class="grid {{ $gridColsClass }} gap-6">
                @forelse($allProducts as $part)
                    <div class="group relative rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800/90 shadow-sm hover:shadow-xl hover:border-[#003C58]/40 dark:hover:border-cyan-500/40 transition-all duration-300 flex flex-col overflow-hidden">
                        
                        <!-- Top Image Aspect Container -->
                        <div class="relative aspect-16/10 bg-slate-100 dark:bg-slate-900/80 overflow-hidden">
                            <img src="{{ $part->image_url }}" alt="{{ $part->display_title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                            <!-- Top Badges Overlay -->
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2 pointer-events-none">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-slate-900/80 backdrop-blur-xs text-white shadow-xs">
                                    {{ $part->part_number ?: 'OEM PART' }}
                                </span>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-500/90 backdrop-blur-xs text-white shadow-xs">
                                    {{ $part->condition }}
                                </span>
                            </div>

                            <!-- Bottom Floating Brand Tag -->
                            <div class="absolute bottom-2.5 left-3">
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-white/90 dark:bg-slate-900/90 text-[#003C58] dark:text-cyan-400 shadow-2xs">
                                    {{ $part->brand }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400 uppercase tracking-wider block">
                                    {{ $part->category }}
                                </span>
                                <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors line-clamp-2">
                                    <a href="{{ route('product.details', $part->slug) }}">
                                        {{ $part->display_title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                                    {{ $part->summary ?: $part->description }}
                                </p>
                            </div>

                            <!-- Quick Specs Chips -->
                            @if(!empty($part->specs_list))
                                <div class="grid grid-cols-2 gap-1.5 py-2 border-t border-slate-100 dark:border-slate-800/80 text-[10px]">
                                    @foreach(array_slice($part->specs_list, 0, 2) as $sp)
                                        <div class="bg-slate-50 dark:bg-slate-900/60 p-1.5 rounded-lg truncate">
                                            <span class="text-slate-400 block truncate">{{ $sp['key'] }}:</span>
                                            <strong class="text-slate-800 dark:text-slate-200 truncate">{{ $sp['value'] }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Stock + Action Footer -->
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-2">
                                <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>{{ $part->stock_status }}</span>
                                </span>

                                <div class="flex items-center gap-1.5">
                                    @if($showBrochureBtn && $part->brochure)
                                        <a href="{{ $part->brochure->url }}" target="_blank"
                                           title="Download Technical Brochure"
                                           class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-white">
                                            <x-icon name="solid:document-arrow-down" class="w-3.5 h-3.5 text-rose-500" />
                                        </a>
                                    @endif

                                    <a href="{{ route('product.details', $part->slug) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58] hover:text-white dark:hover:bg-cyan-500 dark:hover:text-slate-950 transition-all cursor-pointer">
                                        <span>{{ __('Details') }}</span>
                                        <x-icon name="solid:arrow-right" class="w-3 h-3" />
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 space-y-3">
                        <x-icon name="solid:cog" class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-700 animate-spin" />
                        <h4 class="text-base font-bold text-slate-700 dark:text-slate-300">No spare parts match your filter</h4>
                        <p class="text-xs text-slate-500">Please try selecting a different category or search keyword.</p>
                        <a href="{{ route('products') }}" class="inline-block mt-2 px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950">
                            Clear All Filters
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- Bottom Technical Assistance CTA -->
    <div class="py-16 bg-white dark:bg-[#07131e] text-center border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">{{ __('Looking for a Specific Marine Turbocharger Part?') }}</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                {{ __('Send your engine nameplate photo or turbocharger serial number to our technical dispatch team for instant quotation and availability.') }}
            </p>
            <div class="flex items-center justify-center gap-3 pt-2 flex-wrap">
                <a href="{{ route('contact') }}#rfq" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-[#003C58] hover:bg-[#024a6d] shadow-lg transition-all">
                    {{ __('Submit Technical RFQ') }} &rarr;
                </a>
                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+8801819318488') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    <x-icon name="solid:phone-volume" class="w-4 h-4 text-cyan-500" />
                    <span>{{ __('Call 24/7 Port Duty Desk') }}</span>
                </a>
            </div>
        </div>
    </div>

</x-layouts.frontend>
