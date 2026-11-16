<?php

namespace App\Livewire\Admin\Theme;

use App\Models\Menu;
use App\Models\Setting;
use App\Services\SmartBoxModelHelper;
use App\Services\SmartColorHelper;
use Livewire\Component;

class HeaderFooterBuilder extends Component
{
    public string $activeMode = 'header'; // 'header' or 'footer'
    public string $activeHeaderRow = 'section'; // 'section', 'row1', 'row2', 'row3'
    public string $activeFooterRow = 'section'; // 'section', 'row1', 'row2', 'row3'
    public string $headerSubTab = 'layout'; // 'layout', 'style', 'content'
    public string $footerSubTab = 'layout'; // 'layout', 'style', 'content'

    // ==================== MASTER WRAPPER: HEADER SECTION ====================
    public array $headerSectionBoxModel = [];
    public array $headerSectionBgColor = [];
    public array $headerSectionTextColor = [];

    // ==================== ROW 1: TOPBAR ====================
    public array $headerTopbar = [];
    public array $topbarBgColor = [];
    public array $topbarTextColor = [];
    public array $topbarBoxModel = [];

    // ==================== ROW 2: MAIN NAVBAR ====================
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

    // ==================== ROW 3: BOTTOM SUB-HEADER ====================
    public array $headerBottom = [];

    // ==================== MASTER WRAPPER: FOOTER SECTION ====================
    public array $footerSectionBoxModel = [];
    public array $footerSectionBgColor = [];
    public array $footerSectionTextColor = [];

    // ==================== ROW 1: PRE-FOOTER CALLOUT ====================
    public array $footerTop = [];

    // ==================== ROW 2: MAIN MODULAR FOOTER GRID ====================
    public array $footerBgColor = [];
    public array $footerTextColor = [];
    public array $footerBoxModel = [];
    public array $footerColumns = [];
    public ?int $expandedFooterColIndex = null;

    // ==================== ROW 3: BOTTOM SUB-FOOTER ====================
    public array $footerBottomColumns = [];
    public array $footerBottomBgColor = [];
    public array $footerBottomTextColor = [];
    public array $footerBottomBoxModel = [];
    public ?int $expandedBottomColIndex = null;
    public array $footerConfig = [];

    public function mount(): void
    {
        // 0. Master Header Section (Wrapper)
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

        // 1. Header Row 1: Topbar
        $this->headerTopbar = array_merge([
            'enabled'           => true,
            'alignment'         => 'between',
            'density'           => 'standard',
            'badge_text'        => '24/7 Port Call & Emergency Squads',
            'subtext'           => 'Authorized Multi-Brand Turbocharger Engineering',
            'show_badge'        => true,
            'show_phone'        => true,
            'show_email'        => true,
            'show_social'       => true,
            'show_custom_link'  => true,
            'custom_link_text'  => 'Vessel Tracking',
            'custom_link_url'   => '#tracking',
            'custom_link_blank' => true,
            'phone'             => '',
            'email'             => '',
            'admin_link'        => false,
        ], Setting::getJson('header_topbar') ?: []);

        $this->topbarBgColor = Setting::getJson('topbar_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#050f18',
            'opacity' => 95,
        ];
        $this->topbarTextColor = Setting::getJson('topbar_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#334155',
            'dark'    => '#cbd5e1',
            'opacity' => 100,
        ];
        $this->topbarBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('topbar_box_model'), [
            'width'   => '1536px',
            'padding' => ['mode' => 'axis', 'y' => '6px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);

        // 2. Header Row 2: Main Header Navbar
        $this->headerStyle = Setting::get('theme_header_style', 'glass');
        $this->headerHeight = Setting::get('theme_header_height', '80px');
        $this->headerSticky = Setting::get('header_sticky', '1') == '1';
        $this->headerThemeToggle = Setting::get('header_theme_toggle', '1') == '1';
        $this->headerBgColor = Setting::getJson('header_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#07131e',
            'opacity' => 100,
        ];
        $this->headerTextColor = Setting::getJson('header_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#0f172a',
            'dark'    => '#ffffff',
            'opacity' => 100,
        ];
        $this->headerBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('header_box_model'), [
            'width'   => '1536px',
            'padding' => ['mode' => 'axis', 'y' => '0px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->headerBorderSpan = Setting::get('header_border_span', 'full');
        $this->headerBorderWidth = Setting::get('header_border_width', '1px');
        $this->headerBorderColor = Setting::get('header_border_color', '');
        $this->headerMenuId = Setting::get('header_menu_id') ? (int) Setting::get('header_menu_id') : null;
        $this->headerCta = array_merge([
            'enabled'   => true,
            'label'     => 'Request RFQ',
            'link'      => ['type' => 'internal', 'page' => 'contact', 'section' => 'rfq', 'target_blank' => false],
            'show_icon' => true,
        ], Setting::getJson('header_cta') ?: []);

        // 3. Header Row 3: Bottom Sub-Header Bar
        $this->headerBottom = array_merge([
            'enabled'    => false,
            'text'       => 'Authorized Multi-Brand Turbocharger Engineering Bulletin & Port Flying Squad Notice',
            'layout'     => 'between', // 'between', 'center', 'start'
            'items'      => [
                ['label' => 'Dynamic Balancing', 'url' => '/services#balancing', 'icon' => 'solid:arrows-spin'],
                ['label' => 'Emergency Squads', 'url' => '/services#flying-squad', 'icon' => 'solid:truck-fast'],
                ['label' => 'OEM Spares', 'url' => '/products', 'icon' => 'solid:boxes-stacked'],
            ],
            'bg_color'   => ['mode' => 'theme', 'light' => '#f8fafc', 'dark' => '#061320', 'opacity' => 95],
            'text_color' => ['mode' => 'theme', 'light' => '#475569', 'dark' => '#94a3b8', 'opacity' => 100],
            'box_model'  => [
                'width'   => '1536px',
                'padding' => ['mode' => 'axis', 'y' => '8px', 'x' => '24px'],
                'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
            ],
        ], Setting::getJson('header_bottom') ?: []);

        // 0. Master Footer Section (Wrapper)
        $this->footerSectionBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_section_box_model'), [
            'width'   => '100%',
            'padding' => ['mode' => 'axis', 'y' => '0px', 'x' => '0px'],
            'margin'  => ['top' => '0px', 'bottom' => '0px', 'center' => true],
            'border'  => ['enabled' => true, 'width' => '1px', 'side' => 'top', 'style' => 'solid', 'color' => '#e2e8f0'],
            'shadow'  => 'none',
        ]);
        $this->footerSectionBgColor = Setting::getJson('footer_section_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#f1f5f9',
            'dark'    => '#040e17',
            'opacity' => 95,
        ];
        $this->footerSectionTextColor = Setting::getJson('footer_section_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#334155',
            'dark'    => '#cbd5e1',
            'opacity' => 100,
        ];

        // 1. Footer Row 1: Top Pre-Footer Callout
        $this->footerTop = array_merge([
            'enabled'     => true,
            'type'        => 'newsletter_callout', // 'newsletter_callout', 'hotline_banner', 'custom_callout'
            'headline'    => 'Subscribe to Maritime Technical Bulletins',
            'subtext'     => 'Receive real-time turbocharger service advisories, port flying squad bulletins, and parts catalog updates.',
            'button_text' => 'Subscribe',
            'placeholder' => 'Enter corporate email address...',
            'phone'       => '+880 1800-000000',
            'bg_color'    => ['mode' => 'theme', 'light' => '#003C58', 'dark' => '#061a28', 'opacity' => 100],
            'text_color'  => ['mode' => 'theme', 'light' => '#ffffff', 'dark' => '#f1f5f9', 'opacity' => 100],
            'box_model'   => [
                'width'   => '1536px',
                'padding' => ['mode' => 'axis', 'y' => '24px', 'x' => '24px'],
                'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#0c2738'],
            ],
        ], Setting::getJson('footer_top') ?: []);

        // 2. Footer Row 2: Main Modular Footer Columns
        $this->footerBgColor = Setting::getJson('footer_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#f1f5f9',
            'dark'    => '#040e17',
            'opacity' => 95,
        ];
        $this->footerTextColor = Setting::getJson('footer_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#334155',
            'dark'    => '#cbd5e1',
            'opacity' => 100,
        ];
        $this->footerBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_box_model'), [
            'width'   => '1536px',
            'padding' => ['mode' => 'axis', 'y' => '48px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->footerColumns = Setting::getJson('footer_columns') ?: $this->getDefaultFooterColumns();

        // 3. Footer Row 3: Bottom Sub-Footer
        $this->footerBottomColumns = Setting::getJson('footer_bottom_columns') ?: $this->getDefaultFooterBottomColumns();
        $this->footerBottomBgColor = Setting::getJson('footer_bottom_bg_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#ffffff',
            'dark'    => '#02070c',
            'opacity' => 100,
        ];
        $this->footerBottomTextColor = Setting::getJson('footer_bottom_text_color') ?: [
            'mode'    => 'theme',
            'type'    => 'solid',
            'light'   => '#64748b',
            'dark'    => '#94a3b8',
            'opacity' => 100,
        ];
        $this->footerBottomBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_bottom_box_model'), [
            'width'   => '1536px',
            'padding' => ['mode' => 'axis', 'y' => '20px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'top', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->footerConfig = array_merge([
            'show_social'    => true,
            'show_divisions' => true,
            'show_services'  => true,
            'show_offices'   => true,
            'show_iso'       => true,
            'show_login'     => true,
            'bio'            => '',
            'copyright'      => '',
        ], Setting::getJson('footer_config') ?: []);
    }

    public function selectHeaderRow(string $row): void
    {
        $this->activeHeaderRow = $row;
    }

    public function selectFooterRow(string $row): void
    {
        $this->activeFooterRow = $row;
    }

    public function setHeaderSubTab(string $tab): void
    {
        $this->headerSubTab = $tab;
    }

    public function setFooterSubTab(string $tab): void
    {
        $this->footerSubTab = $tab;
    }

    public function addHeaderBottomLink(): void
    {
        if (!isset($this->headerBottom['items'])) {
            $this->headerBottom['items'] = [];
        }
        $this->headerBottom['items'][] = [
            'label' => 'New Service Link',
            'url'   => '#',
            'icon'  => 'solid:link',
        ];
    }

    public function removeHeaderBottomLink(int $index): void
    {
        if (isset($this->headerBottom['items'][$index])) {
            array_splice($this->headerBottom['items'], $index, 1);
        }
    }

    public function addFooterColumn(): void
    {
        if (count($this->footerColumns) >= 5) {
            return;
        }

        $this->footerColumns[] = [
            'type'    => 'static_list',
            'title'   => 'Quick Links',
            'span'    => 1,
            'content' => [
                'items' => [
                    ['label' => 'Company Profile', 'link' => ['type' => 'internal', 'page' => 'about', 'section' => '', 'target_blank' => false]],
                    ['label' => 'Emergency Response', 'link' => ['type' => 'internal', 'page' => 'services', 'section' => 'flying-squad', 'target_blank' => false]],
                ],
            ],
        ];
        $this->expandedFooterColIndex = count($this->footerColumns) - 1;
    }

    public function removeFooterColumn(int $index): void
    {
        if (isset($this->footerColumns[$index])) {
            array_splice($this->footerColumns, $index, 1);
            $this->expandedFooterColIndex = null;
        }
    }

    public function toggleFooterCol(int $index): void
    {
        $this->expandedFooterColIndex = $this->expandedFooterColIndex === $index ? null : $index;
    }

    public function setFooterLayoutPreset(int $count): void
    {
        $count = max(1, min(5, $count));
        $defaults = $this->getDefaultFooterColumns();
        $this->footerColumns = array_slice($defaults, 0, $count);
        $this->expandedFooterColIndex = null;
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

    public function save(): void
    {
        // 0. Master Wrapper: Header Section
        Setting::set('header_section_box_model', $this->headerSectionBoxModel, 'header', 'json');
        Setting::set('header_section_bg_color', $this->headerSectionBgColor, 'header', 'json');
        Setting::set('header_section_text_color', $this->headerSectionTextColor, 'header', 'json');

        // 1. Header Row 1: Topbar
        Setting::set('header_topbar', $this->headerTopbar, 'header', 'json');
        Setting::set('topbar_bg_color', $this->topbarBgColor, 'header', 'json');
        Setting::set('topbar_text_color', $this->topbarTextColor, 'header', 'json');
        Setting::set('topbar_box_model', $this->topbarBoxModel, 'header', 'json');

        // 2. Header Row 2: Main Header Navbar
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

        // 3. Header Row 3: Bottom Sub-Header Bar
        Setting::set('header_bottom', $this->headerBottom, 'header', 'json');

        // 0. Master Wrapper: Footer Section
        Setting::set('footer_section_box_model', $this->footerSectionBoxModel, 'footer', 'json');
        Setting::set('footer_section_bg_color', $this->footerSectionBgColor, 'footer', 'json');
        Setting::set('footer_section_text_color', $this->footerSectionTextColor, 'footer', 'json');

        // 1. Footer Row 1: Pre-Footer Top
        Setting::set('footer_top', $this->footerTop, 'footer', 'json');

        // 2. Footer Row 2: Main Footer Modular Grid
        Setting::set('footer_bg_color', $this->footerBgColor, 'footer', 'json');
        Setting::set('footer_text_color', $this->footerTextColor, 'footer', 'json');
        Setting::set('footer_box_model', $this->footerBoxModel, 'footer', 'json');
        Setting::set('footer_columns', $this->footerColumns, 'footer', 'json');

        // 3. Footer Row 3: Bottom Sub-Footer
        Setting::set('footer_bottom_columns', $this->footerBottomColumns, 'footer', 'json');
        Setting::set('footer_bottom_bg_color', $this->footerBottomBgColor, 'footer', 'json');
        Setting::set('footer_bottom_text_color', $this->footerBottomTextColor, 'footer', 'json');
        Setting::set('footer_bottom_box_model', $this->footerBottomBoxModel, 'footer', 'json');
        Setting::set('footer_config', $this->footerConfig, 'footer', 'json');

        session()->flash('message', 'Header and Footer configuration successfully synchronized and published across the website.');
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

    public function render()
    {
        return view('livewire.admin.theme.header-footer-builder', [
            'availableMenus' => Menu::withCount('items')->get(),
        ])->layout('components.layouts.admin', [
            'title' => 'Header & Footer Builder | ' . Setting::get('site_name', 'Nordroy CMS'),
        ]);
    }
}
