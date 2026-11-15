@props([
    'label' => 'Box Model & Spacing',
    'help' => null,
    'showPadding' => true,
    'showMargin' => false,
    'showBorder' => true,
    'showShadow' => false,
    'showWidth' => false,
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
        isLinked: {{ ($p['mode'] ?? 'axis') === 'linked' ? 'true' : 'false' }},
        pTop: '{{ $p['top'] ?? ($p['y'] ?? '16px') }}',
        pRight: '{{ $p['right'] ?? ($p['x'] ?? '24px') }}',
        pBottom: '{{ $p['bottom'] ?? ($p['y'] ?? '16px') }}',
        pLeft: '{{ $p['left'] ?? ($p['x'] ?? '24px') }}',

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

        updatePadding(side, value) {
            if (this.isLinked) {
                this.pTop = value;
                this.pRight = value;
                this.pBottom = value;
                this.pLeft = value;
            } else {
                if (side === 'top') this.pTop = value;
                if (side === 'right') this.pRight = value;
                if (side === 'bottom') this.pBottom = value;
                if (side === 'left') this.pLeft = value;
            }
            this.sync();
        },

        applyPreset(val) {
            this.pTop = val;
            this.pRight = val;
            this.pBottom = val;
            this.pLeft = val;
            this.sync();
        },

        toggleLinked() {
            this.isLinked = !this.isLinked;
            if (this.isLinked) {
                this.pRight = this.pTop;
                this.pBottom = this.pTop;
                this.pLeft = this.pTop;
            }
            this.sync();
        },

        sync() {
            const payload = {
                padding: {
                    mode: this.isLinked ? 'linked' : 'independent',
                    top: this.pTop,
                    bottom: this.pBottom,
                    left: this.pLeft,
                    right: this.pRight,
                    all: this.pTop,
                    y: this.pTop,
                    x: this.pLeft,
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
        }
     }"
     class="w-full p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-3">

    <!-- Header bar -->
    <div class="flex items-center justify-between">
        <div>
            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">{{ $label }}</label>
            @if($help)
                <p class="text-[10px] text-slate-400">{{ $help }}</p>
            @endif
        </div>
        <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400" 
              x-text="'P: ' + pTop + ' ' + pRight + ' ' + pBottom + ' ' + pLeft + (bWidth !== '0px' ? ' • B: ' + bWidth : '')">
        </span>
    </div>

    @if($showPadding)
    <!-- ELEMENTOR-STYLE 4-BOX PADDING INSPECTOR -->
    <div class="space-y-1.5 pt-1">
        <div class="flex items-center gap-2">
            <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400 w-14 shrink-0">Padding</span>

            <!-- 4 Inputs: Top, Right, Bottom, Left -->
            <div class="grid grid-cols-4 gap-1.5 flex-1">
                <!-- TOP -->
                <div class="relative">
                    <input type="text" x-model="pTop" @input.debounce.250ms="updatePadding('top', $event.target.value)"
                           placeholder="0px"
                           class="w-full text-center px-1 py-1 text-xs font-mono font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#003C58]">
                    <span class="block text-[8px] font-bold text-slate-400 text-center uppercase tracking-wider mt-0.5">Top</span>
                </div>

                <!-- RIGHT -->
                <div class="relative">
                    <input type="text" x-model="pRight" @input.debounce.250ms="updatePadding('right', $event.target.value)"
                           placeholder="0px"
                           class="w-full text-center px-1 py-1 text-xs font-mono font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#003C58]">
                    <span class="block text-[8px] font-bold text-slate-400 text-center uppercase tracking-wider mt-0.5">Right</span>
                </div>

                <!-- BOTTOM -->
                <div class="relative">
                    <input type="text" x-model="pBottom" @input.debounce.250ms="updatePadding('bottom', $event.target.value)"
                           placeholder="0px"
                           class="w-full text-center px-1 py-1 text-xs font-mono font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#003C58]">
                    <span class="block text-[8px] font-bold text-slate-400 text-center uppercase tracking-wider mt-0.5">Bottom</span>
                </div>

                <!-- LEFT -->
                <div class="relative">
                    <input type="text" x-model="pLeft" @input.debounce.250ms="updatePadding('left', $event.target.value)"
                           placeholder="0px"
                           class="w-full text-center px-1 py-1 text-xs font-mono font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#003C58]">
                    <span class="block text-[8px] font-bold text-slate-400 text-center uppercase tracking-wider mt-0.5">Left</span>
                </div>
            </div>

            <!-- LINK / UNLINK BUTTON (Elementor Style) -->
            <button type="button" @click="toggleLinked()"
                    :title="isLinked ? 'Values are linked (click to unlink)' : 'Values are independent (click to link)'"
                    class="p-1.5 rounded-lg border text-xs transition-all cursor-pointer shrink-0"
                    :class="isLinked ? 'bg-[#003C58] text-white border-[#003C58] dark:bg-cyan-500 dark:text-slate-950 dark:border-cyan-400' : 'bg-white text-slate-400 border-slate-300 dark:bg-slate-900 dark:border-slate-700 hover:text-slate-700'">
                <x-icon name="solid:link" class="w-3.5 h-3.5" />
            </button>
        </div>

        <!-- Quick Presets Strip -->
        <div class="flex items-center gap-1 pl-16 overflow-x-auto no-scrollbar pt-0.5">
            @foreach(['0px', '8px', '16px', '24px', '32px', '48px', '64px', '96px'] as $preset)
                <button type="button" @click="applyPreset('{{ $preset }}')"
                        class="px-1.5 py-0.5 text-[9px] font-mono rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:text-[#003C58] dark:hover:text-cyan-400 hover:border-[#003C58] transition-colors cursor-pointer shrink-0">
                    {{ $preset }}
                </button>
            @endforeach
        </div>
    </div>
    @endif

    @if($showMargin)
    <!-- MARGIN ROW -->
    <div class="flex items-center gap-2 pt-1 border-t border-slate-200/60 dark:border-slate-800/60">
        <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400 w-14 shrink-0">Margin</span>
        <div class="flex items-center gap-2 flex-1">
            <div class="flex items-center gap-1 flex-1">
                <span class="text-[9px] font-bold text-slate-400">Top:</span>
                <input type="text" x-model="mTop" @input.debounce.250ms="sync()" placeholder="0px"
                       class="w-full text-center px-1.5 py-0.5 text-xs font-mono font-bold rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
            </div>
            <div class="flex items-center gap-1 flex-1">
                <span class="text-[9px] font-bold text-slate-400">Bottom:</span>
                <input type="text" x-model="mBottom" @input.debounce.250ms="sync()" placeholder="0px"
                       class="w-full text-center px-1.5 py-0.5 text-xs font-mono font-bold rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
            </div>
            <label class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 cursor-pointer select-none">
                <input type="checkbox" x-model="mCenter" @change="sync()" class="w-3.5 h-3.5 rounded text-[#003C58]">
                <span>Center Auto</span>
            </label>
        </div>
    </div>
    @endif

    @if($showBorder)
    <!-- BORDER ROW -->
    <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-slate-200/60 dark:border-slate-800/60 text-xs">
        <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400 w-14 shrink-0">Border</span>

        <div class="flex flex-wrap items-center gap-1.5 flex-1">
            <!-- Width -->
            <select x-model="bWidth" @change="sync()"
                    class="px-2 py-0.5 text-[11px] font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                <option value="0px">None (0px)</option>
                <option value="1px">1px</option>
                <option value="2px">2px</option>
                <option value="3px">3px</option>
                <option value="4px">4px</option>
            </select>

            <!-- Side -->
            <select x-model="bSide" @change="sync()"
                    class="px-2 py-0.5 text-[11px] font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                <option value="bottom">Bottom Only</option>
                <option value="top">Top Only</option>
                <option value="all">All Sides</option>
                <option value="y">Top &amp; Bottom</option>
            </select>

            <!-- Style -->
            <select x-model="bStyle" @change="sync()"
                    class="px-2 py-0.5 text-[11px] font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
                <option value="solid">Solid</option>
                <option value="dashed">Dashed</option>
                <option value="dotted">Dotted</option>
            </select>

            <!-- Color Swatch -->
            <div class="flex items-center gap-1 bg-white dark:bg-slate-900 px-1 py-0.5 rounded-lg border border-slate-300 dark:border-slate-700">
                <input type="color" x-model="bColor" @input="sync()" class="w-4 h-4 rounded cursor-pointer border-0 p-0 bg-transparent">
                <input type="text" x-model="bColor" @input.debounce.250ms="sync()" class="w-14 text-[10px] font-mono uppercase bg-transparent border-0 p-0 text-slate-800 dark:text-slate-200">
            </div>

            <!-- Radius -->
            <div class="flex items-center gap-1">
                <span class="text-[9px] font-bold text-slate-400">Rad:</span>
                <input type="text" x-model="bRadius" @input.debounce.250ms="sync()" placeholder="0px"
                       class="w-12 px-1 py-0.5 text-[10px] font-mono text-center rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-white">
            </div>
        </div>
    </div>
    @endif

    @if($showWidth)
    <!-- CONTAINER WIDTH SELECTOR (Elementor Style) -->
    <div class="flex items-center gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
        <span class="text-xs font-bold text-slate-700 dark:text-slate-300 w-24 shrink-0">Row Width</span>
        <select x-model="width" @change="sync()"
                class="flex-1 px-3 py-1.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white cursor-pointer focus:ring-1 focus:ring-[#003C58]">
            <option value="100%">100% Fluid Full Width</option>
            <option value="1536px">Ultra Wide (1536px - Recommended)</option>
            <option value="1440px">Corporate Wide (1440px)</option>
            <option value="1280px">Standard Boxed (1280px)</option>
            <option value="1680px">Panoramic (1680px)</option>
        </select>
    </div>
    @endif

</div>
