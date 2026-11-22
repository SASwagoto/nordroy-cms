<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:gears" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Precision Overhaul Services Studio</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Controls service cards display mode (Static Corporate Cards vs Dynamic CMS Service Database).</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="services_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $services_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="services" />

        <!-- Mode & Limit -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:database" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Content Architecture &amp; Database Sync</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Data Mode</label>
                    <select wire:model.live="services_mode"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="static">Static Corporate Cards (6 Certified Overhaul Services)</option>
                        <option value="dynamic">Dynamic Database Sync (Services Table)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Maximum Cards to Display</label>
                    <input type="number" wire:model="services_limit" min="1" max="24"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            @if($services_mode === 'dynamic')
            <div class="p-3 rounded-lg bg-cyan-50 dark:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 text-xs text-cyan-900 dark:text-cyan-200 flex items-center gap-2">
                <x-icon name="solid:circle-info" class="w-4 h-4 shrink-0 text-cyan-600 dark:text-cyan-400" />
                <span>Dynamic Mode: Queries published services directly from your database. If the database has 0 services, the homepage gracefully renders the exact 6 corporate production overhaul cards without disruption.</span>
            </div>
            @endif
        </div>

        <!-- Section Titles -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:heading" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Section Headers</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Badge Label</label>
                    <input type="text" wire:model="services_badge" placeholder="Workshop & Port Capabilities"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Section Title</label>
                    <input type="text" wire:model="services_title" placeholder="Precision Overhaul Services"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Subtitle / Tagline</label>
                <input type="text" wire:model="services_subtitle" placeholder="Engineered according to manufacturer tolerance protocols..."
                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
            </div>
        </div>

        <!-- Static Service Cards Repeater -->
        @if($services_mode === 'static')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:rectangle-group" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Static Overhaul Service Cards ({{ count($services_static_items) }})</span>
                </div>
                <button type="button" wire:click="addStaticService"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 transition-colors cursor-pointer flex items-center gap-1">
                    <x-icon name="solid:plus" class="w-3 h-3" />
                    <span>Add Service Card</span>
                </button>
            </div>

            <div class="space-y-3">
                @foreach($services_static_items as $sIdx => $item)
                <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 relative group">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400">Service Card 0{{ $sIdx + 1 }}</span>
                        <button type="button" wire:click="removeStaticService({{ $sIdx }})"
                                class="w-5 h-5 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove Card">
                            <x-icon name="solid:xmark" class="w-3 h-3" />
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Service Title</label>
                            <input type="text" wire:model="services_static_items.{{ $sIdx }}.title"
                                   class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Category / Badge</label>
                            <input type="text" wire:model="services_static_items.{{ $sIdx }}.category"
                                   class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Icon Identifier</label>
                            <input type="text" wire:model="services_static_items.{{ $sIdx }}.icon"
                                   class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Excerpt / Description</label>
                        <textarea wire:model="services_static_items.{{ $sIdx }}.excerpt" rows="2"
                                  class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Target Link URL</label>
                        <input type="text" wire:model="services_static_items.{{ $sIdx }}.url"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to Precision Services section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveServices" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Services Changes</span>
            </button>
        </div>
    </div>
</div>
