<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <x-icon name="solid:table-cells" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Corporate Footer Studio</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Controls corporate summary bio, 4 column headings, physical workshop/HQ addresses, certifications, and copyright notices.</p>
        </div>
        <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
            <input type="checkbox" wire:model.live="footer_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Footer</span>
        </label>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ $footer_enabled ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- 1. Footer Branding & Logo Controls -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:photo-film" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Footer Logo &amp; Branding Display</span>
                </div>
                <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-800 dark:text-slate-200 cursor-pointer">
                    <input type="checkbox" wire:model.live="footer_show_logo" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                    <span>Show Logo in Footer</span>
                </label>
            </div>

            @if($footer_show_logo)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Logo Source</label>
                    <select wire:model.live="footer_logo_type"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="site_logo">Primary Corporate Site Logo (Default)</option>
                        <option value="custom_logo">Custom Footer Logo Asset Path</option>
                    </select>
                </div>

                @if($footer_logo_type === 'custom_logo')
                <div class="space-y-1.5">
                    <x-homepage-builder.media-picker 
                        model="footer_custom_logo" 
                        :value="$footer_custom_logo" 
                        label="Custom Footer Logo Asset" />
                </div>
                @endif

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Logo Height</label>
                        <span class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400">{{ $footer_logo_height }}px</span>
                    </div>
                    <input type="range" wire:model.live="footer_logo_height" min="24" max="96" step="2" class="w-full cursor-pointer accent-[#003C58] dark:accent-cyan-400">
                </div>
            </div>
            @endif
        </div>

        <!-- 2. Four Column Visibility Toggles -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800">
                <x-icon name="solid:table-columns" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Footer Columns Grid Visibility</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <label class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between cursor-pointer">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Col 1: Profile</span>
                    <input type="checkbox" wire:model.live="footer_col1_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                </label>
                <label class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between cursor-pointer">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Col 2: Navigation</span>
                    <input type="checkbox" wire:model.live="footer_col2_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                </label>
                <label class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between cursor-pointer">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Col 3: Services</span>
                    <input type="checkbox" wire:model.live="footer_col3_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                </label>
                <label class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between cursor-pointer">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Col 4: Offices</span>
                    <input type="checkbox" wire:model.live="footer_col4_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                </label>
            </div>
        </div>

        <!-- 3. Column 1: Corporate Bio & Quality Certifications -->
        @if($footer_col1_enabled)
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:building" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Column 1: Corporate Profile &amp; Bio</span>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Corporate Overview Summary</label>
                <textarea wire:model="footer_bio" rows="3"
                          class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Quality Certification Badge</label>
                    <input type="text" wire:model="footer_cert_text" placeholder="ISO 9001:2015 & DNV Certified"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div>
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Social Media Links</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400">Display company social icons from Global Settings</span>
                    </div>
                    <input type="checkbox" wire:model.live="footer_show_social" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                </div>
            </div>
        </div>
        @endif

        <!-- 4. Column 2: Spare Parts / Dynamic Menu Studio -->
        @if($footer_col2_enabled)
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:list" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Column 2: Navigation Links</span>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Mode:</label>
                    <select wire:model.live="footer_col2_mode" class="px-2.5 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-semibold">
                        <option value="custom">Custom Editable Links</option>
                        <option value="menu">Dynamic CMS Menu Sync</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Column 2 Heading</label>
                <input type="text" wire:model="footer_col2_title" placeholder="OEM Spare Parts"
                       class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
            </div>

            @if($footer_col2_mode === 'menu')
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Select CMS Navigation Menu</label>
                <select wire:model="footer_col2_menu_id"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                    <option value="">-- Choose Dynamic Menu --</option>
                    @foreach($availableMenus as $m)
                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->location ?: 'Unassigned' }})</option>
                    @endforeach
                </select>
            </div>
            @else
            <!-- Custom Links Repeater for Col 2 -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Custom Links ({{ count($footer_col2_links) }})</span>
                    <button type="button" wire:click="addFooterCol2Link"
                            class="px-2 py-0.5 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 cursor-pointer flex items-center gap-1">
                        <x-icon name="solid:plus" class="w-3 h-3" />
                        <span>Add Link</span>
                    </button>
                </div>

                <div class="space-y-2">
                    @foreach($footer_col2_links as $lIdx => $lItem)
                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <input type="text" wire:model="footer_col2_links.{{ $lIdx }}.text" placeholder="Link Label"
                                   class="flex-1 px-2.5 py-1 text-xs rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-medium">
                            <button type="button" wire:click="removeFooterCol2Link({{ $lIdx }})"
                                    class="w-6 h-6 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove Link">
                                <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                        <x-homepage-builder.link-picker 
                            model="footer_col2_links.{{ $lIdx }}.url" 
                            :options="$internalLinkOptions" />
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- 5. Column 3: Technical Services / Dynamic Menu Studio -->
        @if($footer_col3_enabled)
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:list" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Column 3: Navigation Links</span>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Mode:</label>
                    <select wire:model.live="footer_col3_mode" class="px-2.5 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-semibold">
                        <option value="custom">Custom Editable Links</option>
                        <option value="menu">Dynamic CMS Menu Sync</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Column 3 Heading</label>
                <input type="text" wire:model="footer_col3_title" placeholder="Technical Services"
                       class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
            </div>

            @if($footer_col3_mode === 'menu')
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Select CMS Navigation Menu</label>
                <select wire:model="footer_col3_menu_id"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                    <option value="">-- Choose Dynamic Menu --</option>
                    @foreach($availableMenus as $m)
                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->location ?: 'Unassigned' }})</option>
                    @endforeach
                </select>
            </div>
            @else
            <!-- Custom Links Repeater for Col 3 -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Custom Links ({{ count($footer_col3_links) }})</span>
                    <button type="button" wire:click="addFooterCol3Link"
                            class="px-2 py-0.5 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 cursor-pointer flex items-center gap-1">
                        <x-icon name="solid:plus" class="w-3 h-3" />
                        <span>Add Link</span>
                    </button>
                </div>

                <div class="space-y-2">
                    @foreach($footer_col3_links as $lIdx => $lItem)
                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <input type="text" wire:model="footer_col3_links.{{ $lIdx }}.text" placeholder="Link Label"
                                   class="flex-1 px-2.5 py-1 text-xs rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-medium">
                            <button type="button" wire:click="removeFooterCol3Link({{ $lIdx }})"
                                    class="w-6 h-6 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove Link">
                                <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                        <x-homepage-builder.link-picker 
                            model="footer_col3_links.{{ $lIdx }}.url" 
                            :options="$internalLinkOptions" />
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- 6. Column 4: Physical Offices & Emergency Hotline -->
        @if($footer_col4_enabled)
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:location-dot" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Column 4: Physical Locations &amp; Contacts</span>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Column 4 Heading</label>
                <input type="text" wire:model="footer_col4_title" placeholder="Port & HQ Offices"
                       class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-slate-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Chattogram Port Workshop Address</label>
                    <input type="text" wire:model="footer_workshop_addr" placeholder="Near Marine Academy Jetty, Chattogram Port..."
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Dhaka Corporate HQ Address</label>
                    <input type="text" wire:model="footer_hq_addr" placeholder="Gulshan Industrial Area, Dhaka..."
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Emergency 24/7 Telephone</label>
                        <label class="inline-flex items-center gap-1.5 text-[10px] text-slate-500 cursor-pointer">
                            <input type="checkbox" wire:model.live="footer_show_phone" class="w-3.5 h-3.5 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                            <span>Show Phone</span>
                        </label>
                    </div>
                    <input type="text" wire:model="footer_phone" placeholder="+880 1800-000000"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono font-bold text-[#003C58] dark:text-cyan-400">
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Operations Email</label>
                        <label class="inline-flex items-center gap-1.5 text-[10px] text-slate-500 cursor-pointer">
                            <input type="checkbox" wire:model.live="footer_show_email" class="w-3.5 h-3.5 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                            <span>Show Email</span>
                        </label>
                    </div>
                    <input type="text" wire:model="footer_email" placeholder="operations@nordroy.com"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white">
                </div>
            </div>
        </div>
        @endif

        <!-- 7. Copyright Strip & Staff Login -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:copyright" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Bottom Copyright Strip</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Copyright Line</label>
                    <input type="text" wire:model="footer_copyright" placeholder="© 2026 Nordroy Marine & Turbochargers. All rights reserved."
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <div>
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Staff Login Link</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400">Show link to admin login in footer</span>
                    </div>
                    <input type="checkbox" wire:model.live="footer_show_login" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly across the platform footer.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="restoreProductionDesign" wire:confirm="Restore real production design defaults?"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 transition-colors cursor-pointer">
                <x-icon name="solid:rotate-left" class="w-3.5 h-3.5" />
                <span>Restore Real Design</span>
            </button>
            <button type="button" wire:click="saveFooter" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Footer Changes</span>
            </button>
        </div>
    </div>
</div>
