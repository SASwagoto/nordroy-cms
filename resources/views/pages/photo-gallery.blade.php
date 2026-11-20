<x-layouts.frontend title="{{ __('Photo Gallery') }} | Nordroy Marine">

    @php
        $bgStyle = \App\Models\Setting::get('photo_gallery_header_bg', 'transparent');
        $frostedOpacity = max(10, min(90, (int) \App\Models\Setting::get('photo_gallery_header_frosted_opacity', 80)));
        $opacityDecimal = $frostedOpacity / 100;

        $customLightBg = \App\Models\Setting::get('photo_gallery_light_bg', '#ffffff');
        $customDarkBg = \App\Models\Setting::get('photo_gallery_dark_bg', '#07131e');
        $customLightText = \App\Models\Setting::get('photo_gallery_light_text', '#0f172a');
        $customDarkText = \App\Models\Setting::get('photo_gallery_dark_text', '#f8fafc');

        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'header-frosted-photos backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            'custom'   => 'header-custom-photos',
            default    => 'bg-transparent',
        };

        // Layout & Display Controls
        $colsSetting = \App\Models\Setting::get('photo_gallery_grid_cols', '4');
        $perPage = \App\Models\Setting::get('photo_gallery_per_page', '24');
        $showAlbums = (bool) \App\Models\Setting::get('photo_gallery_show_albums', true);
        $showCaptions = (bool) \App\Models\Setting::get('photo_gallery_show_captions', true);

        $gridColsClass = match($colsSetting) {
            '2'     => 'grid-cols-1 sm:grid-cols-2',
            '3'     => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3',
            '5'     => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
            default => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
        };

        $photosToDisplay = ($perPage !== 'all') ? $photos->take((int) $perPage) : $photos;
    @endphp

    @if($bgStyle === 'frosted')
        <style>
            .header-frosted-photos { background-color: rgba(255, 255, 255, {{ $opacityDecimal }}); }
            .dark .header-frosted-photos { background-color: rgba(7, 19, 30, {{ $opacityDecimal }}); }
        </style>
    @elseif($bgStyle === 'custom')
        <style>
            .header-custom-photos { background-color: {{ $customLightBg }}; color: {{ $customLightText }}; }
            .header-custom-photos h1, .header-custom-photos p { color: {{ $customLightText }}; }
            .dark .header-custom-photos { background-color: {{ $customDarkBg }}; color: {{ $customDarkText }}; }
            .dark .header-custom-photos h1, .dark .header-custom-photos p { color: {{ $customDarkText }}; }
        </style>
    @endif

    <!-- Alpine State Container for Album Filtering & Fullscreen Lightbox -->
    <div x-data="{
            activeAlbum: '{{ $currentAlbum?->slug ?? 'all' }}',
            
            // Lightbox state
            isLightboxOpen: false,
            lightboxImage: '',
            lightboxTitle: '',
            lightboxCaption: '',
            lightboxIndex: 0,
            lightboxPhotos: [],

            init() {
                this.lightboxPhotos = @js($photosToDisplay->map(fn($p) => [
                    'id'      => $p->id,
                    'url'     => $p->image_url,
                    'title'   => $p->display_title,
                    'caption' => $p->display_caption,
                    'album'   => $p->album?->slug ?? 'all',
                ]));
            },

            openLightbox(index) {
                const p = this.filteredPhotos[index];
                if (!p) return;
                this.lightboxIndex = index;
                this.lightboxImage = p.url;
                this.lightboxTitle = p.title;
                this.lightboxCaption = p.caption;
                this.isLightboxOpen = true;
            },

            nextPhoto() {
                if (this.filteredPhotos.length === 0) return;
                this.lightboxIndex = (this.lightboxIndex + 1) % this.filteredPhotos.length;
                this.openLightbox(this.lightboxIndex);
            },

            prevPhoto() {
                if (this.filteredPhotos.length === 0) return;
                this.lightboxIndex = (this.lightboxIndex - 1 + this.filteredPhotos.length) % this.filteredPhotos.length;
                this.openLightbox(this.lightboxIndex);
            },

            get filteredPhotos() {
                if (this.activeAlbum === 'all') return this.lightboxPhotos;
                return this.lightboxPhotos.filter(p => p.album === this.activeAlbum);
            }
         }"
         @keydown.escape.window="isLightboxOpen = false"
         @keydown.arrow-right.window="if(isLightboxOpen) nextPhoto()"
         @keydown.arrow-left.window="if(isLightboxOpen) prevPhoto()">

        <!-- Hero Header -->
        <section class="pt-24 pb-10 sm:pt-28 sm:pb-14 {{ $headerBgClasses }} border-b border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-4">
                
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">{{ __('Home') }}</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-slate-800 dark:text-slate-200 font-bold">{{ __('Photo Gallery') }}</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pt-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20">
                                {{ \App\Models\Setting::get('photo_gallery_badge', __('Visual Showcase')) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                &bull; {{ $photosToDisplay->count() }} {{ __('Curated Photos') }}
                            </span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
                            {{ \App\Models\Setting::get('photo_gallery_title', __('Marine Engineering & Overhaul Photo Gallery')) }}
                        </h1>
                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl leading-relaxed">
                            {{ \App\Models\Setting::get('photo_gallery_subtitle', __('Photographic documentation of our dynamic balancing procedures, high-precision rotor overhauls, ultrasonic chemical decarbonization, and emergency ship engine room interventions.')) }}
                        </p>
                    </div>

                    <!-- Direct Switch to Video Gallery -->
                    <div class="shrink-0">
                        <a href="{{ route('video-gallery') }}" 
                           class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-all inline-flex items-center gap-2 shadow-2xs">
                            <x-icon name="solid:video" class="w-4 h-4 text-rose-500" />
                            <span>{{ __('Switch to Video Gallery') }} &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Album / Category Filter Pills (Conditional) -->
                @if($showAlbums && $albums->count() > 0)
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-1">{{ __('Filter Album:') }}</span>
                        
                        <button type="button" @click="activeAlbum = 'all'"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer"
                                :class="activeAlbum === 'all' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'">
                            {{ __('All Photos') }} ({{ $photosToDisplay->count() }})
                        </button>

                        @foreach($albums as $album)
                            <button type="button" @click="activeAlbum = '{{ $album->slug }}'"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer flex items-center gap-1.5"
                                    :class="activeAlbum === '{{ $album->slug }}' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'">
                                <span>{{ $album->display_name }}</span>
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-mono"
                                      :class="activeAlbum === '{{ $album->slug }}' ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500'">
                                    {{ $album->photos_count }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

        <!-- Main Photo Showcase Grid -->
        <section class="py-12 sm:py-16 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors min-h-[60vh]">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">

                @if($photosToDisplay->count() > 0)
                    <div class="grid {{ $gridColsClass }} gap-6">
                        @foreach($photosToDisplay as $index => $photo)
                            <div wire:key="public-photo-{{ $photo->id }}"
                                 x-show="activeAlbum === 'all' || activeAlbum === '{{ $photo->album?->slug }}'"
                                 @click="openLightbox({{ $index }})"
                                 class="group relative rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl transition-all cursor-pointer flex flex-col">
                                
                                <div class="relative aspect-4/3 overflow-hidden bg-slate-900">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->display_title }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                                    
                                    <!-- Hover Overlay with Magnifying Glass -->
                                    <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <div class="w-11 h-11 rounded-full bg-white/90 text-slate-900 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                            <x-icon name="solid:magnifying-glass-plus" class="w-5 h-5" />
                                        </div>
                                    </div>

                                    @if($photo->album)
                                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/75 text-white backdrop-blur-xs truncate max-w-[85%]">
                                            {{ $photo->album->display_name }}
                                        </span>
                                    @endif
                                </div>

                                @if($showCaptions)
                                    <div class="p-4 space-y-1">
                                        <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                            {{ $photo->display_title }}
                                        </h3>
                                        @if(!empty($photo->display_caption))
                                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">
                                                {{ $photo->display_caption }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-slate-400 text-xs">
                        {{ __('No photos currently cataloged in this album.') }}
                    </div>
                @endif

            </div>
        </section>

        <!-- ==================== FULLSCREEN LIGHTBOX MODAL ==================== -->
        <div x-show="isLightboxOpen" 
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
             style="display: none;"
             role="dialog">
            
            <button type="button" @click="isLightboxOpen = false" 
                    class="absolute top-5 right-5 p-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-lg transition-colors cursor-pointer z-50">
                <x-icon name="solid:xmark" class="w-6 h-6" />
            </button>

            <!-- Navigation Controls -->
            <button type="button" @click="prevPhoto()" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors cursor-pointer z-50">
                <x-icon name="solid:chevron-left" class="w-6 h-6" />
            </button>
            <button type="button" @click="nextPhoto()" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors cursor-pointer z-50">
                <x-icon name="solid:chevron-right" class="w-6 h-6" />
            </button>

            <!-- Lightbox Frame -->
            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center justify-center text-center space-y-3" @click.outside="isLightboxOpen = false">
                <img :src="lightboxImage" :alt="lightboxTitle" 
                     class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl">
                
                <div class="text-white space-y-1">
                    <h3 class="text-base font-bold" x-text="lightboxTitle"></h3>
                    <p class="text-xs text-slate-300 max-w-lg" x-text="lightboxCaption" x-show="lightboxCaption"></p>
                </div>
            </div>
        </div>

    </div>

</x-layouts.frontend>
