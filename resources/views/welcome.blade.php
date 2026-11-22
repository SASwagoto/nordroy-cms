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
         SECTION 2: OEM MULTI-BRAND PARTNER TICKER (Turbo Internacional Style)
         ===================================================================== -->
    <section id="partners" class="reveal-init reveal-fade py-8 bg-slate-100 dark:bg-[#06121d] border-b border-slate-200 dark:border-slate-800 overflow-hidden text-slate-600 dark:text-slate-400 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8 mb-4 text-center">
            <span class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                Multi-Brand Authorized Engineering &amp; Overhauls For Global OEM Platforms
            </span>
        </div>
        
        <div class="relative w-full overflow-hidden flex items-center">
            <div class="animate-ticker flex items-center gap-12 sm:gap-20 text-slate-700 dark:text-slate-300 font-heading font-extrabold text-sm sm:text-base tracking-widest uppercase">
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">Accelleron (ABB)</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">MAN Energy Solutions</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">KBB Kompressorenbau</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">Napier Turbochargers</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">Mitsubishi Heavy Industries (MET)</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">PBS Turbo</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">INNIO Waukesha</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">Ariel Compressors</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <!-- Duplicate for seamless infinite loop -->
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">Accelleron (ABB)</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">MAN Energy Solutions</span>
                <span class="text-slate-400 dark:text-cyan-500 font-black">&bull;</span>
                <span class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors cursor-default">KBB Kompressorenbau</span>
            </div>
        </div>
    </section>

    <!-- =====================================================================
         SECTION 3: CONGLOMERATE OVERVIEW & CORPORATE PILLARS (Dana Group Style)
         ===================================================================== -->
    <section id="about" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Corporate Presentation (7 cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-800">
                        Conglomerate Heritage &amp; Vision
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white font-heading leading-tight">
                        A Heritage of Heavy Industrial Power, Maritime Integrity, &amp; Turn-Key Engineering.
                    </h2>
                    
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Operating under the high standards of global marine engineering, Nordroy Marine &amp; Turbochargers unites heavy mechanical overhaul workshops, non-destructive metallurgical testing (NDT), dynamic rotor calibration, and comprehensive spare parts logistics under one unified corporate umbrella.
                    </p>

                    <!-- 3 Strategic Pillars -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                        <div class="reveal-init reveal-fade-up reveal-delay-100 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center text-[#003C58] dark:text-cyan-400 mb-3">
                                <x-icon name="solid:anchor" class="w-5 h-5" />
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">Global Port Reach</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">24/7 flying squads equipped for anchorage and berth call overhauls.</p>
                        </div>

                        <div class="reveal-init reveal-fade-up reveal-delay-200 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center text-[#003C58] dark:text-cyan-400 mb-3">
                                <x-icon name="solid:gauge-high" class="w-5 h-5" />
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">Calibrated Precision</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Computerized Schenck dynamic balancing up to 100,000 RPM.</p>
                        </div>

                        <div class="reveal-init reveal-fade-up reveal-delay-300 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/80 dark:bg-slate-800 flex items-center justify-center text-[#003C58] dark:text-cyan-400 mb-3">
                                <x-icon name="solid:certificate" class="w-5 h-5" />
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white font-heading">OEM Alliances</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Direct access to genuine replacement parts and calibrated drawings.</p>
                        </div>
                    </div>

                </div>

                <!-- Right: Executive Leadership Quote Box (Dana Group inspired) (5 cols) -->
                <div class="lg:col-span-5 reveal-init reveal-scale reveal-delay-200">
                    <div class="p-8 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-lg relative space-y-6">
                        <div class="text-[#003C58] dark:text-cyan-400 opacity-30 text-5xl font-serif leading-none">&ldquo;</div>
                        <blockquote class="text-sm sm:text-base text-slate-700 dark:text-slate-300 italic leading-relaxed">
                            "In maritime logistics and heavy power generation, downtime is measured in thousands of dollars per hour. Our mission is to restore engine efficiency with zero deviation from OEM tolerances."
                        </blockquote>
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#003C58] text-white flex items-center justify-center font-bold text-sm">
                                NR
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider font-heading">Technical Operations</h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Turbomachinery Overhaul Division</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- =====================================================================
         SECTION 5: PRECISION OVERHAUL SERVICES (Turbo Internacional Style)
         ===================================================================== -->
    <section id="services" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                    Workshop &amp; Port Capabilities
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                    Precision Overhaul Services
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Engineered according to manufacturer tolerance protocols with calibrated German Schenck balancing rigs.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Service 1 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">01 / BALANCING</span>
                        <x-icon name="solid:gauge" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Dynamic Rotor Balancing (100k RPM)</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Elimination of micro-vibrations with computerized dynamic balancing up to 100,000 RPM, certified with comprehensive tolerance test sheets.
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">02 / WELDING</span>
                        <x-icon name="solid:fire-flame-curved" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Turbine Blading &amp; TIG Welding</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Precision laser and micro-TIG rebuilding of eroded turbine blade profiles, shroud rings, and metallurgical crack restoration.
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="reveal-init reveal-fade-up reveal-delay-300 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">03 / CHRA</span>
                        <x-icon name="solid:arrows-rotate" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Cartridge (CHRA) Exchange</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pre-assembled, factory-balanced cartridge replacement modules for rapid turnaround times during tight vessel port calls.
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">04 / CHEMICAL</span>
                        <x-icon name="solid:spray-can" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Ultrasonic Chemical De-Carbonization</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Multi-stage heated ultrasonic bath cleaning to remove stubborn heavy fuel oil carbon glaze without damaging parent metal tolerances.
                    </p>
                </div>

                <!-- Service 5 -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">05 / FLYING SQUAD</span>
                        <x-icon name="solid:truck-fast" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">24/7 Port Emergency Flying Squads</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Marine engineers equipped with mobile inspection tools ready to board vessels at Chattogram, Mongla, or international outer anchorages.
                    </p>
                </div>

                <!-- Service 6 -->
                <div class="reveal-init reveal-fade-up reveal-delay-300 p-6 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm hover:border-[#003C58] dark:hover:border-cyan-500/50 transition-all space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold text-[#003C58] dark:text-cyan-400">06 / RETROFIT</span>
                        <x-icon name="solid:wrench" class="w-5 h-5 text-slate-400" />
                    </div>
                    <h3 class="text-base font-bold font-heading text-slate-900 dark:text-white">Retrofit &amp; Modernization Upgrades</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Replacement of outdated, obsolete turbochargers with modern, high-efficiency models for reduced fuel consumption and lower IMO emissions.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- =====================================================================
         TRANSPARENT MARINE VIDEO WINDOW BREAK (Turbo Internacional Style)
         Panoramic viewport over background marine video with adaptive executive glass glaze
         ===================================================================== -->
    @if(\App\Models\Setting::get('theme_video_break_enabled', '1') == '1')
    <section class="py-16 sm:py-24 bg-transparent relative overflow-hidden flex items-center justify-center text-center">
        <div class="max-w-4xl mx-auto px-6 py-10 sm:px-12 sm:py-14 rounded-3xl bg-white/85 dark:bg-[#07131e]/85 backdrop-blur-md border border-slate-200/80 dark:border-slate-800 shadow-xl space-y-6 relative z-10">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-slate-100 dark:bg-slate-900 text-[#003C58] dark:text-cyan-400 border border-slate-200 dark:border-slate-800 shadow-2xs">
                Global Marine Engineering Excellence
            </span>
            <h2 class="text-3xl sm:text-5xl font-black font-heading tracking-tight text-slate-900 dark:text-white leading-tight">
                24/7 Rapid Emergency Response Across 40+ International Ports
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-2xl mx-auto leading-relaxed font-medium">
                Our certified flying squads board commercial vessels at anchorage or alongside berths to deliver on-site turbocharger diagnostics, cartridge swap-outs, and dynamic balancing.
            </p>
            <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('services') }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-[#003C58] hover:bg-[#002f45] text-white shadow-lg transition-all">
                    View Overhaul Capabilities &rarr;
                </a>
                <a href="{{ route('contact') }}" class="px-7 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    Contact Port Operations
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- =====================================================================
         SECTION 6: COMPANY MISSION, VISION & STRATEGIC VALUES (NEW)
         ===================================================================== -->
    <section class="py-20 lg:py-28 bg-slate-50 dark:bg-[#06121d] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                    Corporate Blueprint
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                    Mission, Vision &amp; Core Values
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Guiding principles that define our commitment to global shipowners, captive power operators, and heavy industries.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Mission Card -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                        <x-icon name="solid:bullseye" class="w-6 h-6" />
                    </div>
                    <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">Our Mission</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        To eliminate engine downtime by delivering certified, multi-brand turbocharger overhauls, high-speed dynamic balancing, and genuine OEM parts with unmatched turnaround speed, metallurgical precision, and total engineering transparency.
                    </p>
                </div>

                <!-- Vision Card -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                        <x-icon name="solid:eye" class="w-6 h-6" />
                    </div>
                    <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">Our Vision 2030</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        To be the premier independent maritime turbomachinery conglomerate in South Asia and global waters, recognized by international classification societies as the benchmark for quality, technical integrity, and decarbonization retrofits.
                    </p>
                </div>

                <!-- Core Values Card -->
                <div class="reveal-init reveal-fade-up reveal-delay-300 p-8 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 flex items-center justify-center text-[#003C58] dark:text-cyan-400">
                        <x-icon name="solid:shield-halved" class="w-6 h-6" />
                    </div>
                    <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">Core Values</h3>
                    <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-2">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span><strong>Zero-Defect Quality:</strong> Strict adherence to ISO 9001 protocols.</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span><strong>Rapid Port Agility:</strong> 24/7 readiness for urgent port calls.</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-[#003C58] dark:bg-cyan-400"></span><strong>Technical Rigor:</strong> Calibrated testing and certified reports.</li>
                    </ul>
                </div>

            </div>

        </div>
    </section>


    <!-- =====================================================================
         SECTION 8: OUR PROJECTS PORTFOLIO (Dana Group Style) (NEW)
         ===================================================================== -->
    <section id="projects" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-slate-50 dark:bg-[#0b1b2b] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                    Execution Proven Track Record
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                    Featured Industrial &amp; Marine Projects
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    A glimpse of recent turn-key overhauls completed on commercial ships and captive power plants.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Project 1 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition-all group">
                    <div class="h-60 bg-slate-100 dark:bg-slate-900 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('assets/images/gallery/gallery-plant.webp') }}" alt="7.2 MW Plant Overhaul" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <div class="absolute bottom-3 left-4 right-4 bg-white/90 dark:bg-[#07131e]/90 backdrop-blur-md px-4 py-2 rounded-xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs shadow-sm">
                            <span class="px-2.5 py-0.5 rounded-md bg-[#003C58] text-white font-bold uppercase tracking-wider text-[10px]">Captive Power</span>
                            <span class="text-[#003C58] dark:text-cyan-400 font-mono font-bold">7.2 MW Plant Overhaul</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">7.2 MW Waukesha Gas Generator Turbocharger Rebuild</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Complete disassembly, ultrasonic de-carbonization, and Schenck dynamic balancing for eight Waukesha gas engines at a major export spinning mill conglomerate.
                        </p>
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span>Client: Export Spinning Mills Ltd.</span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">Zero Downtime</span>
                        </div>
                    </div>
                </div>

                <!-- Project 2 -->
                <div class="reveal-init reveal-fade-up reveal-delay-200 rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg transition-all group">
                    <div class="h-60 bg-slate-100 dark:bg-slate-900 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('assets/images/gallery/gallery-turbine.webp') }}" alt="CHRA Cartridge Exchange" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <div class="absolute bottom-3 left-4 right-4 bg-white/90 dark:bg-[#07131e]/90 backdrop-blur-md px-4 py-2 rounded-xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between text-xs shadow-sm">
                            <span class="px-2.5 py-0.5 rounded-md bg-[#003C58] text-white font-bold uppercase tracking-wider text-[10px]">Maritime Vessel</span>
                            <span class="text-[#003C58] dark:text-cyan-400 font-mono font-bold">45,000 DWT Bulk Carrier</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">Emergency CHRA Cartridge Exchange at Chattogram Port</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Rapid 18-hour emergency response for an international bulk carrier experiencing high turbine vibrations, replacing the entire CHRA cartridge during cargo discharging.
                        </p>
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span>Location: Chattogram Outer Anchorage</span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">18h Turnaround</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- =====================================================================
         SECTION 9: VIDEO GALLERY WITH HOVER-TO-PLAY (Dana Group Style) (NEW)
         Thumbnails play video preview smoothly on mouse hover, without YouTube distractions.
         ===================================================================== -->
    <section id="videos" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                    Workshop &amp; Port In Action
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                    Video Gallery (Hover to Play)
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Hover your mouse over any video card to stream a live silent preview of our precision balancing and overhaul operations.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Video Card 1 -->
                <div class="reveal-init reveal-fade-up reveal-delay-100 rounded-3xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group"
                     x-data="{ isHovered: false }">
                    <a href="{{ route('project.details', ['slug' => 'marine-vessel-turbocharger-overhaul']) }}"
                       class="relative aspect-video bg-slate-100 dark:bg-black overflow-hidden flex items-center justify-center cursor-pointer block"
                       @mouseenter="isHovered = true; $refs.video1.play()"
                       @mouseleave="isHovered = false; $refs.video1.pause(); $refs.video1.currentTime = 0">
                        
                        <!-- Video element -->
                        <video x-ref="video1" loop muted playsinline preload="metadata" 
                               class="w-full h-full object-cover">
                            <source src="{{ asset('assets/videos/background-marine.mp4') }}" type="video/mp4">
                        </video>

                        <!-- Guaranteed Poster Image (Fades on hover, INSTANTLY returns on mouseleave so it NEVER stays black) -->
                        <img src="{{ asset('assets/images/gallery/gallery-balancing.webp') }}" 
                             alt="Dynamic Balancing Thumbnail"
                             x-show="!isHovered"
                             class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none transition-opacity duration-150" />

                        <!-- Play Button Overlay -->
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

                        <!-- Card Action Links -->
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

            </div>

        </div>
    </section>

    <!-- =====================================================================
         SECTION 10: PHOTO GALLERY & WORKSHOPS (NEW - With Full-Screen Image Lightbox Preview)
         ===================================================================== -->
    <section id="photos" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-slate-50 dark:bg-[#06121d] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-white dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                    Visual Facilities
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                    Workshop &amp; Engineering Gallery
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Click on any photo below to inspect high-resolution images of our port workshops and overhaul facilities.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                
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

            </div>

        </div>
    </section>

    <!-- =====================================================================
         SECTION 11: PROVEN PERFORMANCE METRICS
         ===================================================================== -->
    <section class="py-16 bg-slate-100 dark:bg-[#0b1b2b] border-b border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                
                <div>
                    <span class="block text-4xl sm:text-5xl font-black font-heading text-[#003C58] dark:text-cyan-400">30+</span>
                    <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">Years of Excellence</span>
                </div>

                <div>
                    <span class="block text-4xl sm:text-5xl font-black font-heading text-slate-900 dark:text-white">1,450+</span>
                    <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">Turbomachines Overhauled</span>
                </div>

                <div>
                    <span class="block text-4xl sm:text-5xl font-black font-heading text-[#003C58] dark:text-cyan-400">12+</span>
                    <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">Global Ports Covered</span>
                </div>

                <div>
                    <span class="block text-4xl sm:text-5xl font-black font-heading text-emerald-600 dark:text-emerald-400">100%</span>
                    <span class="text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 font-bold mt-1 block">Calibrated Schenck Testing</span>
                </div>

            </div>
        </div>
    </section>

    <!-- =====================================================================
         SECTION 12: GENUINE SPARE PARTS CATALOG (Turbo Internacional Style)
         ===================================================================== -->
    <section id="parts" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-white dark:bg-[#07131e] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                    OEM Replacement Inventory
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white">
                    Genuine Spare Parts Catalog
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Traceable serial numbers with mill test certificates ready for immediate dispatch.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                
                <div class="reveal-init reveal-fade-up reveal-delay-100 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:fan" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Turbine Blades</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Nimonic 80A / 90</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-150 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:circle-notch" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Rotor Shafts</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Forged Alloy Steel</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-200 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:ring" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Nozzle Rings</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">High-Temp Resistant</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-250 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:compact-disc" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Bearing Bushes</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Hydrodynamic Squeeze</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-300 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:asterisk" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Impellers</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Milled Titanium / Al</span>
                </div>

                <div class="reveal-init reveal-fade-up reveal-delay-350 p-5 rounded-2xl bg-slate-50 dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 text-center space-y-2 hover:border-[#003C58] dark:hover:border-cyan-400 transition-all">
                    <x-icon name="solid:shield" class="w-8 h-8 mx-auto text-[#003C58] dark:text-cyan-400" />
                    <h4 class="text-xs font-bold font-heading text-slate-900 dark:text-white">Seal Kits</h4>
                    <span class="text-[10px] text-slate-500 font-mono block">Gas &amp; Oil Labyrinth</span>
                </div>

            </div>

        </div>
    </section>

    <!-- =====================================================================
         SECTION 13: INTERACTIVE RAPID RFQ / DUTY DESK
         ===================================================================== -->
    <section id="rfq" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-slate-50 dark:bg-[#06121d] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
            
            <div class="reveal-init reveal-scale reveal-delay-150 max-w-4xl mx-auto rounded-3xl p-8 sm:p-12 bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl space-y-8">
                
                <div class="text-center space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
                        24/7 Operations Desk
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                        Request Instant Quotation or Emergency Port Call
                    </h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        Our duty marine engineering superintendents respond within 45 minutes of RFQ submission.
                    </p>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Vessel / Plant Name</label>
                            <input type="text" placeholder="e.g. M/V Nordroy Carrier or Power Plant Unit 3" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Turbocharger Model &amp; Serial</label>
                            <input type="text" placeholder="e.g. ABB TPL-77 or MAN TCR22" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Port / Location</label>
                            <input type="text" placeholder="Chattogram / Mongla / Other" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Service Required</label>
                            <select class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none">
                                <option>Complete Overhaul &amp; Dynamic Balancing</option>
                                <option>CHRA Cartridge Exchange</option>
                                <option>Emergency Flying Squad to Vessel</option>
                                <option>Spare Parts Purchase</option>
                                <option>NDT Metallurgical Inspection</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Urgency Level</label>
                            <select class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none">
                                <option>Standard Scheduled Maintenance</option>
                                <option>Urgent Port Call (Within 48h)</option>
                                <option>Emergency Vessel Blackout / AOG</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Contact Email &amp; Phone</label>
                        <input type="text" placeholder="technical.director@shipping-line.com / +880 1800-000000" class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Technical Notes &amp; Observed Issues</label>
                        <textarea rows="3" placeholder="Describe symptoms (e.g. abnormal vibrations, oil leakage in exhaust casing, surging under load)..." class="w-full px-4 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]/40 focus:outline-none"></textarea>
                    </div>

                    <button type="button" class="w-full py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white shadow-md active:scale-95 transition-all"
                            style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                        Submit Technical RFQ to Duty Desk
                    </button>
                </form>

            </div>

        </div>
    </section>

</x-layouts.frontend>
