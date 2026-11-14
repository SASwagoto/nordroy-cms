@props([
    'title' => 'Common Section Layout & Geometry',
])

@php
    $wireModel = $attributes->wire('model')->value();
@endphp

<div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5"
     x-data="{ isOpen: false }">
    
    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
        <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white flex items-center gap-2">
                <x-icon name="solid:ruler-combined" class="w-3.5 h-3.5 text-cyan-600 dark:text-cyan-400" />
                <span>{{ $title }}</span>
            </h4>
            <p class="text-[11px] text-slate-400 mt-0.5">Control container width, vertical padding, margin, borders, shadows &amp; background color.</p>
        </div>

        <button type="button" @click="isOpen = !isOpen"
                class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors inline-flex items-center gap-1 cursor-pointer">
            <span x-text="isOpen ? 'Collapse' : 'Customize'"></span>
            <x-icon name="solid:chevron-down" class="w-3 h-3 transition-transform duration-200" ::class="isOpen ? 'rotate-180' : ''" />
        </button>
    </div>

    <div x-show="isOpen" x-collapse class="space-y-4 pt-1">
        
        <!-- Row 1: Width & Padding -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Container Max Width</label>
                <select wire:model.live="{{ $wireModel }}.container_width"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    <option value="default">Theme Default (var(--container-width))</option>
                    <option value="1280px">Boxed Standard (1280px)</option>
                    <option value="1440px">Corporate Wide (1440px)</option>
                    <option value="1536px">Ultra Wide (1536px - Recommended)</option>
                    <option value="1680px">Panoramic Studio (1680px)</option>
                    <option value="100%">100% Fluid Full Width</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Section Vertical Padding (py)</label>
                <select wire:model.live="{{ $wireModel }}.padding_y"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    <option value="default">Theme Default (var(--section-padding))</option>
                    <option value="none">Zero Padding (py-0)</option>
                    <option value="compact">Compact (py-12)</option>
                    <option value="normal">Standard Corporate (py-20 - Recommended)</option>
                    <option value="generous">Generous Premium (py-28)</option>
                    <option value="grand">Grand Spacious (py-36)</option>
                </select>
            </div>
        </div>

        <!-- Row 2: Margin & Borders -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Vertical Margin (my)</label>
                <select wire:model.live="{{ $wireModel }}.margin_y"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    <option value="none">None (0px)</option>
                    <option value="small">Small Spacing (my-6)</option>
                    <option value="medium">Medium Spacing (my-12)</option>
                    <option value="large">Large Separation (my-20)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Section Borders</label>
                <select wire:model.live="{{ $wireModel }}.border"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    <option value="none">Clean Borderless</option>
                    <option value="subtle">Subtle Line Top &amp; Bottom</option>
                    <option value="accent_top">Brand Accent Bar on Top</option>
                    <option value="full">Boxed Card Border (All sides)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Surface Shadow</label>
                <select wire:model.live="{{ $wireModel }}.shadow"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    <option value="none">Flat (No Shadow)</option>
                    <option value="shadow-sm">Soft Elevation (shadow-sm)</option>
                    <option value="shadow-md">Medium Elevation (shadow-md)</option>
                    <option value="shadow-lg">Elevated Floating (shadow-xl)</option>
                    <option value="glow">Subtle Brand Glow</option>
                </select>
            </div>
        </div>

        <!-- Row 3: Section Background Color with Dual Light & Dark Mode Engine -->
        <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
            <x-smart-color-picker wire:model="{{ $wireModel }}.bg_color" 
                                  label="Section Background Color (Light &amp; Dark Mode Engine)"
                                  help="Select Theme Default or assign dedicated custom colors for Light and Dark modes." />
        </div>

    </div>

</div>
