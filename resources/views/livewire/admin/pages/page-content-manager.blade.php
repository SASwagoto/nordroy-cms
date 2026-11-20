<div class="space-y-6">
    <!-- Top Action Bar & Header Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight font-heading">
                    Static Page Content Studio
                </h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span>
                    Live Editor
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Customize titles, background styles, individual sections on/off, text colors, and dynamic pillars across fixed corporate pages.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            @php
                $previewUrl = match($activePage) {
                    'about'    => route('about'),
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

    <!-- Page Selection Segmented Navigation (Homepage removed as requested) -->
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
            <span>Contact &amp; Duty Desk (/contact)</span>
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
            <span>Services Header</span>
        </button>

        <button type="button" 
                wire:click="setPage('products')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'products' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:cog" class="w-4 h-4" />
            <span>Products Header</span>
        </button>

        <button type="button" 
                wire:click="setPage('gallery')"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap flex items-center gap-2 {{ $activePage === 'gallery' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800' }}">
            <x-icon name="solid:photo" class="w-4 h-4" />
            <span>Galleries Header</span>
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
                            Hero Header &amp; Background Style
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model="content.about_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background (Default)</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
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

                    <!-- Section ON/OFF Toggle -->
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

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-2">
                            <label class="text-[11px] font-bold uppercase text-slate-400">Spec Stat 1</label>
                            <input type="text" wire:model="content.about_stat1_value" placeholder="100k RPM"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                            <input type="text" wire:model="content.about_stat1_label" placeholder="Balancing Rig Capacity"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-2">
                            <label class="text-[11px] font-bold uppercase text-slate-400">Spec Stat 2</label>
                            <input type="text" wire:model="content.about_stat2_value" placeholder="± 0.005mm"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                            <input type="text" wire:model="content.about_stat2_label" placeholder="Shaft Run-Out Accuracy"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
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

                    <!-- OEM Card Toggle -->
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($content['about_show_mission'])
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-2">
                            <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                <x-icon name="solid:bullseye" class="w-4 h-4 text-cyan-500" />
                                <span>Mission Title</span>
                            </label>
                            <input type="text" wire:model="content.about_mission_title"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <label class="text-[11px] font-semibold text-slate-500">Mission Statement</label>
                            <textarea rows="3" wire:model="content.about_mission_text"
                                      class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                    @endif

                    @if($content['about_show_vision'])
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 space-y-2">
                            <label class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                <x-icon name="solid:eye" class="w-4 h-4 text-cyan-500" />
                                <span>Vision Title</span>
                            </label>
                            <input type="text" wire:model="content.about_vision_title"
                                   class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <label class="text-[11px] font-semibold text-slate-500">Vision Statement</label>
                            <textarea rows="3" wire:model="content.about_vision_text"
                                      class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 5: International Accreditations & Quality Framework -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            Quality Framework &amp; Accreditations (#certifications)
                        </h2>
                    </div>

                    <!-- Certifications Toggle -->
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show Accreditations:</span>
                        <input type="checkbox" wire:model="content.about_show_certifications" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['about_show_certifications'])
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Framework Badge</label>
                            <input type="text" wire:model="content.about_cert_badge"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Framework Main Title</label>
                            <input type="text" wire:model="content.about_cert_title"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Accreditation Badges List</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($aboutCertifications as $idx => $cert)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-xs font-mono font-bold border border-slate-200 dark:border-slate-700">
                                        <span>{{ $cert }}</span>
                                        <button type="button" wire:click="removeCertification({{ $idx }})" class="text-rose-500 hover:text-rose-700 cursor-pointer ml-1">&times;</button>
                                    </span>
                                @endforeach
                            </div>

                            <div class="flex items-center gap-2 pt-2">
                                <input type="text" wire:model="newCertName" placeholder="Add certification (e.g. ISO 9001:2015 CERTIFIED)"
                                       wire:keydown.enter.prevent="addCertification"
                                       class="flex-1 px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                <button type="button" wire:click="addCertification" class="px-4 py-2 rounded-xl text-xs font-bold bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">
                                    Add Badge
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ===================================================================
             2. CONTACT US PAGE EDITING STUDIO
             =================================================================== -->
        @if($activePage === 'contact')
            <!-- Hero Header & Background Style -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Contact Page Hero Header
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model="content.contact_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Top Badge</label>
                        <input type="text" wire:model="content.contact_badge"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Hero Main Title</label>
                        <input type="text" wire:model="content.contact_hero_title"
                               class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Hero Subtitle / Description</label>
                        <textarea rows="2" wire:model="content.contact_hero_subtitle"
                                  class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Facilities & Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chattogram Port Workshop -->
                <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <x-icon name="solid:wrench-screwdriver" class="w-4 h-4 text-cyan-500" />
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                                Primary Workshop (Port)
                            </h2>
                        </div>

                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <span class="text-xs font-semibold text-slate-500">Show Card:</span>
                            <input type="checkbox" wire:model="content.contact_show_port_facility" class="sr-only peer">
                            <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                        </label>
                    </div>

                    @if($content['contact_show_port_facility'])
                        <div class="space-y-3">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Facility Badge</label>
                                <input type="text" wire:model="content.contact_port_badge" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Facility Name</label>
                                <input type="text" wire:model="content.contact_port_title" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Address / Port Location</label>
                                <input type="text" wire:model="content.contact_port_address" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Workshop Equipment Description</label>
                                <textarea rows="2" wire:model="content.contact_port_desc" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Superintendent Phone</label>
                                    <input type="text" wire:model="content.contact_port_phone" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Operations Email</label>
                                    <input type="text" wire:model="content.contact_port_email" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 text-center text-xs text-slate-400">Port Facility card is hidden.</div>
                    @endif
                </div>

                <!-- Dhaka Corporate HQ -->
                <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <x-icon name="solid:building" class="w-4 h-4 text-cyan-500" />
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                                Corporate HQ (Dhaka)
                            </h2>
                        </div>

                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <span class="text-xs font-semibold text-slate-500">Show Card:</span>
                            <input type="checkbox" wire:model="content.contact_show_hq_facility" class="sr-only peer">
                            <div class="w-7 h-4 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-cyan-600"></div>
                        </label>
                    </div>

                    @if($content['contact_show_hq_facility'])
                        <div class="space-y-3">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">HQ Badge</label>
                                <input type="text" wire:model="content.contact_hq_badge" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">HQ Office Name</label>
                                <input type="text" wire:model="content.contact_hq_title" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Address / City</label>
                                <input type="text" wire:model="content.contact_hq_address" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">HQ Desk Phone</label>
                                    <input type="text" wire:model="content.contact_hq_phone" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Corporate Email</label>
                                    <input type="text" wire:model="content.contact_hq_email" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">24/7 Port Emergency Notice</label>
                                <input type="text" wire:model="content.contact_emergency_note" class="w-full px-3 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            </div>
                        </div>
                    @else
                        <div class="p-4 text-center text-xs text-slate-400">HQ Office card is hidden.</div>
                    @endif
                </div>
            </div>

            <!-- RFQ Lead Form Toggle -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 flex items-center justify-between shadow-xs">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Interactive RFQ Lead Submission Form
                    </h3>
                    <p class="text-xs text-slate-500">Show or hide the right-column quotation request form on /contact page.</p>
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
                        <select wire:model="content.careers_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
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
                                                title="Toggle Active/Hidden"
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
                                        <label class="text-[10px] font-semibold text-slate-500">Icon Key</label>
                                        <input type="text" wire:model="careersCultureCards.{{ $i }}.icon" placeholder="solid:cpu-chip"
                                               class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 font-mono">
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
                                   class="sm:col-span-4 px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <select wire:model="newPillarColor" class="sm:col-span-2 px-2 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200">
                                <option value="cyan">Cyan</option>
                                <option value="blue">Blue</option>
                                <option value="emerald">Emerald</option>
                                <option value="rose">Rose</option>
                                <option value="amber">Amber</option>
                                <option value="indigo">Indigo</option>
                                <option value="purple">Purple</option>
                            </select>
                            <input type="text" wire:model="newPillarIcon" placeholder="solid:bolt"
                                   class="sm:col-span-1 px-2 py-2 text-xs rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-mono">
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

            <!-- Spontaneous Application Section -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                            General Talent Pool / Spontaneous Application Banner
                        </h2>
                    </div>

                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <span class="text-xs font-semibold text-slate-500">Show Spontaneous Section:</span>
                        <input type="checkbox" wire:model="content.careers_show_spontaneous" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-600"></div>
                    </label>
                </div>

                @if($content['careers_show_spontaneous'])
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Banner Badge</label>
                            <input type="text" wire:model="content.careers_spontaneous_badge" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Banner Heading</label>
                            <input type="text" wire:model="content.careers_spontaneous_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Banner Narrative Description</label>
                            <textarea rows="2" wire:model="content.careers_spontaneous_desc" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Form Box Title</label>
                            <input type="text" wire:model="content.careers_form_title" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Form Box Subtitle</label>
                            <input type="text" wire:model="content.careers_form_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/20 text-amber-800 dark:text-amber-400 text-xs font-medium">
                        Spontaneous Application section is hidden. Only active vacancies will be displayed.
                    </div>
                @endif
            </div>
        @endif

        <!-- ===================================================================
             4. SERVICES CATALOG HEADER
             =================================================================== -->
        @if($activePage === 'services')
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Services Catalog Page Header (/services)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model="content.services_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
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

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Intro Subtitle / Narrative</label>
                        <textarea rows="3" wire:model="content.services_hero_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>
        @endif

        <!-- ===================================================================
             5. PRODUCTS CATALOG HEADER
             =================================================================== -->
        @if($activePage === 'products')
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
                        <select wire:model="content.products_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
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

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Intro Subtitle / Narrative</label>
                        <textarea rows="3" wire:model="content.products_hero_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>
        @endif

        <!-- ===================================================================
             6. GALLERIES HEADER
             =================================================================== -->
        @if($activePage === 'gallery')
            <!-- Photo Gallery Header -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <x-icon name="solid:photo" class="w-4 h-4 text-cyan-500" />
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Photo Gallery Header (/photo-gallery)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model="content.photo_gallery_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
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

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Subtitle</label>
                        <textarea rows="2" wire:model="content.photo_gallery_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>

            <!-- Video Gallery Header -->
            <div class="p-6 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <x-icon name="solid:video" class="w-4 h-4 text-cyan-500" />
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">
                        Video Gallery Header (/video-gallery)
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Header Background Style</label>
                        <select wire:model="content.video_gallery_header_bg"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                            <option value="transparent">Transparent Background</option>
                            <option value="frosted">Frosted Glass (Backdrop Blur)</option>
                            <option value="solid">Solid White / Navy Pure</option>
                            <option value="slate">Soft Slate Contrast</option>
                            <option value="gradient">Subtle Vertical Gradient</option>
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

                    <div class="md:col-span-3 space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Subtitle</label>
                        <textarea rows="2" wire:model="content.video_gallery_subtitle" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Sticky Bottom Save Bar -->
    <div class="sticky bottom-4 z-20 p-4 rounded-2xl bg-white/95 dark:bg-[#07131e]/95 backdrop-blur-md border border-slate-200 dark:border-slate-800 shadow-xl flex items-center justify-between">
        <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
            <x-icon name="solid:information-circle" class="w-4 h-4 text-cyan-500" />
            <span>Editing <strong>{{ ucfirst($activePage) }}</strong> page content. Disabled sections will seamlessly hide without empty gaps.</span>
        </div>

        <button type="button" 
                wire:click="saveContent"
                class="px-5 py-2.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs shadow-md transition-all inline-flex items-center gap-2 cursor-pointer active:scale-95">
            <x-icon name="solid:check" class="w-4 h-4" />
            <span>Save Changes</span>
        </button>
    </div>
</div>
