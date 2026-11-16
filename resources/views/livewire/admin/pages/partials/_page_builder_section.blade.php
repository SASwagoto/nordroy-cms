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
                    <span class="px-2 py-0.5 text-[9px] font-mono font-bold uppercase rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        {{ $currentSectionLayout['width'] ?? 'container-xl' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Universal layout engine, CSS3 background surfaces, box model, and section styling</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" wire:click="toggleSectionStatus('{{ $selectedSectionId }}')"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border transition-colors flex items-center gap-1.5 bg-slate-100 border-slate-300 text-slate-700 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300">
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
        <button type="button" wire:click="$set('activeSectionTab', 'layout')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 {{ $activeSectionTab === 'layout' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
            <x-icon name="solid:layer-group" class="w-3.5 h-3.5" />
            <span>Universal Layout &amp; Surface</span>
        </button>

        <button type="button" wire:click="$set('activeSectionTab', 'title')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 {{ $activeSectionTab === 'title' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
            <x-icon name="solid:heading" class="w-3.5 h-3.5" />
            <span>Title, Subtitle &amp; Badge</span>
        </button>

        <button type="button" wire:click="$set('activeSectionTab', 'content')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 {{ $activeSectionTab === 'content' ? 'bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
            <x-icon name="solid:cube" class="w-3.5 h-3.5" />
            <span>Section Content &amp; Feeds</span>
        </button>
    </div>

    <!-- TAB 1: UNIVERSAL LAYOUT & SURFACE ENGINE -->
    @if ($activeSectionTab === 'layout')
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

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Base Text Color</label>
                        <input type="text" wire:model.live="currentSectionLayout.text_color" placeholder="#0f172a" class="w-full px-3 py-2 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>

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
                                <input type="text" wire:model.live="currentSectionLayout.gradient_stop1" placeholder="#f8fafc" class="w-full px-2 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Color Stop 2</label>
                                <input type="text" wire:model.live="currentSectionLayout.gradient_stop2" placeholder="#e2e8f0" class="w-full px-2 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
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
                            <input type="text" wire:model.live="currentSectionLayout.border_color" placeholder="#e2e8f0" class="w-full px-2 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
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

    <!-- TAB 2: TITLE, SUBTITLE & BADGE -->
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
                            <input type="text" wire:model.live="currentSectionTitleSettings.badge_icon" placeholder="sparkles, shield-check, award" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Badge Text / Suffix</label>
                            <input type="text" wire:model.live="currentSectionTitleSettings.badge_text" placeholder="Featured Services" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                    </div>
                @endif
            </div>
        </div>

    <!-- TAB 3: CONTENT & FEEDS -->
    @elseif ($activeSectionTab === 'content')
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                    <x-icon name="solid:cube" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span>Dynamic Feed &amp; Items Repeater</span>
                </span>
            </div>

            <!-- Dynamic Model Feeds (If Grid or Slider) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Content Feed Source</label>
                    <select wire:model.live="currentSectionContent.source_type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        <option value="model">Dynamic Corporate Model</option>
                        <option value="manual">Custom Repeater Cards</option>
                    </select>
                </div>

                @if (($currentSectionContent['source_type'] ?? 'model') === 'model')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Target Model</label>
                        <select wire:model.live="currentSectionContent.model" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            <option value="services">Marine Services Catalog</option>
                            <option value="divisions">Business Units / Divisions</option>
                            <option value="projects">Drydock Project Cases</option>
                            <option value="leadership">Executive Leadership</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Display Limit</label>
                        <input type="number" wire:model.live="currentSectionContent.limit" min="1" max="24" class="w-full px-3 py-2 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                @endif
            </div>

            <!-- Call to Action Button -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Section CTA Button Label</label>
                    <input type="text" wire:model.live="currentSectionContent.cta_label" placeholder="View All Services" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Button Destination URL</label>
                    <input type="text" wire:model.live="currentSectionContent.cta_url" placeholder="/services" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                </div>
            </div>
        </div>
    @endif
</div>
