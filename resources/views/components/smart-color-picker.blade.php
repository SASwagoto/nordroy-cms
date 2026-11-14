@props([
    'label' => 'Color Configuration',
    'help' => null,
    'defaultLight' => '#ffffff',
    'defaultDark' => '#07131e',
])

@php
    $wireModel = $attributes->wire('model')->value();
    $currentVal = ($wireModel && isset($this)) ? data_get($this, $wireModel) : null;
    $initMode = (is_array($currentVal) && ($currentVal['mode'] ?? '') === 'custom') ? 'custom' : 'theme';
    $initLight = (is_array($currentVal) && !empty($currentVal['light'])) ? $currentVal['light'] : $defaultLight;
    $initDark = (is_array($currentVal) && !empty($currentVal['dark'])) ? $currentVal['dark'] : $defaultDark;
    $initOpacity = (is_array($currentVal) && isset($currentVal['opacity'])) ? (int) $currentVal['opacity'] : 100;
@endphp

<div x-data="{
        mode: '{{ $initMode }}',
        light: '{{ $initLight }}',
        dark: '{{ $initDark }}',
        opacity: {{ $initOpacity }},
        setMode(newMode) {
            this.mode = newMode;
            this.sync();
        },
        sync() {
            const payload = {
                mode: this.mode,
                light: this.light,
                dark: this.dark,
                opacity: parseInt(this.opacity) || 100
            };
            if ('{{ $wireModel }}' && $wire) {
                $wire.set('{{ $wireModel }}', payload);
            }
            window.dispatchEvent(new CustomEvent('smart-color-changed', {
                detail: { model: '{{ $wireModel }}', color: payload }
            }));
            if (this.$dispatch) {
                this.$dispatch('smart-color-changed', { model: '{{ $wireModel }}', color: payload });
            }
        }
     }"
     class="w-full space-y-3">
    
    <div class="flex items-center justify-between">
        <div>
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $label }}</label>
            @if($help)
                <p class="text-[11px] text-slate-400 mt-0.5">{{ $help }}</p>
            @endif
        </div>

        <!-- Mode Indicator Badge -->
        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full"
              :class="mode === 'custom' ? 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700'"
              x-text="mode === 'custom' ? 'Custom Dual Mode' : 'Theme Default'">
        </span>
    </div>

    <!-- Mode Selector Pills -->
    <div class="flex items-center gap-1.5 p-1 rounded-xl bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold">
        <button type="button" 
                @click="setMode('theme')"
                class="flex-1 py-2 px-3 rounded-lg transition-all text-center cursor-pointer"
                :class="mode === 'theme' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs ring-1 ring-slate-200 dark:ring-slate-700' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white'">
            <span class="inline-flex items-center justify-center gap-1.5">
                <x-icon name="solid:palette" class="w-3.5 h-3.5" />
                <span>Theme Default</span>
            </span>
        </button>

        <button type="button" 
                @click="setMode('custom')"
                class="flex-1 py-2 px-3 rounded-lg transition-all text-center cursor-pointer"
                :class="mode === 'custom' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs ring-1 ring-slate-200 dark:ring-slate-700' : 'text-slate-500 hover:text-slate-800 dark:hover:text-white'">
            <span class="inline-flex items-center justify-center gap-1.5">
                <x-icon name="solid:sliders" class="w-3.5 h-3.5" />
                <span>Custom Light &amp; Dark</span>
            </span>
        </button>
    </div>

    <!-- Theme Default Explanation -->
    <div x-show="mode === 'theme'" 
         class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-dashed border-slate-200 dark:border-slate-800 text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-2">
        <x-icon name="solid:circle-info" class="w-4 h-4 text-cyan-600 dark:text-cyan-400 shrink-0" />
        <span>Uses global design system styling &amp; glassmorphism tokens automatically.</span>
    </div>

    <!-- Custom Light & Dark Mode Color Pickers -->
    <div x-show="mode === 'custom'" 
         x-transition
         class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            <!-- Light Mode Color -->
            <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                        <span>☀️</span>
                        <span>Light Mode</span>
                    </span>
                    <span class="w-4 h-4 rounded-full border border-slate-300 dark:border-slate-700 shadow-2xs" :style="'background-color: ' + light"></span>
                </div>

                <div class="flex items-center gap-2">
                    <input type="color" 
                           x-model="light" 
                           @input="sync()"
                           class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer bg-transparent p-0.5 shrink-0" />
                    <input type="text" 
                           x-model="light" 
                           @input.debounce.250ms="sync()"
                           placeholder="#ffffff" 
                           class="w-full px-2.5 py-1.5 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white uppercase focus:outline-none focus:ring-1 focus:ring-[#003C58]" />
                </div>
            </div>

            <!-- Dark Mode Color -->
            <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                        <span>🌙</span>
                        <span>Dark Mode</span>
                    </span>
                    <span class="w-4 h-4 rounded-full border border-slate-300 dark:border-slate-700 shadow-2xs" :style="'background-color: ' + dark"></span>
                </div>

                <div class="flex items-center gap-2">
                    <input type="color" 
                           x-model="dark" 
                           @input="sync()"
                           class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer bg-transparent p-0.5 shrink-0" />
                    <input type="text" 
                           x-model="dark" 
                           @input.debounce.250ms="sync()"
                           placeholder="#07131e" 
                           class="w-full px-2.5 py-1.5 text-xs font-mono rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white uppercase focus:outline-none focus:ring-1 focus:ring-[#003C58]" />
                </div>
            </div>

        </div>

        <!-- Opacity Slider -->
        <div class="space-y-1.5 pt-2 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between text-xs">
                <span class="text-slate-600 dark:text-slate-400 font-medium">Background Opacity</span>
                <span class="font-mono font-bold text-slate-800 dark:text-white" x-text="opacity + '%'"></span>
            </div>
            <input type="range" min="10" max="100" step="5"
                   x-model="opacity" 
                   @input="sync()"
                   class="w-full accent-[#003C58] dark:accent-cyan-400 cursor-pointer" />
        </div>

        <!-- Dual Swatch Preview Bar -->
        <div class="pt-2 flex items-center justify-between gap-3 text-[11px]">
            <span class="text-slate-400">Preview:</span>
            <div class="flex items-center rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-2xs h-7 flex-1 max-w-xs">
                <div class="flex-1 h-full flex items-center justify-center text-[10px] font-bold text-slate-800"
                     :style="'background-color: ' + light + '; opacity: ' + (opacity / 100)">
                    Light
                </div>
                <div class="flex-1 h-full flex items-center justify-center text-[10px] font-bold text-white"
                     :style="'background-color: ' + dark + '; opacity: ' + (opacity / 100)">
                    Dark
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    if (typeof window.nordroyHexToRgba !== 'function') {
        window.nordroyHexToRgba = function(hex, opacity = 1) {
            if (!hex) return 'transparent';
            hex = String(hex).replace('#', '').trim();
            if (hex.length === 3) {
                hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
            }
            if (hex.length !== 6) {
                return `rgba(255, 255, 255, ${opacity})`;
            }
            const r = parseInt(hex.substring(0, 2), 16) || 0;
            const g = parseInt(hex.substring(2, 4), 16) || 0;
            const b = parseInt(hex.substring(4, 6), 16) || 0;
            return `rgba(${r}, ${g}, ${b}, ${opacity})`;
        };
    }
</script>
