<div class="space-y-6">
    <!-- Header Top Action Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center shrink-0">
                <x-icon name="solid:window-maximize" class="w-5 h-5" />
            </span>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Global Website Header</h2>
                    <span class="px-2 py-0.5 text-[9px] font-bold rounded-md bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Fixed at Top</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">3-Row customizable corporate header with independent box models and surfaces</p>
            </div>
        </div>

        <button type="button" wire:click="save"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-xs cursor-pointer">
            <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
            <span>Save Header</span>
        </button>
    </div>

    <!-- Row Navigation Tabs -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
        <button type="button" wire:click="selectHeaderRow('section')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeHeaderRow === 'section' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:layer-group" class="w-4 h-4 {{ $activeHeaderRow === 'section' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Wrapper</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Master Section</span>
        </button>

        <button type="button" wire:click="selectHeaderRow('row1')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeHeaderRow === 'row1' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:bolt" class="w-4 h-4 {{ $activeHeaderRow === 'row1' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Row 1</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Topbar Strip</span>
        </button>

        <button type="button" wire:click="selectHeaderRow('row2')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeHeaderRow === 'row2' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:bars-staggered" class="w-4 h-4 {{ $activeHeaderRow === 'row2' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Row 2</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Main Navbar</span>
        </button>

        <button type="button" wire:click="selectHeaderRow('row3')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeHeaderRow === 'row3' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:bullhorn" class="w-4 h-4 {{ $activeHeaderRow === 'row3' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Row 3</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Sub-Header Bar</span>
        </button>
    </div>

    <!-- Active Tab Configuration Body -->
    @if ($activeHeaderRow === 'section')
        <!-- Master Section Wrapper Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Main Outer Header Section (Master Wrapper)</h3>
                <p class="text-xs text-slate-500">Overall container wrapping all header rows. Controls overall container width, sticky behavior, and outer surface.</p>
            </div>

            <!-- Box Model Component -->
            <x-smart-box-model wire:model="headerSectionBoxModel" label="Master Header Section Box Model & Spacing" />

            <!-- Background & Text Surfaces -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-smart-color-picker wire:model="headerSectionBgColor" label="Master Header Section Background" />
                <x-smart-color-picker wire:model="headerSectionTextColor" label="Master Header Section Text Color" :allowGradient="false" :allowGlass="false" />
            </div>

            <!-- Sticky & Theme Behavior -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Sticky Header</span>
                        <span class="block text-[11px] text-slate-400">Keep header pinned to top during page scroll</span>
                    </div>
                    <input type="checkbox" wire:model="headerSticky" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Theme Toggle Button</span>
                        <span class="block text-[11px] text-slate-400">Show light/dark mode switch in navbar</span>
                    </div>
                    <input type="checkbox" wire:model="headerThemeToggle" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>
        </div>

    @elseif ($activeHeaderRow === 'row1')
        <!-- Row 1: Topbar Strip Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 1: Top Emergency &amp; Information Strip</h3>
                    <p class="text-xs text-slate-500">Contact hotlines, emergency dispatch badge, and social handles.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Enable Topbar</span>
                    <input type="checkbox" wire:model="headerTopbar.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>

            @if ($headerTopbar['enabled'] ?? true)
                <x-smart-box-model wire:model="topbarBoxModel" label="Topbar Layout & Box Model (Independent Row 1)" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-smart-color-picker wire:model="topbarBgColor" label="Topbar Row Background" />
                    <x-smart-color-picker wire:model="topbarTextColor" label="Topbar Row Text Color" :allowGradient="false" :allowGlass="false" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Emergency Badge Text</label>
                        <input type="text" wire:model="headerTopbar.badge_text" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Duty Desk Phone</label>
                        <input type="text" wire:model="headerTopbar.phone" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Duty Desk Email</label>
                        <input type="text" wire:model="headerTopbar.email" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>
            @endif
        </div>

    @elseif ($activeHeaderRow === 'row2')
        <!-- Row 2: Main Header Navbar Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 2: Main Header Navbar</h3>
                <p class="text-xs text-slate-500">Brand identity, corporate navigation menus, and primary call-to-action button.</p>
            </div>

            <x-smart-box-model wire:model="headerBoxModel" label="Header Navbar Layout & Box Model (Independent Row 2)" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-smart-color-picker wire:model="headerBgColor" label="Navbar Row Background" />
                <x-smart-color-picker wire:model="headerTextColor" label="Navbar Row Text & Navigation Color" :allowGradient="false" :allowGlass="false" />
            </div>

            <!-- Menu Selector & Call to Action -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Primary Navigation Menu</label>
                    <select wire:model="headerMenuId" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        <option value="">-- Theme Default Navigation --</option>
                        @foreach ($availableMenus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }} ({{ $menu->items_count }} items)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Header Style Variant</label>
                    <select wire:model="headerStyle" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        <option value="glass">Glassmorphism Frosted</option>
                        <option value="solid">Solid Background</option>
                        <option value="transparent">Transparent Floating</option>
                    </select>
                </div>
            </div>

            <!-- CTA Button Settings -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Header Call to Action (CTA) Button</span>
                    <input type="checkbox" wire:model="headerCta.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>

                @if ($headerCta['enabled'] ?? true)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Button Label</label>
                            <input type="text" wire:model="headerCta.label" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Button Variant</label>
                            <select wire:model="headerCta.variant" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="primary">Primary Brand</option>
                                <option value="outline">Outline</option>
                                <option value="custom">Custom Color</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Target Route / URL</label>
                            <input type="text" wire:model="headerCta.destination.value" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                    </div>
                @endif
            </div>
        </div>

    @elseif ($activeHeaderRow === 'row3')
        <!-- Row 3: Sub-Header Bar Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 3: Bottom Sub-Header Bar</h3>
                    <p class="text-xs text-slate-500">Secondary navigation strip, division categories, or announcements ticker.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Enable Row 3</span>
                    <input type="checkbox" wire:model="headerBottom.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>

            @if ($headerBottom['enabled'] ?? false)
                <x-smart-box-model wire:model="headerBottom.box_model" label="Sub-Header Layout & Box Model (Independent Row 3)" />

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Ticker / Announcement Text</label>
                    <input type="text" wire:model="headerBottom.ticker_text" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                </div>
            @endif
        </div>
    @endif
</div>
