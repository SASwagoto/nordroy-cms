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

<div wire:ignore.self
     x-data="{
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
     class="w-full py-1.5 px-3 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 transition-colors">
    
    <div class="flex flex-wrap items-center justify-between gap-2">
        <!-- Label on Left -->
        <div class="min-w-0 pr-2">
            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200 truncate">{{ $label }}</span>
            @if($help)
                <span class="text-[10px] text-slate-400 block truncate">{{ $help }}</span>
            @endif
        </div>

        <!-- Mode Toggle & Inline Color Swatches on Right -->
        <div class="flex items-center gap-2 shrink-0">
            <!-- Mode Selector (Theme / Custom) -->
            <div class="inline-flex items-center p-0.5 rounded-lg bg-slate-200/80 dark:bg-slate-900 border border-slate-300 dark:border-slate-800 text-[10px] font-bold">
                <button type="button" 
                        @click="setMode('theme')"
                        class="px-2 py-0.5 rounded-md transition-all cursor-pointer"
                        :class="mode === 'theme' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs font-extrabold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                    Theme Default
                </button>
                <button type="button" 
                        @click="setMode('custom')"
                        title="Custom Dual Mode"
                        class="px-2 py-0.5 rounded-md transition-all cursor-pointer"
                        :class="mode === 'custom' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs font-extrabold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                    Custom Dual
                </button>
            </div>

            <!-- When Custom: Inline Light & Dark Color Inputs + Opacity -->
            <template x-if="mode === 'custom'">
                <div class="flex items-center gap-1.5 pl-1.5 border-l border-slate-200 dark:border-slate-800 text-[11px]">
                    <!-- Light Mode Swatch -->
                    <div class="flex items-center gap-1 bg-white dark:bg-slate-900 px-1.5 py-0.5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-2xs" title="Light Mode Color">
                        <span class="text-[10px]">☀️</span>
                        <input type="color" 
                               x-model="light" 
                               @input="sync()"
                               class="w-5 h-5 rounded-md border-0 cursor-pointer bg-transparent p-0 shrink-0" />
                        <input type="text" 
                               x-model="light" 
                               @input.debounce.250ms="sync()"
                               class="w-14 px-1 py-0 text-[10px] font-mono font-bold bg-transparent border-0 text-slate-800 dark:text-slate-200 uppercase focus:ring-0" />
                    </div>

                    <!-- Dark Mode Swatch -->
                    <div class="flex items-center gap-1 bg-white dark:bg-slate-900 px-1.5 py-0.5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-2xs" title="Dark Mode Color">
                        <span class="text-[10px]">🌙</span>
                        <input type="color" 
                               x-model="dark" 
                               @input="sync()"
                               class="w-5 h-5 rounded-md border-0 cursor-pointer bg-transparent p-0 shrink-0" />
                        <input type="text" 
                               x-model="dark" 
                               @input.debounce.250ms="sync()"
                               class="w-14 px-1 py-0 text-[10px] font-mono font-bold bg-transparent border-0 text-slate-800 dark:text-slate-200 uppercase focus:ring-0" />
                    </div>

                    <!-- Opacity -->
                    <div class="flex items-center gap-1 bg-white dark:bg-slate-900 px-1.5 py-0.5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-2xs" title="Opacity Percentage">
                        <span class="text-[9px] font-bold text-slate-400">Op:</span>
                        <input type="number" min="10" max="100" step="5"
                               x-model="opacity" 
                               @input.debounce.250ms="sync()"
                               class="w-10 px-0.5 py-0 text-[10px] font-mono font-bold bg-transparent border-0 text-slate-800 dark:text-slate-200 text-center focus:ring-0" />
                        <span class="text-[9px] font-bold text-slate-400">%</span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
