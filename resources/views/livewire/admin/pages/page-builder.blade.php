<div class="space-y-6">
    <!-- Top Bar: Page Customizer Header -->
    <div class="p-4 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        Storefront Customizer &amp; Sections CMS
                    </h1>
                    <span class="px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider rounded-md bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300">
                        CMS V2
                    </span>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Page: {{ $pageTitle }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Visual page builder and section layout engine. Reorder sections, customize box models, backgrounds, borders, and dynamic feeds.
                </p>
            </div>

            <!-- Top Action Controls -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ url('/?preview=1') }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs">
                    <x-icon name="solid:arrow-up-right-from-square" class="w-3.5 h-3.5" />
                    <span>Live Preview</span>
                </a>

                <button type="button" wire:click="save" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                    <span wire:loading.remove wire:target="save" class="flex items-center gap-1.5">
                        <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                        <span>Save All Changes</span>
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-1.5">
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
                <span class="text-[10px] text-emerald-600 dark:text-emerald-400 uppercase font-mono">Synchronized</span>
            </div>
        @endif
    </div>

    <!-- 2-Column Customizer Layout: Left Sidebar + Right Workspace -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- ==================== LEFT SIDEBAR: PAGE SECTIONS PANEL (col-12 col-lg-4) ==================== -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-4">
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
                <!-- Sidebar Header -->
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-icon name="solid:cubes" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Page Sections</span>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                        {{ count($sections) + 2 }} Items
                    </span>
                </div>

                <div class="p-3 space-y-2.5">
                    <!-- 1. Fixed Header Card -->
                    <div wire:click="selectSection('header')"
                         class="group p-2.5 rounded-xl border transition-all cursor-pointer flex items-center justify-between {{ $selectedSectionId === 'header' ? 'bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600' }}">
                        <div class="flex items-center gap-2.5 truncate">
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                <x-icon name="solid:window-maximize" class="w-3.5 h-3.5" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-bold truncate">Header (Global Multi-Row)</span>
                                <span class="block text-[9px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Top + Main + Sub</span>
                            </div>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-mono font-bold uppercase rounded bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 shrink-0">
                            FIXED
                        </span>
                    </div>

                    <!-- 2. Fixed Hero Banner Card -->
                    <div wire:click="selectSection('hero')"
                         class="group p-2.5 rounded-xl border transition-all cursor-pointer flex items-center justify-between {{ $selectedSectionId === 'hero' ? 'bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600' }} {{ $heroEnabled ? '' : 'opacity-60' }}">
                        <div class="flex items-center gap-2.5 truncate">
                            <x-icon name="solid:lock" class="w-3 h-3 text-slate-400 shrink-0" title="Fixed directly below Header" />
                            <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                <x-icon name="solid:images" class="w-3.5 h-3.5" />
                            </span>
                            <div class="truncate">
                                <span class="block text-xs font-bold truncate">{{ $heroTitle }}</span>
                                <span class="block text-[9px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">HERO BANNER (LOCKED)</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <!-- Toggle Visibility Eye -->
                            <button type="button" wire:click.stop="toggleSectionStatus('hero')"
                                    class="p-1 rounded-md text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors {{ $heroEnabled ? 'text-emerald-500 dark:text-emerald-400' : 'text-slate-400' }}"
                                    title="{{ $heroEnabled ? 'Hero Visible' : 'Hero Hidden' }}">
                                <x-icon name="{{ $heroEnabled ? 'solid:eye' : 'solid:eye-slash' }}" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>

                    <!-- Body Sections Header -->
                    <div class="pt-2 px-1 flex items-center justify-between border-t border-slate-100 dark:border-slate-800">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Homepage Sections
                        </span>
                        <span class="text-[9px] text-slate-400 flex items-center gap-1">
                            <span>Use</span>
                            <x-icon name="solid:arrows-up-down" class="w-2.5 h-2.5" />
                        </span>
                    </div>

                    <!-- 3. Sortable Body Sections List -->
                    <div class="space-y-1.5">
                        @forelse ($sections as $index => $sec)
                            @php
                                $typeIcons = [
                                    'grid'         => 'solid:table-cells',
                                    'slider'       => 'solid:film',
                                    'banner'       => 'solid:image',
                                    'text'         => 'solid:file-lines',
                                    'form'         => 'solid:envelope-open-text',
                                    'list'         => 'solid:list-check',
                                    'faq'          => 'solid:circle-question',
                                    'stats'        => 'solid:chart-simple',
                                    'testimonials' => 'solid:comments',
                                    'custom_html'  => 'solid:code',
                                ];
                                $icon = $typeIcons[$sec['section_type']] ?? 'solid:cube';
                                $isActive = (string)$selectedSectionId === (string)$sec['id'];
                            @endphp
                            <div wire:key="sec-item-{{ $sec['id'] }}"
                                 wire:click="selectSection('{{ $sec['id'] }}')"
                                 class="group p-2 rounded-xl border transition-all cursor-pointer flex items-center justify-between {{ $isActive ? 'bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600' }} {{ $sec['is_active'] ? '' : 'opacity-60' }}">
                                
                                <div class="flex items-center gap-2 truncate flex-1 mr-1">
                                    <x-icon name="solid:grip-vertical" class="w-3 h-3 text-slate-300 dark:text-slate-600 group-hover:text-slate-400 shrink-0 cursor-grab" />
                                    <span class="w-6 h-6 rounded-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                        <x-icon name="{{ $icon }}" class="w-3 h-3" />
                                    </span>
                                    <div class="truncate">
                                        <span class="block text-xs font-semibold truncate">{{ $sec['title'] }}</span>
                                        <span class="block text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">{{ $sec['section_type'] }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons: Up, Down, Eye, Delete -->
                                <div class="flex items-center gap-0.5 shrink-0">
                                    <button type="button" wire:click.stop="moveSection('{{ $sec['id'] }}', 'up')"
                                            class="p-1 rounded text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                                            title="Move Up">
                                        <x-icon name="solid:chevron-up" class="w-2.5 h-2.5" />
                                    </button>
                                    <button type="button" wire:click.stop="moveSection('{{ $sec['id'] }}', 'down')"
                                            class="p-1 rounded text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors"
                                            title="Move Down">
                                        <x-icon name="solid:chevron-down" class="w-2.5 h-2.5" />
                                    </button>
                                    <button type="button" wire:click.stop="toggleSectionStatus('{{ $sec['id'] }}')"
                                            class="p-1 rounded transition-colors {{ $sec['is_active'] ? 'text-emerald-500 hover:text-emerald-600' : 'text-slate-400 hover:text-slate-600' }}"
                                            title="{{ $sec['is_active'] ? 'Visible' : 'Hidden' }}">
                                        <x-icon name="{{ $sec['is_active'] ? 'solid:eye' : 'solid:eye-slash' }}" class="w-3 h-3" />
                                    </button>
                                    <button type="button" wire:click.stop="deleteSection('{{ $sec['id'] }}')"
                                            wire:confirm="Are you sure you want to remove this section from the page?"
                                            class="p-1 rounded text-slate-400 hover:text-rose-500 transition-colors"
                                            title="Delete Section">
                                        <x-icon name="solid:trash-can" class="w-3 h-3" />
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-dashed border-slate-200 dark:border-slate-700 text-slate-400 text-xs">
                                No body sections added yet.
                            </div>
                        @endforelse
                    </div>

                    <!-- 4. Add New Section Button (Dashed Outline) -->
                    <button type="button" wire:click="openCreateModal"
                            class="w-full py-2.5 px-3 rounded-xl border-2 border-dashed border-[#003C58]/30 dark:border-cyan-500/30 hover:border-[#003C58] dark:hover:border-cyan-400 text-[#003C58] dark:text-cyan-400 text-xs font-bold flex items-center justify-center gap-2 hover:bg-[#003C58]/5 dark:hover:bg-cyan-500/5 transition-all cursor-pointer">
                        <x-icon name="solid:circle-plus" class="w-4 h-4" />
                        <span>Add New Section</span>
                    </button>

                    <!-- 5. Fixed Global Footer Card -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                        <span class="block px-1 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Global Footer Section
                        </span>
                        <div wire:click="selectSection('footer')"
                             class="group p-2.5 rounded-xl border transition-all cursor-pointer flex items-center justify-between {{ $selectedSectionId === 'footer' ? 'bg-cyan-50/70 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600' }}">
                            <div class="flex items-center gap-2.5 truncate">
                                <span class="w-7 h-7 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-[#003C58] dark:text-cyan-400 shrink-0 shadow-2xs">
                                    <x-icon name="solid:shoe-prints" class="w-3.5 h-3.5" />
                                </span>
                                <div class="truncate">
                                    <span class="block text-xs font-bold truncate">Global Store Footer</span>
                                    <span class="block text-[9px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Multi-Row + Modular Columns</span>
                                </div>
                            </div>
                            <span class="px-1.5 py-0.5 text-[9px] font-mono font-bold uppercase rounded bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 shrink-0">
                                FIXED
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ==================== RIGHT WORKSPACE: ACTIVE SECTION CONFIGURATION (col-12 col-lg-8) ==================== -->
        <div class="lg:col-span-8 xl:col-span-9 space-y-6">

            <!-- Active Header Workspace -->
            @if ($selectedSectionId === 'header')
                @include('livewire.admin.pages.partials._page_builder_header')

            <!-- Active Hero Workspace -->
            @elseif ($selectedSectionId === 'hero')
                @include('livewire.admin.pages.partials._page_builder_hero')

            <!-- Active Footer Workspace -->
            @elseif ($selectedSectionId === 'footer')
                @include('livewire.admin.pages.partials._page_builder_footer')

            <!-- Active Body Section Workspace -->
            @else
                @include('livewire.admin.pages.partials._page_builder_section')
            @endif

        </div>

    </div>

    <!-- ==================== MODAL: ADD NEW SECTION ==================== -->
    @if ($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="relative w-full max-w-2xl rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center">
                            <x-icon name="solid:circle-plus" class="w-4 h-4" />
                        </span>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Add New Homepage Section</h3>
                            <p class="text-[11px] text-slate-500">Choose a section component to insert into your page layout</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeCreateModal"
                            class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <x-icon name="solid:xmark" class="w-4 h-4" />
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Section Title</label>
                        <input type="text" wire:model="newSectionTitle"
                               placeholder="e.g. Authorized Turbocharger Overhaul Facilities"
                               class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    </div>

                    <!-- Type Selection Grid -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Component Type</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @foreach ([
                                'grid'         => ['name' => 'Grid Showcase', 'desc' => 'Multi-column cards or service items', 'icon' => 'solid:table-cells'],
                                'slider'       => ['name' => 'Slider / Carousel', 'desc' => 'Interactive slide showcase or marquee', 'icon' => 'solid:film'],
                                'banner'       => ['name' => 'Feature Banner', 'desc' => 'Full-width visual banner with callout', 'icon' => 'solid:image'],
                                'text'         => ['name' => 'Editorial Text', 'desc' => 'Headings, lead text and descriptions', 'icon' => 'solid:file-lines'],
                                'form'         => ['name' => 'Inquiry / RFQ Form', 'desc' => 'Interactive service dispatch form', 'icon' => 'solid:envelope-open-text'],
                                'list'         => ['name' => 'Features & Steps', 'desc' => 'Step-by-step checklist or specs', 'icon' => 'solid:list-check'],
                                'faq'          => ['name' => 'FAQ Accordion', 'desc' => 'Expandable questions and answers', 'icon' => 'solid:circle-question'],
                                'stats'        => ['name' => 'Metrics Counter', 'desc' => 'Key metrics and stat callouts', 'icon' => 'solid:chart-simple'],
                                'testimonials' => ['name' => 'Testimonials', 'desc' => 'Customer ratings and feedback cards', 'icon' => 'solid:comments'],
                                'custom_html'  => ['name' => 'Custom HTML', 'desc' => 'Raw markup, scripts, and embeds', 'icon' => 'solid:code'],
                            ] as $tKey => $tData)
                                <button type="button" wire:click="$set('newSectionType', '{{ $tKey }}')"
                                        class="p-3 rounded-2xl border text-left transition-all cursor-pointer flex flex-col justify-between {{ $newSectionType === $tKey ? 'bg-cyan-50/80 border-cyan-500 text-cyan-900 dark:bg-cyan-950/40 dark:border-cyan-500 dark:text-cyan-200 ring-2 ring-cyan-500/20' : 'bg-slate-50 dark:bg-slate-800/40 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <x-icon name="{{ $tData['icon'] }}" class="w-4 h-4 text-[#003C58] dark:text-cyan-400 shrink-0" />
                                        <span class="text-xs font-bold leading-tight">{{ $tData['name'] }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 leading-snug">{{ $tData['desc'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-3.5 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-2">
                    <button type="button" wire:click="closeCreateModal"
                            class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        Cancel
                    </button>
                    <button type="button" wire:click="addSection"
                            class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer">
                        Add Section to Layout
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Universal Media Library & Icon Picker Modals -->
    <x-media-picker-modal />
    <x-icon-picker-modal />
</div>
