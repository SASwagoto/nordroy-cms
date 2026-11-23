@php
    $photosEnabled = (bool) \App\Models\Setting::get('home_photos_enabled', true);
    if (!$photosEnabled) return;

    $photosBadge = \App\Models\Setting::get('home_photos_badge', 'Visual Facilities');
    $photosTitle = \App\Models\Setting::get('home_photos_title', 'Workshop & Engineering Gallery');
    $photosSubtitle = \App\Models\Setting::get('home_photos_subtitle', 'Click on any photo below to inspect high-resolution images of our port workshops and overhaul facilities.');
    $photosMode = \App\Models\Setting::get('home_photos_mode', 'static');
    $photosLimit = (int) \App\Models\Setting::get('home_photos_limit', 8);

    $align = \App\Models\Setting::get('home_photos_align', 'center');
    $headerAlignClass = match($align) {
        'left' => 'text-left mr-auto ml-0 items-start justify-start',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-center mx-auto items-center justify-center',
    };

    $dynamicPhotos = collect();
    if ($photosMode === 'dynamic') {
        try {
            $dynamicPhotos = \App\Models\PhotoGallery::where('is_active', true)->take($photosLimit)->get();
        } catch (\Throwable $e) {
            $dynamicPhotos = collect();
        }
    }

    $staticPhotos = \App\Models\Setting::getJson('home_photos_static_items', []);
    if (empty($staticPhotos)) {
        $staticPhotos = [
            ['title' => 'Dynamic Balancing Bay', 'subtitle' => '100,000 RPM Schenck Rig', 'image_url' => 'assets/images/gallery/gallery-balancing.webp'],
            ['title' => 'Turbine Blade Welding', 'subtitle' => 'Laser & TIG Profiling', 'image_url' => 'assets/images/gallery/gallery-welding.webp'],
            ['title' => 'Cartridge Rebuild Station', 'subtitle' => 'CHRA Precision Assembly', 'image_url' => 'assets/images/gallery/gallery-turbine.webp'],
            ['title' => 'Industrial Plant Overhaul', 'subtitle' => '7.2 MW Captive Power Station', 'image_url' => 'assets/images/gallery/gallery-plant.webp'],
            ['title' => 'Superfinishing & Polishing', 'subtitle' => 'Bearing Journal Surface Polish', 'image_url' => 'assets/images/gallery/gallery-machining.webp'],
            ['title' => 'Ultrasonic De-Carbonization', 'subtitle' => 'Chemical Cleaning Line', 'image_url' => 'assets/images/gallery/gallery-ultrasonic.webp'],
            ['title' => 'Nozzle Ring Alignment', 'subtitle' => 'Gas Flow Clearance Calibration', 'image_url' => 'assets/images/gallery/gallery-inspection.webp'],
            ['title' => 'Emergency Anchorage Squad', 'subtitle' => 'Chattogram & Mongla Outer Road', 'image_url' => 'assets/images/gallery/gallery-flying-squad.webp'],
        ];
    }
@endphp

<!-- =====================================================================
     PHOTO GALLERY & WORKSHOPS (With Full-Screen Image Lightbox Preview)
     ===================================================================== -->
<x-section-styler-wrap sectionKey="photos" id="photos">
    
    <div class="max-w-3xl space-y-3 mb-16 {{ $headerAlignClass }}">
        <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 inline-block">
            {{ __($photosBadge) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
            {{ __($photosTitle) }}
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            {{ __($photosSubtitle) }}
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        @if($photosMode === 'dynamic' && $dynamicPhotos->isNotEmpty())
            @foreach($dynamicPhotos as $idx => $p)
                <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx % 4 + 1) * 100 }} group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset($p->image_url) }}', title: '{{ addslashes($p->display_title ?? (is_array($p->title) ? ($p->title[app()->getLocale()] ?? reset($p->title)) : $p->title)) }}' })">
                    <img src="{{ asset($p->image_url) }}" alt="{{ $p->display_title ?? (is_array($p->title) ? ($p->title[app()->getLocale()] ?? reset($p->title)) : $p->title) }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">{{ $p->display_title ?? (is_array($p->title) ? ($p->title[app()->getLocale()] ?? reset($p->title)) : $p->title) }}</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium truncate">{{ $p->subtitle ?? 'Facility Inspection' }}</span>
                    </div>
                </div>
            @endforeach
        @else
            @foreach($staticPhotos as $idx => $sp)
                <div class="reveal-init reveal-fade-up reveal-delay-{{ ($idx % 4 + 1) * 100 }} group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset($sp['image_url'] ?? '') }}', title: '{{ addslashes($sp['title'] ?? '') }}' })">
                    <img src="{{ asset($sp['image_url'] ?? '') }}" alt="{{ $sp['title'] ?? '' }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">{{ $sp['title'] ?? '' }}</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium truncate">{{ $sp['subtitle'] ?? 'Facility Inspection' }}</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</x-section-styler-wrap>