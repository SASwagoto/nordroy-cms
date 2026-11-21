<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="p-4 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        Homepage Builder &amp; Section Studio
                    </h1>
                    <span class="px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider rounded-md bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300">
                        V2 CMS
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Locked: {{ $selectedSection === 'hero' ? 'Hero Banner' : 'Header' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Customize homepage layout, emergency topbar, sticky navigation, branding logos, colors, and action buttons.
                </p>
            </div>

            <!-- Top Action Controls -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs">
                    <x-icon name="solid:arrow-up-right-from-square" class="w-3.5 h-3.5" />
                    <span>View Frontend</span>
                </a>

                <button type="button" wire:click="restoreProductionDesign" 
                        wire:confirm="Restore real production header design (100% real corporate data, zero demo values)?"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer shadow-2xs"
                        title="Restore 100% Real Production Design">
                    <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                    <span>Restore Real Production Design</span>
                </button>

                <button type="button" wire:click="saveCurrentSection" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveCurrentSection" class="flex items-center gap-1.5">
                        <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                        <span>Save {{ $selectedSection === 'hero' ? 'Hero Banner' : 'Header' }}</span>
                    </span>
                    <span wire:loading wire:target="saveCurrentSection" class="flex items-center gap-1.5">
                        <svg class="animate-spin h-3.5 w-3.5 text-white dark:text-slate-950" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Saving...</span>
                    </span>
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mt-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs font-semibold flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500" />
                    <span>{{ session('message') }}</span>
                </div>
                <span class="text-[10px] text-emerald-600 dark:text-emerald-400 uppercase font-mono">Live Sync</span>
            </div>
        @endif
    </div>

    <!-- 2-Column Customizer Layout: Left Sidebar + Right Workspace -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- ==================== LEFT SIDEBAR: HOMEPAGE SECTIONS ==================== -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-4">
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
                <!-- Sidebar Header -->
                <div class="p-3.5 bg-slate-100 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:cubes" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Homepage Sections</span>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        2 Active Sections (Locked)
                    </span>
                </div>

                <div class="p-3 space-y-2">
                    <!-- 1. LOCKED HEADER (Topbar & Main Navigation) -->
                    <div wire:click="selectSection('header')"
                         class="group p-3 rounded-xl border transition-all cursor-pointer flex items-center justify-between {{ $selectedSection === 'header' ? 'bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-950/50 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700' }}">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                <x-icon name="solid:window-maximize" class="w-3.5 h-3.5" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-bold truncate">Header (Topbar &amp; Navbar)</span>
                                <span class="block text-[9px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pinned &bull; Multi-Row</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="px-1.5 py-0.5 text-[9px] font-mono font-bold uppercase rounded bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 flex items-center gap-1">
                                <x-icon name="solid:lock-closed" class="w-2.5 h-2.5" />
                                <span>LOCKED</span>
                            </span>
                        </div>
                    </div>

                    <!-- 2. LOCKED HERO BANNER -->
                    <div wire:click="selectSection('hero')"
                         class="group p-3 rounded-xl border transition-all cursor-pointer flex items-center justify-between {{ $selectedSection === 'hero' ? 'bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-950/50 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700' }}">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                <x-icon name="solid:sparkles" class="w-3.5 h-3.5" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-bold truncate">Hero Banner</span>
                                <span class="block text-[9px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Industrial Showcase &bull; Dial</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="px-1.5 py-0.5 text-[9px] font-mono font-bold uppercase rounded bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 flex items-center gap-1">
                                <x-icon name="solid:lock-closed" class="w-2.5 h-2.5" />
                                <span>LOCKED</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informational Lock Rule Note -->
                <div class="p-3.5 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 text-[11px] text-slate-600 dark:text-slate-400">
                    <p class="leading-relaxed">
                        <strong class="text-slate-800 dark:text-slate-200">Lock Rule:</strong> The Header and Hero Banner are locked at the top of the homepage hierarchy and cannot be displaced. Other sections will be configured one by one sequentially.
                    </p>
                </div>
            </div>
        </div>

        <!-- ==================== RIGHT WORKSPACE: CUSTOMIZER ==================== -->
        <div class="lg:col-span-8 xl:col-span-9 space-y-6">
            
            @if($selectedSection === 'header')
            <!-- Workspace Card: Header -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
                
                <!-- Workspace Sub-Navigation Tabs -->
                <div class="p-2.5 bg-slate-100 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center gap-1.5 overflow-x-auto">
                    <button type="button" wire:click="setHeaderTab('topbar')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'topbar' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:phone-volume" class="w-3.5 h-3.5" />
                        <span>1. Topbar (Emergency &amp; Contacts)</span>
                        @if($topbar_enabled)
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        @endif
                    </button>

                    <button type="button" wire:click="setHeaderTab('navbar')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'navbar' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:bars-3" class="w-3.5 h-3.5" />
                        <span>2. Main Navbar (Style &amp; Brand)</span>
                    </button>

                    <button type="button" wire:click="setHeaderTab('menu')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'menu' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:list-bullet" class="w-3.5 h-3.5" />
                        <span>3. Navigation Menu</span>
                    </button>

                    <button type="button" wire:click="setHeaderTab('cta')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'cta' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:bolt" class="w-3.5 h-3.5" />
                        <span>4. Actions &amp; CTA</span>
                    </button>
                </div>

                <!-- ==================== TAB 1: TOPBAR CONFIGURATION ==================== -->
                @if($headerTab === 'topbar')
                <div class="p-6 space-y-6">
                    <!-- Strip Master Switch -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Emergency Topbar Configuration</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Controls the topmost strip displaying emergency contacts, secondary tagline, social channels, and portal shortcuts.</p>
                        </div>
                        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                            <input type="checkbox" wire:model.live="topbar_enabled"
                                   class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-[#003C58] dark:text-cyan-500 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Strip</span>
                        </label>
                    </div>

                    <div class="space-y-6 {{ $topbar_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                        <!-- Topbar Width & Background Material Engine -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="flex items-center gap-2">
                                <x-icon name="solid:swatchbook" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Topbar Geometry &amp; Background Engine</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Topbar Width -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Topbar Container Width</label>
                                    <select wire:model.live="topbar_width"
                                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        <option value="container">Corporate Boxed (max-w-[1536px] - Default)</option>
                                        <option value="fluid">Container Fluid (Full Width - 100% with Standard Padding)</option>
                                        <option value="fluid_full">Full Bleed Edge-to-Edge (100% Flush Padding)</option>
                                        <option value="ultrawide">Ultra-Wide Screen (max-w-[1728px] / 108rem)</option>
                                        <option value="desktop">Standard Desktop (max-w-7xl / 1280px)</option>
                                        <option value="narrow">Narrow Container (max-w-6xl / 1152px)</option>
                                        <option value="content_focused">Focused Compact (max-w-5xl / 1024px)</option>
                                    </select>
                                </div>

                                <!-- Topbar Background Type -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Background Material</label>
                                    <select wire:model.live="topbar_bg_type"
                                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        <option value="theme_default">Theme Default (Executive Marine Clean)</option>
                                        <option value="transparent">Fully Transparent</option>
                                        <option value="solid_custom">Solid Custom Palette (Dual Mode)</option>
                                        <option value="gradient">Multicolor Full-Feature Gradient</option>
                                        <option value="glass">Frosted Glass Effect (Custom Transparency)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- If Solid Custom Dual Mode -->
                            @if($topbar_bg_type === 'solid_custom')
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 pt-3 border-t border-slate-200 dark:border-slate-800">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Light BG</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="topbar_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-300">
                                        <input type="text" wire:model.live="topbar_light_bg" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Light Text</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="topbar_light_text" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-300">
                                        <input type="text" wire:model.live="topbar_light_text" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Dark BG</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="topbar_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-700">
                                        <input type="text" wire:model.live="topbar_dark_bg" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Dark Text</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="topbar_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-700">
                                        <input type="text" wire:model.live="topbar_dark_text" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- If Gradient -->
                            @if($topbar_bg_type === 'gradient')
                            <div class="space-y-3 pt-3 border-t border-slate-200 dark:border-slate-800">
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Direction</label>
                                        <select wire:model.live="topbar_gradient_dir"
                                                class="w-full px-2 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                            <option value="to right">To Right &rarr;</option>
                                            <option value="to left">&larr; To Left</option>
                                            <option value="to bottom">To Bottom &darr;</option>
                                            <option value="135deg">Diagonal (135&deg;)</option>
                                            <option value="45deg">Diagonal (45&deg;)</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">From Color</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" wire:model.live="topbar_gradient_from" class="w-7 h-7 rounded-lg cursor-pointer border">
                                            <input type="text" wire:model.live="topbar_gradient_from" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Via Color (Optional)</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" wire:model.live="topbar_gradient_via" class="w-7 h-7 rounded-lg cursor-pointer border">
                                            <input type="text" wire:model.live="topbar_gradient_via" placeholder="None" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">To Color</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" wire:model.live="topbar_gradient_to" class="w-7 h-7 rounded-lg cursor-pointer border">
                                            <input type="text" wire:model.live="topbar_gradient_to" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- If Frosted Glass Effect -->
                            @if($topbar_bg_type === 'glass')
                            <div class="space-y-1.5 pt-3 border-t border-slate-200 dark:border-slate-800">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Frosted Glass Opacity (Strictly Clamped 10% - 90%)</label>
                                    <span class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400">{{ $topbar_glass_opacity }}%</span>
                                </div>
                                <input type="range" min="10" max="90" step="5" wire:model.live="topbar_glass_opacity"
                                       class="w-full accent-[#003C58] dark:accent-cyan-400">
                                <span class="text-[10px] text-slate-500">Enforces high-readability frosted glass (never 0% and never 100%).</span>
                            </div>
                            @endif
                        </div>

                        <!-- 2-COLUMN MODULAR ZONES (LEFT COLUMN & RIGHT COLUMN) -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            
                            <!-- ================= COLUMN 1: LEFT ZONE ================= -->
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Left Column Zone</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500">Notice badge &amp; Tagline</span>
                                </div>

                                <!-- Notice Badge Toggle & Text -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Notice Badge</label>
                                        <input type="checkbox" wire:model="topbar_show_badge" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 {{ $topbar_show_badge ? '' : 'opacity-40 pointer-events-none' }}">
                                        <div class="sm:col-span-2">
                                            <input type="text" wire:model="topbar_badge_text" placeholder="24/7 Port Call & Emergency Squads"
                                                   class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        </div>
                                        <div>
                                            <div x-data="{
                                                    iconVal: @entangle('topbar_badge_icon'),
                                                    get iconUrl() {
                                                        if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/phone-volume.svg';
                                                        if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                            return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                        }
                                                        if (this.iconVal.includes(':')) {
                                                            const p = this.iconVal.split(':');
                                                            return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                        }
                                                        return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                                    }
                                                 }"
                                                 @click="$dispatch('open-icon-picker', { targetField: 'topbar_badge_icon' })"
                                                 class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                                <div class="w-5 h-5 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 p-0.5">
                                                    <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                                    <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                        <x-icon :name="$topbar_badge_icon ?: 'solid:phone-volume'" class="w-3.5 h-3.5" />
                                                    </div>
                                                </div>
                                                <span class="text-[11px] font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary Tagline -->
                                <div class="space-y-1.5 pt-2 border-t border-slate-200 dark:border-slate-800">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Secondary Tagline / Subtitle</label>
                                        <input type="checkbox" wire:model="topbar_show_tagline" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>
                                    <input type="text" wire:model="topbar_tagline" placeholder="Authorized Multi-Brand Turbocharger Engineering"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium {{ $topbar_show_tagline ? '' : 'opacity-40 pointer-events-none' }}">
                                </div>
                            </div>

                            <!-- ================= COLUMN 2: RIGHT ZONE ================= -->
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Right Column Zone</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500">Contacts, Social &amp; Links</span>
                                </div>

                                <!-- Direct Duty Phone -->
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Duty Phone</label>
                                        <input type="checkbox" wire:model="topbar_show_phone" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 {{ $topbar_show_phone ? '' : 'opacity-40 pointer-events-none' }}">
                                        <div class="sm:col-span-2">
                                            <input type="text" wire:model="topbar_phone" placeholder="+880 1800-000000"
                                                   class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        </div>
                                        <div>
                                            <div x-data="{
                                                    iconVal: @entangle('topbar_phone_icon'),
                                                    get iconUrl() {
                                                        if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/phone.svg';
                                                        if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                            return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                        }
                                                        if (this.iconVal.includes(':')) {
                                                            const p = this.iconVal.split(':');
                                                            return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                        }
                                                        return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                                    }
                                                 }"
                                                 @click="$dispatch('open-icon-picker', { targetField: 'topbar_phone_icon' })"
                                                 class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                                <div class="w-5 h-5 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 p-0.5">
                                                    <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                                    <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                        <x-icon :name="$topbar_phone_icon ?: 'solid:phone'" class="w-3.5 h-3.5" />
                                                    </div>
                                                </div>
                                                <span class="text-[11px] font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Operations Email -->
                                <div class="space-y-1.5 pt-2 border-t border-slate-200 dark:border-slate-800">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Operations Email</label>
                                        <input type="checkbox" wire:model="topbar_show_email" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 {{ $topbar_show_email ? '' : 'opacity-40 pointer-events-none' }}">
                                        <div class="sm:col-span-2">
                                            <input type="email" wire:model="topbar_email" placeholder="operations@nordroy.com"
                                                   class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        </div>
                                        <div>
                                            <div x-data="{
                                                    iconVal: @entangle('topbar_email_icon'),
                                                    get iconUrl() {
                                                        if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/envelope.svg';
                                                        if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                            return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                        }
                                                        if (this.iconVal.includes(':')) {
                                                            const p = this.iconVal.split(':');
                                                            return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                        }
                                                        return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                                    }
                                                 }"
                                                 @click="$dispatch('open-icon-picker', { targetField: 'topbar_email_icon' })"
                                                 class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                                <div class="w-5 h-5 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 p-0.5">
                                                    <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                                    <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                        <x-icon :name="$topbar_email_icon ?: 'solid:envelope'" class="w-3.5 h-3.5" />
                                                    </div>
                                                </div>
                                                <span class="text-[11px] font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick'"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Social Links from Settings -->
                                <div class="pt-2 border-t border-slate-200 dark:border-slate-800 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Dynamic Social Media Links</span>
                                            <span class="block text-[10px] text-slate-500">Renders social channels configured in Global Settings</span>
                                        </div>
                                        <input type="checkbox" wire:model="topbar_show_social" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>
                                    @if(count($availableSocialLinks) > 0)
                                        <div class="flex flex-wrap items-center gap-2 p-2 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                                            @foreach($availableSocialLinks as $s)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                                    <x-icon :name="$s['icon'] ?? 'brands:facebook'" class="w-3 h-3 text-[#003C58] dark:text-cyan-400" />
                                                    <span>{{ $s['title'] ?? 'Link' }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-400">No social links yet. Add them in Global Settings &rarr; Social Links.</span>
                                    @endif
                                </div>

                                <!-- Language Switcher & Admin Portal -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-200 dark:border-slate-800">
                                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                                        <div>
                                            <span class="block text-[11px] font-bold text-slate-800 dark:text-slate-200">Language Dropdown</span>
                                            <span class="block text-[9px] text-slate-500">Flags &amp; Locales</span>
                                        </div>
                                        <input type="checkbox" wire:model="topbar_show_lang" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>

                                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                                        <div>
                                            <span class="block text-[11px] font-bold text-slate-800 dark:text-slate-200">Portal / Login Link</span>
                                            <span class="block text-[9px] text-slate-500">Quick Access</span>
                                        </div>
                                        <input type="checkbox" wire:model="topbar_show_portal" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    </div>
                                </div>

                                @if($topbar_show_portal)
                                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2 pt-2">
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Portal Link Label</label>
                                        <input type="text" wire:model="topbar_portal_text" placeholder="Admin Portal &rarr;"
                                               class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <label class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Destination Route / URL</label>
                                            <div class="inline-flex rounded-lg p-0.5 bg-slate-100 dark:bg-slate-800 text-[10px] font-bold">
                                                <button type="button" wire:click="$set('topbar_portal_link_type', 'internal')"
                                                        class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $topbar_portal_link_type === 'internal' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                                    Internal Route
                                                </button>
                                                <button type="button" wire:click="$set('topbar_portal_link_type', 'external')"
                                                        class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $topbar_portal_link_type === 'external' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                                    External URL
                                                </button>
                                            </div>
                                        </div>
                                        @if($topbar_portal_link_type === 'internal')
                                            <select wire:model.live="topbar_portal_url"
                                                    class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                                @foreach($internalLinkOptions as $category => $routes)
                                                    <optgroup label="{{ $category }}">
                                                        @foreach($routes as $rUrl => $rLabel)
                                                            <option value="{{ $rUrl }}">{{ $rLabel }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" wire:model="topbar_portal_url" placeholder="https://..."
                                                   class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- MODULAR CUSTOM ITEMS REPEATER -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                                <div class="flex items-center gap-2">
                                    <x-icon name="solid:puzzle-piece" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Custom Topbar Items &amp; Shortcuts</span>
                                </div>
                                <span class="text-[10px] text-slate-500">Modular repeater for Left or Right Zone</span>
                            </div>

                            <!-- Add New Custom Item Box -->
                            <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Add New Modular Topbar Item</span>
                                    <div class="inline-flex rounded-lg p-0.5 bg-slate-100 dark:bg-slate-800 text-[10px] font-bold">
                                        <button type="button" wire:click="$set('newCustomLinkType', 'internal')"
                                                class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $newCustomLinkType === 'internal' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                            Internal Page
                                        </button>
                                        <button type="button" wire:click="$set('newCustomLinkType', 'external')"
                                                class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $newCustomLinkType === 'external' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                            External URL
                                        </button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-end">
                                    <!-- Zone Selector -->
                                    <div class="sm:col-span-2 space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500">Zone</label>
                                        <select wire:model="newCustomZone"
                                                class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                            <option value="left">Left Zone</option>
                                            <option value="right">Right Zone</option>
                                        </select>
                                    </div>
                                    <!-- Text Label -->
                                    <div class="sm:col-span-3 space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500">Item Label</label>
                                        <input type="text" wire:model="newCustomText" placeholder="e.g. Careers"
                                               class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    </div>
                                    <!-- Icon Picker -->
                                    <div class="sm:col-span-3 space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500">Icon</label>
                                        <div x-data="{
                                                iconVal: @entangle('newCustomIcon'),
                                                get iconUrl() {
                                                    if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/info.svg';
                                                    if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                        return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                    }
                                                    if (this.iconVal.includes(':')) {
                                                        const p = this.iconVal.split(':');
                                                        return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                    }
                                                    return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                                }
                                             }"
                                             @click="$dispatch('open-icon-picker', { targetField: 'newCustomIcon' })"
                                             class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                            <div class="w-4 h-4 rounded bg-slate-200 dark:bg-slate-800 flex items-center justify-center shrink-0 p-0.5">
                                                <img :src="iconUrl" :alt="iconVal" class="w-3 h-3 object-contain dark:invert" 
                                                     onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                                <div style="display:none;" class="w-3 h-3 items-center justify-center">
                                                    <x-icon :name="$newCustomIcon ?: 'solid:info'" class="w-3 h-3" />
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'solid:info'"></span>
                                        </div>
                                    </div>
                                    <!-- URL Target: Smart Internal / External Selector -->
                                    <div class="sm:col-span-3 space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500">Destination</label>
                                        @if($newCustomLinkType === 'internal')
                                            <select wire:model="newCustomUrl"
                                                    class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                                <option value="">-- Choose Page / Section --</option>
                                                @foreach($internalLinkOptions as $category => $routes)
                                                    <optgroup label="{{ $category }}">
                                                        @foreach($routes as $rUrl => $rLabel)
                                                            <option value="{{ $rUrl }}">{{ $rLabel }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" wire:model="newCustomUrl" placeholder="https://..."
                                                   class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        @endif
                                    </div>
                                    <!-- Add Button -->
                                    <div class="sm:col-span-1">
                                        <button type="button" wire:click="addCustomTopbarItem"
                                                class="w-full h-[34px] px-2 rounded-xl text-xs font-bold bg-[#003C58] text-white hover:bg-[#002f45] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 transition-colors flex items-center justify-center cursor-pointer shadow-xs">
                                            <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Items List -->
                            @if(count($topbar_custom_items) > 0)
                            <div class="divide-y divide-slate-200 dark:divide-slate-800 border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden">
                                @foreach($topbar_custom_items as $idx => $item)
                                    <div class="p-2.5 bg-white dark:bg-slate-900 flex items-center justify-between gap-3 text-xs">
                                        <div class="flex items-center gap-2.5">
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase rounded {{ ($item['zone'] ?? 'left') === 'left' ? 'bg-cyan-100 dark:bg-cyan-950 text-cyan-800 dark:text-cyan-300' : 'bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300' }}">
                                                {{ $item['zone'] ?? 'left' }}
                                            </span>
                                            <x-icon :name="$item['icon'] ?? 'solid:info'" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400 shrink-0" />
                                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $item['text'] }}</span>
                                            @if(!empty($item['url']))
                                                <span class="text-[10px] font-mono text-slate-400">({{ $item['url'] }})</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" wire:click="toggleCustomTopbarItem({{ $idx }})"
                                                    class="px-2 py-0.5 rounded text-[10px] font-bold cursor-pointer {{ ($item['is_active'] ?? true) ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                                                {{ ($item['is_active'] ?? true) ? 'Active' : 'Disabled' }}
                                            </button>
                                            <button type="button" wire:click="removeCustomTopbarItem({{ $idx }})"
                                                    class="p-1 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 cursor-pointer">
                                                <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- ==================== TAB 2: MAIN NAVBAR (STYLE & BRAND) ==================== -->
                @if($headerTab === 'navbar')
                <div class="p-6 space-y-6">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">Main Navbar Styling &amp; Geometry</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Configure sticky behavior, container width, height, background transparency, frosted glass effects, and logos.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Navbar Width -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Navbar Container Width</label>
                            <select wire:model.live="header_width"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="container">Corporate Boxed (max-w-[1536px] - Default)</option>
                                <option value="fluid">Container Fluid (Full Width - 100% with Standard Padding)</option>
                                <option value="fluid_full">Full Bleed Edge-to-Edge (100% Flush Padding)</option>
                                <option value="ultrawide">Ultra-Wide Screen (max-w-[1728px] / 108rem)</option>
                                <option value="desktop">Standard Desktop (max-w-7xl / 1280px)</option>
                                <option value="narrow">Narrow Container (max-w-6xl / 1152px)</option>
                                <option value="content_focused">Focused Compact (max-w-5xl / 1024px)</option>
                            </select>
                        </div>

                        <!-- Header Height -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Navbar Height</label>
                            <select wire:model="header_height"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="70px">Compact (70px)</option>
                                <option value="80px">Standard (80px - Default)</option>
                                <option value="90px">Spacious (90px)</option>
                                <option value="100px">Grand (100px)</option>
                            </select>
                        </div>

                        <!-- Sticky Toggle -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="block text-xs font-bold text-slate-900 dark:text-white">Sticky Header on Scroll</span>
                                <span class="block text-[10px] text-slate-500">Pins navbar to top of viewport when scrolling</span>
                            </div>
                            <input type="checkbox" wire:model="header_sticky" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <!-- Border Style -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Border &amp; Elevation</label>
                            <select wire:model="header_border_style"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="border">Subtle Bottom Border (Executive Standard)</option>
                                <option value="shadow">Ambient Drop Shadow</option>
                                <option value="none">Flat (No Border or Shadow)</option>
                            </select>
                        </div>

                        <!-- Background Material Engine -->
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Navbar Background Material</label>
                            <select wire:model.live="header_bg_type"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="glass">Frosted Glassmorphism (Executive Standard)</option>
                                <option value="theme_default">Theme Default (Pure Surface)</option>
                                <option value="transparent">Fully Transparent</option>
                                <option value="solid_custom">Solid Custom Palette (Dual Mode)</option>
                                <option value="gradient">Multicolor Full-Feature Gradient</option>
                            </select>
                        </div>

                        <!-- Frosted Opacity Slider (When glass selected) -->
                        @if($header_bg_type === 'glass')
                        <div class="md:col-span-2 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Glass Opacity (Strictly Clamped 10% - 90%)</label>
                                <span class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400">{{ $header_glass_opacity }}%</span>
                            </div>
                            <input type="range" min="10" max="90" step="5" wire:model.live="header_glass_opacity"
                                   class="w-full accent-[#003C58] dark:accent-cyan-400">
                            <span class="text-[10px] text-slate-500">Ensures background backdrop filter blur works beautifully without 0% wash-out or 100% opacity loss.</span>
                        </div>
                        @endif

                        <!-- Custom Dual Mode Colors -->
                        @if($header_bg_type === 'solid_custom')
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Light BG</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="header_custom_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-300">
                                    <input type="text" wire:model.live="header_custom_light_bg" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Light Text</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="header_custom_light_text" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-300">
                                    <input type="text" wire:model.live="header_custom_light_text" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Dark BG</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="header_custom_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-700">
                                    <input type="text" wire:model.live="header_custom_dark_bg" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Dark Text</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" wire:model.live="header_custom_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-700">
                                    <input type="text" wire:model.live="header_custom_dark_text" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Gradient Controls -->
                        @if($header_bg_type === 'gradient')
                        <div class="md:col-span-2 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Direction</label>
                                    <select wire:model.live="header_gradient_dir"
                                            class="w-full px-2 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                        <option value="to right">To Right &rarr;</option>
                                        <option value="to left">&larr; To Left</option>
                                        <option value="to bottom">To Bottom &darr;</option>
                                        <option value="135deg">Diagonal (135&deg;)</option>
                                        <option value="45deg">Diagonal (45&deg;)</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">From Color</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="header_gradient_from" class="w-7 h-7 rounded-lg cursor-pointer border">
                                        <input type="text" wire:model.live="header_gradient_from" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Via Color</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="header_gradient_via" class="w-7 h-7 rounded-lg cursor-pointer border">
                                        <input type="text" wire:model.live="header_gradient_via" placeholder="None" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">To Color</label>
                                    <div class="flex items-center gap-1.5">
                                        <input type="color" wire:model.live="header_gradient_to" class="w-7 h-7 rounded-lg cursor-pointer border">
                                        <input type="text" wire:model.live="header_gradient_to" class="w-full px-2 py-1 text-xs rounded-lg border border-slate-200 dark:border-slate-800 font-mono bg-white dark:bg-slate-900 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Brand Logo Display & Scaling (Theme Studio Synchronized) -->
                        <div class="md:col-span-2 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <span class="block text-xs font-bold text-slate-900 dark:text-white">Brand Logo Scale</span>
                                    <span class="block text-[10px] text-slate-500">Logo files and site name are automatically synchronized from Global Settings &amp; Theme Studio (no manual file paths needed).</span>
                                </div>
                                <a href="{{ route('admin.theme') }}" target="_blank"
                                   class="text-[11px] font-bold text-[#003C58] dark:text-cyan-400 hover:underline shrink-0">
                                    Manage Logo in Theme Studio &rarr;
                                </a>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Display Height</label>
                                <span class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400">{{ $header_logo_height }}px</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="range" min="20" max="80" step="2" wire:model.live="header_logo_height"
                                       class="w-full accent-[#003C58] dark:accent-cyan-400">
                                <input type="number" min="20" max="100" wire:model.live="header_logo_height"
                                       class="w-20 px-2 py-1 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium text-center">
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ==================== TAB 3: NAVIGATION MENU ==================== -->
                @if($headerTab === 'menu')
                <div class="p-6 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Navigation Menu Assignment</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Select which menu governs the main desktop links and mobile drawer.</p>
                        </div>
                        <a href="{{ route('admin.menus') }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 hover:opacity-80 transition-opacity">
                            <x-icon name="solid:bars-staggered" class="w-3.5 h-3.5" />
                            <span>Edit in Menu Manager &rarr;</span>
                        </a>
                    </div>

                    <div class="space-y-4 max-w-xl">
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Active Navigation Menu Source</label>
                            <select wire:model.live="header_menu_id"
                                    class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-bold">
                                @foreach($availableMenus as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} (Location: {{ strtoupper($m->location) }})</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Selecting a menu here instantly connects its parent links and child dropdowns to the primary header.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ==================== TAB 4: ACTIONS & CTA ==================== -->
                @if($headerTab === 'cta')
                <div class="p-6 space-y-6">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">Header Action Controls &amp; CTA Button</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Configure the primary call-to-action button and theme toggle switches.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Theme Toggle Switch -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="block text-xs font-bold text-slate-900 dark:text-white">Dark / Light Mode Switcher</span>
                                <span class="block text-[10px] text-slate-500">0ms instant theme toggle button</span>
                            </div>
                            <input type="checkbox" wire:model="header_show_theme_toggle" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <!-- CTA Button Enabled -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="block text-xs font-bold text-slate-900 dark:text-white">Header CTA Action Button</span>
                                <span class="block text-[10px] text-slate-500">Show primary button in navbar</span>
                            </div>
                            <input type="checkbox" wire:model="header_cta_enabled" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <!-- CTA Button Text -->
                        <div class="space-y-1.5 {{ $header_cta_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">CTA Button Label</label>
                            <input type="text" wire:model="header_cta_text" placeholder="Request RFQ"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- CTA Button URL: Smart Internal / External Selector -->
                        <div class="space-y-1.5 {{ $header_cta_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">CTA Target Destination</label>
                                <div class="inline-flex rounded-lg p-0.5 bg-slate-200 dark:bg-slate-800 text-[10px] font-bold">
                                    <button type="button" wire:click="$set('header_cta_link_type', 'internal')"
                                            class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $header_cta_link_type === 'internal' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                        Internal Page
                                    </button>
                                    <button type="button" wire:click="$set('header_cta_link_type', 'external')"
                                            class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $header_cta_link_type === 'external' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                        External URL
                                    </button>
                                </div>
                            </div>

                            @if($header_cta_link_type === 'internal')
                                <select wire:model.live="header_cta_url"
                                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    @foreach($internalLinkOptions as $category => $routes)
                                        <optgroup label="{{ $category }}">
                                            @foreach($routes as $rUrl => $rLabel)
                                                <option value="{{ $rUrl }}">{{ $rLabel }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" wire:model="header_cta_url" placeholder="https://..."
                                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                            @endif
                        </div>

                        <!-- CTA Button Icon -->
                        <div class="space-y-1.5 {{ $header_cta_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">CTA Button Icon</label>
                            <div x-data="{
                                    iconVal: @entangle('header_cta_icon'),
                                    get iconUrl() {
                                        if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/clipboard-document-list.svg';
                                        if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                            return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                        }
                                        if (this.iconVal.includes(':')) {
                                            const p = this.iconVal.split(':');
                                            return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                        }
                                        return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                    }
                                 }"
                                 @click="$dispatch('open-icon-picker', { targetField: 'header_cta_icon' })"
                                 class="flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[38px]">
                                <div class="w-6 h-6 rounded-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-1 group-hover:scale-105 transition-transform text-cyan-600 dark:text-cyan-400">
                                    <img :src="iconUrl" :alt="iconVal" class="w-4 h-4 object-contain dark:invert" 
                                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                    <div style="display:none;" class="w-4 h-4 items-center justify-center">
                                        <x-icon :name="$header_cta_icon ?: 'solid:clipboard-document-list'" class="w-4 h-4" />
                                    </div>
                                </div>
                                <span class="text-xs font-mono text-slate-800 dark:text-slate-200 truncate flex-1" x-text="iconVal || 'solid:clipboard-document-list'"></span>
                                <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                            </div>
                        </div>

                        <!-- CTA Button Style -->
                        <div class="space-y-1.5 {{ $header_cta_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Button Style</label>
                            <select wire:model="header_cta_style"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="primary_gradient">Primary Brand Gradient</option>
                                <option value="outline">Subtle Outline</option>
                                <option value="solid_dark">Solid High-Contrast</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Bottom Save Footer Inside Workspace -->
                <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <span class="text-[11px] text-slate-500 dark:text-slate-400">
                        Changes apply directly across the homepage and all platform layouts.
                    </span>

                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="restoreProductionDesign"
                                wire:confirm="Restore real production header design (100% real corporate data)?"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                            <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                            <span>Restore Real Design</span>
                        </button>

                        <button type="button" wire:click="saveHeader" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                            <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                            <span>Save Header Changes</span>
                        </button>
                    </div>
                </div>

            </div>
            @endif

            <!-- ==================== HERO BANNER WORKSPACE CARD ==================== -->
            @if($selectedSection === 'hero')
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
                
                <!-- Workspace Sub-Navigation Tabs for Hero Banner -->
                <div class="p-2.5 bg-slate-100 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center gap-1.5 overflow-x-auto">
                    <button type="button" wire:click="setHeroTab('layout')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $heroTab === 'layout' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:swatchbook" class="w-3.5 h-3.5" />
                        <span>1. Layout &amp; Backdrop</span>
                        @if($hero_enabled)
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        @endif
                    </button>

                    <button type="button" wire:click="setHeroTab('content')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $heroTab === 'content' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:language" class="w-3.5 h-3.5" />
                        <span>2. Badges &amp; Typography</span>
                    </button>

                    <button type="button" wire:click="setHeroTab('actions')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $heroTab === 'actions' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:chart-simple" class="w-3.5 h-3.5" />
                        <span>3. Actions &amp; Metrics</span>
                    </button>

                    <button type="button" wire:click="setHeroTab('instrument')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $heroTab === 'instrument' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800' }}">
                        <x-icon name="solid:gauge" class="w-3.5 h-3.5" />
                        <span>4. Instrument &amp; HUD</span>
                    </button>
                </div>

                <!-- ==================== TAB 1: LAYOUT & BACKDROP ==================== -->
                @if($heroTab === 'layout')
                <div class="p-6 space-y-6">
                    <!-- Hero Master Switch -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Hero Layout &amp; Backdrop Configuration</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Controls container width, vertical padding, dot matrix grid overlay, and dual-mode background engines.</p>
                        </div>
                        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                            <input type="checkbox" wire:model.live="hero_enabled"
                                   class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-[#003C58] dark:text-cyan-500 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Hero</span>
                        </label>
                    </div>

                    <div class="space-y-6 {{ $hero_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                        <!-- Geometry & Container Settings -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="flex items-center gap-2">
                                <x-icon name="solid:swatchbook" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Hero Geometry &amp; Container Width</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Container Width -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center justify-between">
                                        <span>Container Width</span>
                                        <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400">{{ $hero_width }}</span>
                                    </label>
                                    <select wire:model.live="hero_width"
                                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20">
                                        <option value="container">Standard Corporate Container (max-w-7xl)</option>
                                        <option value="fluid">Fluid Container (max-w-[1536px])</option>
                                        <option value="fluid_full">Full Width Fluid (w-full)</option>
                                        <option value="ultrawide">Ultra-Wide Heavy Duty (max-w-[1720px])</option>
                                        <option value="desktop">Fixed Desktop Layout (max-w-6xl)</option>
                                        <option value="narrow">Focused Compact Width (max-w-5xl)</option>
                                        <option value="content_focused">Content-Focused Reader (max-w-4xl)</option>
                                    </select>
                                </div>

                                <!-- Vertical Section Padding -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center justify-between">
                                        <span>Vertical Section Padding</span>
                                        <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400">{{ $hero_padding }}</span>
                                    </label>
                                    <select wire:model.live="hero_padding"
                                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20">
                                        <option value="compact">Compact Dense (py-10 sm:py-14 lg:py-16)</option>
                                        <option value="standard">Standard Maritime (py-16 sm:py-20 lg:py-24)</option>
                                        <option value="spacious">Spacious Engineering (py-20 sm:py-28 lg:py-32)</option>
                                        <option value="extra_spacious">Extra Spacious Showcase (py-24 sm:py-36 lg:py-40)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Geometric Dot Matrix Grid Overlay -->
                            <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                                <div>
                                    <label class="text-xs font-bold text-slate-800 dark:text-slate-200">Industrial Dot Matrix Grid Overlay</label>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Renders a subtle radial micro-grid pattern across the Hero section backdrop.</p>
                                </div>
                                <input type="checkbox" wire:model.live="hero_grid_enabled"
                                       class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-[#003C58] dark:text-cyan-500 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                            </div>
                        </div>

                        <!-- Background Engine Type -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <x-icon name="solid:palette" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Hero Background Engine</span>
                                </div>
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                    {{ strtoupper($hero_bg_type) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                                @foreach([
                                    'frosted' => ['Frosted Maritime', 'Default theme blend'],
                                    'transparent' => ['Transparent', 'Inherit canvas'],
                                    'subtle_tint' => ['Subtle Tint', 'Low-contrast tint'],
                                    'solid_custom' => ['Solid Dual-Mode', 'Light & dark colors'],
                                    'gradient' => ['Gradient', 'Multicolor angle'],
                                    'glass' => ['Frosted Glass', 'Opacity clamped slider']
                                ] as $bgKey => $bgInfo)
                                <button type="button" wire:click="$set('hero_bg_type', '{{ $bgKey }}')"
                                        class="p-2.5 rounded-xl border text-left transition-all cursor-pointer {{ $hero_bg_type === $bgKey ? 'bg-white dark:bg-slate-900 border-[#003C58] dark:border-cyan-500 shadow-xs ring-1 ring-[#003C58] dark:ring-cyan-500' : 'bg-slate-100/60 dark:bg-slate-900/60 border-slate-200 dark:border-slate-800 hover:border-slate-300' }}">
                                    <span class="block text-xs font-bold text-slate-900 dark:text-white">{{ $bgInfo[0] }}</span>
                                    <span class="block text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ $bgInfo[1] }}</span>
                                </button>
                                @endforeach
                            </div>

                            <!-- Glass Opacity Controls -->
                            @if($hero_bg_type === 'glass')
                            <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Frosted Glass Opacity (Clamped 10% - 90%)</label>
                                    <span class="px-2 py-0.5 text-xs font-mono font-bold rounded bg-cyan-500/10 text-cyan-600 dark:text-cyan-400">
                                        {{ $hero_glass_opacity }}%
                                    </span>
                                </div>
                                <input type="range" wire:model.live="hero_glass_opacity" min="10" max="90" step="5"
                                       class="w-full accent-cyan-500 cursor-pointer">
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">Prevents unreadable 0% invisible or 100% flat glass.</p>
                            </div>
                            @endif

                            <!-- Solid Custom Dual-Mode Controls -->
                            @if($hero_bg_type === 'solid_custom')
                            <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200">Dual-Mode Color Setup (Light vs Dark)</div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Light Mode -->
                                    <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                                        <span class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                            <x-icon name="solid:sun" class="w-3.5 h-3.5 text-amber-500" />
                                            Light Mode
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <input type="color" wire:model.live="hero_light_bg" class="w-8 h-8 rounded border-0 cursor-pointer">
                                            <input type="text" wire:model="hero_light_bg" class="flex-1 px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Text Color</label>
                                            <div class="flex items-center gap-2">
                                                <input type="color" wire:model.live="hero_light_text" class="w-7 h-7 rounded border-0 cursor-pointer">
                                                <input type="text" wire:model="hero_light_text" class="flex-1 px-3 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dark Mode -->
                                    <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                                        <span class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                            <x-icon name="solid:moon" class="w-3.5 h-3.5 text-cyan-400" />
                                            Dark Mode
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <input type="color" wire:model.live="hero_dark_bg" class="w-8 h-8 rounded border-0 cursor-pointer">
                                            <input type="text" wire:model="hero_dark_bg" class="flex-1 px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Text Color</label>
                                            <div class="flex items-center gap-2">
                                                <input type="color" wire:model.live="hero_dark_text" class="w-7 h-7 rounded border-0 cursor-pointer">
                                                <input type="text" wire:model="hero_dark_text" class="flex-1 px-3 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Gradient Controls -->
                            @if($hero_bg_type === 'gradient')
                            <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200">Multicolor Gradient Controls</div>
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Direction</label>
                                        <select wire:model.live="hero_gradient_dir"
                                                class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                            <option value="135deg">135° Industrial Angle</option>
                                            <option value="to right">To Right (Horizontal)</option>
                                            <option value="to bottom">To Bottom (Vertical)</option>
                                            <option value="to bottom right">To Bottom Right</option>
                                            <option value="45deg">45° Diagonal</option>
                                            <option value="90deg">90° Top to Bottom</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">From Color</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" wire:model.live="hero_gradient_from" class="w-7 h-7 rounded border-0 cursor-pointer">
                                            <input type="text" wire:model="hero_gradient_from" class="w-full px-2 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Via Color (Optional)</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" wire:model.live="hero_gradient_via" class="w-7 h-7 rounded border-0 cursor-pointer">
                                            <input type="text" wire:model="hero_gradient_via" placeholder="#003C58" class="w-full px-2 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">To Color</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" wire:model.live="hero_gradient_to" class="w-7 h-7 rounded border-0 cursor-pointer">
                                            <input type="text" wire:model="hero_gradient_to" class="w-full px-2 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-800 flex items-center justify-between"
                                     style="background: linear-gradient({{ $hero_gradient_dir }}, {{ $hero_gradient_from }}{{ $hero_gradient_via ? ', ' . $hero_gradient_via : '' }}, {{ $hero_gradient_to }});">
                                    <span class="text-xs font-bold text-white drop-shadow">Gradient Preview Canvas</span>
                                    <span class="text-[10px] font-mono text-white/80 drop-shadow">{{ $hero_gradient_dir }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- ==================== TAB 2: BADGES & TYPOGRAPHY ==================== -->
                @if($heroTab === 'content')
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Badges &amp; Headline Typography</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Customize authority trust badges, primary statement headline, and technical engineering description.</p>
                        </div>
                    </div>

                    <!-- Authority Badges -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                        <div class="flex items-center gap-2">
                            <x-icon name="solid:award" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Authority Badges</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Badge 1 -->
                            <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-slate-800 dark:text-slate-200">Authority Badge #1</label>
                                    <input type="checkbox" wire:model.live="hero_badge1_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                </div>
                                <div class="space-y-2 {{ $hero_badge1_enabled ? '' : 'opacity-40 pointer-events-none' }}">
                                    <input type="text" wire:model="hero_badge1_text" placeholder="Authorized Multi-Brand Turbocharger Engineering"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    
                                    <div x-data="{
                                            iconVal: @entangle('hero_badge1_icon'),
                                            get iconUrl() {
                                                if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/shield-check.svg';
                                                if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                    return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                }
                                                if (this.iconVal.includes(':')) {
                                                    const p = this.iconVal.split(':');
                                                    return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                }
                                                return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                            }
                                         }"
                                         @click="$dispatch('open-icon-picker', { targetField: 'hero_badge1_icon' })"
                                         class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                        <div class="w-5 h-5 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-0.5 text-cyan-600 dark:text-cyan-400">
                                            <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                 onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                            <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                <x-icon :name="$hero_badge1_icon ?: 'solid:shield-check'" class="w-3.5 h-3.5" />
                                            </div>
                                        </div>
                                        <span class="text-xs font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick Icon'"></span>
                                        <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Badge 2 -->
                            <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-slate-800 dark:text-slate-200">Authority Badge #2</label>
                                    <input type="checkbox" wire:model.live="hero_badge2_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                </div>
                                <div class="space-y-2 {{ $hero_badge2_enabled ? '' : 'opacity-40 pointer-events-none' }}">
                                    <input type="text" wire:model="hero_badge2_text" placeholder="ISO 9001:2015 • DNV Certified"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    
                                    <div x-data="{
                                            iconVal: @entangle('hero_badge2_icon'),
                                            get iconUrl() {
                                                if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/award.svg';
                                                if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                    return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                }
                                                if (this.iconVal.includes(':')) {
                                                    const p = this.iconVal.split(':');
                                                    return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                }
                                                return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                            }
                                         }"
                                         @click="$dispatch('open-icon-picker', { targetField: 'hero_badge2_icon' })"
                                         class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                        <div class="w-5 h-5 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-0.5 text-cyan-600 dark:text-cyan-400">
                                            <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                 onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                            <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                <x-icon :name="$hero_badge2_icon ?: 'solid:award'" class="w-3.5 h-3.5" />
                                            </div>
                                        </div>
                                        <span class="text-xs font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick Icon'"></span>
                                        <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Headline & Subtitle -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                        <div class="flex items-center gap-2">
                            <x-icon name="solid:heading" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Hero Statement &amp; Subtitle</span>
                        </div>

                        <div class="space-y-4">
                            <!-- Headline -->
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Primary Headline Statement</label>
                                <textarea wire:model="hero_title" rows="2"
                                          placeholder="Precision Turbocharger Overhauls &amp; Marine Propulsion Support."
                                          class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20"></textarea>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">Main value proposition statement displayed in prominent display typography.</p>
                            </div>

                            <!-- Subtitle -->
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Technical Engineering Subtitle</label>
                                <textarea wire:model="hero_subtitle" rows="3"
                                          placeholder="Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil &amp; gas terminals."
                                          class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20"></textarea>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400">Detailed industrial scope of capability and vessel/plant classifications.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ==================== TAB 3: ACTIONS & METRICS ==================== -->
                @if($heroTab === 'actions')
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Call-to-Action Buttons &amp; Technical Metrics Strip</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Configure conversion action buttons with internal or external links, and the 3-metric technical highlight bar.</p>
                        </div>
                    </div>

                    <!-- CTA 1 and CTA 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- CTA 1 -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3.5">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Primary CTA (Button 1)</span>
                                </div>
                                <input type="checkbox" wire:model.live="hero_cta1_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                            </div>

                            <div class="space-y-3 {{ $hero_cta1_enabled ? '' : 'opacity-40 pointer-events-none' }}">
                                <!-- Label -->
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Button Label</label>
                                    <input type="text" wire:model="hero_cta1_text" placeholder="Explore Overhaul Services"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                </div>

                                <!-- Link Destination -->
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Destination Link</label>
                                        <div class="inline-flex rounded-lg bg-slate-200 dark:bg-slate-800 p-0.5 text-[10px]">
                                            <button type="button" wire:click="$set('hero_cta1_link_type', 'internal')"
                                                    class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $hero_cta1_link_type === 'internal' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                                Internal Route
                                            </button>
                                            <button type="button" wire:click="$set('hero_cta1_link_type', 'external')"
                                                    class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $hero_cta1_link_type === 'external' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                                External URL
                                            </button>
                                        </div>
                                    </div>

                                    @if($hero_cta1_link_type === 'internal')
                                        <select wire:model.live="hero_cta1_url"
                                                class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                            @foreach($internalLinkOptions as $category => $routes)
                                                <optgroup label="{{ $category }}">
                                                    @foreach($routes as $rUrl => $rLabel)
                                                        <option value="{{ $rUrl }}">{{ $rLabel }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" wire:model="hero_cta1_url" placeholder="https://..."
                                               class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    @endif
                                </div>

                                <!-- Icon -->
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Button Icon</label>
                                    <div x-data="{
                                            iconVal: @entangle('hero_cta1_icon'),
                                            get iconUrl() {
                                                if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/arrow-right.svg';
                                                if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                    return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                }
                                                if (this.iconVal.includes(':')) {
                                                    const p = this.iconVal.split(':');
                                                    return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                }
                                                return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                            }
                                         }"
                                         @click="$dispatch('open-icon-picker', { targetField: 'hero_cta1_icon' })"
                                         class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                        <div class="w-5 h-5 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 p-0.5 text-cyan-600 dark:text-cyan-400">
                                            <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                 onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                            <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                <x-icon :name="$hero_cta1_icon ?: 'solid:arrow-right'" class="w-3.5 h-3.5" />
                                            </div>
                                        </div>
                                        <span class="text-xs font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick Icon'"></span>
                                        <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                                    </div>
                                </div>

                                <!-- Style -->
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Style</label>
                                    <select wire:model="hero_cta1_style"
                                            class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        <option value="primary_gradient">Primary Brand Gradient</option>
                                        <option value="solid_dark">Solid High-Contrast</option>
                                        <option value="outline">Subtle Outline</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- CTA 2 -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3.5">
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Secondary CTA (Button 2)</span>
                                </div>
                                <input type="checkbox" wire:model.live="hero_cta2_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                            </div>

                            <div class="space-y-3 {{ $hero_cta2_enabled ? '' : 'opacity-40 pointer-events-none' }}">
                                <!-- Label -->
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Button Label</label>
                                    <input type="text" wire:model="hero_cta2_text" placeholder="Request Instant RFQ"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                </div>

                                <!-- Link Destination -->
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Destination Link</label>
                                        <div class="inline-flex rounded-lg bg-slate-200 dark:bg-slate-800 p-0.5 text-[10px]">
                                            <button type="button" wire:click="$set('hero_cta2_link_type', 'internal')"
                                                    class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $hero_cta2_link_type === 'internal' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                                Internal Route
                                            </button>
                                            <button type="button" wire:click="$set('hero_cta2_link_type', 'external')"
                                                    class="px-2 py-0.5 rounded-md transition-all cursor-pointer {{ $hero_cta2_link_type === 'external' ? 'bg-white dark:bg-slate-950 text-[#003C58] dark:text-cyan-400 shadow-2xs font-bold' : 'text-slate-500' }}">
                                                External URL
                                            </button>
                                        </div>
                                    </div>

                                    @if($hero_cta2_link_type === 'internal')
                                        <select wire:model.live="hero_cta2_url"
                                                class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                            @foreach($internalLinkOptions as $category => $routes)
                                                <optgroup label="{{ $category }}">
                                                    @foreach($routes as $rUrl => $rLabel)
                                                        <option value="{{ $rUrl }}">{{ $rLabel }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" wire:model="hero_cta2_url" placeholder="https://..."
                                               class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                    @endif
                                </div>

                                <!-- Icon -->
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Button Icon</label>
                                    <div x-data="{
                                            iconVal: @entangle('hero_cta2_icon'),
                                            get iconUrl() {
                                                if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/clipboard-document-list.svg';
                                                if (this.iconVal.startsWith('storage/') || this.iconVal.startsWith('http') || this.iconVal.startsWith('/')) {
                                                    return this.iconVal.startsWith('http') ? this.iconVal : '/' + this.iconVal.replace(/^\/+/, '');
                                                }
                                                if (this.iconVal.includes(':')) {
                                                    const p = this.iconVal.split(':');
                                                    return '/assets/plugins/fontawesome/svgs/' + p[0] + '/' + p[1] + '.svg';
                                                }
                                                return '/assets/plugins/fontawesome/svgs/solid/' + this.iconVal + '.svg';
                                            }
                                         }"
                                         @click="$dispatch('open-icon-picker', { targetField: 'hero_cta2_icon' })"
                                         class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[34px]">
                                        <div class="w-5 h-5 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 p-0.5 text-cyan-600 dark:text-cyan-400">
                                            <img :src="iconUrl" :alt="iconVal" class="w-3.5 h-3.5 object-contain dark:invert" 
                                                 onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                            <div style="display:none;" class="w-3.5 h-3.5 items-center justify-center">
                                                <x-icon :name="$hero_cta2_icon ?: 'solid:clipboard-document-list'" class="w-3.5 h-3.5" />
                                            </div>
                                        </div>
                                        <span class="text-xs font-mono truncate flex-1 text-slate-700 dark:text-slate-300" x-text="iconVal || 'Pick Icon'"></span>
                                        <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                                    </div>
                                </div>

                                <!-- Style -->
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Style</label>
                                    <select wire:model="hero_cta2_style"
                                            class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                        <option value="surface_border">Surface Border / Subtle Glass</option>
                                        <option value="outline">Subtle Outline</option>
                                        <option value="solid_dark">Solid High-Contrast</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Metrics Strip -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <x-icon name="solid:chart-simple" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Technical Metrics Strip</span>
                            </div>
                            <input type="checkbox" wire:model.live="hero_metrics_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 {{ $hero_metrics_enabled ? '' : 'opacity-40 pointer-events-none' }}">
                            <!-- Metric 1 -->
                            <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Metric 1</span>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Numeric Value</label>
                                    <input type="text" wire:model="hero_metric1_value" placeholder="100,000"
                                           class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Description Label</label>
                                    <input type="text" wire:model="hero_metric1_label" placeholder="RPM Dynamic Balancing"
                                           class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Metric 2 -->
                            <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Metric 2</span>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Numeric Value</label>
                                    <input type="text" wire:model="hero_metric2_value" placeholder="24/7/365"
                                           class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Description Label</label>
                                    <input type="text" wire:model="hero_metric2_label" placeholder="Flying Squads to Port"
                                           class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Metric 3 -->
                            <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Metric 3</span>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Numeric Value</label>
                                    <input type="text" wire:model="hero_metric3_value" placeholder="10,000+"
                                           class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Description Label</label>
                                    <input type="text" wire:model="hero_metric3_label" placeholder="OEM Spares in Stock"
                                           class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- ==================== TAB 4: INSTRUMENT & HUD ==================== -->
                @if($heroTab === 'instrument')
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Visual Instrument Dial &amp; Technical HUD</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Turbine tachometer dial showcase, rotation animation controls, cardinal point graduations, and equipment HUD specs.</p>
                        </div>
                        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                            <input type="checkbox" wire:model.live="hero_visual_enabled"
                                   class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-[#003C58] dark:text-cyan-500 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Showcase</span>
                        </label>
                    </div>

                    <div class="space-y-6 {{ $hero_visual_enabled ? '' : 'opacity-40 pointer-events-none' }}">
                        <!-- Dial Controls -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <x-icon name="solid:gauge" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Turbine Tachometer Dial</span>
                                </div>
                                <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                    <input type="checkbox" wire:model="hero_tacho_animated" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                                    <span>Turbine Rotation Animation</span>
                                </label>
                            </div>

                            <!-- Graduation Labels (Top, Right, Bottom, Left) -->
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Dial Graduation Points (4 Cardinal Quadrants)</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div class="space-y-1">
                                        <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold">Top (0°)</span>
                                        <input type="text" wire:model="hero_tacho_top" placeholder="0° / RPM"
                                               class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold">Right (90°)</span>
                                        <input type="text" wire:model="hero_tacho_right" placeholder="90°"
                                               class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold">Bottom (180°)</span>
                                        <input type="text" wire:model="hero_tacho_bottom" placeholder="180°"
                                               class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold">Left (270°)</span>
                                        <input type="text" wire:model="hero_tacho_left" placeholder="270°"
                                               class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Technical HUD Box under Dial -->
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="flex items-center gap-2">
                                <x-icon name="solid:rectangle-list" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Technical HUD Specification Box</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Customizable 3-line military/industrial spec block positioned beneath the turbine dial.</p>

                            <div class="space-y-3">
                                <!-- Line 1 -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <input type="text" wire:model="hero_hud_l1_label" placeholder="EQUIPMENT:"
                                           class="px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-600 dark:text-slate-400">
                                    <input type="text" wire:model="hero_hud_l1_val" placeholder="HEAVY EXHAUST TURBOCHARGER"
                                           class="sm:col-span-2 px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-cyan-600 dark:text-cyan-400">
                                </div>

                                <!-- Line 2 -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <input type="text" wire:model="hero_hud_l2_label" placeholder="AUTHORIZED:"
                                           class="px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-600 dark:text-slate-400">
                                    <input type="text" wire:model="hero_hud_l2_val" placeholder="ABB • MAN • KBB • MHI • NAPIER"
                                           class="sm:col-span-2 px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-cyan-600 dark:text-cyan-400">
                                </div>

                                <!-- Line 3 -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <input type="text" wire:model="hero_hud_l3_label" placeholder="WORKSHOP RADIUS:"
                                           class="px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-slate-600 dark:text-slate-400">
                                    <input type="text" wire:model="hero_hud_l3_val" placeholder="CHATTOGRAM • MONGLA • GLOBAL"
                                           class="sm:col-span-2 px-2.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-cyan-600 dark:text-cyan-400">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Bottom Save Footer Inside Hero Workspace -->
                <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <span class="text-[11px] text-slate-500 dark:text-slate-400">
                        Changes apply directly across the homepage Hero section.
                    </span>

                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="restoreProductionDesign"
                                wire:confirm="Restore real production design (100% real corporate data)?"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                            <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                            <span>Restore Real Design</span>
                        </button>

                        <button type="button" wire:click="saveHero" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                            <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                            <span>Save Hero Banner Changes</span>
                        </button>
                    </div>
                </div>

            </div>
            @endif
        </div>

    </div>

    <!-- Vector Icon Picker Modal -->
    <x-icon-picker-modal />
</div>