<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:film" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Marine Video Window Break</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Atmospheric video background window break showcasing rapid port emergency flying squads.</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="video_break_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $video_break_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- Universal Section Styler Component -->
        <x-homepage-builder.section-styler prefix="video_break" />

        <!-- Headlines -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:heading" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Break Banner Content</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Badge Label</label>
                    <input type="text" wire:model="video_break_badge" placeholder="Global Marine Engineering Excellence"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Heading Title</label>
                    <input type="text" wire:model="video_break_heading" placeholder="24/7 Rapid Emergency Response Across 40+ International Ports"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Subtitle Description</label>
                <textarea wire:model="video_break_subtitle" rows="2"
                          class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium"></textarea>
            </div>
        </div>

        <!-- Action CTAs -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:bolt" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Action Buttons &amp; Route Destinations</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- CTA 1 -->
                <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Primary Button</span>
                    <input type="text" wire:model="video_break_cta1_text" placeholder="View Overhaul Capabilities →"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                    <div class="space-y-1">
                        <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">Link Destination</label>
                        <select wire:model.live="video_break_cta1_url"
                                class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                            @foreach($internalLinkOptions as $cat => $routes)
                                <optgroup label="{{ $cat }}">
                                    @foreach($routes as $url => $label)
                                        <option value="{{ $url }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- CTA 2 -->
                <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 uppercase">Secondary Button</span>
                    <input type="text" wire:model="video_break_cta2_text" placeholder="Contact Port Operations"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
                    <div class="space-y-1">
                        <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">Link Destination</label>
                        <select wire:model.live="video_break_cta2_url"
                                class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                            @foreach($internalLinkOptions as $cat => $routes)
                                <optgroup label="{{ $cat }}">
                                    @foreach($routes as $url => $label)
                                        <option value="{{ $url }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to Marine Video Break section.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveVideoBreak" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Video Break Changes</span>
            </button>
        </div>
    </div>
</div>
