<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = \App\Models\Setting::get('site_name', 'Nordroy Marine & Turbochargers');
        $siteTagline = \App\Models\Setting::get('site_tagline', 'Authorized Multi-Brand Turbocharger Overhauls & Maritime Engineering');
        $defaultTitle = \App\Models\Setting::get('seo_meta_title') ?: ($siteName . ' | ' . $siteTagline);
        $pageTitle = (isset($title) && !empty($title)) ? ($title . ' | ' . $siteName) : $defaultTitle;
        
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

    <title>{{ $pageTitle }}</title>

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

        /* Smart Color Engine: Dynamic Header, Topbar & Section Backgrounds/Text */
        html:not(.dark) .smart-custom-header-bg {
            background-color: var(--header-bg-light) !important;
        }
        html.dark .smart-custom-header-bg {
            background-color: var(--header-bg-dark) !important;
        }
        html:not(.dark) .smart-custom-header-text,
        html:not(.dark) .smart-custom-header-text nav a,
        html:not(.dark) .smart-custom-header-text nav button {
            color: var(--header-text-light) !important;
        }
        html.dark .smart-custom-header-text,
        html.dark .smart-custom-header-text nav a,
        html.dark .smart-custom-header-text nav button {
            color: var(--header-text-dark) !important;
        }

        html:not(.dark) .smart-custom-topbar-bg {
            background-color: var(--topbar-bg-light) !important;
        }
        html.dark .smart-custom-topbar-bg {
            background-color: var(--topbar-bg-dark) !important;
        }
        html:not(.dark) .smart-custom-topbar-text,
        html:not(.dark) .smart-custom-topbar-text a,
        html:not(.dark) .smart-custom-topbar-text span {
            color: var(--topbar-text-light) !important;
        }
        html.dark .smart-custom-topbar-text,
        html.dark .smart-custom-topbar-text a,
        html.dark .smart-custom-topbar-text span {
            color: var(--topbar-text-dark) !important;
        }

        html:not(.dark) .smart-custom-bg {
            background-color: var(--sec-bg-light) !important;
        }
        html.dark .smart-custom-bg {
            background-color: var(--sec-bg-dark) !important;
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
            $headerTopbar = array_merge([
                'enabled'           => true,
                'badge_text'        => '24/7 Port Call & Emergency Squads',
                'subtext'           => 'Authorized Multi-Brand Turbocharger Engineering',
                'show_badge'        => true,
                'show_phone'        => true,
                'phone'             => '',
                'show_email'        => true,
                'email'             => '',
                'show_social'       => true,
                'show_custom_link'  => false,
                'custom_link_text'  => 'Vessel Tracking',
                'custom_link_url'   => '',
                'custom_link_blank' => false,
                'admin_link'        => true,
                'alignment'         => 'between',
                'density'           => 'standard',
                'bg_color'          => ['mode' => 'theme', 'light' => '#ffffff', 'dark' => '#050f18', 'opacity' => 95],
                'text_color'        => ['mode' => 'theme', 'light' => '#334155', 'dark' => '#cbd5e1', 'opacity' => 100],
            ], \App\Models\Setting::getJson('header_topbar') ?: []);

            $topbarBgColor = $headerTopbar['bg_color'] ?? ['mode' => 'theme', 'light' => '#ffffff', 'dark' => '#050f18', 'opacity' => 95];
            $isCustomTopbarBg = \App\Services\SmartColorHelper::isCustom($topbarBgColor);

            $topbarTextColor = $headerTopbar['text_color'] ?? ['mode' => 'theme', 'light' => '#334155', 'dark' => '#cbd5e1', 'opacity' => 100];
            $isCustomTopbarText = \App\Services\SmartColorHelper::isCustom($topbarTextColor);

            $topbarAlignment = $headerTopbar['alignment'] ?? 'between';
            $topbarDensity = $headerTopbar['density'] ?? 'standard';
            $densityClass = match($topbarDensity) {
                'compact'  => 'py-1 text-[10px]',
                'spacious' => 'py-3 text-xs',
                default    => 'py-2 text-[11px]',
            };

            $topbarPhone = !empty($headerTopbar['phone']) ? $headerTopbar['phone'] : \App\Models\Setting::get('contact_phone', '+880 1800-000000');
            $topbarEmail = !empty($headerTopbar['email']) ? $headerTopbar['email'] : \App\Models\Setting::get('contact_email', 'operations@nordroy.com');
            $socialLinks = json_decode(\App\Models\Setting::get('social_links_data', '[]'), true) ?: [];

            $headerSticky = \App\Models\Setting::get('header_sticky', '1') == '1';
            $headerThemeToggle = \App\Models\Setting::get('header_theme_toggle', '1') == '1';
            $headerStyle = \App\Models\Setting::get('theme_header_style', 'glass');
            $headerHeight = \App\Models\Setting::get('theme_header_height', '80px');

            // Header Background & Text Color Engines (Theme vs Custom Light/Dark)
            $headerBgColor = \App\Models\Setting::getJson('header_bg_color', [
                'mode'    => 'theme',
                'light'   => '#ffffff',
                'dark'    => '#07131e',
                'opacity' => 100,
            ]);
            $isCustomHeaderBg = \App\Services\SmartColorHelper::isCustom($headerBgColor);

            $headerTextColor = \App\Models\Setting::getJson('header_text_color', [
                'mode'    => 'theme',
                'light'   => '#0f172a',
                'dark'    => '#ffffff',
                'opacity' => 100,
            ]);
            $isCustomHeaderText = \App\Services\SmartColorHelper::isCustom($headerTextColor);

            // Active Multi-layer Navigation Menu (from DB Menu Builder with fallback)
            $headerMenuId = \App\Models\Setting::get('header_menu_id');
            $activeMenu = null;
            if ($headerMenuId) {
                $activeMenu = \App\Models\Menu::with(['items.children.children'])->find($headerMenuId);
            }
            if (!$activeMenu) {
                $activeMenu = \App\Models\Menu::with(['items.children.children'])->where('location', 'primary')->first();
            }

            $navTree = [];
            if ($activeMenu && $activeMenu->items()->whereNull('parent_id')->count() > 0) {
                $dbRoots = $activeMenu->items()->whereNull('parent_id')->where('is_active', true)->orderBy('order')->get();
                foreach ($dbRoots as $root) {
                    $children = [];
                    foreach ($root->children()->where('is_active', true)->orderBy('order')->get() as $c) {
                        $grandChildren = [];
                        foreach ($c->children()->where('is_active', true)->orderBy('order')->get() as $gc) {
                            $grandChildren[] = [
                                'label' => $gc->display_title,
                                'link'  => $gc->mega_menu_schema ?: ['type' => 'external', 'url' => $gc->url ?: '#', 'target_blank' => ($gc->target === '_blank')],
                            ];
                        }
                        $children[] = [
                            'label'    => $c->display_title,
                            'link'     => $c->mega_menu_schema ?: ['type' => 'external', 'url' => $c->url ?: '#', 'target_blank' => ($c->target === '_blank')],
                            'children' => $grandChildren,
                        ];
                    }
                    $navTree[] = [
                        'label'    => $root->display_title,
                        'link'     => $root->mega_menu_schema ?: ['type' => 'external', 'url' => $root->url ?: '#', 'target_blank' => ($root->target === '_blank')],
                        'children' => $children,
                    ];
                }
            } else {
                $defaultMenuItems = (new \App\Livewire\Admin\Theme\ThemeStudio())->getDefaultMenuItems();
                $navTree = \App\Models\Setting::getJson('header_menu_items') ?: $defaultMenuItems;
            }

            $headerCta = \App\Models\Setting::getJson('header_cta', [
                'enabled'   => true,
                'label'     => 'Request RFQ',
                'link'      => ['type' => 'internal', 'page' => 'contact', 'section' => 'rfq', 'target_blank' => false],
                'show_icon' => true,
            ]);
            $resolvedCta = \App\Services\LinkResolver::resolve($headerCta['link'] ?? []);
        @endphp

        <!-- TOP CORPORATE EMERGENCY & STATS STRIP -->
        @if(!empty($headerTopbar['enabled']))
        <div class="{{ $isCustomTopbarBg ? 'smart-custom-topbar-bg' : 'bg-white/95 dark:bg-[#050f18]/95' }} {{ $isCustomTopbarText ? 'smart-custom-topbar-text' : 'text-slate-700 dark:text-slate-300' }} border-b border-slate-200/90 dark:border-slate-800 {{ $densityClass }} px-4 sm:px-8 transition-colors"
             style="{{ $isCustomTopbarBg ? \App\Services\SmartColorHelper::cssVars($topbarBgColor, 'topbar-bg') : '' }} {{ $isCustomTopbarText ? \App\Services\SmartColorHelper::cssVars($topbarTextColor, 'topbar-text') : '' }}">
            <div class="max-w-[1536px] mx-auto flex flex-col sm:flex-row items-center {{ $topbarAlignment === 'center' ? 'justify-center gap-4 text-center' : ($topbarAlignment === 'start' ? 'justify-start gap-4' : 'justify-between gap-2') }}">
                @if(!empty($headerTopbar['show_badge'] ?? true) && !empty($headerTopbar['badge_text']))
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-xs text-[#003C58] dark:text-cyan-400 tracking-tight">
                            {{ $headerTopbar['badge_text'] }}
                        </span>
                        @if(!empty($headerTopbar['subtext']))
                            <span class="hidden md:inline text-slate-300 dark:text-slate-700">|</span>
                            <span class="hidden md:inline text-slate-500 dark:text-slate-400 font-medium">{{ $headerTopbar['subtext'] }}</span>
                        @endif
                    </div>
                @endif
                <div class="flex items-center flex-wrap gap-3 sm:gap-4 {{ $topbarDensity === 'compact' ? 'text-[11px]' : 'text-xs' }}">
                    @if(!empty($headerTopbar['show_phone'] ?? true) && !empty($topbarPhone))
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $topbarPhone) }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors flex items-center gap-1.5 font-semibold">
                            <svg class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $topbarPhone }}</span>
                        </a>
                    @endif
                    @if(!empty($headerTopbar['show_email'] ?? true) && !empty($topbarEmail))
                        <a href="mailto:{{ $topbarEmail }}" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors hidden sm:flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $topbarEmail }}</span>
                        </a>
                    @endif
                    @if(!empty($headerTopbar['show_custom_link']) && !empty($headerTopbar['custom_link_text']))
                        <a href="{{ $headerTopbar['custom_link_url'] ?: '#' }}" 
                           @if(!empty($headerTopbar['custom_link_blank'])) target="_blank" rel="noopener noreferrer" @endif
                           class="hover:text-[#003C58] dark:hover:text-cyan-400 font-bold transition-colors inline-flex items-center gap-1">
                            <span>{{ $headerTopbar['custom_link_text'] }}</span>
                            @if(!empty($headerTopbar['custom_link_blank']))
                                <svg class="w-3 h-3 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            @endif
                        </a>
                    @endif
                    @if(!empty($headerTopbar['show_social'] ?? true) && count($socialLinks) > 0)
                        <div class="flex items-center gap-1.5 border-l border-slate-300 dark:border-slate-700 pl-3">
                            @foreach($socialLinks as $slink)
                                @if(!empty($slink['url']))
                                    <a href="{{ $slink['url'] }}" target="_blank" rel="noopener noreferrer"
                                       title="{{ $slink['title'] ?? 'Social' }}"
                                       class="w-5 h-5 rounded flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-200/60 dark:hover:bg-slate-800 transition-colors">
                                        <x-icon :name="$slink['icon'] ?? 'solid:globe'" class="w-3 h-3" />
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if(!empty($headerTopbar['admin_link']))
                        <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[11px] font-bold text-slate-700 dark:text-slate-300 transition-colors">
                            Admin Portal &rarr;
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- DYNAMIC PUBLIC HEADER -->
        <header class="{{ $headerSticky ? 'sticky top-0' : 'relative' }} z-40 {{ $isCustomHeaderBg ? 'smart-custom-header-bg' : ($headerStyle === 'solid' ? 'bg-white dark:bg-[#07131e]' : ($headerStyle === 'transparent' ? 'bg-transparent' : ($headerStyle === 'floating' ? 'glass-nav my-3 max-w-[1536px] mx-auto rounded-2xl shadow-lg border border-slate-200/90 dark:border-slate-800' : 'glass-nav border-b border-slate-200/90 dark:border-slate-800'))) }} {{ $isCustomHeaderText ? 'smart-custom-header-text' : '' }} transition-colors duration-200"
                style="{{ $isCustomHeaderBg ? \App\Services\SmartColorHelper::cssVars($headerBgColor, 'header-bg') : '' }} {{ $isCustomHeaderText ? \App\Services\SmartColorHelper::cssVars($headerTextColor, 'header-text') : '' }} {{ $headerStyle !== 'floating' ? 'border-bottom-width: 1px;' : '' }}">
            <div class="max-w-[1536px] mx-auto px-4 sm:px-8 flex items-center justify-between"
                 style="height: {{ $headerHeight ?: '80px' }};">
                
                <!-- Brand Logo & Title (Light & Dark Mode Responsive Pairing) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <!-- Light Mode Logo: Visible in Light Mode, hidden in Dark Mode -->
                    <img src="{{ asset($siteLogoLight) }}" 
                         alt="{{ \App\Models\Setting::get('site_name', 'Nordroy Marine') }}" 
                         class="h-10 w-auto object-contain dark:hidden group-hover:scale-102 transition-transform duration-200" />
                    <!-- Dark Mode Logo: Visible in Dark Mode, hidden in Light Mode -->
                    <img src="{{ asset($siteLogoDark) }}" 
                         alt="{{ \App\Models\Setting::get('site_name', 'Nordroy Marine') }}" 
                         class="h-10 w-auto object-contain hidden dark:block group-hover:scale-102 transition-transform duration-200" />
                </a>

                <!-- DESKTOP MULTI-LAYER DYNAMIC NAVIGATION LINKS WITH SUBMENUS -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-[13px] font-semibold text-slate-700 dark:text-slate-200 tracking-normal">
                    @foreach($navTree as $item)
                        @php
                            $hasChildren = !empty($item['children']) && count($item['children']) > 0;
                            $resolved = \App\Services\LinkResolver::resolve($item['link'] ?? []);
                            $isCurrent = request()->url() === rtrim($resolved['url'], '/') || request()->fullUrl() === $resolved['url'];
                        @endphp

                        @if(!$hasChildren)
                            <!-- Single Link -->
                            <a href="{{ $resolved['url'] }}" 
                               target="{{ $resolved['target'] }}" 
                               @if(!empty($resolved['rel'])) rel="{{ $resolved['rel'] }}" @endif
                               class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors {{ $isCurrent ? 'text-[#003C58] dark:text-cyan-400 font-bold' : '' }}">
                                {{ $item['label'] }}
                            </a>
                        @else
                            <!-- Dropdown Menu Item -->
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <button type="button" class="px-3 py-2 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors inline-flex items-center gap-1 cursor-pointer">
                                    <span>{{ $item['label'] }}</span>
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
                                     class="absolute left-0 mt-1 min-w-[280px] max-w-md rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl py-3 px-2 z-50"
                                     style="display: none;">
                                    <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $item['label'] }}</div>
                                    @foreach($item['children'] as $child)
                                        @php
                                            $childResolved = \App\Services\LinkResolver::resolve($child['link'] ?? []);
                                            $hasGrandChildren = !empty($child['children']) && count($child['children']) > 0;
                                        @endphp
                                        <div class="space-y-0.5">
                                            <a href="{{ $childResolved['url'] }}" 
                                               target="{{ $childResolved['target'] }}" 
                                               @if(!empty($childResolved['rel'])) rel="{{ $childResolved['rel'] }}" @endif
                                               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#003C58] dark:hover:text-cyan-400 transition-all">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400 shrink-0"></span>
                                                <span class="truncate">{{ $child['label'] }}</span>
                                            </a>
                                            @if($hasGrandChildren)
                                                <div class="pl-6 pr-2 py-0.5 space-y-0.5">
                                                    @foreach($child['children'] as $gc)
                                                        @php
                                                            $gcResolved = \App\Services\LinkResolver::resolve($gc['link'] ?? []);
                                                        @endphp
                                                        <a href="{{ $gcResolved['url'] }}"
                                                           target="{{ $gcResolved['target'] }}"
                                                           class="block px-2.5 py-1 text-[11px] text-slate-500 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                            &bull; {{ $gc['label'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </nav>

                <!-- Header Actions: Theme Toggle + CTA + Mobile Hamburger -->
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    @if($headerThemeToggle)
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

                    @if(!empty($headerCta['enabled']))
                    <!-- Dynamic CTA Button -->
                    <a href="{{ $resolvedCta['url'] }}" 
                       target="{{ $resolvedCta['target'] }}" 
                       @if(!empty($resolvedCta['rel'])) rel="{{ $resolvedCta['rel'] }}" @endif
                       class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white shadow-md active:scale-95 transition-all"
                       style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); border-radius: var(--button-radius);">
                        @if(!empty($headerCta['show_icon']))
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                        <span>{{ $headerCta['label'] ?: 'Request RFQ' }}</span>
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

                    <!-- Drawer Nav Items (Dynamic Accordion Submenus) -->
                    <div class="flex-1 overflow-y-auto p-5 space-y-2 text-sm font-semibold tracking-normal">
                        @foreach($navTree as $mi => $item)
                            @php
                                $hasChildren = !empty($item['children']) && count($item['children']) > 0;
                                $resolved = \App\Services\LinkResolver::resolve($item['link'] ?? []);
                                $isCurrent = request()->url() === rtrim($resolved['url'], '/') || request()->fullUrl() === $resolved['url'];
                            @endphp

                            @if(!$hasChildren)
                                <a href="{{ $resolved['url'] }}" 
                                   target="{{ $resolved['target'] }}" 
                                   @if(!empty($resolved['rel'])) rel="{{ $resolved['rel'] }}" @endif
                                   @click="mobileNavOpen = false" 
                                   class="block py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ $isCurrent ? 'bg-slate-100 dark:bg-slate-800 font-bold text-[#003C58] dark:text-cyan-400' : '' }}">
                                    {{ $item['label'] }}
                                </a>
                            @else
                                <!-- Accordion for Dropdowns -->
                                <div class="border-b border-slate-100 dark:border-slate-800/80 pb-2">
                                    <button type="button" @click="activeMobileSubmenu = (activeMobileSubmenu === '{{ $mi }}' ? null : '{{ $mi }}')" 
                                            class="w-full flex items-center justify-between py-2.5 px-3 rounded-xl text-slate-800 dark:text-slate-200 hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer transition-colors">
                                        <span>{{ $item['label'] }}</span>
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="activeMobileSubmenu === '{{ $mi }}' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    <div x-show="activeMobileSubmenu === '{{ $mi }}'" x-transition class="pl-4 pt-1 space-y-1 text-xs font-medium text-slate-600 dark:text-slate-400">
                                        @foreach($item['children'] as $child)
                                            @php
                                                $childResolved = \App\Services\LinkResolver::resolve($child['link'] ?? []);
                                                $hasGrandChildren = !empty($child['children']) && count($child['children']) > 0;
                                            @endphp
                                            <div>
                                                <a href="{{ $childResolved['url'] }}" 
                                                   target="{{ $childResolved['target'] }}" 
                                                   @if(!empty($childResolved['rel'])) rel="{{ $childResolved['rel'] }}" @endif
                                                   @click="mobileNavOpen = false" 
                                                   class="block py-1.5 px-2.5 rounded-lg hover:text-[#003C58] dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/60 font-semibold">
                                                    {{ $child['label'] }}
                                                </a>
                                                @if($hasGrandChildren)
                                                    <div class="pl-4 space-y-0.5 pb-1">
                                                        @foreach($child['children'] as $gc)
                                                            @php
                                                                $gcResolved = \App\Services\LinkResolver::resolve($gc['link'] ?? []);
                                                            @endphp
                                                            <a href="{{ $gcResolved['url'] }}" 
                                                               target="{{ $gcResolved['target'] }}"
                                                               @click="mobileNavOpen = false" 
                                                               class="block py-1 px-2 rounded text-[11px] text-slate-500 hover:text-cyan-500">
                                                                &bull; {{ $gc['label'] }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Drawer Footer CTA & Emergency Info -->
                    <div class="p-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 space-y-3">
                        @if(!empty($headerCta['enabled']))
                        <a href="{{ $resolvedCta['url'] }}" 
                           target="{{ $resolvedCta['target'] }}" 
                           @if(!empty($resolvedCta['rel'])) rel="{{ $resolvedCta['rel'] }}" @endif
                           @click="mobileNavOpen = false" 
                           class="w-full inline-flex items-center justify-center py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-white shadow-md"
                           style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                            {{ $headerCta['label'] ?: 'Request Instant RFQ' }}
                        </a>
                        @endif

                        @if(!empty($topbarPhone))
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 text-center font-medium">
                            24/7 Port Helpline: <a href="tel:{{ preg_replace('/[^\d+]/', '', $topbarPhone) }}" class="font-bold text-[#003C58] dark:text-cyan-400">{{ $topbarPhone }}</a>
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

                    <!-- Col 2: Business Units -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">Business Units</h4>
                        <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li><a href="{{ route('home') }}#divisions" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Marine Turbochargers</a></li>
                            <li><a href="{{ route('home') }}#divisions" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Captive Power Generation</a></li>
                            <li><a href="{{ route('home') }}#divisions" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Spare Parts Distribution</a></li>
                            <li><a href="{{ route('home') }}#divisions" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Non-Destructive Testing (NDT)</a></li>
                            <li><a href="{{ route('home') }}#divisions" class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors">Gas Compressor Solutions</a></li>
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
                    <div class="flex items-center gap-6">
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
