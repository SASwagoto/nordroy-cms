<div class="space-y-6">
    <!-- Hero Banner Top Action Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 flex items-center justify-center shrink-0">
                <x-icon name="solid:images" class="w-5 h-5" />
            </span>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">{{ $heroTitle }}</h2>
                    <span class="px-2 py-0.5 text-[9px] font-bold rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-400">Fixed Below Header</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400">High-impact hero visual showcase with ambient background video, slides, and trust indicators</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" wire:click="toggleSectionStatus('hero')"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold border transition-colors flex items-center gap-1.5 {{ $heroEnabled ? 'bg-emerald-50 border-emerald-300 text-emerald-700 dark:bg-emerald-950/40 dark:border-emerald-600 dark:text-emerald-300' : 'bg-slate-100 border-slate-300 text-slate-600 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400' }}">
                <x-icon name="{{ $heroEnabled ? 'solid:eye' : 'solid:eye-slash' }}" class="w-3.5 h-3.5" />
                <span>{{ $heroEnabled ? 'Hero Visible' : 'Hero Hidden' }}</span>
            </button>

            <button type="button" wire:click="save"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-xs cursor-pointer">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Hero</span>
            </button>
        </div>
    </div>

    <!-- 1. Universal Layout & Surface Engine for Hero -->
    <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
            <div class="flex items-center gap-2">
                <x-icon name="solid:layer-group" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Hero Layout &amp; Ambient Surface</h3>
            </div>
            <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400 uppercase">Universal Engine</span>
        </div>

        <!-- Hero Presentation Style & Container Width -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Hero Presentation Style</label>
                <select wire:model.live="heroLayout.hero_style" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    <option value="split">🚢 Industrial Split Showcase (Turbo Copy Left + Precision Rotor Dial Right)</option>
                    <option value="slider">🎞️ Fullscreen Carousel Slider (Multiple Photography Slides &amp; Dual CTAs)</option>
                    <option value="video">🎬 Ambient Video Player (Looping YouTube with Dark Frosted Overlay)</option>
                    <option value="minimal">🏢 Minimal Corporate (Clean Centered Typography &amp; Quick Action Buttons)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Container Width</label>
                <select wire:model.live="heroLayout.width" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    <option value="container-fluid">Container Fluid (100% Full Width Edge-to-Edge)</option>
                    <option value="container-panoramic">Panoramic Max-Width (1680px)</option>
                    <option value="container-xl">Standard Boxed (1440px)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Background Type</label>
                <select wire:model.live="heroLayout.bg_type" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    <option value="video">🎬 Ambient Video Background (YouTube)</option>
                    <option value="image">🖼️ Image Background (Upload / URL)</option>
                    <option value="gradient">🌈 CSS3 Multicolor Gradient</option>
                    <option value="color">🎨 Solid Color</option>
                </select>
            </div>
        </div>

        <!-- Ambient Video Controls (When bg_type == 'video') -->
        @if (($heroLayout['bg_type'] ?? 'video') === 'video')
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                        <x-icon name="solid:circle-play" class="w-4 h-4 text-rose-500" />
                        <span>Ambient YouTube Video Player</span>
                    </span>
                    <span class="text-[10px] text-slate-400">Autoplays muted in infinite loop</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">YouTube Video URL or Video ID</label>
                        <input type="text" wire:model.live="heroLayout.bg_video_url" placeholder="https://www.youtube.com/watch?v=kJQP7kiw5Fk"
                               class="w-full px-3 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Overlay Opacity ({{ $heroLayout['bg_video_overlay_opacity'] ?? '0.75' }})</label>
                            <input type="range" wire:model.live="heroLayout.bg_video_overlay_opacity" min="0" max="1" step="0.05" class="w-full">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Overlay Color</label>
                            <input type="text" wire:model.live="heroLayout.bg_video_overlay_color" class="w-24 px-2 py-1 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Spacing & Padding Controls -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
            <div>
                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Top Padding</label>
                <input type="text" wire:model.live="heroLayout.padding_top" placeholder="80px" class="w-full px-3 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Bottom Padding</label>
                <input type="text" wire:model.live="heroLayout.padding_bottom" placeholder="80px" class="w-full px-3 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Top Margin</label>
                <input type="text" wire:model.live="heroLayout.margin_top" placeholder="0px" class="w-full px-3 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Bottom Margin</label>
                <input type="text" wire:model.live="heroLayout.margin_bottom" placeholder="0px" class="w-full px-3 py-1.5 text-xs font-mono rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
            </div>
        </div>
    </div>

    <!-- 2. Hero Slides & Content Repeater -->
    <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Hero Slides &amp; Headlines</h3>
                <p class="text-xs text-slate-500">Configure prominent value propositions, slide photography, calls-to-action, and badges</p>
            </div>
            <button type="button" wire:click="addHeroSlide"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                <span>Add Slide</span>
            </button>
        </div>

        <div class="space-y-4">
            @foreach ($heroSlides as $sIdx => $slide)
                <div wire:key="hero-slide-{{ $sIdx }}" class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Slide #{{ $sIdx + 1 }}</span>
                        @if (count($heroSlides) > 1)
                            <button type="button" wire:click="removeHeroSlide({{ $sIdx }})" class="text-xs text-rose-500 hover:text-rose-600 font-semibold cursor-pointer">
                                Remove Slide
                            </button>
                        @endif
                    </div>

                    <!-- Slide Background Image Selector -->
                    <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="w-20 h-14 rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden shrink-0">
                            @if (!empty($slide['image_url']))
                                <img src="{{ asset($slide['image_url']) }}" class="w-full h-full object-cover">
                            @else
                                <x-icon name="solid:image" class="w-6 h-6 text-slate-400" />
                            @endif
                        </div>
                        <div class="flex-1 space-y-1">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase">Slide Background Photography</label>
                            <div class="flex items-center gap-2">
                                <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.image_url" placeholder="assets/images/gallery/gallery-vessel.jpg" class="flex-1 px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                <button type="button" 
                                        @click="$dispatch('open-media-picker', { targetField: 'heroSlides', targetIndex: {{ $sIdx }} })"
                                        class="px-2.5 py-1 rounded-lg text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors shrink-0 cursor-pointer">
                                    Browse Library
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Headline Text</label>
                            <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.headline" class="w-full px-3 py-2 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 mb-1">Subtitle / Description</label>
                            <textarea wire:model.live="heroSlides.{{ $sIdx }}.subtitle" rows="2" class="w-full px-3 py-2 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Pill Badge Text</label>
                                <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.badge" placeholder="e.g. DNV Certified" class="w-full px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">CTA 1 (Label &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.cta1.text" placeholder="Explore Services" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.cta1.url" placeholder="/services" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">CTA 2 (Label &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.cta2.text" placeholder="Request RFQ" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <input type="text" wire:model.live="heroSlides.{{ $sIdx }}.cta2.url" placeholder="/#rfq" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Floating Trust Overlay Cards -->
    <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Floating Trust &amp; Performance Badges</h3>
                <p class="text-xs text-slate-500">Credibility cards overlaid at the bottom rim of the hero section</p>
            </div>
            <button type="button" wire:click="addHeroOverlayCard"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1.5 cursor-pointer">
                <x-icon name="solid:circle-plus" class="w-3.5 h-3.5" />
                <span>Add Card</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @foreach ($heroOverlayCards as $cIdx => $card)
                <div wire:key="hero-card-{{ $cIdx }}" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-2">
                    <div class="flex items-center justify-between">
                        <button type="button" 
                                @click="$dispatch('open-icon-picker', { targetField: 'heroOverlayCards', targetIndex: {{ $cIdx }} })"
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-[10px] font-mono font-bold text-slate-700 dark:text-slate-300">
                            <x-icon :name="$card['icon'] ?: 'solid:award'" class="w-3 h-3 text-[#003C58] dark:text-cyan-400" />
                            <span>{{ $card['icon'] ?: 'Icon' }}</span>
                        </button>
                        <button type="button" wire:click="removeHeroOverlayCard({{ $cIdx }})" class="text-xs text-rose-500 hover:text-rose-600">
                            <x-icon name="solid:trash-can" class="w-3 h-3" />
                        </button>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Headline / Metric</label>
                        <input type="text" wire:model.live="heroOverlayCards.{{ $cIdx }}.title" class="w-full px-2 py-1 text-xs font-bold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-500 mb-0.5">Detail Subtext</label>
                        <input type="text" wire:model.live="heroOverlayCards.{{ $cIdx }}.detail" class="w-full px-2 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
