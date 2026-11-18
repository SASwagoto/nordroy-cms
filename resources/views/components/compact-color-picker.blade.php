@props([
    'placeholder' => '#003C58',
    'default' => '#003C58',
    'allowTransparent' => false,
    'presets' => [
        '#003C58', '#0ea5e9', '#06b6d4', '#10b981', '#f59e0b', '#ef4444',
        '#0f172a', '#1e293b', '#334155', '#64748b', '#cbd5e1', '#ffffff'
    ],
])

@php
    $wireModel = $attributes->wire('model')->value();
@endphp

<div class="relative inline-block" 
     x-data="{ 
        openColorPicker: false,
        colorVal: @if($wireModel) $wire.entangle('{{ $wireModel }}').live @else '{{ $default }}' @endif
     }">
    <button type="button" 
            @click="openColorPicker = !openColorPicker" 
            class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xs hover:border-[#003C58] dark:hover:border-cyan-500 transition-all cursor-pointer">
        <span class="w-4 h-4 rounded-md border border-slate-300 dark:border-slate-600 shadow-2xs shrink-0"
              :class="colorVal === 'transparent' ? 'bg-[repeating-linear-gradient(45deg,#cbd5e1,#cbd5e1_2px,#ffffff_2px,#ffffff_4px)]' : ''"
              :style="colorVal !== 'transparent' ? 'background-color: ' + (colorVal || '{{ $default }}') : ''"></span>
        <span class="text-[11px] font-mono font-bold uppercase text-slate-800 dark:text-slate-200"
              x-text="colorVal === 'transparent' ? 'None' : (colorVal || '{{ $placeholder }}')"></span>
        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>

    <!-- Color Swatch Popover -->
    <div x-show="openColorPicker" 
         @click.outside="openColorPicker = false"
         x-transition
         style="display: none;"
         class="absolute z-50 mt-1.5 right-0 sm:left-0 sm:right-auto w-64 p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-2xl space-y-3">
        <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
            <span class="text-[11px] font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">Color Swatches</span>
            @if($allowTransparent)
                <button type="button" 
                        @click="colorVal = 'transparent'; openColorPicker = false" 
                        class="text-[10px] font-bold px-2 py-0.5 rounded bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/60 transition-colors cursor-pointer">
                    Clear (None)
                </button>
            @else
                <button type="button" 
                        @click="colorVal = '{{ $default }}'; openColorPicker = false" 
                        class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                    Reset
                </button>
            @endif
        </div>

        <!-- Presets -->
        <div>
            <span class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase">Presets</span>
            <div class="grid grid-cols-6 gap-1.5">
                @foreach($presets as $c)
                    <button type="button" 
                            @click="colorVal = '{{ $c }}'; openColorPicker = false" 
                            style="background-color: {{ $c }};"
                            class="w-7 h-7 rounded-lg border border-slate-300 dark:border-slate-700 shadow-2xs hover:scale-110 active:scale-95 transition-transform cursor-pointer relative"
                            title="{{ $c }}">
                        <span x-show="colorVal && colorVal.toLowerCase() === '{{ strtolower($c) }}'" class="absolute inset-0 flex items-center justify-center text-white text-[10px] font-bold drop-shadow">✓</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Direct Hex & Native Color Eye-dropper -->
        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <label class="relative w-8 h-8 rounded-lg border border-slate-300 dark:border-slate-600 overflow-hidden cursor-pointer shrink-0 shadow-2xs" title="Open Custom Color Picker">
                <input type="color" 
                       x-model="colorVal" 
                       class="absolute -inset-2 w-12 h-12 opacity-0 cursor-pointer">
                <span class="block w-full h-full" 
                      :style="'background-color: ' + (colorVal || '{{ $default }}')"></span>
            </label>
            <input type="text" 
                   x-model="colorVal" 
                   placeholder="{{ $placeholder }}"
                   class="flex-1 px-2.5 py-1 text-xs font-mono font-bold uppercase rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#003C58]">
        </div>
    </div>
</div>
