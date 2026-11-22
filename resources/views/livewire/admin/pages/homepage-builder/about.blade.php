<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:building-columns" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Corporate Heritage &amp; Strategic Pillars</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Executive overview, 3 strategic pillars, and leadership technical quote box.</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="about_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $about_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="about" />

        <!-- Header Text & Description -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:heading" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Section Headlines</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Badge Label</label>
                    <input type="text" wire:model="about_badge" placeholder="Conglomerate Heritage & Vision"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Main Title / Headline</label>
                    <input type="text" wire:model="about_title" placeholder="A Heritage of Heavy Industrial Power..."
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Detailed Corporate Narrative</label>
                <textarea wire:model="about_description" rows="3"
                          class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium"></textarea>
            </div>
        </div>

        <!-- 3 Strategic Pillars -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:cubes-stacked" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">3 Strategic Pillars</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Pillar 1 -->
                <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Pillar 1</span>
                        <div class="flex items-center gap-1 cursor-pointer text-cyan-600 dark:text-cyan-400 text-[10px] font-bold"
                             @click="$dispatch('open-icon-picker', { targetField: 'about_p1_icon' })">
                            <x-icon :name="$about_p1_icon ?: 'solid:anchor'" class="w-3.5 h-3.5" />
                            <span>Pick Icon</span>
                        </div>
                    </div>
                    <input type="text" wire:model="about_p1_title" placeholder="Pillar Title"
                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                    <textarea wire:model="about_p1_desc" rows="2" placeholder="Description"
                              class="w-full px-2.5 py-1.5 text-[11px] rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300"></textarea>
                </div>

                <!-- Pillar 2 -->
                <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Pillar 2</span>
                        <div class="flex items-center gap-1 cursor-pointer text-cyan-600 dark:text-cyan-400 text-[10px] font-bold"
                             @click="$dispatch('open-icon-picker', { targetField: 'about_p2_icon' })">
                            <x-icon :name="$about_p2_icon ?: 'solid:gauge-high'" class="w-3.5 h-3.5" />
                            <span>Pick Icon</span>
                        </div>
                    </div>
                    <input type="text" wire:model="about_p2_title" placeholder="Pillar Title"
                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                    <textarea wire:model="about_p2_desc" rows="2" placeholder="Description"
                              class="w-full px-2.5 py-1.5 text-[11px] rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300"></textarea>
                </div>

                <!-- Pillar 3 -->
                <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Pillar 3</span>
                        <div class="flex items-center gap-1 cursor-pointer text-cyan-600 dark:text-cyan-400 text-[10px] font-bold"
                             @click="$dispatch('open-icon-picker', { targetField: 'about_p3_icon' })">
                            <x-icon :name="$about_p3_icon ?: 'solid:certificate'" class="w-3.5 h-3.5" />
                            <span>Pick Icon</span>
                        </div>
                    </div>
                    <input type="text" wire:model="about_p3_title" placeholder="Pillar Title"
                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                    <textarea wire:model="about_p3_desc" rows="2" placeholder="Description"
                              class="w-full px-2.5 py-1.5 text-[11px] rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300"></textarea>
                </div>
            </div>
        </div>

        <!-- Executive Leadership Quote Box -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:quote-left" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Executive Quote Card</span>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Quote Text</label>
                <textarea wire:model="about_quote_text" rows="2"
                          class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="space-y-1">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Author Name</label>
                    <input type="text" wire:model="about_quote_author" placeholder="Technical Operations"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Department / Role</label>
                    <input type="text" wire:model="about_quote_role" placeholder="Turbomachinery Overhaul Division"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Badge / Initials</label>
                    <input type="text" wire:model="about_quote_initials" placeholder="NR"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white font-bold text-center">
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to Corporate Heritage section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveAbout" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save About Us Changes</span>
            </button>
        </div>
    </div>
</div>
