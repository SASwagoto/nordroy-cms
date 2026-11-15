<?php

namespace App\Livewire\Admin\Theme;

use App\Models\Menu;
use App\Models\Setting;
use App\Services\SmartBoxModelHelper;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class ThemeStudio extends Component
{
    use WithFileUploads;

    public string $activeTab = 'colors'; // 'colors', 'typography', 'buttons', 'cards', 'header', 'footer', 'layout', 'background'

    // Media Modal State
    public ?string $modalTargetField = null;
    public ?int $modalTargetIndex = null;
    public $uploads = [];
    public string $uploadFolder = 'branding';
    public bool $autoCompress = true;

    // Full Design Tokens State
    public array $theme = [];

    // Header & Navigation Builder State
    public ?int $headerMenuId = null;
    public array $headerBgColor = [
        'mode'    => 'theme',
        'light'   => '#ffffff',
        'dark'    => '#07131e',
        'opacity' => 100,
    ];
    public array $headerTextColor = [
        'mode'    => 'theme',
        'light'   => '#0f172a',
        'dark'    => '#ffffff',
        'opacity' => 100,
    ];
    public array $headerMenuItems = [];
    public array $headerCta = [];
    public array $headerTopbar = [];
    public array $topbarBgColor = [
        'mode'    => 'theme',
        'light'   => '#ffffff',
        'dark'    => '#050f18',
        'opacity' => 95,
    ];
    public array $topbarTextColor = [
        'mode'    => 'theme',
        'light'   => '#334155',
        'dark'    => '#cbd5e1',
        'opacity' => 100,
    ];
    public array $topbarBoxModel = [];
    public array $headerBoxModel = [];
    public string $headerBorderSpan = 'full'; // 'full' or 'boxed'
    public string $headerBorderWidth = '1px'; // '0px', '1px', '2px', '3px', '4px'
    public string $headerBorderColor = '';
    public bool $headerSticky = true;
    public bool $headerThemeToggle = true;
    public ?int $expandedMenuIndex = null;

    // Modular Footer Customizer State (Elementor-Style Row & Column Engine)
    public array $footerBgColor = [
        'mode'    => 'theme',
        'light'   => '#f1f5f9',
        'dark'    => '#040e17',
        'opacity' => 95,
    ];
    public array $footerTextColor = [
        'mode'    => 'theme',
        'light'   => '#334155',
        'dark'    => '#cbd5e1',
        'opacity' => 100,
    ];
    public array $footerBoxModel = [];
    public array $footerColumns = [];
    public array $footerBottomColumns = [];
    public ?int $expandedFooterColIndex = null;
    public ?int $expandedBottomColIndex = null;
    public array $footerConfig = [
        'show_social'    => true,
        'show_divisions' => true,
        'show_services'  => true,
        'show_offices'   => true,
        'show_iso'       => true,
        'show_login'     => true,
        'bio'            => '',
        'copyright'      => '',
    ];

    // Global Layout & Section Spacing Engine
    public array $sectionBoxModel = [];

    // Pre-engineered Industrial Presets
    public array $presets = [
        'nordroy_marine' => [
            'name'          => 'Nordroy Marine & Power (Active)',
            'primary'       => '#003C58',
            'secondary'     => '#75767A',
            'accent'        => '#0ea5e9',
            'surface_light' => '#ffffff',
            'surface_dark'  => '#07131e',
            'border_color'  => '#e2e8f0',
            'font_head'     => 'Plus Jakarta Sans',
            'font_body'     => 'Plus Jakarta Sans',
            'radius'        => '12px',
            'container_w'   => '1536px',
            'section_py'    => '96px',
            'button_style'  => 'solid',
            'header_style'  => 'glass',
            'card_shadow'   => 'shadow-sm',
            'card_border'   => 'subtle',
        ],
        'turbo_steel' => [
            'name'          => 'Turbo Precision Steel',
            'primary'       => '#0f172a',
            'secondary'     => '#475569',
            'accent'        => '#d97706',
            'surface_light' => '#f8fafc',
            'surface_dark'  => '#020617',
            'border_color'  => '#cbd5e1',
            'font_head'     => 'Space Grotesk',
            'font_body'     => 'Inter',
            'radius'        => '6px',
            'container_w'   => '1600px',
            'section_py'    => '112px',
            'button_style'  => 'outline_bold',
            'header_style'  => 'solid',
            'card_shadow'   => 'shadow-md',
            'card_border'   => 'subtle',
        ],
        'clean_energy' => [
            'name'          => 'Nordic Clean Energy & Wind',
            'primary'       => '#064e3b',
            'secondary'     => '#334155',
            'accent'        => '#10b981',
            'surface_light' => '#ffffff',
            'surface_dark'  => '#022c22',
            'border_color'  => '#e2e8f0',
            'font_head'     => 'Outfit',
            'font_body'     => 'Inter',
            'radius'        => '14px',
            'container_w'   => '1536px',
            'section_py'    => '96px',
            'button_style'  => 'gradient',
            'header_style'  => 'glass',
            'card_shadow'   => 'shadow-sm',
            'card_border'   => 'subtle',
        ],
        'dana_conglomerate' => [
            'name'          => 'Dana Conglomerate Navy',
            'primary'       => '#0b2545',
            'secondary'     => '#134074',
            'accent'        => '#c59b27',
            'surface_light' => '#ffffff',
            'surface_dark'  => '#051329',
            'border_color'  => '#e2e8f0',
            'font_head'     => 'Montserrat',
            'font_body'     => 'Inter',
            'radius'        => '8px',
            'container_w'   => '1440px',
            'section_py'    => '80px',
            'button_style'  => 'solid',
            'header_style'  => 'transparent',
            'card_shadow'   => 'shadow-sm',
            'card_border'   => 'subtle',
        ],
        'cyber_titanium' => [
            'name'          => 'High-Tech Cyber Titanium',
            'primary'       => '#0b0f19',
            'secondary'     => '#64748b',
            'accent'        => '#06b6d4',
            'surface_light' => '#f1f5f9',
            'surface_dark'  => '#050811',
            'border_color'  => '#334155',
            'font_head'     => 'Syne',
            'font_body'     => 'Inter',
            'radius'        => '10px',
            'container_w'   => '1536px',
            'section_py'    => '100px',
            'button_style'  => 'gradient',
            'header_style'  => 'glass',
            'card_shadow'   => 'glow',
            'card_border'   => 'subtle',
        ],
        'heavy_machinery' => [
            'name'          => 'Apex Heavy Machinery',
            'primary'       => '#18181b',
            'secondary'     => '#52525b',
            'accent'        => '#eab308',
            'surface_light' => '#fafafa',
            'surface_dark'  => '#09090b',
            'border_color'  => '#e4e4e7',
            'font_head'     => 'Plus Jakarta Sans',
            'font_body'     => 'Inter',
            'radius'        => '4px',
            'container_w'   => '1600px',
            'section_py'    => '112px',
            'button_style'  => 'solid',
            'header_style'  => 'solid',
            'card_shadow'   => 'none',
            'card_border'   => 'subtle',
        ],
        'aerospace_crimson' => [
            'name'          => 'Aerospace & Defense Crimson',
            'primary'       => '#09090b',
            'secondary'     => '#71717a',
            'accent'        => '#e11d48',
            'surface_light' => '#ffffff',
            'surface_dark'  => '#050507',
            'border_color'  => '#e4e4e7',
            'font_head'     => 'Outfit',
            'font_body'     => 'Plus Jakarta Sans',
            'radius'        => '8px',
            'container_w'   => '1440px',
            'section_py'    => '96px',
            'button_style'  => 'gradient',
            'header_style'  => 'glass',
            'card_shadow'   => 'shadow-md',
            'card_border'   => 'subtle',
        ],
        'swiss_minimal' => [
            'name'          => 'Swiss Minimalist Monochrome',
            'primary'       => '#0a0a0a',
            'secondary'     => '#525252',
            'accent'        => '#2563eb',
            'surface_light' => '#ffffff',
            'surface_dark'  => '#121212',
            'border_color'  => '#e5e5e5',
            'font_head'     => 'Inter',
            'font_body'     => 'Inter',
            'radius'        => '0px',
            'container_w'   => '1440px',
            'section_py'    => '96px',
            'button_style'  => 'outline_bold',
            'header_style'  => 'solid',
            'card_shadow'   => 'none',
            'card_border'   => 'subtle',
        ],
    ];

    public function mount(): void
    {
        $existing = Setting::all()->pluck('value', 'key')->toArray();

        $defaults = [
            // Colors (Official Logo Brand Colors: #003C58 & #75767A)
            'theme_primary_color'    => '#003C58',
            'theme_secondary_color'  => '#75767A',
            'theme_accent_color'     => '#0ea5e9',
            'theme_surface_light'    => '#ffffff',
            'theme_surface_dark'     => '#07131e',
            'theme_border_color'     => '#e2e8f0',

            // Typography
            'theme_heading_font'     => 'Plus Jakarta Sans',
            'theme_body_font'        => 'Plus Jakarta Sans',
            'theme_letter_spacing'   => '-0.02em',
            'theme_heading_weight'   => '800',
            'theme_base_font_size'   => '16px',
            'theme_line_height'      => '1.6',

            // Buttons & UI Geometry
            'theme_button_radius'    => '12px',
            'theme_button_style'     => 'solid', // 'solid', 'gradient', 'outline_bold', 'soft_tint'
            'theme_button_hover'     => 'lift',  // 'lift', 'glow', 'scale', 'none'

            // Cards & Surface Elevation
            'theme_card_shadow'      => 'shadow-sm', // 'none', 'shadow-sm', 'shadow-md', 'shadow-lg', 'glow'
            'theme_card_border'      => 'subtle',    // 'none', 'subtle', 'accent_top'
            'theme_card_radius'      => '16px',

            // Header & Navigation
            'theme_header_style'     => 'glass',     // 'glass', 'solid', 'transparent', 'floating'
            'theme_header_height'    => '80px',

            // Layout & Spacing
            'theme_container_width'  => '1536px', // 2xl
            'theme_section_padding'  => '96px',   // py-24

            // Full-Site Background & Motion Video (Turbo Internacional Architecture)
            'site_bg_video_enabled'     => '1',
            'site_bg_video_url'         => 'assets/videos/background-marine.mp4',
            'site_bg_video_opacity'     => '85',
            'theme_hero_backdrop'       => 'frosted', // 'frosted', 'transparent', 'subtle_tint', 'solid'
            'theme_video_break_enabled' => '1',
        ];

        $this->theme = array_merge($defaults, $existing);

        // Initialize Header & Navigation Builder State
        $this->headerBgColor = Setting::getJson('header_bg_color') ?: [
            'mode'    => 'theme',
            'light'   => '#ffffff',
            'dark'    => '#07131e',
            'opacity' => 100,
        ];
        $this->headerTextColor = Setting::getJson('header_text_color') ?: [
            'mode'    => 'theme',
            'light'   => '#0f172a',
            'dark'    => '#ffffff',
            'opacity' => 100,
        ];
        $this->headerMenuId = Setting::get('header_menu_id')
            ? (int) Setting::get('header_menu_id')
            : (Menu::where('location', 'primary')->value('id') ?? Menu::value('id') ?? null);
        $this->headerMenuItems = Setting::getJson('header_menu_items') ?: $this->getDefaultMenuItems();
        $this->headerCta = array_merge($this->getDefaultHeaderCta(), Setting::getJson('header_cta') ?: []);
        $this->headerTopbar = array_merge($this->getDefaultHeaderTopbar(), Setting::getJson('header_topbar') ?: []);
        $this->topbarBgColor = Setting::getJson('topbar_bg_color') ?: ($this->headerTopbar['bg_color'] ?? [
            'mode'    => 'theme',
            'light'   => '#ffffff',
            'dark'    => '#050f18',
            'opacity' => 95,
        ]);
        $this->topbarTextColor = Setting::getJson('topbar_text_color') ?: ($this->headerTopbar['text_color'] ?? [
            'mode'    => 'theme',
            'light'   => '#334155',
            'dark'    => '#cbd5e1',
            'opacity' => 100,
        ]);
        $this->topbarBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('topbar_box_model'), [
            'padding' => ['mode' => 'axis', 'y' => '8px', 'x' => '16px'],
            'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->headerBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('header_box_model'), [
            'padding' => ['mode' => 'axis', 'y' => '0px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'bottom', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->headerBorderSpan = Setting::get('header_border_span', 'full');
        $this->headerBorderWidth = Setting::get('header_border_width', '1px');
        $this->headerBorderColor = Setting::get('header_border_color', '');
        $this->headerSticky = (bool) Setting::get('header_sticky', '1');
        $this->headerThemeToggle = (bool) Setting::get('header_theme_toggle', '1');

        // Initialize Modular Footer Customizer State
        $this->footerBgColor = Setting::getJson('footer_bg_color') ?: [
            'mode'    => 'theme',
            'light'   => '#f1f5f9',
            'dark'    => '#040e17',
            'opacity' => 95,
        ];
        $this->footerTextColor = Setting::getJson('footer_text_color') ?: [
            'mode'    => 'theme',
            'light'   => '#334155',
            'dark'    => '#cbd5e1',
            'opacity' => 100,
        ];
        $this->footerBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('footer_box_model'), [
            'padding' => ['mode' => 'axis', 'y' => '64px', 'x' => '24px'],
            'border'  => ['width' => '1px', 'side' => 'top', 'style' => 'solid', 'color' => '#e2e8f0'],
        ]);
        $this->footerColumns = Setting::getJson('footer_columns') ?: $this->getDefaultFooterColumns();
        $this->footerBottomColumns = Setting::getJson('footer_bottom_columns') ?: $this->getDefaultFooterBottomColumns();
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

        // Global Layout & Section Spacing Engine
        $this->sectionBoxModel = SmartBoxModelHelper::normalize(Setting::getJson('section_box_model'), [
            'padding' => ['mode' => 'axis', 'y' => $this->theme['theme_section_padding'] ?? '96px', 'x' => '24px'],
            'width'   => $this->theme['theme_container_width'] ?? '1536px',
        ]);
    }

    #[On('media-selected')]
    public function handleMediaSelected(int $assetId, string $assetUrl, ?string $targetField = null): void
    {
        $field = $targetField ?: $this->modalTargetField;
        if ($field && array_key_exists($field, $this->theme)) {
            $this->theme[$field] = $assetUrl;
        }
        $this->dispatch('close-media-modal');
    }

    public function selectAsset(int $assetId, string $assetUrl, ?string $targetField = null, ?int $targetIndex = null): void
    {
        $field = $targetField ?: $this->modalTargetField;
        if ($field && array_key_exists($field, $this->theme)) {
            $this->theme[$field] = $assetUrl;
        }
        $this->dispatch('close-media-modal');
    }

    public function uploadFiles(?string $targetField = null, ?int $targetIndex = null): void
    {
        if (empty($this->uploads) || !is_array($this->uploads)) {
            $this->addError('uploads', 'Please select at least one file to upload.');
            return;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf', 'gif', 'ico', 'mp4', 'webm'];
        $service = app(\App\Services\MediaStorageService::class);
        $lastAsset = null;
        $successCount = 0;

        foreach ($this->uploads as $file) {
            if ($file) {
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, $allowedExtensions)) {
                    continue;
                }

                $folder = $this->uploadFolder ?: 'branding';
                $lastAsset = $service->store($file, $folder, null, $this->autoCompress);
                $successCount++;

                $this->dispatch('media-asset-uploaded', [
                    'id'       => $lastAsset->id,
                    'name'     => $lastAsset->getTranslation('title', 'en') ?: $lastAsset->file_name,
                    'url'      => $lastAsset->url,
                    'is_image' => in_array(strtolower(pathinfo($lastAsset->file_name, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','svg','gif','ico']),
                    'size'     => $lastAsset->human_size,
                    'folder'   => $lastAsset->folder,
                ]);
            }
        }

        $this->uploads = [];

        if ($successCount > 0 && $lastAsset) {
            $field = $targetField ?: $this->modalTargetField;
            $index = $targetIndex ?? $this->modalTargetIndex;
            $this->selectAsset($lastAsset->id, $lastAsset->url, $field, $index);
            session()->flash('message', "{$successCount} asset(s) successfully uploaded and synchronized.");
            $this->dispatch('close-media-modal');
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function applyPreset(string $presetKey): void
    {
        if (isset($this->presets[$presetKey])) {
            $p = $this->presets[$presetKey];
            $this->theme['theme_primary_color']   = $p['primary'];
            $this->theme['theme_secondary_color'] = $p['secondary'];
            $this->theme['theme_accent_color']    = $p['accent'];
            $this->theme['theme_surface_light']   = $p['surface_light'];
            $this->theme['theme_surface_dark']    = $p['surface_dark'];
            $this->theme['theme_border_color']    = $p['border_color'];
            $this->theme['theme_heading_font']    = $p['font_head'];
            $this->theme['theme_body_font']       = $p['font_body'];
            $this->theme['theme_button_radius']   = $p['radius'];
            $this->theme['theme_container_width'] = $p['container_w'];
            $this->theme['theme_section_padding'] = $p['section_py'];
            $this->theme['theme_button_style']    = $p['button_style'];
            $this->theme['theme_header_style']    = $p['header_style'];
            $this->theme['theme_card_shadow']     = $p['card_shadow'] ?? 'shadow-sm';
            $this->theme['theme_card_border']     = $p['card_border'] ?? 'subtle';
        }
    }

    public function toggleMenuItem(int $index): void
    {
        $this->expandedMenuIndex = ($this->expandedMenuIndex === $index) ? null : $index;
    }

    public function addMenuItem(): void
    {
        $this->headerMenuItems[] = [
            'id'       => 'nav_' . uniqid(),
            'label'    => 'New Menu Item',
            'link'     => ['type' => 'internal', 'page' => 'home', 'section' => '', 'target_blank' => false],
            'children' => [],
        ];
        $this->expandedMenuIndex = count($this->headerMenuItems) - 1;
    }

    public function removeMenuItem(int $index): void
    {
        if (isset($this->headerMenuItems[$index])) {
            array_splice($this->headerMenuItems, $index, 1);
            if ($this->expandedMenuIndex === $index) {
                $this->expandedMenuIndex = null;
            } elseif ($this->expandedMenuIndex > $index) {
                $this->expandedMenuIndex--;
            }
        }
    }

    public function moveMenuItem(int $index, string $direction): void
    {
        $targetIndex = $direction === 'up' ? $index - 1 : $index + 1;
        if ($targetIndex >= 0 && $targetIndex < count($this->headerMenuItems)) {
            $temp = $this->headerMenuItems[$index];
            $this->headerMenuItems[$index] = $this->headerMenuItems[$targetIndex];
            $this->headerMenuItems[$targetIndex] = $temp;
            $this->expandedMenuIndex = $targetIndex;
        }
    }

    public function addChildMenuItem(int $parentIndex): void
    {
        if (!isset($this->headerMenuItems[$parentIndex]['children'])) {
            $this->headerMenuItems[$parentIndex]['children'] = [];
        }
        $this->headerMenuItems[$parentIndex]['children'][] = [
            'id'    => 'child_' . uniqid(),
            'label' => 'Sub Item',
            'link'  => ['type' => 'internal', 'page' => 'services', 'section' => '', 'target_blank' => false],
        ];
        $this->expandedMenuIndex = $parentIndex;
    }

    public function removeChildMenuItem(int $parentIndex, int $childIndex): void
    {
        if (isset($this->headerMenuItems[$parentIndex]['children'][$childIndex])) {
            array_splice($this->headerMenuItems[$parentIndex]['children'], $childIndex, 1);
        }
    }

    public function moveChildMenuItem(int $parentIndex, int $childIndex, string $direction): void
    {
        if (!isset($this->headerMenuItems[$parentIndex]['children'])) {
            return;
        }
        $children = &$this->headerMenuItems[$parentIndex]['children'];
        $targetIndex = $direction === 'up' ? $childIndex - 1 : $childIndex + 1;
        if ($targetIndex >= 0 && $targetIndex < count($children)) {
            $temp = $children[$childIndex];
            $children[$childIndex] = $children[$targetIndex];
            $children[$targetIndex] = $temp;
        }
    }

    public function getDefaultMenuItems(): array
    {
        return [
            [
                'id'       => 'nav_home',
                'label'    => 'Home',
                'link'     => ['type' => 'internal', 'page' => 'home', 'section' => '', 'target_blank' => false],
                'children' => [],
            ],
            [
                'id'       => 'nav_about',
                'label'    => 'About Us',
                'link'     => ['type' => 'internal', 'page' => 'about', 'section' => '', 'target_blank' => false],
                'children' => [
                    ['id' => 'about_1', 'label' => 'Corporate Heritage & Profile', 'link' => ['type' => 'internal', 'page' => 'about', 'section' => 'story', 'target_blank' => false]],
                    ['id' => 'about_2', 'label' => 'Mission, Vision & Core Values', 'link' => ['type' => 'internal', 'page' => 'about', 'section' => 'story', 'target_blank' => false]],
                    ['id' => 'about_3', 'label' => 'Leadership & Engineering Board', 'link' => ['type' => 'internal', 'page' => 'about', 'section' => 'leadership', 'target_blank' => false]],
                    ['id' => 'about_4', 'label' => 'ISO 9001:2015 & DNV Standards', 'link' => ['type' => 'internal', 'page' => 'about', 'section' => 'certifications', 'target_blank' => false]],
                ],
            ],
            [
                'id'       => 'nav_services',
                'label'    => 'Services',
                'link'     => ['type' => 'internal', 'page' => 'services', 'section' => '', 'target_blank' => false],
                'children' => [
                    ['id' => 'srv_1', 'label' => 'Dynamic Rotor Balancing (100k RPM)', 'link' => ['type' => 'internal', 'page' => 'services', 'section' => 'capabilities', 'target_blank' => false]],
                    ['id' => 'srv_2', 'label' => 'Turbine Blading & TIG Welding', 'link' => ['type' => 'internal', 'page' => 'services', 'section' => 'overview', 'target_blank' => false]],
                    ['id' => 'srv_3', 'label' => 'Cartridge (CHRA) Exchange & Rebuild', 'link' => ['type' => 'internal', 'page' => 'services', 'section' => 'categories', 'target_blank' => false]],
                    ['id' => 'srv_4', 'label' => 'Ultrasonic Chemical Cleaning', 'link' => ['type' => 'internal', 'page' => 'services', 'section' => 'categories', 'target_blank' => false]],
                    ['id' => 'srv_5', 'label' => '24/7 Port Flying Squads to Vessel', 'link' => ['type' => 'internal', 'page' => 'services', 'section' => 'inquiry', 'target_blank' => false]],
                ],
            ],
            [
                'id'       => 'nav_divisions',
                'label'    => 'Business Units',
                'link'     => ['type' => 'internal', 'page' => 'home', 'section' => 'partners', 'target_blank' => false],
                'children' => [],
            ],
            [
                'id'       => 'nav_projects',
                'label'    => 'Projects & Media',
                'link'     => ['type' => 'internal', 'page' => 'projects', 'section' => '', 'target_blank' => false],
                'children' => [
                    ['id' => 'prj_1', 'label' => 'Industrial Projects', 'link' => ['type' => 'internal', 'page' => 'projects', 'section' => 'featured', 'target_blank' => false]],
                    ['id' => 'prj_2', 'label' => 'Video Gallery (Hover Play)', 'link' => ['type' => 'internal', 'page' => 'projects', 'section' => 'archive', 'target_blank' => false]],
                    ['id' => 'prj_3', 'label' => 'Photo Gallery & Workshops', 'link' => ['type' => 'internal', 'page' => 'projects', 'section' => 'archive', 'target_blank' => false]],
                ],
            ],
            [
                'id'       => 'nav_contact',
                'label'    => 'Contact',
                'link'     => ['type' => 'internal', 'page' => 'contact', 'section' => '', 'target_blank' => false],
                'children' => [],
            ],
        ];
    }

    public function getDefaultHeaderCta(): array
    {
        return [
            'enabled'   => true,
            'label'     => 'Request RFQ',
            'link'      => ['type' => 'internal', 'page' => 'contact', 'section' => 'rfq', 'target_blank' => false],
            'show_icon' => true,
        ];
    }

    public function getDefaultHeaderTopbar(): array
    {
        return [
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
        ];
    }

    public function getDefaultFooterColumns(): array
    {
        return [
            [
                'id'       => 'col_about',
                'title'    => 'About Nordroy',
                'type'     => 'company_info',
                'span'     => 2,
                'content'  => [
                    'show_logo'   => true,
                    'bio'         => 'A premier industrial conglomerate and maritime engineering group specializing in authorized multi-brand exhaust gas turbocharger overhauls, dynamic rotor balancing up to 100,000 RPM, genuine OEM spare parts supply, and technical port assistance across global maritime hubs.',
                    'show_social' => true,
                    'show_phone'  => true,
                ],
            ],
            [
                'id'       => 'col_divisions',
                'title'    => 'Business Units',
                'type'     => 'dynamic_menu',
                'span'     => 1,
                'content'  => [
                    'source'   => 'divisions',
                    'menu_id'  => null,
                ],
            ],
            [
                'id'       => 'col_services',
                'title'    => 'Technical Services',
                'type'     => 'dynamic_menu',
                'span'     => 1,
                'content'  => [
                    'source'   => 'services',
                    'menu_id'  => null,
                ],
            ],
            [
                'id'       => 'col_contact',
                'title'    => 'Port & HQ Offices',
                'type'     => 'contact_offices',
                'span'     => 1,
                'content'  => [
                    'port_title'     => 'Chattogram Port Workshop:',
                    'port_address'   => 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.',
                    'hq_title'       => 'Dhaka Corporate HQ:',
                    'hq_address'     => 'Gulshan Industrial Area, Dhaka, Bangladesh',
                    'show_emergency' => true,
                ],
            ],
        ];
    }

    public function getDefaultFooterBottomColumns(): array
    {
        return [
            [
                'id'      => 'bot_copyright',
                'type'    => 'copyright',
                'content' => [
                    'text' => '© {year} {site_name}. All rights reserved. Maritime Engineering & Industrial Overhauls.',
                ],
            ],
            [
                'id'      => 'bot_badges',
                'type'    => 'badges_menu',
                'content' => [
                    'show_iso'     => true,
                    'iso_text'     => 'ISO 9001:2015 & DNV Certified',
                    'show_login'   => true,
                    'login_text'   => 'Staff Login',
                    'menu_id'      => null,
                    'menu_layout'  => 'horizontal',
                ],
            ],
        ];
    }

    public function setFooterLayoutPreset(int $numCols): void
    {
        $current = $this->footerColumns;
        $diff = $numCols - count($current);

        if ($diff > 0) {
            for ($i = 0; $i < $diff; $i++) {
                $this->addFooterColumn();
            }
        } elseif ($diff < 0) {
            $this->footerColumns = array_slice($current, 0, $numCols);
        }
    }

    public function addFooterColumn(): void
    {
        $id = 'col_' . uniqid();
        $this->footerColumns[] = [
            'id'      => $id,
            'title'   => 'New Column ' . (count($this->footerColumns) + 1),
            'type'    => 'static_list',
            'span'    => 1,
            'content' => [
                'items' => [
                    ['text' => 'Home', 'url' => '/'],
                    ['text' => 'About Us', 'url' => '/about'],
                    ['text' => 'Contact Support', 'url' => '/contact'],
                ],
            ],
        ];
        $this->expandedFooterColIndex = count($this->footerColumns) - 1;
    }

    public function removeFooterColumn(int $index): void
    {
        if (isset($this->footerColumns[$index])) {
            array_splice($this->footerColumns, $index, 1);
            if ($this->expandedFooterColIndex === $index) {
                $this->expandedFooterColIndex = null;
            } elseif ($this->expandedFooterColIndex > $index) {
                $this->expandedFooterColIndex--;
            }
        }
    }

    public function moveFooterColumn(int $index, string $dir): void
    {
        $target = ($dir === 'left' || $dir === 'up') ? $index - 1 : $index + 1;
        if ($target >= 0 && $target < count($this->footerColumns)) {
            $tmp = $this->footerColumns[$index];
            $this->footerColumns[$index] = $this->footerColumns[$target];
            $this->footerColumns[$target] = $tmp;
            $this->expandedFooterColIndex = $target;
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
            'text' => 'New Link Item',
            'url'  => '#',
        ];
    }

    public function removeStaticListItem(int $colIndex, int $itemIndex): void
    {
        if (isset($this->footerColumns[$colIndex]['content']['items'][$itemIndex])) {
            array_splice($this->footerColumns[$colIndex]['content']['items'], $itemIndex, 1);
        }
    }

    public function setFooterBottomPreset(int $numCols): void
    {
        if ($numCols === 1) {
            $this->footerBottomColumns = [
                [
                    'id'      => 'bot_copyright',
                    'type'    => 'copyright',
                    'content' => ['text' => '© {year} {site_name}. All rights reserved.'],
                ],
            ];
        } elseif ($numCols === 2) {
            $this->footerBottomColumns = $this->getDefaultFooterBottomColumns();
        } elseif ($numCols === 3) {
            $this->footerBottomColumns = [
                [
                    'id'      => 'bot_copyright',
                    'type'    => 'copyright',
                    'content' => ['text' => '© {year} {site_name}. All rights reserved.'],
                ],
                [
                    'id'      => 'bot_menu',
                    'type'    => 'menu',
                    'content' => ['menu_layout' => 'horizontal', 'menu_id' => null],
                ],
                [
                    'id'      => 'bot_badges',
                    'type'    => 'badges',
                    'content' => ['iso_text' => 'ISO 9001:2015 & DNV Certified'],
                ],
            ];
        }
    }

    public function addFooterBottomColumn(): void
    {
        $this->footerBottomColumns[] = [
            'id'      => 'bot_' . uniqid(),
            'type'    => 'custom_text',
            'content' => [
                'text' => 'Custom text / credits here',
            ],
        ];
        $this->expandedBottomColIndex = count($this->footerBottomColumns) - 1;
    }

    public function removeFooterBottomColumn(int $index): void
    {
        if (isset($this->footerBottomColumns[$index])) {
            array_splice($this->footerBottomColumns, $index, 1);
            if ($this->expandedBottomColIndex === $index) {
                $this->expandedBottomColIndex = null;
            } elseif ($this->expandedBottomColIndex > $index) {
                $this->expandedBottomColIndex--;
            }
        }
    }

    public function toggleBottomCol(int $index): void
    {
        $this->expandedBottomColIndex = ($this->expandedBottomColIndex === $index) ? null : $index;
    }

    public function saveThemeTokens(): void
    {
        foreach ($this->theme as $key => $value) {
            Setting::set($key, $value, 'theme');
        }

        // Save Header & Topbar Navigation Builder configuration
        Setting::set('header_menu_id', (string) ($this->headerMenuId ?? ''), 'header');
        Setting::set('header_bg_color', $this->headerBgColor, 'header', 'json');
        Setting::set('header_text_color', $this->headerTextColor, 'header', 'json');
        Setting::set('header_menu_items', $this->headerMenuItems, 'header', 'json');
        Setting::set('header_cta', $this->headerCta, 'header', 'json');

        $this->headerTopbar['bg_color'] = $this->topbarBgColor;
        $this->headerTopbar['text_color'] = $this->topbarTextColor;
        Setting::set('header_topbar', $this->headerTopbar, 'header', 'json');
        Setting::set('topbar_bg_color', $this->topbarBgColor, 'header', 'json');
        Setting::set('topbar_text_color', $this->topbarTextColor, 'header', 'json');
        Setting::set('topbar_box_model', $this->topbarBoxModel, 'header', 'json');
        Setting::set('header_box_model', $this->headerBoxModel, 'header', 'json');
        Setting::set('header_border_span', $this->headerBorderSpan, 'header');
        Setting::set('header_border_width', $this->headerBorderWidth, 'header');
        Setting::set('header_border_color', $this->headerBorderColor, 'header');
        Setting::set('header_sticky', $this->headerSticky ? '1' : '0', 'header');
        Setting::set('header_theme_toggle', $this->headerThemeToggle ? '1' : '0', 'header');

        // Save Modular Footer Customizer Studio configuration
        Setting::set('footer_bg_color', $this->footerBgColor, 'footer', 'json');
        Setting::set('footer_text_color', $this->footerTextColor, 'footer', 'json');
        Setting::set('footer_box_model', $this->footerBoxModel, 'footer', 'json');
        Setting::set('footer_columns', $this->footerColumns, 'footer', 'json');
        Setting::set('footer_bottom_columns', $this->footerBottomColumns, 'footer', 'json');
        Setting::set('footer_config', $this->footerConfig, 'footer', 'json');

        // Save Global Layout & Section Spacing Engine
        Setting::set('section_box_model', $this->sectionBoxModel, 'layout', 'json');
        if (!empty($this->sectionBoxModel['width'])) {
            Setting::set('theme_container_width', $this->sectionBoxModel['width'], 'theme');
            $this->theme['theme_container_width'] = $this->sectionBoxModel['width'];
        }
        if (!empty($this->sectionBoxModel['padding']['y'])) {
            Setting::set('theme_section_padding', $this->sectionBoxModel['padding']['y'], 'theme');
            $this->theme['theme_section_padding'] = $this->sectionBoxModel['padding']['y'];
        }

        session()->flash('message', 'Full Corporate Design System, Header & Footer Customizations successfully published and synchronized.');
    }

    public function render()
    {
        return view('livewire.admin.theme.theme-studio', [
            'presets'        => $this->presets,
            'availableMenus' => Menu::withCount('items')->get(),
        ])->title('Theme Customizer Studio | ' . Setting::get('site_name', 'Nordroy CMS'));
    }
}