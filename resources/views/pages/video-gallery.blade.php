<x-layouts.frontend title="{{ __('Video Gallery') }} | Nordroy Marine">

    @php
        $bgStyle = \App\Models\Setting::get('video_gallery_header_bg', 'transparent');
        $headerBgClasses = match($bgStyle) {
            'frosted'  => 'bg-white/80 dark:bg-[#07131e]/80 backdrop-blur-md',
            'solid'    => 'bg-white dark:bg-[#07131e]',
            'slate'    => 'bg-slate-100 dark:bg-slate-900',
            'gradient' => 'bg-gradient-to-b from-slate-100/90 via-slate-50/50 to-transparent dark:from-[#0b1b2b] dark:via-[#07131e]/60 dark:to-transparent',
            default    => 'bg-transparent',
        };
    @endphp

    <!-- Alpine State Container for Video Filtering & Responsive Popup Player -->
    <div x-data="{
            activeAlbum: '{{ $currentAlbum?->slug ?? 'all' }}',
            
            // Video player modal state
            isVideoModalOpen: false,
            videoEmbedUrl: '',
            videoTitle: '',
            videoDescription: '',

            openVideo(embedUrl, title, desc) {
                if (!embedUrl) return;
                this.videoEmbedUrl = embedUrl + (embedUrl.includes('?') ? '&autoplay=1' : '?autoplay=1');
                this.videoTitle = title;
                this.videoDescription = desc;
                this.isVideoModalOpen = true;
            },

            closeVideo() {
                this.isVideoModalOpen = false;
                this.videoEmbedUrl = '';
            }
         }"
         @keydown.escape.window="closeVideo()">

        <!-- Hero Header -->
        <section class="pt-24 pb-10 sm:pt-28 sm:pb-14 {{ $headerBgClasses }} border-b border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 space-y-4">
                
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">{{ __('Home') }}</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-slate-800 dark:text-slate-200 font-bold">{{ __('Video Gallery') }}</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pt-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                {{ \App\Models\Setting::get('video_gallery_badge', __('Video Showcase')) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                &bull; {{ $videos->count() }} {{ __('Curated Videos') }}
                            </span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
                            {{ \App\Models\Setting::get('video_gallery_title', __('Marine Engineering & Turbocharger Video Gallery')) }}
                        </h1>
                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-3xl leading-relaxed">
                            {{ \App\Models\Setting::get('video_gallery_subtitle', __('Watch live recorded procedures of dynamic balancing, complete turbocharger overhauls, shipyard flying squad interventions, and workshop precision engineering.')) }}
                        </p>
                    </div>

                    <!-- Direct Switch to Photo Gallery -->
                    <div class="shrink-0">
                        <a href="{{ route('photo-gallery') }}" 
                           class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-all inline-flex items-center gap-2 shadow-2xs">
                            <x-icon name="solid:images" class="w-4 h-4 text-cyan-500" />
                            <span>{{ __('Switch to Photo Gallery') }} &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Video Album / Category Filter Pills -->
                @if($albums->count() > 0)
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-1">{{ __('Filter Album:') }}</span>

                        <button type="button" @click="activeAlbum = 'all'"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer"
                                :class="activeAlbum === 'all' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'">
                            {{ __('All Videos') }} ({{ $videos->count() }})
                        </button>

                        @foreach($albums as $album)
                            <button type="button" @click="activeAlbum = '{{ $album->slug }}'"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer flex items-center gap-1.5"
                                    :class="activeAlbum === '{{ $album->slug }}' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800'">
                                <span>{{ $album->display_name }}</span>
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-mono"
                                      :class="activeAlbum === '{{ $album->slug }}' ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500'">
                                    {{ $album->videos_count }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

        <!-- Main Video Showcase Grid -->
        <section class="py-12 sm:py-16 bg-slate-50 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 transition-colors min-h-[60vh]">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">

                @if($videos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                        @foreach($videos as $video)
                            <div wire:key="public-video-{{ $video->id }}"
                                 x-show="activeAlbum === 'all' || activeAlbum === '{{ $video->album?->slug }}'"
                                 class="group rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-xl transition-all flex flex-col">
                                
                                <!-- Video Thumbnail & Play Trigger -->
                                <div class="relative aspect-video overflow-hidden bg-slate-900 cursor-pointer"
                                     @click="openVideo('{{ $video->embed_url }}', @js($video->display_title), @js($video->display_description))">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->display_title }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    
                                    <!-- Dark Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/30"></div>

                                    <!-- YouTube Pulsing Play Button -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-14 h-14 rounded-full bg-rose-600/90 text-white flex items-center justify-center shadow-xl group-hover:scale-115 group-hover:bg-rose-600 transition-all">
                                            <x-icon name="solid:play" class="w-6 h-6 fill-current ml-0.5" />
                                        </div>
                                    </div>

                                    <!-- Badges: Album & YouTube -->
                                    <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                        @if($video->album)
                                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/75 text-white backdrop-blur-xs">
                                                {{ $video->album->display_name }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="absolute bottom-3 right-3">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-600 text-white flex items-center gap-1">
                                            <x-icon name="solid:video" class="w-3 h-3" />
                                            <span>HD</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Video Metadata & Description -->
                                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                    <div class="space-y-2">
                                        <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2 hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-pointer"
                                            @click="openVideo('{{ $video->embed_url }}', @js($video->display_title), @js($video->display_description))">
                                            {{ $video->display_title }}
                                        </h3>
                                        
                                        @if(!empty($video->display_description))
                                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                                {{ Str::limit(strip_tags($video->display_description), 130) }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Footer Actions: Watch Modal vs Open on YouTube -->
                                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs">
                                        <button type="button" 
                                                @click="openVideo('{{ $video->embed_url }}', @js($video->display_title), @js($video->display_description))"
                                                class="font-bold text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 flex items-center gap-1.5 cursor-pointer">
                                            <x-icon name="solid:play" class="w-3.5 h-3.5 fill-current" />
                                            <span>{{ __('Watch Video') }}</span>
                                        </button>

                                        @if(!empty($video->youtube_url))
                                            <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" 
                                               class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-[11px] flex items-center gap-1 transition-colors">
                                                <span>{{ __('YouTube') }}</span>
                                                <x-icon name="solid:arrow-top-right-on-square" class="w-3 h-3" />
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-slate-400 text-xs">
                        {{ __('No video presentations available in this album.') }}
                    </div>
                @endif

            </div>
        </section>

        <!-- ==================== RESPONSIVE VIDEO POPUP PLAYER MODAL ==================== -->
        <div x-show="isVideoModalOpen" 
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-md"
             style="display: none;"
             role="dialog">
            
            <!-- Close Button -->
            <button type="button" @click="closeVideo()" 
                    class="absolute top-5 right-5 p-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-lg transition-colors cursor-pointer z-50">
                <x-icon name="solid:xmark" class="w-6 h-6" />
            </button>

            <!-- Modal Card -->
            <div class="w-full max-w-4xl bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 shadow-2xl space-y-4 p-4 sm:p-6"
                 @click.outside="closeVideo()">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-white truncate pr-4" x-text="videoTitle"></h3>
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

                <div x-show="videoDescription" class="text-xs text-slate-300 leading-relaxed pt-2 max-h-48 overflow-y-auto no-scrollbar">
                    <div x-html="videoDescription" class="prose prose-invert prose-xs max-w-none"></div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.frontend>
