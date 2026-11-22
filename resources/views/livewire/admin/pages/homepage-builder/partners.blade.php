<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:handshake" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">OEM Brand Partners Marquee Ticker</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Continuous flowing ticker displaying authorized OEM marine turbomachinery partner brands.</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="partners_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $partners_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="partners" />

        <!-- Mode & Ticker Dynamics -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:sliders" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Data Mode &amp; Ticker Dynamics</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Data Mode -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Content Source Mode</label>
                    <select wire:model.live="partners_mode"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="static">Static Corporate Partners List</option>
                        <option value="dynamic">Dynamic Database Brands (Brands Table)</option>
                    </select>
                </div>

                <!-- Ticker Speed -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Marquee Flow Speed</label>
                    <select wire:model.live="partners_speed"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="slow">Slow &amp; Subtle (48s duration)</option>
                        <option value="normal">Standard Flow (32s duration - Default)</option>
                        <option value="fast">Rapid Flow (18s duration)</option>
                    </select>
                </div>

                <!-- Background Style -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Background Styling</label>
                    <select wire:model.live="partners_bg_style"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="theme_default">Theme Default (Light Gray / Navy 950)</option>
                        <option value="clean_white">Pure Contrast (White / Jet Black)</option>
                        <option value="transparent">Transparent Glass</option>
                    </select>
                </div>
            </div>

            @if($partners_mode === 'dynamic')
            <div class="p-3 rounded-lg bg-cyan-50 dark:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 text-xs text-cyan-900 dark:text-cyan-200 flex items-center gap-2">
                <x-icon name="solid:circle-info" class="w-4 h-4 shrink-0 text-cyan-600 dark:text-cyan-400" />
                <span>Dynamic Mode: Renders all active brands stored in your CMS Brand database table. If the database table is empty, it automatically falls back to corporate production defaults.</span>
            </div>
            @endif
        </div>

        <!-- Tagline & Brands Content -->
        <div class="space-y-4">
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Top Tagline / Subtitle</label>
                <input type="text" wire:model="partners_tagline" placeholder="Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms"
                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">
                    OEM Partner Brands (Comma Separated List)
                </label>
                <textarea wire:model="partners_brands_list" rows="3"
                          placeholder="Accelleron (ABB), MAN Energy Solutions, KBB Kompressorenbau, Napier Turbochargers..."
                          class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium"></textarea>
                <p class="text-[10px] text-slate-500 dark:text-slate-400">Brands appear in the animated endless ticker tape across both desktop and mobile viewports.</p>
            </div>
        </div>

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to the OEM Brand Partners section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="savePartners" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Partners Changes</span>
            </button>
        </div>
    </div>
</div>
