<div class="space-y-6">
    <!-- Footer Top Action Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center shrink-0">
                <x-icon name="solid:shoe-prints" class="w-5 h-5" />
            </span>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Global Website Footer</h2>
                    <span class="px-2 py-0.5 text-[9px] font-bold rounded-md bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Fixed at Bottom</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Multi-row modular corporate footer with independent column layouts and sub-footer</p>
            </div>
        </div>

        <button type="button" wire:click="save"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-xs cursor-pointer">
            <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
            <span>Save Footer</span>
        </button>
    </div>

    <!-- Row Navigation Tabs -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
        <button type="button" wire:click="selectFooterRow('section')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeFooterRow === 'section' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:layer-group" class="w-4 h-4 {{ $activeFooterRow === 'section' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Wrapper</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Master Section</span>
        </button>

        <button type="button" wire:click="selectFooterRow('row1')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeFooterRow === 'row1' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:bullhorn" class="w-4 h-4 {{ $activeFooterRow === 'row1' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Row 1</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Pre-Footer Callout</span>
        </button>

        <button type="button" wire:click="selectFooterRow('row2')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeFooterRow === 'row2' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:table-columns" class="w-4 h-4 {{ $activeFooterRow === 'row2' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Row 2</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Modular Columns</span>
        </button>

        <button type="button" wire:click="selectFooterRow('row3')"
                class="p-3 rounded-2xl border text-left transition-all cursor-pointer {{ $activeFooterRow === 'row3' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
            <div class="flex items-center gap-2 mb-1">
                <x-icon name="solid:copyright" class="w-4 h-4 {{ $activeFooterRow === 'row3' ? 'text-cyan-300 dark:text-slate-900' : 'text-[#003C58] dark:text-cyan-400' }}" />
                <span class="text-[10px] font-extrabold uppercase tracking-wider opacity-80">Row 3</span>
            </div>
            <span class="block text-xs font-bold leading-tight">Sub-Footer Row</span>
        </button>
    </div>

    <!-- Active Tab Configuration Body -->
    @if ($activeFooterRow === 'section')
        <!-- Master Footer Wrapper Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Main Outer Footer Section (Master Wrapper)</h3>
                <p class="text-xs text-slate-500">Master container for entire corporate footer including all rows and background surface.</p>
            </div>

            <x-smart-box-model wire:model="footerSectionBoxModel" label="Master Footer Section Box Model & Spacing" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-smart-color-picker wire:model="footerSectionBgColor" label="Master Footer Section Background" />
                <x-smart-color-picker wire:model="footerSectionTextColor" label="Master Footer Section Text Color" :allowGradient="false" :allowGlass="false" />
            </div>
        </div>

    @elseif ($activeFooterRow === 'row1')
        <!-- Row 1: Pre-Footer Callout & Features Strip Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 1: Pre-Footer Feature Strip &amp; Urgent Callout</h3>
                    <p class="text-xs text-slate-500">Value proposition badges, 24/7 hotline numbers, and emergency booking.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Enable Pre-Footer</span>
                    <input type="checkbox" wire:model.live="footerTop.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>

            @if ($footerTop['enabled'] ?? true)
                <x-smart-box-model wire:model="footerTop.box_model" label="Pre-Footer Layout & Box Model (Independent Row 1)" />

                <!-- Features Cards Repeater (sherazipos12 Top Row Engine) -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <x-icon name="solid:certificate" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                            <span>Value Proposition Badges (Up to 4 Columns)</span>
                        </span>
                        @if (count($footerTop['features'] ?? []) < 4)
                            <button type="button" wire:click="addFooterTopFeature" class="text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                + Add Feature Badge
                            </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach ($footerTop['features'] ?? [] as $fIdx => $feat)
                            <div wire:key="ft-feat-{{ $fIdx }}" class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">Feature #{{ $fIdx + 1 }}</span>
                                    <button type="button" wire:click="removeFooterTopFeature({{ $fIdx }})" class="text-rose-500 hover:text-rose-600">
                                        <x-icon name="solid:trash-can" class="w-3 h-3" />
                                    </button>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-semibold text-slate-400 mb-0.5">Title</label>
                                    <input type="text" wire:model.live="footerTop.features.{{ $fIdx }}.title" class="w-full px-2 py-1 text-xs font-bold rounded bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-semibold text-slate-400 mb-0.5">Subtitle</label>
                                    <input type="text" wire:model.live="footerTop.features.{{ $fIdx }}.subtitle" class="w-full px-2 py-1 text-xs rounded bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-semibold text-slate-400 mb-0.5">Icon Name</label>
                                    <input type="text" wire:model.live="footerTop.features.{{ $fIdx }}.icon" placeholder="solid:bolt" class="w-full px-2 py-1 text-xs font-mono rounded bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Headline</label>
                        <input type="text" wire:model.live="footerTop.title" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Hotline Phone</label>
                        <input type="text" wire:model.live="footerTop.phone" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>
            @endif
        </div>

    @elseif ($activeFooterRow === 'row2')
        <!-- Row 2: Main Modular Footer Grid Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 2: Main Modular Footer Columns (1 to 4 Columns)</h3>
                    <p class="text-xs text-slate-500">Corporate bio, dynamic business unit menus, port workshop offices, and static links.</p>
                </div>
                @if (count($footerColumns) < 4)
                    <button type="button" wire:click="addFooterColumn"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5">
                        <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                        <span>Add Column</span>
                    </button>
                @endif
            </div>

            <x-smart-box-model wire:model="footerBoxModel" label="Main Footer Grid Layout & Box Model" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-smart-color-picker wire:model="footerBgColor" label="Main Footer Background" />
                <x-smart-color-picker wire:model="footerTextColor" label="Main Footer Text Color" :allowGradient="false" :allowGlass="false" />
            </div>

            <!-- Deep Column Content Editors -->
            <div class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Configured Columns &amp; Content ({{ count($footerColumns) }})</h4>
                <div class="space-y-4">
                    @foreach ($footerColumns as $cIdx => $col)
                        <div wire:key="footer-col-edit-{{ $cIdx }}" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-2">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 text-[9px] font-mono font-bold rounded bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">COL #{{ $cIdx + 1 }}</span>
                                    <input type="text" wire:model.live="footerColumns.{{ $cIdx }}.title" class="px-2 py-0.5 text-xs font-bold rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                                <div class="flex items-center gap-2">
                                    <select wire:model.live="footerColumns.{{ $cIdx }}.type" class="px-2 py-1 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                        <option value="company_info">🏢 Company Bio &amp; Logo</option>
                                        <option value="dynamic_menu">⚡ Dynamic Menu Links</option>
                                        <option value="contact_offices">📍 Port &amp; HQ Addresses</option>
                                        <option value="static_links">🔗 Static Custom Links</option>
                                        <option value="newsletter">📬 Newsletter Box</option>
                                    </select>
                                    <button type="button" wire:click="removeFooterColumn({{ $cIdx }})" class="p-1 rounded text-rose-500 hover:text-rose-600">
                                        <x-icon name="solid:trash-can" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </div>

                            <!-- Content specific to column type -->
                            @if (($col['type'] ?? '') === 'company_info')
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-semibold text-slate-500">Company Bio / Narrative</label>
                                    <textarea wire:model.live="footerColumns.{{ $cIdx }}.content.bio" rows="2" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                                    <div class="flex items-center gap-4 pt-1">
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                            <input type="checkbox" wire:model.live="footerColumns.{{ $cIdx }}.content.show_logo" class="rounded text-[#003C58]">
                                            <span>Show Logo</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                            <input type="checkbox" wire:model.live="footerColumns.{{ $cIdx }}.content.show_social" class="rounded text-[#003C58]">
                                            <span>Show Social Handles</span>
                                        </label>
                                    </div>
                                </div>

                            @elseif (($col['type'] ?? '') === 'dynamic_menu')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Target Menu</label>
                                        <select wire:model.live="footerColumns.{{ $cIdx }}.content.source" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                            <option value="divisions">Business Units / Divisions</option>
                                            <option value="services">Marine Technical Services</option>
                                            @foreach ($availableMenus as $m)
                                                <option value="menu_{{ $m->id }}">{{ $m->name }} ({{ $m->items_count }} items)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            @elseif (($col['type'] ?? '') === 'static_links')
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] font-semibold text-slate-500">Custom Navigation Links</span>
                                        <button type="button" wire:click="addStaticListItem({{ $cIdx }})" class="text-xs font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                            + Add Link
                                        </button>
                                    </div>
                                    <div class="space-y-2">
                                        @foreach ($col['content']['items'] ?? [] as $lkIdx => $lk)
                                            <div wire:key="col-{{ $cIdx }}-lk-{{ $lkIdx }}" class="flex items-center gap-2">
                                                <input type="text" wire:model.live="footerColumns.{{ $cIdx }}.content.items.{{ $lkIdx }}.label" placeholder="Link Label" class="flex-1 px-2.5 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                <input type="text" wire:model.live="footerColumns.{{ $cIdx }}.content.items.{{ $lkIdx }}.link.url" placeholder="/url" class="flex-1 px-2.5 py-1 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                                <button type="button" wire:click="removeStaticListItem({{ $cIdx }}, {{ $lkIdx }})" class="text-rose-500 hover:text-rose-600">
                                                    <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif (($col['type'] ?? '') === 'contact_offices')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Port Workshop</label>
                                        <input type="text" wire:model.live="footerColumns.{{ $cIdx }}.content.port_address" class="w-full px-2 py-1 text-xs rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Corporate HQ</label>
                                        <input type="text" wire:model.live="footerColumns.{{ $cIdx }}.content.hq_address" class="w-full px-2 py-1 text-xs rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif ($activeFooterRow === 'row3')
        <!-- Row 3: Sub-Footer Copyright Row Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 3: Bottom Sub-Footer Bar</h3>
                <p class="text-xs text-slate-500">Copyright information with dynamic year replacement, legal links, and back to top button.</p>
            </div>

            <x-smart-box-model wire:model="footerBottomBoxModel" label="Sub-Footer Layout & Box Model (Independent Row 3)" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-smart-color-picker wire:model="footerBottomBgColor" label="Sub-Footer Background" />
                <x-smart-color-picker wire:model="footerBottomTextColor" label="Sub-Footer Text Color" :allowGradient="false" :allowGlass="false" />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Copyright Template Text</label>
                <input type="text" wire:model="footerConfig.copyright_template" placeholder="© {year} {site_name}. All rights reserved." class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                <span class="block text-[11px] text-slate-400 mt-1">Tags supported: <code class="text-cyan-600 font-mono">{year}</code>, <code class="text-cyan-600 font-mono">{site_name}</code></span>
            </div>
        </div>
    @endif
</div>
