@php
    $secType = $this->getActiveSectionType();
@endphp

<div class="space-y-6">
    <!-- Active Body Section Top Action Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center shrink-0">
                <x-icon name="solid:table-cells" class="w-5 h-5" />
            </span>
            <div>
                <div class="flex items-center gap-2">
                    <input type="text" wire:model.live.debounce.300ms="currentSectionTitleSettings.title"
                           class="text-base font-bold text-slate-900 dark:text-white bg-transparent border-0 border-b border-transparent hover:border-slate-300 dark:hover:border-slate-700 focus:border-[#003C58] focus:ring-0 p-0 text-truncate max-w-sm sm:max-w-md">
                    <span class="px-2 py-0.5 text-[9px] font-mono font-bold uppercase rounded-md bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                        {{ strtoupper($secType) }}
                    </span>
                    <span class="px-2 py-0.5 text-[9px] font-mono font-bold uppercase rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        {{ $currentSectionLayout['width'] ?? 'container-xl' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Complete Elementor-grade section customizer: content feeds, responsive layout, and visual styling</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" wire:click="toggleSectionStatus('{{ $selectedSectionId }}')"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border transition-colors flex items-center gap-1.5 bg-slate-100 border-slate-300 text-slate-700 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 cursor-pointer">
                <x-icon name="solid:eye" class="w-3.5 h-3.5 text-emerald-500" />
                <span>Active Status</span>
            </button>

            <button type="button" wire:click="save"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-xs cursor-pointer">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Section</span>
            </button>
        </div>
    </div>

    <!-- Section Navigation Sub-Tabs -->
    <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700">
        <button type="button" wire:click="$set('activeSectionTab', 'content')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer {{ $activeSectionTab === 'content' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
            <x-icon name="solid:cube" class="w-3.5 h-3.5" />
            <span>1. Content &amp; Feeds</span>
        </button>

        <button type="button" wire:click="$set('activeSectionTab', 'title')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer {{ $activeSectionTab === 'title' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
            <x-icon name="solid:heading" class="w-3.5 h-3.5" />
            <span>2. Title, Subtitle &amp; Badge</span>
        </button>

        <button type="button" wire:click="$set('activeSectionTab', 'layout')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer {{ $activeSectionTab === 'layout' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
            <x-icon name="solid:layer-group" class="w-3.5 h-3.5" />
            <span>3. Universal Layout &amp; Surface</span>
        </button>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 1: SECTION CONTENT & FEEDS (CUSTOMIZED PER COMPONENT TYPE)            -->
    <!-- ========================================================================= -->
    @if ($activeSectionTab === 'content')
        <div class="space-y-6">

            <!-- 1. GRID SECTION CONTENT -->
            @if ($secType === 'grid')
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <x-icon name="solid:table-cells" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span>Grid Content &amp; Query Engine</span>
                            </h3>
                            <p class="text-xs text-slate-500">Query corporate models dynamically or manually curate static cards (like SheraziPOS)</p>
                        </div>
                        <div class="flex items-center gap-2 p-1 rounded-xl bg-slate-100 dark:bg-slate-800">
                            <button type="button" wire:click="$set('currentSectionContent.source_type', 'model')"
                                    class="px-3 py-1 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ ($currentSectionContent['source_type'] ?? 'model') === 'model' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                                ⚡ Dynamic Query
                            </button>
                            <button type="button" wire:click="$set('currentSectionContent.source_type', 'manual')"
                                    class="px-3 py-1 rounded-lg text-xs font-bold transition-colors cursor-pointer {{ ($currentSectionContent['source_type'] ?? '') === 'manual' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-2xs' : 'text-slate-500 hover:text-slate-900' }}">
                                🗂️ Static Cards
                            </button>
                        </div>
                    </div>

                    @if (($currentSectionContent['source_type'] ?? 'model') === 'model')
                        <!-- Dynamic Model Settings -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Target Corporate Model</label>
                                <select wire:model.live="currentSectionContent.model" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="services">Marine Services Catalog</option>
                                    <option value="products">Products &amp; Turbocharger Spares</option>
                                    <option value="divisions">Business Units &amp; Divisions</option>
                                    <option value="projects">Vessel &amp; Engineering Projects</option>
                                    <option value="leadership">Executive Leadership &amp; Engineers</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Filter Scope</label>
                                <select wire:model.live="currentSectionContent.filter_scope" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="all">All Active Records</option>
                                    <option value="featured">Featured / Priority Only</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Items Limit</label>
                                <input type="number" wire:model.live="currentSectionContent.limit" min="1" max="24" class="w-full px-3 py-2 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>
                    @else
                        <!-- Static Cards Repeater -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Custom Cards ({{ count($currentSectionContent['items'] ?? []) }})</span>
                                <button type="button" wire:click="addContentItem"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                                    <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                                    <span>Add Card</span>
                                </button>
                            </div>

                            <div class="space-y-4">
                                @foreach ($currentSectionContent['items'] ?? [] as $iIdx => $item)
                                    <div wire:key="grid-item-{{ $iIdx }}" class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                                        <div class="flex items-center justify-between border-b border-slate-200/80 dark:border-slate-700 pb-2">
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                                                <x-icon name="solid:id-card" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                                                <span>Card #{{ $iIdx + 1 }}</span>
                                            </span>
                                            <button type="button" wire:click="removeContentItem({{ $iIdx }})" class="text-xs text-rose-500 hover:text-rose-600 flex items-center gap-1 cursor-pointer">
                                                <x-icon name="solid:trash-can" class="w-3 h-3" />
                                                <span>Remove</span>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start">
                                            <!-- Card Image Thumbnail & Media Picker -->
                                            <div class="md:col-span-4 space-y-1.5">
                                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Card Image / Banner</label>
                                                <div class="flex items-start gap-2.5">
                                                    <div class="w-16 h-16 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden shrink-0 flex items-center justify-center shadow-2xs">
                                                        @if (!empty($item['image_url'] ?? $item['image'] ?? ''))
                                                            <img src="{{ $item['image_url'] ?? $item['image'] }}" class="w-full h-full object-cover">
                                                        @else
                                                            <x-icon name="solid:image" class="w-6 h-6 text-slate-300 dark:text-slate-600" />
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 space-y-1">
                                                        <button type="button"
                                                                wire:click="$dispatch('open-media-picker', { targetField: 'currentSectionContent.items', targetIndex: {{ $iIdx }} })"
                                                                class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 hover:bg-[#003C58]/20 transition-colors w-full text-center cursor-pointer">
                                                            Browse Library
                                                        </button>
                                                        @if (!empty($item['image_url'] ?? $item['image'] ?? ''))
                                                            <button type="button" wire:click="removeAsset('currentSectionContent.items', {{ $iIdx }})"
                                                                    class="px-2 py-0.5 text-[10px] font-bold text-rose-500 hover:text-rose-600 w-full text-center cursor-pointer">
                                                                Clear Image
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card Icon Picker -->
                                            <div class="md:col-span-2 space-y-1.5">
                                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400">Card Icon</label>
                                                <div class="flex items-center gap-1.5">
                                                    <button type="button"
                                                            wire:click="$dispatch('open-icon-picker', { targetField: 'currentSectionContent.items', targetIndex: {{ $iIdx }} })"
                                                            class="w-10 h-10 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 flex items-center justify-center text-[#003C58] dark:text-cyan-400 hover:bg-slate-100 transition-colors shrink-0 shadow-2xs cursor-pointer"
                                                            title="Pick Icon">
                                                        @if (!empty($item['icon'] ?? ''))
                                                            <x-icon name="{{ $item['icon'] }}" class="w-5 h-5" />
                                                        @else
                                                            <x-icon name="solid:shapes" class="w-5 h-5 text-slate-400" />
                                                        @endif
                                                    </button>
                                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $iIdx }}.icon" placeholder="icon" class="w-full px-2 py-1 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                </div>
                                            </div>

                                            <!-- Title & Subtitle -->
                                            <div class="md:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Card Title</label>
                                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $iIdx }}.title" placeholder="e.g. Turbocharger Dynamic Balancing" class="w-full px-2.5 py-1.5 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Subtitle / Part No / Spec</label>
                                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $iIdx }}.subtitle" placeholder="e.g. OEM Spec / ISO 9001" class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div>
                                            <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Description / Scope Summary</label>
                                            <textarea wire:model.live="currentSectionContent.items.{{ $iIdx }}.desc" rows="2" placeholder="Full service engineering description, specifications, and scope..." class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                                        </div>

                                        <!-- Badge, Button Text, Target URL -->
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Pill Badge</label>
                                                <input type="text" wire:model.live="currentSectionContent.items.{{ $iIdx }}.badge" placeholder="e.g. Certified / Ready Stock" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Button Label</label>
                                                <input type="text" wire:model.live="currentSectionContent.items.{{ $iIdx }}.link_text" placeholder="e.g. Request RFQ" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Destination URL</label>
                                                <input type="text" wire:model.live="currentSectionContent.items.{{ $iIdx }}.link" placeholder="/services" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-0.5">Alignment</label>
                                                <select wire:model.live="currentSectionContent.items.{{ $iIdx }}.align" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                    <option value="left">Left Aligned</option>
                                                    <option value="center">Center Aligned</option>
                                                    <option value="right">Right Aligned</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Responsive Columns & Card Component Archetype Engine -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <x-icon name="solid:table-columns" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                            <span>Responsive Breakpoints &amp; Dedicated Card Archetypes</span>
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Desktop Columns</label>
                                <select wire:model.live="currentSectionContent.columns" class="w-full px-2 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="2">2 Columns (Half Width)</option>
                                    <option value="3">3 Columns (Standard Feature Grid)</option>
                                    <option value="4">4 Columns (Catalog / Spares)</option>
                                    <option value="6">6 Columns (Compact Icons / Stats)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Card Component Archetype</label>
                                <select wire:model.live="currentSectionContent.card_style" class="w-full px-2 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="service_card">⚙️ Marine Service Card (Scope &amp; ISO)</option>
                                    <option value="part_card">🔩 Spare Part Card (Part No &amp; RFQ)</option>
                                    <option value="project_card">🚢 Project / Vessel Case Card</option>
                                    <option value="unit_card">🏢 Business Unit Division Card</option>
                                    <option value="corporate_card">🏛️ Classic Corporate Card</option>
                                    <option value="bordered">🔲 Bordered Outline Card</option>
                                    <option value="elevated">📄 Elevated White Card</option>
                                    <option value="minimal">◽ Minimal Flat Card</option>
                                    <option value="glass">✨ Frosted Glass Maritime Card</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Grid Gap</label>
                                <select wire:model.live="currentSectionContent.gap" class="w-full px-2 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="12px">12px (Compact)</option>
                                    <option value="16px">16px (Standard)</option>
                                    <option value="24px">24px (Relaxed)</option>
                                    <option value="32px">32px (Spacious)</option>
                                </select>
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model.live="currentSectionContent.equal_height" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Equal Height Cards</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- View All / See All Action Button -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">"View All" Header Action Button</span>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span class="text-xs text-slate-500">Enable CTA</span>
                                <input type="checkbox" wire:model.live="currentSectionContent.show_cta" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                            </label>
                        </div>
                        @if ($currentSectionContent['show_cta'] ?? true)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Button Label</label>
                                    <input type="text" wire:model.live="currentSectionContent.cta_label" placeholder="View All Services" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Destination URL / Route</label>
                                    <input type="text" wire:model.live="currentSectionContent.cta_url" placeholder="/services" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            <!-- 2. SLIDER / MARQUEE SECTION CONTENT -->
            @elseif ($secType === 'slider')
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <x-icon name="solid:film" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span>Carousel Slider &amp; Marquee Content</span>
                            </h3>
                            <p class="text-xs text-slate-500">Configure slide items, autoplay timings, and slide controls</p>
                        </div>
                        <button type="button" wire:click="addContentItem"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                            <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                            <span>Add Slide</span>
                        </button>
                    </div>

                    <!-- Slide Controls -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Slider Type</label>
                            <select wire:model.live="currentSectionContent.slider_type" class="w-full px-2 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="carousel">Interactive Carousel</option>
                                <option value="marquee">Continuous Marquee</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Autoplay Speed (ms)</label>
                            <input type="number" wire:model.live="currentSectionContent.autoplay_speed" placeholder="5000" class="w-full px-2 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Slides Per View</label>
                            <select wire:model.live="currentSectionContent.slides_per_view" class="w-full px-2 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="1">1 Full Slide</option>
                                <option value="2">2 Slides</option>
                                <option value="3">3 Slides</option>
                                <option value="4">4 Slides</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-4 pt-5">
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input type="checkbox" wire:model.live="currentSectionContent.show_arrows" class="rounded text-[#003C58]">
                                <span>Arrows</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input type="checkbox" wire:model.live="currentSectionContent.loop" class="rounded text-[#003C58]">
                                <span>Loop</span>
                            </label>
                        </div>
                    </div>

                    <!-- Slide Items Repeater -->
                    <div class="space-y-4">
                        @foreach ($currentSectionContent['items'] ?? [] as $sIdx => $slide)
                            <div wire:key="slider-slide-{{ $sIdx }}" class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                                <div class="flex items-center justify-between border-b border-slate-200/80 dark:border-slate-700 pb-2">
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Slide #{{ $sIdx + 1 }}</span>
                                    <button type="button" wire:click="removeContentItem({{ $sIdx }})" class="text-xs text-rose-500 hover:text-rose-600 flex items-center gap-1 cursor-pointer">
                                        <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                        <span>Remove</span>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-start">
                                    <div class="sm:col-span-3">
                                        <label class="block text-[10px] font-bold text-slate-500 mb-1">Slide Image</label>
                                        <div class="flex items-center gap-2">
                                            <div class="w-14 h-14 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if (!empty($slide['image_url'] ?? $slide['image'] ?? ''))
                                                    <img src="{{ $slide['image_url'] ?? $slide['image'] }}" class="w-full h-full object-cover">
                                                @else
                                                    <x-icon name="solid:image" class="w-5 h-5 text-slate-300" />
                                                @endif
                                            </div>
                                            <button type="button"
                                                    wire:click="$dispatch('open-media-picker', { targetField: 'currentSectionContent.items', targetIndex: {{ $sIdx }} })"
                                                    class="px-2 py-1 text-[10px] font-bold rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 hover:bg-[#003C58]/20 transition-colors cursor-pointer">
                                                Browse
                                            </button>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-5">
                                        <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Headline</label>
                                        <input type="text" wire:model.live="currentSectionContent.items.{{ $sIdx }}.headline" class="w-full px-2 py-1.5 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Tag / Badge</label>
                                        <input type="text" wire:model.live="currentSectionContent.items.{{ $sIdx }}.badge" placeholder="e.g. Drydock Case" class="w-full px-2 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                    <div class="sm:col-span-12">
                                        <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Subtitle / Details</label>
                                        <textarea wire:model.live="currentSectionContent.items.{{ $sIdx }}.subtitle" rows="2" class="w-full px-2 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            <!-- 3. BANNER SECTION CONTENT -->
            @elseif ($secType === 'banner')
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="solid:image" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                            <span>Feature &amp; Promotional Banner Content</span>
                        </h3>
                    </div>

                    <!-- Banner Illustration & Layout Variant -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                            <!-- Image / Illustration Picker -->
                            <div class="sm:col-span-6 space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Banner Illustration / Visual Image</label>
                                <div class="flex items-center gap-3">
                                    <div class="w-20 h-16 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden shrink-0 flex items-center justify-center shadow-2xs">
                                        @if (!empty($currentSectionContent['image_url'] ?? $currentSectionContent['image'] ?? ''))
                                            <img src="{{ $currentSectionContent['image_url'] ?? $currentSectionContent['image'] }}" class="w-full h-full object-cover">
                                        @else
                                            <x-icon name="solid:image" class="w-7 h-7 text-slate-300 dark:text-slate-600" />
                                        @endif
                                    </div>
                                    <div class="flex-1 space-y-1">
                                        <button type="button"
                                                wire:click="$dispatch('open-media-picker', { targetField: 'currentSectionContent.image_url' })"
                                                class="px-3 py-1.5 text-xs font-bold rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                                            <x-icon name="solid:photo-film" class="w-3.5 h-3.5" />
                                            <span>Browse Media Library</span>
                                        </button>
                                        @if (!empty($currentSectionContent['image_url'] ?? $currentSectionContent['image'] ?? ''))
                                            <button type="button" wire:click="removeAsset('currentSectionContent.image_url')"
                                                    class="text-[10px] font-bold text-rose-500 hover:text-rose-600 cursor-pointer">
                                                Clear Image
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Banner Layout Variant</label>
                                <select wire:model.live="currentSectionContent.layout_variant" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="split_right">Split 2-Col (Content Left, Image Right)</option>
                                    <option value="split_left">Split 2-Col (Image Left, Content Right)</option>
                                    <option value="fullwidth">Full-Width Hero Callout</option>
                                    <option value="boxed">Boxed Card Callout</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Eyebrow Tagline</label>
                            <input type="text" wire:model.live="currentSectionContent.eyebrow" placeholder="Precision Engineering" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Banner Main Headline</label>
                            <input type="text" wire:model.live="currentSectionContent.headline" placeholder="Authorized Turbocharger Dynamic Balancing Facility" class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Description Text</label>
                            <textarea wire:model.live="currentSectionContent.description" rows="3" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                        </div>
                    </div>

                    <!-- Bullet Points Highlights -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Key Highlights &amp; Specifications</span>
                            <button type="button" wire:click="addBannerBullet" class="text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline cursor-pointer">
                                + Add Bullet Point
                            </button>
                        </div>
                        <div class="space-y-2">
                            @foreach ($currentSectionContent['bullet_points'] ?? [] as $bIdx => $bp)
                                <div wire:key="banner-bp-{{ $bIdx }}" class="flex items-center gap-2">
                                    <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500 shrink-0" />
                                    <input type="text" wire:model.live="currentSectionContent.bullet_points.{{ $bIdx }}" class="flex-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <button type="button" wire:click="removeBannerBullet({{ $bIdx }})" class="text-xs text-rose-500 hover:text-rose-600 cursor-pointer">
                                        <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dual Action Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Button 1 Label &amp; URL</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" wire:model.live="currentSectionContent.btn1_text" placeholder="Request Service" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <input type="text" wire:model.live="currentSectionContent.btn1_url" placeholder="/#inquiry" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Button 2 Label &amp; URL</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" wire:model.live="currentSectionContent.btn2_text" placeholder="Technical Specs" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <input type="text" wire:model.live="currentSectionContent.btn2_url" placeholder="/services" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

            <!-- 4. FAQ ACCORDION SECTION CONTENT -->
            @elseif ($secType === 'faq')
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <x-icon name="solid:circle-question" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span>FAQ Accordion Questions &amp; Answers</span>
                            </h3>
                            <p class="text-xs text-slate-500">Provide direct answers to customer queries, port anchorage access, and turnaround</p>
                        </div>
                        <button type="button" wire:click="addContentItem"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                            <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                            <span>Add Question</span>
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach ($currentSectionContent['items'] ?? [] as $qIdx => $faq)
                            <div wire:key="faq-q-{{ $qIdx }}" class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Question #{{ $qIdx + 1 }}</span>
                                    <button type="button" wire:click="removeContentItem({{ $qIdx }})" class="text-xs text-rose-500 hover:text-rose-600 cursor-pointer">
                                        <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Question Title</label>
                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $qIdx }}.q" class="w-full px-3 py-1.5 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Detailed Answer</label>
                                    <textarea wire:model.live="currentSectionContent.items.{{ $qIdx }}.a" rows="3" class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            <!-- 5. STATS & NUMBERS SECTION CONTENT -->
            @elseif ($secType === 'stats')
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <x-icon name="solid:chart-simple" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span>Performance Metrics &amp; Key Numbers</span>
                            </h3>
                            <p class="text-xs text-slate-500">Highlight operating statistics, vibration reduction percentages, and port turnarounds</p>
                        </div>
                        <button type="button" wire:click="addContentItem"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                            <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                            <span>Add Stat</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach ($currentSectionContent['items'] ?? [] as $stIdx => $st)
                            <div wire:key="stat-{{ $stIdx }}" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Metric #{{ $stIdx + 1 }}</span>
                                    <button type="button" wire:click="removeContentItem({{ $stIdx }})" class="text-xs text-rose-500 hover:text-rose-600 cursor-pointer">
                                        <x-icon name="solid:trash-can" class="w-3 h-3" />
                                    </button>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Stat Number</label>
                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $stIdx }}.number" placeholder="850+" class="w-full px-2 py-1 text-sm font-black font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-[#003C58] dark:text-cyan-400">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Label / Title</label>
                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $stIdx }}.label" class="w-full px-2 py-1 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Icon Name</label>
                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $stIdx }}.icon" placeholder="anchor, clock, shield" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            <!-- 6. INTERACTIVE FORMS & RFQ SECTION CONTENT -->
            @elseif ($secType === 'form')
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="solid:envelope-open-text" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                            <span>Interactive Service Dispatch &amp; RFQ Form</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Form Purpose / Type</label>
                            <select wire:model.live="currentSectionContent.form_type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="rfq">Emergency Dispatch / RFQ</option>
                                <option value="contact">General Corporate Contact</option>
                                <option value="consultation">Technical Consultation</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Submit Button Text</label>
                            <input type="text" wire:model.live="currentSectionContent.submit_label" placeholder="Submit Engineering Request" class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <!-- Configurable Field Switches -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enabled Maritime Form Fields</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="flex items-center gap-2 cursor-pointer text-xs">
                                <input type="checkbox" wire:model.live="currentSectionContent.show_vessel" class="rounded text-[#003C58]">
                                <span>Vessel &amp; IMO #</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-xs">
                                <input type="checkbox" wire:model.live="currentSectionContent.show_port" class="rounded text-[#003C58]">
                                <span>Port Terminal</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-xs">
                                <input type="checkbox" wire:model.live="currentSectionContent.show_urgency" class="rounded text-[#003C58]">
                                <span>Urgency Level</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-xs">
                                <input type="checkbox" wire:model.live="currentSectionContent.show_file" class="rounded text-[#003C58]">
                                <span>Report Attachment</span>
                            </label>
                        </div>
                    </div>
                </div>

            <!-- 7. EDITORIAL TEXT, TESTIMONIALS, LIST, OR CUSTOM HTML CONTENT -->
            @else
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="solid:cube" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                            <span>{{ ucfirst($secType) }} Content Items</span>
                        </h3>
                        <button type="button" wire:click="addContentItem"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                            <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                            <span>Add Item</span>
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach ($currentSectionContent['items'] ?? [] as $genIdx => $genItem)
                            <div wire:key="gen-item-{{ $genIdx }}" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Item #{{ $genIdx + 1 }}</span>
                                    <button type="button" wire:click="removeContentItem({{ $genIdx }})" class="text-xs text-rose-500 hover:text-rose-600 cursor-pointer">
                                        <x-icon name="solid:trash-can" class="w-3 h-3" />
                                    </button>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Title / Heading</label>
                                    <input type="text" wire:model.live="currentSectionContent.items.{{ $genIdx }}.title" class="w-full px-2 py-1 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Description / Body Text</label>
                                    <textarea wire:model.live="currentSectionContent.items.{{ $genIdx }}.desc" rows="2" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    <!-- ========================================================================= -->
    <!-- TAB 2: TITLE, SUBTITLE & BADGE                                            -->
    <!-- ========================================================================= -->
    @elseif ($activeSectionTab === 'title')
        <div class="space-y-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:heading" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Section Header &amp; Alignment</span>
                    </span>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Show Header</span>
                        <input type="checkbox" wire:model.live="currentSectionTitleSettings.show" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Section Title Heading</label>
                        <input type="text" wire:model.live="currentSectionTitleSettings.title" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Subtitle / Caption Text</label>
                        <input type="text" wire:model.live="currentSectionTitleSettings.subtitle" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Header Alignment</label>
                        <select wire:model.live="currentSectionTitleSettings.align" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            <option value="start">Left Aligned</option>
                            <option value="center">Center Aligned</option>
                            <option value="end">Right Aligned</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Title Font Size (px)</label>
                        <input type="number" wire:model.live="currentSectionTitleSettings.title_size" min="16" max="64" class="w-full px-3 py-2 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Title Pill Badge Tag -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:certificate" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Title Badge / Pill Tag</span>
                    </span>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Enable Badge</span>
                        <input type="checkbox" wire:model.live="currentSectionTitleSettings.show_badge" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                    </label>
                </div>

                @if ($currentSectionTitleSettings['show_badge'] ?? false)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Type</label>
                            <select wire:model.live="currentSectionTitleSettings.badge_type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="dynamic_count">⚡ Dynamic Total Count (e.g. 16+ Services)</option>
                                <option value="custom">🏷️ Custom Text (e.g. CERTIFIED CAPABILITIES)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lucide Icon Name</label>
                            <div class="flex items-center gap-1.5">
                                <button type="button"
                                        wire:click="$dispatch('open-icon-picker', { targetField: 'currentSectionTitleSettings.badge_icon' })"
                                        class="w-9 h-9 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 flex items-center justify-center text-[#003C58] dark:text-cyan-400 hover:bg-slate-100 transition-colors shrink-0 shadow-2xs cursor-pointer">
                                    <x-icon name="solid:shapes" class="w-4 h-4" />
                                </button>
                                <input type="text" wire:model.live="currentSectionTitleSettings.badge_icon" placeholder="sparkles, shield-check, award" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Text / Suffix</label>
                            <input type="text" wire:model.live="currentSectionTitleSettings.badge_text" placeholder="Featured Services" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                    </div>
                @endif
            </div>
        </div>

    <!-- ========================================================================= -->
    <!-- TAB 3: UNIVERSAL LAYOUT & SURFACE ENGINE                                  -->
    <!-- ========================================================================= -->
    @elseif ($activeSectionTab === 'layout')
        <div class="space-y-6">
            <!-- 1. Width, Background Type, Colors -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:maximize" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Container Sizing &amp; Surface Type</span>
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">Fluid vs Boxed</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Container Width</label>
                        <select wire:model.live="currentSectionLayout.width" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            <option value="container-xl">Boxed Container (Max 1440px - Standard)</option>
                            <option value="container-panoramic">Panoramic Wide (1680px)</option>
                            <option value="container-fluid">Container Fluid (100% Full Width Edge-to-Edge)</option>
                            <option value="container-lg">Compact Boxed (1280px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Background Type</label>
                        <select wire:model.live="currentSectionLayout.bg_type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="color">🎨 Solid Color</option>
                            <option value="gradient">🌈 Multicolor CSS3 Gradient</option>
                            <option value="image">🖼️ Image Background</option>
                            <option value="video">🎬 Ambient Video Background</option>
                        </select>
                    </div>

                    <!-- Base Text Color with direct modern color picker -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Base Text Color</label>
                        <div class="flex items-center gap-2 p-1.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xs">
                            <label class="relative w-6 h-6 rounded-lg border border-slate-300 dark:border-slate-600 overflow-hidden cursor-pointer shrink-0" title="Click to pick text color">
                                <input type="color" wire:model.live="currentSectionLayout.text_color" class="absolute -inset-2 w-10 h-10 opacity-0 cursor-pointer">
                                <span class="block w-full h-full" style="background-color: {{ $currentSectionLayout['text_color'] ?? '#0f172a' }}"></span>
                            </label>
                            <input type="text" wire:model.live="currentSectionLayout.text_color" placeholder="#0f172a" class="flex-1 px-1 py-0.5 text-xs font-mono font-bold uppercase bg-transparent border-0 text-slate-900 dark:text-white focus:ring-0">
                            <!-- Quick Swatches -->
                            <div class="flex items-center gap-1 shrink-0">
                                @foreach(['#0f172a', '#ffffff', '#003C58', '#64748b'] as $cHex)
                                    <button type="button" wire:click="$set('currentSectionLayout.text_color', '{{ $cHex }}')" class="w-4 h-4 rounded-full border border-black/10 transition-transform hover:scale-110" style="background-color: {{ $cHex }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solid Color Controls (When bg_type == 'color') -->
                @if (($currentSectionLayout['bg_type'] ?? '') === 'color')
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Solid Background Surface Color</span>
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xs">
                                <label class="relative w-7 h-7 rounded-lg border border-slate-300 dark:border-slate-600 overflow-hidden cursor-pointer shrink-0" title="Click to pick color">
                                    <input type="color" wire:model.live="currentSectionLayout.bg_color" class="absolute -inset-2 w-12 h-12 opacity-0 cursor-pointer">
                                    <span class="block w-full h-full" style="background-color: {{ $currentSectionLayout['bg_color'] ?? '#ffffff' }}"></span>
                                </label>
                                <input type="text" wire:model.live="currentSectionLayout.bg_color" placeholder="#ffffff" class="w-24 px-1 py-0.5 text-xs font-mono font-bold uppercase bg-transparent border-0 text-slate-900 dark:text-white focus:ring-0">
                            </div>

                            <!-- Curated Corporate Swatches -->
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] font-bold uppercase text-slate-400 mr-1">Presets:</span>
                                @foreach([
                                    '#ffffff' => 'White',
                                    '#f8fafc' => 'Off White',
                                    '#003C58' => 'Navy Brand',
                                    '#002436' => 'Dark Navy',
                                    '#07131e' => 'Dark Slate',
                                    '#02070c' => 'Midnight',
                                    '#f0f9ff' => 'Ice Blue',
                                    '#06b6d4' => 'Cyan',
                                    'transparent' => 'Transparent',
                                ] as $cHex => $cName)
                                    <button type="button" wire:click="$set('currentSectionLayout.bg_color', '{{ $cHex }}')"
                                            title="{{ $cName }} ({{ $cHex }})"
                                            class="w-6 h-6 rounded-lg border border-slate-300 dark:border-slate-600 transition-all hover:scale-110 cursor-pointer shadow-2xs {{ $cHex === 'transparent' ? 'bg-slate-200' : '' }}"
                                            style="background-color: {{ $cHex === 'transparent' ? 'transparent' : $cHex }};">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Gradient Controls (When bg_type == 'gradient') -->
                @if (($currentSectionLayout['bg_type'] ?? '') === 'gradient')
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-2">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Multicolor Gradient Engine</span>
                            <span class="text-[10px] font-mono text-cyan-600">CSS3 Linear / Radial</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Direction / Angle</label>
                                <input type="text" wire:model.live="currentSectionLayout.gradient_angle" placeholder="135deg" class="w-full px-2 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Color Stop 1</label>
                                <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xs">
                                    <label class="relative w-5 h-5 rounded-md border border-slate-300 dark:border-slate-600 overflow-hidden cursor-pointer shrink-0">
                                        <input type="color" wire:model.live="currentSectionLayout.gradient_stop1" class="absolute -inset-2 w-8 h-8 opacity-0 cursor-pointer">
                                        <span class="block w-full h-full" style="background-color: {{ $currentSectionLayout['gradient_stop1'] ?? '#f8fafc' }}"></span>
                                    </label>
                                    <input type="text" wire:model.live="currentSectionLayout.gradient_stop1" placeholder="#f8fafc" class="flex-1 px-1 py-0 text-xs font-mono font-bold uppercase bg-transparent border-0 text-slate-900 dark:text-white focus:ring-0">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Color Stop 2</label>
                                <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xs">
                                    <label class="relative w-5 h-5 rounded-md border border-slate-300 dark:border-slate-600 overflow-hidden cursor-pointer shrink-0">
                                        <input type="color" wire:model.live="currentSectionLayout.gradient_stop2" class="absolute -inset-2 w-8 h-8 opacity-0 cursor-pointer">
                                        <span class="block w-full h-full" style="background-color: {{ $currentSectionLayout['gradient_stop2'] ?? '#e2e8f0' }}"></span>
                                    </label>
                                    <input type="text" wire:model.live="currentSectionLayout.gradient_stop2" placeholder="#e2e8f0" class="flex-1 px-1 py-0 text-xs font-mono font-bold uppercase bg-transparent border-0 text-slate-900 dark:text-white focus:ring-0">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Image Background Controls (When bg_type == 'image') -->
                @if (($currentSectionLayout['bg_type'] ?? '') === 'image')
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Section Background Image &amp; Overlay</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-20 h-14 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if (!empty($currentSectionLayout['bg_image'] ?? ''))
                                        <img src="{{ $currentSectionLayout['bg_image'] }}" class="w-full h-full object-cover">
                                    @else
                                        <x-icon name="solid:image" class="w-6 h-6 text-slate-300" />
                                    @endif
                                </div>
                                <div class="flex-1 space-y-1">
                                    <button type="button"
                                            wire:click="$dispatch('open-media-picker', { targetField: 'currentSectionLayout.bg_image' })"
                                            class="px-3 py-1.5 text-xs font-bold rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                                        <x-icon name="solid:photo-film" class="w-3.5 h-3.5" />
                                        <span>Browse Library</span>
                                    </button>
                                    @if (!empty($currentSectionLayout['bg_image'] ?? ''))
                                        <button type="button" wire:click="$set('currentSectionLayout.bg_image', '')" class="text-[10px] font-bold text-rose-500 hover:text-rose-600 cursor-pointer">
                                            Clear Background Image
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Dark Overlay Opacity ({{ $currentSectionLayout['bg_overlay_opacity'] ?? 60 }}%)</label>
                                <input type="range" wire:model.live="currentSectionLayout.bg_overlay_opacity" min="0" max="100" class="w-full accent-[#003C58]">
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 2. Box Model Spacing (Margins & Paddings) -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:arrows-up-down-left-right" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Box Model Spacing (External Margins &amp; Internal Paddings)</span>
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">px / rem values</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Internal Padding -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Internal Padding (Top, Right, Bottom, Left)</label>
                        <div class="grid grid-cols-4 gap-2">
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.padding_top" placeholder="48px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Top</span>
                            </div>
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.padding_right" placeholder="0px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Right</span>
                            </div>
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.padding_bottom" placeholder="48px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Bottom</span>
                            </div>
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.padding_left" placeholder="0px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Left</span>
                            </div>
                        </div>
                    </div>

                    <!-- External Margin -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">External Margin (Top, Right, Bottom, Left)</label>
                        <div class="grid grid-cols-4 gap-2">
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.margin_top" placeholder="0px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Top</span>
                            </div>
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.margin_right" placeholder="0px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Right</span>
                            </div>
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.margin_bottom" placeholder="0px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Bottom</span>
                            </div>
                            <div>
                                <input type="text" wire:model.live="currentSectionLayout.margin_left" placeholder="0px" class="w-full px-2 py-1.5 text-xs font-mono font-bold text-center rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <span class="block text-[8px] uppercase font-bold text-center text-slate-400 mt-0.5">Left</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Borders & Box Shadows -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Border Styling -->
                <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:border-all" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Border Styling</span>
                    </span>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Border Style</label>
                            <select wire:model.live="currentSectionLayout.border_style" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="none">None</option>
                                <option value="solid">Solid</option>
                                <option value="dashed">Dashed</option>
                                <option value="dotted">Dotted</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Corner Radius</label>
                            <select wire:model.live="currentSectionLayout.border_radius" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="0px">0px (Square)</option>
                                <option value="6px">6px (Small)</option>
                                <option value="12px">12px (Medium)</option>
                                <option value="16px">16px (Large)</option>
                                <option value="24px">24px (X-Large)</option>
                                <option value="9999px">9999px (Pill)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Border Width</label>
                            <input type="number" wire:model.live="currentSectionLayout.border_width" min="1" max="20" class="w-full px-2 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Border Color</label>
                            <div class="relative" x-data="{ openColorPicker: false }">
                                <button type="button" 
                                        @click="openColorPicker = !openColorPicker" 
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xs hover:border-[#003C58] dark:hover:border-cyan-500 transition-all cursor-pointer">
                                    <span class="w-4 h-4 rounded-md border border-slate-300 dark:border-slate-600 shadow-2xs shrink-0"
                                          style="background-color: {{ ($currentSectionLayout['border_color'] ?? '#e2e8f0') === 'transparent' ? 'transparent' : ($currentSectionLayout['border_color'] ?? '#e2e8f0') }}"></span>
                                    <span class="text-[11px] font-mono font-bold uppercase text-slate-700 dark:text-slate-300">
                                        {{ ($currentSectionLayout['border_color'] ?? '#e2e8f0') === 'transparent' ? 'None' : ($currentSectionLayout['border_color'] ?? '#E2E8F0') }}
                                    </span>
                                    <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>

                                <!-- Color Swatch Popover -->
                                <div x-show="openColorPicker" 
                                     @click.outside="openColorPicker = false"
                                     x-transition
                                     style="display: none;"
                                     class="absolute z-50 mt-1 w-64 p-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl space-y-3">
                                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100 dark:border-slate-800">
                                        <span class="text-[11px] font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Border Color</span>
                                        <button type="button" 
                                                wire:click="$set('currentSectionLayout.border_color', 'transparent')"
                                                @click="openColorPicker = false"
                                                class="text-[10px] font-bold px-2 py-0.5 rounded bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 hover:bg-rose-100 transition-colors cursor-pointer">
                                            Clear (None)
                                        </button>
                                    </div>

                                    <!-- Presets -->
                                    <div>
                                        <span class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase">Color Presets</span>
                                        <div class="grid grid-cols-6 gap-1.5">
                                            @foreach(['#e2e8f0', '#cbd5e1', '#94a3b8', '#64748b', '#334155', '#0f172a', '#003C58', '#0ea5e9', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'] as $presetHex)
                                                <button type="button" 
                                                        wire:click="$set('currentSectionLayout.border_color', '{{ $presetHex }}')"
                                                        @click="openColorPicker = false"
                                                        style="background-color: {{ $presetHex }};"
                                                        class="w-7 h-7 rounded-lg border border-slate-300 dark:border-slate-700 shadow-2xs hover:scale-110 active:scale-95 transition-transform cursor-pointer relative"
                                                        title="{{ $presetHex }}">
                                                    @if(strtolower($currentSectionLayout['border_color'] ?? '') === strtolower($presetHex))
                                                        <span class="absolute inset-0 flex items-center justify-center text-white text-[10px] font-bold drop-shadow">✓</span>
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Direct Hex & Native Color Eye-dropper -->
                                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                                        <label class="relative w-8 h-8 rounded-lg border border-slate-300 dark:border-slate-600 overflow-hidden cursor-pointer shrink-0 shadow-2xs" title="Open Custom Color Picker">
                                            <input type="color" 
                                                   wire:model.live="currentSectionLayout.border_color"
                                                   class="absolute -inset-2 w-12 h-12 opacity-0 cursor-pointer">
                                            <span class="block w-full h-full" 
                                                  style="background-color: {{ $currentSectionLayout['border_color'] ?? '#e2e8f0' }}"></span>
                                        </label>
                                        <input type="text" 
                                               wire:model.live="currentSectionLayout.border_color"
                                               placeholder="#e2e8f0"
                                               class="flex-1 px-2.5 py-1 text-xs font-mono font-bold uppercase rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#003C58]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box Shadow -->
                <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:cube" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Box Shadow</span>
                    </span>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Shadow Intensity Preset</label>
                            <select wire:model.live="currentSectionLayout.shadow_mode" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="none">None (No Shadow)</option>
                                <option value="preset">Preset Shadow</option>
                            </select>
                        </div>

                        @if (($currentSectionLayout['shadow_mode'] ?? '') === 'preset')
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Intensity</label>
                                <select wire:model.live="currentSectionLayout.shadow_preset" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="sm">Small (Subtle border glow)</option>
                                    <option value="md">Medium (Clean elevated card)</option>
                                    <option value="lg">Large (Floating prominent card)</option>
                                    <option value="xl">Extra Large (Deep elevation)</option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
