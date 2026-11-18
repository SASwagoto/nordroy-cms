<x-layouts.frontend title="{{ __('Media Gallery & Visual Showcase') }} | Nordroy Marine">

    <!-- Alpine State Container for Filtering, Lightbox & Video Player -->
    <div x-data="{
            activeType: '{{ $currentType ?? 'all' }}',
            activeAlbum: '{{ $currentAlbum?->slug ?? 'all' }}',
            
            // Lightbox state
            isLightboxOpen: false,
            lightboxImage: '',
            lightboxTitle: '',
            lightboxCaption: '',
            lightboxIndex: 0,
            lightboxPhotos: [],

            // Video player modal state
            isVideoModalOpen: false,
            videoEmbedUrl: '',
            videoTitle: '',
            videoDescription: '',

            init() {
                this.lightboxPhotos = @js($photos->map(fn($p) => [
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

            openVideo(embedUrl, title, desc) {
                this.videoEmbedUrl = embedUrl + (embedUrl.includes('?') ? '&autoplay=1' : '?autoplay=1');
                this.videoTitle = title;
                this.videoDescription = desc;
                this.isVideoModalOpen = true;
            },

            closeVideo() {
                this.isVideoModalOpen = false;
                this.videoEmbedUrl = '';
            },

            get filteredPhotos() {
                if (this.activeAlbum === 'all') return this.lightboxPhotos;
                return this.lightboxPhotos.filter(p => p.album === this.activeAlbum);
            }
         }"
         @keydown.escape.window="isLightboxOpen = false; closeVideo()"
         @keydown.arrow-right.window="if(isLightboxOpen) nextPhoto()"
         @keydown.arrow-left.window="if(isLightboxOpen) prevPhoto()">

        <!-- Hero Header -->
        <section class="pt-24 pb-12 sm:pt-28 sm:pb-16 bg-white dark:bg-[#07131e] border-b border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-4">
                
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">{{ __('Home') }}</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-slate-800 dark:text-slate-200 font-bold">{{ __('Media Gallery') }}</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pt-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/20">
                                {{ __('Visual Showcase') }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                &bull; {{ $photos->count() }} {{ __('Photos') }} &amp; {{ $videos->count() }} {{ __('Videos') }}
                            </span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
                            {{ __('Marine Engineering & Overhaul Gallery') }}
                        </h1>
                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl leading-relaxed">
                            {{ __('Explore live photographic documentation and video recordings from our high-precision turbocharger overhaul workshops, dynamic balancing benches, and emergency ship attendance operations.') }}
                        </p>
                    </div>

                    <!-- Media Type Filter Buttons (All / Photos / Videos) -->
                    <div class="flex items-center p-1 rounded-2xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shrink-0">
                        <button type="button" @click="activeType = 'all'"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                                :class="activeType === 'all' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                            <x-icon name="solid:layer-group" class="w-3.5 h-3.5" />
                            <span>{{ __('All Media') }}</span>
                        </button>
                        <button type="button" @click="activeType = 'photos'"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                                :class="activeType === 'photos' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                            <x-icon name="solid:images" class="w-3.5 h-3.5" />
                            <span>{{ __('Photos') }} ({{ $photos->count() }})</span>
                        </button>
                        <button type="button" @click="activeType = 'videos'"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5"
                                :class="activeType === 'videos' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                            <x-icon name="solid:video" class="w-3.5 h-3.5 text-rose-500" />
                            <span>{{ __('Videos') }} ({{ $videos->count() }})</span>
                        </button>
                    </div>
                </div>

                <!-- Album / Category Filter Pills -->
                @if($albums->count() > 0)
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-1">{{ __('Filter by Album:') }}</span>
                        
                        <button type="button" @click="activeAlbum = 'all'"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer"
                                :class="activeAlbum === 'all' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'">
                            {{ __('All Albums') }}
                        </button>

                        @foreach($albums as $album)
                            <button type="button" @click="activeAlbum = '{{ $album->slug }}'"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer flex items-center gap-1.5"
                                    :class="activeAlbum === '{{ $album->slug }}' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'">
                                <span>{{ $album->display_name }}</span>
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-mono"
                                      :class="activeAlbum === '{{ $album->slug }}' ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500'">
                                    {{ $album->photos_count + $album->videos_count }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

        <!-- Main Gallery Content Grid -->
        <section class="py-12 sm:py-16 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors min-h-[60vh]">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-12">

                <!-- 1. VIDEO GALLERY SECTION -->
                <div x-show="activeType === 'all' || activeType === 'videos'" class="space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center">
                                <x-icon name="solid:video" class="w-4 h-4" />
                            </div>
                            <h2 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                {{ __('Video Portfolio & Overhaul Demonstrations') }}
                            </h2>
                        </div>
                    </div>

                    @if($videos->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($videos as $video)
                                <div wire:key="public-video-{{ $video->id }}"
                                     x-show="activeAlbum === 'all' || activeAlbum === '{{ $video->album?->slug }}'"
                                     class="group rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl transition-all flex flex-col">
                                    
                                    <!-- Thumbnail with Play Button -->
                                    <div class="relative aspect-video bg-black overflow-hidden cursor-pointer"
                                         @click="openVideo('{{ $video->embed_url }}', @js($video->display_title), @js($video->display_description))">
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->display_title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        
                                        <!-- Play overlay -->
                                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/60 transition-colors flex items-center justify-center">
                                            <div class="w-14 h-14 rounded-full bg-rose-600 text-white flex items-center justify-center shadow-2xl group-hover:scale-115 transition-transform duration-300">
                                                <x-icon name="solid:play" class="w-6 h-6 fill-current ml-0.5" />
                                            </div>
                                        </div>

                                        <span class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded-lg bg-black/80 text-white text-[10px] font-mono font-bold flex items-center gap-1 backdrop-blur-xs">
                                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                            <span>YouTube</span>
                                        </span>

                                        @if($video->album)
                                            <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/70 text-white backdrop-blur-xs">
                                                {{ $video->album->display_name }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Video Info -->
                                    <div class="p-5 space-y-2 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors cursor-pointer"
                                                @click="openVideo('{{ $video->embed_url }}', @js($video->display_title), @js($video->display_description))">
                                                {{ $video->display_title }}
                                            </h3>
                                            @if(!empty($video->display_description))
                                                <div class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1.5 prose dark:prose-invert">
                                                    {!! strip_tags($video->display_description) !!}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs">
                                            <button type="button" 
                                                    @click="openVideo('{{ $video->embed_url }}', @js($video->display_title), @js($video->display_description))"
                                                    class="font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1 cursor-pointer">
                                                <x-icon name="solid:play" class="w-3 h-3 fill-current" />
                                                <span>{{ __('Watch Video') }}</span>
                                            </button>

                                            <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" 
                                               class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-[11px] flex items-center gap-1">
                                                <span>{{ __('Open in YouTube') }}</span>
                                                <x-icon name="solid:arrow-top-right-on-square" class="w-3 h-3" />
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-slate-400 text-xs">
                            {{ __('No video presentations available in this album.') }}
                        </div>
                    @endif
                </div>

                <!-- 2. PHOTO GALLERY SECTION (MASONRY-STYLE GRID WITH LIGHTBOX) -->
                <div x-show="activeType === 'all' || activeType === 'photos'" class="space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:images" class="w-4 h-4" />
                            </div>
                            <h2 class="text-xl font-bold font-heading text-slate-900 dark:text-white">
                                {{ __('Workshop & Precision Engineering Photography') }}
                            </h2>
                        </div>
                    </div>

                    @if($photos->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4 sm:gap-6">
                            @foreach($photos as $index => $photo)
                                <div wire:key="public-photo-{{ $photo->id }}"
                                     x-show="activeAlbum === 'all' || activeAlbum === '{{ $photo->album?->slug }}'"
                                     @click="openLightbox({{ $index }})"
                                     class="group relative rounded-2xl sm:rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl transition-all cursor-pointer flex flex-col">
                                    
                                    <div class="relative aspect-4/3 overflow-hidden bg-slate-900">
                                        <img src="{{ $photo->image_url }}" alt="{{ $photo->display_title }}" 
                                             loading="lazy"
                                             class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500">
                                        
                                        <!-- Hover Overlay with Magnifying Glass -->
                                        <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <div class="w-10 h-10 rounded-full bg-white/90 text-slate-900 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                                <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                                            </div>
                                        </div>

                                        @if($photo->album)
                                            <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-lg text-[9px] font-bold bg-black/70 text-white backdrop-blur-xs truncate max-w-[85%]">
                                                {{ $photo->album->display_name }}
                                            </span>
                                        @endif
                                    </div>

                                    @if(!empty($photo->display_title))
                                        <div class="p-3 sm:p-4">
                                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate">
                                                {{ $photo->display_title }}
                                            </h4>
                                            @if(!empty($photo->display_caption))
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate mt-0.5">
                                                    {{ $photo->display_caption }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-slate-400 text-xs">
                            {{ __('No photos currently cataloged in this album.') }}
                        </div>
                    @endif
                </div>

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
            
            <!-- Close Button -->
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

            <!-- Lightbox Main Frame -->
            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center justify-center text-center space-y-3" @click.outside="isLightboxOpen = false">
                <img :src="lightboxImage" :alt="lightboxTitle" 
                     class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl">
                
                <div class="text-white space-y-1">
                    <h3 class="text-base font-bold" x-text="lightboxTitle"></h3>
                    <p class="text-xs text-slate-300 max-w-lg" x-text="lightboxCaption" x-show="lightboxCaption"></p>
                </div>
            </div>
        </div>

        <!-- ==================== RESPONSIVE VIDEO POPUP PLAYER MODAL ==================== -->
        <div x-show="isVideoModalOpen" 
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
             style="display: none;"
             role="dialog">
            
            <button type="button" @click="closeVideo()" 
                    class="absolute top-5 right-5 p-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-lg transition-colors cursor-pointer z-50">
                <x-icon name="solid:xmark" class="w-6 h-6" />
            </button>

            <div class="w-full max-w-4xl bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 shadow-2xl space-y-4 p-4 sm:p-6"
                 @click.outside="closeVideo()">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-white truncate" x-text="videoTitle"></h3>
                </div>

                <div class="relative aspect-video rounded-2xl overflow-hidden bg-black shadow-inner">
                    <template x-if="isVideoModalOpen">
                        <iframe :src="videoEmbedUrl" 
                                class="w-full h-full" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </template>
                </div>

                <div x-show="videoDescription" class="text-xs text-slate-300 leading-relaxed pt-2">
                    <div x-html="videoDescription"></div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.frontend>
