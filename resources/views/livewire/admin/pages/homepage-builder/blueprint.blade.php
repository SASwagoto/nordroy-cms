<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:compass-drafting" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Corporate Blueprint (Mission, Vision &amp; Values)</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Mission, Vision 2030, and Core Values corporate framework cards.</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="blueprint_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $blueprint_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="blueprint" />

        <!-- Headers -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Badge Label</label>
                    <input type="text" wire:model="blueprint_badge" placeholder="Corporate Blueprint"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Title</label>
                    <input type="text" wire:model="blueprint_title" placeholder="Mission, Vision & Core Values"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Subtitle</label>
                <input type="text" wire:model="blueprint_subtitle" placeholder="Guiding principles that define our commitment..."
                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
            </div>
        </div>

        <!-- 3 Cards: Mission, Vision, Core Values -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1: Mission -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Card 1: Mission</span>
                    <button type="button" @click="$dispatch('open-icon-picker', { targetField: 'blueprint_mission_icon' })"
                            class="inline-flex items-center gap-1 text-[11px] font-bold text-cyan-600 dark:text-cyan-400 cursor-pointer">
                        <x-icon :name="$blueprint_mission_icon ?: 'solid:bullseye'" class="w-3.5 h-3.5" />
                        <span>Icon</span>
                    </button>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Title</label>
                    <input type="text" wire:model="blueprint_mission_title" placeholder="Our Mission"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Description</label>
                    <textarea wire:model="blueprint_mission_desc" rows="5"
                              class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300"></textarea>
                </div>
            </div>

            <!-- Card 2: Vision -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Card 2: Vision</span>
                    <button type="button" @click="$dispatch('open-icon-picker', { targetField: 'blueprint_vision_icon' })"
                            class="inline-flex items-center gap-1 text-[11px] font-bold text-cyan-600 dark:text-cyan-400 cursor-pointer">
                        <x-icon :name="$blueprint_vision_icon ?: 'solid:eye'" class="w-3.5 h-3.5" />
                        <span>Icon</span>
                    </button>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Title</label>
                    <input type="text" wire:model="blueprint_vision_title" placeholder="Our Vision 2030"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Description</label>
                    <textarea wire:model="blueprint_vision_desc" rows="5"
                              class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300"></textarea>
                </div>
            </div>

            <!-- Card 3: Core Values -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Card 3: Values</span>
                    <button type="button" @click="$dispatch('open-icon-picker', { targetField: 'blueprint_values_icon' })"
                            class="inline-flex items-center gap-1 text-[11px] font-bold text-cyan-600 dark:text-cyan-400 cursor-pointer">
                        <x-icon :name="$blueprint_values_icon ?: 'solid:shield-halved'" class="w-3.5 h-3.5" />
                        <span>Icon</span>
                    </button>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Title</label>
                    <input type="text" wire:model="blueprint_values_title" placeholder="Core Values"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Values List (3 Strategic Bullet Items)</label>
                    <input type="text" wire:model="blueprint_value1" placeholder="Zero-Defect Quality..."
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white mb-1.5">
                    <input type="text" wire:model="blueprint_value2" placeholder="Rapid Port Agility..."
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white mb-1.5">
                    <input type="text" wire:model="blueprint_value3" placeholder="Technical Rigor..."
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                </div>
            </div>

        </div>

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to Corporate Blueprint section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveBlueprint" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Blueprint Changes</span>
            </button>
        </div>
    </div>
</div>
