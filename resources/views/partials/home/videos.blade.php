@php
    $videosEnabled = (bool) \App\Models\Setting::get('home_videos_enabled', true);
    if (!$videosEnabled) return;

    $videosBadge = \App\Models\Setting::get('home_videos_badge', 'Workshop & Port In Action');
    $videosTitle = \App\Models\Setting::get('home_videos_title', 'Video Gallery (Hover to Play)');
    $videosSubtitle = \App\Models\Setting::get('home_videos_subtitle', 'Hover your mouse over any video card to stream a live silent preview of our precision balancing and overhaul operations.');
    $videosMode = \App\Models\Setting::get('home_videos_mode', 'static');
    $videosLimit = (int) \App\Models\Setting::get('home_videos_limit', 3);

    $align = \App\Models\Setting::get('home_videos_align', 'center');
    $headerAlignClass = match($align) {
        'left' => 'text-left mr-auto ml-0 items-start justify-start',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-center mx-auto items-center justify-center',
    };

    $dynamicVideos = collect();
    if ($videosMode === 'dynamic') {
        try {
            $dynamicVideos = \App\Models\VideoGallery::where('is_active', true)->take($videosLimit)->get();
        } catch (\Throwable $e) {
            $dynamicVideos = collect();
        }
    }

    $staticVideos = \App\Models\Setting::getJson('home_videos_static_items', []);
    if (empty($staticVideos)) {
        $staticVideos = [
            ['title' => '100,000 RPM Dynamic Balancing Operation', 'category' => 'ROTOR BALANCING', 'thumbnail_url' => 'assets/images/gallery/gallery-balancing.webp', 'video_url' => 'assets/videos/background-marine.mp4', 'link_url' => '/services#balancing'],
            ['title' => 'Micro-TIG Turbine Blade Reconstruction', 'category' => 'PRECISION WELDING', 'thumbnail_url' => 'assets/images/gallery/gallery-welding.webp', 'video_url' => 'assets/videos/background-marine.mp4', 'link_url' => '/services#overhaul'],
            ['title' => '24/7 Anchorage Flying Squad Deployment', 'category' => 'EMERGENCY OVERHAUL', 'thumbnail_url' => 'assets/images/gallery/gallery-flying-squad.webp', 'video_url' => 'assets/videos/background-marine.mp4', 'link_url' => '/contact#emergency'],
        ];
    }
@endphp

<!-- =====================================================================
     VIDEO GALLERY WITH HOVER-TO-PLAY (Dana Group Style)
     ===================================================================== -->
<x-section-styler-wrap sectionKey="videos" id="videos">
    
    <div class="max-w-3xl space-y-3 mb-16 {{ $headerAlignClass }}">
        <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 inline-block">
            {{ __($videosBadge) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
            {{ __($videosTitle) }}
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            {{ __($videosSubtitle) }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @if($videosMode === 'dynamic' && $dynamicVideos->isNotEmpty())
            @foreach($dynamicVideos as $idx => $v)
                <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx + 1) * 100 }} rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group"
                     x-data="{ isHovered: false }">
                    <div class="relative aspect-video bg-slate-100 dark:bg-black overflow-hidden flex items-center justify-center cursor-pointer block"
                         @mouseenter="isHovered = true; if($refs.dynVideo{{ $idx }}) $refs.dynVideo{{ $idx }}.play()"
                         @mouseleave="isHovered = false; if($refs.dynVideo{{ $idx }}) { $refs.dynVideo{{ $idx }}.pause(); $refs.dynVideo{{ $idx }}.currentTime = 0; }">
                        
                        <video x-ref="dynVideo{{ $idx }}" loop muted playsinline preload="metadata" 
                               class="w-full h-full object-cover">
                            <source src="{{ asset($v->video_file_url ?? 'assets/videos/background-marine.mp4') }}" type="video/mp4">
                        </video>

                        <img src="{{ asset($v->thumbnail_url ?: 'assets/images/gallery/gallery-balancing.webp') }}" 
                             alt="{{ $v->display_title ?? (is_array($v->title) ? ($v->title[app()->getLocale()] ?? reset($v->title)) : $v->title) }}"
                             x-show="!isHovered"
                             class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none transition-opacity duration-150" />

                        <div x-show="!isHovered" class="absolute inset-0 bg-slate-900/15 dark:bg-black/40 flex items-center justify-center transition-opacity pointer-events-none z-20">
                            <div class="w-12 h-12 rounded-full bg-white text-[#003C58] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <x-icon name="solid:play" class="w-4 h-4 translate-x-0.5" />
                            </div>
                        </div>
                    </div>

                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-widest">{{ $v->category ?? 'PROCEDURE' }}</span>
                            <h4 class="text-sm font-bold font-heading text-slate-900 dark:text-white">{{ $v->display_title ?? (is_array($v->title) ? ($v->title[app()->getLocale()] ?? reset($v->title)) : $v->title) }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ Str::limit($v->display_description ?? (is_array($v->description) ? ($v->description[app()->getLocale()] ?? reset($v->description)) : $v->description), 90) }}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs">
                            <a href="{{ route('video-gallery') }}" class="font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                Video Gallery &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @foreach($staticVideos as $idx => $v)
                <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx + 1) * 100 }} rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group"
                     x-data="{ isHovered: false }">
                    <a href="{{ $v['link_url'] ?? route('video-gallery') }}"
                       class="relative aspect-video bg-slate-100 dark:bg-black overflow-hidden flex items-center justify-center cursor-pointer block"
                       @mouseenter="isHovered = true; if($refs.statVideo{{ $idx }}) $refs.statVideo{{ $idx }}.play()"
                       @mouseleave="isHovered = false; if($refs.statVideo{{ $idx }}) { $refs.statVideo{{ $idx }}.pause(); $refs.statVideo{{ $idx }}.currentTime = 0; }">
                        
                        <video x-ref="statVideo{{ $idx }}" loop muted playsinline preload="metadata" 
                               class="w-full h-full object-cover">
                            <source src="{{ asset($v['video_url'] ?? 'assets/videos/background-marine.mp4') }}" type="video/mp4">
                        </video>

                        <img src="{{ asset($v['thumbnail_url'] ?? 'assets/images/gallery/gallery-balancing.webp') }}" 
                             alt="{{ $v['title'] ?? 'Video' }}"
                             x-show="!isHovered"
                             class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none transition-opacity duration-150" />

                        <div x-show="!isHovered" class="absolute inset-0 bg-slate-900/15 dark:bg-black/40 flex items-center justify-center transition-opacity pointer-events-none z-20">
                            <div class="w-12 h-12 rounded-full bg-white text-[#003C58] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <x-icon name="solid:play" class="w-4 h-4 translate-x-0.5" />
                            </div>
                        </div>
                    </a>

                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-widest">{{ $v['category'] ?? 'PROCEDURE' }}</span>
                            <h4 class="text-sm font-bold font-heading text-slate-900 dark:text-white">{{ $v['title'] ?? 'Workshop Video' }}</h4>
                        </div>
                        <div class="pt-3 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs">
                            <a href="{{ $v['link_url'] ?? route('video-gallery') }}" class="font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                Video Details &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</x-section-styler-wrap>