@props(['prefix' => ''])

@php
    $currentStyler = $sectionStylers[$prefix] ?? [
        'bg_type' => 'theme_default',
        'bg_light' => '#ffffff',
        'bg_dark' => '#0b1b2b',
        'gradient_dir' => '135deg',
        'gradient_from' => '#002538',
        'gradient_to' => '#07131e',
        'glass_opacity' => 90,
        'align' => 'left',
        'width' => 'container',
        'padding' => 'standard',
    ];
@endphp

<div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
    <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <x-icon name="solid:swatchbook" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
            <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Section Background, Alignment &amp; Geometry</span>
        </div>
        <span class="text-[10px] text-cyan-600 dark:text-cyan-400 font-mono font-bold uppercase">Universal Styler</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Background Style -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Background Material</label>
            <select wire:model.live="sectionStylers.{{ $prefix }}.bg_type"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20">
                <option value="theme_default">Theme Default (Adaptive Contrast)</option>
                <option value="clean_white">Pure Contrast (Clean White / Dark 950)</option>
                <option value="solid_custom">Solid Custom Colors (Light &amp; Dark)</option>
                <option value="gradient">Multi-Color Directional Gradient</option>
                <option value="glass">Glassmorphism Frosted Backdrop</option>
                <option value="transparent">Transparent / Seamless</option>
            </select>
        </div>

        <!-- 2. Content Alignment -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Content Alignment</label>
            <div class="grid grid-cols-3 gap-1 bg-white dark:bg-slate-900 p-1 rounded-xl border border-slate-200 dark:border-slate-800 h-[38px]">
                <button type="button" wire:click="$set('sectionStylers.{{ $prefix }}.align', 'left')"
                        class="flex items-center justify-center rounded-lg text-xs font-bold transition-all cursor-pointer {{ ($currentStyler['align'] ?? 'left') === 'left' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}"
                        title="Align Left">
                    <x-icon name="solid:bars-3-bottom-left" class="w-3.5 h-3.5" />
                </button>
                <button type="button" wire:click="$set('sectionStylers.{{ $prefix }}.align', 'center')"
                        class="flex items-center justify-center rounded-lg text-xs font-bold transition-all cursor-pointer {{ ($currentStyler['align'] ?? 'left') === 'center' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}"
                        title="Align Center">
                    <x-icon name="solid:bars-3" class="w-3.5 h-3.5" />
                </button>
                <button type="button" wire:click="$set('sectionStylers.{{ $prefix }}.align', 'right')"
                        class="flex items-center justify-center rounded-lg text-xs font-bold transition-all cursor-pointer {{ ($currentStyler['align'] ?? 'left') === 'right' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}"
                        title="Align Right">
                    <x-icon name="solid:bars-3-bottom-right" class="w-3.5 h-3.5" />
                </button>
            </div>
        </div>

        <!-- 3. Width Container -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Container Width</label>
            <select wire:model.live="sectionStylers.{{ $prefix }}.width"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20">
                <option value="container">Boxed Container (Max 1536px - Recommended)</option>
                <option value="fluid">Full Fluid Width (Edge to Edge)</option>
                <option value="narrow">Narrow Focus Container (Max 1152px)</option>
            </select>
        </div>

        <!-- 4. Vertical Padding -->
        <div class="space-y-1.5">
            <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Vertical Spacing (Padding)</label>
            <select wire:model.live="sectionStylers.{{ $prefix }}.padding"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-cyan-500/20">
                <option value="compact">Compact (py-12 sm:py-16)</option>
                <option value="standard">Standard Corporate (py-16 sm:py-24 - Default)</option>
                <option value="spacious">Spacious Luxury (py-24 sm:py-32)</option>
            </select>
        </div>
    </div>

    <!-- Conditional Settings: Solid Custom Colors -->
    @if(($currentStyler['bg_type'] ?? '') === 'solid_custom')
    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="flex items-center gap-3">
            <input type="color" wire:model.live="sectionStylers.{{ $prefix }}.bg_light" class="w-8 h-8 rounded border-0 cursor-pointer">
            <div class="space-y-0.5">
                <label class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Light Mode Background</label>
                <input type="text" wire:model="sectionStylers.{{ $prefix }}.bg_light" class="px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono w-28 text-slate-800 dark:text-slate-200">
            </div>
        </div>
        <div class="flex items-center gap-3">
            <input type="color" wire:model.live="sectionStylers.{{ $prefix }}.bg_dark" class="w-8 h-8 rounded border-0 cursor-pointer">
            <div class="space-y-0.5">
                <label class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Dark Mode Background</label>
                <input type="text" wire:model="sectionStylers.{{ $prefix }}.bg_dark" class="px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono w-28 text-slate-800 dark:text-slate-200">
            </div>
        </div>
    </div>
    @endif

    <!-- Conditional Settings: Multi-Color Gradient -->
    @if(($currentStyler['bg_type'] ?? '') === 'gradient')
    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="space-y-1">
            <label class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Gradient Angle / Direction</label>
            <select wire:model.live="sectionStylers.{{ $prefix }}.gradient_dir"
                    class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200">
                <option value="to right">To Right &rarr;</option>
                <option value="to left">&larr; To Left</option>
                <option value="to bottom">&darr; To Bottom</option>
                <option value="135deg">135&deg; Diagonal</option>
                <option value="45deg">45&deg; Angle</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <input type="color" wire:model.live="sectionStylers.{{ $prefix }}.gradient_from" class="w-7 h-7 rounded border-0 cursor-pointer">
            <div class="space-y-0.5 flex-1">
                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">From Color</label>
                <input type="text" wire:model="sectionStylers.{{ $prefix }}.gradient_from" class="w-full px-2 py-0.5 text-xs rounded-md bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-800 dark:text-slate-200">
            </div>
        </div>
        <div class="flex items-center gap-2">
            <input type="color" wire:model.live="sectionStylers.{{ $prefix }}.gradient_to" class="w-7 h-7 rounded border-0 cursor-pointer">
            <div class="space-y-0.5 flex-1">
                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">To Color</label>
                <input type="text" wire:model="sectionStylers.{{ $prefix }}.gradient_to" class="w-full px-2 py-0.5 text-xs rounded-md bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono text-slate-800 dark:text-slate-200">
            </div>
        </div>
    </div>
    @endif

    <!-- Conditional Settings: Glass Opacity -->
    @if(($currentStyler['bg_type'] ?? '') === 'glass')
    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between gap-4">
        <div class="space-y-0.5">
            <label class="text-xs font-bold text-slate-800 dark:text-slate-200">Glass Transparency Opacity</label>
            <p class="text-[10px] text-slate-500 dark:text-slate-400">Clamped between 10% and 90% to maintain pristine typography readability.</p>
        </div>
        <div class="flex items-center gap-3">
            <input type="range" wire:model.live="sectionStylers.{{ $prefix }}.glass_opacity" min="10" max="90" step="5" class="w-36 accent-cyan-500">
            <span class="text-xs font-mono font-bold text-cyan-600 dark:text-cyan-400 w-10 text-right">{{ $currentStyler['glass_opacity'] ?? 90 }}%</span>
        </div>
    </div>
    @endif
</div>
