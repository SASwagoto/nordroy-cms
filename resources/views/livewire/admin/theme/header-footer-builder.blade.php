<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight font-heading">
                    Header &amp; Footer Builder
                </h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span>
                    Elementor-Grade Studio
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Visual customizer for multi-row corporate website headers and modular footers with independent box models and styling.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.theme') }}" wire:navigate
               class="px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                &larr; Design System Tokens
            </a>

            <button type="button" 
                    wire:click="save" 
                    wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs shadow-md transition-all flex items-center gap-2 cursor-pointer active:scale-95">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <x-icon name="solid:cloud-arrow-up" class="w-4 h-4" />
                    <span>Publish &amp; Synchronize</span>
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white dark:text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    <span>Publishing Changes...</span>
                </span>
            </button>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500" />
                <span>{{ session('message') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Builder Mode Switcher: Header Builder vs Footer Builder -->
    <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 max-w-md shadow-2xs">
        <button type="button" 
                wire:click="$set('activeMode', 'header')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer"
                :class="'{{ $activeMode }}' === 'header' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
            <x-icon name="solid:compass-drafting" class="w-4 h-4" />
            <span>Header Builder (3 Rows)</span>
        </button>
        <button type="button" 
                wire:click="$set('activeMode', 'footer')"
                class="flex-1 py-2 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer"
                :class="'{{ $activeMode }}' === 'footer' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
            <x-icon name="solid:layer-group" class="w-4 h-4" />
            <span>Footer Builder (3 Rows)</span>
        </button>
    </div>

    <!-- MAIN TWO-COLUMN SPLIT STUDIO -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start"
         x-data="{
             canvasDark: false,
             headerBgState: @js(\App\Services\SmartColorHelper::normalize($headerBgColor)),
             headerTextState: @js(\App\Services\SmartColorHelper::normalize($headerTextColor, '#0f172a', '#ffffff')),
             topbarBgState: @js(\App\Services\SmartColorHelper::normalize($topbarBgColor)),
             topbarTextState: @js(\App\Services\SmartColorHelper::normalize($topbarTextColor, '#334155', '#cbd5e1')),
             headerBottomBgState: @js(\App\Services\SmartColorHelper::normalize($headerBottom['bg_color'] ?? null, '#f8fafc', '#061320')),
             headerBottomTextState: @js(\App\Services\SmartColorHelper::normalize($headerBottom['text_color'] ?? null, '#475569', '#94a3b8')),
             footerTopBgState: @js(\App\Services\SmartColorHelper::normalize($footerTop['bg_color'] ?? null, '#003C58', '#061a28')),
             footerTopTextState: @js(\App\Services\SmartColorHelper::normalize($footerTop['text_color'] ?? null, '#ffffff', '#f1f5f9')),
             footerBgState: @js(\App\Services\SmartColorHelper::normalize($footerBgColor, '#f1f5f9', '#040e17')),
             footerTextState: @js(\App\Services\SmartColorHelper::normalize($footerTextColor, '#334155', '#cbd5e1')),

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

             getHeaderBg() {
                 let fallback = this.canvasDark ? 'rgba(7, 19, 30, 0.88)' : 'rgba(255, 255, 255, 0.9)';
                 if ('{{ $headerStyle }}' === 'solid') fallback = this.canvasDark ? '#07131e' : '#003C58';
                 else if ('{{ $headerStyle }}' === 'transparent') fallback = 'transparent';
                 return this.computeSmartBg(this.headerBgState, this.canvasDark, fallback);
             },
             getHeaderText() {
                 const fallback = this.canvasDark ? '#ffffff' : ('{{ $headerStyle }}' === 'solid' ? '#ffffff' : '#003C58');
                 return this.computeSmartText(this.headerTextState, this.canvasDark, fallback);
             },
             getTopbarBg() {
                 const fallback = this.canvasDark ? 'rgba(5, 15, 24, 0.95)' : 'rgba(255, 255, 255, 0.95)';
                 return this.computeSmartBg(this.topbarBgState, this.canvasDark, fallback);
             },
             getTopbarText() {
                 const fallback = this.canvasDark ? '#cbd5e1' : '#475569';
                 return this.computeSmartText(this.topbarTextState, this.canvasDark, fallback);
             },
             getHeaderBottomBg() {
                 const fallback = this.canvasDark ? 'rgba(6, 19, 32, 0.95)' : 'rgba(248, 250, 252, 0.95)';
                 return this.computeSmartBg(this.headerBottomBgState, this.canvasDark, fallback);
             },
             getHeaderBottomText() {
                 const fallback = this.canvasDark ? '#94a3b8' : '#475569';
                 return this.computeSmartText(this.headerBottomTextState, this.canvasDark, fallback);
             },
             getFooterTopBg() {
                 const fallback = this.canvasDark ? '#061a28' : '#003C58';
                 return this.computeSmartBg(this.footerTopBgState, this.canvasDark, fallback);
             },
             getFooterTopText() {
                 const fallback = this.canvasDark ? '#f1f5f9' : '#ffffff';
                 return this.computeSmartText(this.footerTopTextState, this.canvasDark, fallback);
             },
             getFooterBg() {
                 const fallback = this.canvasDark ? 'rgba(4, 14, 23, 0.95)' : 'rgba(241, 245, 249, 0.95)';
                 return this.computeSmartBg(this.footerBgState, this.canvasDark, fallback);
             },
             getFooterText() {
                 const fallback = this.canvasDark ? '#cbd5e1' : '#475569';
                 return this.computeSmartText(this.footerTextState, this.canvasDark, fallback);
             }
         }"
         @smart-color-changed.window="
             const m = $event.detail.model;
             const c = $event.detail.color;
             if (m === 'headerBgColor') headerBgState = c;
             else if (m === 'headerTextColor') headerTextState = c;
             else if (m === 'topbarBgColor' || m === 'headerTopbar.bg_color') topbarBgState = c;
             else if (m === 'topbarTextColor' || m === 'headerTopbar.text_color') topbarTextState = c;
             else if (m === 'headerBottom.bg_color') headerBottomBgState = c;
             else if (m === 'headerBottom.text_color') headerBottomTextState = c;
             else if (m === 'footerTop.bg_color') footerTopBgState = c;
             else if (m === 'footerTop.text_color') footerTopTextState = c;
             else if (m === 'footerBgColor') footerBgState = c;
             else if (m === 'footerTextColor') footerTextState = c;
         "
    >
        <!-- LEFT COLUMN: CONTROLS & INSPECTOR (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            @if($activeMode === 'header')
                <!-- ==================== HEADER BUILDER (3 ROWS) ==================== -->
                
                <!-- ROW 1: TOPBAR -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                    Row 1: Top Emergency &amp; Information Strip
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                    Utility Row
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                Top utility strip for 24/7 hotline, duty email, social icons, and custom vessel tracking links.
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="headerTopbar.enabled" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                        </label>
                    </div>

                    @if(!empty($headerTopbar['enabled']))
                        <div class="space-y-4 pt-1">
                            <!-- Headline & Tagline -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Emergency Badge Text</label>
                                    <input type="text" wire:model.live="headerTopbar.badge_text" placeholder="24/7 Port Call &amp; Emergency Squads"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Service Tagline</label>
                                    <input type="text" wire:model.live="headerTopbar.subtext" placeholder="Authorized Multi-Brand Turbocharger Engineering"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Phone & Email Overrides -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Hotline Phone Override</label>
                                    <input type="text" wire:model.live="headerTopbar.phone" placeholder="Default: Global Settings Contact Phone"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Duty Email Override</label>
                                    <input type="text" wire:model.live="headerTopbar.email" placeholder="Default: Global Settings Duty Email"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Layout Alignment -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Topbar Content Alignment</label>
                                <select wire:model.live="headerTopbar.alignment" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="between">Space Between (Left: Badge/Text • Right: Phone/Socials)</option>
                                    <option value="center">Centered Strip</option>
                                    <option value="start">Left Aligned</option>
                                </select>
                            </div>

                            <!-- Custom Topbar Link -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Custom Link Label</label>
                                    <input type="text" wire:model.live="headerTopbar.custom_link_text" placeholder="e.g. Vessel Tracking"
                                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Custom Link URL</label>
                                    <input type="text" wire:model.live="headerTopbar.custom_link_url" placeholder="https://... or /tracking"
                                           class="w-full px-2.5 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <!-- DEDICATED ROW 1 BOX MODEL -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                <x-smart-box-model wire:model="topbarBoxModel" :show-width="true" :show-margin="true" :show-border="true" label="Topbar Layout & Box Model (Independent Row 1)" />
                            </div>

                            <!-- DEDICATED ROW 1 STYLING -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                <x-smart-color-picker wire:model="topbarBgColor" :allow-glass="true" label="Topbar Background Color" default-light="#ffffff" default-dark="#050f18" />
                                <x-smart-color-picker wire:model="topbarTextColor" :allow-glass="false" label="Topbar Text Color" default-light="#334155" default-dark="#cbd5e1" />
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ROW 2: MAIN HEADER NAVBAR -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                    Row 2: Main Header Navbar
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                    Primary Navigation
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                Core website navigation row holding the brand logo, navigation menu tree, and call-to-action button.
                            </p>
                        </div>
                    </div>

                    <!-- Appearance & Height -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Navbar Style Preset</label>
                            <select wire:model.live="headerStyle" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="glass">Glass Frosted (Blurred Semi-Transparent - Recommended)</option>
                                <option value="solid">Solid Crisp Background</option>
                                <option value="transparent">Transparent (Floats Directly Over Hero)</option>
                                <option value="floating">Floating Island Navbar (Pill Container)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5">Navbar Height</label>
                            <select wire:model.live="headerHeight" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="64px">Compact (64px)</option>
                                <option value="80px">Standard Corporate (80px - Recommended)</option>
                                <option value="96px">Spacious Grand (96px)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sticky & Theme Switch Toggles -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1 border-t border-slate-100 dark:border-slate-800">
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs text-slate-700 dark:text-slate-300 font-medium">
                            <input type="checkbox" wire:model.live="headerSticky" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                            <div>
                                <span class="font-bold">Sticky Header Navbar</span>
                                <p class="text-[11px] text-slate-400">Keeps navbar fixed on scroll</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs text-slate-700 dark:text-slate-300 font-medium">
                            <input type="checkbox" wire:model.live="headerThemeToggle" class="w-4 h-4 rounded text-[#003C58] focus:ring-0">
                            <div>
                                <span class="font-bold">Dark / Light Mode Toggle</span>
                                <p class="text-[11px] text-slate-400">Show sun/moon theme switch button</p>
                            </div>
                        </label>
                    </div>

                    <!-- Navigation Menu Picker -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">Active Navigation Menu Tree</label>
                            <a href="{{ route('admin.menus') }}" wire:navigate class="text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:underline">
                                Open Menu Builder &rarr;
                            </a>
                        </div>
                        <select wire:model.live="headerMenuId" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            @forelse($availableMenus as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->items_count }} items) [{{ $m->location }}]</option>
                            @empty
                                <option value="">No menus created yet</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Call-to-Action (CTA) Button -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-800 dark:text-slate-200">Header Call to Action (CTA) Button</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="headerCta.enabled" value="1" class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#003C58] dark:peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>

                        @if(!empty($headerCta['enabled']))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Button Label</label>
                                    <input type="text" wire:model.live="headerCta.label" placeholder="Request RFQ"
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Button Destination Link</label>
                                    <x-smart-link-picker wire:model="headerCta.link" />
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- DEDICATED ROW 2 BOX MODEL -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                        <x-smart-box-model wire:model="headerBoxModel" :show-width="true" :show-margin="true" :show-border="true" label="Header Navbar Layout & Box Model (Independent Row 2)" />
                    </div>

                    <!-- DEDICATED ROW 2 STYLING -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-4">
                        <x-smart-color-picker wire:model="headerBgColor" :allow-glass="true" label="Header Background Color" default-light="#ffffff" default-dark="#07131e" />
                        <x-smart-color-picker wire:model="headerTextColor" :allow-glass="false" label="Header Text & Navigation Links Color" default-light="#0f172a" default-dark="#ffffff" />
                    </div>
                </div>

                <!-- ROW 3: BOTTOM SUB-HEADER BAR -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                    Row 3: Bottom Sub-Header Bar
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                    Secondary Strip
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                Strip below the main header for announcements, bulletins, category tabs, or service links.
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
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Announcement / Bulletin Text</label>
                                    <input type="text" wire:model.live="headerBottom.text" placeholder="Authorized Marine Engineering Bulletin..."
                                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Layout Alignment</label>
                                    <select wire:model.live="headerBottom.layout" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                        <option value="between">Split Left &amp; Right</option>
                                        <option value="center">Centered Strip</option>
                                        <option value="start">Left Aligned</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quick Links Repeater -->
                            <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Sub-Header Quick Service Links</span>
                                    <button type="button" wire:click="addHeaderBottomLink" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-white transition-colors flex items-center gap-1 cursor-pointer">
                                        <x-icon name="solid:plus" class="w-3 h-3" />
                                        <span>Add Link</span>
                                    </button>
                                </div>

                                <div class="space-y-2">
                                    @foreach($headerBottom['items'] ?? [] as $bIdx => $bItem)
                                        <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                                            <input type="text" wire:model.live="headerBottom.items.{{ $bIdx }}.label" placeholder="Link Label" class="flex-1 px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                            <input type="text" wire:model.live="headerBottom.items.{{ $bIdx }}.url" placeholder="URL (/services or https://...)" class="flex-1 px-2.5 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                            <button type="button" wire:click="removeHeaderBottomLink({{ $bIdx }})" class="p-1.5 text-rose-500 hover:text-rose-700 cursor-pointer">
                                                <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- DEDICATED ROW 3 BOX MODEL -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                <x-smart-box-model wire:model="headerBottom.box_model" :show-width="true" :show-margin="true" :show-border="true" label="Sub-Header Layout & Box Model (Independent Row 3)" />
                            </div>

                            <!-- DEDICATED ROW 3 STYLING -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                <x-smart-color-picker wire:model="headerBottom.bg_color" :allow-glass="true" label="Sub-Header Background Color" default-light="#f8fafc" default-dark="#061320" />
                                <x-smart-color-picker wire:model="headerBottom.text_color" :allow-glass="false" label="Sub-Header Text Color" default-light="#475569" default-dark="#94a3b8" />
                            </div>
                        </div>
                    @endif
                </div>

            @else
                <!-- ==================== FOOTER BUILDER (3 ROWS) ==================== -->

                <!-- ROW 1: TOP PRE-FOOTER CALLOUT BAR -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                    Row 1: Top Pre-Footer Callout Bar
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                    Pre-Footer Action
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                Pre-footer banner for newsletter bulletin signup, 24/7 emergency port hotline, or custom call-to-action.
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
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Callout Widget Type</label>
                                    <select wire:model.live="footerTop.type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                        <option value="newsletter_callout">✉️ Newsletter Subscription &amp; Bulletin</option>
                                        <option value="hotline_banner">⚓ 24/7 Emergency Port Hotline Banner</option>
                                        <option value="custom_callout">📢 Custom Callout &amp; Action Button</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Headline</label>
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

                            <!-- DEDICATED PRE-FOOTER BOX MODEL -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                <x-smart-box-model wire:model="footerTop.box_model" :show-width="true" :show-margin="true" :show-border="true" label="Pre-Footer Layout & Box Model (Independent Row 1)" />
                            </div>

                            <!-- DEDICATED PRE-FOOTER STYLING -->
                            <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                <x-smart-color-picker wire:model="footerTop.bg_color" :allow-glass="true" label="Pre-Footer Background Color" default-light="#003C58" default-dark="#061a28" />
                                <x-smart-color-picker wire:model="footerTop.text_color" :allow-glass="false" label="Pre-Footer Text Color" default-light="#ffffff" default-dark="#f1f5f9" />
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ROW 2: MAIN MODULAR FOOTER GRID -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                    Row 2: Main Modular Footer Columns
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                    {{ count($footerColumns) }} Columns Configured
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                Customize columns, spans, and modular widgets: Company Info, Menus, Static Lists, Newsletter, Google Map, and Offices.
                            </p>
                        </div>

                        <button type="button" 
                                wire:click="addFooterColumn"
                                @if(count($footerColumns) >= 5) disabled @endif
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 disabled:opacity-50 transition-all cursor-pointer shadow-2xs">
                            <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                            <span>Add Column (Max 5)</span>
                        </button>
                    </div>

                    <!-- Columns Repeater Cards -->
                    <div class="space-y-3">
                        @foreach($footerColumns as $colIdx => $col)
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 cursor-pointer" wire:click="toggleFooterCol({{ $colIdx }})">
                                        <span class="w-6 h-6 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-xs font-mono font-bold">
                                            {{ $colIdx + 1 }}
                                        </span>
                                        <strong class="text-xs text-slate-800 dark:text-slate-200">
                                            {{ $col['title'] ?: 'Untitled Column' }}
                                        </strong>
                                        <span class="text-[10px] px-2 py-0.5 rounded-md bg-cyan-50 dark:bg-cyan-950/40 text-cyan-700 dark:text-cyan-300 font-bold uppercase">
                                            {{ str_replace('_', ' ', $col['type']) }} ({{ ($col['span'] ?? 1) == 2 ? 'Span 2' : 'Span 1' }})
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" wire:click="toggleFooterCol({{ $colIdx }})" class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-white cursor-pointer">
                                            <x-icon name="{{ $expandedFooterColIndex === $colIdx ? 'solid:chevron-up' : 'solid:chevron-down' }}" class="w-3.5 h-3.5" />
                                        </button>
                                        <button type="button" wire:click="removeFooterColumn({{ $colIdx }})" class="p-1 text-rose-500 hover:text-rose-700 cursor-pointer" title="Delete Column">
                                            <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </div>

                                @if($expandedFooterColIndex === $colIdx)
                                    <div class="space-y-3 pt-2 border-t border-slate-200/80 dark:border-slate-800/80">
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Column Title</label>
                                                <input type="text" wire:model.live="footerColumns.{{ $colIdx }}.title" placeholder="e.g. Quick Links"
                                                       class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Widget Type</label>
                                                <select wire:model.live="footerColumns.{{ $colIdx }}.type" class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    <option value="company_info">Company Info &amp; Bio</option>
                                                    <option value="dynamic_menu">Dynamic Navigation Menu</option>
                                                    <option value="static_list">Static Navigation Links</option>
                                                    <option value="newsletter">Newsletter Form</option>
                                                    <option value="contact_offices">Contact &amp; Port Offices</option>
                                                    <option value="custom_text">Custom Text / Description</option>
                                                    <option value="google_map">Google Map Embed</option>
                                                    <option value="custom_html">Raw Custom HTML</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Column Width Span</label>
                                                <select wire:model.live="footerColumns.{{ $colIdx }}.span" class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                                                    <option value="1">1 Column Span</option>
                                                    <option value="2">2 Columns Span (Double Width)</option>
                                                </select>
                                            </div>
                                        </div>

                                        @if($col['type'] === 'static_list')
                                            <!-- Static List Repeater -->
                                            <div class="space-y-2 pt-2 border-t border-slate-200 dark:border-slate-800">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Navigation Items</span>
                                                    <button type="button" wire:click="addStaticListItem({{ $colIdx }})" class="px-2 py-0.5 text-[10px] font-bold rounded bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 text-slate-800 dark:text-white transition-colors cursor-pointer">
                                                        + Add Link
                                                    </button>
                                                </div>
                                                <div class="space-y-1.5">
                                                    @foreach($col['content']['items'] ?? [] as $iIdx => $item)
                                                        <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                                            <input type="text" wire:model.live="footerColumns.{{ $colIdx }}.content.items.{{ $iIdx }}.label" placeholder="Item Label" class="flex-1 px-2 py-1 text-xs rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                                            <div class="flex-1">
                                                                <x-smart-link-picker wire:model="footerColumns.{{ $colIdx }}.content.items.{{ $iIdx }}.link" />
                                                            </div>
                                                            <button type="button" wire:click="removeStaticListItem({{ $colIdx }}, {{ $iIdx }})" class="p-1 text-rose-500 hover:text-rose-700 cursor-pointer">
                                                                <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- DEDICATED MAIN FOOTER BOX MODEL -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                        <x-smart-box-model wire:model="footerBoxModel" :show-width="true" :show-margin="true" :show-border="true" label="Main Footer Layout & Box Model (Independent Row 2)" />
                    </div>

                    <!-- DEDICATED MAIN FOOTER STYLING -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-4">
                        <x-smart-color-picker wire:model="footerBgColor" :allow-glass="true" label="Main Footer Background Color" default-light="#f1f5f9" default-dark="#040e17" />
                        <x-smart-color-picker wire:model="footerTextColor" :allow-glass="false" label="Main Footer Text Color" default-light="#334155" default-dark="#cbd5e1" />
                    </div>
                </div>

                <!-- ROW 3: BOTTOM SUB-FOOTER / COPYRIGHT STRIP -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                    Row 3: Bottom Sub-Footer / Copyright Strip
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                                    Bottom Bar
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                Bottom copyright notice, certification badges, and staff access portal links.
                            </p>
                        </div>
                    </div>

                    <!-- Badges & Features Toggles -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700 dark:text-slate-300">
                            <input type="checkbox" wire:model.live="footerConfig.show_iso" class="w-3.5 h-3.5 rounded text-[#003C58]">
                            <span>ISO / DNV Badges</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700 dark:text-slate-300">
                            <input type="checkbox" wire:model.live="footerConfig.show_social" class="w-3.5 h-3.5 rounded text-[#003C58]">
                            <span>Social Media Icons</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700 dark:text-slate-300">
                            <input type="checkbox" wire:model.live="footerConfig.show_login" class="w-3.5 h-3.5 rounded text-[#003C58]">
                            <span>Staff Portal Link</span>
                        </label>
                    </div>

                    <!-- DEDICATED SUB-FOOTER BOX MODEL -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                        <x-smart-box-model wire:model="footerBottomBoxModel" :show-width="true" :show-margin="true" :show-border="true" label="Sub-Footer Layout & Box Model (Independent Row 3)" />
                    </div>

                    <!-- DEDICATED SUB-FOOTER STYLING -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-4">
                        <x-smart-color-picker wire:model="footerBottomBgColor" :allow-glass="true" label="Sub-Footer Background Color" default-light="#ffffff" default-dark="#02070c" />
                        <x-smart-color-picker wire:model="footerBottomTextColor" :allow-glass="false" label="Sub-Footer Text Color" default-light="#64748b" default-dark="#94a3b8" />
                    </div>
                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN: LIVE COMPONENT CANVAS (5 cols) -->
        <div class="lg:col-span-5 sticky top-24 space-y-4">
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Live Component Canvas</span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold text-emerald-600 bg-emerald-500/10">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live
                        </span>
                    </div>

                    <!-- Canvas Dark Mode Toggle -->
                    <button type="button" @click="canvasDark = !canvasDark"
                            class="px-2.5 py-1 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:border-slate-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                        <span x-text="canvasDark ? '🌙 Dark Mode' : '☀️ Light Mode'"></span>
                    </button>
                </div>

                <!-- Live Mockup Display Container -->
                <div class="p-4 rounded-2xl border transition-all duration-300 space-y-3 overflow-hidden shadow-2xs"
                     :style="canvasDark ? 'background-color: #07131e; border-color: #1e293b; color: #ffffff;' : 'background-color: #f8fafc; border-color: #e2e8f0; color: #0f172a;'">
                    
                    <!-- HEADER PREVIEW SECTION -->
                    <div class="space-y-1.5">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block font-mono">Header Live Preview</span>
                        
                        <!-- Topbar Preview -->
                        @if(!empty($headerTopbar['enabled']))
                            <div class="px-3 py-1 flex items-center justify-between text-[9px] border transition-all rounded-t-xl"
                                 :style="'background: ' + getTopbarBg() + '; color: ' + getTopbarText() + '; border-color: ' + (canvasDark ? '#1e293b' : '#e2e8f0')">
                                <span class="font-bold truncate">{{ $headerTopbar['badge_text'] ?: '24/7 Hotline' }}</span>
                                <div class="flex items-center gap-2 text-[8px] opacity-80 font-mono">
                                    <span>{{ $headerTopbar['phone'] ?: '+880 1800-000000' }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Main Navbar Preview -->
                        <div class="px-3.5 py-2.5 border flex items-center justify-between text-xs transition-all gap-2 duration-300"
                             :style="'border-radius: {{ ($headerStyle === 'floating') ? '9999px' : '12px' }}; background: ' + getHeaderBg() + '; border-color: ' + (canvasDark ? '#1e293b' : '#e2e8f0')">
                            <span class="font-extrabold uppercase tracking-wider text-[11px] shrink-0"
                                  :style="'color: ' + getHeaderText()">
                                {{ \App\Models\Setting::get('site_name', 'NORDROY') }}
                            </span>
                            <div class="flex items-center gap-2 text-[10px] opacity-80 overflow-hidden"
                                 :style="'color: ' + getHeaderText()">
                                <span class="font-medium">Services</span>
                                <span class="font-medium">Balancing</span>
                                <span class="font-medium">Contact</span>
                            </div>
                            @if(!empty($headerCta['enabled']))
                                <span class="px-2 py-1 text-[8px] font-bold rounded text-white shadow-2xs shrink-0"
                                      style="background: linear-gradient(135deg, #003C58, #0ea5e9);">
                                    {{ $headerCta['label'] ?: 'RFQ' }}
                                </span>
                            @endif
                        </div>

                        <!-- Sub-Header Preview -->
                        @if(!empty($headerBottom['enabled']))
                            <div class="px-3 py-1 border flex items-center justify-between text-[8px] transition-all rounded-b-xl"
                                 :style="'background: ' + getHeaderBottomBg() + '; color: ' + getHeaderBottomText() + '; border-color: ' + (canvasDark ? '#1e293b' : '#e2e8f0')">
                                <span class="truncate font-semibold">{{ $headerBottom['text'] ?: 'Notice Bulletin' }}</span>
                                <span class="font-bold underline">Port Squads</span>
                            </div>
                        @endif
                    </div>

                    <!-- FOOTER PREVIEW SECTION -->
                    <div class="space-y-1.5 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block font-mono">Footer Live Preview</span>

                        <!-- Pre-Footer Callout Preview -->
                        @if(!empty($footerTop['enabled']))
                            <div class="p-2.5 rounded-xl border transition-all text-[9px] flex items-center justify-between gap-2"
                                 :style="'background: ' + getFooterTopBg() + '; color: ' + getFooterTopText() + '; border-color: ' + (canvasDark ? '#1e293b' : '#e2e8f0')">
                                <div class="truncate">
                                    <strong class="block truncate text-[10px]">{{ $footerTop['headline'] ?: 'Subscribe to Maritime Bulletins' }}</strong>
                                    <span class="opacity-75 block truncate text-[8px]">{{ $footerTop['subtext'] ?: 'Stay informed with technical alerts' }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-cyan-500 text-slate-950 shrink-0 shadow-2xs">
                                    {{ $footerTop['button_text'] ?: 'Subscribe' }}
                                </span>
                            </div>
                        @endif

                        <!-- Main Modular Footer Preview -->
                        <div class="p-3 border transition-all duration-300 rounded-xl space-y-2 text-[10px]"
                             :style="'background: ' + getFooterBg() + '; color: ' + getFooterText() + '; border-color: ' + (canvasDark ? '#1e293b' : '#e2e8f0')">
                            <div class="flex items-center justify-between pb-1.5 border-b border-black/10 dark:border-white/10">
                                <span class="font-extrabold uppercase tracking-wider text-[11px]">
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
