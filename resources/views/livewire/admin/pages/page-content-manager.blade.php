<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 font-mono">
                    Nordroy Content Engine &bull; Version 2.0
                </span>
            </div>
            <h1 class="text-2xl font-black font-heading text-slate-900 dark:text-white mt-1">
                Static Page Content Studio
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Manage hero text, dynamic repeaters, header backgrounds, glass transparency, grid layouts, and section toggles.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @php
                $previewUrl = match($activePage) {
                    'contact'  => route('contact'),
                    'careers'  => route('careers'),
                    'services' => route('services'),
                    'products' => route('products'),
                    'gallery'  => route('photo-gallery'),
                    default    => route('about'),
                };
            @endphp
            <a href="{{ $previewUrl }}" target="_blank"
               class="px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-1.5">
                <x-icon name="solid:arrow-top-right-on-square" class="w-3.5 h-3.5 text-cyan-500" />
                <span>View Public Page</span>
            </a>

            <button type="button" 
                    wire:click="resetToDefaults"
                    wire:confirm="Are you sure you want to restore default corporate copy and section toggles for this page?"
                    class="px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                Reset Defaults
            </button>

            <button type="button" 
                    wire:click="saveContent"
                    class="px-4 py-2 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs shadow-md transition-all inline-flex items-center gap-2 cursor-pointer active:scale-95">
                <x-icon name="solid:check" class="w-4 h-4" />
                <span>Save Page Content</span>
            </button>
        </div>
    </div>

    <!-- Flash Notification -->
    @if (session()->has('message'))
        <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500" />
                <span>{{ session('message') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Page Selection Segmented Navigation -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar border-b border-slate-200 dark:border-slate-800 pb-2">
        <button type="button" 
                wire:click="setPage('about')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'about' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:building" class="w-4 h-4" />
            <span>About Us (/about)</span>
        </button>

        <button type="button" 
                wire:click="setPage('contact')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'contact' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:phone" class="w-4 h-4" />
            <span>Contact &amp; Workshops (/contact)</span>
        </button>

        <button type="button" 
                wire:click="setPage('careers')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'careers' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:briefcase" class="w-4 h-4" />
            <span>Careers (/careers)</span>
        </button>

        <button type="button" 
                wire:click="setPage('services')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'services' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:wrench-screwdriver" class="w-4 h-4" />
            <span>Services Catalog (/services)</span>
        </button>

        <button type="button" 
                wire:click="setPage('products')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'products' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:cog" class="w-4 h-4" />
            <span>Products Catalog (/products)</span>
        </button>

        <button type="button" 
                wire:click="setPage('gallery')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'gallery' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:photo" class="w-4 h-4" />
            <span>Galleries (/photo &amp; /video)</span>
        </button>
    </div>

    <!-- Active Page Form Containers -->
    <div class="space-y-6">

        <!-- ===================================================================
             1. ABOUT US PAGE EDITING STUDIO
             =================================================================== -->
        @if($activePage === 'about')
            <!-- Section 1: Hero Header & Background Style -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            About Us: Hero Header &amp; Background Customization
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.about_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background (Default)</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Top Badge</label>
                        <input type="text" wire:model="content.about_badge"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Hero Main Headline</label>
                        <input type="text" wire:model="content.about_hero_title"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['about_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['about_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.about_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['about_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.about_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.about_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.about_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.about_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.about_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.about_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.about_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.about_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Hero Subtitle / Corporate Intro</label>
                        <textarea rows="3" wire:model="content.about_hero_subtitle"
                                  class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Section 2: Corporate Overview & Specs (#overview) -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Corporate Overview &amp; Specifications (#overview)
                        </h2>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show Overview Section:</span>
                        <input type="checkbox" wire:model="content.about_show_overview" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['about_show_overview'])
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Overview Heading</label>
                            <input type="text" wire:model="content.about_overview_title"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Overview Paragraph 1</label>
                            <textarea rows="4" wire:model="content.about_overview_p1"
                                      class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Overview Paragraph 2</label>
                            <textarea rows="4" wire:model="content.about_overview_p2"
                                      class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <!-- Dynamic Spec Stats Repeater -->
                        <div class="md:col-span-2 space-y-3 pt-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                    Technical Specification Stats (Dynamic Repeater)
                                </label>
                                <span class="text-[11px] text-slate-500">Unlimited stats. Live toggle &amp; adaptive gapless layout.</span>
                            </div>

                            <!-- Existing Stats List -->
                            <div class="space-y-2">
                                @forelse($aboutStats as $idx => $stat)
                                    <div class="p-3.5 rounded-2xl border {{ !empty($stat['is_active']) ? 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800' : 'bg-slate-100/60 dark:bg-slate-900/30 border-dashed border-slate-300 dark:border-slate-800 opacity-70' }} flex flex-col sm:flex-row items-center justify-between gap-3 shadow-2xs">
                                        <div class="flex items-center gap-2 self-start sm:self-center">
                                            <button type="button" wire:click="toggleStat({{ $idx }})" 
                                                    title="Click to toggle display on/off"
                                                    class="cursor-pointer px-2 py-1 rounded-lg text-[10px] font-bold uppercase transition-all {{ !empty($stat['is_active']) ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-slate-200 dark:bg-slate-800 text-slate-500' }}">
                                                {{ !empty($stat['is_active']) ? 'Active' : 'Disabled' }}
                                            </button>
                                        </div>

                                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-12 gap-2 w-full">
                                            <div class="sm:col-span-4">
                                                <input type="text" wire:model="aboutStats.{{ $idx }}.value" placeholder="Value (e.g. 100k RPM)"
                                                       class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono font-bold">
                                            </div>
                                            <div class="sm:col-span-5">
                                                <input type="text" wire:model="aboutStats.{{ $idx }}.label" placeholder="Label (e.g. Balancing Rig Capacity)"
                                                       class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                                            </div>
                                            <div class="sm:col-span-3">
                                                <select wire:model="aboutStats.{{ $idx }}.color"
                                                        class="w-full px-2.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300">
                                                    <option value="cyan">Cyan Accent</option>
                                                    <option value="emerald">Emerald Accent</option>
                                                    <option value="rose">Rose Accent</option>
                                                    <option value="amber">Amber Accent</option>
                                                    <option value="indigo">Indigo Accent</option>
                                                    <option value="blue">Blue Accent</option>
                                                    <option value="purple">Purple Accent</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" wire:click="removeStat({{ $idx }})" 
                                                title="Delete this specification stat"
                                                class="text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/20 cursor-pointer transition-colors self-end sm:self-center">
                                            <x-icon name="solid:trash" class="w-4 h-4" />
                                        </button>
                                    </div>
                                @empty
                                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/40 text-center text-xs text-slate-400">
                                        No spec stats added yet. Add one below.
                                    </div>
                                @endforelse
                            </div>

                            <!-- Add New Stat Inline -->
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-3">
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Add New Specification Stat</span>
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                                    <input type="text" wire:model="newStatValue" placeholder="Value (e.g. 100k RPM)"
                                           class="sm:col-span-4 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono font-bold">
                                    <input type="text" wire:model="newStatLabel" placeholder="Label (e.g. Balancing Rig Capacity)"
                                           class="sm:col-span-5 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                    <select wire:model="newStatColor"
                                            class="sm:col-span-3 px-2.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                        <option value="cyan">Cyan Accent</option>
                                        <option value="emerald">Emerald Accent</option>
                                        <option value="rose">Rose Accent</option>
                                        <option value="amber">Amber Accent</option>
                                        <option value="indigo">Indigo Accent</option>
                                        <option value="blue">Blue Accent</option>
                                        <option value="purple">Purple Accent</option>
                                    </select>
                                    <div class="sm:col-span-12 flex justify-end">
                                        <button type="button" wire:click="addStat"
                                                class="px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 hover:opacity-90 cursor-pointer flex items-center gap-1.5 transition-all">
                                            <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                                            <span>Add Spec Stat</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 text-amber-800 dark:text-amber-400 text-xs font-medium">
                        This section is currently disabled. The frontend will adapt seamlessly without leaving blank spaces.
                    </div>
                @endif
            </div>

            <!-- Section 3: Authorized OEM Partnerships Card -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Authorized OEM Partnerships Card
                        </h2>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show OEM Partnerships:</span>
                        <input type="checkbox" wire:model="content.about_show_partners" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['about_show_partners'])
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Partnership Box Title</label>
                        <input type="text" wire:model="content.about_partners_title"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Existing Partners List -->
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Partners &amp; Turbocharger Series List</label>
                        <div class="divide-y divide-slate-100 dark:divide-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden">
                            @forelse($aboutPartners as $index => $item)
                                <div class="p-3.5 flex items-center justify-between gap-3 bg-slate-50/50 dark:bg-slate-900/40">
                                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <div class="font-bold text-xs text-slate-900 dark:text-white">{{ $item['brand'] }}</div>
                                        <div class="sm:col-span-2 text-xs text-slate-600 dark:text-slate-400">{{ $item['models'] }}</div>
                                    </div>
                                    <button type="button" wire:click="removePartner({{ $index }})" class="text-rose-500 hover:text-rose-700 p-1 cursor-pointer">
                                        <x-icon name="solid:trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-slate-400">No OEM partnerships added yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Add Partner Inline -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Add New Partner / Series</span>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                            <input type="text" wire:model="newPartnerBrand" placeholder="Brand (e.g. Accelleron)"
                                   class="sm:col-span-4 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <input type="text" wire:model="newPartnerModels" placeholder="Models (e.g. VTR, TPL, TPS series)"
                                   class="sm:col-span-6 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <button type="button" wire:click="addPartner"
                                    class="sm:col-span-2 px-3 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">
                                Add Partner
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 text-amber-800 dark:text-amber-400 text-xs font-medium">
                        OEM Card is hidden. The overview text will expand to comfortable reading width automatically.
                    </div>
                @endif
            </div>

            <!-- Section 4: Mission & Vision -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Mission &amp; Vision (#mission)
                        </h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <span class="text-xs font-semibold text-slate-500">Show Mission:</span>
                            <input type="checkbox" wire:model="content.about_show_mission" class="sr-only peer">
                            <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <span class="text-xs font-semibold text-slate-500">Show Vision:</span>
                            <input type="checkbox" wire:model="content.about_show_vision" class="sr-only peer">
                            <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Global Section Visual Settings -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                            <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                            <span>Card Visual Layout / Alignment</span>
                        </label>
                        <select wire:model.live="content.about_mission_vision_align"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="left">Left Aligned (Classic Corporate Layout)</option>
                            <option value="center">Center Aligned (Heroic Balanced Alignment)</option>
                            <option value="horizontal">Horizontal Split (Icon on Left, Content on Right)</option>
                        </select>
                        <p class="text-[11px] text-slate-500">Sets the content alignment and layout orientation across both cards.</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                            <x-icon name="solid:sparkles" class="w-4 h-4 text-cyan-500" />
                            <span>Card Visual Theme &amp; Surface</span>
                        </label>
                        <select wire:model.live="content.about_mission_vision_style"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="modern">Modern Glass Card (Clean with Soft Glow)</option>
                            <option value="bordered">High-Tech Bordered (Sharp with Neon Top Line)</option>
                            <option value="gradient">Subtle Ambient Gradient (Atmospheric Surface)</option>
                        </select>
                        <p class="text-[11px] text-slate-500">Selects border thickness, backdrop gradient, and neon accent lines.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mission Card Settings -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60 dark:border-slate-800">
                            <span class="font-bold text-xs text-slate-900 dark:text-white flex items-center gap-1.5">
                                <x-icon name="solid:bullseye" class="w-4 h-4 text-cyan-500" />
                                <span>Corporate Mission Details</span>
                            </span>
                            <span class="text-[10px] uppercase font-bold text-cyan-600 dark:text-cyan-400">Card 1</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Badge Text</label>
                                <input type="text" wire:model="content.about_mission_badge" placeholder="Strategic Purpose"
                                       class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Accent Color</label>
                                <select wire:model="content.about_mission_color"
                                        class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                    <option value="cyan">Cyan</option>
                                    <option value="emerald">Emerald</option>
                                    <option value="indigo">Indigo</option>
                                    <option value="blue">Blue</option>
                                    <option value="purple">Purple</option>
                                    <option value="amber">Amber</option>
                                    <option value="rose">Rose</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Mission Title</label>
                                <input type="text" wire:model="content.about_mission_title" placeholder="Our Corporate Mission"
                                       class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Mission Icon</label>
                                <div x-data="{
                                        iconVal: @entangle('content.about_mission_icon'),
                                        get iconUrl() {
                                            if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/bullseye.svg';
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
                                     @click="$dispatch('open-icon-picker', { targetField: 'content.about_mission_icon' })"
                                     class="flex items-center gap-2.5 p-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 dark:hover:border-cyan-400 cursor-pointer transition-all shadow-2xs group">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-1.5 group-hover:scale-105 transition-transform text-[#003C58] dark:text-cyan-400">
                                        <img :src="iconUrl" :alt="iconVal" class="w-5 h-5 object-contain dark:invert" 
                                             onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                        <div style="display:none;" class="w-5 h-5 items-center justify-center">
                                            <x-icon :name="$content['about_mission_icon'] ?? 'solid:bullseye'" class="w-5 h-5" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="block text-xs font-mono font-bold text-slate-900 dark:text-white truncate" x-text="iconVal || 'solid:bullseye'"></span>
                                        <span class="text-[10px] text-cyan-600 dark:text-cyan-400 font-semibold group-hover:underline">Click to change icon</span>
                                    </div>
                                    <div class="text-slate-400 group-hover:text-cyan-500 transition-colors pr-1">
                                        <x-icon name="solid:arrows-up-down" class="w-3.5 h-3.5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Mission Statement</label>
                            <textarea rows="4" wire:model="content.about_mission_text"
                                      class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                    </div>

                    <!-- Vision Card Settings -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60 dark:border-slate-800">
                            <span class="font-bold text-xs text-slate-900 dark:text-white flex items-center gap-1.5">
                                <x-icon name="solid:eye" class="w-4 h-4 text-emerald-500" />
                                <span>Vision 2030 Details</span>
                            </span>
                            <span class="text-[10px] uppercase font-bold text-emerald-600 dark:text-emerald-400">Card 2</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Badge Text</label>
                                <input type="text" wire:model="content.about_vision_badge" placeholder="Horizon 2030"
                                       class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Accent Color</label>
                                <select wire:model="content.about_vision_color"
                                        class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                    <option value="emerald">Emerald</option>
                                    <option value="cyan">Cyan</option>
                                    <option value="indigo">Indigo</option>
                                    <option value="blue">Blue</option>
                                    <option value="purple">Purple</option>
                                    <option value="amber">Amber</option>
                                    <option value="rose">Rose</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Vision Title</label>
                                <input type="text" wire:model="content.about_vision_title" placeholder="Vision 2030"
                                       class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-500">Vision Icon</label>
                                <div x-data="{
                                        iconVal: @entangle('content.about_vision_icon'),
                                        get iconUrl() {
                                            if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/eye.svg';
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
                                     @click="$dispatch('open-icon-picker', { targetField: 'content.about_vision_icon' })"
                                     class="flex items-center gap-2.5 p-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 dark:hover:border-emerald-400 cursor-pointer transition-all shadow-2xs group">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-1.5 group-hover:scale-105 transition-transform text-emerald-600 dark:text-emerald-400">
                                        <img :src="iconUrl" :alt="iconVal" class="w-5 h-5 object-contain dark:invert" 
                                             onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                        <div style="display:none;" class="w-5 h-5 items-center justify-center">
                                            <x-icon :name="$content['about_vision_icon'] ?? 'solid:eye'" class="w-5 h-5" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="block text-xs font-mono font-bold text-slate-900 dark:text-white truncate" x-text="iconVal || 'solid:eye'"></span>
                                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold group-hover:underline">Click to change icon</span>
                                    </div>
                                    <div class="text-slate-400 group-hover:text-emerald-500 transition-colors pr-1">
                                        <x-icon name="solid:arrows-up-down" class="w-3.5 h-3.5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Vision Statement</label>
                            <textarea rows="4" wire:model="content.about_vision_text"
                                      class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: International Accreditations & Certifications -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Quality Framework &amp; Accreditations (#certifications)
                        </h2>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show Accreditations:</span>
                        <input type="checkbox" wire:model="content.about_show_certifications" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['about_show_certifications'])
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Section Badge</label>
                            <input type="text" wire:model="content.about_cert_badge" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Section Heading</label>
                            <input type="text" wire:model="content.about_cert_title" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <!-- Certifications List -->
                    <div class="flex flex-wrap gap-2 pt-2">
                        @foreach($aboutCertifications as $idx => $cert)
                            <div class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-bold font-mono flex items-center gap-2">
                                <span>{{ $cert }}</span>
                                <button type="button" wire:click="removeCertification({{ $idx }})" class="text-rose-500 hover:text-rose-700 cursor-pointer">&times;</button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Cert Inline -->
                    <div class="flex items-center gap-2 pt-2">
                        <input type="text" wire:model="newCertName" placeholder="New Certification Standard (e.g. ABS Marine Class Approved)"
                               class="flex-1 px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                        <button type="button" wire:click="addCertification"
                                class="px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">
                            Add Standard
                        </button>
                    </div>
                @endif
            </div>
        @endif

        <!-- ===================================================================
             2. CONTACT & MARINE DUTY DESK PAGE EDITING STUDIO
             =================================================================== -->
        @if($activePage === 'contact')
            <!-- Contact Header Background & Intro -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Contact Page: Hero Header &amp; Background Style
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.contact_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Badge</label>
                        <input type="text" wire:model="content.contact_badge" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Main Title</label>
                        <input type="text" wire:model="content.contact_hero_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['contact_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['contact_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.contact_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['contact_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.contact_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.contact_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.contact_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.contact_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.contact_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.contact_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.contact_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.contact_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Subtitle / Port Dispatch Notice</label>
                        <textarea rows="2" wire:model="content.contact_hero_subtitle"
                                  class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Dynamic Contact Facilities & Workshops Repeater -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-6 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:building" class="w-4 h-4 text-cyan-500" />
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                                Workshop Facilities &amp; Offices (Dynamic Unlimited Locations)
                            </h2>
                            <p class="text-[11px] text-slate-400">Add port facilities, headquarters, regional hubs, or flying squad desks. Toggle active status in real time.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <span class="text-xs font-semibold text-slate-500">24/7 Emergency Notice:</span>
                            <input type="checkbox" wire:model="content.contact_show_emergency" class="sr-only peer">
                            <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Existing Facilities Cards List -->
                <div class="space-y-4">
                    @forelse($contactFacilities as $i => $fac)
                        @php
                            $isActive = $fac['is_active'] ?? true;
                        @endphp
                        <div class="p-5 rounded-2xl border transition-all space-y-4 {{ $isActive ? 'bg-slate-50/70 dark:bg-slate-900/60 border-slate-200 dark:border-slate-800' : 'bg-slate-100/40 dark:bg-slate-950/40 border-slate-200/50 opacity-60' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span class="text-xs font-bold font-mono uppercase {{ $isActive ? 'text-slate-900 dark:text-white' : 'text-slate-400' }}">
                                        Facility {{ $i + 1 }}: {{ $fac['title'] ?: 'Untitled Location' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- Real-time toggle button -->
                                    <button type="button" wire:click="toggleFacility({{ $i }})"
                                            title="Click to Toggle Active in Real Time"
                                            class="px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer transition-all {{ $isActive ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-slate-200 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border border-slate-300 dark:border-slate-700' }}">
                                        {{ $isActive ? '✓ Active (Showing)' : '✕ Inactive (Hidden)' }}
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" wire:click="removeFacility({{ $i }})"
                                            wire:confirm="Delete this facility location?"
                                            title="Delete Facility"
                                            class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg cursor-pointer">
                                        <x-icon name="solid:trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Badge</label>
                                    <input type="text" wire:model="contactFacilities.{{ $i }}.badge" placeholder="Primary Workshop Facility"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                                <div class="sm:col-span-2 space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Facility / Hub Title</label>
                                    <input type="text" wire:model="contactFacilities.{{ $i }}.title" placeholder="Chattogram Port Workshop"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-bold">
                                </div>

                                <div class="sm:col-span-3 space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Address / Geographic Point</label>
                                    <input type="text" wire:model="contactFacilities.{{ $i }}.address" placeholder="Near Marine Academy Jetty, Chattogram Port, Bangladesh."
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>

                                <div class="sm:col-span-3 space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Equipment / Capabilities Description</label>
                                    <textarea rows="2" wire:model="contactFacilities.{{ $i }}.desc" placeholder="Overhead gantry cranes, Schenck balancing benches..."
                                              class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Phone / Duty Desk</label>
                                    <input type="text" wire:model="contactFacilities.{{ $i }}.phone" placeholder="+880 1800-000000"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Operations Email</label>
                                    <input type="text" wire:model="contactFacilities.{{ $i }}.email" placeholder="port.ops@nordroy.com"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Emergency / Helpline Tag</label>
                                    <input type="text" wire:model="contactFacilities.{{ $i }}.emergency" placeholder="24/7 Flying Squad Available"
                                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400 rounded-2xl border border-dashed border-slate-300 dark:border-slate-800">
                            No facilities added yet. Use the form below to add workshop and office locations.
                        </div>
                    @endforelse
                </div>

                <!-- Add New Facility Inline Form -->
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:plus-circle" class="w-4 h-4 text-cyan-500" />
                        <span class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            Add New Workshop Facility / Branch Office
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Facility Badge</label>
                            <input type="text" wire:model="newFacilityBadge" placeholder="e.g. Regional Hub"
                                   class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="sm:col-span-2 space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Facility Title</label>
                            <input type="text" wire:model="newFacilityTitle" placeholder="e.g. Singapore Marine Logistics Hub"
                                   class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>

                        <div class="sm:col-span-3 space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Address / Location</label>
                            <input type="text" wire:model="newFacilityAddress" placeholder="e.g. Jurong Port Road, Singapore"
                                   class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>

                        <div class="sm:col-span-3 space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Equipment / Capabilities</label>
                            <textarea rows="2" wire:model="newFacilityDesc" placeholder="e.g. Rapid transit spares depot, dynamic balancing liaison"
                                      class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Phone</label>
                            <input type="text" wire:model="newFacilityPhone" placeholder="+65 6000-0000"
                                   class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Email</label>
                            <input type="text" wire:model="newFacilityEmail" placeholder="singapore@nordroy.com"
                                   class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-slate-500">Emergency / Helpline Tag</label>
                            <input type="text" wire:model="newFacilityEmergency" placeholder="24/7 Dispatch Ready"
                                   class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="button" wire:click="addFacility"
                                class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 cursor-pointer shadow-sm active:scale-95 transition-all">
                            + Add Facility Location
                        </button>
                    </div>
                </div>
            </div>

            <!-- RFQ Lead Form Toggle -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 flex items-center justify-between shadow-xs">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Interactive RFQ Lead Submission Form
                    </h3>
                    <p class="text-xs text-slate-500">Show or hide the right-column quotation request form on /contact page. If hidden, the facilities list seamlessly expands to center without gap.</p>
                </div>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <span class="text-xs font-semibold text-slate-500">Show RFQ Form:</span>
                    <input type="checkbox" wire:model="content.contact_show_rfq_form" class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                </label>
            </div>
        @endif

        <!-- ===================================================================
             3. CAREERS PAGE EDITING STUDIO
             =================================================================== -->
        @if($activePage === 'careers')
            <!-- Hero Header & Background Style -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Careers Hero Header &amp; Background Style
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.careers_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Badge</label>
                        <input type="text" wire:model="content.careers_badge"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Main Title</label>
                        <input type="text" wire:model="content.careers_hero_title"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['careers_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['careers_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.careers_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['careers_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.careers_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.careers_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.careers_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.careers_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.careers_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.careers_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.careers_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.careers_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Subtitle / Work Culture Narrative</label>
                        <textarea rows="3" wire:model="content.careers_hero_subtitle"
                                  class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Dynamic Culture Highlights Pillars -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Dynamic Culture Pillars (Add / Remove / Toggle &amp; Colors)
                        </h2>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show Culture Section:</span>
                        <input type="checkbox" wire:model="content.careers_show_culture" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['careers_show_culture'])
                    <!-- Existing Pillars Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($careersCultureCards as $i => $card)
                            @php
                                $isActive = $card['is_active'] ?? true;
                            @endphp
                            <div class="p-4 rounded-2xl border transition-all space-y-3 {{ $isActive ? 'bg-slate-50/60 dark:bg-slate-900/60 border-slate-200 dark:border-slate-800' : 'bg-slate-100/40 dark:bg-slate-950/40 border-slate-200/50 opacity-60' }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-mono font-bold uppercase {{ $isActive ? 'text-cyan-600 dark:text-cyan-400' : 'text-slate-400' }}">
                                        Pillar {{ $i + 1 }} {{ $isActive ? '(Active)' : '(Hidden)' }}
                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" wire:click="togglePillar({{ $i }})"
                                                title="Toggle Active/Hidden in Real Time"
                                                class="px-2 py-0.5 rounded-md text-[10px] font-bold cursor-pointer {{ $isActive ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400' : 'bg-slate-200 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                            {{ $isActive ? 'On' : 'Off' }}
                                        </button>
                                        <button type="button" wire:click="removePillar({{ $i }})"
                                                title="Delete Pillar"
                                                class="text-rose-500 hover:text-rose-700 p-1 cursor-pointer">
                                            <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Pillar Title</label>
                                    <input type="text" wire:model="careersCultureCards.{{ $i }}.title"
                                           class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Description</label>
                                    <textarea rows="2" wire:model="careersCultureCards.{{ $i }}.desc"
                                              class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-semibold text-slate-500">Accent Color</label>
                                        <select wire:model="careersCultureCards.{{ $i }}.color"
                                                class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200">
                                            <option value="cyan">Cyan Accent</option>
                                            <option value="blue">Deep Blue / Navy</option>
                                            <option value="emerald">Emerald Green</option>
                                            <option value="rose">Safety Rose</option>
                                            <option value="amber">Warm Amber</option>
                                            <option value="indigo">Tech Indigo</option>
                                            <option value="purple">Royal Purple</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-semibold text-slate-500">Pillar Icon</label>
                                        <div x-data="{
                                                iconVal: @entangle('careersCultureCards.'.$i.'.icon'),
                                                get iconUrl() {
                                                    if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/cpu-chip.svg';
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
                                             @click="$dispatch('open-icon-picker', { targetField: 'careersCultureCards', targetIndex: {{ $i }} })"
                                             class="flex items-center gap-2 p-1.5 rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group">
                                            
                                            <div class="w-6 h-6 rounded-md bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-1 group-hover:scale-105 transition-transform text-cyan-600 dark:text-cyan-400">
                                                <img :src="iconUrl" :alt="iconVal" class="w-4 h-4 object-contain dark:invert" 
                                                     onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                                <div style="display:none;" class="w-4 h-4 items-center justify-center">
                                                    <x-icon :name="$careersCultureCards[$i]['icon'] ?? 'solid:cpu-chip'" class="w-4 h-4" />
                                                </div>
                                            </div>
                                            <span class="text-[11px] font-mono text-slate-700 dark:text-slate-300 truncate flex-1" x-text="iconVal || 'solid:cpu-chip'"></span>
                                            <span class="text-[10px] text-cyan-500 font-bold pr-1">Change</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add New Pillar Inline -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Add New Pillar</span>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                            <input type="text" wire:model="newPillarTitle" placeholder="Pillar Title (e.g. Rapid Deployment)"
                                   class="sm:col-span-3 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <input type="text" wire:model="newPillarDesc" placeholder="Description (e.g. 24h mobilization to port)"
                                   class="sm:col-span-3 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <select wire:model="newPillarColor" class="sm:col-span-2 px-2 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200">
                                <option value="cyan">Cyan</option>
                                <option value="blue">Blue</option>
                                <option value="emerald">Emerald</option>
                                <option value="rose">Rose</option>
                                <option value="amber">Amber</option>
                                <option value="indigo">Indigo</option>
                                <option value="purple">Purple</option>
                            </select>
                            <div class="sm:col-span-2">
                                <div x-data="{
                                        iconVal: @entangle('newPillarIcon'),
                                        get iconUrl() {
                                            if (!this.iconVal) return '/assets/plugins/fontawesome/svgs/solid/bolt.svg';
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
                                     @click="$dispatch('open-icon-picker', { targetField: 'newPillarIcon' })"
                                     class="flex items-center gap-2 px-2.5 py-1.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all group h-[38px]">
                                    
                                    <div class="w-6 h-6 rounded-md bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-center shrink-0 p-1 group-hover:scale-105 transition-transform text-cyan-600 dark:text-cyan-400">
                                        <img :src="iconUrl" :alt="iconVal" class="w-4 h-4 object-contain dark:invert" 
                                             onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';" />
                                        <div style="display:none;" class="w-4 h-4 items-center justify-center">
                                            <x-icon :name="$newPillarIcon ?: 'solid:bolt'" class="w-4 h-4" />
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono text-slate-800 dark:text-slate-200 truncate flex-1" x-text="iconVal || 'solid:bolt'"></span>
                                    <span class="text-[10px] text-cyan-500 font-bold">Pick</span>
                                </div>
                            </div>
                            <button type="button" wire:click="addPillar"
                                    class="sm:col-span-2 px-3 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">
                                Add Pillar
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 text-amber-800 dark:text-amber-400 text-xs font-medium">
                        Culture Pillars section is hidden. The page will transition directly from Header to Job Openings.
                    </div>
                @endif
            </div>

            <!-- General Application Lead Section -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Spontaneous Application &amp; Talent Pool Section
                        </h2>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show Section:</span>
                        <input type="checkbox" wire:model="content.careers_show_spontaneous" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['careers_show_spontaneous'])
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Section Badge</label>
                            <input type="text" wire:model="content.careers_spontaneous_badge" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Headline</label>
                            <input type="text" wire:model="content.careers_spontaneous_title" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Description</label>
                            <textarea rows="2" wire:model="content.careers_spontaneous_desc" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ===================================================================
             4. SERVICES CATALOG & PROCEDURES STUDIO
             =================================================================== -->
        @if($activePage === 'services')
            <!-- Services Header & Background Style -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Services Catalog Header &amp; Background Style (/services)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.services_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Top Badge</label>
                        <input type="text" wire:model="content.services_badge" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Main Title</label>
                        <input type="text" wire:model="content.services_hero_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['services_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['services_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.services_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['services_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.services_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.services_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.services_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.services_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.services_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.services_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.services_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.services_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Intro Subtitle / Narrative</label>
                        <textarea rows="3" wire:model="content.services_hero_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Services Grid & Catalog Display Controls -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <x-icon name="solid:table-cells" class="w-4 h-4 text-cyan-500" />
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Services Catalog Grid, Display &amp; Action Settings
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Cards per Row (Grid Layout)</label>
                        <select wire:model="content.services_grid_cols"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="1">1 Column (Detailed Horizontal Split - Default)</option>
                            <option value="2">2 Columns (Compact Grid)</option>
                            <option value="3">3 Columns (3 Cards Per Row)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Items to Display</label>
                        <select wire:model="content.services_per_page"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="6">6 Services</option>
                            <option value="9">9 Services</option>
                            <option value="12">12 Services</option>
                            <option value="18">18 Services</option>
                            <option value="all">All Published Services</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Request Quote Button</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.services_show_quote_btn" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show Button</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Procedure &amp; Scope Link</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.services_show_scope_btn" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show Button</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ===================================================================
             5. PRODUCTS CATALOG STUDIO
             =================================================================== -->
        @if($activePage === 'products')
            <!-- Products Header & Background Style -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Products &amp; Spare Parts Catalog Header (/products)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.products_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Top Badge</label>
                        <input type="text" wire:model="content.products_badge" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Main Title</label>
                        <input type="text" wire:model="content.products_hero_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['products_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['products_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.products_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['products_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.products_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.products_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.products_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.products_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.products_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.products_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.products_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.products_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Intro Subtitle / Narrative</label>
                        <textarea rows="3" wire:model="content.products_hero_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Products Catalog Grid & Filter Controls -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <x-icon name="solid:table-cells" class="w-4 h-4 text-cyan-500" />
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Product Grid Columns, Filters &amp; Pagination
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Columns Per Row (Desktop)</label>
                        <select wire:model="content.products_grid_cols"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="2">2 Columns (Large Cards)</option>
                            <option value="3">3 Columns</option>
                            <option value="4">4 Columns (Default)</option>
                            <option value="6">6 Columns (Compact Catalog)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Items per Page</label>
                        <select wire:model="content.products_per_page"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="8">8 Products</option>
                            <option value="12">12 Products</option>
                            <option value="16">16 Products (Default)</option>
                            <option value="24">24 Products</option>
                            <option value="all">All Products (No Limit)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Category Filter Strip</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.products_show_category_filter" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show Tabs</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Search Box</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.products_show_search" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show Search</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Brochure Download</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.products_show_brochure_btn" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show PDF Link</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Inquire Button</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.products_show_inquiry_btn" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show RFQ Link</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ===================================================================
             6. GALLERIES STUDIO (PHOTO & VIDEO)
             =================================================================== -->
        @if($activePage === 'gallery')
            <!-- Photo Gallery Header & Layout -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <x-icon name="solid:photo" class="w-4 h-4 text-cyan-500" />
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Photo Gallery Header &amp; Grid (/photo-gallery)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.photo_gallery_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Top Badge</label>
                        <input type="text" wire:model="content.photo_gallery_badge" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Main Title</label>
                        <input type="text" wire:model="content.photo_gallery_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['photo_gallery_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['photo_gallery_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.photo_gallery_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['photo_gallery_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.photo_gallery_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.photo_gallery_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.photo_gallery_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.photo_gallery_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.photo_gallery_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.photo_gallery_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.photo_gallery_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.photo_gallery_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Subtitle</label>
                        <textarea rows="2" wire:model="content.photo_gallery_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>

                    <!-- Photo Gallery Layout Controls -->
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Photos per Row (Columns)</label>
                        <select wire:model="content.photo_gallery_grid_cols"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="2">2 Columns</option>
                            <option value="3">3 Columns</option>
                            <option value="4">4 Columns (Default)</option>
                            <option value="5">5 Columns (Wide Wall)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Photos to Show</label>
                        <select wire:model="content.photo_gallery_per_page"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="12">12 Photos</option>
                            <option value="24">24 Photos (Default)</option>
                            <option value="36">36 Photos</option>
                            <option value="all">All Photos (No Limit)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Album Category Filter</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.photo_gallery_show_albums" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show Filter</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Gallery Header & Layout -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <x-icon name="solid:video" class="w-4 h-4 text-cyan-500" />
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Video Gallery Header &amp; Grid (/video-gallery)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model.live="content.video_gallery_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                            <option value="custom">Custom Color (Light &amp; Dark Mode)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Top Badge</label>
                        <input type="text" wire:model="content.video_gallery_badge" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Main Title</label>
                        <input type="text" wire:model="content.video_gallery_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <!-- Conditional: Frosted Glass Opacity Slider -->
                    @if(($content['video_gallery_header_bg'] ?? '') === 'frosted')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-cyan-500/5 border border-cyan-500/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <x-icon name="solid:adjustments-horizontal" class="w-4 h-4 text-cyan-500" />
                                    <span>Glass Transparency Opacity</span>
                                </label>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-[#003C58] dark:text-cyan-300">
                                    {{ $content['video_gallery_header_frosted_opacity'] ?? 80 }}% Opacity
                                </span>
                            </div>
                            <input type="range" wire:model.live="content.video_gallery_header_frosted_opacity"
                                   min="10" max="90" step="5"
                                   class="w-full accent-cyan-600 cursor-pointer">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Protected Range: Minimum 10% (translucent blur), Maximum 90% (dense frosted). 0% and 100% are strictly restricted to safeguard the glass effect.
                            </p>
                        </div>
                    @endif

                    <!-- Conditional: Custom Colors (Light / Dark Mode with Text) -->
                    @if(($content['video_gallery_header_bg'] ?? '') === 'custom')
                        <div class="md:col-span-3 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.video_gallery_header_light_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.video_gallery_header_light_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Light Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.video_gallery_header_light_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.video_gallery_header_light_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Background</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.video_gallery_header_dark_bg" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.video_gallery_header_dark_bg" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400">Dark Mode Text Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.live="content.video_gallery_header_dark_text" class="w-8 h-8 rounded-lg cursor-pointer border-0">
                                    <input type="text" wire:model="content.video_gallery_header_dark_text" class="w-full px-2 py-1 text-xs font-mono rounded-lg border border-slate-200 dark:border-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Subtitle</label>
                        <textarea rows="2" wire:model="content.video_gallery_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>

                    <!-- Video Gallery Layout Controls -->
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Videos per Row (Columns)</label>
                        <select wire:model="content.video_gallery_grid_cols"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="1">1 Column (Large Cinema Display)</option>
                            <option value="2">2 Columns</option>
                            <option value="3">3 Columns (Default)</option>
                            <option value="4">4 Columns</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Videos to Show</label>
                        <select wire:model="content.video_gallery_per_page"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="6">6 Videos</option>
                            <option value="9">9 Videos</option>
                            <option value="12">12 Videos (Default)</option>
                            <option value="18">18 Videos</option>
                            <option value="all">All Videos (No Limit)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Show Album Category Filter</label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="content.video_gallery_show_albums" class="sr-only peer">
                                <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                                <span class="text-xs text-slate-600 dark:text-slate-400">Show Filter</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Sticky Bottom Save Bar -->
    <div class="sticky bottom-4 z-20 p-4 rounded-2xl bg-white/95 dark:bg-[#07131e]/95 backdrop-blur-md border border-slate-200 dark:border-slate-800 shadow-xl flex items-center justify-between">
        <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
            <x-icon name="solid:information-circle" class="w-4 h-4 text-cyan-500" />
            <span>Editing <strong>{{ ucfirst($activePage) }}</strong> settings. Toggle states reflect in real time. Changes take immediate effect upon save.</span>
        </div>

        <button type="button" 
                wire:click="saveContent"
                class="px-5 py-2.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs shadow-md transition-all inline-flex items-center gap-2 cursor-pointer active:scale-95">
            <x-icon name="solid:check" class="w-4 h-4" />
            <span>Save Changes</span>
        </button>
    </div>

    <!-- Dedicated Interactive Vector Icon Picker Modal -->
    <x-icon-picker-modal />
</div>
