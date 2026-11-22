@php
    $videosEnabled = (bool) \App\Models\Setting::get('home_videos_enabled', true);
    if (!$videosEnabled) return;

    $videosBadge = \App\Models\Setting::get('home_videos_badge', 'Workshop & Port In Action');
    $videosTitle = \App\Models\Setting::get('home_videos_title', 'Video Gallery (Hover to Play)');
    $videosSubtitle = \App\Models\Setting::get('home_videos_subtitle', 'Hover your mouse over any video card to stream a live silent preview of our precision balancing and overhaul operations.');
    $videosMode = \App\Models\Setting::get('home_videos_mode', 'static');
    $videosLimit = (int) \App\Models\Setting::get('home_videos_limit', 3);

    $dynamicVideos = collect();
    if ($videosMode === 'dynamic') {
        try {
            $dynamicVideos = \App\Models\VideoGallery::where('is_active', true)->take($videosLimit)->get();
        } catch (\Throwable $e) {
            $dynamicVideos = collect();
        }
    }
@endphp

<!-- =====================================================================
     VIDEO GALLERY WITH HOVER-TO-PLAY (Dana Group Style)
     ===================================================================== -->
<section id="videos" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
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
                                 alt="{{ $v->title }}"
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
                                <h4 class="text-sm font-bold font-heading text-slate-900 dark:text-white">{{ $v->title }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ Str::limit($v->description, 90) }}</p>
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
                <!-- Video Card 1 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group"
                     x-data="{ isHovered: false }">
                    <a href="{{ route('project.details', ['slug' => 'marine-vessel-turbocharger-overhaul']) }}"
                       class="relative aspect-video bg-slate-100 dark:bg-black overflow-hidden flex items-center justify-center cursor-pointer block"
                       @mouseenter="isHovered = true; $refs.video1.play()"
                       @mouseleave="isHovered = false; $refs.video1.pause(); $refs.video1.currentTime = 0">
                        
                        <video x-ref="video1" loop muted playsinline preload="metadata" 
                               class="w-full h-full object-cover">
                            <source src="{{ asset('assets/videos/background-marine.mp4') }}" type="video/mp4">
                        </video>

                        <img src="{{ asset('assets/images/gallery/gallery-balancing.webp') }}" 
                             alt="Dynamic Balancing Thumbnail"
                             x-show="!isHovered"
                             class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none transition-opacity duration-150" />

                        <div x-show="!isHovered" class="absolute inset-0 bg-slate-900/15 dark:bg-black/40 flex items-center justify-center transition-opacity pointer-events-none z-20">
                            <div class="w-12 h-12 rounded-full bg-white text-[#003C58] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <x-icon name="solid:play" class="w-4 h-4 translate-x-0.5" />
                            </div>
                        </div>

                        <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-white/95 dark:bg-black/80 text-[10px] font-mono font-medium text-slate-800 dark:text-white border border-slate-200/80 dark:border-transparent shadow-sm pointer-events-none z-20">
                            0:24 HD &bull; Hover to Preview
                        </div>
                    </a>

                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-widest">Schenck Dynamic Test</span>
                            <h4 class="text-sm font-bold font-heading text-slate-900 dark:text-white">
                                <a href="{{ route('project.details', ['slug' => 'marine-vessel-turbocharger-overhaul']) }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">
                                    Rotor Dynamic Balancing at 100,000 RPM
                                </a>
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Calibrated precision run on our computerized Schenck hard-bearing rig.</p>
                        </div>

                        <div class="pt-3 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs">
                            <a href="{{ route('project.details', ['slug' => 'marine-vessel-turbocharger-overhaul']) }}"
                               class="inline-flex items-center gap-1.5 font-bold text-red-600 dark:text-red-400 hover:underline">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                <span>Watch Video &amp; Case Study &rarr;</span>
                            </a>
                            <a href="{{ route('services') }}#balancing" class="font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                Details &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Video Card 2 -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group"
                     x-data="{ isHovered: false }">
                    <a href="{{ route('project.details', ['slug' => 'emergency-anchorage-flying-squad']) }}"
                       class="relative aspect-video bg-slate-100 dark:bg-black overflow-hidden flex items-center justify-center cursor-pointer block"
                       @mouseenter="isHovered = true; $refs.video2.play()"
                       @mouseleave="isHovered = false; $refs.video2.pause(); $refs.video2.currentTime = 0">
                        
                        <video x-ref="video2" loop muted playsinline preload="metadata" 
                               class="w-full h-full object-cover">
                            <source src="{{ asset('assets/videos/background-marine.mp4') }}" type="video/mp4">
                        </video>

                        <img src="{{ asset('assets/images/gallery/gallery-vessel.jpg') }}" 
                             alt="Vessel Boarding Thumbnail"
                             x-show="!isHovered"
                             class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none transition-opacity duration-150" />

                        <div x-show="!isHovered" class="absolute inset-0 bg-slate-900/15 dark:bg-black/40 flex items-center justify-center transition-opacity pointer-events-none z-20">
                            <div class="w-12 h-12 rounded-full bg-white text-[#003C58] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <x-icon name="solid:play" class="w-4 h-4 translate-x-0.5" />
                            </div>
                        </div>

                        <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-white/95 dark:bg-black/80 text-[10px] font-mono font-medium text-slate-800 dark:text-white border border-slate-200/80 dark:border-transparent shadow-sm pointer-events-none z-20">
                            0:32 HD &bull; Hover to Preview
                        </div>
                    </a>

                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-widest">Chattogram Port</span>
                            <h4 class="text-sm font-bold font-heading text-slate-900 dark:text-white">
                                <a href="{{ route('project.details', ['slug' => 'emergency-anchorage-flying-squad']) }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">
                                    Emergency Anchorage Flying Squad Operation
                                </a>
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Boarding an oceangoing bulk carrier for in-situ turbocharger inspection.</p>
                        </div>

                        <div class="pt-3 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs">
                            <a href="{{ route('project.details', ['slug' => 'emergency-anchorage-flying-squad']) }}"
                               class="inline-flex items-center gap-1.5 font-bold text-red-600 dark:text-red-400 hover:underline">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                <span>Watch Video &amp; Case Study &rarr;</span>
                            </a>
                            <a href="{{ route('projects') }}#projects" class="font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                Details &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Video Card 3 -->
                <div class="reveal-init reveal-fade-up reveal-delay-300 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group"
                     x-data="{ isHovered: false }">
                    <a href="{{ route('project.details', ['slug' => 'industrial-power-plant-balancing']) }}"
                       class="relative aspect-video bg-slate-100 dark:bg-black overflow-hidden flex items-center justify-center cursor-pointer block"
                       @mouseenter="isHovered = true; $refs.video3.play()"
                       @mouseleave="isHovered = false; $refs.video3.pause(); $refs.video3.currentTime = 0">
                        
                        <video x-ref="video3" loop muted playsinline preload="metadata" 
                               class="w-full h-full object-cover">
                            <source src="{{ asset('assets/videos/background-marine.mp4') }}" type="video/mp4">
                        </video>

                        <img src="{{ asset('assets/images/gallery/gallery-welding.webp') }}" 
                             alt="Welding Thumbnail"
                             x-show="!isHovered"
                             class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none transition-opacity duration-150" />

                        <div x-show="!isHovered" class="absolute inset-0 bg-slate-900/15 dark:bg-black/40 flex items-center justify-center transition-opacity pointer-events-none z-20">
                            <div class="w-12 h-12 rounded-full bg-white text-[#003C58] flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <x-icon name="solid:play" class="w-4 h-4 translate-x-0.5" />
                            </div>
                        </div>

                        <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-white/95 dark:bg-black/80 text-[10px] font-mono font-medium text-slate-800 dark:text-white border border-slate-200/80 dark:border-transparent shadow-sm pointer-events-none z-20">
                            0:18 HD &bull; Hover to Preview
                        </div>
                    </a>

                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 uppercase tracking-widest">Precision Metallurgical</span>
                            <h4 class="text-sm font-bold font-heading text-slate-900 dark:text-white">
                                <a href="{{ route('project.details', ['slug' => 'industrial-power-plant-balancing']) }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">
                                    Micro-TIG Blade Reconstruction &amp; Polishing
                                </a>
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Restoration of eroded turbine blade aerofoil geometry and shroud rings.</p>
                        </div>

                        <div class="pt-3 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs">
                            <a href="{{ route('project.details', ['slug' => 'industrial-power-plant-balancing']) }}"
                               class="inline-flex items-center gap-1.5 font-bold text-red-600 dark:text-red-400 hover:underline">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                <span>Watch Video &amp; Case Study &rarr;</span>
                            </a>
                            <a href="{{ route('services') }}#overhaul" class="font-bold text-[#003C58] dark:text-cyan-400 hover:underline">
                                Details &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</section>
