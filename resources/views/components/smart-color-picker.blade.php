@props([
    'label' => 'Color Configuration',
    'help' => null,
    'defaultLight' => '#ffffff',
    'defaultDark' => '#07131e',
    'allowGradient' => true,
    'allowGlass' => true,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $currentVal = ($wireModel && isset($this)) ? data_get($this, $wireModel) : null;
    $norm = \App\Services\SmartColorHelper::normalize($currentVal, $defaultLight, $defaultDark);

    $initMode     = $norm['mode'];
    $initType     = $norm['type'];
    if (!$allowGlass && $initType === 'glass') {
        $initType = 'solid';
    }
    if (!$allowGradient && $initType === 'gradient') {
        $initType = 'solid';
    }

    $initLight    = $norm['light'];
    $initDark     = $norm['dark'];
    $initOpacity  = $norm['opacity'];
    $initGradDir  = $norm['gradient']['direction'];
    $initGradLFrom = $norm['gradient']['light_from'];
    $initGradLTo   = $norm['gradient']['light_to'];
    $initGradDFrom = $norm['gradient']['dark_from'];
    $initGradDTo   = $norm['gradient']['dark_to'];
    $initGlassBlur = $norm['glass']['blur'];
    $initGlassOp   = $norm['glass']['opacity'];
    $initGlassBorder = $norm['glass']['border'] ? 'true' : 'false';
@endphp

<div wire:ignore.self
     x-data="{
        mode: '{{ $initMode }}',
        type: '{{ $initType }}',
        light: '{{ $initLight }}',
        dark: '{{ $initDark }}',
        opacity: {{ $initOpacity }},
        gradDir: '{{ $initGradDir }}',
        gradLFrom: '{{ $initGradLFrom }}',
        gradLTo: '{{ $initGradLTo }}',
        gradDFrom: '{{ $initGradDFrom }}',
        gradDTo: '{{ $initGradDTo }}',
        glassBlur: '{{ $initGlassBlur }}',
        glassOp: {{ $initGlassOp }},
        glassBorder: {{ $initGlassBorder }},

        setMode(newMode) {
            this.mode = newMode;
            this.sync();
        },

        setType(newType) {
            this.type = newType;
            this.sync();
        },

        applyLightColor(val) {
            this.light = val;
            this.gradLFrom = val;
            this.sync();
        },

        applyDarkColor(val) {
            this.dark = val;
            this.gradDFrom = val;
            this.sync();
        },

        sync() {
            const payload = {
                mode: this.mode,
                type: this.type,
                light: this.light,
                dark: this.dark,
                opacity: parseInt(this.opacity) || 100,
                gradient: {
                    direction: this.gradDir,
                    light_from: this.gradLFrom,
                    light_to: this.gradLTo,
                    dark_from: this.gradDFrom,
                    dark_to: this.gradDTo,
                },
                glass: {
                    blur: this.glassBlur,
                    opacity: parseInt(this.glassOp) || 80,
                    border: !!this.glassBorder,
                }
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
     class="rounded-2xl p-4 sm:p-5 bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xs transition-all space-y-4">
    
    <!-- Top Bar: Label & Mode Segmented Controller -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">{{ $label }}</label>
            @if($help)
                <p class="text-[11px] text-slate-400 mt-0.5">{{ $help }}</p>
            @endif
        </div>

        <!-- Mode Segmented Control -->
        <div class="inline-flex items-center p-1 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold shadow-2xs">
            <button type="button" 
                    @click="setMode('theme')"
                    class="px-3.5 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5"
                    :class="mode === 'theme' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs font-extrabold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <x-icon name="solid:wand-magic-sparkles" class="w-3.5 h-3.5" />
                <span>Theme Default</span>
            </button>
            <button type="button" 
                    @click="setMode('custom')"
                    title="Custom Dual Mode"
                    class="px-3.5 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5"
                    :class="mode === 'custom' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs font-extrabold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <x-icon name="solid:sliders" class="w-3.5 h-3.5" />
                <span>Custom Color</span>
            </button>
        </div>
    </div>

    <!-- Theme Default Status Banner -->
    <div x-show="mode === 'theme'" 
         x-transition
         class="p-3 rounded-xl bg-cyan-50/70 dark:bg-cyan-950/20 border border-cyan-200/60 dark:border-cyan-800/40 text-xs text-cyan-900 dark:text-cyan-300 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <x-icon name="solid:circle-check" class="w-4 h-4 text-cyan-600 dark:text-cyan-400 shrink-0" />
            <span class="font-medium text-[11px] sm:text-xs">Automatically synchronized with global design system tokens and surface styles.</span>
        </div>
        <span class="text-[10px] font-mono font-bold px-2.5 py-1 rounded-lg bg-white/90 dark:bg-slate-900/90 border border-cyan-200 dark:border-cyan-800 text-cyan-800 dark:text-cyan-300 shrink-0">
            System Dynamic
        </span>
    </div>

    <!-- Custom Mode Inspector -->
    <div x-show="mode === 'custom'" 
         x-transition
         class="space-y-4 pt-1">
        
        @if($allowGradient || $allowGlass)
        <!-- Style Sub-type Switcher: Solid | Gradient | Glass -->
        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3 text-xs font-semibold">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mr-1">Style Type:</span>
            
            <button type="button" 
                    @click="setType('solid')"
                    class="px-3 py-1.5 rounded-xl transition-all cursor-pointer flex items-center gap-1.5"
                    :class="type === 'solid' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-extrabold shadow-2xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <span class="w-2.5 h-2.5 rounded-full bg-current"></span>
                <span>Solid Color</span>
            </button>

            @if($allowGradient)
            <button type="button" 
                    @click="setType('gradient')"
                    class="px-3 py-1.5 rounded-xl transition-all cursor-pointer flex items-center gap-1.5"
                    :class="type === 'gradient' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-extrabold shadow-2xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-cyan-400 to-blue-500"></span>
                <span>Linear Gradient</span>
            </button>
            @endif

            @if($allowGlass)
            <button type="button" 
                    @click="setType('glass')"
                    class="px-3 py-1.5 rounded-xl transition-all cursor-pointer flex items-center gap-1.5"
                    :class="type === 'glass' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 font-extrabold shadow-2xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <x-icon name="solid:cubes" class="w-3.5 h-3.5" />
                <span>Glass Effect</span>
            </button>
            @endif
        </div>
        @endif

        <!-- TYPE 1: SOLID COLOR -->
        <div x-show="type === 'solid'" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Light Mode Swatch Card -->
                <div class="p-3.5 sm:p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 shadow-2xs space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <span class="text-amber-500">☀️</span>
                            <span>Light Mode Color</span>
                        </span>
                        <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 uppercase" x-text="light"></span>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <div class="relative w-11 h-11 rounded-xl overflow-hidden border-2 border-slate-300 dark:border-slate-700 shadow-xs shrink-0 cursor-pointer"
                             :style="'background-color: ' + light">
                            <input type="color" 
                                   x-model="light" 
                                   @input="sync()"
                                   class="absolute -inset-2 w-16 h-16 opacity-0 cursor-pointer" />
                        </div>
                        <div class="relative flex-1">
                            <input type="text" 
                                   x-model="light" 
                                   @input.debounce.250ms="sync()"
                                   placeholder="#ffffff" 
                                   class="w-full px-3 py-2 text-xs font-mono font-bold uppercase rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-[#003C58] focus:border-transparent" />
                        </div>
                    </div>

                    <!-- Quick Preset Chips -->
                    <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                        <span class="text-[10px] font-bold text-slate-400 mr-1">Presets:</span>
                        <template x-for="hex in ['#ffffff', '#f8fafc', '#f1f5f9', '#003C58', '#0ea5e9', '#0f172a']" :key="hex">
                            <button type="button" 
                                    @click="applyLightColor(hex)"
                                    :title="hex"
                                    class="w-5 h-5 rounded-md border border-slate-300 dark:border-slate-700 shadow-2xs hover:scale-125 transition-transform cursor-pointer"
                                    :style="'background-color: ' + hex"></button>
                        </template>
                    </div>
                </div>

                <!-- Dark Mode Swatch Card -->
                <div class="p-3.5 sm:p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 shadow-2xs space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <span class="text-indigo-400">🌙</span>
                            <span>Dark Mode Color</span>
                        </span>
                        <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 uppercase" x-text="dark"></span>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <div class="relative w-11 h-11 rounded-xl overflow-hidden border-2 border-slate-300 dark:border-slate-700 shadow-xs shrink-0 cursor-pointer"
                             :style="'background-color: ' + dark">
                            <input type="color" 
                                   x-model="dark" 
                                   @input="sync()"
                                   class="absolute -inset-2 w-16 h-16 opacity-0 cursor-pointer" />
                        </div>
                        <div class="relative flex-1">
                            <input type="text" 
                                   x-model="dark" 
                                   @input.debounce.250ms="sync()"
                                   placeholder="#07131e" 
                                   class="w-full px-3 py-2 text-xs font-mono font-bold uppercase rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:ring-2 focus:ring-[#003C58] focus:border-transparent" />
                        </div>
                    </div>

                    <!-- Quick Preset Chips -->
                    <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                        <span class="text-[10px] font-bold text-slate-400 mr-1">Presets:</span>
                        <template x-for="hex in ['#07131e', '#0a1926', '#0f172a', '#040e17', '#003C58', '#0ea5e9']" :key="hex">
                            <button type="button" 
                                    @click="applyDarkColor(hex)"
                                    :title="hex"
                                    class="w-5 h-5 rounded-md border border-slate-300 dark:border-slate-700 shadow-2xs hover:scale-125 transition-transform cursor-pointer"
                                    :style="'background-color: ' + hex"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Opacity Slider -->
            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <span class="text-xs font-bold">Surface Opacity</span>
                    <span class="font-mono text-xs font-extrabold px-2 py-0.5 rounded-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-[#003C58] dark:text-cyan-400" x-text="opacity + '%'"></span>
                </div>
                <input type="range" min="10" max="100" step="5"
                       x-model="opacity" 
                       @input="sync()"
                       class="w-full accent-[#003C58] dark:accent-cyan-400 cursor-pointer h-2 bg-slate-200 dark:bg-slate-800 rounded-lg" />
            </div>

            <!-- Dual Swatch Preview Bar -->
            <div class="flex items-center rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xs h-9 text-xs font-bold">
                <div class="flex-1 h-full flex items-center justify-center text-slate-900 border-r border-slate-200 dark:border-slate-800"
                     :style="'background-color: ' + light + '; opacity: ' + (opacity / 100)">
                    <span>☀️ Light: <strong class="font-mono ml-1" x-text="light"></strong></span>
                </div>
                <div class="flex-1 h-full flex items-center justify-center text-white"
                     :style="'background-color: ' + dark + '; opacity: ' + (opacity / 100)">
                    <span>🌙 Dark: <strong class="font-mono ml-1" x-text="dark"></strong></span>
                </div>
            </div>
        </div>

        @if($allowGradient)
        <!-- TYPE 2: LINEAR GRADIENT -->
        <div x-show="type === 'gradient'" class="space-y-4">
            <!-- Direction Selector -->
            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block">Gradient Direction / Angle</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <button type="button" @click="gradDir = '90deg'; sync();"
                            class="px-2.5 py-1.5 rounded-lg text-xs font-bold border transition-all cursor-pointer text-center"
                            :class="gradDir === '90deg' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
                        Horizontal (90° →)
                    </button>
                    <button type="button" @click="gradDir = '135deg'; sync();"
                            class="px-2.5 py-1.5 rounded-lg text-xs font-bold border transition-all cursor-pointer text-center"
                            :class="gradDir === '135deg' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
                        Diagonal (135° ↘)
                    </button>
                    <button type="button" @click="gradDir = '180deg'; sync();"
                            class="px-2.5 py-1.5 rounded-lg text-xs font-bold border transition-all cursor-pointer text-center"
                            :class="gradDir === '180deg' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
                        Vertical (180° ↓)
                    </button>
                    <button type="button" @click="gradDir = '45deg'; sync();"
                            class="px-2.5 py-1.5 rounded-lg text-xs font-bold border transition-all cursor-pointer text-center"
                            :class="gradDir === '45deg' ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
                        Diagonal (45° ↗)
                    </button>
                </div>
            </div>

            <!-- Light & Dark Gradient Stops -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Light Gradient Stops -->
                <div class="p-3.5 sm:p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">☀️ Light Mode Gradient Stops</span>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 block uppercase">Start Color</span>
                            <div class="flex items-center gap-2">
                                <div class="relative w-9 h-9 rounded-lg overflow-hidden border border-slate-300 dark:border-slate-700 shrink-0 cursor-pointer"
                                     :style="'background-color: ' + gradLFrom">
                                    <input type="color" x-model="gradLFrom" @input="sync()" class="absolute -inset-2 w-14 h-14 opacity-0 cursor-pointer" />
                                </div>
                                <input type="text" x-model="gradLFrom" @input.debounce.250ms="sync()" class="w-full px-2 py-1.5 text-xs font-mono font-bold uppercase rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 block uppercase">End Color</span>
                            <div class="flex items-center gap-2">
                                <div class="relative w-9 h-9 rounded-lg overflow-hidden border border-slate-300 dark:border-slate-700 shrink-0 cursor-pointer"
                                     :style="'background-color: ' + gradLTo">
                                    <input type="color" x-model="gradLTo" @input="sync()" class="absolute -inset-2 w-14 h-14 opacity-0 cursor-pointer" />
                                </div>
                                <input type="text" x-model="gradLTo" @input.debounce.250ms="sync()" class="w-full px-2 py-1.5 text-xs font-mono font-bold uppercase rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dark Gradient Stops -->
                <div class="p-3.5 sm:p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-3">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">🌙 Dark Mode Gradient Stops</span>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 block uppercase">Start Color</span>
                            <div class="flex items-center gap-2">
                                <div class="relative w-9 h-9 rounded-lg overflow-hidden border border-slate-300 dark:border-slate-700 shrink-0 cursor-pointer"
                                     :style="'background-color: ' + gradDFrom">
                                    <input type="color" x-model="gradDFrom" @input="sync()" class="absolute -inset-2 w-14 h-14 opacity-0 cursor-pointer" />
                                </div>
                                <input type="text" x-model="gradDFrom" @input.debounce.250ms="sync()" class="w-full px-2 py-1.5 text-xs font-mono font-bold uppercase rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 block uppercase">End Color</span>
                            <div class="flex items-center gap-2">
                                <div class="relative w-9 h-9 rounded-lg overflow-hidden border border-slate-300 dark:border-slate-700 shrink-0 cursor-pointer"
                                     :style="'background-color: ' + gradDTo">
                                    <input type="color" x-model="gradDTo" @input="sync()" class="absolute -inset-2 w-14 h-14 opacity-0 cursor-pointer" />
                                </div>
                                <input type="text" x-model="gradDTo" @input.debounce.250ms="sync()" class="w-full px-2 py-1.5 text-xs font-mono font-bold uppercase rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gradient Live Preview Strip -->
            <div class="grid grid-cols-2 gap-2 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 text-xs font-bold h-9">
                <div class="h-full flex items-center justify-center text-slate-900 border-r border-slate-200 dark:border-slate-800"
                     :style="'background: linear-gradient(' + gradDir + ', ' + gradLFrom + ', ' + gradLTo + ');'">
                    ☀️ Light Gradient Preview
                </div>
                <div class="h-full flex items-center justify-center text-white"
                     :style="'background: linear-gradient(' + gradDir + ', ' + gradDFrom + ', ' + gradDTo + ');'">
                    🌙 Dark Gradient Preview
                </div>
            </div>
        </div>
        @endif

        @if($allowGlass)
        <!-- TYPE 3: GLASS EFFECT (BACKGROUNDS ONLY) -->
        <div x-show="type === 'glass'" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Blur Slider -->
                <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Frosted Glass Blur</span>
                        <span class="font-mono text-xs font-extrabold px-2 py-0.5 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-[#003C58] dark:text-cyan-400" x-text="glassBlur"></span>
                    </div>
                    <select x-model="glassBlur" @change="sync()" class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white cursor-pointer">
                        <option value="4px">Subtle Glaze (4px)</option>
                        <option value="8px">Balanced Frost (8px)</option>
                        <option value="12px">Standard Frosted Glass (12px - Recommended)</option>
                        <option value="16px">Heavy Frosted (16px)</option>
                        <option value="24px">Dense Blur (24px)</option>
                    </select>
                </div>

                <!-- Glass Opacity Slider -->
                <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Glass Translucency</span>
                        <span class="font-mono text-xs font-extrabold px-2 py-0.5 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-[#003C58] dark:text-cyan-400" x-text="glassOp + '%'"></span>
                    </div>
                    <input type="range" min="20" max="95" step="5"
                           x-model="glassOp" 
                           @input="sync()"
                           class="w-full accent-[#003C58] dark:accent-cyan-400 cursor-pointer h-2 bg-slate-200 dark:bg-slate-800 rounded-lg mt-2" />
                </div>
            </div>

            <!-- Glass Live Preview Strip -->
            <div class="relative rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 h-10 p-2 flex items-center justify-between text-xs font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500">
                <span class="text-white/40 text-[10px] uppercase tracking-wider font-mono">Sample Background</span>
                <div class="absolute inset-0 flex items-center justify-center text-slate-900 dark:text-white text-xs font-extrabold"
                     :style="'background-color: ' + (mode === 'custom' ? (type === 'glass' ? 'rgba(255,255,255,' + (glassOp/100) + ')' : light) : 'rgba(255,255,255,0.8)') + '; backdrop-filter: blur(' + glassBlur + '); -webkit-backdrop-filter: blur(' + glassBlur + ');'">
                    <span>✨ Frosted Glassmorphism Active</span>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
