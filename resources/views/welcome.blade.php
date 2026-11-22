<x-layouts.frontend>
    
    <!-- =====================================================================
         SECTION 1: HIGH-IMPACT INDUSTRIAL HERO BANNER (Turbo Internacional Style)
         Soft executive frosted backdrop so the precision turbine tachometer instrument dial rests with razor-sharp stability!
         ===================================================================== -->
    @php
        $heroEnabled = (bool) \App\Models\Setting::get('home_hero_enabled', true);
        $heroWidth = \App\Models\Setting::get('home_hero_width', 'container');
        $heroWidthClass = match($heroWidth) {
            'fluid' => 'w-full px-4 sm:px-8',
            'fluid_full' => 'w-full px-2 sm:px-4',
            'ultrawide' => 'w-full max-w-[1728px] mx-auto px-4 sm:px-8',
            'desktop' => 'w-full max-w-7xl mx-auto px-4 sm:px-8',
            'narrow' => 'w-full max-w-6xl mx-auto px-4 sm:px-8',
            'content_focused' => 'w-full max-w-5xl mx-auto px-4 sm:px-8',
            default => 'w-full max-w-[1536px] mx-auto px-4 sm:px-8',
        };

        $heroPadding = \App\Models\Setting::get('home_hero_padding', 'standard');
        $heroPaddingClass = match($heroPadding) {
            'compact' => 'py-12 sm:py-16 lg:py-20',
            'spacious' => 'py-20 sm:py-28 lg:py-32',
            'extra_spacious' => 'py-24 sm:py-32 lg:py-36',
            default => 'py-16 sm:py-24 lg:py-28',
        };

        $heroGridEnabled = (bool) \App\Models\Setting::get('home_hero_grid_enabled', true);

        $heroBgType = \App\Models\Setting::get('home_hero_bg_type', \App\Models\Setting::get('theme_hero_backdrop', 'frosted'));
        $heroGlassOpacity = max(10, min(90, (int) \App\Models\Setting::get('home_hero_glass_opacity', 90)));
        $heroLightBg = \App\Models\Setting::get('home_hero_light_bg', '#ffffff');
        $heroLightText = \App\Models\Setting::get('home_hero_light_text', '#0f172a');
        $heroDarkBg = \App\Models\Setting::get('home_hero_dark_bg', '#07131e');
        $heroDarkText = \App\Models\Setting::get('home_hero_dark_text', '#f8fafc');

        $heroGradientDir = \App\Models\Setting::get('home_hero_gradient_dir', '135deg');
        $heroGradientFrom = \App\Models\Setting::get('home_hero_gradient_from', '#002538');
        $heroGradientVia = \App\Models\Setting::get('home_hero_gradient_via', '#003C58');
        $heroGradientTo = \App\Models\Setting::get('home_hero_gradient_to', '#07131e');

        $heroBackdropClass = match($heroBgType) {
            'transparent' => 'bg-transparent backdrop-blur-none',
            'subtle_tint' => 'bg-white/70 dark:bg-[#07131e]/70 backdrop-blur-xs',
            'solid_custom' => '',
            'gradient' => '',
            'glass' => 'backdrop-blur-md',
            default => 'bg-white/92 dark:bg-[#07131e]/90 backdrop-blur-xs',
        };

        // Badges
        $heroBadge1Enabled = (bool) \App\Models\Setting::get('home_hero_badge1_enabled', true);
        $heroBadge1Text = \App\Models\Setting::get('home_hero_badge1', 'Authorized Multi-Brand Turbocharger Engineering');
        $heroBadge1Icon = \App\Models\Setting::get('home_hero_badge1_icon', 'solid:shield-check');

        $heroBadge2Enabled = (bool) \App\Models\Setting::get('home_hero_badge2_enabled', true);
        $heroBadge2Text = \App\Models\Setting::get('home_hero_badge2', 'ISO 9001:2015 • DNV Certified');
        $heroBadge2Icon = \App\Models\Setting::get('home_hero_badge2_icon', 'solid:award');

        // Layout: Column Split, Order & Content Alignment
        $heroColSplit = \App\Models\Setting::get('home_hero_column_split', '7_5');
        $heroColOrder = \App\Models\Setting::get('home_hero_column_order', 'content_first');
        $heroAlign = \App\Models\Setting::get('home_hero_alignment', 'left');

        $leftColSpan = match($heroColSplit) {
            '6_6' => 'lg:col-span-6',
            '8_4' => 'lg:col-span-8',
            '5_7' => 'lg:col-span-5',
            default => 'lg:col-span-7',
        };
        $rightColSpan = match($heroColSplit) {
            '6_6' => 'lg:col-span-6',
            '8_4' => 'lg:col-span-4',
            '5_7' => 'lg:col-span-7',
            default => 'lg:col-span-5',
        };

        $leftOrder = $heroColOrder === 'visual_first' ? 'order-2 lg:order-2' : 'order-1 lg:order-1';
        $rightOrder = $heroColOrder === 'visual_first' ? 'order-1 lg:order-1' : 'order-2 lg:order-2';

        $alignTextClass = match($heroAlign) {
            'center' => 'text-center items-center',
            'right' => 'text-right items-end',
            default => 'text-left items-start',
        };
        $alignFlexClass = match($heroAlign) {
            'center' => 'justify-center',
            'right' => 'justify-end',
            default => 'justify-start',
        };
        $alignSubtitleMargin = match($heroAlign) {
            'center' => 'mx-auto',
            'right' => 'ml-auto mr-0',
            default => 'mr-auto ml-0',
        };

        // Typography & Multicolor Headline
        $heroTitle = \App\Models\Setting::get('home_hero_title', 'Precision Turbocharger Overhauls & Marine Propulsion Support.');
        $heroTitleHighlightEnabled = (bool) \App\Models\Setting::get('home_hero_title_highlight_enabled', true);
        $heroTitlePrefix = \App\Models\Setting::get('home_hero_title_prefix', 'Precision Turbocharger Overhauls &');
        $heroTitleHighlight = \App\Models\Setting::get('home_hero_title_highlight', 'Marine Propulsion Support.');
        $heroTitleSuffix = \App\Models\Setting::get('home_hero_title_suffix', '');
        $heroTitleHighlightStyle = \App\Models\Setting::get('home_hero_title_highlight_style', 'gradient_cyan');
        $heroTitleHighlightCustom = \App\Models\Setting::get('home_hero_title_highlight_custom', '#0ea5e9');
        $heroTitleSize = \App\Models\Setting::get('home_hero_title_size', 'standard');
        $heroTitleWeight = \App\Models\Setting::get('home_hero_title_weight', 'black');
        $heroTitleGlow = \App\Models\Setting::get('home_hero_title_glow', 'none');
        $heroTitleGradDir = \App\Models\Setting::get('home_hero_title_grad_dir', '135deg');
        $heroTitleGradFrom = \App\Models\Setting::get('home_hero_title_grad_from', '#00d2ff');
        $heroTitleGradVia = \App\Models\Setting::get('home_hero_title_grad_via', '#0084ff');
        $heroTitleGradTo = \App\Models\Setting::get('home_hero_title_grad_to', '#003C58');

        $heroTitleSizeClass = match($heroTitleSize) {
            'compact' => 'text-2xl sm:text-4xl lg:text-5xl',
            'large' => 'text-4xl sm:text-5xl lg:text-7xl',
            'extra_large' => 'text-4xl sm:text-6xl lg:text-8xl',
            default => 'text-3xl sm:text-5xl lg:text-6xl',
        };
        $heroTitleWeightClass = match($heroTitleWeight) {
            'bold' => 'font-bold',
            'extrabold' => 'font-extrabold',
            default => 'font-black',
        };
        $heroTitleGlowClass = match($heroTitleGlow) {
            'subtle' => 'drop-shadow-xs',
            'cyan' => 'drop-shadow-[0_4px_24px_rgba(6,182,212,0.45)]',
            'amber' => 'drop-shadow-[0_4px_24px_rgba(245,158,11,0.45)]',
            'deep' => 'drop-shadow-lg',
            default => 'drop-shadow-none',
        };

        $heroHighlightClass = match($heroTitleHighlightStyle) {
            'gradient_amber' => 'bg-gradient-to-r from-amber-400 via-orange-400 to-amber-300 bg-clip-text text-transparent drop-shadow-xs',
            'brand_primary' => 'text-[#003C58] dark:text-cyan-400',
            'gradient_emerald' => 'bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-200 bg-clip-text text-transparent drop-shadow-xs',
            'gradient_custom' => 'bg-clip-text text-transparent',
            'solid_custom' => '',
            default => 'bg-gradient-to-r from-cyan-500 via-teal-400 to-cyan-300 bg-clip-text text-transparent drop-shadow-xs',
        };

        $heroHighlightInlineStyle = '';
        if ($heroTitleHighlightStyle === 'solid_custom') {
            $heroHighlightInlineStyle = 'color: ' . $heroTitleHighlightCustom . ';';
        } elseif ($heroTitleHighlightStyle === 'gradient_custom') {
            $heroHighlightInlineStyle = 'background-image: linear-gradient(' . $heroTitleGradDir . ', ' . $heroTitleGradFrom . ($heroTitleGradVia ? ', ' . $heroTitleGradVia : '') . ', ' . $heroTitleGradTo . ');';
        }

        $heroSubtitle = \App\Models\Setting::get('home_hero_subtitle', 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil & gas terminals.');

        // Extra Content: Feature Bullets
        $heroBulletsEnabled = (bool) \App\Models\Setting::get('home_hero_bullets_enabled', true);
        $heroBullet1Enabled = (bool) \App\Models\Setting::get('home_hero_bullet1_enabled', true);
        $heroBullet1Text = \App\Models\Setting::get('home_hero_bullet1_text', '24/7 Rapid Outer Anchorage Squads');
        $heroBullet1Icon = \App\Models\Setting::get('home_hero_bullet1_icon', 'solid:circle-check');
        $heroBullet2Enabled = (bool) \App\Models\Setting::get('home_hero_bullet2_enabled', true);
        $heroBullet2Text = \App\Models\Setting::get('home_hero_bullet2_text', 'Dynamic Balancing to 100,000 RPM');
        $heroBullet2Icon = \App\Models\Setting::get('home_hero_bullet2_icon', 'solid:circle-check');
        $heroBullet3Enabled = (bool) \App\Models\Setting::get('home_hero_bullet3_enabled', true);
        $heroBullet3Text = \App\Models\Setting::get('home_hero_bullet3_text', "Class Society Certified Reports (DNV • Lloyd's)");
        $heroBullet3Icon = \App\Models\Setting::get('home_hero_bullet3_icon', 'solid:circle-check');
        $heroBullet4Enabled = (bool) \App\Models\Setting::get('home_hero_bullet4_enabled', true);
        $heroBullet4Text = \App\Models\Setting::get('home_hero_bullet4_text', 'OEM Spare Parts Logistics & Exchange Cartridges');
        $heroBullet4Icon = \App\Models\Setting::get('home_hero_bullet4_icon', 'solid:circle-check');

        // Extra Content: Notice Bar
        $heroNoticeEnabled = (bool) \App\Models\Setting::get('home_hero_notice_enabled', false);
        $heroNoticeText = \App\Models\Setting::get('home_hero_notice_text', 'Emergency Port Calls & Anchorage Squads on standby 24/7');
        $heroNoticeIcon = \App\Models\Setting::get('home_hero_notice_icon', 'solid:bullhorn');
        $heroNoticeUrl = \App\Models\Setting::get('home_hero_notice_url', '/contact#emergency');

        // CTAs
        $heroCta1Enabled = (bool) \App\Models\Setting::get('home_hero_cta1_enabled', true);
        $heroCta1Text = \App\Models\Setting::get('home_hero_cta1_text', 'Explore Overhaul Services');
        $heroCta1Url = \App\Models\Setting::get('home_hero_cta1_url', route('services'));
        $heroCta1Icon = \App\Models\Setting::get('home_hero_cta1_icon', 'solid:arrow-right');
        $heroCta1Style = \App\Models\Setting::get('home_hero_cta1_style', 'primary_gradient');

        $heroCta2Enabled = (bool) \App\Models\Setting::get('home_hero_cta2_enabled', true);
        $heroCta2Text = \App\Models\Setting::get('home_hero_cta2_text', 'Request Instant RFQ');
        $heroCta2Url = \App\Models\Setting::get('home_hero_cta2_url', route('contact') . '#rfq');
        $heroCta2Icon = \App\Models\Setting::get('home_hero_cta2_icon', 'solid:clipboard-document-list');
        $heroCta2Style = \App\Models\Setting::get('home_hero_cta2_style', 'surface_border');

        // Metrics Strip
        $heroMetricsEnabled = (bool) \App\Models\Setting::get('home_hero_metrics_enabled', true);
        $heroMetric1Val = \App\Models\Setting::get('home_metric1_value', '100,000');
        $heroMetric1Lbl = \App\Models\Setting::get('home_metric1_label', 'RPM Dynamic Balancing');
        $heroMetric2Val = \App\Models\Setting::get('home_metric2_value', '24/7/365');
        $heroMetric2Lbl = \App\Models\Setting::get('home_metric2_label', 'Flying Squads to Port');
        $heroMetric3Val = \App\Models\Setting::get('home_metric3_value', '10,000+');
        $heroMetric3Lbl = \App\Models\Setting::get('home_metric3_label', 'OEM Spares in Stock');

        // Visual Showcase
        $heroVisualEnabled = (bool) \App\Models\Setting::get('home_hero_visual_enabled', true);
        $heroVisualType = \App\Models\Setting::get('home_hero_visual_type', 'tachometer');
        $heroVisualSize = \App\Models\Setting::get('home_hero_visual_size', 'standard');
        $heroVisualBgStyle = \App\Models\Setting::get('home_hero_visual_bg_style', 'cockpit_card');
        $heroVisualCustomBg = \App\Models\Setting::get('home_hero_visual_custom_bg', '#07131e');
        $heroVisualBorder = \App\Models\Setting::get('home_hero_visual_border', 'border');

        $heroTachoAnimated = (bool) \App\Models\Setting::get('home_hero_tacho_animated', true);
        $heroTachoSpeed = \App\Models\Setting::get('home_hero_tacho_speed', 'normal');
        $heroTachoDirection = \App\Models\Setting::get('home_hero_tacho_direction', 'normal');

        $heroTachoTopEnabled = (bool) \App\Models\Setting::get('home_hero_tacho_top_enabled', true);
        $heroTachoTop = \App\Models\Setting::get('home_hero_tacho_top', '0° / RPM');
        $heroTachoRightEnabled = (bool) \App\Models\Setting::get('home_hero_tacho_right_enabled', true);
        $heroTachoRight = \App\Models\Setting::get('home_hero_tacho_right', '90°');
        $heroTachoBottomEnabled = (bool) \App\Models\Setting::get('home_hero_tacho_bottom_enabled', true);
        $heroTachoBottom = \App\Models\Setting::get('home_hero_tacho_bottom', '180°');
        $heroTachoLeftEnabled = (bool) \App\Models\Setting::get('home_hero_tacho_left_enabled', true);
        $heroTachoLeft = \App\Models\Setting::get('home_hero_tacho_left', '270°');

        $heroTachoCenterEnabled = (bool) \App\Models\Setting::get('home_hero_tacho_center_enabled', false);
        $heroTachoCenterLabel = \App\Models\Setting::get('home_hero_tacho_center_label', 'DYNAMIC ROTOR');
        $heroTachoCenterVal = \App\Models\Setting::get('home_hero_tacho_center_val', '100K RPM');

        $heroHudEnabled = (bool) \App\Models\Setting::get('home_hero_hud_enabled', true);
        $heroHudL1Enabled = (bool) \App\Models\Setting::get('home_hero_hud_l1_enabled', true);
        $heroHudL1Label = \App\Models\Setting::get('home_hero_hud_l1_label', 'EQUIPMENT:');
        $heroHudL1Val = \App\Models\Setting::get('home_hero_hud_l1_val', 'HEAVY EXHAUST TURBOCHARGER');
        $heroHudL2Enabled = (bool) \App\Models\Setting::get('home_hero_hud_l2_enabled', true);
        $heroHudL2Label = \App\Models\Setting::get('home_hero_hud_l2_label', 'AUTHORIZED:');
        $heroHudL2Val = \App\Models\Setting::get('home_hero_hud_l2_val', 'ABB • MAN • KBB • MHI • NAPIER');
        $heroHudL3Enabled = (bool) \App\Models\Setting::get('home_hero_hud_l3_enabled', true);
        $heroHudL3Label = \App\Models\Setting::get('home_hero_hud_l3_label', 'WORKSHOP RADIUS:');
        $heroHudL3Val = \App\Models\Setting::get('home_hero_hud_l3_val', 'CHATTOGRAM • MONGLA • GLOBAL');

        // Dynamic visual dimension classes
        $heroVisualPadding = \App\Models\Setting::get('home_hero_visual_padding', 'spacious');
        $visualCardPaddingClass = match($heroVisualPadding) {
            'none' => 'p-0',
            'compact' => 'p-3 sm:p-4',
            'standard' => 'p-5 sm:p-7',
            'extra_spacious' => 'p-8 sm:p-12',
            default => 'p-6 sm:p-8',
        };

        $visualFrameMaxW = match($heroVisualSize) {
            'compact' => 'max-w-[300px]',
            'large' => 'max-w-[420px]',
            'extra_large' => 'max-w-[480px]',
            default => 'max-w-[360px]',
        };
        $dialSizeClass = match($heroVisualSize) {
            'compact' => 'w-44 h-44',
            'large' => 'w-64 sm:w-72 h-64 sm:h-72',
            'extra_large' => 'w-72 sm:w-80 h-72 sm:h-80',
            default => 'w-52 sm:w-60 h-52 sm:h-60',
        };
        $turbineSizeClass = match($heroVisualSize) {
            'compact' => 'w-28 h-28',
            'large' => 'w-44 sm:w-48 h-44 sm:h-48',
            'extra_large' => 'w-52 sm:w-56 h-52 sm:h-56',
            default => 'w-36 h-36 sm:w-40 sm:h-40',
        };
        $visualCardClass = match($heroVisualBgStyle) {
            'frosted_glass' => 'bg-white/80 dark:bg-[#0b1b2b]/75 backdrop-blur-md border border-white/60 dark:border-slate-800/80 shadow-2xl',
            'transparent' => 'bg-transparent border-0 shadow-none',
            'ambient_glow' => 'bg-white dark:bg-[#0b1b2b] border border-cyan-500/30 dark:border-cyan-500/40 shadow-[0_0_50px_rgba(6,182,212,0.18)] dark:shadow-[0_0_60px_rgba(6,182,212,0.25)]',
            'solid_custom' => 'shadow-xl',
            default => 'bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl',
        };
        $turbineAnimationClass = $heroTachoAnimated ? ('animate-turbine turbine-speed-' . $heroTachoSpeed . ($heroTachoDirection === 'reverse' ? ' turbine-reverse' : '')) : '';
    @endphp

    @if($heroEnabled)
    <style>
        @if($heroBgType === 'solid_custom')
            #home-hero-section {
                background-color: {{ $heroLightBg }} !important;
                color: {{ $heroLightText }} !important;
            }
            html.dark #home-hero-section {
                background-color: {{ $heroDarkBg }} !important;
                color: {{ $heroDarkText }} !important;
            }
        @elseif($heroBgType === 'gradient')
            #home-hero-section {
                background: linear-gradient({{ $heroGradientDir }}, {{ $heroGradientFrom }}{{ $heroGradientVia ? ', ' . $heroGradientVia : '' }}, {{ $heroGradientTo }}) !important;
                color: #ffffff !important;
            }
        @elseif($heroBgType === 'glass')
            #home-hero-section {
                background-color: rgba(255, 255, 255, {{ $heroGlassOpacity / 100 }}) !important;
            }
            html.dark #home-hero-section {
                background-color: rgba(7, 19, 30, {{ $heroGlassOpacity / 100 }}) !important;
            }
        @endif
    </style>

    <section id="home-hero-section" class="relative overflow-hidden {{ $heroBackdropClass }} text-slate-900 dark:text-white {{ $heroPaddingClass }} border-b border-slate-200/90 dark:border-slate-800 transition-colors duration-200">
        
        <!-- Subtle Industrial Geometric Grid Background -->
        @if($heroGridEnabled)
        <div class="absolute inset-0 opacity-[0.025] dark:opacity-[0.04] pointer-events-none bg-[radial-gradient(#003C58_1px,transparent_1px)] dark:bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
        @endif

        <div class="{{ $heroWidthClass }} relative z-10">
            <div class="grid grid-cols-1 {{ $heroVisualEnabled ? 'lg:grid-cols-12' : 'grid-cols-1 max-w-4xl' }} gap-12 lg:gap-10 items-center">
                
                <!-- Left Column: Copy & Actions -->
                <div class="{{ $heroVisualEnabled ? $leftColSpan : 'w-full' }} {{ $leftOrder }} space-y-6 sm:space-y-8 p-6 sm:p-8 lg:p-0 rounded-3xl bg-white/85 dark:bg-[#07131e]/75 lg:bg-transparent lg:dark:bg-transparent backdrop-blur-xs lg:backdrop-blur-none border border-white/60 dark:border-slate-800/60 lg:border-none flex flex-col {{ $alignTextClass }}">
                    
                    <!-- Clean Corporate Badges -->
                    @if(($heroBadge1Enabled && $heroBadge1Text) || ($heroBadge2Enabled && $heroBadge2Text))
                    <div class="reveal-init reveal-fade-up flex flex-wrap items-center gap-2.5 {{ $alignFlexClass }}">
                        @if($heroBadge1Enabled && $heroBadge1Text)
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-800 shadow-2xs">
                            @if($heroBadge1Icon)
                                <x-icon :name="$heroBadge1Icon" class="w-3.5 h-3.5 shrink-0" />
                            @endif
                            <span>{{ __($heroBadge1Text) }}</span>
                        </span>
                        @endif

                        @if($heroBadge2Enabled && $heroBadge2Text)
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-white dark:bg-[#0a1926] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            @if($heroBadge2Icon)
                                <x-icon :name="$heroBadge2Icon" class="w-3.5 h-3.5 shrink-0 text-[#003C58] dark:text-cyan-400" />
                            @endif
                            <span>{{ __($heroBadge2Text) }}</span>
                        </span>
                        @endif
                    </div>
                    @endif

                    <!-- Main Headline (With Multicolor Highlight Scope) -->
                    @if($heroTitle)
                    <h1 class="reveal-init reveal-fade-up reveal-delay-100 {{ $heroTitleSizeClass }} {{ $heroTitleWeightClass }} leading-[1.12] tracking-tight font-heading text-slate-900 dark:text-white {{ $heroTitleGlowClass }}">
                        @if($heroTitleHighlightEnabled && $heroTitleHighlight)
                            @if($heroTitlePrefix)
                                <span>{{ __($heroTitlePrefix) }}</span>
                            @endif
                            <span class="{{ $heroHighlightClass }}" @if($heroHighlightInlineStyle) style="{{ $heroHighlightInlineStyle }}" @endif>
                                {{ __($heroTitleHighlight) }}
                            </span>
                            @if($heroTitleSuffix)
                                <span>{{ __($heroTitleSuffix) }}</span>
                            @endif
                        @else
                            {{ __($heroTitle) }}
                        @endif
                    </h1>
                    @endif

                    <!-- Technical Subtitle -->
                    @if($heroSubtitle)
                    <p class="reveal-init reveal-fade-up reveal-delay-200 text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl font-body font-medium {{ $alignSubtitleMargin }}">
                        {{ __($heroSubtitle) }}
                    </p>
                    @endif

                    <!-- Extra Content: Capability Feature Bullets -->
                    @if($heroBulletsEnabled)
                    <div class="reveal-init reveal-fade-up reveal-delay-250 flex flex-wrap items-center gap-x-6 gap-y-2.5 pt-1 {{ $alignFlexClass }}">
                        @if($heroBullet1Enabled && $heroBullet1Text)
                        <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <x-icon :name="$heroBullet1Icon ?: 'solid:circle-check'" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>{{ __($heroBullet1Text) }}</span>
                        </div>
                        @endif
                        @if($heroBullet2Enabled && $heroBullet2Text)
                        <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <x-icon :name="$heroBullet2Icon ?: 'solid:circle-check'" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>{{ __($heroBullet2Text) }}</span>
                        </div>
                        @endif
                        @if($heroBullet3Enabled && $heroBullet3Text)
                        <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <x-icon :name="$heroBullet3Icon ?: 'solid:circle-check'" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>{{ __($heroBullet3Text) }}</span>
                        </div>
                        @endif
                        @if($heroBullet4Enabled && $heroBullet4Text)
                        <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                            <x-icon :name="$heroBullet4Icon ?: 'solid:circle-check'" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>{{ __($heroBullet4Text) }}</span>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Extra Content: Emergency Advisory Notice Bar -->
                    @if($heroNoticeEnabled && $heroNoticeText)
                    <div class="reveal-init reveal-fade-up reveal-delay-250 w-full p-3.5 rounded-2xl bg-cyan-500/10 border border-cyan-500/25 flex items-center justify-between gap-3 text-xs text-cyan-900 dark:text-cyan-200">
                        <div class="flex items-center gap-2.5">
                            <x-icon :name="$heroNoticeIcon ?: 'solid:bullhorn'" class="w-4 h-4 text-cyan-600 dark:text-cyan-400 shrink-0" />
                            <span class="font-medium">{{ __($heroNoticeText) }}</span>
                        </div>
                        @if(!empty($heroNoticeUrl))
                        <a href="{{ $heroNoticeUrl }}" class="shrink-0 font-bold underline hover:no-underline text-cyan-700 dark:text-cyan-300 flex items-center gap-1">
                            <span>Details &rarr;</span>
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- Dual Call-to-Action Buttons -->
                    @if(($heroCta1Enabled && $heroCta1Text) || ($heroCta2Enabled && $heroCta2Text))
                    <div class="reveal-init reveal-fade-up reveal-delay-300 flex flex-wrap items-center gap-4 pt-2 {{ $alignFlexClass }}">
                        @if($heroCta1Enabled && $heroCta1Text)
                            @php
                                $cta1StyleClass = match($heroCta1Style) {
                                    'solid_dark' => 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:opacity-90',
                                    'outline' => 'border border-[#003C58] dark:border-cyan-400 text-[#003C58] dark:text-cyan-400 bg-transparent hover:bg-[#003C58]/5 dark:hover:bg-cyan-500/10',
                                    default => 'text-white shadow-lg',
                                };
                                $cta1InlineStyle = $heroCta1Style === 'primary_gradient' ? 'background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); border-radius: var(--button-radius);' : 'border-radius: var(--button-radius);';
                            @endphp
                            <a href="{{ $heroCta1Url }}" 
                               class="inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider active:scale-95 transition-all {{ $cta1StyleClass }}"
                                style="{{ $cta1InlineStyle }}">
                                <span>{{ __($heroCta1Text) }}</span>
                                @if($heroCta1Icon)
                                    <x-icon :name="$heroCta1Icon" class="w-4 h-4 shrink-0" />
                                @endif
                            </a>
                        @endif

                        @if($heroCta2Enabled && $heroCta2Text)
                            @php
                                $cta2StyleClass = match($heroCta2Style) {
                                    'outline' => 'border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 bg-transparent hover:bg-slate-100 dark:hover:bg-slate-800',
                                    'solid_dark' => 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 hover:opacity-90',
                                    default => 'border border-slate-300 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200',
                                };
                            @endphp
                            <a href="{{ $heroCta2Url }}" 
                               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider active:scale-95 transition-all {{ $cta2StyleClass }}"
                                style="border-radius: var(--button-radius);">
                                <span>{{ __($heroCta2Text) }}</span>
                                @if($heroCta2Icon)
                                    <x-icon :name="$heroCta2Icon" class="w-4 h-4 shrink-0 text-slate-500 dark:text-slate-400" />
                                @endif
                            </a>
                        @endif
                    </div>
                    @endif

                    <!-- Key Technical Highlights Strip -->
                    @if($heroMetricsEnabled)
                    <div class="reveal-init reveal-fade-up reveal-delay-400 w-full pt-6 border-t border-slate-200/80 dark:border-slate-800 grid grid-cols-3 gap-4 text-xs">
                        <div>
                            <span class="block text-2xl sm:text-3xl font-black text-[#003C58] dark:text-cyan-400 font-heading">
                                {{ __($heroMetric1Val) }}
                            </span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                {{ __($heroMetric1Lbl) }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-2xl sm:text-3xl font-black text-slate-800 dark:text-white font-heading">
                                {{ __($heroMetric2Val) }}
                            </span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                {{ __($heroMetric2Lbl) }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 font-heading">
                                {{ __($heroMetric3Val) }}
                            </span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                {{ __($heroMetric3Lbl) }}
                            </span>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Right Column: PRECISION TURBINE INSTRUMENT DIAL -->
                @if($heroVisualEnabled)
                <div class="{{ $rightColSpan }} {{ $rightOrder }} relative reveal-init reveal-scale reveal-delay-200">
                    <div class="relative rounded-3xl {{ $visualCardPaddingClass }} {{ $visualCardClass }} transition-all"
                         @if($heroVisualBgStyle === 'solid_custom') style="background-color: {{ $heroVisualCustomBg }};" @endif>
                        
                        <!-- High-Contrast Tachometer Frame with Calibrated Tick Marks -->
                        <div class="relative w-full aspect-square {{ $visualFrameMaxW }} mx-auto flex items-center justify-center mb-6">
                            
                            <!-- Outer Calibrated Graduation Ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-slate-300/80 dark:border-slate-700 flex items-center justify-center">
                                @if($heroTachoTopEnabled && $heroTachoTop)
                                    <div class="absolute top-1 text-[9px] font-mono font-bold text-slate-500 dark:text-slate-400">{{ $heroTachoTop }}</div>
                                @endif
                                @if($heroTachoRightEnabled && $heroTachoRight)
                                    <div class="absolute right-1 text-[9px] font-mono font-bold text-slate-500 dark:text-slate-400">{{ $heroTachoRight }}</div>
                                @endif
                                @if($heroTachoBottomEnabled && $heroTachoBottom)
                                    <div class="absolute bottom-1 text-[9px] font-mono font-bold text-slate-500 dark:text-slate-400">{{ $heroTachoBottom }}</div>
                                @endif
                                @if($heroTachoLeftEnabled && $heroTachoLeft)
                                    <div class="absolute left-1 text-[9px] font-mono font-bold text-slate-500 dark:text-slate-400">{{ $heroTachoLeft }}</div>
                                @endif
                            </div>
                            
                            <!-- Middle Rotating Indicator Ring -->
                            <div class="absolute inset-4 rounded-full border border-dashed border-[#003C58]/35 dark:border-slate-700 {{ $turbineAnimationClass }}"></div>
                            
                            <!-- Inner Recessed Instrument Center -->
                            <div class="relative z-10 {{ $dialSizeClass }} rounded-full bg-slate-50 dark:bg-[#030c14] border-4 border-slate-200 dark:border-slate-800 shadow-inner flex items-center justify-center overflow-hidden">
                                
                                <!-- Subtle Radial Grid Inside Dial -->
                                <div class="absolute inset-0 opacity-20 dark:opacity-10 bg-[radial-gradient(#003C58_1px,transparent_1px)] dark:bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px]"></div>
                                
                                <!-- Center Readout Overlay (Optional) -->
                                @if($heroTachoCenterEnabled)
                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 text-center pointer-events-none z-30 px-2 py-0.5 rounded-md bg-slate-900/85 text-white border border-cyan-500/30 backdrop-blur-xs">
                                    <div class="text-[7px] font-mono font-bold tracking-widest text-cyan-300 leading-tight">{{ $heroTachoCenterLabel }}</div>
                                    <div class="text-[9px] font-mono font-black text-white leading-tight">{{ $heroTachoCenterVal }}</div>
                                </div>
                                @endif

                                <!-- The Spinning Turbine -->
                                @php
                                    $heroTurbineLight = \App\Models\Setting::get('site_icon', 'assets/images/icon.png');
                                    $heroTurbineDark = \App\Models\Setting::get('site_icon_dark') ?: $heroTurbineLight;
                                    $heroTurbineLightUrl = str_starts_with($heroTurbineLight, 'http') ? $heroTurbineLight : asset($heroTurbineLight);
                                    $heroTurbineDarkUrl = str_starts_with($heroTurbineDark, 'http') ? $heroTurbineDark : asset($heroTurbineDark);
                                @endphp
                                <img src="{{ $heroTurbineLightUrl }}" 
                                     alt="Nordroy Precision Marine Turbine" 
                                     class="{{ $turbineSizeClass }} object-contain {{ $turbineAnimationClass }} drop-shadow-[0_4px_16px_rgba(0,60,88,0.22)] dark:hidden relative z-20" />
                                <img src="{{ $heroTurbineDarkUrl }}" 
                                     alt="Nordroy Precision Marine Turbine" 
                                     class="{{ $turbineSizeClass }} object-contain {{ $turbineAnimationClass }} drop-shadow-[0_6px_20px_rgba(0,0,0,0.6)] hidden dark:block relative z-20" />
                            </div>
                        </div>

                        <!-- Technical Specification HUD Box -->
                        @if($heroHudEnabled)
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs space-y-2 font-mono">
                            @if($heroHudL1Enabled)
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-[11px]">
                                <span>{{ $heroHudL1Label }}</span>
                                <span class="text-[#003C58] dark:text-cyan-400 font-bold">{{ $heroHudL1Val }}</span>
                            </div>
                            @endif
                            @if($heroHudL2Enabled)
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-[11px]">
                                <span>{{ $heroHudL2Label }}</span>
                                <span class="text-slate-800 dark:text-white font-bold">{{ $heroHudL2Val }}</span>
                            </div>
                            @endif
                            @if($heroHudL3Enabled)
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-[11px]">
                                <span>{{ $heroHudL3Label }}</span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $heroHudL3Val }}</span>
                            </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
    @endif

    <!-- =====================================================================
         DYNAMIC HOMEPAGE BODY SECTIONS (REORDERABLE HIERARCHY)
         ===================================================================== -->
    @php
        $defaultOrder = [
            'partners',
            'about',
            'services',
            'video_break',
            'blueprint',
            'projects',
            'videos',
            'photos',
            'metrics',
            'parts',
            'rfq',
        ];
        $storedOrder = \App\Models\Setting::get('home_sections_order');
        $sectionsOrder = $storedOrder ? (is_array($storedOrder) ? $storedOrder : (json_decode($storedOrder, true) ?: $defaultOrder)) : $defaultOrder;
    @endphp

    @foreach($sectionsOrder as $secKey)
        @if(str_starts_with($secKey, 'custom_'))
            @include('partials.home.custom_section', ['customKey' => $secKey])
        @elseif(view()->exists('partials.home.' . $secKey))
            @include('partials.home.' . $secKey)
        @endif
    @endforeach

</x-layouts.frontend>
