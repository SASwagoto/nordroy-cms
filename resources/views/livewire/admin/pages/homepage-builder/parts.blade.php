<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:boxes-stacked" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Genuine OEM Spare Parts Catalog</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Traceable serial numbers with mill certificates (Rotors, Cartridges, Bearings, Nozzle Rings).</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="parts_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $parts_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="parts" />

        <!-- Architecture -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:database" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Spare Parts Architecture</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Data Source</label>
                    <select wire:model.live="parts_mode"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="static">Static Corporate Spare Parts (6 Certified Components)</option>
                        <option value="dynamic">Dynamic Database Catalog (Product Table)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Maximum Parts to Query</label>
                    <input type="number" wire:model="parts_limit" min="1" max="24"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            @if($parts_mode === 'dynamic')
            <div class="p-3 rounded-lg bg-cyan-50 dark:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 text-xs text-cyan-900 dark:text-cyan-200 flex items-center gap-2">
                <x-icon name="solid:circle-info" class="w-4 h-4 shrink-0 text-cyan-600 dark:text-cyan-400" />
                <span>Dynamic Mode: Queries active products and spares from the database. If empty, falls back seamlessly to corporate production defaults.</span>
            </div>
            @endif
        </div>

        <!-- Headers -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Badge Label</label>
                    <input type="text" wire:model="parts_badge" placeholder="OEM Replacement Inventory"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Section Title</label>
                    <input type="text" wire:model="parts_title" placeholder="Genuine Spare Parts Catalog"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Section Subtitle</label>
                <input type="text" wire:model="parts_subtitle" placeholder="Traceable serial numbers with mill test certificates..."
                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
            </div>
        </div>

        <!-- Static Parts Cards Repeater -->
        @if($parts_mode === 'static')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:boxes-stacked" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Static Spare Parts Cards ({{ count($parts_static_items) }})</span>
                </div>
                <button type="button" wire:click="addStaticPart"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 transition-colors cursor-pointer flex items-center gap-1">
                    <x-icon name="solid:plus" class="w-3 h-3" />
                    <span>Add Spare Part</span>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($parts_static_items as $pIdx => $item)
                <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2 relative group">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400">Part 0{{ $pIdx + 1 }}</span>
                        <button type="button" wire:click="removeStaticPart({{ $pIdx }})"
                                class="w-5 h-5 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove Part">
                            <x-icon name="solid:xmark" class="w-3 h-3" />
                        </button>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Component Name</label>
                        <input type="text" wire:model="parts_static_items.{{ $pIdx }}.name"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Specification / Material</label>
                        <input type="text" wire:model="parts_static_items.{{ $pIdx }}.part_number"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                    </div>

                    <div class="space-y-2">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Part Icon</label>
                            <x-homepage-builder.icon-picker 
                                model="parts_static_items.{{ $pIdx }}.icon" 
                                :value="$item['icon'] ?? 'solid:gears'" 
                                label="" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Target Link Destination</label>
                            <x-homepage-builder.link-picker 
                                model="parts_static_items.{{ $pIdx }}.url" 
                                :options="$internalLinkOptions" />
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to Genuine Spare Parts section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveParts" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Spare Parts Changes</span>
            </button>
        </div>
    </div>
</div>
