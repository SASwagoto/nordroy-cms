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
        <!-- Row 1: Pre-Footer Callout Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 1: Pre-Footer Urgent Callout Strip</h3>
                    <p class="text-xs text-slate-500">Full-width call to action, 24/7 hotline numbers, and emergency booking.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Enable Pre-Footer</span>
                    <input type="checkbox" wire:model="footerTop.enabled" class="rounded border-slate-300 text-[#003C58] focus:ring-[#003C58] h-4 w-4">
                </div>
            </div>

            @if ($footerTop['enabled'] ?? true)
                <x-smart-box-model wire:model="footerTop.box_model" label="Pre-Footer Layout & Box Model (Independent Row 1)" />

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Headline</label>
                        <input type="text" wire:model="footerTop.title" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Hotline Phone</label>
                        <input type="text" wire:model="footerTop.phone" class="w-full px-3 py-1.5 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>
            @endif
        </div>

    @elseif ($activeFooterRow === 'row2')
        <!-- Row 2: Main Modular Footer Grid Config -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Row 2: Main Modular Footer Columns</h3>
                    <p class="text-xs text-slate-500">Corporate bio, dynamic business unit menus, port workshop offices, and certifications.</p>
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

            <!-- Columns Repeater -->
            <div class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Configured Columns ({{ count($footerColumns) }})</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach ($footerColumns as $cIdx => $col)
                        <div wire:key="footer-col-{{ $cIdx }}" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Col #{{ $cIdx + 1 }}</span>
                                <button type="button" wire:click="removeFooterColumn({{ $cIdx }})" class="text-xs text-rose-500 hover:text-rose-600">
                                    <x-icon name="solid:trash-can" class="w-3 h-3" />
                                </button>
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Column Title</label>
                                <input type="text" wire:model="footerColumns.{{ $cIdx }}.title" class="w-full px-2 py-1 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Type</label>
                                <select wire:model="footerColumns.{{ $cIdx }}.type" class="w-full px-2 py-1 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="company_info">Company Bio &amp; Logo</option>
                                    <option value="dynamic_menu">Dynamic Menu Links</option>
                                    <option value="contact_offices">Port &amp; HQ Addresses</option>
                                    <option value="static_links">Custom Links</option>
                                </select>
                            </div>
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
