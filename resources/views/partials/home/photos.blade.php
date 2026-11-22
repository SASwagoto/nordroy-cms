@php
    $photosEnabled = (bool) \App\Models\Setting::get('home_photos_enabled', true);
    if (!$photosEnabled) return;

    $photosBadge = \App\Models\Setting::get('home_photos_badge', 'Visual Facilities');
    $photosTitle = \App\Models\Setting::get('home_photos_title', 'Workshop & Engineering Gallery');
    $photosSubtitle = \App\Models\Setting::get('home_photos_subtitle', 'Click on any photo below to inspect high-resolution images of our port workshops and overhaul facilities.');
    $photosMode = \App\Models\Setting::get('home_photos_mode', 'static');
    $photosLimit = (int) \App\Models\Setting::get('home_photos_limit', 8);

    $dynamicPhotos = collect();
    if ($photosMode === 'dynamic') {
        try {
            $dynamicPhotos = \App\Models\PhotoGallery::where('is_active', true)->take($photosLimit)->get();
        } catch (\Throwable $e) {
            $dynamicPhotos = collect();
        }
    }
@endphp

<!-- =====================================================================
     PHOTO GALLERY & WORKSHOPS (With Full-Screen Image Lightbox Preview)
     ===================================================================== -->
<section id="photos" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-slate-50 dark:bg-[#06121d] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
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
                         @click="$dispatch('open-lightbox', { src: '{{ asset($p->image_url) }}', title: '{{ addslashes($p->title) }}' })">
                        <img src="{{ asset($p->image_url) }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                        <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                                <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                            </div>
                        </div>
                        <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                            <span class="font-bold block truncate text-slate-900 dark:text-white">{{ $p->title }}</span>
                            <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium truncate">{{ $p->subtitle ?? 'Facility Inspection' }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Photo 1: Dynamic Balancing Bay -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-balancing.webp') }}', title: 'Dynamic Rotor Balancing Bay (Schenck Hard-Bearing Calibrated)' })">
                    <img src="{{ asset('assets/images/gallery/gallery-balancing.webp') }}" alt="Dynamic Balancing" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">Dynamic Balancing Bay</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">100,000 RPM Schenck Rig</span>
                    </div>
                </div>

                <!-- Photo 2: Micro-TIG Welding Bay -->
                <div class="reveal-init reveal-fade-up reveal-delay-150 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-welding.webp') }}', title: 'Micro-TIG Turbine Blade Reconstruction Bay' })">
                    <img src="{{ asset('assets/images/gallery/gallery-welding.webp') }}" alt="Micro-TIG Welding" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">Turbine Blade Welding</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">Laser &amp; TIG Profiling</span>
                    </div>
                </div>

                <!-- Photo 3: Cartridge Rebuild Station -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-turbine.webp') }}', title: 'Heavy Turbocharger Cartridge (CHRA) Assembly' })">
                    <img src="{{ asset('assets/images/gallery/gallery-turbine.webp') }}" alt="CHRA Assembly" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">CHRA Cartridge Assembly</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">Calibrated Clean Bay</span>
                    </div>
                </div>

                <!-- Photo 4: 7.2 MW Plant Turbomachinery -->
                <div class="reveal-init reveal-fade-up reveal-delay-250 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-plant.webp') }}', title: '7.2 MW Captive Power Plant Turbomachinery Overhaul' })">
                    <img src="{{ asset('assets/images/gallery/gallery-plant.webp') }}" alt="Captive Power Plant" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">Captive Power Plant</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">Industrial Utilities</span>
                    </div>
                </div>

                <!-- Photo 5: Generator Overhaul -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-generator.webp') }}', title: 'Industrial Diesel & Gas Generator Turbochargers' })">
                    <img src="{{ asset('assets/images/gallery/gallery-generator.webp') }}" alt="Generator Turbochargers" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">Generator Turbo Systems</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">Continuous Contracts</span>
                    </div>
                </div>

                <!-- Photo 6: Vessel Port Flying Squad -->
                <div class="reveal-init reveal-fade-up reveal-delay-150 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-vessel.jpg') }}', title: 'Chattogram Port Anchorage Vessel Flying Squad' })">
                    <img src="{{ asset('assets/images/gallery/gallery-vessel.jpg') }}" alt="Vessel Port Call" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">Port Flying Squad</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">Chattogram Outer Anchorage</span>
                    </div>
                </div>

                <!-- Photo 7: NDT Inspection -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-technician.jpg') }}', title: 'Non-Destructive Metallurgical Flaw Detection & Testing' })">
                    <img src="{{ asset('assets/images/gallery/gallery-technician.jpg') }}" alt="NDT Inspection" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">NDT Metallurgy Testing</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">ASNT Level III Bench</span>
                    </div>
                </div>

                <!-- Photo 8: Industrial Power Diagnostics -->
                <div class="reveal-init reveal-fade-up reveal-delay-250 group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm cursor-pointer"
                     @click="$dispatch('open-lightbox', { src: '{{ asset('assets/images/gallery/gallery-substation.webp') }}', title: 'Industrial Turbine Power Substation Diagnostics' })">
                    <img src="{{ asset('assets/images/gallery/gallery-substation.webp') }}" alt="Turbine Power Diagnostics" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-[#003C58]/20 dark:bg-slate-950/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg">
                            <x-icon name="solid:magnifying-glass-plus" class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="absolute bottom-2 left-2 right-2 bg-white/95 dark:bg-[#07131e]/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-800 text-xs shadow-sm z-10">
                        <span class="font-bold block truncate text-slate-900 dark:text-white">Turbine Diagnostics</span>
                        <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-medium">Load &amp; Surge Verification</span>
                    </div>
                </div>
            @endif
        </div>

    </div>
</section>
