@php
    $videoBreakEnabled = (bool) \App\Models\Setting::get('home_video_break_enabled', \App\Models\Setting::get('theme_video_break_enabled', '1') == '1');
    if (!$videoBreakEnabled) return;

    $videoBreakBadge = \App\Models\Setting::get('home_video_break_badge', 'Global Marine Engineering Excellence');
    $videoBreakHeading = \App\Models\Setting::get('home_video_break_heading', '24/7 Rapid Emergency Response Across 40+ International Ports');
    $videoBreakSubtitle = \App\Models\Setting::get('home_video_break_subtitle', 'Our certified flying squads board commercial vessels at anchorage or alongside berths to deliver on-site turbocharger diagnostics, cartridge swap-outs, and dynamic balancing.');
    $videoBreakCta1Text = \App\Models\Setting::get('home_video_break_cta1_text', 'View Overhaul Capabilities →');
    $videoBreakCta1Url = \App\Models\Setting::get('home_video_break_cta1_url', '/services');
    $videoBreakCta2Text = \App\Models\Setting::get('home_video_break_cta2_text', 'Contact Port Operations');
    $videoBreakCta2Url = \App\Models\Setting::get('home_video_break_cta2_url', '/contact');
@endphp

<!-- =====================================================================
     TRANSPARENT MARINE VIDEO WINDOW BREAK (Turbo Internacional Style)
     Panoramic viewport over background marine video with adaptive executive glass glaze
     ===================================================================== -->
<x-section-styler-wrap sectionKey="video_break" id="video-break">
    <div class="reveal-init reveal-scale reveal-delay-150 max-w-4xl mx-auto px-6 py-10 sm:px-12 sm:py-14 rounded-3xl bg-white/85 dark:bg-[#07131e]/85 backdrop-blur-md border border-slate-200/80 dark:border-slate-800 shadow-xl space-y-6 relative z-10 text-center">
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-slate-100 dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-800 shadow-2xs">
            {{ __($videoBreakBadge) }}
        </span>
        <h2 class="text-3xl sm:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
            {{ __($videoBreakHeading) }}
        </h2>
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed font-medium">
            {{ __($videoBreakSubtitle) }}
        </p>
        <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
            @if($videoBreakCta1Text)
            <a href="{{ $videoBreakCta1Url }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#003C58] hover:bg-[#002f45] text-white shadow-lg transition-all">
                {{ __($videoBreakCta1Text) }}
            </a>
            @endif
            @if($videoBreakCta2Text)
            <a href="{{ $videoBreakCta2Url }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                {{ __($videoBreakCta2Text) }}
            </a>
            @endif
        </div>
    </div>
</x-section-styler-wrap>