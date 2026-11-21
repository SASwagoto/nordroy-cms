<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="p-4 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs">
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
                        Locked Section: Header
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

                <button type="button" wire:click="resetDefaults" 
                        wire:confirm="Reset header configuration to default values?"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-900/50 transition-colors cursor-pointer">
                    <x-icon name="solid:arrow-path" class="w-3.5 h-3.5" />
                    <span>Reset Defaults</span>
                </button>

                <button type="button" wire:click="saveHeader" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                    <span wire:loading.remove wire:target="saveHeader" class="flex items-center gap-1.5">
                        <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                        <span>Save Header</span>
                    </span>
                    <span wire:loading wire:target="saveHeader" class="flex items-center gap-1.5">
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
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
                <!-- Sidebar Header -->
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:cubes" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Homepage Sections</span>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                        8 Sections
                    </span>
                </div>

                <div class="p-3 space-y-2">
                    <!-- 1. LOCKED HEADER (Topbar & Main Navigation) -->
                    <div wire:click="selectSection('header')"
                         class="group p-3 rounded-xl border transition-all cursor-pointer flex items-center justify-between bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                <x-icon name="solid:window-maximize" class="w-3.5 h-3.5" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-bold truncate">Header (Topbar &amp; Navbar)</span>
                                <span class="block text-[9px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Pinned &bull; Multi-Row</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="px-1.5 py-0.5 text-[9px] font-mono font-bold uppercase rounded bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 flex items-center gap-1">
                                <x-icon name="solid:lock-closed" class="w-2.5 h-2.5" />
                                <span>LOCKED</span>
                            </span>
                        </div>
                    </div>

                    <!-- 2. Hero Banner (Planning / Next) -->
                    <div wire:click="selectSection('hero')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:sparkles" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">Hero Banner</span>
                                <span class="block text-[9px] text-slate-400">Turbine Dial &amp; Overhauls</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>

                    <!-- 3. OEM Partner Ticker -->
                    <div wire:click="selectSection('partners')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:arrows-right-left" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">OEM Partner Ticker</span>
                                <span class="block text-[9px] text-slate-400">ABB &bull; MAN &bull; KBB</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>

                    <!-- 4. Overhaul Services -->
                    <div wire:click="selectSection('services')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:wrench-screwdriver" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">Precision Services</span>
                                <span class="block text-[9px] text-slate-400">Balancing &amp; Overhauls</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>

                    <!-- 5. Products & Parts -->
                    <div wire:click="selectSection('products')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:cube" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">Products &amp; Spares</span>
                                <span class="block text-[9px] text-slate-400">Cartridges &amp; Rotors</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>

                    <!-- 6. Metrics & Stats -->
                    <div wire:click="selectSection('stats')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:chart-bar" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">Engineering Stats</span>
                                <span class="block text-[9px] text-slate-400">100k RPM &bull; 24/7 Squads</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>

                    <!-- 7. Inquiries / RFQ Desk -->
                    <div wire:click="selectSection('rfq')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:envelope" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">Inquiries / RFQ Form</span>
                                <span class="block text-[9px] text-slate-400">Dynamic Lead Capture</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>

                    <!-- 8. LOCKED FOOTER -->
                    <div wire:click="selectSection('footer')"
                         class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-700 cursor-pointer transition-all flex items-center justify-between opacity-75">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0">
                                <x-icon name="solid:window-minimize" class="w-3.5 h-3.5 text-slate-400" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-semibold truncate">Modular Footer</span>
                                <span class="block text-[9px] text-slate-400">Pinned &bull; Multi-Column</span>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Next Step</span>
                    </div>
                </div>

                <div class="p-3 bg-slate-50/80 dark:bg-slate-800/40 border-t border-slate-200/80 dark:border-slate-800 text-[11px] text-slate-500">
                    <p class="leading-relaxed">
                        <strong class="text-slate-700 dark:text-slate-300">Lock Rule:</strong> The Header is anchored at the top of the homepage hierarchy and cannot be displaced.
                    </p>
                </div>
            </div>
        </div>

        <!-- ==================== RIGHT WORKSPACE: HEADER CUSTOMIZER ==================== -->
        <div class="lg:col-span-8 xl:col-span-9 space-y-6">
            
            <!-- Workspace Card -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
                
                <!-- Workspace Sub-Navigation Tabs -->
                <div class="p-2.5 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200/80 dark:border-slate-800 flex items-center gap-1.5 overflow-x-auto">
                    <button type="button" wire:click="setHeaderTab('topbar')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'topbar' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-700' }}">
                        <x-icon name="solid:phone-volume" class="w-3.5 h-3.5" />
                        <span>1. Topbar (Emergency Strip)</span>
                        @if($topbar_enabled)
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        @endif
                    </button>

                    <button type="button" wire:click="setHeaderTab('navbar')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'navbar' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-700' }}">
                        <x-icon name="solid:bars-3" class="w-3.5 h-3.5" />
                        <span>2. Main Navbar (Style &amp; Brand)</span>
                    </button>

                    <button type="button" wire:click="setHeaderTab('menu')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'menu' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-700' }}">
                        <x-icon name="solid:list-bullet" class="w-3.5 h-3.5" />
                        <span>3. Navigation Menu</span>
                    </button>

                    <button type="button" wire:click="setHeaderTab('cta')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shrink-0 cursor-pointer {{ $headerTab === 'cta' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-700' }}">
                        <x-icon name="solid:bolt" class="w-3.5 h-3.5" />
                        <span>4. Actions &amp; CTA</span>
                    </button>
                </div>

                <!-- Tab 1: Topbar Content & Styling -->
                @if($headerTab === 'topbar')
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white">Emergency Topbar Configuration</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Controls the topmost strip displaying emergency contacts, secondary tagline, and portal shortcuts.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="topbar_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:width-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Enable Strip</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 {{ $topbar_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                        <!-- Left Callout Badge -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Notice Badge Text</label>
                            <input type="text" wire:model="topbar_badge_text" placeholder="24/7 Port Call & Emergency Squads"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- Left Callout Icon -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Notice Badge Icon</label>
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
                                 class="flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[38px]">
                                <div class="w-6 h-6 rounded-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-1 group-hover:scale-105 transition-transform text-cyan-600 dark:text-cyan-400">
                                    <img :src="iconUrl" :alt="iconVal" class="w-4 h-4 object-contain dark:invert" 
                                         onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                    <div style="display:none;" class="w-4 h-4 items-center justify-center">
                                        <x-icon :name="$topbar_badge_icon ?: 'solid:phone-volume'" class="w-4 h-4" />
                                    </div>
                                </div>
                                <span class="text-xs font-mono text-slate-800 dark:text-slate-200 truncate flex-1" x-text="iconVal || 'solid:phone-volume'"></span>
                                <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                            </div>
                        </div>

                        <!-- Secondary Tagline -->
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Secondary Tagline / Subtitle</label>
                            <input type="text" wire:model="topbar_tagline" placeholder="Authorized Multi-Brand Turbocharger Engineering"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- Phone Number -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Direct Duty Phone</label>
                            <input type="text" wire:model="topbar_phone" placeholder="+880 1800-000000"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Operations Email</label>
                            <input type="email" wire:model="topbar_email" placeholder="operations@nordroy.com"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- Language Switcher Toggle -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="block text-xs font-bold text-slate-900 dark:text-white">Language Switcher Dropdown</span>
                                <span class="block text-[10px] text-slate-500">Show multi-language picker with flags</span>
                            </div>
                            <input type="checkbox" wire:model="topbar_show_lang" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <!-- Admin Portal Link Toggle -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="block text-xs font-bold text-slate-900 dark:text-white">Admin Portal / Login Link</span>
                                <span class="block text-[10px] text-slate-500">Display quick shortcut button</span>
                            </div>
                            <input type="checkbox" wire:model="topbar_show_portal" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <!-- Portal Text & URL -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Portal Link Label</label>
                            <input type="text" wire:model="topbar_portal_text" placeholder="Admin Portal &rarr;"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Portal Target URL</label>
                            <input type="text" wire:model="topbar_portal_url" placeholder="/admin/dashboard"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tab 2: Main Navbar (Layout & Style) -->
                @if($headerTab === 'navbar')
                <div class="p-6 space-y-6">
                    <div class="pb-4 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white">Main Navbar Styling &amp; Geometry</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Configure sticky behavior, height, background transparency, frosted glass effects, and logos.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Sticky Toggle -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="block text-xs font-bold text-slate-900 dark:text-white">Sticky Header on Scroll</span>
                                <span class="block text-[10px] text-slate-500">Pins navbar to top of viewport when scrolling</span>
                            </div>
                            <input type="checkbox" wire:model="header_sticky" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                        </div>

                        <!-- Header Height -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Navbar Height</label>
                            <select wire:model="header_height"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="70px">Compact (70px)</option>
                                <option value="80px">Standard (80px - Default)</option>
                                <option value="90px">Spacious (90px)</option>
                            </select>
                        </div>

                        <!-- Background Style Selector -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Background Material</label>
                            <select wire:model.live="header_bg_style"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                <option value="frosted">Frosted Glassmorphism (Executive Standard)</option>
                                <option value="transparent">Fully Transparent</option>
                                <option value="solid">Solid Background</option>
                                <option value="custom">Custom Dual Mode Palette</option>
                            </select>
                        </div>

                        <!-- Frosted Opacity Slider (When frosted selected) -->
                        @if($header_bg_style === 'frosted')
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Glass Opacity (10% - 90%)</label>
                                <span class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400">{{ $header_frosted_opacity }}%</span>
                            </div>
                            <input type="range" min="10" max="90" step="5" wire:model.live="header_frosted_opacity"
                                   class="w-full accent-[#003C58] dark:accent-cyan-400">
                        </div>
                        @endif

                        <!-- Custom Dual Mode Colors (When custom selected) -->
                        @if($header_bg_style === 'custom')
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="header_custom_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-300">
                                    <input type="text" wire:model.live="header_custom_light_bg" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-200 font-mono">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="header_custom_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border border-slate-700">
                                    <input type="text" wire:model.live="header_custom_dark_bg" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-800 font-mono bg-slate-900 text-white">
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Brand Title / Alt -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Brand Title / Alt Text</label>
                            <input type="text" wire:model="header_brand_title" placeholder="Nordroy Marine"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- Logo Height -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Logo Height (px)</label>
                            <input type="number" min="20" max="80" wire:model="header_logo_height"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        </div>

                        <!-- Light Mode Logo -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Light Mode Logo Path</label>
                            <div class="flex items-center gap-2">
                                <input type="text" wire:model="header_logo_light" placeholder="assets/images/logo.png"
                                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono text-[11px]">
                                @if($header_logo_light)
                                <img src="{{ asset($header_logo_light) }}" alt="Preview" class="h-8 max-w-[60px] object-contain p-1 border rounded bg-white shrink-0">
                                @endif
                            </div>
                        </div>

                        <!-- Dark Mode Logo -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Dark Mode Logo Path</label>
                            <div class="flex items-center gap-2">
                                <input type="text" wire:model="header_logo_dark" placeholder="assets/images/logo-dark.png"
                                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono text-[11px]">
                                @if($header_logo_dark)
                                <img src="{{ asset($header_logo_dark) }}" alt="Preview" class="h-8 max-w-[60px] object-contain p-1 border rounded bg-slate-950 shrink-0">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tab 3: Navigation Menu -->
                @if($headerTab === 'menu')
                <div class="p-6 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
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

                    <div class="space-y-4">
                        <div class="space-y-1.5 max-w-md">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Active Menu Source</label>
                            <select wire:model.live="header_menu_id"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                                @foreach($availableMenus as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->location }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Active Menu Items Tree Preview -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                            <div class="p-3 bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs font-bold">
                                <span>Menu Links Preview</span>
                                <span class="text-slate-400 font-normal">Auto-synchronized with Header</span>
                            </div>

                            @if($selectedMenu && $selectedMenu->rootItems->count() > 0)
                            <div class="divide-y divide-slate-100 dark:divide-slate-800 p-2">
                                @foreach($selectedMenu->rootItems as $item)
                                    <div class="p-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2 hover:bg-slate-50/50 dark:hover:bg-slate-800/40 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ $item->getTranslation('title', app()->getLocale()) ?: $item->title }}</span>
                                            <span class="text-[10px] font-mono text-slate-400">{{ $item->url }}</span>
                                        </div>
                                        @if($item->children->count() > 0)
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-cyan-50 dark:bg-cyan-950/40 text-cyan-600 dark:text-cyan-400 font-semibold self-start sm:self-center">
                                                {{ $item->children->count() }} Submenu items
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @else
                            <div class="p-6 text-center text-xs text-slate-500">
                                Default system navigation is active (Home, About Us, Services, Products, Projects, Careers, Contact).
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tab 4: Actions & CTA -->
                @if($headerTab === 'cta')
                <div class="p-6 space-y-6">
                    <div class="pb-4 border-b border-slate-100 dark:border-slate-800">
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

                        <!-- CTA Button URL -->
                        <div class="space-y-1.5 {{ $header_cta_enabled ? '' : 'opacity-50 pointer-events-none' }}">
                            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">CTA Target URL</label>
                            <input type="text" wire:model="header_cta_url" placeholder="/contact#rfq"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
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
                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500 dark:text-slate-400">
                        Changes apply directly across the homepage and all platform layouts.
                    </span>

                    <button type="button" wire:click="saveHeader" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                        <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                        <span>Save Header Changes</span>
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Vector Icon Picker Modal -->
    <x-icon-picker-modal />
</div>
