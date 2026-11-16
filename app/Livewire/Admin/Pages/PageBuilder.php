<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Menu;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Setting;
use App\Services\SmartBoxModelHelper;
use App\Services\SmartColorHelper;
use Livewire\Component;
use Livewire\WithFileUploads;

class PageBuilder extends Component
{
    use WithFileUploads;

    // Selection & Workspace State
    public string $selectedSectionId = 'header'; // 'header', 'hero', numeric ID / string ID, 'footer'
    public string $activeHeaderRow = 'section'; // 'section', 'row1', 'row2', 'row3'
    public string $activeFooterRow = 'section'; // 'section', 'row1', 'row2', 'row3'
    public string $headerSubTab = 'layout'; // 'layout', 'style', 'content'
    public string $footerSubTab = 'layout'; // 'layout', 'style', 'content'
    public string $activeSectionTab = 'layout'; // 'layout', 'content'

    // Page Context
    public ?int $pageId = null;
    public string $pageTitle = 'Corporate Homepage';
    public array $sections = []; // Array representation of body sections

    // Modal State for Adding Sections
    public bool $showCreateModal = false;
    public string $newSectionType = 'grid';
    public string $newSectionTitle = '';
    public int $newSectionOrder = 10;

    // ==================== FIXED HERO BANNER ====================
    public bool $heroEnabled = true;
    public string $heroTitle = 'Hero Banner';
    public array $heroLayout = [];
    public array $heroSlides = [];
    public array $heroOverlayCards = [];

    // ==================== MASTER WRAPPER: HEADER SECTION ====================
    public array $headerSectionBoxModel = [];
    public array $headerSectionBgColor = [];
    public array $headerSectionTextColor = [];

    // ==================== HEADER ROW 1: TOPBAR ====================
    public array $headerTopbar = [];
    public array $topbarBgColor = [];
    public array $topbarTextColor = [];
    public array $topbarBoxModel = [];

    // ==================== HEADER ROW 2: MAIN NAVBAR ====================
    public string $headerStyle = 'glass';
    public string $headerHeight = '80px';
    public bool $headerSticky = true;
    public bool $headerThemeToggle = true;
    public array $headerBgColor = [];
    public array $headerTextColor = [];
    public array $headerBoxModel = [];
    public string $headerBorderSpan = 'full';
    public string $headerBorderWidth = '1px';
    public string $headerBorderColor = '';
    public ?int $headerMenuId = null;
    public array $headerCta = [];

    // ==================== HEADER ROW 3: BOTTOM SUB-HEADER ====================
    public array $headerBottom = [];

    // ==================== MASTER WRAPPER: FOOTER SECTION ====================
    public array $footerSectionBoxModel = [];
    public array $footerSectionBgColor = [];
    public array $footerSectionTextColor = [];

    // ==================== FOOTER ROW 1: PRE-FOOTER CALLOUT ====================
    public array $footerTop = [];

    // ==================== FOOTER ROW 2: MAIN MODULAR FOOTER GRID ====================
    public array $footerBgColor = [];
    public array $footerTextColor = [];
    public array $footerBoxModel = [];
    public array $footerColumns = [];
    public ?int $expandedFooterColIndex = null;

    // ==================== FOOTER ROW 3: BOTTOM SUB-FOOTER ====================
    public array $footerBottomColumns = [];
    public array $footerBottomBgColor = [];
    public array $footerBottomTextColor = [];
    public array $footerBottomBoxModel = [];
    public ?int $expandedBottomColIndex = null;
    public array $footerConfig = [];

    // ==================== ACTIVE BODY SECTION BUFFER ====================
    public array $currentSectionLayout = [];
    public array $currentSectionTitleSettings = [];
    public array $currentSectionContent = [];

    public function mount(?string $section = null): void
    {
        if ($section) {
            $this->selectedSectionId = $section;
        }

        // 1. Initialize Header Settings
        $this->loadHeaderSettings();

        // 2. Initialize Footer Settings
        $this->loadFooterSettings();

        // 3. Initialize Hero Banner Settings
        $this->loadHeroSettings();

        // 4. Initialize Homepage & Body Sections
        $this->loadPageSections();

        // If a body section is initially selected, sync buffer
        if (!in_array($this->selectedSectionId, ['header', 'hero', 'footer'])) {
            $this->syncActiveSectionBuffer();
        }
    }

    protected function loadHeaderSettings(): void
    {
        $this->headerSectionBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('header_section_box_model'), [
            'width'   => '100%',
            'padding' => ['mode' => 'axis', 'y' => '0px', 'x' => '0px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => false, 'width' => '0px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
            'shadow'  => 'none',
        ]);
        $this->headerSectionBgColor = Setting::getJson('header_section_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#07131e',
            'opacity' => 100,
        ];
        $this->headerSectionTextColor = Setting::getJson('header_section_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#0f172a',
            'dark'    => '#ffffff',
            'opacity' => 100,
        ];

        $this->headerTopbar = array_merge([
            'enabled'           => true,
            'alignment'         => 'between',
            'density'           => 'standard',
            'badge_text'        => '24/7 Port Call & Emergency Squads',
            'badge_icon'        => 'solid:bolt',
            'phone'             => '+880 1819 000000',
            'email'             => 'duty@nordroy.com',
            'show_social_links' => true,
            'emergency_cta'     => 'Urgent Port Assistance',
        ], Setting::getJson('header_topbar'));

        $this->topbarBgColor = Setting::getJson('topbar_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#002538',
            'dark'    => '#030c14',
            'opacity' => 100,
        ];
        $this->topbarTextColor = Setting::getJson('topbar_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#e2e8f0',
            'dark'    => '#94a3b8',
            'opacity' => 100,
        ];
        $this->topbarBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('topbar_box_model'), [
            'width'   => '1680px',
            'padding' => ['mode' => 'axis', 'y' => '6px', 'x' => '24px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => true, 'width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#ffffff15'],
            'shadow'  => 'none',
        ]);

        $this->headerStyle = Setting::get('theme_header_style', 'glass');
        $this->headerHeight = Setting::get('theme_header_height', '80px');
        $this->headerSticky = (bool) Setting::get('header_sticky', '1');
        $this->headerThemeToggle = (bool) Setting::get('header_theme_toggle', '1');
        $this->headerBgColor = Setting::getJson('header_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#07131e',
            'opacity' => 95,
        ];
        $this->headerTextColor = Setting::getJson('header_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#0f172a',
            'dark'    => '#ffffff',
            'opacity' => 100,
        ];
        $this->headerBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('header_box_model'), [
            'width'   => '1680px',
            'padding' => ['mode' => 'axis', 'y' => '16px', 'x' => '24px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => true, 'width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
            'shadow'  => 'sm',
        ]);
        $this->headerBorderSpan = Setting::get('header_border_span', 'full');
        $this->headerBorderWidth = Setting::get('header_border_width', '1px');
        $this->headerBorderColor = Setting::get('header_border_color', '#e2e8f0');
        $this->headerMenuId = ($m = Setting::get('header_menu_id')) ? (int) $m : null;
        $this->headerCta = array_merge([
            'enabled'      => true,
            'label'        => 'Request Service',
            'icon'         => 'solid:file-pen',
            'destination'  => ['type' => 'route', 'value' => 'enquiries.create', 'target_blank' => false],
            'variant'      => 'primary',
            'custom_color' => '#003C58',
        ], Setting::getJson('header_cta'));

        $this->headerBottom = array_merge([
            'enabled'   => false,
            'density'   => 'compact',
            'alignment' => 'start',
            'show_all_divisions' => true,
            'ticker_text' => 'Direct Drydock & Berth Support: Chittagong Anchorage • Mongla Port • Payra Port',
            'bg_color'  => ['mode' => 'theme', 'type' => 'solid', 'light' => '#f8fafc', 'dark' => '#0a1926', 'opacity' => 100],
            'text_color'=> ['mode' => 'theme', 'type' => 'solid', 'light' => '#334155', 'dark' => '#cbd5e1', 'opacity' => 100],
            'box_model' => [
                'width'   => '1680px',
                'padding' => ['mode' => 'axis', 'y' => '8px', 'x' => '24px'],
                'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
                'border'  => ['enabled' => true, 'width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
                'shadow'  => 'none',
            ],
        ], Setting::getJson('header_bottom'));
    }

    protected function loadFooterSettings(): void
    {
        $this->footerSectionBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_section_box_model'), [
            'width'   => '100%',
            'padding' => ['mode' => 'axis', 'y' => '0px', 'x' => '0px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => false, 'width' => '0px', 'side' => 'top', 'style' => 'solid', 'color' => '#e2e8f0'],
            'shadow'  => 'none',
        ]);
        $this->footerSectionBgColor = Setting::getJson('footer_section_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#002538',
            'dark'    => '#030c14',
            'opacity' => 100,
        ];
        $this->footerSectionTextColor = Setting::getJson('footer_section_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#e2e8f0',
            'dark'    => '#94a3b8',
            'opacity' => 100,
        ];

        $this->footerTop = array_merge([
            'enabled'   => true,
            'title'     => 'Immediate Marine Vessel Engineering Support',
            'subtitle'  => 'Certified flying squads available for 24/7 port calls & emergency voyages across all Bangladesh maritime terminals.',
            'cta_text'  => 'Contact Port Squad',
            'cta_link'  => ['type' => 'route', 'value' => 'enquiries.create', 'target_blank' => false],
            'phone'     => '+880 1819 000000',
            'bg_color'  => ['mode' => 'theme', 'type' => 'solid', 'light' => '#003C58', 'dark' => '#071d2b', 'opacity' => 100],
            'text_color'=> ['mode' => 'theme', 'type' => 'solid', 'light' => '#ffffff', 'dark' => '#ffffff', 'opacity' => 100],
            'box_model' => [
                'width'   => '1680px',
                'padding' => ['mode' => 'axis', 'y' => '24px', 'x' => '32px'],
                'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
                'border'  => ['enabled' => true, 'width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#ffffff15'],
                'shadow'  => 'none',
            ],
        ], Setting::getJson('footer_top'));

        $this->footerBgColor = Setting::getJson('footer_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#002538',
            'dark'    => '#030c14',
            'opacity' => 100,
        ];
        $this->footerTextColor = Setting::getJson('footer_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#cbd5e1',
            'dark'    => '#94a3b8',
            'opacity' => 100,
        ];
        $this->footerBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_box_model'), [
            'width'   => '1680px',
            'padding' => ['mode' => 'axis', 'y' => '48px', 'x' => '32px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => false, 'width' => '0px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#ffffff10'],
            'shadow'  => 'none',
        ]);

        $this->footerColumns = Setting::getJson('footer_columns') ?: $this->getDefaultFooterColumns();
        $this->footerBottomColumns = Setting::getJson('footer_bottom_columns') ?: $this->getDefaultFooterBottomColumns();
        $this->footerBottomBgColor = Setting::getJson('footer_bottom_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#001a27',
            'dark'    => '#02070c',
            'opacity' => 100,
        ];
        $this->footerBottomTextColor = Setting::getJson('footer_bottom_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#94a3b8',
            'dark'    => '#64748b',
            'opacity' => 100,
        ];
        $this->footerBottomBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_bottom_box_model'), [
            'width'   => '1680px',
            'padding' => ['mode' => 'axis', 'y' => '16px', 'x' => '32px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => true, 'width' => '1px', 'side' => 'top', 'style' => 'solid', 'color' => '#ffffff10'],
            'shadow'  => 'none',
        ]);
        $this->footerConfig = array_merge([
            'show_back_to_top' => true,
            'show_social_bar'  => true,
            'social_alignment' => 'end',
            'copyright_template' => '© {year} {site_name}. All rights reserved.',
        ], Setting::getJson('footer_config'));
    }

    protected function loadHeroSettings(): void
    {
        $heroData = Setting::getJson('hero_banner_settings', []);
        $this->heroEnabled = isset($heroData['enabled']) ? (bool)$heroData['enabled'] : true;
        $this->heroTitle = $heroData['title'] ?? 'Hero Banner (Fixed)';
        $this->heroLayout = array_merge([
            'width'       => 'container-fluid',
            'bg_type'     => 'video',
            'bg_color'    => '#001e2e',
            'text_color'  => '#ffffff',
            'margin_top'  => '0px',
            'margin_bottom' => '0px',
            'padding_top' => '80px',
            'padding_bottom' => '80px',
            'border_style'=> 'none',
            'border_width'=> 1,
            'border_color'=> '#ffffff15',
            'border_radius'=> '0px',
            'shadow_mode' => 'none',
            'bg_video_url'=> 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
            'bg_video_overlay' => true,
            'bg_video_overlay_color' => '#001e2e',
            'bg_video_overlay_opacity' => '0.75',
            'bg_image_url'=> '',
            'glass_blur'  => '12px',
            'glass_opacity'=> 80,
        ], $heroData['layout'] ?? []);

        $this->heroSlides = Setting::getJson('hero_banner_slides') ?: [
            [
                'headline'   => 'Marine Turbocharger Overhaul & High-Speed Dynamic Balancing',
                'subtitle'   => 'Class-certified 24/7 flying squads with calibrated Schenck dynamic balancing up to 100,000 RPM. Zero port demurrage guarantee.',
                'badge'      => 'DNV & ISO 9001:2015 Class A Certified',
                'badge_icon' => 'shield-check',
                'cta1'       => ['text' => 'Request Emergency Dispatch', 'url' => '/#inquiry', 'variant' => 'primary', 'icon' => 'bolt'],
                'cta2'       => ['text' => 'Technical Capabilities', 'url' => '/services', 'variant' => 'outline', 'icon' => 'compass'],
            ]
        ];

        $this->heroOverlayCards = Setting::getJson('hero_banner_cards') ?: [
            ['title' => 'ISO 1940 Grade G1.0', 'detail' => 'Aerospace Tolerance Residual Vibration', 'icon' => 'award'],
            ['title' => '32h Avg Port Turnaround', 'detail' => 'Zero Vessel Demurrage Penalties', 'icon' => 'clock'],
            ['title' => '12-Month Class Warranty', 'detail' => '100% Genuine OEM Replacement Kits', 'icon' => 'shield-check'],
        ];
    }

    protected function loadPageSections(): void
    {
        // 1. Ensure homepage record exists
        $page = null;
        try {
            $page = Page::firstOrCreate(
                ['slug' => 'home'],
                [
                    'title' => ['en' => 'Corporate Homepage'],
                    'template' => 'default',
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
            $this->pageId = $page->id;
            $this->pageTitle = is_array($page->title) ? ($page->title['en'] ?? 'Corporate Homepage') : (string)$page->title;
        } catch (\Throwable $e) {
            $this->pageId = null;
        }

        // 2. Fetch sections from DB or initialize standard corporate defaults
        $dbSections = [];
        if ($this->pageId) {
            try {
                $dbSections = PageSection::where('page_id', $this->pageId)
                    ->orderBy('order')
                    ->get()
                    ->toArray();
            } catch (\Throwable $e) {
                $dbSections = [];
            }
        }

        if (empty($dbSections)) {
            // Seed corporate sections
            $this->sections = $this->getDefaultHomepageSections();
            if ($this->pageId) {
                foreach ($this->sections as $sec) {
                    try {
                        PageSection::create([
                            'page_id'         => $this->pageId,
                            'section_type'    => $sec['section_type'],
                            'schema_version'  => 1,
                            'order'           => $sec['order'],
                            'is_active'       => $sec['is_active'],
                            'is_global'       => false,
                            'settings'        => $sec['settings'],
                            'content'         => $sec['content'],
                        ]);
                    } catch (\Throwable $e) {
                        // DB might be temporarily mock/sqlite
                    }
                }
            }
        } else {
            $this->sections = [];
            foreach ($dbSections as $sec) {
                $this->sections[] = [
                    'id'           => (string) $sec['id'],
                    'section_type' => $sec['section_type'],
                    'title'        => $sec['settings']['title_settings']['title'] ?? ucfirst(str_replace('_', ' ', $sec['section_type'])),
                    'order'        => (int) $sec['order'],
                    'is_active'    => (bool) $sec['is_active'],
                    'settings'     => $sec['settings'] ?? [],
                    'content'      => $sec['content'] ?? [],
                ];
            }
        }
    }

    public function getDefaultHomepageSections(): array
    {
        return [
            [
                'id'           => 'sec-services',
                'section_type' => 'grid',
                'title'        => 'Marine & Industrial Turbocharger Services',
                'order'        => 10,
                'is_active'    => true,
                'settings'     => [
                    'title_settings' => [
                        'show'             => true,
                        'title'            => 'Marine & Industrial Turbocharger Services',
                        'subtitle'         => 'Authorized multi-brand overhauls, dynamic rotor balancing, and ultrasonic decarbonization.',
                        'align'            => 'center',
                        'title_size'       => 28,
                        'title_color_mode' => 'theme',
                        'title_color'      => '#0f172a',
                        'subtitle_color'   => '#64748b',
                        'show_badge'       => true,
                        'badge_type'       => 'dynamic_count',
                        'badge_content_mode'=> 'both',
                        'badge_icon'       => 'sparkles',
                        'badge_count_suffix'=> 'Core Services',
                        'badge_text'       => 'Certified Capabilities',
                        'badge_style_mode' => 'theme',
                    ],
                    'layout' => [
                        'width'          => 'container-xl',
                        'bg_type'        => 'transparent',
                        'bg_color'       => '#ffffff',
                        'text_color'     => '#0f172a',
                        'margin_top'     => '0px',
                        'margin_bottom'  => '0px',
                        'padding_top'    => '64px',
                        'padding_bottom' => '64px',
                        'border_style'   => 'none',
                        'border_width'   => 1,
                        'border_color'   => '#e2e8f0',
                        'border_radius'  => '0px',
                        'shadow_mode'    => 'none',
                    ],
                ],
                'content' => [
                    'source_type' => 'model',
                    'model'       => 'services',
                    'columns'     => 3,
                    'limit'       => 6,
                    'show_cta'    => true,
                    'cta_label'   => 'View All Marine Services',
                    'cta_url'     => '/services',
                ],
            ],
            [
                'id'           => 'sec-about',
                'section_type' => 'banner',
                'title'        => 'Precision Metallurgy & Dynamic Balancing',
                'order'        => 20,
                'is_active'    => true,
                'settings'     => [
                    'title_settings' => [
                        'show'             => true,
                        'title'            => 'Balancing to Aerospace Grade ISO 1940 G1.0',
                        'subtitle'         => 'Calibrated Schenck multi-plane dynamic balancing benches eliminating hazardous high-speed resonance.',
                        'align'            => 'start',
                        'title_size'       => 26,
                        'title_color_mode' => 'theme',
                        'title_color'      => '#0f172a',
                        'subtitle_color'   => '#64748b',
                        'show_badge'       => true,
                        'badge_type'       => 'custom',
                        'badge_content_mode'=> 'both',
                        'badge_icon'       => 'award',
                        'badge_text'       => 'Proprietary Engineering',
                        'badge_style_mode' => 'theme',
                    ],
                    'layout' => [
                        'width'          => 'container-xl',
                        'bg_type'        => 'gradient',
                        'gradient_type'  => 'linear',
                        'gradient_angle' => '135deg',
                        'gradient_stop1' => '#f8fafc',
                        'gradient_stop1_pos' => '0%',
                        'gradient_stop2' => '#e2e8f0',
                        'gradient_stop2_pos' => '100%',
                        'bg_color'       => '#f8fafc',
                        'text_color'     => '#0f172a',
                        'margin_top'     => '0px',
                        'margin_bottom'  => '0px',
                        'padding_top'    => '48px',
                        'padding_bottom' => '48px',
                        'border_style'   => 'solid',
                        'border_position'=> 'all',
                        'border_width'   => 1,
                        'border_color'   => '#e2e8f0',
                        'border_radius'  => '16px',
                        'shadow_mode'    => 'preset',
                        'shadow_preset'  => 'md',
                    ],
                ],
                'content' => [
                    'items' => [
                        ['title' => 'Ultra-High Speed Balancing', 'desc' => 'Precision balance testing up to 100,000 RPM reducing vibration below 0.4 mm/s RMS.'],
                        ['title' => 'Micro-TIG Metallurgy', 'desc' => 'Thermal crack remediation and shaft journals rebuild under argon shielding.'],
                        ['title' => 'Chemical Ultrasonic Decarbonization', 'desc' => 'Restoring heat transfer rates and eliminating exhaust gas back-pressure.'],
                    ],
                ],
            ],
            [
                'id'           => 'sec-stats',
                'section_type' => 'grid',
                'title'        => 'Engineering Key Performance Metrics',
                'order'        => 30,
                'is_active'    => true,
                'settings'     => [
                    'title_settings' => [
                        'show'             => true,
                        'title'            => '14+ Years of Maritime Engineering Excellence',
                        'subtitle'         => 'Key operating performance delivered across ocean-going vessels, container carriers, and captive power plants.',
                        'align'            => 'center',
                        'title_size'       => 24,
                        'title_color_mode' => 'theme',
                        'title_color'      => '#0f172a',
                        'subtitle_color'   => '#64748b',
                        'show_badge'       => false,
                    ],
                    'layout' => [
                        'width'          => 'container-xl',
                        'bg_type'        => 'color',
                        'bg_color'       => '#003C58',
                        'text_color'     => '#ffffff',
                        'margin_top'     => '24px',
                        'margin_bottom'  => '24px',
                        'padding_top'    => '48px',
                        'padding_bottom' => '48px',
                        'border_style'   => 'none',
                        'border_width'   => 0,
                        'border_radius'  => '16px',
                        'shadow_mode'    => 'preset',
                        'shadow_preset'  => 'lg',
                    ],
                ],
                'content' => [
                    'items' => [
                        ['number' => '850+', 'label' => 'Marine Turbochargers Overhauled', 'icon' => 'anchor'],
                        ['number' => '32h', 'label' => 'Average Port Berth Turnaround', 'icon' => 'clock'],
                        ['number' => '97.2%', 'label' => 'Vibration Reduction Achieved', 'icon' => 'activity'],
                        ['number' => '0', 'label' => 'Port Demurrage Penalties Incurred', 'icon' => 'shield-check'],
                    ],
                ],
            ],
            [
                'id'           => 'sec-projects',
                'section_type' => 'slider',
                'title'        => 'Recent Drydock & Port Call Interventions',
                'order'        => 40,
                'is_active'    => true,
                'settings'     => [
                    'title_settings' => [
                        'show'             => true,
                        'title'            => 'Recent Drydock & Port Call Interventions',
                        'subtitle'         => 'Verified case studies delivering rapid restoration for ocean transit vessels and power stations.',
                        'align'            => 'start',
                        'title_size'       => 28,
                        'title_color_mode' => 'theme',
                        'title_color'      => '#0f172a',
                        'subtitle_color'   => '#64748b',
                        'show_badge'       => true,
                        'badge_type'       => 'custom',
                        'badge_content_mode'=> 'both',
                        'badge_icon'       => 'briefcase',
                        'badge_text'       => 'Proven Track Record',
                        'badge_style_mode' => 'theme',
                    ],
                    'layout' => [
                        'width'          => 'container-xl',
                        'bg_type'        => 'transparent',
                        'bg_color'       => '#ffffff',
                        'text_color'     => '#0f172a',
                        'margin_top'     => '0px',
                        'margin_bottom'  => '0px',
                        'padding_top'    => '48px',
                        'padding_bottom' => '48px',
                        'border_style'   => 'none',
                        'border_width'   => 0,
                        'border_radius'  => '0px',
                        'shadow_mode'    => 'none',
                    ],
                ],
                'content' => [
                    'items' => [
                        ['title' => '85,000 DWT Container Carrier Turbo Refit', 'tag' => 'Chittagong Port', 'duration' => '36 Hours'],
                        ['title' => '2.5MW Dual-Fuel Industrial Power Plant Overhaul', 'tag' => 'Gazipur Belt', 'duration' => '4 Days Outage'],
                        ['title' => 'Bulk Carrier MAN NR/S Rotor Replacement', 'tag' => 'Mongla Anchorage', 'duration' => '28 Hours'],
                    ],
                ],
            ],
            [
                'id'           => 'sec-inquiry',
                'section_type' => 'form',
                'title'        => 'Request Immediate Engineering Dispatch',
                'order'        => 50,
                'is_active'    => true,
                'settings'     => [
                    'title_settings' => [
                        'show'             => true,
                        'title'            => 'Request Immediate Engineering Dispatch',
                        'subtitle'         => 'Reach our duty desk directly for flying squad mobilization or urgent OEM spare part allocations.',
                        'align'            => 'center',
                        'title_size'       => 26,
                        'title_color_mode' => 'theme',
                        'title_color'      => '#0f172a',
                        'subtitle_color'   => '#64748b',
                        'show_badge'       => true,
                        'badge_type'       => 'custom',
                        'badge_content_mode'=> 'both',
                        'badge_icon'       => 'phone-call',
                        'badge_text'       => '24/7 Duty Response',
                        'badge_style_mode' => 'theme',
                    ],
                    'layout' => [
                        'width'          => 'container-xl',
                        'bg_type'        => 'color',
                        'bg_color'       => '#f1f5f9',
                        'text_color'     => '#0f172a',
                        'margin_top'     => '24px',
                        'margin_bottom'  => '24px',
                        'padding_top'    => '48px',
                        'padding_bottom' => '48px',
                        'border_style'   => 'solid',
                        'border_position'=> 'all',
                        'border_width'   => 1,
                        'border_color'   => '#cbd5e1',
                        'border_radius'  => '16px',
                        'shadow_mode'    => 'preset',
                        'shadow_preset'  => 'sm',
                    ],
                ],
                'content' => [
                    'form_type'    => 'rfq',
                    'submit_label' => 'Submit Engineering Request',
                    'show_vessel'  => true,
                    'show_port'    => true,
                ],
            ],
            [
                'id'           => 'sec-faq',
                'section_type' => 'faq',
                'title'        => 'Frequently Asked Questions',
                'order'        => 60,
                'is_active'    => true,
                'settings'     => [
                    'title_settings' => [
                        'show'             => true,
                        'title'            => 'Frequently Asked Questions',
                        'subtitle'         => 'Answers regarding port anchorage access, emergency turnaround, dynamic balancing, and OEM certifications.',
                        'align'            => 'center',
                        'title_size'       => 24,
                        'title_color_mode' => 'theme',
                        'title_color'      => '#0f172a',
                        'subtitle_color'   => '#64748b',
                        'show_badge'       => false,
                    ],
                    'layout' => [
                        'width'          => 'container-xl',
                        'bg_type'        => 'transparent',
                        'bg_color'       => '#ffffff',
                        'text_color'     => '#0f172a',
                        'margin_top'     => '0px',
                        'margin_bottom'  => '0px',
                        'padding_top'    => '48px',
                        'padding_bottom' => '48px',
                        'border_style'   => 'none',
                        'border_width'   => 0,
                        'border_radius'  => '0px',
                        'shadow_mode'    => 'none',
                    ],
                ],
                'content' => [
                    'items' => [
                        ['q' => 'Can your flying squad board vessels at outer anchorage?', 'a' => 'Yes. Our squads possess complete Port Authority and Coast Guard clearances with self-contained diagnostic gear for direct boarding at Chittagong, Kutubdia, and Mongla anchorages.'],
                        ['q' => 'What precision balancing standard is provided?', 'a' => 'All turbocharger rotors undergo high-speed multi-plane dynamic balancing conforming strictly to ISO 1940 Grade G1.0, backed by Schenck calibration graphs and DNV inspection certificates.'],
                        ['q' => 'How are emergency spare parts sourced?', 'a' => 'We maintain bonded warehouse stock of genuine OEM turbine blades, compressor wheels, floating journal bearings, and seal rings for all major European and Asian turbocharger series.'],
                    ],
                ],
            ],
        ];
    }

    public function selectSection(string $id): void
    {
        // First save active section buffer if switching away from a body section
        if (!in_array($this->selectedSectionId, ['header', 'hero', 'footer'])) {
            $this->flushActiveSectionBuffer();
        }

        $this->selectedSectionId = $id;

        // If newly selected is a body section, populate buffer
        if (!in_array($this->selectedSectionId, ['header', 'hero', 'footer'])) {
            $this->syncActiveSectionBuffer();
        }
    }

    protected function syncActiveSectionBuffer(): void
    {
        $idx = $this->findSectionIndex($this->selectedSectionId);
        if ($idx !== null && isset($this->sections[$idx])) {
            $sec = $this->sections[$idx];
            $this->currentSectionLayout = $sec['settings']['layout'] ?? [
                'width'       => 'container-xl',
                'bg_type'     => 'transparent',
                'bg_color'    => '#ffffff',
                'text_color'  => '#0f172a',
                'margin_top'  => '0px',
                'margin_bottom' => '0px',
                'padding_top' => '48px',
                'padding_bottom' => '48px',
                'border_style'=> 'none',
                'border_width'=> 1,
                'border_color'=> '#e2e8f0',
                'border_radius'=> '0px',
                'shadow_mode' => 'none',
            ];
            $this->currentSectionTitleSettings = $sec['settings']['title_settings'] ?? [
                'show'             => true,
                'title'            => $sec['title'] ?? '',
                'subtitle'         => '',
                'align'            => 'start',
                'title_size'       => 26,
                'title_color_mode' => 'theme',
                'title_color'      => '#0f172a',
                'subtitle_color'   => '#64748b',
                'show_badge'       => false,
                'badge_type'       => 'dynamic_count',
                'badge_content_mode'=> 'both',
                'badge_icon'       => 'sparkles',
                'badge_count_suffix'=> 'Items',
                'badge_text'       => 'Featured',
                'badge_style_mode' => 'theme',
            ];
            $this->currentSectionContent = $sec['content'] ?? [];
        }
    }

    protected function flushActiveSectionBuffer(): void
    {
        $idx = $this->findSectionIndex($this->selectedSectionId);
        if ($idx !== null && isset($this->sections[$idx])) {
            $this->sections[$idx]['settings']['layout'] = $this->currentSectionLayout;
            $this->sections[$idx]['settings']['title_settings'] = $this->currentSectionTitleSettings;
            $this->sections[$idx]['title'] = $this->currentSectionTitleSettings['title'] ?? $this->sections[$idx]['title'];
            $this->sections[$idx]['content'] = $this->currentSectionContent;
        }
    }

    protected function findSectionIndex(string $id): ?int
    {
        foreach ($this->sections as $i => $sec) {
            if ((string)($sec['id'] ?? '') === (string)$id) {
                return $i;
            }
        }
        return null;
    }

    public function toggleSectionStatus(string $id): void
    {
        if ($id === 'hero') {
            $this->heroEnabled = !$this->heroEnabled;
            return;
        }

        $idx = $this->findSectionIndex($id);
        if ($idx !== null) {
            $this->sections[$idx]['is_active'] = !$this->sections[$idx]['is_active'];
        }
    }

    public function moveSection(string $id, string $direction): void
    {
        $idx = $this->findSectionIndex($id);
        if ($idx === null) {
            return;
        }

        if ($direction === 'up' && $idx > 0) {
            $temp = $this->sections[$idx - 1];
            $this->sections[$idx - 1] = $this->sections[$idx];
            $this->sections[$idx] = $temp;
        } elseif ($direction === 'down' && $idx < count($this->sections) - 1) {
            $temp = $this->sections[$idx + 1];
            $this->sections[$idx + 1] = $this->sections[$idx];
            $this->sections[$idx] = $temp;
        }

        // Recalculate orders
        foreach ($this->sections as $i => &$sec) {
            $sec['order'] = ($i + 1) * 10;
        }
    }

    public function deleteSection(string $id): void
    {
        $idx = $this->findSectionIndex($id);
        if ($idx !== null) {
            // Delete from DB if numeric ID
            if (is_numeric($id)) {
                try {
                    PageSection::where('id', $id)->delete();
                } catch (\Throwable $e) {}
            }

            array_splice($this->sections, $idx, 1);

            if ($this->selectedSectionId === $id) {
                $this->selectedSectionId = 'hero';
            }
        }
    }

    public function openCreateModal(): void
    {
        $this->newSectionType = 'grid';
        $this->newSectionTitle = 'New Section';
        $this->newSectionOrder = (count($this->sections) + 1) * 10;
        $this->showCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
    }

    public function addSection(): void
    {
        $typeCatalog = [
            'slider'       => ['title' => 'Dynamic Carousel & Marquee Slider', 'icon' => 'sparkles'],
            'grid'         => ['title' => 'Multi-Column Showcase Grid', 'icon' => 'grid'],
            'banner'       => ['title' => 'Promotional Hero Banner', 'icon' => 'image'],
            'text'         => ['title' => 'Rich Editorial Content', 'icon' => 'file-text'],
            'form'         => ['title' => 'Interactive Inquiry & RFQ Form', 'icon' => 'mail'],
            'list'         => ['title' => 'Feature Highlights & Steps', 'icon' => 'list'],
            'faq'          => ['title' => 'Frequently Asked Questions Accordion', 'icon' => 'help-circle'],
            'stats'        => ['title' => 'Engineering Performance Numbers', 'icon' => 'activity'],
            'testimonials' => ['title' => 'Client Testimonials & Feedback', 'icon' => 'message-square'],
            'custom_html'  => ['title' => 'Custom Raw HTML & Embeds', 'icon' => 'code'],
        ];

        $title = !empty(trim($this->newSectionTitle)) 
            ? trim($this->newSectionTitle) 
            : ($typeCatalog[$this->newSectionType]['title'] ?? 'Custom Section');

        $newId = 'sec_' . time() . '_' . rand(100, 999);

        $newSec = [
            'id'           => $newId,
            'section_type' => $this->newSectionType,
            'title'        => $title,
            'order'        => $this->newSectionOrder,
            'is_active'    => true,
            'settings'     => [
                'title_settings' => [
                    'show'             => true,
                    'title'            => $title,
                    'subtitle'         => 'Customize subtitle and descriptive context for this section.',
                    'align'            => 'start',
                    'title_size'       => 26,
                    'title_color_mode' => 'theme',
                    'title_color'      => '#0f172a',
                    'subtitle_color'   => '#64748b',
                    'show_badge'       => false,
                    'badge_type'       => 'custom',
                    'badge_content_mode'=> 'both',
                    'badge_icon'       => 'sparkles',
                    'badge_text'       => 'Featured',
                    'badge_style_mode' => 'theme',
                ],
                'layout' => [
                    'width'          => 'container-xl',
                    'bg_type'        => 'transparent',
                    'bg_color'       => '#ffffff',
                    'text_color'     => '#0f172a',
                    'margin_top'     => '0px',
                    'margin_bottom'  => '0px',
                    'padding_top'    => '48px',
                    'padding_bottom' => '48px',
                    'border_style'   => 'none',
                    'border_width'   => 1,
                    'border_color'   => '#e2e8f0',
                    'border_radius'  => '0px',
                    'shadow_mode'    => 'none',
                ],
            ],
            'content'      => [
                'items' => [
                    ['title' => 'Feature 1', 'desc' => 'High quality maritime service delivery and execution.'],
                    ['title' => 'Feature 2', 'desc' => 'Precision ISO 9001:2015 Class A engineering compliance.'],
                ],
            ],
        ];

        // Create in DB if page exists
        if ($this->pageId) {
            try {
                $created = PageSection::create([
                    'page_id'        => $this->pageId,
                    'section_type'   => $this->newSectionType,
                    'schema_version' => 1,
                    'order'          => $this->newSectionOrder,
                    'is_active'      => true,
                    'is_global'      => false,
                    'settings'       => $newSec['settings'],
                    'content'        => $newSec['content'],
                ]);
                $newSec['id'] = (string)$created->id;
            } catch (\Throwable $e) {}
        }

        $this->sections[] = $newSec;
        $this->showCreateModal = false;
        $this->selectSection((string)$newSec['id']);
    }

    // ==================== HEADER BUILDER METHODS ====================
    public function selectHeaderRow(string $row): void
    {
        $this->activeHeaderRow = $row;
    }

    public function setHeaderSubTab(string $tab): void
    {
        $this->headerSubTab = $tab;
    }

    // ==================== FOOTER BUILDER METHODS ====================
    public function selectFooterRow(string $row): void
    {
        $this->activeFooterRow = $row;
    }

    public function setFooterSubTab(string $tab): void
    {
        $this->footerSubTab = $tab;
    }

    public function addFooterColumn(): void
    {
        if (count($this->footerColumns) < 4) {
            $this->footerColumns[] = [
                'type'    => 'static_links',
                'title'   => 'Quick Links',
                'span'    => 1,
                'content' => [
                    'items' => [
                        ['label' => 'Marine Services', 'link' => ['type' => 'custom', 'url' => '/services', 'target_blank' => false]],
                        ['label' => 'Quality Certifications', 'link' => ['type' => 'custom', 'url' => '/about', 'target_blank' => false]],
                    ],
                ],
            ];
            $this->expandedFooterColIndex = count($this->footerColumns) - 1;
        }
    }

    public function removeFooterColumn(int $index): void
    {
        if (isset($this->footerColumns[$index])) {
            array_splice($this->footerColumns, $index, 1);
            if ($this->expandedFooterColIndex === $index) {
                $this->expandedFooterColIndex = null;
            }
        }
    }

    public function addStaticListItem(int $colIndex): void
    {
        if (isset($this->footerColumns[$colIndex])) {
            if (!isset($this->footerColumns[$colIndex]['content']['items'])) {
                $this->footerColumns[$colIndex]['content']['items'] = [];
            }
            $this->footerColumns[$colIndex]['content']['items'][] = [
                'label' => 'New Navigation Link',
                'link'  => ['type' => 'custom', 'url' => '#', 'target_blank' => false],
            ];
        }
    }

    public function removeStaticListItem(int $colIndex, int $itemIndex): void
    {
        if (isset($this->footerColumns[$colIndex]['content']['items'][$itemIndex])) {
            array_splice($this->footerColumns[$colIndex]['content']['items'], $itemIndex, 1);
        }
    }

    public function getDefaultFooterColumns(): array
    {
        return [
            [
                'type'    => 'company_info',
                'title'   => 'About Nordroy',
                'span'    => 2,
                'content' => [
                    'show_logo'   => true,
                    'bio'         => 'A premier maritime engineering and industrial group specializing in authorized multi-brand exhaust gas turbocharger overhauls, dynamic rotor balancing up to 100,000 RPM, and 24/7 flying squads.',
                    'show_social' => true,
                    'show_phone'  => true,
                ],
            ],
            [
                'type'    => 'dynamic_menu',
                'title'   => 'Business Units',
                'span'    => 1,
                'content' => [
                    'source' => 'divisions',
                ],
            ],
            [
                'type'    => 'dynamic_menu',
                'title'   => 'Technical Services',
                'span'    => 1,
                'content' => [
                    'source' => 'services',
                ],
            ],
            [
                'type'    => 'contact_offices',
                'title'   => 'Port & HQ Offices',
                'span'    => 1,
                'content' => [
                    'port_title'     => 'Chattogram Port Workshop:',
                    'port_address'   => 'Plot 14, Marine Drive Road, Sholashahar Heavy Industrial Area, Chattogram.',
                    'hq_title'       => 'Dhaka Corporate HQ:',
                    'hq_address'     => 'Level 9, Crystal Tower, Gulshan-2, Dhaka-1212.',
                    'show_emergency' => true,
                ],
            ],
        ];
    }

    public function getDefaultFooterBottomColumns(): array
    {
        return [
            [
                'type'    => 'copyright',
                'content' => [
                    'text' => '© {year} {site_name}. All rights reserved. Precision Maritime Engineering.',
                ],
            ],
            [
                'type'    => 'badges',
                'content' => [
                    'show_iso'   => true,
                    'iso_text'   => 'ISO 9001:2015 & DNV Certified Facility',
                    'show_login' => true,
                    'login_text' => 'Staff Access Portal',
                ],
            ],
        ];
    }

    // ==================== HERO BUILDER METHODS ====================
    public function addHeroSlide(): void
    {
        $this->heroSlides[] = [
            'headline'   => 'Precision Overhauls & Class Certified Engineering',
            'subtitle'   => 'Zero port demurrage turnaround backed by calibrated Schenck rotor balancing.',
            'badge'      => 'DNV Certified',
            'badge_icon' => 'shield-check',
            'cta1'       => ['text' => 'Request Service', 'url' => '/#inquiry', 'variant' => 'primary', 'icon' => 'bolt'],
            'cta2'       => ['text' => 'Learn More', 'url' => '/services', 'variant' => 'outline', 'icon' => 'compass'],
        ];
    }

    public function removeHeroSlide(int $index): void
    {
        if (isset($this->heroSlides[$index])) {
            array_splice($this->heroSlides, $index, 1);
        }
    }

    public function addHeroOverlayCard(): void
    {
        $this->heroOverlayCards[] = [
            'title'  => 'New Trust Indicator',
            'detail' => 'Certified high-speed marine capability',
            'icon'   => 'award',
        ];
    }

    public function removeHeroOverlayCard(int $index): void
    {
        if (isset($this->heroOverlayCards[$index])) {
            array_splice($this->heroOverlayCards, $index, 1);
        }
    }

    // ==================== SAVE & PERSIST ALL ====================
    public function save(): void
    {
        // 1. Flush active section buffer to memory array
        if (!in_array($this->selectedSectionId, ['header', 'hero', 'footer'])) {
            $this->flushActiveSectionBuffer();
        }

        // 2. Persist Header Settings to Setting
        Setting::set('header_section_box_model', $this->headerSectionBoxModel, 'header', 'json');
        Setting::set('header_section_bg_color', $this->headerSectionBgColor, 'header', 'json');
        Setting::set('header_section_text_color', $this->headerSectionTextColor, 'header', 'json');

        Setting::set('header_topbar', $this->headerTopbar, 'header', 'json');
        Setting::set('topbar_bg_color', $this->topbarBgColor, 'header', 'json');
        Setting::set('topbar_text_color', $this->topbarTextColor, 'header', 'json');
        Setting::set('topbar_box_model', $this->topbarBoxModel, 'header', 'json');

        Setting::set('theme_header_style', $this->headerStyle, 'theme');
        Setting::set('theme_header_height', $this->headerHeight, 'theme');
        Setting::set('header_sticky', $this->headerSticky ? '1' : '0', 'header');
        Setting::set('header_theme_toggle', $this->headerThemeToggle ? '1' : '0', 'header');
        Setting::set('header_bg_color', $this->headerBgColor, 'header', 'json');
        Setting::set('header_text_color', $this->headerTextColor, 'header', 'json');
        Setting::set('header_box_model', $this->headerBoxModel, 'header', 'json');
        Setting::set('header_border_span', $this->headerBorderSpan, 'header');
        Setting::set('header_border_width', $this->headerBorderWidth, 'header');
        Setting::set('header_border_color', $this->headerBorderColor, 'header');
        Setting::set('header_menu_id', (string) ($this->headerMenuId ?: ''), 'header');
        Setting::set('header_cta', $this->headerCta, 'header', 'json');

        Setting::set('header_bottom', $this->headerBottom, 'header', 'json');

        // 3. Persist Footer Settings to Setting
        Setting::set('footer_section_box_model', $this->footerSectionBoxModel, 'footer', 'json');
        Setting::set('footer_section_bg_color', $this->footerSectionBgColor, 'footer', 'json');
        Setting::set('footer_section_text_color', $this->footerSectionTextColor, 'footer', 'json');

        Setting::set('footer_top', $this->footerTop, 'footer', 'json');
        Setting::set('footer_bg_color', $this->footerBgColor, 'footer', 'json');
        Setting::set('footer_text_color', $this->footerTextColor, 'footer', 'json');
        Setting::set('footer_box_model', $this->footerBoxModel, 'footer', 'json');
        Setting::set('footer_columns', $this->footerColumns, 'footer', 'json');

        Setting::set('footer_bottom_columns', $this->footerBottomColumns, 'footer', 'json');
        Setting::set('footer_bottom_bg_color', $this->footerBottomBgColor, 'footer', 'json');
        Setting::set('footer_bottom_text_color', $this->footerBottomTextColor, 'footer', 'json');
        Setting::set('footer_bottom_box_model', $this->footerBottomBoxModel, 'footer', 'json');
        Setting::set('footer_config', $this->footerConfig, 'footer', 'json');

        // 4. Persist Hero Banner Settings
        Setting::set('hero_banner_settings', [
            'enabled' => $this->heroEnabled,
            'title'   => $this->heroTitle,
            'layout'  => $this->heroLayout,
        ], 'hero', 'json');
        Setting::set('hero_banner_slides', $this->heroSlides, 'hero', 'json');
        Setting::set('hero_banner_cards', $this->heroOverlayCards, 'hero', 'json');

        // 5. Persist Body Sections to Database
        if ($this->pageId) {
            foreach ($this->sections as $sec) {
                try {
                    if (is_numeric($sec['id'])) {
                        PageSection::where('id', $sec['id'])->update([
                            'order'        => $sec['order'],
                            'is_active'    => $sec['is_active'],
                            'settings'     => $sec['settings'],
                            'content'      => $sec['content'],
                        ]);
                    } else {
                        // Insert new
                        $created = PageSection::create([
                            'page_id'        => $this->pageId,
                            'section_type'   => $sec['section_type'],
                            'schema_version' => 1,
                            'order'          => $sec['order'],
                            'is_active'      => $sec['is_active'],
                            'is_global'      => false,
                            'settings'       => $sec['settings'],
                            'content'        => $sec['content'],
                        ]);
                        // update in-memory id
                        $idx = $this->findSectionIndex($sec['id']);
                        if ($idx !== null) {
                            $this->sections[$idx]['id'] = (string)$created->id;
                            if ($this->selectedSectionId === $sec['id']) {
                                $this->selectedSectionId = (string)$created->id;
                            }
                        }
                    }
                } catch (\Throwable $e) {}
            }
        }

        session()->flash('message', 'Page sections and theme architecture saved and published successfully.');
    }

    public function render()
    {
        return view('livewire.admin.pages.page-builder', [
            'availableMenus' => Menu::withCount('items')->get(),
        ])->layout('components.layouts.admin', [
            'title' => 'Storefront Customizer & Homepage CMS | ' . Setting::get('site_name', 'Nordroy Corporate CMS'),
        ]);
    }
}
