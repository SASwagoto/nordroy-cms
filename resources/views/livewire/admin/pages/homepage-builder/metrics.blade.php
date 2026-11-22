<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:chart-pie" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Corporate Metrics &amp; Performance Counters</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">4 key numerical performance milestones proving decades of engineering dominance.</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="metrics_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $metrics_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="metrics" />

        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Stat 1 -->
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Counter 1</span>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Value / Number</label>
                        <input type="text" wire:model="metric_counter1_val" placeholder="30+"
                               class="w-full px-3 py-1.5 text-base rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Label / Title</label>
                        <input type="text" wire:model="metric_counter1_lbl" placeholder="Years of Excellence"
                               class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Counter 2</span>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Value / Number</label>
                        <input type="text" wire:model="metric_counter2_val" placeholder="1,450+"
                               class="w-full px-3 py-1.5 text-base rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Label / Title</label>
                        <input type="text" wire:model="metric_counter2_lbl" placeholder="Turbomachines Overhauled"
                               class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Counter 3</span>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Value / Number</label>
                        <input type="text" wire:model="metric_counter3_val" placeholder="12+"
                               class="w-full px-3 py-1.5 text-base rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Label / Title</label>
                        <input type="text" wire:model="metric_counter3_lbl" placeholder="Global Ports Covered"
                               class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Counter 4</span>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Value / Number</label>
                        <input type="text" wire:model="metric_counter4_val" placeholder="100%"
                               class="w-full px-3 py-1.5 text-base rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Label / Title</label>
                        <input type="text" wire:model="metric_counter4_lbl" placeholder="Calibrated Schenck Testing"
                               class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                    </div>
                </div>

            </div>
        </div>

        <!-- Dynamic Metrics Items Repeater -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:chart-pie" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Customizable Performance Counter Items ({{ count($metrics_items) }})</span>
                </div>
                <button type="button" wire:click="addMetricItem"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 transition-colors cursor-pointer flex items-center gap-1">
                    <x-icon name="solid:plus" class="w-3 h-3" />
                    <span>Add Counter</span>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($metrics_items as $mIdx => $mItem)
                <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2 relative group">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400">Counter 0{{ $mIdx + 1 }}</span>
                        <button type="button" wire:click="removeMetricItem({{ $mIdx }})"
                                class="w-5 h-5 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove Counter">
                            <x-icon name="solid:xmark" class="w-3 h-3" />
                        </button>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Milestone Value</label>
                        <input type="text" wire:model="metrics_items.{{ $mIdx }}.value"
                               class="w-full px-2.5 py-1 text-sm rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-black text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Milestone Label</label>
                        <input type="text" wire:model="metrics_items.{{ $mIdx }}.label"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Icon Identifier</label>
                        <input type="text" wire:model="metrics_items.{{ $mIdx }}.icon"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to Metrics Counters section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveMetrics" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Metrics Changes</span>
            </button>
        </div>
    </div>
</div>
