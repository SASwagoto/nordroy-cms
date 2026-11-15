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

    // ==================== ROW 1: TOPBAR STATE ====================
    public array $headerTopbar = [];
    public array $topbarBgColor = [];
    public array $topbarTextColor = [];
    public array $topbarBoxModel = [];

    // ==================== ROW 2: MAIN HEADER STATE ====================
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

    // ==================== ROW 3: BOTTOM SUB-HEADER STATE ====================
    public array $headerBottom = [];

    // ==================== ROW 1: PRE-FOOTER TOP CALLOUT STATE ====================
    public array $footerTop = [];

    // ==================== ROW 2: MAIN MODULAR FOOTER GRID STATE ====================
    public array $footerBgColor = [];
    public array $footerTextColor = [];
    public array $footerBoxModel = [];
    public array $footerColumns = [];
    public ?int $expandedFooterColIndex = null;

    // ==================== ROW 3: BOTTOM SUB-FOOTER STATE ====================
    public array $footerBottomColumns = [];
    public array $footerBottomBgColor = [];
    public array $footerBottomTextColor = [];
    public array $footerBottomBoxModel = [];
    public ?int $expandedBottomColIndex = null;
    public array $footerConfig = [];

    public function mount(): void
    {
        // 1. Row 1: Topbar
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

        // 2. Row 2: Main Header
        $this->headerStyle = Setting::get('theme_header_style', 'glass');
        $this->headerHeight = Setting::get('theme_header_height', '80px');
        $this->headerSticky = (bool) Setting::get('header_sticky', '1');
        $this->headerThemeToggle = (bool) Setting::get('header_theme_toggle', '1');
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

        // 3. Row 3: Bottom Sub-Header
        $this->headerBottom = array_merge([
            'enabled'    => false,
            'layout'     => 'between',
            'text'       => 'Authorized Multi-Brand Turbocharger Engineering & Dynamic Balancing',
            'items'      => [
                ['label' => 'Technical Specs', 'url' => '/services#specs', 'icon' => 'solid:gear'],
                ['label' => 'Port Squads 24/7', 'url' => '/services#flying-squad', 'icon' => 'solid:ship'],
            ],
            'bg_color'   => ['mode' => 'theme', 'type' => 'solid', 'light' => '#f8fafc', 'dark' => '#061320', 'opacity' => 90],
            'text_color' => ['mode' => 'theme', 'type' => 'solid', 'light' => '#475569', 'dark' => '#94a3b8', 'opacity' => 100],
            'box_model'  => [
                'width'   => '1536px',
                'padding' => ['mode' => 'axis', 'y' => '6px', 'x' => '24px'],
                'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
            ],
        ], Setting::getJson('header_bottom') ?: []);

        // 4. Footer Row 1: Pre-Footer Top Callout
        $this->footerTop = array_merge([
            'enabled'     => true,
            'type'        => 'newsletter_callout',
            'headline'    => 'Subscribe to Maritime Technical Bulletins',
            'subtext'     => 'Receive the latest turbocharger overhaul updates, port schedules, and OEM parts arrivals.',
            'button_text' => 'Subscribe',
            'placeholder' => 'Enter your corporate email...',
            'phone'       => '+880 1800-000000',
            'bg_color'    => ['mode' => 'theme', 'type' => 'solid', 'light' => '#003C58', 'dark' => '#061a28', 'opacity' => 100],
            'text_color'  => ['mode' => 'theme', 'type' => 'solid', 'light' => '#ffffff', 'dark' => '#f1f5f9', 'opacity' => 100],
            'box_model'   => [
                'width'   => '1536px',
                'padding' => ['mode' => 'axis', 'y' => '32px', 'x' => '24px'],
                'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
            ],
        ], Setting::getJson('footer_top') ?: []);

        // 5. Footer Row 2: Main Modular Footer
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
            'padding' => ['mode' => 'axis', 'y' => '64px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'top', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->footerColumns = Setting::getJson('footer_columns') ?: $this->getDefaultFooterColumns();

        // 6. Footer Row 3: Sub-Footer
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
                    ['label' => 'About Us', 'link' => ['type' => 'internal', 'page' => 'about'], 'icon' => 'solid:chevron-right'],
                    ['label' => 'Services', 'link' => ['type' => 'internal', 'page' => 'services'], 'icon' => 'solid:chevron-right'],
                    ['label' => 'Contact Us', 'link' => ['type' => 'internal', 'page' => 'contact'], 'icon' => 'solid:chevron-right'],
                ],
            ],
        ];
    }

    public function removeFooterColumn(int $index): void
    {
        if (isset($this->footerColumns[$index])) {
            array_splice($this->footerColumns, $index, 1);
        }
    }

    public function toggleFooterCol(int $index): void
    {
        $this->expandedFooterColIndex = ($this->expandedFooterColIndex === $index) ? null : $index;
    }

    public function addStaticListItem(int $colIndex): void
    {
        if (!isset($this->footerColumns[$colIndex]['content']['items'])) {
            $this->footerColumns[$colIndex]['content']['items'] = [];
        }
        $this->footerColumns[$colIndex]['content']['items'][] = [
            'label' => 'New Navigation Item',
            'link'  => ['type' => 'external', 'url' => '#', 'target_blank' => false],
            'icon'  => 'solid:link',
        ];
    }

    public function removeStaticListItem(int $colIndex, int $itemIndex): void
    {
        if (isset($this->footerColumns[$colIndex]['content']['items'][$itemIndex])) {
            array_splice($this->footerColumns[$colIndex]['content']['items'], $itemIndex, 1);
        }
    }

    public function save(): void
    {
        // 1. Topbar
        Setting::set('header_topbar', $this->headerTopbar, 'header', 'json');
        Setting::set('topbar_bg_color', $this->topbarBgColor, 'header', 'json');
        Setting::set('topbar_text_color', $this->topbarTextColor, 'header', 'json');
        Setting::set('topbar_box_model', $this->topbarBoxModel, 'header', 'json');

        // 2. Main Header
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

        // 3. Sub-Header
        Setting::set('header_bottom', $this->headerBottom, 'header', 'json');

        // 4. Footer Top
        Setting::set('footer_top', $this->footerTop, 'footer', 'json');

        // 5. Main Footer Grid
        Setting::set('footer_bg_color', $this->footerBgColor, 'footer', 'json');
        Setting::set('footer_text_color', $this->footerTextColor, 'footer', 'json');
        Setting::set('footer_box_model', $this->footerBoxModel, 'footer', 'json');
        Setting::set('footer_columns', $this->footerColumns, 'footer', 'json');

        // 6. Sub-Footer
        Setting::set('footer_bottom_columns', $this->footerBottomColumns, 'footer', 'json');
        Setting::set('footer_bottom_bg_color', $this->footerBottomBgColor, 'footer', 'json');
        Setting::set('footer_bottom_text_color', $this->footerBottomTextColor, 'footer', 'json');
        Setting::set('footer_bottom_box_model', $this->footerBottomBoxModel, 'footer', 'json');
        Setting::set('footer_config', $this->footerConfig, 'footer', 'json');

        session()->flash('message', 'Header and Footer configuration successfully synchronized and published across the website.');
    }

    public function getDefaultFooterColumns(): array
    {
        return (new ThemeStudio())->getDefaultFooterColumns();
    }

    public function getDefaultFooterBottomColumns(): array
    {
        return (new ThemeStudio())->getDefaultFooterBottomColumns();
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
