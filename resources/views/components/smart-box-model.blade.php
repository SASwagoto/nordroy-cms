@props([
    'label' => 'Spacing, Dimensions & Box Model',
    'help' => 'Granular control over padding, margin, border, elevation, and max-width.',
    'showPadding' => true,
    'showMargin' => true,
    'showBorder' => true,
    'showShadow' => true,
    'showWidth' => true,
    'compact' => false,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $currentVal = ($wireModel && isset($this)) ? data_get($this, $wireModel) : null;
    $val = \App\Services\SmartBoxModelHelper::normalize($currentVal);

    $p = $val['padding'];
    $m = $val['margin'];
    $b = $val['border'];
    $sh = $val['shadow'];
    $w = $val['width'];
@endphp

<div wire:ignore.self
     x-data="{
        isExpanded: false,
        paddingMode: '{{ $p['mode'] ?? 'axis' }}',
        pY: '{{ $p['y'] ?? '16px' }}',
        pX: '{{ $p['x'] ?? '24px' }}',
        pTop: '{{ $p['top'] ?? '16px' }}',
        pBottom: '{{ $p['bottom'] ?? '16px' }}',
        pLeft: '{{ $p['left'] ?? '24px' }}',
        pRight: '{{ $p['right'] ?? '24px' }}',
        pAll: '{{ $p['all'] ?? '16px' }}',

        mTop: '{{ $m['top'] ?? '0px' }}',
        mBottom: '{{ $m['bottom'] ?? '0px' }}',
        mCenter: {{ !empty($m['center']) ? 'true' : 'false' }},

        bWidth: '{{ $b['width'] ?? '0px' }}',
        bSide: '{{ $b['side'] ?? 'bottom' }}',
        bStyle: '{{ $b['style'] ?? 'solid' }}',
        bRadius: '{{ $b['radius'] ?? '0px' }}',
        bColor: '{{ $b['color'] ?? '#e2e8f0' }}',

        shadow: '{{ $sh ?? 'none' }}',
        width: '{{ $w ?? '1536px' }}',

        setPaddingPreset(val, axis = 'y') {
            if (axis === 'y') {
                this.pY = val;
                this.pTop = val;
                this.pBottom = val;
            } else if (axis === 'x') {
                this.pX = val;
                this.pLeft = val;
                this.pRight = val;
            } else if (axis === 'all') {
                this.pAll = val;
                this.pY = val;
                this.pX = val;
                this.pTop = val;
                this.pBottom = val;
                this.pLeft = val;
                this.pRight = val;
            }
            this.sync();
        },

        sync() {
            const payload = {
                padding: {
                    mode: this.paddingMode,
                    top: this.pTop,
                    bottom: this.pBottom,
                    left: this.pLeft,
                    right: this.pRight,
                    all: this.pAll,
                    y: this.pY,
                    x: this.pX,
                },
                margin: {
                    top: this.mTop,
                    bottom: this.mBottom,
                    center: !!this.mCenter,
                },
                border: {
                    enabled: (this.bWidth !== '0px' && this.bWidth !== '0'),
                    width: this.bWidth,
                    side: this.bSide,
                    style: this.bStyle,
                    radius: this.bRadius,
                    color: this.bColor,
                },
                shadow: this.shadow,
                width: this.width,
            };

            if ('{{ $wireModel }}' && $wire) {
                $wire.set('{{ $wireModel }}', payload);
            }
            window.dispatchEvent(new CustomEvent('smart-box-model-changed', {
                detail: { model: '{{ $wireModel }}', box: payload }
            }));
            if (this.$dispatch) {
                this.$dispatch('smart-box-model-changed', { model: '{{ $wireModel }}', box: payload });
            }
        },

        get summaryText() {
            let parts = [];
            if (this.paddingMode === 'axis') {
                parts.push(`Pad: ${this.pY} / ${this.pX}`);
            } else if (this.paddingMode === 'linked') {
                parts.push(`Pad: ${this.pAll}`);
            } else {
                parts.push(`Pad: T${this.pTop} R${this.pRight} B${this.pBottom} L${this.pLeft}`);
            }
            if (this.width) {
                parts.push(`Max: ${this.width}`);
            }
            if (this.bWidth !== '0px' && this.bWidth !== '0') {
                parts.push(`Border: ${this.bWidth}`);
            }
            return parts.join(' • ');
        }
     }"
     class="w-full space-y-2">

    @if ($label)
        <div class="flex items-center justify-between">
            <div>
                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">{{ $label }}</label>
                @if($help)
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 font-medium">{{ $help }}</p>
                @endif
            </div>
            <span class="text-[10px] font-mono font-extrabold px-2 py-0.5 rounded-md bg-cyan-100 text-cyan-800 border border-cyan-200 dark:bg-cyan-500/20 dark:text-cyan-400 dark:border-cyan-500/30" x-text="summaryText"></span>
        </div>
    @endif

    <!-- Trigger Bar -->
    <div @click="isExpanded = !isExpanded"
         role="button"
         tabindex="0"
         @keydown.enter.prevent="isExpanded = !isExpanded"
         @keydown.space.prevent="isExpanded = !isExpanded"
         class="p-3 rounded-2xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-800 shadow-xs hover:border-[#003C58] dark:hover:border-cyan-400 transition-all flex items-center justify-between gap-3 cursor-pointer select-none group">
        
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center shrink-0">
                <x-icon name="solid:border-all" class="w-4 h-4" />
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-xs font-extrabold text-slate-900 dark:text-white truncate group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors" 
                   x-text="summaryText || 'Click to configure spacing'"></p>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Fine-tune padding, margins, borders &amp; container width</p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="text-[11px] font-bold text-slate-500 group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors hidden sm:inline"
                  x-text="isExpanded ? 'Collapse Engine' : 'Customize Spacing'"></span>
            
            <button type="button" 
                    @click.stop="isExpanded = !isExpanded"
                    class="px-3 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer shrink-0 inline-flex items-center gap-1.5 shadow-2xs"
                    :class="isExpanded ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700'">
                <span x-text="isExpanded ? 'Done' : 'Edit'"></span>
                <x-icon name="solid:chevron-down" class="w-3 h-3 transition-transform duration-200" ::class="isExpanded ? 'rotate-180' : ''" />
            </button>
        </div>
    </div>

    <!-- Collapsible Controls HUD -->
    <div x-show="isExpanded" 
         x-collapse
         class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-800 shadow-md space-y-4">
        
        @if($showPadding)
        <!-- 1. PADDING CONTROLS -->
        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-800 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <label class="block text-xs font-extrabold text-slate-900 dark:text-white flex items-center gap-1.5">
                    <x-icon name="solid:arrows-to-dot" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                    <span>Internal Padding Engine</span>
                </label>
                
                <!-- Padding Mode Pills -->
                <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-950 p-1 rounded-lg border border-slate-300 dark:border-slate-800 text-[10px] font-bold">
                    <button type="button" @click="paddingMode = 'axis'; sync()"
                            :class="paddingMode === 'axis' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                            class="px-2 py-0.5 rounded cursor-pointer transition-all">
                        Y / X Axis
                    </button>
                    <button type="button" @click="paddingMode = 'linked'; sync()"
                            :class="paddingMode === 'linked' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                            class="px-2 py-0.5 rounded cursor-pointer transition-all">
                        Linked (All)
                    </button>
                    <button type="button" @click="paddingMode = 'independent'; sync()"
                            :class="paddingMode === 'independent' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-2xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                            class="px-2 py-0.5 rounded cursor-pointer transition-all">
                        4-Side Independent
                    </button>
                </div>
            </div>

            <!-- MODE A: AXIS (Y & X) -->
            <template x-if="paddingMode === 'axis'">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Vertical Y -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Vertical Padding (Top / Bottom)</span>
                            <span class="font-mono text-xs font-extrabold text-[#003C58] dark:text-cyan-400" x-text="pY"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" x-model="pY" @input.debounce.250ms="pTop = pY; pBottom = pY; sync()"
                                   placeholder="16px" 
                                   class="w-24 px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                            <div class="flex flex-wrap gap-1">
                                <template x-for="chip in ['0px', '8px', '16px', '24px', '32px', '48px', '64px', '96px']">
                                    <button type="button" @click="pY = chip; pTop = chip; pBottom = chip; sync()"
                                            :class="pY === chip ? 'bg-[#003C58] text-white font-extrabold dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300'"
                                            class="px-2 py-1 rounded text-[10px] font-mono font-semibold transition-colors cursor-pointer"
                                            x-text="chip"></button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Horizontal X -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Horizontal Padding (Left / Right)</span>
                            <span class="font-mono text-xs font-extrabold text-[#003C58] dark:text-cyan-400" x-text="pX"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" x-model="pX" @input.debounce.250ms="pLeft = pX; pRight = pX; sync()"
                                   placeholder="24px" 
                                   class="w-24 px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                            <div class="flex flex-wrap gap-1">
                                <template x-for="chip in ['0px', '12px', '16px', '24px', '32px', '48px']">
                                    <button type="button" @click="pX = chip; pLeft = chip; pRight = chip; sync()"
                                            :class="pX === chip ? 'bg-[#003C58] text-white font-extrabold dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300'"
                                            class="px-2 py-1 rounded text-[10px] font-mono font-semibold transition-colors cursor-pointer"
                                            x-text="chip"></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- MODE B: LINKED (ALL 4 SIDES EQUAL) -->
            <template x-if="paddingMode === 'linked'">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Uniform Padding (All Sides)</span>
                        <span class="font-mono text-xs font-extrabold text-[#003C58] dark:text-cyan-400" x-text="pAll"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" x-model="pAll" @input.debounce.250ms="setPaddingPreset(pAll, 'all')"
                               placeholder="16px" 
                               class="w-28 px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="chip in ['0px', '8px', '12px', '16px', '24px', '32px', '48px', '64px', '80px', '96px']">
                                <button type="button" @click="setPaddingPreset(chip, 'all')"
                                        :class="pAll === chip ? 'bg-[#003C58] text-white font-extrabold dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300'"
                                        class="px-2.5 py-1 rounded-lg text-xs font-mono font-semibold transition-colors cursor-pointer"
                                        x-text="chip"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- MODE C: 4-SIDE INDEPENDENT -->
            <template x-if="paddingMode === 'independent'">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Top</label>
                        <input type="text" x-model="pTop" @input.debounce.250ms="sync()" placeholder="16px"
                               class="w-full px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Right</label>
                        <input type="text" x-model="pRight" @input.debounce.250ms="sync()" placeholder="24px"
                               class="w-full px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Bottom</label>
                        <input type="text" x-model="pBottom" @input.debounce.250ms="sync()" placeholder="16px"
                               class="w-full px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">Left</label>
                        <input type="text" x-model="pLeft" @input.debounce.250ms="sync()" placeholder="24px"
                               class="w-full px-3 py-1.5 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                    </div>
                </div>
            </template>
        </div>
        @endif

        <!-- 2. MARGIN & WIDTH CONTROLS -->
        @if($showMargin || $showWidth)
        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-800 shadow-xs space-y-3">
            <label class="block text-xs font-extrabold text-slate-900 dark:text-white flex items-center gap-1.5">
                <x-icon name="solid:maximize" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                <span>Layout Dimensions &amp; External Margins</span>
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if($showWidth)
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Content Max-Width</label>
                    <select x-model="width" @change="sync()"
                            class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="1280px">Boxed Standard (1280px)</option>
                        <option value="1440px">Corporate Wide (1440px)</option>
                        <option value="1536px">Ultra Wide (1536px - Recommended)</option>
                        <option value="1680px">Studio Panoramic (1680px)</option>
                        <option value="100%">100% Full Fluid Width</option>
                    </select>
                </div>
                @endif

                @if($showMargin)
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Margin Top</label>
                        <input type="text" x-model="mTop" @input.debounce.250ms="sync()" placeholder="0px"
                               class="w-full px-3 py-2 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Margin Bottom</label>
                        <input type="text" x-model="mBottom" @input.debounce.250ms="sync()" placeholder="0px"
                               class="w-full px-3 py-2 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- 3. BORDER & ELEVATION CONTROLS -->
        @if($showBorder || $showShadow)
        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-800 shadow-xs space-y-3">
            <label class="block text-xs font-extrabold text-slate-900 dark:text-white flex items-center gap-1.5">
                <x-icon name="solid:square-dashed" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                <span>Borders, Radii &amp; Shadow Elevation</span>
            </label>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @if($showBorder)
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Border Width</label>
                    <select x-model="bWidth" @change="sync()"
                            class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="0px">None (0px)</option>
                        <option value="1px">Thin (1px)</option>
                        <option value="2px">Crisp (2px)</option>
                        <option value="3px">Bold (3px)</option>
                        <option value="4px">Thick (4px)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Border Side</label>
                    <select x-model="bSide" @change="sync()"
                            class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="bottom">Bottom Divider Only</option>
                        <option value="top">Top Divider Only</option>
                        <option value="y">Top &amp; Bottom</option>
                        <option value="all">All 4 Sides (Boxed)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Corner Radius</label>
                    <select x-model="bRadius" @change="sync()"
                            class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="0px">Sharp (0px)</option>
                        <option value="6px">Subtle (6px)</option>
                        <option value="12px">Rounded (12px)</option>
                        <option value="16px">Curved (16px)</option>
                        <option value="24px">Pill / Island (24px)</option>
                    </select>
                </div>
                @endif

                @if($showShadow)
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Shadow Elevation</label>
                    <select x-model="shadow" @change="sync()"
                            class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="none">Flat (No Shadow)</option>
                        <option value="2xs">Subtle 2XS</option>
                        <option value="xs">Soft XS</option>
                        <option value="sm">Elevated SM</option>
                        <option value="md">Floating MD</option>
                        <option value="lg">Prominent LG</option>
                        <option value="xl">Deep XL</option>
                    </select>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>

</div>
