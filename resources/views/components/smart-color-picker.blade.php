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
     class="rounded-2xl p-4 bg-slate-50/80 dark:bg-slate-950/60 border border-slate-200/90 dark:border-slate-800 transition-all space-y-3.5">
    
    <!-- Top Bar: Label & Mode Segmented Controller -->
    <div class="flex flex-wrap items-center justify-between gap-2.5">
        <div>
            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider">{{ $label }}</label>
            @if($help)
                <p class="text-[11px] text-slate-400 mt-0.5">{{ $help }}</p>
            @endif
        </div>

        <!-- Mode Segmented Control -->
        <div class="inline-flex items-center p-1 rounded-xl bg-slate-200/80 dark:bg-slate-900 border border-slate-300/80 dark:border-slate-800 text-xs font-bold shadow-2xs">
            <button type="button" 
                    @click="setMode('theme')"
                    class="px-3 py-1 rounded-lg transition-all cursor-pointer flex items-center gap-1.5"
                    :class="mode === 'theme' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs font-extrabold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <x-icon name="solid:wand-magic-sparkles" class="w-3 h-3" />
                <span>Theme Default</span>
            </button>
            <button type="button" 
                    @click="setMode('custom')"
                    title="Custom Dual Mode"
                    class="px-3 py-1 rounded-lg transition-all cursor-pointer flex items-center gap-1.5"
                    :class="mode === 'custom' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs font-extrabold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <x-icon name="solid:sliders" class="w-3 h-3" />
                <span>Custom Dual Mode</span>
            </button>
        </div>
    </div>

    <!-- Theme Default Status Banner -->
    <div x-show="mode === 'theme'" 
         x-transition
         class="p-2.5 rounded-xl bg-cyan-50/70 dark:bg-cyan-950/20 border border-cyan-200/60 dark:border-cyan-800/40 text-[11px] text-cyan-900 dark:text-cyan-300 flex items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            <x-icon name="solid:circle-check" class="w-4 h-4 text-cyan-600 dark:text-cyan-400 shrink-0" />
            <span class="font-medium">Uses dynamic design system surface tokens &amp; global backdrop rules automatically.</span>
        </div>
        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md bg-white/80 dark:bg-slate-900/80 border border-cyan-200 dark:border-cyan-800 text-cyan-800 dark:text-cyan-300 shrink-0">
            System Dynamic
        </span>
    </div>

    <!-- Custom Mode Inspector -->
    <div x-show="mode === 'custom'" 
         x-transition
         class="space-y-3.5 pt-1">
        
        @if($allowGradient || $allowGlass)
        <!-- Style Sub-type Switcher: Solid | Gradient | Glass -->
        <div class="flex items-center gap-1.5 border-b border-slate-200 dark:border-slate-800 pb-2.5 text-xs font-semibold">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mr-1">Style:</span>
            
            <button type="button" 
                    @click="setType('solid')"
                    class="px-2.5 py-1 rounded-lg transition-all cursor-pointer flex items-center gap-1"
                    :class="type === 'solid' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 font-extrabold shadow-2xs border border-slate-200 dark:border-slate-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <span class="w-2.5 h-2.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                <span>Solid Color</span>
            </button>

            @if($allowGradient)
            <button type="button" 
                    @click="setType('gradient')"
                    class="px-2.5 py-1 rounded-lg transition-all cursor-pointer flex items-center gap-1"
                    :class="type === 'gradient' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 font-extrabold shadow-2xs border border-slate-200 dark:border-slate-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600"></span>
                <span>Linear Gradient</span>
            </button>
            @endif

            @if($allowGlass)
            <button type="button" 
                    @click="setType('glass')"
                    class="px-2.5 py-1 rounded-lg transition-all cursor-pointer flex items-center gap-1"
                    :class="type === 'glass' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 font-extrabold shadow-2xs border border-slate-200 dark:border-slate-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                <x-icon name="solid:cubes" class="w-3 h-3 text-cyan-500" />
                <span>Glass Effect</span>
            </button>
            @endif
        </div>
        @endif

        <!-- TYPE 1: SOLID COLOR -->
        <div x-show="type === 'solid'" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Light Mode Swatch Card -->
                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <span>☀️ Light Mode Color</span>
                        </span>
                        <span class="text-[10px] font-mono font-bold text-slate-400 uppercase" x-text="light"></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="color" 
                               x-model="light" 
                               @input="sync()"
                               class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 p-0.5 bg-transparent cursor-pointer shrink-0" />
                        <input type="text" 
                               x-model="light" 
                               @input.debounce.250ms="sync()"
                               placeholder="#ffffff" 
                               class="w-full px-2.5 py-1.5 text-xs font-mono font-bold uppercase rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white focus:ring-1 focus:ring-[#003C58]" />
                    </div>

                    <!-- Quick Preset Chips -->
                    <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                        <span class="text-[9px] font-bold text-slate-400 mr-0.5">Presets:</span>
                        <template x-for="hex in ['#ffffff', '#f8fafc', '#f1f5f9', '#003C58', '#0ea5e9', '#0f172a']" :key="hex">
                            <button type="button" 
                                    @click="applyLightColor(hex)"
                                    :title="hex"
                                    class="w-4 h-4 rounded-md border border-slate-300 dark:border-slate-700 shadow-2xs hover:scale-110 transition-transform cursor-pointer"
                                    :style="'background-color: ' + hex"></button>
                        </template>
                    </div>
                </div>

                <!-- Dark Mode Swatch Card -->
                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                            <span>🌙 Dark Mode Color</span>
                        </span>
                        <span class="text-[10px] font-mono font-bold text-slate-400 uppercase" x-text="dark"></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="color" 
                               x-model="dark" 
                               @input="sync()"
                               class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 p-0.5 bg-transparent cursor-pointer shrink-0" />
                        <input type="text" 
                               x-model="dark" 
                               @input.debounce.250ms="sync()"
                               placeholder="#07131e" 
                               class="w-full px-2.5 py-1.5 text-xs font-mono font-bold uppercase rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white focus:ring-1 focus:ring-[#003C58]" />
                    </div>

                    <!-- Quick Preset Chips -->
                    <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                        <span class="text-[9px] font-bold text-slate-400 mr-0.5">Presets:</span>
                        <template x-for="hex in ['#07131e', '#0a1926', '#0f172a', '#040e17', '#003C58', '#0ea5e9']" :key="hex">
                            <button type="button" 
                                    @click="applyDarkColor(hex)"
                                    :title="hex"
                                    class="w-4 h-4 rounded-md border border-slate-300 dark:border-slate-700 shadow-2xs hover:scale-110 transition-transform cursor-pointer"
                                    :style="'background-color: ' + hex"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Opacity Slider -->
            <div class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1.5">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <span class="text-[11px] font-bold">Surface Opacity</span>
                    <span class="font-mono text-xs font-extrabold text-[#003C58] dark:text-cyan-400" x-text="opacity + '%'"></span>
                </div>
                <input type="range" min="10" max="100" step="5"
                       x-model="opacity" 
                       @input="sync()"
                       class="w-full accent-[#003C58] dark:accent-cyan-400 cursor-pointer h-1.5 bg-slate-200 dark:bg-slate-800 rounded-lg" />
            </div>

            <!-- Dual Swatch Preview Bar -->
            <div class="flex items-center rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xs h-7 text-[10px] font-bold">
                <div class="flex-1 h-full flex items-center justify-center text-slate-900 border-r border-slate-200 dark:border-slate-800"
                     :style="'background-color: ' + light + '; opacity: ' + (opacity / 100)">
                    ☀️ Light: <span class="font-mono ml-1" x-text="light"></span>
                </div>
                <div class="flex-1 h-full flex items-center justify-center text-white"
                     :style="'background-color: ' + dark + '; opacity: ' + (opacity / 100)">
                    🌙 Dark: <span class="font-mono ml-1" x-text="dark"></span>
                </div>
            </div>
        </div>

        @if($allowGradient)
        <!-- TYPE 2: LINEAR GRADIENT -->
        <div x-show="type === 'gradient'" class="space-y-3">
            <!-- Direction Selector -->
            <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs">
                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Gradient Angle</span>
                <select x-model="gradDir" @change="sync()" class="px-2 py-1 text-xs font-bold rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white cursor-pointer">
                    <option value="90deg">Horizontal (90° →)</option>
                    <option value="135deg">Diagonal (135° ↘ - Recommended)</option>
                    <option value="180deg">Vertical (180° ↓)</option>
                    <option value="45deg">Diagonal (45° ↗)</option>
                </select>
            </div>

            <!-- Light & Dark Gradient Stops -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Light Gradient Stops -->
                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">☀️ Light Gradient Stops</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 block mb-0.5">Start Color</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="gradLFrom" @input="sync()" class="w-7 h-7 rounded-md p-0.5 border border-slate-200 dark:border-slate-700 bg-transparent cursor-pointer" />
                                <input type="text" x-model="gradLFrom" @input.debounce.250ms="sync()" class="w-full px-1.5 py-1 text-[11px] font-mono font-bold uppercase rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 block mb-0.5">End Color</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="gradLTo" @input="sync()" class="w-7 h-7 rounded-md p-0.5 border border-slate-200 dark:border-slate-700 bg-transparent cursor-pointer" />
                                <input type="text" x-model="gradLTo" @input.debounce.250ms="sync()" class="w-full px-1.5 py-1 text-[11px] font-mono font-bold uppercase rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dark Gradient Stops -->
                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">🌙 Dark Gradient Stops</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 block mb-0.5">Start Color</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="gradDFrom" @input="sync()" class="w-7 h-7 rounded-md p-0.5 border border-slate-200 dark:border-slate-700 bg-transparent cursor-pointer" />
                                <input type="text" x-model="gradDFrom" @input.debounce.250ms="sync()" class="w-full px-1.5 py-1 text-[11px] font-mono font-bold uppercase rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 block mb-0.5">End Color</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="gradDTo" @input="sync()" class="w-7 h-7 rounded-md p-0.5 border border-slate-200 dark:border-slate-700 bg-transparent cursor-pointer" />
                                <input type="text" x-model="gradDTo" @input.debounce.250ms="sync()" class="w-full px-1.5 py-1 text-[11px] font-mono font-bold uppercase rounded bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gradient Live Preview Strip -->
            <div class="grid grid-cols-2 gap-2 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 text-[10px] font-bold h-7">
                <div class="h-full flex items-center justify-center text-slate-900 border-r border-slate-200 dark:border-slate-800"
                     :style="'background: linear-gradient(' + gradDir + ', ' + gradLFrom + ', ' + gradLTo + ');'">
                    ☀️ Light Gradient
                </div>
                <div class="h-full flex items-center justify-center text-white"
                     :style="'background: linear-gradient(' + gradDir + ', ' + gradDFrom + ', ' + gradDTo + ');'">
                    🌙 Dark Gradient
                </div>
            </div>
        </div>
        @endif

        @if($allowGlass)
        <!-- TYPE 3: GLASS EFFECT -->
        <div x-show="type === 'glass'" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Blur Slider -->
                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Frosted Glass Blur</span>
                        <span class="font-mono text-xs font-extrabold text-[#003C58] dark:text-cyan-400" x-text="glassBlur"></span>
                    </div>
                    <select x-model="glassBlur" @change="sync()" class="w-full px-2 py-1 text-xs font-bold rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white cursor-pointer">
                        <option value="4px">Subtle Glaze (4px)</option>
                        <option value="8px">Medium Frost (8px)</option>
                        <option value="12px">Standard Glass (12px - Recommended)</option>
                        <option value="16px">Heavy Frosted (16px)</option>
                        <option value="24px">Dense Blur (24px)</option>
                    </select>
                </div>

                <!-- Glass Opacity Slider -->
                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300">Glass Translucency</span>
                        <span class="font-mono text-xs font-extrabold text-[#003C58] dark:text-cyan-400" x-text="glassOp + '%'"></span>
                    </div>
                    <input type="range" min="20" max="95" step="5"
                           x-model="glassOp" 
                           @input="sync()"
                           class="w-full accent-[#003C58] dark:accent-cyan-400 cursor-pointer h-1.5 bg-slate-200 dark:bg-slate-800 rounded-lg mt-2" />
                </div>
            </div>

            <!-- Glass Live Preview Strip -->
            <div class="relative rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 h-9 p-2 flex items-center justify-between text-xs font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500">
                <span class="text-white/40 text-[10px] uppercase tracking-wider font-mono">Background Specimen</span>
                <div class="absolute inset-0 flex items-center justify-center text-slate-900 dark:text-white text-[11px] font-extrabold"
                     :style="'background-color: ' + (mode === 'custom' ? (type === 'glass' ? 'rgba(255,255,255,' + (glassOp/100) + ')' : light) : 'rgba(255,255,255,0.8)') + '; backdrop-filter: blur(' + glassBlur + '); -webkit-backdrop-filter: blur(' + glassBlur + ');'">
                    <span>Glassmorphism Preview Active</span>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
