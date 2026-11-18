<x-layouts.frontend title="{{ $product->display_title }} | {{ $product->part_number }} | Nordroy Marine">

    <!-- Breadcrumb Navigation Bar -->
    <section class="pt-24 pb-4 sm:pt-28 sm:pb-6 bg-slate-50 dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors shrink-0">Home</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('products') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors shrink-0">Spare Parts</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('products', ['category' => $product->category]) }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors shrink-0">{{ $product->category }}</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-800 dark:text-slate-200 truncate font-bold">{{ $product->display_title }}</span>
            </nav>
        </div>
    </section>

    <!-- Main Product Showcase Section -->
    <section class="py-10 sm:py-16 bg-white dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors"
             x-data="{ 
                 activeTab: 'specs',
                 isRfqModalOpen: false,
                 copiedPart: false,
                 copyPartNumber() {
                     navigator.clipboard.writeText('{{ $product->part_number }}');
                     this.copiedPart = true;
                     setTimeout(() => this.copiedPart = false, 2000);
                 }
             }">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                
                <!-- Left Column: High-Res Image Showcase & Engineering Badges (5 cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="relative rounded-3xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-lg aspect-square flex items-center justify-center group">
                        <img src="{{ $product->image_url }}" alt="{{ $product->display_title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                        <!-- Top Floating Badges -->
                        <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2 pointer-events-none">
                            <span class="px-3 py-1 rounded-xl text-xs font-mono font-bold bg-slate-950/80 backdrop-blur-xs text-white shadow-md">
                                {{ $product->part_number ?: 'OEM SPEC' }}
                            </span>
                            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-emerald-500/90 backdrop-blur-xs text-white shadow-md">
                                {{ $product->condition }}
                            </span>
                        </div>

                        <!-- Bottom Zoom Hint -->
                        <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-xs text-white text-[10px] font-semibold flex items-center gap-1.5 opacity-80 group-hover:opacity-100 transition-opacity">
                            <x-icon name="solid:magnifying-glass-plus" class="w-3.5 h-3.5" />
                            <span>High-Precision Component</span>
                        </div>
                    </div>

                    <!-- Quality & Certification Trust Matrix -->
                    <div class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 text-center">
                        <div class="space-y-1">
                            <x-icon name="solid:shield-check" class="w-5 h-5 mx-auto text-[#003C58] dark:text-cyan-400" />
                            <strong class="block text-[11px] font-bold text-slate-900 dark:text-white">ISO 1940 G1.0</strong>
                            <span class="text-[9px] text-slate-400 block">Dynamic Balanced</span>
                        </div>
                        <div class="space-y-1 border-x border-slate-200 dark:border-slate-800">
                            <x-icon name="solid:certificate" class="w-5 h-5 mx-auto text-emerald-500" />
                            <strong class="block text-[11px] font-bold text-slate-900 dark:text-white">100% NDT Tested</strong>
                            <span class="text-[9px] text-slate-400 block">Zero Micro-Cracks</span>
                        </div>
                        <div class="space-y-1">
                            <x-icon name="solid:clock" class="w-5 h-5 mx-auto text-amber-500" />
                            <strong class="block text-[11px] font-bold text-slate-900 dark:text-white">24h Port Call</strong>
                            <span class="text-[9px] text-slate-400 block">Chittagong Dispatch</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Part Details, Specs & Procurement Actions (7 cols) -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Header Group -->
                    <div class="space-y-3 pb-6 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                {{ $product->category }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                {{ $product->brand }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10">
                                &bull; {{ $product->stock_status }}
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-4xl font-black font-heading text-slate-900 dark:text-white tracking-tight leading-tight">
                            {{ $product->display_title }}
                        </h1>

                        <!-- Part Number + Copy Button -->
                        @if(!empty($product->part_number))
                            <div class="flex items-center gap-3 pt-1">
                                <span class="text-xs font-bold text-slate-400">OEM Part Number:</span>
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono text-xs font-bold text-slate-900 dark:text-cyan-300">
                                    <span>{{ $product->part_number }}</span>
                                    <button type="button" @click="copyPartNumber()" 
                                            class="text-slate-400 hover:text-[#003C58] dark:hover:text-white transition-colors cursor-pointer"
                                            :title="copiedPart ? 'Copied!' : 'Copy to clipboard'">
                                        <x-icon name="solid:clipboard" class="w-3.5 h-3.5" x-show="!copiedPart" />
                                        <x-icon name="solid:check" class="w-3.5 h-3.5 text-emerald-500" x-show="copiedPart" style="display: none;" />
                                    </button>
                                </div>
                                <span x-show="copiedPart" class="text-[10px] font-bold text-emerald-500" style="display: none;">Copied!</span>
                            </div>
                        @endif

                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed pt-1">
                            {{ $product->summary ?: $product->description }}
                        </p>
                    </div>

                    <!-- Key Technical Highlights (Quick Specs Matrix) -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Compatible Engines</span>
                            <strong class="text-xs font-bold text-slate-800 dark:text-slate-200 block truncate" title="{{ $product->compatible_models }}">
                                {{ $product->compatible_models }}
                            </strong>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Dispatch Window</span>
                            <strong class="text-xs font-bold text-emerald-600 dark:text-emerald-400 block truncate">
                                {{ $product->lead_time }}
                            </strong>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800 col-span-2 sm:col-span-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Class Warranty</span>
                            <strong class="text-xs font-bold text-cyan-600 dark:text-cyan-400 block truncate">
                                {{ $product->warranty }}
                            </strong>
                        </div>
                    </div>

                    <!-- Procurement & RFQ Action Bar -->
                    <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Procurement &amp; Inquiries</span>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Request Quotation or Immediate Delivery</h3>
                            </div>
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border border-cyan-500/20">
                                24/7 Response
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <!-- Primary RFQ Button -->
                            <button type="button" 
                                    @click="isRfqModalOpen = true"
                                    class="w-full sm:flex-1 py-3.5 px-6 rounded-2xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs uppercase tracking-wider shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <x-icon name="solid:paper-airplane" class="w-4 h-4" />
                                <span>Request Quotation (RFQ)</span>
                            </button>

                            <!-- Direct WhatsApp RFQ -->
                            @php
                                $waPhone = preg_replace('/[^\d]/', '', \App\Models\Setting::get('contact_phone', '+8801819318488'));
                                $waText = urlencode("Hello Nordroy Marine, I would like to request a quotation for spare part: " . $product->display_title . " (Part #: " . $product->part_number . ")");
                            @endphp
                            <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer"
                               class="w-full sm:w-auto py-3.5 px-5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-colors flex items-center justify-center gap-2">
                                <x-icon name="solid:chat-bubble-oval-left" class="w-4 h-4" />
                                <span>WhatsApp RFQ</span>
                            </a>
                        </div>

                        <!-- Secondary Actions: Hotline & PDF Datasheet -->
                        <div class="flex items-center justify-between pt-3 border-t border-slate-200/80 dark:border-slate-800 text-xs text-slate-500 flex-wrap gap-2">
                            <div class="flex items-center gap-1.5">
                                <x-icon name="solid:phone-volume" class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                                <span>24/7 Port Duty Desk:</span>
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+8801819318488') }}" class="font-bold text-slate-800 dark:text-slate-200 hover:underline">
                                    {{ \App\Models\Setting::get('contact_phone', '+880 1819-318488') }}
                                </a>
                            </div>

                            @if($product->pdf_url)
                                <a href="{{ $product->pdf_url }}" target="_blank" download
                                   class="font-bold text-[#003C58] dark:text-cyan-400 hover:underline inline-flex items-center gap-1">
                                    <x-icon name="solid:document-arrow-down" class="w-3.5 h-3.5" />
                                    <span>Download Technical Datasheet (PDF)</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                    <x-icon name="solid:check-badge" class="w-3.5 h-3.5 text-emerald-500" />
                                    <span>Class Certificate Included with Shipment</span>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

            <!-- In-Depth Technical Information & Inspection Protocols Tabs -->
            <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800">
                
                <!-- Tab Selector Buttons -->
                <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-4 overflow-x-auto no-scrollbar">
                    <button type="button" @click="activeTab = 'specs'"
                            class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 cursor-pointer"
                            :class="activeTab === 'specs' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white dark:hover:bg-slate-800'">
                        1. Engineering Specifications
                    </button>
                    <button type="button" @click="activeTab = 'inspection'"
                            class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 cursor-pointer"
                            :class="activeTab === 'inspection' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white dark:hover:bg-slate-800'">
                        2. Balancing &amp; NDT Protocols
                    </button>
                    <button type="button" @click="activeTab = 'warranty'"
                            class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all shrink-0 cursor-pointer"
                            :class="activeTab === 'warranty' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white dark:hover:bg-slate-800'">
                        3. Classification &amp; Warranty
                    </button>
                </div>

                <!-- Tab Content 1: Full Specifications Table -->
                <div x-show="activeTab === 'specs'" class="pt-6 space-y-6">
                    <div class="rounded-3xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                        <div class="px-6 py-4 bg-slate-100 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                Technical Parameters &amp; Tolerances
                            </h3>
                            <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold">OEM Standard Verified</span>
                        </div>
                        <div class="p-6">
                            @if(!empty($product->specs_list))
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-xs">
                                    @foreach($product->specs_list as $sp)
                                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60 dark:border-slate-800/80">
                                            <dt class="font-semibold text-slate-500 dark:text-slate-400">{{ $sp['key'] }}</dt>
                                            <dd class="font-bold text-slate-900 dark:text-white text-right">{{ $sp['value'] }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @else
                                <p class="text-xs text-slate-400 italic">No additional technical parameters listed for this item.</p>
                            @endif
                        </div>
                    </div>

                    @if(!empty($product->description))
                        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3">
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Detailed Component Overview</h3>
                            <div class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed space-y-2">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Tab Content 2: Balancing & NDT Inspection Protocols -->
                <div x-show="activeTab === 'inspection'" class="pt-6 space-y-6" style="display: none;">
                    <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">High-Speed Dynamic Balancing Bench Protocol</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Every rotating spare part supplied by Nordroy Marine undergoes dual-plane computerized dynamic balancing on our calibrated Schenck balancing benches down to ISO 1940-1 Grade G1.0 tolerance (residual vibration &le; 0.42 mm/s RMS). Test certificate with run-out data is sealed inside each delivery crate.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                <span class="text-xs font-bold text-[#003C58] dark:text-cyan-400 block mb-1">Fluorescent Penetrant (FPI)</span>
                                <p class="text-[11px] text-slate-500">100% surface crack detection on turbine blade roots and shroud contact surfaces.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                <span class="text-xs font-bold text-[#003C58] dark:text-cyan-400 block mb-1">Laser Shaft Alignment</span>
                                <p class="text-[11px] text-slate-500">Rotor shaft journal concentricity checked with dial indicator to &lt; 0.008 mm TIR.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                <span class="text-xs font-bold text-[#003C58] dark:text-cyan-400 block mb-1">Hydrostatic Pressure Test</span>
                                <p class="text-[11px] text-slate-500">Casings pressure-tested at 1.5x operating limit for zero pinhole leaks.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Content 3: Warranty & Class Approvals -->
                <div x-show="activeTab === 'warranty'" class="pt-6 space-y-6" style="display: none;">
                    <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Marine Class Guarantee &amp; Demurrage Protection</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            All genuine and reconditioned spare parts provided by Nordroy are certified for international deep-sea voyage standards conforming to DNV, Lloyd's Register, ABS, and ClassNK requirements. Covered by a comprehensive 12-month marine operational warranty.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Related Spare Parts -->
            @if($relatedProducts->count() > 0)
                <div class="mt-20 pt-12 border-t border-slate-200 dark:border-slate-800 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Inventory Catalog</span>
                            <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-900 dark:text-white">{{ __('Related Spare Parts & Kits') }}</h2>
                        </div>
                        <a href="{{ route('products') }}" class="text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                            {{ __('View All Catalog') }} &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($relatedProducts as $rel)
                            <div class="rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 overflow-hidden p-4 space-y-3 hover:border-[#003C58] dark:hover:border-cyan-400 transition-colors">
                                <div class="aspect-video rounded-xl bg-slate-200 dark:bg-slate-800 overflow-hidden">
                                    <img src="{{ $rel->image_url }}" alt="{{ $rel->display_title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[9px] font-mono font-bold text-cyan-600 dark:text-cyan-400 block">{{ $rel->part_number ?: 'OEM PART' }}</span>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white line-clamp-1">
                                        <a href="{{ route('product.details', $rel->slug) }}">{{ $rel->display_title }}</a>
                                    </h4>
                                    <span class="text-[10px] text-slate-400 block">{{ $rel->brand }}</span>
                                </div>
                                <a href="{{ route('product.details', $rel->slug) }}" class="block text-center py-1.5 rounded-lg text-[11px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58] hover:text-white dark:hover:bg-cyan-500 dark:hover:text-slate-950 transition-colors">
                                    {{ __('View Details') }} &rarr;
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- ==================== DEDICATED RFQ MODAL ==================== -->
        <div x-show="isRfqModalOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             role="dialog">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="isRfqModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white font-heading">
                                Request Quote (RFQ)
                            </h3>
                            <p class="text-xs text-slate-500">
                                Part: <strong>{{ $product->part_number ?: $product->display_title }}</strong>
                            </p>
                        </div>
                        <button type="button" @click="isRfqModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
                    </div>

                    <!-- RFQ Lead Form Component -->
                    <livewire:frontend.rfq-lead-form :service="$product->display_title . ' (Part #: ' . $product->part_number . ')'" />
                </div>
            </div>
        </div>

    </section>

</x-layouts.frontend>
