<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs">
        <div class="space-y-1">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-bold">
                    <x-icon name="solid:bars-staggered" class="w-5 h-5" />
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white">Navigation Menu Builder</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Design multi-tier navigation trees with page anchors, dynamic services, and submenus</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Menu Selector -->
            @if(count($availableMenus) > 0)
                <div class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 hidden sm:inline">Active Menu:</label>
                    <select wire:model.live="selectedMenuId" class="text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                        @foreach($availableMenus as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->items_count }} items)</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="button" wire:click="$set('showCreateModal', true)" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-transparent dark:border-slate-700 rounded-xl transition-colors">
                <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                <span>New Menu</span>
            </button>

            @if($selectedMenuId)
                <button type="button" wire:confirm="Are you sure you want to delete this entire navigation menu?" wire:click="deleteCurrentMenu" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/40 border border-transparent dark:border-rose-900/40 rounded-xl transition-colors" title="Delete current menu">
                    <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                </button>
            @endif

            <!-- Save & Publish Button with Non-Overlapping Spinner -->
            <button type="button" wire:click="saveMenu" wire:loading.attr="disabled" 
                    class="inline-flex items-center justify-center h-10 px-5 rounded-xl font-bold text-xs uppercase tracking-wider bg-cyan-600 hover:bg-cyan-500 text-white dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm active:scale-95 transition-all cursor-pointer disabled:opacity-60 disabled:cursor-wait shrink-0">
                <span wire:loading.remove wire:target="saveMenu" class="inline-flex items-center gap-2 whitespace-nowrap">
                    <x-icon name="solid:floppy-disk" class="w-4 h-4" />
                    <span>Save &amp; Publish Menu</span>
                </span>
                <span wire:loading.inline-flex wire:target="saveMenu" class="items-center justify-center gap-2 whitespace-nowrap" style="display: none;">
                    <svg class="animate-spin h-4 w-4 text-current shrink-0" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Saving Menu...</span>
                </span>
            </button>
        </div>
    </div>

    <!-- Feedback Message Banner -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-700/80 text-emerald-800 dark:text-emerald-200 rounded-2xl text-xs font-semibold shadow-xs">
            <div class="flex items-center gap-2.5">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
                <span>{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-white">
                <x-icon name="solid:xmark" class="w-4 h-4" />
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left Column: Quick Add Toolboxes -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Pages Quick-Add Box -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                <div class="p-4 bg-slate-50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:file-lines" class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Pages</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                        {{ count($availablePages) }}
                    </span>
                </div>
                <div class="p-4 space-y-3">
                    <div class="max-h-52 overflow-y-auto space-y-1.5 pr-1 custom-scrollbar">
                        @foreach($availablePages as $page)
                            <label class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/90 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 cursor-pointer transition-colors text-xs text-slate-800 dark:text-slate-200">
                                <input type="checkbox" value="{{ $page['slug'] }}" wire:model="selectedPages" class="rounded text-cyan-600 focus:ring-cyan-500 border-slate-300 dark:border-slate-600 dark:bg-slate-800">
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium truncate text-slate-900 dark:text-white">{{ $page['title'] }}</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">/{{ $page['slug'] === 'home' ? '' : $page['slug'] }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <button type="button" wire:click="quickAddPages" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-bold text-slate-800 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl transition-colors">
                        <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                        <span>Add Selected to Menu</span>
                    </button>
                </div>
            </div>

            <!-- Dynamic Services Quick-Add Box -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                <div class="p-4 bg-slate-50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700/80 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:gears" class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Dynamic Services</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                        {{ count($availableServices) }}
                    </span>
                </div>
                <div class="p-4 space-y-3">
                    <div class="max-h-52 overflow-y-auto space-y-1.5 pr-1 custom-scrollbar">
                        @foreach($availableServices as $srv)
                            <label class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/90 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 cursor-pointer transition-colors text-xs text-slate-800 dark:text-slate-200">
                                <input type="checkbox" value="{{ $srv['slug'] }}" wire:model="selectedServices" class="rounded text-cyan-600 focus:ring-cyan-500 border-slate-300 dark:border-slate-600 dark:bg-slate-800">
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium truncate text-slate-900 dark:text-white">{{ $srv['title'] }}</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">/services/{{ $srv['slug'] }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <button type="button" wire:click="quickAddServices" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-bold text-slate-800 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl transition-colors">
                        <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                        <span>Add Selected to Menu</span>
                    </button>
                </div>
            </div>

            <!-- Custom Smart Item Box -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xs">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:link" class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Custom Smart Item</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Add a standalone item with full control over anchor sections, external URLs, or phone/WhatsApp actions.</p>
                <button type="button" wire:click="addNewItem" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-4 text-xs font-bold text-white bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-600 dark:hover:bg-cyan-500 rounded-xl shadow-xs transition-colors">
                    <x-icon name="solid:plus" class="w-4 h-4 text-cyan-300 dark:text-white" />
                    <span>+ Add Custom Item</span>
                </button>
            </div>
        </div>

        <!-- Right Column: Hierarchical Menu Items Tree -->
        <div class="lg:col-span-8 space-y-4">
            <!-- Active Menu Header & Settings -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex-1 max-w-sm">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Menu Name</label>
                        <input type="text" wire:model.defer="menuName" class="w-full text-sm font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Target Location</label>
                        <select wire:model.defer="menuLocation" class="text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                            <option value="primary">Primary Header</option>
                            <option value="footer">Footer Navigation</option>
                            <option value="mobile">Mobile Drawer</option>
                            <option value="custom">Custom Location</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-600 dark:text-slate-300 font-medium">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-cyan-500"></span>
                        <span class="font-bold text-cyan-700 dark:text-cyan-400">Root (L0)</span>
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500 ml-2"></span>
                        <span class="font-bold text-blue-700 dark:text-blue-400">Submenu (L1)</span>
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500 ml-2"></span>
                        <span class="font-bold text-amber-700 dark:text-amber-400">Child (L2)</span>
                    </div>
                    <div>
                        <span>Total Items: <strong class="text-slate-900 dark:text-white">{{ count($items) }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            @if(empty($items))
                <div class="bg-white dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-2xl p-12 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 mx-auto flex items-center justify-center mb-3">
                        <x-icon name="solid:bars-staggered" class="w-6 h-6" />
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-1">No items in this menu yet</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-4">Select pages or dynamic services from the left panel, or add a custom item to begin building your menu tree.</p>
                    <button type="button" wire:click="addNewItem" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-cyan-600 hover:bg-cyan-500 rounded-xl transition-colors">
                        <x-icon name="solid:plus" class="w-4 h-4" />
                        <span>Add First Menu Item</span>
                    </button>
                </div>
            @else
                <div class="space-y-1.5">
                    @foreach($items as $index => $item)
                        @php
                            $depth = $item['depth'] ?? 0;
                            
                            // High-contrast, streamlined compact container styling
                            $containerClass = match($depth) {
                                1 => 'ml-3 sm:ml-7 bg-blue-50/40 dark:bg-slate-900/90 border-blue-200 dark:border-blue-900/60 border-l-[4px] border-l-blue-500 dark:border-l-blue-400 shadow-2xs',
                                2 => 'ml-6 sm:ml-14 bg-amber-50/40 dark:bg-slate-900/90 border-amber-200 dark:border-amber-900/60 border-l-[4px] border-l-amber-500 dark:border-l-amber-400 shadow-2xs',
                                default => 'ml-0 bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 border-l-[4px] border-l-cyan-500 dark:border-l-cyan-400 shadow-2xs',
                            };
                            
                            $badgeColor = match($depth) {
                                1 => 'bg-blue-100 text-blue-800 dark:bg-blue-400 dark:text-slate-950',
                                2 => 'bg-amber-100 text-amber-800 dark:bg-amber-400 dark:text-slate-950',
                                default => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-400 dark:text-slate-950',
                            };
                            
                            $depthLabel = match($depth) {
                                1 => 'L1',
                                2 => 'L2',
                                default => 'L0',
                            };

                            $canIndent = ($index > 0 && $depth < 2 && $depth < min(2, ($items[$index - 1]['depth'] ?? 0) + 1));
                            $canOutdent = ($depth > 0);
                            $isExpanded = ($expandedIndex === $index);
                        @endphp

                        <div wire:key="menu-item-{{ $item['temp_id'] ?? $item['id'] ?? $index }}" 
                             class="rounded-xl border transition-all overflow-hidden {{ $containerClass }}">
                            
                            <!-- Compact Streamlined Item Row Header -->
                            <div class="py-1.5 px-3 flex items-center justify-between gap-2.5 bg-slate-50/80 dark:bg-slate-800/60 {{ $isExpanded ? 'border-b border-slate-200 dark:border-slate-700' : '' }}">
                                <div class="flex items-center gap-2 min-w-0 flex-1">
                                    <!-- Depth Badge -->
                                    <span class="text-[9px] font-extrabold uppercase tracking-wider px-1.5 py-0.5 rounded shrink-0 shadow-2xs {{ $badgeColor }}"
                                          title="{{ $depth === 0 ? 'Root Level (L0)' : ($depth === 1 ? 'Submenu Level 1' : 'Child Level 2') }}">
                                        {{ $depthLabel }}
                                    </span>

                                    <!-- Title Display -->
                                    <div class="min-w-0 flex items-center gap-2 flex-1">
                                        <button type="button" wire:click="toggleItem({{ $index }})" 
                                                class="text-xs font-bold text-slate-900 dark:text-white truncate hover:text-cyan-600 dark:hover:text-cyan-400 text-left cursor-pointer transition-colors">
                                            {{ $item['title'] ?: 'Untitled Item' }}
                                        </button>
                                        @if(!empty($item['link']['type']))
                                            <span class="text-[10px] text-slate-500 dark:text-cyan-400/90 font-mono hidden sm:inline truncate max-w-[200px]">
                                                @if($item['link']['type'] === 'internal')
                                                    ({{ $item['link']['page'] ?? 'home' }}{{ !empty($item['link']['section']) ? '#' . $item['link']['section'] : '' }})
                                                @elseif($item['link']['type'] === 'service')
                                                    (/services/{{ $item['link']['service_slug'] ?? '' }})
                                                @elseif($item['link']['type'] === 'external')
                                                    ({{ $item['link']['url'] ?? '#' }})
                                                @else
                                                    ({{ $item['link']['type'] }})
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons (Ultra-compact Toolbar) -->
                                <div class="flex items-center gap-1 shrink-0">
                                    <!-- Outdent Button (<) -->
                                    <button type="button" wire:click="outdentItem({{ $index }})" 
                                            @disabled(!$canOutdent) 
                                            class="p-1 rounded-md text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs disabled:opacity-20 disabled:pointer-events-none" 
                                            title="Outdent to Parent / Root (Move Left)">
                                        <x-icon name="solid:arrow-left" class="w-3 h-3" />
                                    </button>

                                    <!-- Indent Button (>) -->
                                    <button type="button" wire:click="indentItem({{ $index }})" 
                                            @disabled(!$canIndent) 
                                            class="p-1 rounded-md text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs disabled:opacity-20 disabled:pointer-events-none" 
                                            title="Indent as Submenu (Move Right)">
                                        <x-icon name="solid:arrow-right" class="w-3 h-3" />
                                    </button>

                                    <!-- Move Up -->
                                    <button type="button" wire:click="moveItem({{ $index }}, 'up')" 
                                            @disabled($index === 0) 
                                            class="p-1 rounded-md text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs disabled:opacity-20 disabled:pointer-events-none" 
                                            title="Move Up">
                                        <x-icon name="solid:arrow-up" class="w-3 h-3" />
                                    </button>

                                    <!-- Move Down -->
                                    <button type="button" wire:click="moveItem({{ $index }}, 'down')" 
                                            @disabled($index === count($items) - 1) 
                                            class="p-1 rounded-md text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs disabled:opacity-20 disabled:pointer-events-none" 
                                            title="Move Down">
                                        <x-icon name="solid:arrow-down" class="w-3 h-3" />
                                    </button>

                                    <!-- Toggle Edit HUD -->
                                    <button type="button" wire:click="toggleItem({{ $index }})" 
                                            class="p-1 rounded-md text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-950/80 hover:bg-cyan-100 dark:hover:bg-cyan-900 border border-cyan-200 dark:border-cyan-800 transition-colors shadow-2xs" 
                                            title="Configure item details &amp; parent">
                                        <x-icon name="solid:sliders" class="w-3 h-3" />
                                    </button>

                                    <!-- Delete Item -->
                                    <button type="button" wire:click="removeItem({{ $index }})" 
                                            class="p-1 rounded-md text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/80 hover:bg-rose-100 dark:hover:bg-rose-900 border border-rose-200 dark:border-rose-900 transition-colors shadow-2xs" 
                                            title="Delete item">
                                        <x-icon name="solid:trash" class="w-3 h-3" />
                                    </button>
                                </div>
                            </div>

                            <!-- Expanded Edit Panel -->
                            @if($isExpanded)
                                <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 space-y-3">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <!-- Hierarchy Parent Selector Dropdown -->
                                        <div>
                                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                                Parent Menu (Hierarchy)
                                            </label>
                                            <select wire:change="changeItemParent({{ $index }}, $event.target.value)" 
                                                    class="w-full text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                                                <option value="" @selected(empty($item['parent_id']))>[ None - Root Level (L0) ]</option>
                                                @foreach($items as $pi => $parentCandidate)
                                                    @if($pi !== $index && ($parentCandidate['depth'] ?? 0) < 2)
                                                        @php
                                                            $candKey = $parentCandidate['id'] ?? $parentCandidate['temp_id'];
                                                            $candDepth = $parentCandidate['depth'] ?? 0;
                                                            $prefix = ($candDepth === 0) ? '📂 ' : '└── 📁 ';
                                                            $levelName = ($candDepth === 0) ? 'Root' : 'Submenu';
                                                        @endphp
                                                        <option value="{{ $candKey }}" @selected(($item['parent_id'] ?? null) == $candKey)>
                                                            {{ $prefix }}{{ $parentCandidate['title'] ?: 'Untitled' }} ({{ $levelName }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Label Text Input -->
                                        <div>
                                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Navigation Label</label>
                                            <input type="text" wire:model.defer="items.{{ $index }}.title" 
                                                   class="w-full text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                                        </div>

                                        <!-- Active Toggle -->
                                        <div class="flex items-center pt-6">
                                            <label class="inline-flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-800 dark:text-slate-200">
                                                <input type="checkbox" wire:model.defer="items.{{ $index }}.is_active" class="rounded text-cyan-600 focus:ring-cyan-500 border-slate-300 dark:border-slate-600 dark:bg-slate-800">
                                                <span>Active in Navigation</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Universal Smart Link Picker -->
                                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Destination Action / Target</label>
                                        <x-smart-link-picker wire:model="items.{{ $index }}.link" :show-label="false" />
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Create New Menu Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-150">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center">
                            <x-icon name="solid:plus" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Create New Menu</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Add a new standalone navigation structure</p>
                        </div>
                    </div>
                    <button type="button" wire:click="$set('showCreateModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <x-icon name="solid:xmark" class="w-5 h-5" />
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Menu Name</label>
                        <input type="text" wire:model.defer="newMenuName" placeholder="e.g. Header Main Menu, Footer Quick Links" class="w-full text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                        @error('newMenuName') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Location Identifier</label>
                        <select wire:model.defer="newMenuLocation" class="w-full text-xs font-semibold bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:outline-hidden">
                            <option value="primary">Primary Header</option>
                            <option value="footer">Footer</option>
                            <option value="mobile">Mobile Drawer</option>
                            <option value="custom">Custom Location</option>
                        </select>
                        @error('newMenuLocation') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button type="button" wire:click="createMenu" class="px-5 py-2 text-xs font-bold text-white bg-cyan-600 hover:bg-cyan-500 rounded-xl shadow-xs transition-colors">
                        Create Menu
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
