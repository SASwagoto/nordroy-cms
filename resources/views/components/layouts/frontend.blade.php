<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $currentLanguageDirection ?? 'ltr' }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = \App\Models\Setting::get('site_name', 'Nordroy Marine & Turbochargers');
        $siteTagline = \App\Models\Setting::get('site_tagline', 'Authorized Multi-Brand Turbocharger Overhauls & Maritime Engineering');
        $defaultTitle = \App\Models\Setting::get('seo_meta_title') ?: ($siteName . ' | ' . $siteTagline);
        if (isset($title) && !empty($title)) {
            $rawPageTitle = str_contains($title, $siteName) ? $title : ($title . ' | ' . $siteName);
        } else {
            $rawPageTitle = $defaultTitle;
        }
        $pageTitle = html_entity_decode(strip_tags($rawPageTitle), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        $metaDescription = \App\Models\Setting::get('seo_meta_description', 'Authorized multi-brand marine turbocharger overhauls, high-speed dynamic balancing, cartridge reconditioning, and 24/7 port emergency flying squads in Bangladesh.');
        $metaKeywords = \App\Models\Setting::get('seo_meta_keywords', 'marine turbocharger, dynamic balancing, turbocharger overhaul, chittagong port, maritime engineering, cartridge rebuilding, nordroy');
        
        // Brand Logos: Separate Light & Dark Mode variants with robust fallback
        $siteLogoLight = \App\Models\Setting::get('site_logo', 'assets/images/logo.png');
        $siteLogoDark = \App\Models\Setting::get('site_logo_dark') ?: $siteLogoLight;

        // Open Graph Image: Custom OG image from Settings > Fallback to official site logo (assets/images/logo.png)
        $customOgImage = \App\Models\Setting::get('seo_og_image');
        if (!empty($customOgImage)) {
            $ogImageUrl = str_starts_with($customOgImage, 'http') ? $customOgImage : url(asset($customOgImage));
        } else {
            $ogImageUrl = str_starts_with($siteLogoLight, 'http') ? $siteLogoLight : url(asset($siteLogoLight));
        }

        $canonicalUrl = url()->current();
    @endphp

    <title>{!! $pageTitle !!}</title>

    <!-- Primary Search Engine Meta Tags -->
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph Protocol / Facebook / WhatsApp / LinkedIn / Telegram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta property="og:image:secure_url" content="{{ $ogImageUrl }}">
    <meta property="og:image:alt" content="{{ $siteName }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="en_US">

    <!-- Twitter / X Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">
    <meta name="twitter:image:alt" content="{{ $siteName }}">

    <!-- Dynamic Favicon (Adaptive Light & Dark Mode) -->
    @php
        $siteIconLight = \App\Models\Setting::get('site_icon', 'assets/images/icon.png');
        $siteIconDark = \App\Models\Setting::get('site_icon_dark', 'assets/images/icon-dark.png') ?: $siteIconLight;
    @endphp
    <link rel="icon" type="image/png" href="{{ asset($siteIconLight) }}" media="(prefers-color-scheme: light)">
    <link rel="icon" type="image/png" href="{{ asset($siteIconDark) }}" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/png" href="{{ asset($siteIconLight) }}">

    <!-- 100% Self-Hosted Local Webfonts (Zero Latency & 100% Offline Compatible) -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">

    <!-- Anti-FOUC Theme Script (Default to Dark Mode unless Light Mode explicitly requested) -->
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();

        function sanitizeDocumentTitle() {
            if (document.title && document.title.includes('&amp;')) {
                document.title = document.title.replace(/&amp;/g, '&');
            }
        }
        sanitizeDocumentTitle();
        document.addEventListener('livewire:init', sanitizeDocumentTitle);
        document.addEventListener('livewire:navigated', sanitizeDocumentTitle);

        var _lastThemeToggle = 0;
        window.toggleSiteTheme = function(e) {
            if (e && e.preventDefault) {
                e.preventDefault();
            }
            var now = Date.now();
            if (now - _lastThemeToggle < 300) {
                return;
            }
            _lastThemeToggle = now;

            var html = document.documentElement;
            var isDark = html.classList.contains('dark');
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: !isDark } }));
        };
    </script>

    <!-- Dynamic CSS Design System Tokens from CMS Theme Studio -->
    <style>
        :root {
            --primary-color: {{ \App\Models\Setting::get('theme_primary_color', '#003C58') }};
            --secondary-color: {{ \App\Models\Setting::get('theme_secondary_color', '#75767A') }};
            --accent-color: {{ \App\Models\Setting::get('theme_accent_color', '#0ea5e9') }};
            --surface-light: {{ \App\Models\Setting::get('theme_surface_light', '#ffffff') }};
            --surface-dark: {{ \App\Models\Setting::get('theme_surface_dark', '#07131e') }};
            --border-color: {{ \App\Models\Setting::get('theme_border_color', '#e2e8f0') }};
            --heading-font: '{{ \App\Models\Setting::get('theme_heading_font', 'Plus Jakarta Sans') }}', sans-serif;
            --body-font: '{{ \App\Models\Setting::get('theme_body_font', 'Plus Jakarta Sans') }}', sans-serif;
            --button-radius: {{ \App\Models\Setting::get('theme_button_radius', '12px') }};
            --container-width: {{ \App\Models\Setting::get('theme_container_width', '1536px') }};
            --section-padding: {{ \App\Models\Setting::get('theme_section_padding', '96px') }};
            --heading-weight: {{ \App\Models\Setting::get('theme_heading_weight', '800') }};
            --letter-spacing: {{ \App\Models\Setting::get('theme_letter_spacing', '-0.02em') }};
        }

        /* Dynamic Typography Application */
        .font-heading, h1, h2, h3, h4, h5, h6 { 
            font-family: var(--heading-font) !important; 
            font-weight: var(--heading-weight);
            letter-spacing: var(--letter-spacing);
        }
        .font-body, body, p, span, a, input, select, textarea, li { 
            font-family: var(--body-font); 
        }

        /* LIGHT MODE ONLY: Seamless Brand Primary & Secondary bindings without dark conflicts */
        html:not(.dark) .bg-\[\#003C58\],
        html:not(.dark) .bg-\[\#003C58\] {
            background-color: var(--primary-color) !important;
        }
        html:not(.dark) .text-\[\#003C58\],
        html:not(.dark) .text-\[\#003C58\] {
            color: var(--primary-color) !important;
        }
        html:not(.dark) .border-\[\#003C58\],
        html:not(.dark) .border-\[\#003C58\] {
            border-color: var(--primary-color) !important;
        }
        html:not(.dark) .ring-\[\#003C58\],
        html:not(.dark) .ring-\[\#003C58\] {
            --tw-ring-color: var(--primary-color) !important;
        }

        /* DARK MODE ONLY: High-contrast cyan/sky highlights */
        html.dark .text-cyan-400 {
            color: var(--accent-color) !important;
        }
        html.dark .border-cyan-400 {
            border-color: var(--accent-color) !important;
        }

        /* Dynamic Radius Overrides */
        .rounded-xl, .rounded-2xl {
            border-radius: var(--button-radius) !important;
        }

        /* Dynamic Container Max-Width */
        .max-w-\[1536px\] {
            max-width: var(--container-width) !important;
        }

        @keyframes turbine-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-turbine {
            animation: turbine-spin 4s linear infinite;
        }

        .icon-glow {
            filter: drop-shadow(0 4px 12px rgba(1, 61, 90, 0.25));
        }
        .dark .icon-glow {
            filter: drop-shadow(0 4px 16px rgba(0, 0, 0, 0.6));
        }

        @keyframes progress {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(50%); }
            100% { transform: translateX(200%); }
        }

        /* Continuous Brand Logo Ticker Animation */
        @keyframes ticker-slide {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-ticker {
            display: flex;
            width: max-content;
            animation: ticker-slide 32s linear infinite;
        }
        .animate-ticker:hover {
            animation-play-state: paused;
        }

        /* Glassmorphism Classes */
        .glass-nav {
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .dark .glass-nav {
            background-color: rgba(7, 19, 30, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-body antialiased bg-slate-50 text-slate-900 dark:bg-[#07131e] dark:text-slate-100 selection:bg-[#003C58] selection:text-white transition-colors duration-200 relative"
      x-data="{
          mobileNavOpen: false,
          activeMobileSubmenu: null
      }">

    <!-- ==================== FIXED FULL-SITE BACKGROUND VIDEO (Turbo Internacional Style) ==================== -->
    @php
        $siteBgVideoEnabled = \App\Models\Setting::get('site_bg_video_enabled', '1');
        $siteBgVideoUrl = \App\Models\Setting::get('site_bg_video_url', 'assets/videos/background-marine.mp4');
        $siteBgVideoOpacity = (int)\App\Models\Setting::get('site_bg_video_opacity', '85');
        if ($siteBgVideoOpacity <= 0 || $siteBgVideoOpacity > 100) {
            $siteBgVideoOpacity = 85;
        }
        $opacityDecimal = $siteBgVideoOpacity / 100;
    @endphp
    @if($siteBgVideoEnabled == '1')
    <div class="fixed inset-0 w-full h-full pointer-events-none -z-20 overflow-hidden select-none bg-white dark:bg-slate-950">
        <video autoplay loop muted playsinline preload="auto" 
               class="w-full h-full object-cover transition-opacity duration-300"
               style="opacity: {{ $opacityDecimal }};">
            <source src="{{ asset($siteBgVideoUrl) }}" type="video/mp4">
        </video>
        <!-- Contrast overlay: Clean ambient white tint in light mode, cinematic vignette in dark mode -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/30 via-transparent to-white/40 dark:from-black/30 dark:via-transparent dark:to-black/40 pointer-events-none"></div>
    </div>
    @endif

    <!-- ==================== NORDROY TURBINE PRELOADER ==================== -->
    <div id="nordroy-preloader" 
         class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white dark:bg-[#07131e] select-none transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <div class="relative w-16 h-16 flex items-center justify-center mb-6">
                <img src="{{ asset($siteIconLight) }}" 
                     alt="Nordroy Turbine" 
                     class="w-14 h-14 object-contain animate-turbine drop-shadow-[0_4px_10px_rgba(0,60,88,0.15)] dark:hidden" />
                <img src="{{ asset($siteIconDark) }}" 
                     alt="Nordroy Turbine" 
                     class="w-14 h-14 object-contain animate-turbine drop-shadow-[0_4px_12px_rgba(0,0,0,0.6)] hidden dark:block" />
            </div>
            <div class="w-36 h-[2px] bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden relative shadow-inner">
                <div class="absolute inset-0 w-1/2 bg-gradient-to-r from-transparent via-[#003C58] to-[#0ea5e9] dark:via-cyan-400 dark:to-teal-300 rounded-full animate-[progress_1.2s_ease-in-out_infinite]"></div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            var preloaderDismissed = false;
            function dismissPreloader() {
                if (preloaderDismissed) return;
                preloaderDismissed = true;
                var p = document.getElementById('nordroy-preloader');
                if (p) {
                    p.style.opacity = '0';
                    p.style.pointerEvents = 'none';
                    setTimeout(function() {
                        if (p && p.parentNode) {
                            p.style.display = 'none';
                        }
                    }, 350);
                }
            }

            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                setTimeout(dismissPreloader, 350);
            } else {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(dismissPreloader, 350);
                });
            }
            setTimeout(dismissPreloader, 800);
        })();
    </script>
    <!-- ================== END NORDROY PRELOADER ================== -->

    <div class="min-h-full flex flex-col justify-between relative z-10">
        
        @php
            // ==================== DYNAMIC TOPBAR SETTINGS ====================
            $topbarEnabled = (bool) \App\Models\Setting::get('header_topbar_enabled', true);
            $topbarBadgeText = \App\Models\Setting::get('header_topbar_badge_text', '24/7 Port Call & Emergency Squads');
            $topbarBadgeIcon = \App\Models\Setting::get('header_topbar_badge_icon', 'solid:phone-volume');
            $topbarTagline = \App\Models\Setting::get('header_topbar_tagline', 'Authorized Multi-Brand Turbocharger Engineering');
            $topbarPhone = \App\Models\Setting::get('header_topbar_phone') ?: \App\Models\Setting::get('contact_phone', '+880 1800-000000');
            $topbarPhoneIcon = \App\Models\Setting::get('header_topbar_phone_icon', 'solid:phone');
            $topbarEmail = \App\Models\Setting::get('header_topbar_email') ?: \App\Models\Setting::get('contact_email', 'operations@nordroy.com');
            $topbarEmailIcon = \App\Models\Setting::get('header_topbar_email_icon', 'solid:envelope');
            $topbarShowLang = (bool) \App\Models\Setting::get('header_topbar_show_lang', true);
            $topbarShowPortal = (bool) \App\Models\Setting::get('header_topbar_show_portal', true);
            $topbarPortalText = \App\Models\Setting::get('header_topbar_portal_text', 'Admin Portal →');
            $topbarPortalUrl = \App\Models\Setting::get('header_topbar_portal_url', route('admin.dashboard'));
            $topbarLightBg = \App\Models\Setting::get('header_topbar_light_bg', '#ffffff');
            $topbarDarkBg = \App\Models\Setting::get('header_topbar_dark_bg', '#050f18');
            $topbarLightText = \App\Models\Setting::get('header_topbar_light_text', '#334155');
            $topbarDarkText = \App\Models\Setting::get('header_topbar_dark_text', '#cbd5e1');

            // ==================== DYNAMIC NAVBAR SETTINGS ====================
            $headerSticky = (bool) \App\Models\Setting::get('header_sticky', true);
            $headerHeight = \App\Models\Setting::get('header_height', '80px');
            $headerBgStyle = \App\Models\Setting::get('header_bg_style', 'frosted');
            $headerFrostedOpacity = max(10, min(90, (int) \App\Models\Setting::get('header_frosted_opacity', 85)));
            $headerOpacityDecimal = $headerFrostedOpacity / 100;
            $headerCustomLightBg = \App\Models\Setting::get('header_custom_light_bg', '#ffffff');
            $headerCustomDarkBg = \App\Models\Setting::get('header_custom_dark_bg', '#07131e');
            $headerCustomLightText = \App\Models\Setting::get('header_custom_light_text', '#0f172a');
            $headerCustomDarkText = \App\Models\Setting::get('header_custom_dark_text', '#f8fafc');

            $headerBrandTitle = \App\Models\Setting::get('header_brand_title') ?: \App\Models\Setting::get('site_name', 'Nordroy Marine');
            $headerLogoLight = \App\Models\Setting::get('header_logo_light') ?: $siteLogoLight;
            $headerLogoDark = \App\Models\Setting::get('header_logo_dark') ?: $siteLogoDark;
            $headerLogoHeight = (int) \App\Models\Setting::get('header_logo_height', 40);

            $headerShowThemeToggle = (bool) \App\Models\Setting::get('header_show_theme_toggle', true);
            $headerCtaEnabled = (bool) \App\Models\Setting::get('header_cta_enabled', true);
            $headerCtaText = \App\Models\Setting::get('header_cta_text', 'Request RFQ');
            $headerCtaUrl = \App\Models\Setting::get('header_cta_url', route('contact') . '#rfq');
            $headerCtaIcon = \App\Models\Setting::get('header_cta_icon', 'solid:clipboard-document-list');
            $headerCtaStyle = \App\Models\Setting::get('header_cta_style', 'primary_gradient');

            // Dynamic Menu lookup
            $headerMenuId = \App\Models\Setting::get('header_menu_id');
            $primaryMenu = null;
            if ($headerMenuId) {
                try {
                    $primaryMenu = \App\Models\Menu::with(['rootItems.children'])->find($headerMenuId);
                } catch (\Throwable $e) {}
            }
            if (!$primaryMenu) {
                try {
                    $primaryMenu = \App\Models\Menu::with(['rootItems.children'])->where('location', 'primary')->first();
                } catch (\Throwable $e) {}
            }
        @endphp

        <style>
            @if($headerBgStyle === 'frosted')
                .glass-nav {
                    background-color: rgba(255, 255, 255, {{ $headerOpacityDecimal }}) !important;
                }
                html.dark .glass-nav {
                    background-color: rgba(7, 19, 30, {{ $headerOpacityDecimal }}) !important;
                }
            @elseif($headerBgStyle === 'custom')
                .glass-nav {
                    background-color: {{ $headerCustomLightBg }} !important;
                    color: {{ $headerCustomLightText }} !important;
                }
                html.dark .glass-nav {
                    background-color: {{ $headerCustomDarkBg }} !important;
                    color: {{ $headerCustomDarkText }} !important;
                }
            @elseif($headerBgStyle === 'solid')
                .glass-nav {
                    background-color: #ffffff !important;
                    backdrop-filter: none !important;
                }
                html.dark .glass-nav {
                    background-color: #07131e !important;
                    backdrop-filter: none !important;
                }
            @elseif($headerBgStyle === 'transparent')
                .glass-nav {
                    background-color: transparent !important;
                    backdrop-filter: none !important;
                }
            @endif
        </style>

        @if($topbarEnabled)
        <!-- TOP CORPORATE EMERGENCY & STATS STRIP -->
        <div class="bg-white/95 dark:bg-[#050f18]/95 text-slate-700 dark:text-slate-300 border-b border-slate-200/90 dark:border-slate-800 text-[11px] py-2 px-4 sm:px-8 transition-colors">
            <div class="max-w-[1536px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-xs text-[#003C58] dark:text-cyan-400 tracking-tight flex items-center gap-1.5">
                        @if($topbarBadgeIcon)
                            <x-icon :name="$topbarBadgeIcon" class="w-3.5 h-3.5 shrink-0" />
                        @endif
                        <span>{{ __($topbarBadgeText) }}</span>
                    </span>
                    @if($topbarTagline)
                        <span class="hidden md:inline text-slate-300 dark:text-slate-700">|</span>
                        <span class="hidden md:inline text-slate-500 dark:text-slate-400 font-medium">{{ __($topbarTagline) }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-3 sm:gap-4 text-xs">
                    @if($topbarPhone)
                    <a href="tel:{{ $topbarPhone }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors flex items-center gap-1.5 font-semibold">
                        <x-icon :name="$topbarPhoneIcon" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400 shrink-0" />
                        <span>{{ $topbarPhone }}</span>
                    </a>
                    @endif
                    @if($topbarEmail)
                    <a href="mailto:{{ $topbarEmail }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors hidden sm:flex items-center gap-1.5">
                        <x-icon :name="$topbarEmailIcon" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400 shrink-0" />
                        <span>{{ $topbarEmail }}</span>
                    </a>
                    @endif

                    <!-- Dynamic Multi-Language Switcher Dropdown -->
                    @if($topbarShowLang)
                        @php
                            $navLanguages = collect();
                            if (\Illuminate\Support\Facades\Schema::hasTable('languages')) {
                                try {
                                    $navLanguages = \App\Models\Language::where('is_active', true)->orderBy('order')->get();
                                } catch (\Throwable $e) {}
                            }
                            $activeLocaleCode = app()->getLocale();
                            $currLang = $navLanguages->firstWhere('code', $activeLocaleCode) 
                                ?? $navLanguages->firstWhere('is_default', true) 
                                ?? $navLanguages->first();
                        @endphp

                        @if($navLanguages->count() > 0)
                            <div class="relative inline-block text-left" x-data="{ langOpen: false }" @click.outside="langOpen = false">
                                <button type="button" 
                                        @click="langOpen = !langOpen" 
                                        class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[11px] font-bold text-slate-800 dark:text-slate-200 transition-colors inline-flex items-center gap-1.5 cursor-pointer border border-slate-200 dark:border-slate-700"
                                        title="Switch Language">
                                    <span class="text-xs select-none">{{ $currLang?->flag_icon ?: '🌐' }}</span>
                                    <span class="font-bold">{{ $currLang?->native_name ?: strtoupper($currLang?->code ?? 'EN') }}</span>
                                    <svg class="w-3 h-3 text-slate-400 transition-transform" :class="langOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="langOpen" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-1 w-40 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl py-1.5 z-50 overflow-hidden" 
                                     style="display: none;">
                                    <div class="px-3 py-1 text-[9px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 dark:border-slate-800 mb-1">
                                        Select Language
                                    </div>
                                    @foreach($navLanguages as $l)
                                        <a href="{{ route('language.switch', $l->code) }}" 
                                           class="flex items-center justify-between px-3 py-1.5 text-xs hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors {{ $activeLocaleCode === $l->code ? 'text-[#003C58] dark:text-cyan-400 font-bold bg-[#003C58]/5 dark:bg-cyan-500/10' : 'text-slate-700 dark:text-slate-300' }}">
                                            <span class="flex items-center gap-2">
                                                <span class="text-sm select-none">{{ $l->flag_icon ?: '🌐' }}</span>
                                                <span>{{ $l->native_name }}</span>
                                            </span>
                                            @if($activeLocaleCode === $l->code)
                                                <svg class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    @if($topbarShowPortal)
                    <a href="{{ $topbarPortalUrl }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[11px] font-bold text-slate-700 dark:text-slate-300 transition-colors">
                        {{ __($topbarPortalText) }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- STICKY GLASSMORPHISM PUBLIC HEADER -->
        <header class="{{ $headerSticky ? 'sticky top-0 ' : '' }}z-40 glass-nav border-b border-slate-200/90 dark:border-slate-800 transition-colors duration-200">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 flex items-center justify-between"
                 style="height: {{ $headerHeight }};">
                
                <!-- Brand Logo & Title (Light & Dark Mode Responsive Pairing) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <!-- Light Mode Logo: Visible in Light Mode, hidden in Dark Mode -->
                    <img src="{{ str_starts_with($headerLogoLight, 'http') ? $headerLogoLight : asset($headerLogoLight) }}" 
                         alt="{{ $headerBrandTitle }}" 
                         class="w-auto object-contain dark:hidden group-hover:scale-102 transition-transform duration-200"
                         style="height: {{ $headerLogoHeight }}px;" />
                    <!-- Dark Mode Logo: Visible in Dark Mode, hidden in Light Mode -->
                    <img src="{{ str_starts_with($headerLogoDark, 'http') ? $headerLogoDark : asset($headerLogoDark) }}" 
                         alt="{{ $headerBrandTitle }}" 
                         class="w-auto object-contain hidden dark:block group-hover:scale-102 transition-transform duration-200"
                         style="height: {{ $headerLogoHeight }}px;" />
                </a>

                <!-- DESKTOP MULTI-LAYER NAVIGATION LINKS WITH CLEAN SUBMENUS (Consistent Title Case) -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-[13px] font-semibold text-slate-700 dark:text-slate-200 tracking-normal">
                    
                    <!-- 1. Home Link -->
                    <a href="{{ route('home') }}" 
                       class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors {{ request()->routeIs('home') ? 'text-[#003C58] dark:text-cyan-400 font-bold' : '' }}">
                        {{ __('Home') }}
                    </a>

                    <!-- 2. About Conglomerate (Dropdown) -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button" class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors inline-flex items-center gap-1 cursor-pointer">
                            <span>{{ __('About Us') }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <!-- Submenu Dropdown Card -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl py-3 px-2 z-50"
                             style="display: none;">
                            <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ __('Company Overview') }}</div>
                            <a href="{{ route('about') }}#overview" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Corporate Heritage & Profile') }}
                            </a>
                            <a href="{{ route('about') }}#mission" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Mission, Vision & Core Values') }}
                            </a>

                            <a href="{{ route('about') }}#certifications" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('ISO 9001:2015 & DNV Standards') }}
                            </a>
                        </div>
                    </div>

                    <!-- 3. Overhaul Services (Dropdown) -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button" class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors inline-flex items-center gap-1 cursor-pointer">
                            <span>{{ __('Services') }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute left-0 mt-1 w-72 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl py-3 px-2 z-50"
                             style="display: none;">
                            <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ __('Services & Precision Overhauls') }}</div>
                            <a href="{{ route('services') }}#balancing" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Dynamic Rotor Balancing (100k RPM)') }}
                            </a>
                            <a href="{{ route('services') }}#overhaul" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Turbine Blading & TIG Welding') }}
                            </a>
                            <a href="{{ route('services') }}#cartridge" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Cartridge (CHRA) Exchange') }}
                            </a>
                            <a href="{{ route('services') }}#ultrasonic" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Ultrasonic Chemical Cleaning') }}
                            </a>
                            <a href="{{ route('services') }}#flying-squad" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('24/7 Port Emergency Flying Squads') }}
                            </a>
                        </div>
                    </div>

                    <!-- 4. Products Link -->
                    <a href="{{ route('products') }}" class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors {{ request()->routeIs('products*') ? 'text-[#003C58] dark:text-cyan-400 font-bold' : '' }}">
                        {{ __('Products & Spares') }}
                    </a>

                    <!-- 5. Projects & Media (Dropdown) -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button" class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors inline-flex items-center gap-1 cursor-pointer">
                            <span>{{ __('Projects') }}</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl py-3 px-2 z-50"
                             style="display: none;">
                            <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ __('Case Studies & Galleries') }}</div>
                            <a href="{{ route('projects') }}#projects" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span>
                                {{ __('Featured Industrial Projects') }}
                            </a>
                            <a href="{{ route('photo-gallery') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                {{ __('Photo Gallery & Workshops') }}
                            </a>
                            <a href="{{ route('video-gallery') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                {{ __('Video Gallery & Procedures') }}
                            </a>
                        </div>
                    </div>

                    <!-- 6. Careers Link -->
                    <a href="{{ route('careers') }}" 
                       class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors {{ request()->routeIs('careers*') ? 'text-[#003C58] dark:text-cyan-400 font-bold' : '' }}">
                        {{ __('Careers') }}
                    </a>

                    <!-- 7. Contact Link -->
                    <a href="{{ route('contact') }}" 
                       class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors {{ request()->routeIs('contact') ? 'text-[#003C58] dark:text-cyan-400 font-bold' : '' }}">
                        {{ __('Contact') }}
                    </a>

                </nav>

                <!-- Header Actions: Theme Toggle + CTA + Mobile Hamburger -->
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    @if($headerShowThemeToggle)
                    <!-- Theme Toggle (Instant 0ms Vanilla JS + Pure CSS Icons) -->
                    <button type="button" onclick="window.toggleSiteTheme(event)"
                            class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100/80 dark:bg-slate-900 text-slate-700 dark:text-amber-400 hover:bg-slate-200/80 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                            title="Toggle Light/Dark Theme">
                        <!-- Sun Icon: Visible in Dark Mode (click to switch to Light) -->
                        <svg class="w-4 h-4 text-amber-500 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon: Visible in Light Mode (click to switch to Dark) -->
                        <svg class="w-4 h-4 text-slate-700 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                    @endif

                    @if($headerCtaEnabled)
                        @php
                            $ctaStyleClass = match($headerCtaStyle) {
                                'outline' => 'border border-[#003C58] dark:border-cyan-400 text-[#003C58] dark:text-cyan-400 bg-transparent hover:bg-[#003C58]/5 dark:hover:bg-cyan-500/10',
                                'solid_dark' => 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:opacity-90',
                                default => 'text-white shadow-md',
                            };
                            $ctaInline = ($headerCtaStyle === 'primary_gradient') 
                                ? 'background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); border-radius: var(--button-radius);'
                                : 'border-radius: var(--button-radius);';
                        @endphp
                        <!-- Dynamic Header CTA Button -->
                        <a href="{{ $headerCtaUrl }}" 
                           class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider active:scale-95 transition-all {{ $ctaStyleClass }}"
                           style="{{ $ctaInline }}">
                            @if($headerCtaIcon)
                                <x-icon :name="$headerCtaIcon" class="w-3.5 h-3.5 shrink-0" />
                            @endif
                            <span>{{ __($headerCtaText) }}</span>
                        </a>
                    @endif

                    <!-- Mobile Hamburger Button -->
                    <button type="button" @click="mobileNavOpen = true" class="lg:hidden p-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- ==================== MODERN OFF-CANVAS SLIDE-OVER MOBILE DRAWER ==================== -->
        <div x-show="mobileNavOpen" 
             class="fixed inset-0 z-50 lg:hidden overflow-hidden" 
             style="display: none;">
            
            <!-- Backdrop Overlay -->
            <div x-show="mobileNavOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileNavOpen = false"
                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"></div>

            <!-- Slide-over Drawer Panel -->
            <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
                <div x-show="mobileNavOpen"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-200"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-sm bg-white dark:bg-[#07131e] border-l border-slate-200 dark:border-slate-800 flex flex-col justify-between shadow-2xl">
                    
                    <!-- Drawer Header -->
                    <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <!-- Light Mode Logo: Visible in Light Mode, hidden in Dark Mode -->
                        <img src="{{ asset($siteLogoLight) }}" 
                             alt="{{ \App\Models\Setting::get('site_name', 'Nordroy Marine') }}" 
                             class="h-8 w-auto object-contain dark:hidden" />
                        <!-- Dark Mode Logo: Visible in Dark Mode, hidden in Light Mode -->
                        <img src="{{ asset($siteLogoDark) }}" 
                             alt="{{ \App\Models\Setting::get('site_name', 'Nordroy Marine') }}" 
                             class="h-8 w-auto object-contain hidden dark:block" />
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="window.toggleSiteTheme(event)"
                                    class="p-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100/80 dark:bg-slate-900 text-slate-700 dark:text-amber-400 cursor-pointer"
                                    title="Toggle Light/Dark Theme">
                                <!-- Sun Icon: Visible in Dark Mode (click to switch to Light) -->
                                <svg class="w-4 h-4 text-amber-500 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <!-- Moon Icon: Visible in Light Mode (click to switch to Dark) -->
                                <svg class="w-4 h-4 text-slate-700 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                            <button type="button" @click="mobileNavOpen = false" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Drawer Nav Items (with Accordion Submenus - Pure Title Case) -->
                    <div class="flex-1 overflow-y-auto p-5 space-y-2 text-sm font-semibold tracking-normal">
                        
                        <!-- Mobile Language Switcher Strip -->
                        @if(isset($navLanguages) && $navLanguages->count() > 1)
                            <div class="pb-3 mb-2 border-b border-slate-100 dark:border-slate-800">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">Language</span>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @foreach($navLanguages as $l)
                                        <a href="{{ route('language.switch', $l->code) }}" 
                                           class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ app()->getLocale() === $l->code ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                                            <span>{{ $l->flag_icon ?: '🌐' }}</span>
                                            <span>{{ $l->native_name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('home') }}" @click="mobileNavOpen = false" 
                           class="block py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ request()->routeIs('home') ? 'bg-slate-100 dark:bg-slate-800 font-bold text-[#003C58] dark:text-cyan-400' : '' }}">
                            {{ __('Home') }}
                        </a>

                        <!-- About Us Accordion -->
                        <div class="border-b border-slate-100 dark:border-slate-800/80 pb-2">
                            <button type="button" @click="activeMobileSubmenu = (activeMobileSubmenu === 'about' ? null : 'about')" 
                                    class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                                <span>{{ __('About Us') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="activeMobileSubmenu === 'about' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="activeMobileSubmenu === 'about'" x-transition class="pl-4 pt-1 space-y-1.5 text-xs font-medium text-slate-600 dark:text-slate-400">
                                <a href="{{ route('about') }}#overview" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Corporate Heritage & Profile') }}</a>
                                <a href="{{ route('about') }}#mission" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Mission, Vision & Core Values') }}</a>
                                <a href="{{ route('about') }}#certifications" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('ISO 9001:2015 & DNV Standards') }}</a>
                            </div>
                        </div>

                        <!-- Services Accordion -->
                        <div class="border-b border-slate-100 dark:border-slate-800/80 pb-2">
                            <button type="button" @click="activeMobileSubmenu = (activeMobileSubmenu === 'services' ? null : 'services')" 
                                    class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                                <span>{{ __('Services') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="activeMobileSubmenu === 'services' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="activeMobileSubmenu === 'services'" x-transition class="pl-4 pt-1 space-y-1.5 text-xs font-medium text-slate-600 dark:text-slate-400">
                                <a href="{{ route('services') }}#balancing" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Dynamic Rotor Balancing (100k RPM)') }}</a>
                                <a href="{{ route('services') }}#overhaul" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Turbine Blading & TIG Welding') }}</a>
                                <a href="{{ route('services') }}#cartridge" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Cartridge (CHRA) Exchange') }}</a>
                                <a href="{{ route('services') }}#ultrasonic" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Ultrasonic Chemical Cleaning') }}</a>
                                <a href="{{ route('services') }}#flying-squad" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('24/7 Port Emergency Flying Squads') }}</a>
                            </div>
                        </div>

                        <a href="{{ route('products') }}" @click="mobileNavOpen = false" 
                           class="block py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 border-b border-slate-100 dark:border-slate-800/80 pb-2 transition-colors {{ request()->routeIs('products*') ? 'bg-slate-100 dark:bg-slate-800 font-bold text-[#003C58] dark:text-cyan-400' : '' }}">
                            {{ __('Products & Spares') }}
                        </a>

                        <!-- Projects Accordion -->
                        <div class="border-b border-slate-100 dark:border-slate-800/80 pb-2">
                            <button type="button" @click="activeMobileSubmenu = (activeMobileSubmenu === 'projects' ? null : 'projects')" 
                                    class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                                <span>{{ __('Projects') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="activeMobileSubmenu === 'projects' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="activeMobileSubmenu === 'projects'" x-transition class="pl-4 pt-1 space-y-1.5 text-xs font-medium text-slate-600 dark:text-slate-400">
                                <a href="{{ route('projects') }}#projects" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Featured Industrial Projects') }}</a>
                                <a href="{{ route('photo-gallery') }}" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Photo Gallery & Workshops') }}</a>
                                <a href="{{ route('video-gallery') }}" @click="mobileNavOpen = false" class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60">{{ __('Video Gallery & Procedures') }}</a>
                            </div>
                        </div>

                        <a href="{{ route('careers') }}" @click="mobileNavOpen = false" 
                           class="block py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ request()->routeIs('careers*') ? 'bg-slate-100 dark:bg-slate-800 font-bold text-[#003C58] dark:text-cyan-400' : '' }}">
                            {{ __('Careers') }}
                        </a>

                        <a href="{{ route('contact') }}" @click="mobileNavOpen = false" 
                           class="block py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ request()->routeIs('contact') ? 'bg-slate-100 dark:bg-slate-800 font-bold text-[#003C58] dark:text-cyan-400' : '' }}">
                            {{ __('Contact') }}
                        </a>
                    </div>

                    <!-- Drawer Footer CTA & Emergency Info -->
                    <div class="p-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 space-y-3">
                        @if($headerCtaEnabled)
                        <a href="{{ $headerCtaUrl }}" @click="mobileNavOpen = false" 
                           class="w-full inline-flex items-center justify-center py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-white shadow-md active:scale-95 transition-all"
                           style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                            {{ __($headerCtaText) }}
                        </a>
                        @endif
                        @if($topbarPhone)
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 text-center font-medium">
                            24/7 Port Helpline: <a href="tel:{{ $topbarPhone }}" class="font-bold text-[#003C58] dark:text-cyan-400">{{ $topbarPhone }}</a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- MAIN PAGE CONTENT -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- ==================== CORPORATE FOOTER (Light Mode: Clean Light Slate, Dark Mode: Shipyard Navy) ==================== -->
        <footer class="bg-slate-100/95 dark:bg-[#040e17]/95 text-slate-700 dark:text-slate-300 border-t border-slate-200 dark:border-slate-800 pt-16 pb-12 transition-colors duration-200">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-200 dark:border-slate-800/80">
                    
                    <!-- Col 1: Brand Info & Mission (2 cols on lg) -->
                    <div class="lg:col-span-2 space-y-4">
                        <!-- Light Mode Logo: Visible in Light Mode, hidden in Dark Mode -->
                        <img src="{{ asset($siteLogoLight) }}" 
                             alt="{{ \App\Models\Setting::get('site_name', 'Nordroy Marine') }}" 
                             class="h-10 w-auto object-contain dark:hidden" />
                        <!-- Dark Mode Logo: Visible in Dark Mode, hidden in Light Mode -->
                        <img src="{{ asset($siteLogoDark) }}" 
                             alt="{{ \App\Models\Setting::get('site_name', 'Nordroy Marine') }}" 
                             class="h-10 w-auto object-contain hidden dark:block" />
                        
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed max-w-md">
                            A premier industrial conglomerate and maritime engineering group specializing in authorized multi-brand exhaust gas turbocharger overhauls, dynamic rotor balancing up to 100,000 RPM, genuine OEM spare parts supply, and technical port assistance across global maritime hubs.
                        </p>

                        <!-- Social Media Links (Rendered Dynamically from Settings Engine) -->
                        <div class="flex items-center gap-2 pt-2">
                            @php
                                $socialLinks = json_decode(\App\Models\Setting::get('social_links_data', '[]'), true) ?: [];
                            @endphp
                            @forelse($socialLinks as $link)
                                <a href="{{ $link['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" 
                                   title="{{ $link['platform'] ?? 'Social Link' }}"
                                   class="w-8 h-8 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-[#003C58] dark:hover:text-cyan-400 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                                    <x-icon :name="$link['icon'] ?? 'solid:globe'" class="w-3.5 h-3.5" />
                                </a>
                            @empty
                                <a href="#" class="w-8 h-8 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-slate-700 dark:hover:text-white"><x-icon name="solid:globe" class="w-3.5 h-3.5" /></a>
                            @endforelse
                        </div>
                    </div>

                    <!-- Col 2: Products & Spare Parts -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">OEM Spare Parts</h4>
                        <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li><a href="{{ route('products') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Turbine Blades &amp; Rotors</a></li>
                            <li><a href="{{ route('products') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">CHRA Replacement Cartridges</a></li>
                            <li><a href="{{ route('products') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Nozzle Rings &amp; Diffusers</a></li>
                            <li><a href="{{ route('products') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Hydrodynamic Bearing Bushes</a></li>
                            <li><a href="{{ route('careers') }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors font-semibold text-cyan-600 dark:text-cyan-400">Careers &amp; Opportunities &rarr;</a></li>
                        </ul>
                    </div>

                    <!-- Col 3: Technical Services -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">Technical Services</h4>
                        <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li><a href="{{ route('services') }}#balancing" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Dynamic Rotor Balancing</a></li>
                            <li><a href="{{ route('services') }}#overhaul" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Turbine Blading &amp; Welding</a></li>
                            <li><a href="{{ route('services') }}#cartridge" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Cartridge Reconditioning</a></li>
                            <li><a href="{{ route('services') }}#ultrasonic" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Ultrasonic Chemical Cleaning</a></li>
                            <li><a href="{{ route('services') }}#flying-squad" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">24/7 Port Emergency Call</a></li>
                        </ul>
                    </div>

                    <!-- Col 4: Corporate Offices & Workshops -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">Port &amp; HQ Offices</h4>
                        <div class="text-xs text-slate-600 dark:text-slate-400 space-y-2.5">
                            <div>
                                <p class="font-bold text-slate-800 dark:text-slate-200">Chattogram Port Workshop:</p>
                                <p>Near Marine Academy Jetty, Chattogram Port, Bangladesh.</p>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-slate-200">Dhaka Corporate HQ:</p>
                                <p>{{ \App\Models\Setting::get('company_address', 'Gulshan Industrial Area, Dhaka, Bangladesh') }}</p>
                            </div>
                            <div class="pt-1">
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+880 1800-000000') }}" class="text-[#003C58] dark:text-cyan-400 font-bold block">
                                    Emergency: {{ \App\Models\Setting::get('contact_phone', '+880 1800-000000') }}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Bottom Copyright Strip -->
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                    <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Nordroy CMS') }}. All rights reserved. Maritime Engineering &amp; Industrial Overhauls.</p>
                    <div class="flex items-center gap-5 flex-wrap">
                        <a href="{{ route('careers') }}" class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Careers</a>
                        <a href="{{ route('photo-gallery') }}" class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Photo Gallery</a>
                        <a href="{{ route('video-gallery') }}" class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Video Gallery</a>
                        <span class="inline-flex items-center gap-1.5 text-slate-600 dark:text-slate-400 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            ISO 9001:2015 &amp; DNV Certified
                        </span>
                        <a href="{{ route('login') }}" class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Staff Login</a>
                    </div>
                </div>

            </div>
        </footer>

    </div>

    <!-- ==================== GLOBAL IMAGE LIGHTBOX PREVIEW MODAL ==================== -->
    <div x-data="{ open: false, src: '', title: '' }"
         @open-lightbox.window="open = true; src = $event.detail.src; title = $event.detail.title || 'Workshop Facility Inspection'"
         @keydown.escape.window="open = false"
         x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[10000] bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-8 select-none"
         style="display: none;">
        
        <div class="relative max-w-5xl w-full flex flex-col items-center" @click.outside="open = false">
            <button type="button" @click="open = false" 
                    class="self-end mb-3 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 transition-colors cursor-pointer">
                <span>Close (Esc)</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-700 max-h-[80vh] flex items-center justify-center bg-black">
                <img :src="src" :alt="title" class="max-h-[75vh] w-auto max-w-full object-contain" />
            </div>
            <p x-text="title" class="mt-3 text-sm font-semibold text-white/90 text-center tracking-wide font-heading"></p>
        </div>
    </div>

    @livewireScripts
</body>
</html>
