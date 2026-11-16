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
                    <p class="text-xs text-slate-500">Multi-column strip with dynamic contact hotlines, social handles, and custom announcements.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Enable Topbar</span>
                    <input type="checkbox" wire:model.live="headerTopbar.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>

            @if ($headerTopbar['enabled'] ?? true)
                <x-smart-box-model wire:model="topbarBoxModel" label="Topbar Layout & Box Model (Independent Row 1)" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-smart-color-picker wire:model="topbarBgColor" label="Topbar Row Background" />
                    <x-smart-color-picker wire:model="topbarTextColor" label="Topbar Row Text Color" :allowGradient="false" :allowGlass="false" />
                </div>

                <!-- Number of Columns Selector -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <x-icon name="solid:table-columns" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                            <span>Topbar Column Grid &amp; Content Items (sherazipos12 Architecture)</span>
                        </span>
                        <div class="flex items-center gap-2">
                            <label class="text-[11px] font-semibold text-slate-500">Columns:</label>
                            <select wire:model.live="headerTopbar.columns_count" class="px-2.5 py-1 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="1">1 Column</option>
                                <option value="2">2 Columns (Left &amp; Right)</option>
                                <option value="3">3 Columns</option>
                                <option value="4">4 Columns</option>
                            </select>
                        </div>
                    </div>

                    <!-- Column Editors -->
                    @php
                        $colsCount = (int)($headerTopbar['columns_count'] ?? 2);
                    @endphp
                    <div class="grid grid-cols-1 {{ $colsCount >= 2 ? 'md:grid-cols-2' : '' }} gap-4">
                        @for ($c = 1; $c <= $colsCount; $c++)
                            @php
                                $colKey = 'col' . $c;
                                $colData = $headerTopbar[$colKey] ?? ['alignment' => ($c === 1 ? 'start' : 'end'), 'items' => []];
                                $items = $colData['items'] ?? [];
                            @endphp
                            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-2xs space-y-3">
                                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 text-[9px] font-mono font-bold rounded bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">COLUMN {{ $c }}</span>
                                        <select wire:model.live="headerTopbar.{{ $colKey }}.alignment" class="px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 dark:bg-slate-800 border-0 text-slate-700 dark:text-slate-300">
                                            <option value="start">Align Left</option>
                                            <option value="center">Align Center</option>
                                            <option value="end">Align Right</option>
                                        </select>
                                    </div>
                                    <button type="button" wire:click="addTopbarItem('{{ $colKey }}')"
                                            class="px-2 py-1 rounded-lg text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1">
                                        <x-icon name="solid:circle-plus" class="w-3 h-3" />
                                        <span>Add Item</span>
                                    </button>
                                </div>

                                <!-- Items in this column -->
                                <div class="space-y-2.5">
                                    @forelse ($items as $itIdx => $it)
                                        <div wire:key="tb-{{ $colKey }}-{{ $itIdx }}" class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-2.5">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-[10px] font-bold text-slate-400">#{{ $itIdx + 1 }}</span>
                                                    <select wire:model.live="headerTopbar.{{ $colKey }}.items.{{ $itIdx }}.type" class="px-2 py-0.5 text-[10px] font-bold rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                        <option value="custom">Custom Text &amp; Link</option>
                                                        <option value="dynamic_phone">📞 Phone Hotline</option>
                                                        <option value="dynamic_email">✉️ Email Address</option>
                                                        <option value="dynamic_address">📍 Workshop / Port Address</option>
                                                        <option value="dynamic_socials">🌐 Social Handles</option>
                                                    </select>
                                                </div>
                                                <button type="button" wire:click="removeTopbarItem('{{ $colKey }}', {{ $itIdx }})" class="text-rose-500 hover:text-rose-600">
                                                    <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                                </button>
                                            </div>

                                            <!-- Fast Sync from Site Settings Buttons -->
                                            <div class="flex items-center gap-1.5 flex-wrap pt-0.5">
                                                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Sync Site Setting:</span>
                                                <button type="button" wire:click="syncTopbarItemWithSiteSettings({{ $c }}, {{ $itIdx }}, 'site_phone')" title="Fetch Phone from Site Settings" class="px-2 py-0.5 text-[9px] rounded-md bg-cyan-50 dark:bg-cyan-950/40 text-cyan-700 dark:text-cyan-300 font-bold border border-cyan-200 dark:border-cyan-800 hover:bg-cyan-100 transition-colors">
                                                    📞 Phone
                                                </button>
                                                <button type="button" wire:click="syncTopbarItemWithSiteSettings({{ $c }}, {{ $itIdx }}, 'site_email')" title="Fetch Email from Site Settings" class="px-2 py-0.5 text-[9px] rounded-md bg-cyan-50 dark:bg-cyan-950/40 text-cyan-700 dark:text-cyan-300 font-bold border border-cyan-200 dark:border-cyan-800 hover:bg-cyan-100 transition-colors">
                                                    ✉️ Email
                                                </button>
                                                <button type="button" wire:click="syncTopbarItemWithSiteSettings({{ $c }}, {{ $itIdx }}, 'site_emergency')" title="Fetch 24/7 Hotline" class="px-2 py-0.5 text-[9px] rounded-md bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 font-bold border border-rose-200 dark:border-rose-800 hover:bg-rose-100 transition-colors">
                                                    🚨 24/7 Port SOS
                                                </button>
                                                <button type="button" wire:click="syncTopbarItemWithSiteSettings({{ $c }}, {{ $itIdx }}, 'site_hours')" title="Fetch Hours" class="px-2 py-0.5 text-[9px] rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold border border-slate-300 dark:border-slate-700 hover:bg-slate-200 transition-colors">
                                                    🕒 Hours
                                                </button>
                                            </div>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-[9px] font-semibold text-slate-400 mb-0.5">Display Text</label>
                                                    <input type="text" wire:model.live="headerTopbar.{{ $colKey }}.items.{{ $itIdx }}.text" placeholder="Text..." class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-[9px] font-semibold text-slate-400 mb-0.5">Target Link / URL</label>
                                                    <input type="text" wire:model.live="headerTopbar.{{ $colKey }}.items.{{ $itIdx }}.url" placeholder="tel:... or mailto:... or /services" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between pt-1 border-t border-slate-200 dark:border-slate-700/60">
                                                <label class="flex items-center gap-1.5 cursor-pointer text-[10px] text-slate-500">
                                                    <input type="checkbox" wire:model.live="headerTopbar.{{ $colKey }}.items.{{ $itIdx }}.show_icon" class="rounded text-[#003C58] h-3 w-3">
                                                    <span>Show Icon</span>
                                                </label>

                                                <!-- Interactive Icon Picker Modal Trigger -->
                                                <div class="flex items-center gap-1.5">
                                                    <button type="button" 
                                                            @click="$dispatch('open-icon-picker', { targetField: 'headerTopbar.{{ $colKey }}.items', targetIndex: {{ $itIdx }} })"
                                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:border-cyan-500 text-[10px] font-mono font-bold text-slate-700 dark:text-slate-300 shadow-2xs cursor-pointer">
                                                        <x-icon :name="$it['icon'] ?: 'solid:icons'" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                                                        <span>{{ $it['icon'] ?: 'Choose Icon' }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-3 text-center rounded-lg bg-slate-50 dark:bg-slate-800/40 text-slate-400 text-xs">
                                            No items in this column. Click "Add Item" above.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endfor
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

            <!-- 1. Brand Logo & Title Identity Card (Inspired by sherazipos12) -->
            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <x-icon name="solid:id-badge" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                        <span>Brand Identity &amp; Logo Settings</span>
                    </span>
                    <div class="flex items-center gap-2 p-1 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                        <label class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer {{ $headerLogoType === 'site' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-600 dark:text-slate-400' }}">
                            <input type="radio" wire:model.live="headerLogoType" value="site" class="sr-only">
                            <span>Default Site Logo</span>
                        </label>
                        <label class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer {{ $headerLogoType === 'custom' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'text-slate-600 dark:text-slate-400' }}">
                            <input type="radio" wire:model.live="headerLogoType" value="custom" class="sr-only">
                            <span>Custom Header Logo</span>
                        </label>
                    </div>
                </div>

                @if ($headerLogoType === 'custom')
                    <!-- Custom Logo Upload / Media Library Selectors -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300">Light Mode Header Logo</label>
                            <div class="flex items-center gap-3">
                                <div class="w-16 h-12 rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                                    @if ($headerCustomLogo)
                                        <img src="{{ asset($headerCustomLogo) }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <x-icon name="solid:image" class="w-5 h-5 text-slate-400" />
                                    @endif
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input type="text" wire:model.live="headerCustomLogo" placeholder="assets/images/logo.png" class="w-full px-2 py-1 text-xs rounded bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <button type="button" @click="$dispatch('open-media-picker', { targetField: 'headerCustomLogo' })" class="text-[10px] font-bold text-cyan-600 hover:underline">
                                        Choose from Media Asset Library &rarr;
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300">Dark Mode Header Logo</label>
                            <div class="flex items-center gap-3">
                                <div class="w-16 h-12 rounded-lg bg-slate-900 border border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                                    @if ($headerCustomLogoDark)
                                        <img src="{{ asset($headerCustomLogoDark) }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <x-icon name="solid:image" class="w-5 h-5 text-slate-500" />
                                    @endif
                                </div>
                                <div class="flex-1 space-y-1">
                                    <input type="text" wire:model.live="headerCustomLogoDark" placeholder="assets/images/logo-dark.png" class="w-full px-2 py-1 text-xs rounded bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <button type="button" @click="$dispatch('open-media-picker', { targetField: 'headerCustomLogoDark' })" class="text-[10px] font-bold text-cyan-600 hover:underline">
                                        Choose from Media Asset Library &rarr;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-500">
                        <x-icon name="solid:circle-info" class="w-4 h-4 text-cyan-500 shrink-0" />
                        <span>Using default site logo configured in Global Settings (<a href="{{ route('admin.settings') }}" class="text-cyan-600 underline font-semibold">Settings Studio</a>).</span>
                    </div>
                @endif

                <!-- Title & Tagline Toggles -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-slate-200 dark:border-slate-700">
                    <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 cursor-pointer">
                        <input type="checkbox" wire:model.live="headerShowTitle" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Show Brand Title</span>
                            <span class="block text-[10px] text-slate-400">Display site name beside logo</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 cursor-pointer">
                        <input type="checkbox" wire:model.live="headerShowTagline" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Show Tagline</span>
                            <span class="block text-[10px] text-slate-400">Subtitle below corporate name</span>
                        </div>
                    </label>

                    <div class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Logo Height</label>
                        <select wire:model.live="headerLogoHeight" class="w-full px-2 py-1 text-xs font-bold rounded bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            <option value="36px">36px (Compact)</option>
                            <option value="44px">44px (Standard)</option>
                            <option value="52px">52px (Medium)</option>
                            <option value="60px">60px (Prominent)</option>
                            <option value="72px">72px (Executive)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2. Navbar Box Model & Colors -->
            <x-smart-box-model wire:model="headerBoxModel" label="Header Navbar Layout & Box Model (Independent Row 2)" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-smart-color-picker wire:model="headerBgColor" label="Navbar Row Background" />
                <x-smart-color-picker wire:model="headerTextColor" label="Navbar Row Text & Navigation Color" :allowGradient="false" :allowGlass="false" />
            </div>

            <!-- 3. Menu Selector & Style Variant -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Primary Navigation Menu</label>
                    <div class="flex items-center gap-2">
                        <select wire:model.live="headerMenuId" class="flex-1 px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            <option value="">-- Theme Default Navigation --</option>
                            @foreach ($availableMenus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }} ({{ $menu->items_count }} items)</option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.menus') }}" target="_blank" class="px-3 py-2 text-xs font-bold rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 transition-colors shrink-0">
                            Manage Menus &rarr;
                        </a>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Header Style Variant</label>
                    <select wire:model.live="headerStyle" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        <option value="glass">Glassmorphism Frosted</option>
                        <option value="solid">Solid Background</option>
                        <option value="transparent">Transparent Floating</option>
                    </select>
                </div>
            </div>

            <!-- 4. CTA Button Settings with Icon Picker -->
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Header Call to Action (CTA) Button</span>
                    <input type="checkbox" wire:model.live="headerCta.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>

                @if ($headerCta['enabled'] ?? true)
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Button Label</label>
                            <input type="text" wire:model.live="headerCta.label" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Target Route / URL</label>
                            <input type="text" wire:model.live="headerCta.destination.value" placeholder="/services or /#rfq" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Button Style</label>
                            <select wire:model.live="headerCta.variant" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="primary">Primary Gradient</option>
                                <option value="outline">Outline</option>
                                <option value="custom">Solid Accent</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Button Icon</label>
                            <button type="button" 
                                    @click="$dispatch('open-icon-picker', { targetField: 'headerCta.icon' })"
                                    class="w-full flex items-center justify-between px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 cursor-pointer shadow-2xs">
                                <span class="flex items-center gap-1.5">
                                    <x-icon :name="$headerCta['icon'] ?? 'solid:file-pen'" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                                    <span class="truncate">{{ $headerCta['icon'] ?? 'Icon' }}</span>
                                </span>
                                <x-icon name="solid:pencil" class="w-3 h-3 text-slate-400" />
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    @elseif ($activeHeaderRow === 'row3')
        <!-- Row 3: Sub-Header Bar Config (Full Content Engine) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 3: Bottom Sub-Header Bar</h3>
                    <p class="text-xs text-slate-500">Secondary navigation strip, division categories, or announcements ticker.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Enable Row 3</span>
                    <input type="checkbox" wire:model.live="headerBottom.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>

            @if ($headerBottom['enabled'] ?? false)
                <x-smart-box-model wire:model="headerBottom.box_model" label="Sub-Header Layout & Box Model (Independent Row 3)" />

                <!-- Sub-header Content Type Selector -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-3">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Sub-Header Display Format</span>
                        <div class="flex items-center gap-2">
                            <select wire:model.live="headerBottom.type" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="notice">📢 Announcement &amp; Ticker Strip</option>
                                <option value="quick_links">🔗 Quick Links &amp; Categories Strip</option>
                                <option value="emergency">🚨 24/7 Flying Squad Hotline Strip</option>
                            </select>
                        </div>
                    </div>

                    @if (($headerBottom['type'] ?? 'notice') === 'notice')
                        <!-- Announcement / Notice Ticker -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Badge Text</label>
                                <input type="text" wire:model.live="headerBottom.badge_text" placeholder="Official Notice" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Announcement Headline</label>
                                <input type="text" wire:model.live="headerBottom.ticker_text" placeholder="Direct Drydock & Berth Support: Chittagong Anchorage • Mongla Port • Payra Port" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Action Link Destination</label>
                                <input type="text" wire:model.live="headerBottom.ticker_link" placeholder="/services or https://..." class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>

                    @elseif (($headerBottom['type'] ?? '') === 'quick_links')
                        <!-- Quick Links Repeater -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Quick Links ({{ count($headerBottom['quick_links'] ?? []) }})</span>
                                <button type="button" wire:click="addRow3QuickLink" class="px-3 py-1 rounded-lg text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1">
                                    <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                                    <span>Add Link</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach ($headerBottom['quick_links'] ?? [] as $qlIdx => $ql)
                                    <div wire:key="ql-{{ $qlIdx }}" class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <button type="button" 
                                                    @click="$dispatch('open-icon-picker', { targetField: 'headerBottom.quick_links', targetIndex: {{ $qlIdx }} })"
                                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-mono font-bold text-slate-700 dark:text-slate-300">
                                                <x-icon :name="$ql['icon'] ?: 'solid:chevron-right'" class="w-3 h-3 text-[#003C58] dark:text-cyan-400" />
                                                <span>{{ $ql['icon'] ?: 'Icon' }}</span>
                                            </button>
                                            <button type="button" wire:click="removeRow3QuickLink({{ $qlIdx }})" class="text-rose-500 hover:text-rose-600">
                                                <x-icon name="solid:trash-can" class="w-3 h-3" />
                                            </button>
                                        </div>
                                        <input type="text" wire:model.live="headerBottom.quick_links.{{ $qlIdx }}.label" placeholder="Link Label" class="w-full px-2 py-1 text-xs font-bold rounded bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                        <input type="text" wire:model.live="headerBottom.quick_links.{{ $qlIdx }}.url" placeholder="/services" class="w-full px-2 py-1 text-xs rounded bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif (($headerBottom['type'] ?? '') === 'emergency')
                        <!-- Emergency Port Hotline Strip -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Hotline Number</label>
                                <input type="text" wire:model.live="headerBottom.emergency_phone" placeholder="+880 1819 000000" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Duty Response Badge</label>
                                <input type="text" wire:model.live="headerBottom.emergency_subtext" placeholder="45-Min Emergency Response Squad" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Call Button Label</label>
                                <input type="text" wire:model.live="headerBottom.emergency_btn_text" placeholder="Call 24/7 Duty Desk" class="w-full px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
