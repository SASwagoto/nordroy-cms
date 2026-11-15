<div>
    <x-slot:header>Theme Studio</x-slot:header>

    <!-- 100% Self-Hosted Local Fonts (Zero CDN Dependency) -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Design System Architecture</span>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white mt-0.5">Corporate Theme & Visual Tokens</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">Granular control over global colors, typography, buttons, layout width, and header styling.</p>
        </div>

        <!-- Publish Button -->
        <button wire:click="saveThemeTokens" 
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center h-10 px-6 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm active:scale-95 transition-all cursor-pointer disabled:opacity-60 disabled:cursor-wait shrink-0 self-start sm:self-auto">
            
            <span wire:loading.remove wire:target="saveThemeTokens" class="inline-flex items-center gap-2 whitespace-nowrap">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Publish Theme Tokens</span>
            </span>

            <span wire:loading.inline-flex wire:target="saveThemeTokens" class="items-center justify-center gap-2 whitespace-nowrap" style="display: none;">
                <svg class="animate-spin h-3.5 w-3.5 text-current shrink-0" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Publishing Tokens...</span>
            </span>
        </button>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500" />
                <span>{{ session('message') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start" 
         x-data="{ 
             canvasDark: false,
             headerBgColorState: @js(\App\Services\SmartColorHelper::normalize($headerBgColor)),
             headerTextColorState: @js(\App\Services\SmartColorHelper::normalize($headerTextColor, '#0f172a', '#ffffff')),
             topbarBgColorState: @js(\App\Services\SmartColorHelper::normalize($topbarBgColor)),
             topbarTextColorState: @js(\App\Services\SmartColorHelper::normalize($topbarTextColor, '#334155', '#cbd5e1')),
             headerBottomBgState: @js(\App\Services\SmartColorHelper::normalize($headerBottom['bg_color'] ?? null, '#f8fafc', '#061320')),
             headerBottomTextState: @js(\App\Services\SmartColorHelper::normalize($headerBottom['text_color'] ?? null, '#475569', '#94a3b8')),
             footerTopBgState: @js(\App\Services\SmartColorHelper::normalize($footerTop['bg_color'] ?? null, '#003C58', '#061a28')),
             footerTopTextState: @js(\App\Services\SmartColorHelper::normalize($footerTop['text_color'] ?? null, '#ffffff', '#f1f5f9')),
             footerBgColorState: @js(\App\Services\SmartColorHelper::normalize($footerBgColor, '#f1f5f9', '#040e17')),
             footerTextColorState: @js(\App\Services\SmartColorHelper::normalize($footerTextColor, '#334155', '#cbd5e1')),

             computeSmartBg(cfg, isDark, fallbackTheme) {
                 if (!cfg || cfg.mode !== 'custom') {
                     return fallbackTheme;
                 }
                 const type = cfg.type || 'solid';
                 if (type === 'gradient' && cfg.gradient) {
                     const dir = cfg.gradient.direction || '135deg';
                     const from = isDark ? (cfg.gradient.dark_from || cfg.dark || '#07131e') : (cfg.gradient.light_from || cfg.light || '#ffffff');
                     const to = isDark ? (cfg.gradient.dark_to || '#0c1e30') : (cfg.gradient.light_to || '#f1f5f9');
                     return `linear-gradient(${dir}, ${from}, ${to})`;
                 }
                 if (type === 'glass' && cfg.glass) {
                     const op = (cfg.glass.opacity !== undefined ? cfg.glass.opacity : 80) / 100;
                     const color = isDark ? (cfg.dark || '#07131e') : (cfg.light || '#ffffff');
                     return window.nordroyHexToRgba ? window.nordroyHexToRgba(color, op) : color;
                 }
                 const op = (cfg.opacity !== undefined ? cfg.opacity : 100) / 100;
                 const color = isDark ? (cfg.dark || '#07131e') : (cfg.light || '#ffffff');
                 return window.nordroyHexToRgba ? window.nordroyHexToRgba(color, op) : color;
             },

             computeSmartText(cfg, isDark, fallbackTheme) {
                 if (!cfg || cfg.mode !== 'custom') {
                     return fallbackTheme;
                 }
                 return isDark ? (cfg.dark || '#ffffff') : (cfg.light || '#0f172a');
             },

             getTopbarPreviewBg() {
                 const fallback = this.canvasDark ? 'rgba(5, 15, 24, 0.95)' : 'rgba(255, 255, 255, 0.95)';
                 return this.computeSmartBg(this.topbarBgColorState, this.canvasDark, fallback);
             },
             getTopbarPreviewText() {
                 const fallback = this.canvasDark ? '#cbd5e1' : '#475569';
                 return this.computeSmartText(this.topbarTextColorState, this.canvasDark, fallback);
             },
             getHeaderPreviewBg() {
                 const style = ($wire && $wire.theme) ? ($wire.theme.theme_header_style || 'glass') : '{{ $theme['theme_header_style'] ?? 'glass' }}';
                 const primary = ($wire && $wire.theme) ? ($wire.theme.theme_primary_color || '#003C58') : '{{ $theme['theme_primary_color'] ?? '#003C58' }}';
                 let fallback = 'rgba(255, 255, 255, 0.85)';
                 if (style === 'solid') fallback = primary;
                 else if (style === 'transparent') fallback = 'transparent';
                 else if (style === 'floating') fallback = this.canvasDark ? 'rgba(11, 27, 43, 0.92)' : 'rgba(255, 255, 255, 0.92)';
                 else fallback = this.canvasDark ? 'rgba(7, 19, 30, 0.85)' : 'rgba(255, 255, 255, 0.85)';

                 return this.computeSmartBg(this.headerBgColorState, this.canvasDark, fallback);
             },
             getHeaderTitleColor() {
                 const style = ($wire && $wire.theme) ? ($wire.theme.theme_header_style || 'glass') : '{{ $theme['theme_header_style'] ?? 'glass' }}';
                 const fallback = (this.canvasDark || style === 'solid') ? '#ffffff' : (($wire && $wire.theme) ? ($wire.theme.theme_primary_color || '#003C58') : '{{ $theme['theme_primary_color'] ?? '#003C58' }}');
                 return this.computeSmartText(this.headerTextColorState, this.canvasDark, fallback);
             },
             getHeaderNavTextColor() {
                 const fallback = this.canvasDark ? '#cbd5e1' : '#334155';
                 return this.computeSmartText(this.headerTextColorState, this.canvasDark, fallback);
             },
             getHeaderBottomPreviewBg() {
                 const fallback = this.canvasDark ? 'rgba(6, 19, 32, 0.95)' : 'rgba(248, 250, 252, 0.95)';
                 return this.computeSmartBg(this.headerBottomBgState, this.canvasDark, fallback);
             },
             getHeaderBottomPreviewText() {
                 const fallback = this.canvasDark ? '#94a3b8' : '#475569';
                 return this.computeSmartText(this.headerBottomTextState, this.canvasDark, fallback);
             },
             getFooterTopPreviewBg() {
                 const fallback = this.canvasDark ? '#061a28' : '#003C58';
                 return this.computeSmartBg(this.footerTopBgState, this.canvasDark, fallback);
             },
             getFooterTopPreviewText() {
                 const fallback = this.canvasDark ? '#f1f5f9' : '#ffffff';
                 return this.computeSmartText(this.footerTopTextState, this.canvasDark, fallback);
             },
             getFooterPreviewBg() {
                 const fallback = this.canvasDark ? 'rgba(4, 14, 23, 0.95)' : 'rgba(241, 245, 249, 0.95)';
                 return this.computeSmartBg(this.footerBgColorState, this.canvasDark, fallback);
             },
             getFooterPreviewText() {
                 const fallback = this.canvasDark ? '#cbd5e1' : '#475569';
                 return this.computeSmartText(this.footerTextColorState, this.canvasDark, fallback);
             }
         }"
         @smart-color-changed.window="
             const m = $event.detail.model;
             const c = $event.detail.color;
             if (m === 'headerBgColor') headerBgColorState = c;
             else if (m === 'headerTextColor') headerTextColorState = c;
             else if (m === 'topbarBgColor' || m === 'headerTopbar.bg_color') topbarBgColorState = c;
             else if (m === 'topbarTextColor' || m === 'headerTopbar.text_color') topbarTextColorState = c;
             else if (m === 'headerBottom.bg_color') headerBottomBgState = c;
             else if (m === 'headerBottom.text_color') headerBottomTextState = c;
             else if (m === 'footerTop.bg_color') footerTopBgState = c;
             else if (m === 'footerTop.text_color') footerTopTextState = c;
             else if (m === 'footerBgColor') footerBgColorState = c;
             else if (m === 'footerTextColor') footerTextColorState = c;
         "
    >
        
        <!-- LEFT COLUMN: Navigation Tabs + Controls (7 cols) -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Quick Presets Shelf (8 Curated Industrial Palettes) -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Instant Corporate Presets</span>
                    <span class="text-[10px] text-slate-400">Click to apply palette & typography</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    @foreach($presets as $key => $preset)
                        <button type="button" wire:click="applyPreset('{{ $key }}')"
                            class="p-2.5 rounded-xl border text-left transition-all cursor-pointer group bg-slate-50/50 dark:bg-slate-950/40 relative {{ ($theme['theme_primary_color'] ?? '') === $preset['primary'] ? 'border-[#003C58] dark:border-cyan-400 ring-2 ring-[#003C58]/20 dark:ring-cyan-400/20' : 'border-slate-200 dark:border-slate-800 hover:border-[#003C58] dark:hover:border-cyan-400' }}">
                            
                            <div class="flex items-center gap-1.5 mb-2">
                                <span class="w-3.5 h-3.5 rounded-full border border-slate-300 dark:border-slate-700 shadow-xs shrink-0" style="background-color: {{ $preset['primary'] }}"></span>
                                <span class="w-3.5 h-3.5 rounded-full border border-slate-300 dark:border-slate-700 shadow-xs shrink-0" style="background-color: {{ $preset['secondary'] }}"></span>
                                <span class="w-3.5 h-3.5 rounded-full border border-slate-300 dark:border-slate-700 shadow-xs shrink-0" style="background-color: {{ $preset['accent'] }}"></span>
                            </div>
                            <p class="text-[11px] font-bold text-slate-800 dark:text-white truncate group-hover:text-[#003C58] dark:group-hover:text-cyan-400">{{ $preset['name'] }}</p>
                            <span class="text-[9px] text-slate-400 block truncate mt-0.5">{{ $preset['font_head'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Granular Studio Tabs -->
            <div class="flex items-center gap-1 overflow-x-auto no-scrollbar p-1 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
                <button wire:click="setTab('colors')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'colors' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Colors
                </button>
                <button wire:click="setTab('typography')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'typography' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Fonts &amp; Text
                </button>
                <button wire:click="setTab('buttons')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'buttons' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Buttons
                </button>
                <button wire:click="setTab('cards')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'cards' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Cards
                </button>
                <button wire:click="setTab('header')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'header' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Header &amp; Topbar
                </button>
                <button wire:click="setTab('footer')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'footer' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Footer Studio
                </button>
                <button wire:click="setTab('layout')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'layout' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    Layout &amp; Box Model
                </button>
                <button wire:click="setTab('background')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors cursor-pointer shrink-0 {{ $activeTab === 'background' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white' }}">
                    <span class="inline-flex items-center gap-1.5">
                        <x-icon name="solid:video" class="w-3.5 h-3.5" />
                        <span>Background Video</span>
                    </span>
                </button>
            </div>

            <!-- TAB 1: COLORS -->
            @if($activeTab === 'colors')
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Brand Colors &amp; Appearance</h3>

                    <!-- Primary -->
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-white">Primary Brand Color (Main Color)</label>
                            <p class="text-[11px] text-slate-400">Used for main buttons, header, active menu links, and important highlights.</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="color" wire:model.live="theme.theme_primary_color" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent" />
                            <input type="text" wire:model.live="theme.theme_primary_color" class="w-24 px-2.5 py-1 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 uppercase" />
                        </div>
                    </div>

                    <!-- Secondary -->
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-white">Secondary Slate Color</label>
                            <p class="text-[11px] text-slate-400">Used for technical labels, subtle borders, and secondary buttons.</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="color" wire:model.live="theme.theme_secondary_color" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent" />
                            <input type="text" wire:model.live="theme.theme_secondary_color" class="w-24 px-2.5 py-1 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 uppercase" />
                        </div>
                    </div>

                    <!-- Accent -->
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-white">Accent Highlight Color (Badges &amp; CTA)</label>
                            <p class="text-[11px] text-slate-400">Used for badges, status indicators, glowing dots, and special action buttons.</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="color" wire:model.live="theme.theme_accent_color" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent" />
                            <input type="text" wire:model.live="theme.theme_accent_color" class="w-24 px-2.5 py-1 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 uppercase" />
                        </div>
                    </div>

                    <!-- Light Surface -->
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-white">Page Background (Light Mode)</label>
                            <p class="text-[11px] text-slate-400">The clean background tone for daylight mode.</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="color" wire:model.live="theme.theme_surface_light" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent" />
                            <input type="text" wire:model.live="theme.theme_surface_light" class="w-24 px-2.5 py-1 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 uppercase" />
                        </div>
                    </div>

                    <!-- Dark Surface -->
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-white">Page Background (Dark Mode)</label>
                            <p class="text-[11px] text-slate-400">Deep corporate ocean tone used for dark cards &amp; night mode.</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="color" wire:model.live="theme.theme_surface_dark" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent" />
                            <input type="text" wire:model.live="theme.theme_surface_dark" class="w-24 px-2.5 py-1 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 uppercase" />
                        </div>
                    </div>

                    <!-- Border Color -->
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-white">Borders &amp; Separator Lines</label>
                            <p class="text-[11px] text-slate-400">Subtle container outlines, table borders, and divider lines.</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="color" wire:model.live="theme.theme_border_color" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent" />
                            <input type="text" wire:model.live="theme.theme_border_color" class="w-24 px-2.5 py-1 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 uppercase" />
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: TYPOGRAPHY -->
            @if($activeTab === 'typography')
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Website Fonts &amp; Typography</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Heading Font Family (Titles)</label>
                            <select wire:model.live="theme.theme_heading_font" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="Plus Jakarta Sans">Plus Jakarta Sans (Nordic Modern - Recommended)</option>
                                <option value="Inter">Inter (Ultra Precision Clean)</option>
                                <option value="Outfit">Outfit (Bold Industrial)</option>
                                <option value="Montserrat">Montserrat (Corporate Prestige - Dana Group style)</option>
                                <option value="Space Grotesk">Space Grotesk (High-Tech Architectural)</option>
                                <option value="Syne">Syne (Heavy Impact Editorial)</option>
                                <option value="DM Sans">DM Sans (Humanist Corporate)</option>
                                <option value="Manrope">Manrope (Clean Minimalist)</option>
                                <option value="Poppins">Poppins (Geometric Display)</option>
                                <option value="Roboto">Roboto (Classic Standard)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Body Text Font Family (Paragraphs)</label>
                            <select wire:model.live="theme.theme_body_font" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="Plus Jakarta Sans">Plus Jakarta Sans (Recommended)</option>
                                <option value="Inter">Inter (Great for data &amp; tables)</option>
                                <option value="Outfit">Outfit</option>
                                <option value="DM Sans">DM Sans</option>
                                <option value="Manrope">Manrope</option>
                                <option value="Poppins">Poppins</option>
                                <option value="Roboto">Roboto</option>
                                <option value="system-ui">System Default (Native UI)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Heading Thickness (Boldness)</label>
                            <select wire:model.live="theme.theme_heading_weight" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="600">Semi-Bold (600)</option>
                                <option value="700">Bold (700)</option>
                                <option value="800">Extra Bold (800 - Standard)</option>
                                <option value="900">Black / Heavy Industrial (900)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Letter Spacing (Tracking)</label>
                            <select wire:model.live="theme.theme_letter_spacing" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="-0.03em">Tight (-0.03em)</option>
                                <option value="-0.015em">Normal Tight (-0.015em)</option>
                                <option value="0em">Standard (0em)</option>
                                <option value="0.05em">Wide Lettering (0.05em)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Base Body Text Size</label>
                            <select wire:model.live="theme.theme_base_font_size" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="14px">Compact (14px)</option>
                                <option value="15px">Refined (15px)</option>
                                <option value="16px">Standard Web (16px - Recommended)</option>
                                <option value="18px">Large &amp; Easy to Read (18px)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Line Height (Spacing between lines)</label>
                            <select wire:model.live="theme.theme_line_height" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="1.4">Tight (1.4)</option>
                                <option value="1.6">Balanced Modern (1.6 - Standard)</option>
                                <option value="1.75">Relaxed Reading (1.75)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Live Font Specimen Box -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2 mt-3">
                        <div class="flex items-center justify-between text-[10px] text-slate-400 font-mono">
                            <span>Specimen: <strong class="text-slate-700 dark:text-slate-200">{{ $theme['theme_heading_font'] }}</strong></span>
                            <span>Weight: {{ $theme['theme_heading_weight'] }}</span>
                        </div>
                        <div class="text-2xl sm:text-3xl text-slate-900 dark:text-white transition-all"
                             style="font-family: '{{ $theme['theme_heading_font'] }}', sans-serif; font-weight: {{ $theme['theme_heading_weight'] }}; letter-spacing: {{ $theme['theme_letter_spacing'] }};">
                            NORDROY PRECISION
                        </div>
                        <div class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed transition-all"
                             style="font-family: '{{ $theme['theme_body_font'] }}', sans-serif; font-size: {{ $theme['theme_base_font_size'] ?? '16px' }}; line-height: {{ $theme['theme_line_height'] ?? '1.6' }};">
                            ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz 0123456789
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 3: BUTTONS -->
            @if($activeTab === 'buttons')
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Button Shapes &amp; Styles</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Button Corner Shape</label>
                            <select wire:model.live="theme.theme_button_radius" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="0px">Sharp Corners (0px)</option>
                                <option value="4px">Slightly Rounded (4px)</option>
                                <option value="8px">Balanced Modern (8px)</option>
                                <option value="12px">Corporate Rounded (12px - Recommended)</option>
                                <option value="16px">Extra Rounded (16px)</option>
                                <option value="9999px">Full Pill (Pill Shaped)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Button Fill Style</label>
                            <select wire:model.live="theme.theme_button_style" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="solid">Solid Brand Color</option>
                                <option value="gradient">Subtle Gradient Fill</option>
                                <option value="outline_bold">Clean Outline Border</option>
                                <option value="soft_tint">Soft Tinted Fill</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Button Hover Animation</label>
                            <select wire:model.live="theme.theme_button_hover" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="lift">Lift Slightly Up (-2px)</option>
                                <option value="glow">Subtle Brand Glow</option>
                                <option value="scale">Slight Scale (1.03x)</option>
                                <option value="none">Flat Color Change Only</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 4: CARDS & SURFACES -->
            @if($activeTab === 'cards')
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Content Cards &amp; Elevation</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Card Shadow Elevation</label>
                            <select wire:model.live="theme.theme_card_shadow" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="none">Flat (No Shadow)</option>
                                <option value="shadow-sm">Subtle Soft Shadow (shadow-sm - Recommended)</option>
                                <option value="shadow-md">Medium Elevation (shadow-md)</option>
                                <option value="shadow-lg">Elevated Floating (shadow-lg)</option>
                                <option value="glow">Subtle Brand Glow</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Card Border Style</label>
                            <select wire:model.live="theme.theme_card_border" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="subtle">Subtle Line on All Sides (Recommended)</option>
                                <option value="accent_top">Brand Color Accent Bar on Top</option>
                                <option value="none">Clean Borderless</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Card Corner Roundness</label>
                            <select wire:model.live="theme.theme_card_radius" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                <option value="0px">Sharp (0px)</option>
                                <option value="8px">Compact (8px)</option>
                                <option value="12px">Modern (12px)</option>
                                <option value="16px">Generous (16px - Standard)</option>
                                <option value="24px">Extra Rounded (24px)</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 5: HEADER & NAVIGATION BUILDER -->
            @if($activeTab === 'header')
                <div class="space-y-6">

                    <!-- Shortcut Banner to Dedicated Header & Footer Builder -->
                    <div class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-r from-[#003C58]/10 via-cyan-500/10 to-transparent border border-[#003C58]/20 dark:border-cyan-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <x-icon name="solid:compass-drafting" class="w-4 h-4 text-[#003C58] dark:text-cyan-400 shrink-0" />
                            <div>
                                <strong class="block text-xs text-slate-800 dark:text-white font-bold">Dedicated Visual Header &amp; Footer Builder Available</strong>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">Design multi-row headers and footers with independent box models in a dedicated studio.</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.header-footer') }}" wire:navigate
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs text-white shrink-0 shadow-2xs transition-all">
                            <span>Open Dedicated Builder &rarr;</span>
                        </a>
                    </div>

                    <!-- SECTION 1: TOP EMERGENCY & INFORMATION STRIP -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Top Emergency &amp; Information Strip</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Customizable utility strip for 24/7 hotline, email, dynamic social icons, and custom portal links</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="headerTopbar.enabled" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>

                        @if(!empty($headerTopbar['enabled']))
                            <!-- Badge & Tagline -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">Emergency Badge / Headline</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-[10px] font-semibold text-slate-500">
                                            <input type="checkbox" wire:model.live="headerTopbar.show_badge" value="1" class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0">
                                            <span>Show</span>
                                        </label>
                                    </div>
                                    <input type="text" wire:model.live="headerTopbar.badge_text" placeholder="24/7 Port Call &amp; Emergency Squads"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Subtext / Service Tagline</label>
                                    <input type="text" wire:model.live="headerTopbar.subtext" placeholder="Authorized Multi-Brand Turbocharger Engineering"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                </div>
                            </div>

                            <!-- Phone & Email Overrides with Show Toggles -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">Hotline Phone Override</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-[10px] font-semibold text-slate-500">
                                            <input type="checkbox" wire:model.live="headerTopbar.show_phone" value="1" class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0">
                                            <span>Show</span>
                                        </label>
                                    </div>
                                    <input type="text" wire:model.live="headerTopbar.phone" placeholder="Default: {{ \App\Models\Setting::get('contact_phone', '+880 1800-000000') }}"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                    <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to use Global Settings contact phone.</span>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">Duty Email Override</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-[10px] font-semibold text-slate-500">
                                            <input type="checkbox" wire:model.live="headerTopbar.show_email" value="1" class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0">
                                            <span>Show</span>
                                        </label>
                                    </div>
                                    <input type="text" wire:model.live="headerTopbar.email" placeholder="Default: {{ \App\Models\Setting::get('contact_email', 'operations@nordroy.com') }}"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                    <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to use Global Settings duty email.</span>
                                </div>
                            </div>

                            <!-- Social Icons & Custom Link -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">Dynamic Social Media Icons</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-[10px] font-semibold text-slate-500">
                                            <input type="checkbox" wire:model.live="headerTopbar.show_social" value="1" class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0">
                                            <span>Show</span>
                                        </label>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                        Dynamically renders brand icons (LinkedIn, Facebook, X, etc.) configured in <a href="{{ route('admin.settings') }}" wire:navigate class="font-bold text-cyan-600 dark:text-cyan-400 hover:underline">Global Settings &rarr; Social Links</a>.
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">Custom Topbar Link</label>
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-[10px] font-semibold text-slate-500">
                                            <input type="checkbox" wire:model.live="headerTopbar.show_custom_link" value="1" class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0">
                                            <span>Show</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" wire:model.live="headerTopbar.custom_link_text" placeholder="e.g. Vessel Tracking"
                                               class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                        <input type="text" wire:model.live="headerTopbar.custom_link_url" placeholder="https://... or /tracking"
                                               class="w-full px-2.5 py-1.5 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                    </div>
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer text-[10px] text-slate-600 dark:text-slate-400">
                                        <input type="checkbox" wire:model.live="headerTopbar.custom_link_blank" value="1" class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0">
                                        <span>Open custom link in new tab</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Alignment Layout Control -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Strip Alignment</label>
                                <select wire:model.live="headerTopbar.alignment" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                    <option value="between">Split / Between (Left: Badge &amp; Info | Right: Contact &amp; Social - Recommended)</option>
                                    <option value="center">Centered (Center-aligned information strip)</option>
                                    <option value="start">Left-Aligned (All items grouped on left)</option>
                                </select>
                            </div>

                            <!-- Granular Topbar Box Model & Spacing Engine -->
                            <div class="pt-2">
                                <x-smart-box-model wire:model="topbarBoxModel" :show-margin="false" :show-width="false" label="Topbar Box Model & Spacing" />
                            </div>

                            <div class="pt-2 flex items-center justify-between">
                                <label class="inline-flex items-center gap-2 cursor-pointer select-none text-xs text-slate-700 dark:text-slate-300 font-medium">
                                    <input type="checkbox" wire:model.live="headerTopbar.admin_link" value="1" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                                    <span>Show "Admin Portal &rarr;" Quick Link in Top Bar</span>
                                </label>
                            </div>

                            <!-- Topbar Box Model & Styling -->
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                <x-smart-box-model wire:model="topbarBoxModel" :show-width="true" :show-margin="true" :show-border="true" label="Topbar Layout & Box Model" />
                                <x-smart-color-picker wire:model="topbarBgColor" :allow-glass="true" label="Topbar Background Color" default-light="#ffffff" default-dark="#050f18" />
                                <x-smart-color-picker wire:model="topbarTextColor" :allow-glass="false" label="Topbar Text & Icons Color" default-light="#334155" default-dark="#cbd5e1" />
                            </div>
                        @endif
                    </div>

                    <!-- SECTION 2: MAIN HEADER STYLING & BEHAVIOR -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Header Appearance &amp; Sticky Behavior</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Header Navbar Appearance</label>
                                <select wire:model.live="theme.theme_header_style" class="w-full px-3 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                    <option value="glass">Glass Frosted (Blurred semi-transparent - Recommended)</option>
                                    <option value="solid">Solid Crisp Background</option>
                                    <option value="transparent">Fully Transparent (Floats directly over hero)</option>
                                    <option value="floating">Floating Island Navbar (Pill Container)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Navbar Height</label>
                                <select wire:model.live="theme.theme_header_height" class="w-full px-3 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                    <option value="64px">Compact (64px)</option>
                                    <option value="80px">Standard Corporate (80px - Recommended)</option>
                                    <option value="96px">Spacious Grand (96px)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none text-xs text-slate-700 dark:text-slate-300 font-medium">
                                <input type="checkbox" wire:model.live="headerSticky" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                                <div>
                                    <span class="font-bold">Sticky Header Navbar</span>
                                    <p class="text-[11px] text-slate-400">Keeps header visible on scroll</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-2.5 cursor-pointer select-none text-xs text-slate-700 dark:text-slate-300 font-medium">
                                <input type="checkbox" wire:model.live="headerThemeToggle" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                                <div>
                                    <span class="font-bold">Dark / Light Mode Toggle</span>
                                    <p class="text-[11px] text-slate-400">Show sun/moon theme switch button</p>
                                </div>
                            </label>
                        </div>

                        <!-- Smart Color Engine for Header Background (Theme Default vs Custom Light/Dark) -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                            <x-smart-color-picker wire:model="headerBgColor" label="Header Background Color" />
                        </div>

                        <!-- Smart Color Engine for Header Text & Navigation Links -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                            <x-smart-color-picker wire:model="headerTextColor" :allow-glass="false" label="Header Text & Navigation Links Color" default-light="#0f172a" default-dark="#ffffff" />
                        </div>

                        <!-- Smart Box Model Engine for Header Navbar -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                            <x-smart-box-model wire:model="headerBoxModel" :show-width="true" :show-margin="true" :show-border="true" label="Header Navbar Box Model & Spacing" />
                        </div>

                        <!-- Header Bottom Border Controls (Full-Width vs Boxed) -->
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Bottom Border Width</label>
                                <select wire:model.live="headerBorderWidth" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                    <option value="0px">None (0px)</option>
                                    <option value="1px">1px (Thin - Standard)</option>
                                    <option value="2px">2px (Medium Accent)</option>
                                    <option value="3px">3px (Bold Accent)</option>
                                    <option value="4px">4px (Heavy)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Bottom Border Span</label>
                                <select wire:model.live="headerBorderSpan" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                    <option value="full">Full Viewport Width (100% - Recommended)</option>
                                    <option value="boxed">Boxed (Contained to Content)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Custom Border Color</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="headerBorderColor" class="w-8 h-8 rounded-lg border border-slate-300 dark:border-slate-700 p-0.5 bg-transparent cursor-pointer">
                                    <input type="text" wire:model.live="headerBorderColor" placeholder="Default: Theme" class="w-full px-2 py-1.5 text-xs font-mono font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: NAVIGATION MENU SELECTION -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Active Navigation Menu</h3>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                        Multi-Tier Engine
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-0.5">Select which navigation menu to render in the main website header</p>
                            </div>

                            <a href="{{ route('admin.menus') }}" wire:navigate
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-2xs transition-all">
                                <x-icon name="solid:bars-staggered" class="w-3.5 h-3.5" />
                                <span>Manage Menus &amp; Tree &rarr;</span>
                            </a>
                        </div>

                        <!-- Menu Selector Dropdown -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Header Display Menu</label>
                                <select wire:model.live="headerMenuId" class="w-full px-3 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                    @forelse($availableMenus as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->items_count }} items) [{{ $m->location }}]</option>
                                    @empty
                                        <option value="">No menus created yet</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950/60 border-2 border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400">
                                <span class="font-extrabold text-slate-900 dark:text-white block mb-0.5">Standalone Tree Builder:</span>
                                <span>Multi-layer indentation, internal page anchors, and dynamic services are managed in the dedicated <a href="{{ route('admin.menus') }}" wire:navigate class="font-bold text-cyan-600 dark:text-cyan-400 hover:underline">Navigation Menu Builder</a>.</span>
                            </div>
                        </div>

                        @php
                            $activeMenuModel = $availableMenus->firstWhere('id', $headerMenuId) ?: $availableMenus->first();
                        @endphp
                        @if($activeMenuModel)
                            <div class="p-4 rounded-xl bg-cyan-50/50 dark:bg-cyan-950/20 border border-cyan-200/60 dark:border-cyan-800/40">
                                <div class="flex items-center justify-between text-xs mb-2">
                                    <span class="font-bold text-cyan-950 dark:text-cyan-200">Active Menu: {{ $activeMenuModel->name }}</span>
                                    <span class="text-[10px] font-mono text-cyan-700 dark:text-cyan-400">{{ $activeMenuModel->items_count }} items configured</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($activeMenuModel->items()->whereNull('parent_id')->orderBy('order')->get() as $root)
                                        <span class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 flex items-center gap-1">
                                            <span>{{ $root->display_title }}</span>
                                            @if($root->children()->count() > 0)
                                                <span class="text-[9px] px-1 rounded-sm bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-mono">+{{ $root->children()->count() }}</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- SECTION 4: CALL TO ACTION (CTA) BUTTON -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                        Header Call to Action (CTA) Button
                                    </h3>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                        Primary Conversion Button
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    The prominent conversion button in the header (e.g. <strong>"Request RFQ"</strong>). Directs visitors straight to quote requests or key consultation channels.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="headerCta.enabled" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>

                        @if(!empty($headerCta['enabled']))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">
                                        Button Display Text
                                    </label>
                                    <input type="text" wire:model.live="headerCta.label" placeholder="Request RFQ"
                                           class="w-full px-3 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                                </div>
                                <div class="flex items-end pb-2">
                                    <label class="inline-flex items-center gap-2 cursor-pointer select-none text-xs text-slate-700 dark:text-slate-300 font-medium">
                                        <input type="checkbox" wire:model.live="headerCta.show_icon" value="1" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                                        <span>Show Document Icon in Button</span>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-2">
                                <x-smart-link-picker 
                                    wire:model="headerCta.link" 
                                    label="Button Destination Link" 
                                    help="Select which page, section anchor (#rfq), dynamic service, or direct call action this button links to."
                                />
                            </div>
                        @endif
                    </div>

                    <!-- SECTION 5: ROW 3 - BOTTOM HEADER (SUB-HEADER ENGINE) -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                        Row 3: Bottom Sub-Header Bar
                                    </h3>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                        Optional Secondary Row
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                    Secondary navigation row below the main header for category tabs, emergency announcements, or quick service links.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="headerBottom.enabled" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>

                        @if(!empty($headerBottom['enabled']))
                            <div class="space-y-4 pt-1">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Announcement / Ticker Text</label>
                                        <input type="text" wire:model.live="headerBottom.text" placeholder="Authorized Marine Engineering Bulletin..."
                                               class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Layout Alignment</label>
                                        <select wire:model.live="headerBottom.layout" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                            <option value="between">Split Left &amp; Right</option>
                                            <option value="center">Centered Strip</option>
                                            <option value="start">Left-Aligned</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Custom Sub-Header Quick Links Repeater -->
                                <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Secondary Quick Links</span>
                                        <button type="button" wire:click="addHeaderBottomLink" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-white transition-colors flex items-center gap-1 cursor-pointer">
                                            <x-icon name="solid:plus" class="w-3 h-3" />
                                            <span>Add Link</span>
                                        </button>
                                    </div>

                                    <div class="space-y-2">
                                        @foreach($headerBottom['items'] ?? [] as $bIdx => $bItem)
                                            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                                <input type="text" wire:model.live="headerBottom.items.{{ $bIdx }}.label" placeholder="Link Label" class="flex-1 px-2.5 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                                <input type="text" wire:model.live="headerBottom.items.{{ $bIdx }}.url" placeholder="URL (/services or https://...)" class="flex-1 px-2.5 py-1 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                                <button type="button" wire:click="removeHeaderBottomLink({{ $bIdx }})" class="p-1.5 text-rose-500 hover:text-rose-700 cursor-pointer">
                                                    <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Sub-Header Box Model & Colors -->
                                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                    <x-smart-box-model wire:model="headerBottom.box_model" :show-width="true" :show-margin="true" :show-border="true" label="Sub-Header Layout & Box Model" />
                                    <x-smart-color-picker wire:model="headerBottom.bg_color" :allow-glass="true" label="Bottom Header Background Color" default-light="#f8fafc" default-dark="#061320" />
                                    <x-smart-color-picker wire:model="headerBottom.text_color" :allow-glass="false" label="Bottom Header Text Color" default-light="#475569" default-dark="#94a3b8" />
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            @endif

            <!-- TAB 6: FOOTER CUSTOMIZER STUDIO -->
            @if($activeTab === 'footer')
                <div class="space-y-6">

                    <!-- Shortcut Banner to Dedicated Header & Footer Builder -->
                    <div class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-r from-[#003C58]/10 via-cyan-500/10 to-transparent border border-[#003C58]/20 dark:border-cyan-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <x-icon name="solid:compass-drafting" class="w-4 h-4 text-[#003C58] dark:text-cyan-400 shrink-0" />
                            <div>
                                <strong class="block text-xs text-slate-800 dark:text-white font-bold">Dedicated Visual Header &amp; Footer Builder Available</strong>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">Design multi-row headers and footers with independent box models in a dedicated studio.</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.header-footer') }}" wire:navigate
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 font-bold text-xs text-white shrink-0 shadow-2xs transition-all">
                            <span>Open Dedicated Builder &rarr;</span>
                        </a>
                    </div>

                    <!-- SECTION 1: FOOTER APPEARANCE & COLORS -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Footer Colors &amp; Appearance</h3>
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-500/20 dark:text-cyan-400">Design System</span>
                        </div>

                        <div class="space-y-4">
                            <x-smart-color-picker wire:model="footerBgColor" :allow-glass="true" label="Footer Background Color" default-light="#f1f5f9" default-dark="#040e17" />
                            <x-smart-color-picker wire:model="footerTextColor" :allow-glass="false" label="Footer Text & Links Color" default-light="#334155" default-dark="#cbd5e1" />
                        </div>
                    </div>

                    <!-- SECTION 2: FOOTER BOX MODEL & SPACING ENGINE -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Footer Box Model &amp; Spacing Engine</h3>
                        <x-smart-box-model wire:model="footerBoxModel" :show-margin="false" label="Footer Internal Padding & Border Model" />
                    </div>

                    <!-- SECTION 2.5: ROW 1 - TOP PRE-FOOTER CALLOUT BAR -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                        Row 1: Top Pre-Footer Callout Bar
                                    </h3>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                        Newsletter &amp; Hotline Callout
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                    A prominent pre-footer banner above the main column grid for newsletter subscription, 24/7 port hotline, or custom call-to-action.
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="footerTop.enabled" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>

                        @if(!empty($footerTop['enabled']))
                            <div class="space-y-4 pt-1">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Pre-Footer Widget Type</label>
                                        <select wire:model.live="footerTop.type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                            <option value="newsletter_callout">✉️ Newsletter Subscription &amp; Bulletin</option>
                                            <option value="hotline_banner">⚓ 24/7 Emergency Port Hotline Banner</option>
                                            <option value="custom_callout">📢 Custom Callout &amp; Direct Action</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Headline</label>
                                        <input type="text" wire:model.live="footerTop.headline" placeholder="Subscribe to Maritime Technical Bulletins"
                                               class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Subtext / Description</label>
                                        <input type="text" wire:model.live="footerTop.subtext" placeholder="Receive real-time turbocharger updates and port notices..."
                                               class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Action Button Text</label>
                                        <input type="text" wire:model.live="footerTop.button_text" placeholder="Subscribe"
                                               class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                    </div>
                                </div>

                                <!-- Pre-Footer Styling & Box Model -->
                                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                    <x-smart-box-model wire:model="footerTop.box_model" :show-width="true" :show-margin="true" :show-border="true" label="Pre-Footer Layout & Box Model" />
                                    <x-smart-color-picker wire:model="footerTop.bg_color" :allow-glass="true" label="Pre-Footer Background Color" default-light="#003C58" default-dark="#061a28" />
                                    <x-smart-color-picker wire:model="footerTop.text_color" :allow-glass="false" label="Pre-Footer Text Color" default-light="#ffffff" default-dark="#f1f5f9" />
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- SECTION 3: MODULAR FOOTER GRID & WIDGET BUILDER -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Footer Columns &amp; Content Modules</h3>
                                <p class="text-[11px] text-slate-400">Add, arrange, and configure modular columns with dynamic or static widgets.</p>
                            </div>

                            <!-- Fast Layout Presets & Add Column -->
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mr-1">Presets:</span>
                                @foreach([1, 2, 3, 4, 5] as $presetCount)
                                    <button type="button" 
                                            wire:click="setFooterLayoutPreset({{ $presetCount }})"
                                            title="Set {{ $presetCount }} Columns"
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-md border transition-all cursor-pointer {{ count($footerColumns) === $presetCount ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-400' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-slate-400' }}">
                                        {{ $presetCount }} Col{{ $presetCount > 1 ? 's' : '' }}
                                    </button>
                                @endforeach

                                <button type="button" 
                                        wire:click="addFooterColumn"
                                        class="ml-2 px-2.5 py-1 text-xs font-extrabold rounded-lg bg-[#003C58] hover:bg-[#002b3f] text-white dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all flex items-center gap-1 shadow-2xs cursor-pointer">
                                    <x-icon name="solid:plus" class="w-3 h-3" />
                                    <span>Add Column</span>
                                </button>
                            </div>
                        </div>

                        <!-- Columns List Repeater -->
                        <div class="space-y-3">
                            @forelse($footerColumns as $index => $col)
                                <div class="rounded-xl border transition-all duration-150 {{ $expandedFooterColIndex === $index ? 'border-[#003C58] dark:border-cyan-500 shadow-sm bg-white dark:bg-slate-900' : 'border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/40' }}">
                                    <!-- Compact Column Header Bar -->
                                    <div class="p-2.5 flex flex-wrap items-center justify-between gap-2">
                                        <!-- Left: Order & Index Badge & Title -->
                                        <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                                            <!-- Move buttons -->
                                            <div class="inline-flex items-center rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 shadow-2xs">
                                                <button type="button" 
                                                        wire:click="moveFooterColumn({{ $index }}, 'left')" 
                                                        title="Move Left"
                                                        {{ $index === 0 ? 'disabled' : '' }}
                                                        class="p-1 hover:text-slate-900 dark:hover:text-white disabled:opacity-30 disabled:cursor-not-allowed">
                                                    <x-icon name="solid:chevron-left" class="w-3 h-3" />
                                                </button>
                                                <button type="button" 
                                                        wire:click="moveFooterColumn({{ $index }}, 'right')" 
                                                        title="Move Right"
                                                        {{ $index === count($footerColumns) - 1 ? 'disabled' : '' }}
                                                        class="p-1 border-l border-slate-200 dark:border-slate-700 hover:text-slate-900 dark:hover:text-white disabled:opacity-30 disabled:cursor-not-allowed">
                                                    <x-icon name="solid:chevron-right" class="w-3 h-3" />
                                                </button>
                                            </div>

                                            <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-slate-200/80 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                                Col #{{ $index + 1 }}
                                            </span>

                                            <!-- Title Input -->
                                            <input type="text" 
                                                   wire:model.live="footerColumns.{{ $index }}.title" 
                                                   placeholder="Column Title (e.g. About Us)" 
                                                   class="px-2 py-1 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white flex-1 min-w-[120px] focus:ring-1 focus:ring-[#003C58]">

                                            <!-- Summary Indicator Badge -->
                                            <span class="text-[10px] font-medium text-slate-400 hidden sm:inline-block">
                                                @if(($col['type'] ?? '') === 'company_info')
                                                    Show Social Media Icons
                                                @elseif(($col['type'] ?? '') === 'dynamic_menu' && ($col['content']['source'] ?? '') === 'divisions')
                                                    Show Business Units Column
                                                @elseif(($col['type'] ?? '') === 'dynamic_menu' && ($col['content']['source'] ?? '') === 'services')
                                                    Show Technical Services Column
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Right: Span, Widget Type, Edit Toggle, Delete -->
                                        <div class="flex items-center gap-2 shrink-0">
                                            <!-- Column Span -->
                                            <select wire:model.live="footerColumns.{{ $index }}.span" 
                                                    title="Column Width Span"
                                                    class="px-2 py-1 text-[11px] font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 cursor-pointer">
                                                <option value="1">1 Span (Normal)</option>
                                                <option value="2">2 Spans (Wide)</option>
                                            </select>

                                            <!-- Widget Type Select -->
                                            <select wire:model.live="footerColumns.{{ $index }}.type" 
                                                    class="px-2 py-1 text-[11px] font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-[#003C58] dark:text-cyan-400 cursor-pointer">
                                                <option value="company_info">🏢 Company Info &amp; Bio</option>
                                                <option value="dynamic_menu">📑 Dynamic Navigation Menu</option>
                                                <option value="static_list">🔗 Custom Links List</option>
                                                <option value="newsletter">✉️ Newsletter Subscription</option>
                                                <option value="google_map">📍 Google Maps Embed</option>
                                                <option value="contact_offices">⚓ Port &amp; HQ Offices</option>
                                                <option value="custom_html">💻 Custom HTML / Code</option>
                                            </select>

                                            <!-- Toggle Accordion Details -->
                                            <button type="button" 
                                                    wire:click="toggleFooterCol({{ $index }})" 
                                                    title="{{ $expandedFooterColIndex === $index ? 'Collapse Settings' : 'Expand Settings' }}"
                                                    class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors cursor-pointer">
                                                <x-icon name="{{ $expandedFooterColIndex === $index ? 'solid:chevron-up' : 'solid:chevron-down' }}" class="w-3.5 h-3.5" />
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" 
                                                    wire:click="removeFooterColumn({{ $index }})" 
                                                    title="Delete Column"
                                                    class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer">
                                                <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Expanded Card Body with Type-Specific Settings -->
                                    @if($expandedFooterColIndex === $index)
                                        <div class="p-3.5 border-t border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50 space-y-3">
                                            @php
                                                $cType = $col['type'] ?? 'company_info';
                                            @endphp

                                            @if($cType === 'company_info')
                                                <!-- Company Info Widget Settings -->
                                                <div class="space-y-2.5">
                                                    <div class="flex items-center gap-4 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                            <input type="checkbox" wire:model.live="footerColumns.{{ $index }}.content.show_logo" value="1" class="rounded text-[#003C58] focus:ring-0">
                                                            <span>Show Brand Logo</span>
                                                        </label>
                                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                            <input type="checkbox" wire:model.live="footerColumns.{{ $index }}.content.show_social" value="1" class="rounded text-[#003C58] focus:ring-0">
                                                            <span>Show Social Media Icons</span>
                                                        </label>
                                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                            <input type="checkbox" wire:model.live="footerColumns.{{ $index }}.content.show_phone" value="1" class="rounded text-[#003C58] focus:ring-0">
                                                            <span>Show 24/7 Hotline</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Company Description / Bio Override</label>
                                                        <textarea wire:model.live="footerColumns.{{ $index }}.content.bio" rows="2" placeholder="Leave empty for corporate default bio..."
                                                                  class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:ring-1 focus:ring-[#003C58]"></textarea>
                                                    </div>
                                                </div>

                                            @elseif($cType === 'dynamic_menu')
                                                <!-- Dynamic Menu Widget Settings -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Menu Data Source</label>
                                                        <select wire:model.live="footerColumns.{{ $index }}.content.source" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                            <option value="divisions">Show Business Units Column (Database)</option>
                                                            <option value="services">Show Technical Services Column (Database)</option>
                                                            <option value="custom_menu">Navigation Menu Builder Tree</option>
                                                        </select>
                                                    </div>
                                                    @if(($col['content']['source'] ?? '') === 'custom_menu')
                                                        <div>
                                                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Select Menu</label>
                                                            <select wire:model.live="footerColumns.{{ $index }}.content.menu_id" class="w-full px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                                <option value="">-- Choose a Navigation Menu --</option>
                                                                @foreach($availableMenus as $menu)
                                                                    <option value="{{ $menu->id }}">{{ $menu->name }} ({{ $menu->items_count }} items)</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>

                                            @elseif($cType === 'static_list')
                                                <!-- Static Links List Repeater -->
                                                <div class="space-y-2">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Custom Links Repeater</span>
                                                        <button type="button" wire:click="addStaticListItem({{ $index }})" 
                                                                class="px-2 py-0.5 text-[10px] font-bold rounded bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-white transition-colors flex items-center gap-1 cursor-pointer">
                                                            <x-icon name="solid:plus" class="w-2.5 h-2.5" />
                                                            <span>Add Link</span>
                                                        </button>
                                                    </div>

                                                    <div class="space-y-1.5 max-h-56 overflow-y-auto pr-1">
                                                        @foreach($col['content']['items'] ?? [] as $itemIndex => $item)
                                                            <div class="flex items-center gap-2 bg-white dark:bg-slate-900 p-1.5 rounded-lg border border-slate-200 dark:border-slate-800">
                                                                <input type="text" 
                                                                       wire:model.live="footerColumns.{{ $index }}.content.items.{{ $itemIndex }}.text" 
                                                                       placeholder="Link Text" 
                                                                       class="flex-1 px-2 py-1 text-xs rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white">
                                                                <input type="text" 
                                                                       wire:model.live="footerColumns.{{ $index }}.content.items.{{ $itemIndex }}.url" 
                                                                       placeholder="URL (/about or https://...)" 
                                                                       class="flex-1 px-2 py-1 text-xs font-mono rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white">
                                                                <button type="button" wire:click="removeStaticListItem({{ $index }}, {{ $itemIndex }})" class="p-1 text-rose-500 hover:text-rose-700 cursor-pointer">
                                                                    <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @elseif($cType === 'newsletter')
                                                <!-- Newsletter Widget Settings -->
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                                                    <div class="sm:col-span-3">
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Short Description</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.description" placeholder="Subscribe for marine engineering updates &amp; overhauls..." 
                                                               class="w-full px-2.5 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    </div>
                                                    <div class="sm:col-span-2">
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Input Placeholder</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.placeholder" placeholder="Enter corporate email..." 
                                                               class="w-full px-2.5 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Button Text</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.button_text" placeholder="Subscribe" 
                                                               class="w-full px-2.5 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    </div>
                                                </div>

                                            @elseif($cType === 'google_map')
                                                <!-- Google Map Widget Settings -->
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                                                    <div class="sm:col-span-2">
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Map Embed URL (Iframe src)</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.embed_url" placeholder="https://maps.google.com/maps?q=..." 
                                                               class="w-full px-2.5 py-1.5 font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Map Height</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.height" placeholder="160px" 
                                                               class="w-full px-2.5 py-1.5 font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    </div>
                                                </div>

                                            @elseif($cType === 'contact_offices')
                                                <!-- Contact Offices Widget Settings -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Port Office Title &amp; Address</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.port_title" placeholder="Chattogram Port Workshop:" class="w-full mb-1 px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                        <textarea wire:model.live="footerColumns.{{ $index }}.content.port_address" rows="2" placeholder="Port workshop address..." class="w-full px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white"></textarea>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Corporate HQ Title &amp; Address</label>
                                                        <input type="text" wire:model.live="footerColumns.{{ $index }}.content.hq_title" placeholder="Dhaka Corporate HQ:" class="w-full mb-1 px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                        <textarea wire:model.live="footerColumns.{{ $index }}.content.hq_address" rows="2" placeholder="HQ office address..." class="w-full px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white"></textarea>
                                                    </div>
                                                    <div class="sm:col-span-2 pt-1">
                                                        <label class="inline-flex items-center gap-1.5 text-xs font-semibold cursor-pointer text-slate-700 dark:text-slate-300">
                                                            <input type="checkbox" wire:model.live="footerColumns.{{ $index }}.content.show_emergency" value="1" class="rounded text-[#003C58] focus:ring-0">
                                                            <span>Show Emergency Phone Hotline from Global Settings</span>
                                                        </label>
                                                    </div>
                                                </div>

                                            @elseif($cType === 'custom_html')
                                                <!-- Custom HTML Widget Settings -->
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Raw HTML / Markdown Content</label>
                                                    <textarea wire:model.live="footerColumns.{{ $index }}.content.html" rows="4" placeholder="<div class='custom-widget'>...</div>"
                                                              class="w-full px-2.5 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:ring-1 focus:ring-[#003C58]"></textarea>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="p-6 text-center rounded-xl border border-dashed border-slate-300 dark:border-slate-700 text-slate-400">
                                    <p class="text-xs">No footer columns configured yet. Click "Add Column" or select a preset above.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- SECTION 4: SUB-FOOTER / COPYRIGHT STRIP ENGINE -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Sub-Footer &amp; Copyright Bar Architecture</h3>
                                <p class="text-[11px] text-slate-400">Configure bottom strip elements (copyright, inline menu, accreditation badges, social links).</p>
                            </div>

                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mr-1">Presets:</span>
                                <button type="button" wire:click="setFooterBottomPreset(1)" class="px-2 py-0.5 text-[10px] font-bold rounded-md border transition-all cursor-pointer {{ count($footerBottomColumns) === 1 ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700' }}">1 Col (Center)</button>
                                <button type="button" wire:click="setFooterBottomPreset(2)" class="px-2 py-0.5 text-[10px] font-bold rounded-md border transition-all cursor-pointer {{ count($footerBottomColumns) === 2 ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700' }}">2 Cols (Split)</button>
                                <button type="button" wire:click="setFooterBottomPreset(3)" class="px-2 py-0.5 text-[10px] font-bold rounded-md border transition-all cursor-pointer {{ count($footerBottomColumns) === 3 ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700' }}">3 Cols</button>

                                <button type="button" wire:click="addFooterBottomColumn" class="ml-2 px-2.5 py-1 text-xs font-extrabold rounded-lg bg-[#003C58] hover:bg-[#002b3f] text-white dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all flex items-center gap-1 shadow-2xs cursor-pointer">
                                    <x-icon name="solid:plus" class="w-3 h-3" />
                                    <span>Add Item</span>
                                </button>
                            </div>
                        </div>

                        <!-- Sub-Footer Items List -->
                        <div class="space-y-3">
                            @foreach($footerBottomColumns as $bIndex => $bCol)
                                <div class="p-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/40 space-y-2.5">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-slate-200/80 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                                Zone #{{ $bIndex + 1 }}
                                            </span>

                                            <!-- Widget Type Select -->
                                            <select wire:model.live="footerBottomColumns.{{ $bIndex }}.type" 
                                                    class="px-2 py-1 text-[11px] font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-[#003C58] dark:text-cyan-400 cursor-pointer">
                                                <option value="copyright">© Copyright Notice</option>
                                                <option value="badges">🛡️ Certification Badges &amp; Login</option>
                                                <option value="menu">📑 Navigation Menu (Inline/Stacked)</option>
                                                <option value="social">🌐 Social Media Icons</option>
                                                <option value="custom_text">📝 Custom Text / Links</option>
                                            </select>
                                        </div>

                                        <button type="button" wire:click="removeFooterBottomColumn({{ $bIndex }})" class="p-1 text-rose-500 hover:text-rose-700 cursor-pointer">
                                            <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>

                                    <!-- Config for Sub-Footer Item -->
                                    @php
                                        $botType = $bCol['type'] ?? 'copyright';
                                    @endphp

                                    @if($botType === 'copyright')
                                        <div class="text-xs">
                                            <input type="text" 
                                                   wire:model.live="footerBottomColumns.{{ $bIndex }}.content.text" 
                                                   placeholder="© {year} {site_name}. All rights reserved." 
                                                   class="w-full px-2.5 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                            <span class="text-[10px] text-slate-400 mt-0.5 block">Supported tokens: <code class="font-mono">{year}</code>, <code class="font-mono">{site_name}</code></span>
                                        </div>

                                    @elseif($botType === 'badges' || $botType === 'badges_menu')
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-500 mb-0.5">Accreditation Badge Text</label>
                                                <input type="text" wire:model.live="footerBottomColumns.{{ $bIndex }}.content.iso_text" placeholder="ISO 9001:2015 &amp; DNV Certified" 
                                                       class="w-full px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                            </div>
                                            <div class="flex items-center gap-3 pt-4">
                                                <label class="inline-flex items-center gap-1.5 cursor-pointer text-slate-700 dark:text-slate-300 font-semibold">
                                                    <input type="checkbox" wire:model.live="footerBottomColumns.{{ $bIndex }}.content.show_login" value="1" class="rounded text-[#003C58] focus:ring-0">
                                                    <span>Show Staff Login Link</span>
                                                </label>
                                            </div>
                                        </div>

                                    @elseif($botType === 'menu')
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-500 mb-0.5">Select Menu</label>
                                                <select wire:model.live="footerBottomColumns.{{ $bIndex }}.content.menu_id" class="w-full px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    <option value="">-- Choose Menu --</option>
                                                    @foreach($availableMenus as $menu)
                                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-500 mb-0.5">Layout Orientation</label>
                                                <select wire:model.live="footerBottomColumns.{{ $bIndex }}.content.menu_layout" class="w-full px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    <option value="horizontal">Horizontal Inline (Side-by-side)</option>
                                                    <option value="vertical">Vertical Stacked</option>
                                                </select>
                                            </div>
                                        </div>

                                    @elseif($botType === 'social')
                                        <p class="text-[11px] text-slate-500 italic">Pulls active social media links configured in Global Settings.</p>

                                    @elseif($botType === 'custom_text')
                                        <div class="text-xs">
                                            <input type="text" wire:model.live="footerBottomColumns.{{ $bIndex }}.content.text" placeholder="Custom credit text or HTML..." 
                                                   class="w-full px-2.5 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 7: LAYOUT & UNIVERSAL BOX MODEL ENGINE -->
            @if($activeTab === 'layout')
                <div class="space-y-6">
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Page Width &amp; Container Architecture</h3>
                            <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-500/20 dark:text-cyan-400">Global Tokens</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Website Content Max Width</label>
                                <select wire:model.live="theme.theme_container_width" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                    <option value="1280px">Boxed Standard (1280px)</option>
                                    <option value="1440px">Corporate Wide (1440px)</option>
                                    <option value="1536px">Ultra Wide (1536px - Recommended)</option>
                                    <option value="1680px">Studio Panoramic (1680px)</option>
                                    <option value="100%">100% Fluid Full Width</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Default Section Vertical Padding</label>
                                <select wire:model.live="theme.theme_section_padding" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                                    <option value="64px">Compact (64px)</option>
                                    <option value="80px">Balanced (80px)</option>
                                    <option value="96px">Generous Premium (96px - Recommended)</option>
                                    <option value="128px">Spacious Grand (128px)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- UNIVERSAL SECTION BOX MODEL ENGINE -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">Universal Section Box Model &amp; Spacing Engine</h3>
                            <span class="text-[10px] font-mono font-bold text-slate-400">Reusable CMS Engine</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                            Set fine-grained Top, Bottom, Left, and Right padding, margins, borders, elevation, and container widths. This engine is shared across all sections.
                        </p>
                        <x-smart-box-model wire:model="sectionBoxModel" label="Global Section Spacing & Geometry Engine" />

                        <!-- Universal Section Color Engine -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-4">
                            <x-smart-color-picker wire:model="sectionBgColor" label="Global Section Background Color" default-light="#ffffff" default-dark="#07131e" />
                            <x-smart-color-picker wire:model="sectionTextColor" :allow-glass="false" label="Global Section Text Color" default-light="#0f172a" default-dark="#f8fafc" />
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 7: BACKGROUND VIDEO SETTINGS -->
            @if($activeTab === 'background')
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2 flex items-center justify-between">
                            <span>Full-Site Background Video</span>
                            <span class="text-[10px] font-semibold text-cyan-600 dark:text-cyan-400 bg-cyan-500/10 px-2.5 py-0.5 rounded-full">Turbo Internacional Style</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                            Plays a high-definition marine video in the background while your website pages scroll smoothly on top of it.
                        </p>
                    </div>

                    <!-- 1. Master On/Off Switch -->
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800">
                        <div class="space-y-0.5">
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Play Background Video</span>
                            <span class="block text-[11px] text-slate-400">Turn On or Off the background video across the entire website</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="theme.site_bg_video_enabled" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                        </label>
                    </div>

                    <!-- 2. Video File / Link Selection -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Video File or URL Link</label>
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model.live="theme.site_bg_video_url"
                                   placeholder="assets/videos/background-marine.mp4 or https://..."
                                   class="flex-1 px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                            <button type="button"
                                    @click="$dispatch('open-media-picker', { targetField: 'site_bg_video_url' })"
                                    class="px-4 py-2.5 text-xs font-bold rounded-xl bg-[#003C58] hover:bg-[#024a6d] text-white dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shrink-0 transition-colors flex items-center gap-1.5 cursor-pointer shadow-xs">
                                <x-icon name="solid:photo" class="w-3.5 h-3.5" />
                                <span>Choose from Media</span>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400">Default: <code class="font-mono text-cyan-600 dark:text-cyan-400">assets/videos/background-marine.mp4</code>. Local video or external video links work automatically.</p>
                    </div>

                    <!-- 3. Video Visibility / Brightness (Opacity Slider) -->
                    <div class="space-y-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Video Brightness / Visibility</label>
                                <p class="text-[11px] text-slate-400">How clearly the background video is seen through the page</p>
                            </div>
                            <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#003C58] dark:text-cyan-400">
                                {{ $theme['site_bg_video_opacity'] ?? 85 }}% ({{ ($theme['site_bg_video_opacity'] ?? 85) >= 80 ? 'Clear & Vibrant' : (($theme['site_bg_video_opacity'] ?? 85) >= 40 ? 'Soft' : 'Subtle') }})
                            </span>
                        </div>
                        <input type="range" min="10" max="100" step="5"
                               wire:model.live="theme.site_bg_video_opacity"
                               class="w-full accent-[#003C58] dark:accent-cyan-400 cursor-pointer" />
                        <div class="flex justify-between text-[10px] text-slate-400 font-mono">
                            <span>10% (Subtle)</span>
                            <span>50% (Medium)</span>
                            <span>85% (Recommended)</span>
                            <span>100% (Full Bright)</span>
                        </div>
                    </div>

                    <!-- 4. Top Hero Banner Look -->
                    <div class="space-y-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Top Hero Banner Background Look</label>
                        <select wire:model.live="theme.theme_hero_backdrop" class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                            <option value="frosted">Frosted Glass (Recommended - Keeps the spinning turbine &amp; text easy to read)</option>
                            <option value="subtle_tint">Semi-Transparent Tint (Shows more video while keeping text readable)</option>
                            <option value="transparent">Fully Transparent (Video is completely visible directly behind hero text)</option>
                            <option value="solid">Solid Color (Hides the video completely in the top hero area)</option>
                        </select>
                        <p class="text-[11px] text-slate-400">Tip: <strong>Frosted Glass</strong> gives the cleanest look because the turbine instrument dial stays razor-sharp.</p>
                    </div>

                    <!-- 5. Mid-Page Video Panorama Section -->
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800">
                        <div class="space-y-0.5">
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Mid-Page Video Panorama Section</span>
                            <span class="block text-[11px] text-slate-400">Shows a 100% clear panoramic window between Services and Company (Turbo Internacional style)</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="theme.theme_video_break_enabled" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                        </label>
                    </div>

                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN: Live Interactive Component Preview (5 cols) -->
        <div class="lg:col-span-5 lg:sticky lg:top-28 space-y-4">
            
            <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-md">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Live Component Canvas</span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold text-emerald-600 bg-emerald-500/10">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Live
                        </span>
                    </div>

                    <!-- Canvas Dark Mode Toggle -->
                    <button type="button" @click="canvasDark = !canvasDark"
                            class="px-2.5 py-1 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:border-slate-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                        <span x-text="canvasDark ? '🌙 Dark Mode' : '☀️ Light Mode'"></span>
                    </button>
                </div>

                <!-- Mockup Preview Card Container -->
                <div class="p-5 rounded-2xl border transition-all duration-300 relative overflow-hidden"
                     :class="canvasDark ? 'dark-canvas' : 'light-canvas'"
                     :style="canvasDark 
                        ? 'background-color: {{ ($theme['theme_hero_backdrop'] ?? 'frosted') === 'transparent' ? 'transparent' : ($theme['theme_surface_dark'] ?? '#0a1926') }}; border-color: {{ $theme['theme_border_color'] ?? '#1e293b' }}; color: #ffffff;' 
                        : 'background-color: {{ ($theme['theme_hero_backdrop'] ?? 'frosted') === 'transparent' ? 'transparent' : ($theme['theme_surface_light'] ?? '#ffffff') }}; border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; color: #0f172a;'">
                    
                    @if(!empty($theme['site_bg_video_enabled']))
                        <!-- Simulated Canvas Background Video Underlay -->
                        <div class="absolute inset-0 pointer-events-none -z-0 overflow-hidden"
                             style="opacity: {{ ($theme['site_bg_video_opacity'] ?? 85) / 100 }};">
                            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                                <source src="{{ asset($theme['site_bg_video_url'] ?? 'assets/videos/background-marine.mp4') }}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 bg-[#003C58]/25 mix-blend-multiply"></div>
                        </div>

                        <!-- Hero Backdrop Glaze Simulation Layer -->
                        @if(($theme['theme_hero_backdrop'] ?? 'frosted') === 'frosted')
                            <div class="absolute inset-0 bg-white/90 dark:bg-[#07131e]/90 backdrop-blur-xs pointer-events-none"></div>
                        @elseif(($theme['theme_hero_backdrop'] ?? 'frosted') === 'subtle_tint')
                            <div class="absolute inset-0 bg-white/70 dark:bg-[#07131e]/70 backdrop-blur-xs pointer-events-none"></div>
                        @elseif(($theme['theme_hero_backdrop'] ?? 'frosted') === 'solid')
                            <div class="absolute inset-0 bg-white dark:bg-[#07131e] pointer-events-none"></div>
                        @endif
                    @endif

                    <div class="relative z-10 space-y-4">
                        <!-- Mockup Topbar (if enabled) -->
                        @if(!empty($headerTopbar['enabled']))
                            @php
                                $tbBg = ($headerTopbar['bg_color']['mode'] ?? 'theme') === 'custom'
                                    ? \App\Services\SmartColorHelper::hexToRgba($headerTopbar['bg_color']['light'] ?? '#ffffff', ($headerTopbar['bg_color']['opacity'] ?? 100) / 100)
                                    : 'rgba(0,0,0,0.03)';
                                $tbAlign = $headerTopbar['alignment'] ?? 'between';
                                $tbDensity = $headerTopbar['density'] ?? 'standard';
                                $tbPad = match($tbDensity) {
                                    'compact'  => 'py-0.5 text-[8px]',
                                    'spacious' => 'py-2 text-[10px]',
                                    default    => 'py-1 text-[9px]',
                                };
                            @endphp
                            <div class="px-2.5 {{ $tbPad }} flex items-center {{ $tbAlign === 'center' ? 'justify-center gap-3 text-center' : ($tbAlign === 'start' ? 'justify-start gap-3' : 'justify-between') }} border-b transition-all rounded-t-xl"
                                 :style="'border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; background: ' + getTopbarPreviewBg() + '; color: ' + getTopbarPreviewText()"
                                 style="border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; background: {{ $tbBg }};">
                                @if(!empty($headerTopbar['show_badge'] ?? true))
                                    <span class="truncate font-bold text-cyan-600 dark:text-cyan-400">
                                        {{ $headerTopbar['badge_text'] ?: '24/7 Emergency' }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-2 font-mono opacity-80 text-[8px]">
                                    @if(!empty($headerTopbar['show_phone'] ?? true))
                                        <span class="hidden sm:inline">
                                            {{ $headerTopbar['phone'] ?: \App\Models\Setting::get('contact_phone', '+880 1800-000000') }}
                                        </span>
                                    @endif
                                    @if(!empty($headerTopbar['show_custom_link']) && !empty($headerTopbar['custom_link_text']))
                                        <span class="text-cyan-600 dark:text-cyan-400 font-bold underline">
                                            {{ $headerTopbar['custom_link_text'] }}
                                        </span>
                                    @endif
                                    @if(!empty($headerTopbar['show_social'] ?? true))
                                        <div class="flex items-center gap-1 border-l border-slate-300 dark:border-slate-700 pl-1.5">
                                            <span class="w-3 h-3 rounded-full bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center text-[7px] font-bold">in</span>
                                            <span class="w-3 h-3 rounded-full bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center text-[7px] font-bold">f</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Mockup Header Navbar -->
                        @php
                            $mockupBg = ($headerBgColor['mode'] ?? 'theme') === 'custom'
                                ? \App\Services\SmartColorHelper::hexToRgba($headerBgColor['light'] ?? '#ffffff', ($headerBgColor['opacity'] ?? 100) / 100)
                                : (($theme['theme_header_style'] ?? 'glass') === 'glass' ? 'rgba(255,255,255,0.85)' : (($theme['theme_header_style'] ?? 'glass') === 'solid' ? ($theme['theme_primary_color'] ?? '#003C58') : 'transparent'));
                        @endphp
                        <div class="px-3.5 py-2 border flex items-center justify-between text-xs transition-all gap-2 duration-300"
                             :style="'border-radius: {{ $theme['theme_button_radius'] ?? '12px' }}; border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; background: ' + getHeaderPreviewBg()"
                             style="
                                 border-radius: {{ $theme['theme_button_radius'] ?? '12px' }};
                                 background: {{ $mockupBg }};
                                 border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }};
                             ">
                            <span class="font-extrabold uppercase tracking-wider text-[11px] shrink-0 transition-colors" 
                                  :style="'font-family: \'{{ $theme['theme_heading_font'] }}\', sans-serif; color: ' + getHeaderTitleColor()"
                                  style="font-family: '{{ $theme['theme_heading_font'] }}', sans-serif; color: {{ ($theme['theme_header_style'] ?? 'glass') === 'solid' ? '#ffffff' : ($theme['theme_primary_color'] ?? '#003C58') }}">
                                {{ \App\Models\Setting::get('site_name', 'NORDROY') }}
                            </span>
                            <div class="flex items-center gap-2 text-[10px] opacity-80 overflow-hidden transition-colors" 
                                 :style="'font-family: \'{{ $theme['theme_body_font'] }}\', sans-serif; color: ' + getHeaderNavTextColor()"
                                 style="font-family: '{{ $theme['theme_body_font'] }}', sans-serif;">
                                @foreach(array_slice($headerMenuItems, 0, 3) as $mItem)
                                    <span class="truncate font-medium">{{ $mItem['label'] }}</span>
                                @endforeach
                            </div>
                            @if(!empty($headerCta['enabled']))
                                <span class="px-2.5 py-1 text-[9px] font-bold rounded-md shrink-0 text-white shadow-xs inline-flex items-center gap-1 cursor-default transition-all"
                                      title="CTA Target: {{ \App\Services\LinkResolver::resolve($headerCta['link'] ?? [])['url'] }}"
                                      style="background: linear-gradient(135deg, {{ $theme['theme_primary_color'] ?? '#003C58' }}, {{ $theme['theme_accent_color'] ?? '#0ea5e9' }}); border-radius: {{ $theme['theme_button_radius'] ?? '6px' }};">
                                    @if(!empty($headerCta['show_icon']))
                                        <x-icon name="solid:file-lines" class="w-2.5 h-2.5 shrink-0" />
                                    @endif
                                    <span>{{ $headerCta['label'] ?: 'RFQ' }}</span>
                                </span>
                            @endif
                        </div>

                        <!-- Mockup Row 3: Bottom Header (Sub-Header) -->
                        @if(!empty($headerBottom['enabled']))
                            <div class="px-3 py-1.5 border flex items-center justify-between text-[9px] transition-all gap-2 duration-300"
                                 :style="'border-radius: {{ $theme['theme_button_radius'] ?? '12px' }}; border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; background: ' + getHeaderBottomPreviewBg() + '; color: ' + getHeaderBottomPreviewText()">
                                <div class="flex items-center gap-1.5 truncate">
                                    <span class="px-1.5 py-0.5 rounded text-[7px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 uppercase">
                                        Sub-Header
                                    </span>
                                    <span class="truncate font-semibold">{{ $headerBottom['text'] ?: 'Authorized Maritime Bulletin' }}</span>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @foreach(array_slice($headerBottom['items'] ?? [], 0, 2) as $hItem)
                                        <span class="font-bold underline text-[8px]">{{ $hItem['label'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    <!-- Category Badge -->
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold tracking-wider uppercase border transition-all"
                              style="
                                  border-radius: {{ $theme['theme_button_radius'] ?? '12px' }};
                                  color: {{ $theme['theme_primary_color'] ?? '#003C58' }};
                                  background-color: {{ $theme['theme_primary_color'] ?? '#003C58' }}15;
                                  border-color: {{ $theme['theme_primary_color'] ?? '#003C58' }}35;
                              ">
                            Marine Engineering
                        </span>

                        <span class="inline-flex items-center px-2 py-0.5 text-[9px] font-mono rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500">
                            Font: {{ $theme['theme_heading_font'] }}
                        </span>
                    </div>

                    <!-- Preview Headings with EXACT Font Styling -->
                    <div class="space-y-1.5">
                        <h4 class="text-xl sm:text-2xl leading-tight transition-all"
                            style="
                                font-family: '{{ $theme['theme_heading_font'] }}', sans-serif;
                                font-weight: {{ $theme['theme_heading_weight'] ?? '800' }};
                                letter-spacing: {{ $theme['theme_letter_spacing'] ?? '-0.02em' }};
                                color: {{ $theme['theme_primary_color'] ?? '#003C58' }};
                            ">
                            High-Precision Turbocharger Solutions
                        </h4>
                        <p class="text-xs opacity-75 leading-relaxed transition-all"
                           style="
                               font-family: '{{ $theme['theme_body_font'] }}', sans-serif;
                               font-size: {{ $theme['theme_base_font_size'] ?? '16px' }};
                               line-height: {{ $theme['theme_line_height'] ?? '1.6' }};
                           ">
                            Certified overhauls, dynamic rotor balancing, and genuine spare parts supplied worldwide by authorized marine specialists.
                        </p>
                    </div>

                    <!-- Live Typography Specimen Strip (Guarantees visible font shape differences) -->
                    <div class="p-3 rounded-xl border border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 text-xs">
                        <div class="flex items-center justify-between text-[9px] uppercase tracking-wider text-slate-400 font-mono mb-1">
                            <span>Specimen Shape Test</span>
                            <span>{{ $theme['theme_heading_weight'] }} Weight</span>
                        </div>
                        <div class="text-base tracking-normal text-slate-800 dark:text-slate-100 font-semibold"
                             style="font-family: '{{ $theme['theme_heading_font'] }}', sans-serif;">
                            Aa Bb Gg Rr Qq 1234567890 &amp;
                        </div>
                    </div>

                    <!-- Preview Interactive Buttons -->
                    <div class="flex flex-wrap items-center gap-2 pt-1">
                        <!-- Primary Button -->
                        <button type="button"
                                class="px-4 py-2 text-xs font-bold text-white shadow-sm transition-all hover:opacity-90 active:scale-95"
                                style="
                                    font-family: '{{ $theme['theme_body_font'] }}', sans-serif;
                                    background: {{ ($theme['theme_button_style'] ?? 'solid') === 'gradient' 
                                        ? 'linear-gradient(135deg, ' . ($theme['theme_primary_color'] ?? '#003C58') . ', ' . ($theme['theme_accent_color'] ?? '#0ea5e9') . ')' 
                                        : (($theme['theme_button_style'] ?? 'solid') === 'soft_tint' ? ($theme['theme_primary_color'] ?? '#003C58') . '25' : ($theme['theme_primary_color'] ?? '#003C58')) }};
                                    color: {{ ($theme['theme_button_style'] ?? 'solid') === 'soft_tint' ? ($theme['theme_primary_color'] ?? '#003C58') : '#ffffff' }};
                                    border-radius: {{ $theme['theme_button_radius'] ?? '12px' }};
                                ">
                            Primary Action
                        </button>

                        <!-- Accent Button -->
                        <button type="button"
                                class="px-4 py-2 text-xs font-bold text-white shadow-sm transition-all hover:opacity-90 active:scale-95"
                                style="
                                    font-family: '{{ $theme['theme_body_font'] }}', sans-serif;
                                    background-color: {{ $theme['theme_accent_color'] ?? '#0ea5e9' }};
                                    border-radius: {{ $theme['theme_button_radius'] ?? '12px' }};
                                ">
                            Accent CTA
                        </button>

                        <!-- Outline Button -->
                        <button type="button"
                                class="px-4 py-2 text-xs font-bold border transition-all hover:bg-slate-100/30 active:scale-95"
                                style="
                                    font-family: '{{ $theme['theme_body_font'] }}', sans-serif;
                                    border-radius: {{ $theme['theme_button_radius'] ?? '12px' }};
                                    border-color: {{ $theme['theme_secondary_color'] ?? '#75767A' }};
                                    color: {{ $theme['theme_secondary_color'] ?? '#75767A' }};
                                ">
                            Outline Spec
                        </button>
                    </div>

                    <!-- Sample Card Surface Feature -->
                    <div class="p-3.5 border transition-all mt-2"
                         style="
                             border-radius: {{ $theme['theme_card_radius'] ?? '16px' }};
                             border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }};
                             border-top: {{ ($theme['theme_card_border'] ?? 'subtle') === 'accent_top' ? '3px solid ' . ($theme['theme_primary_color'] ?? '#003C58') : '' }};
                             box-shadow: {{ ($theme['theme_card_shadow'] ?? 'shadow-sm') === 'none' ? 'none' : (($theme['theme_card_shadow'] ?? 'shadow-sm') === 'shadow-lg' ? '0 10px 15px -3px rgba(0, 0, 0, 0.1)' : (($theme['theme_card_shadow'] ?? 'shadow-sm') === 'glow' ? '0 0 15px ' . ($theme['theme_primary_color'] ?? '#003C58') . '30' : '0 1px 3px rgba(0,0,0,0.08)')) }};
                         ">
                        <div class="flex items-center justify-between text-xs font-bold" style="font-family: '{{ $theme['theme_heading_font'] }}', sans-serif;">
                            <span>Engineering Overhaul 24/7</span>
                            <span style="color: {{ $theme['theme_accent_color'] ?? '#0ea5e9' }}">ISO 9001</span>
                        </div>
                        <p class="text-[11px] opacity-70 mt-1" style="font-family: '{{ $theme['theme_body_font'] }}', sans-serif;">
                            Card Surface with custom shadow elevation & border treatment.
                        </p>
                    </div>

                    <!-- Mockup Row 1: Top Pre-Footer Callout Bar (if enabled) -->
                    @if(!empty($footerTop['enabled']))
                        <div class="p-2.5 rounded-xl border transition-all text-[9px] flex items-center justify-between gap-2 mt-2"
                             :style="'border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; background: ' + getFooterTopPreviewBg() + '; color: ' + getFooterTopPreviewText()">
                            <div class="truncate">
                                <strong class="block truncate text-[10px]">{{ $footerTop['headline'] ?: 'Subscribe to Bulletins' }}</strong>
                                <span class="opacity-75 block truncate text-[8px]">{{ $footerTop['subtext'] ?: 'Stay informed with technical alerts' }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[8px] font-bold bg-cyan-500 text-slate-950 shrink-0 shadow-2xs">
                                {{ $footerTop['button_text'] ?: 'Subscribe' }}
                            </span>
                        </div>
                    @endif

                    <!-- Mockup Footer (Real-time Live Preview) -->
                    <div class="p-3.5 border transition-all duration-300 rounded-xl space-y-2 mt-2 text-[10px]"
                         :style="'border-color: {{ $theme['theme_border_color'] ?? '#e2e8f0' }}; background: ' + getFooterPreviewBg() + '; color: ' + getFooterPreviewText()">
                        <div class="flex items-center justify-between pb-1.5 border-b border-black/10 dark:border-white/10">
                            <span class="font-extrabold uppercase tracking-wider text-[11px]" :style="'font-family: \'{{ $theme['theme_heading_font'] }}\', sans-serif;'">
                                {{ \App\Models\Setting::get('site_name', 'NORDROY') }}
                            </span>
                            <span class="text-[9px] opacity-75">Corporate Footer</span>
                        </div>
                        <div class="grid grid-cols-{{ max(1, min(count($footerColumns), 4)) }} gap-2 opacity-80 py-0.5 text-[9px]">
                            @foreach(array_slice($footerColumns, 0, 4) as $col)
                                <div>
                                    <span class="font-bold block truncate">{{ $col['title'] ?: 'Column' }}</span>
                                    <span class="text-[8px] opacity-70 truncate block">{{ ucfirst(str_replace('_', ' ', $col['type'])) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-1.5 border-t border-black/10 dark:border-white/10 flex items-center justify-between opacity-60 text-[8px]">
                            <span>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Nordroy CMS') }}</span>
                            <span>ISO 9001:2015</span>
                        </div>
                    </div>

                    <!-- Token Active Values Strip -->
                    <div class="pt-3 border-t border-slate-200/80 dark:border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-2 text-[10px] font-mono text-slate-500">
                        <div>Radius: <strong class="text-slate-800 dark:text-slate-200">{{ $theme['theme_button_radius'] }}</strong></div>
                        <div>Max-W: <strong class="text-slate-800 dark:text-slate-200">{{ $theme['theme_container_width'] }}</strong></div>
                        <div>Video: <strong class="text-slate-800 dark:text-slate-200">{{ !empty($theme['site_bg_video_enabled']) ? ($theme['site_bg_video_opacity'] ?? 85).'%' : 'Off' }}</strong></div>
                        <div>Glaze: <strong class="text-slate-800 dark:text-slate-200">{{ ucfirst($theme['theme_hero_backdrop'] ?? 'frosted') }}</strong></div>
                    </div>

                    </div> <!-- End .relative.z-10.space-y-4 -->

                </div>

            </div>

        </div>

    </div>

    <!-- Media Picker Modal Integration for Video & Background Assets -->
    <x-media-picker-modal />
</div>
