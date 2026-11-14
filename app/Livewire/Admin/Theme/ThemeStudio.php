<?php

namespace App\Livewire\Admin\Theme;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class ThemeStudio extends Component
{
    use WithFileUploads;

    public string $activeTab = 'colors'; // 'colors', 'typography', 'buttons', 'layout', 'header', 'background'

    // Media Modal State
    public ?string $modalTargetField = null;
    public ?int $modalTargetIndex = null;
    public $uploads = [];
    public string $uploadFolder = 'branding';
    public bool $autoCompress = true;

    // Full Design Tokens State
    public array $theme = [];

    // Header & Navigation Builder State
    public array $headerMenuItems = [];
    public array $headerCta = [];
    public array $headerTopbar = [];
    public bool $headerSticky = true;
    public bool $headerThemeToggle = true;
    public ?int $expandedMenuIndex = null;

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
        $this->headerMenuItems = Setting::getJson('header_menu_items') ?: $this->getDefaultMenuItems();
        $this->headerCta = array_merge($this->getDefaultHeaderCta(), Setting::getJson('header_cta') ?: []);
        $this->headerTopbar = array_merge($this->getDefaultHeaderTopbar(), Setting::getJson('header_topbar') ?: []);
        $this->headerSticky = (bool) Setting::get('header_sticky', '1');
        $this->headerThemeToggle = (bool) Setting::get('header_theme_toggle', '1');
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
            'enabled'    => true,
            'badge_text' => '24/7 Port Call & Emergency Squads',
            'subtext'    => 'Authorized Multi-Brand Turbocharger Engineering',
            'phone'      => '',
            'email'      => '',
            'admin_link' => true,
        ];
    }

    public function saveThemeTokens(): void
    {
        foreach ($this->theme as $key => $value) {
            Setting::set($key, $value, 'theme');
        }

        // Save Header & Navigation Builder configuration
        Setting::set('header_menu_items', $this->headerMenuItems, 'header', 'json');
        Setting::set('header_cta', $this->headerCta, 'header', 'json');
        Setting::set('header_topbar', $this->headerTopbar, 'header', 'json');
        Setting::set('header_sticky', $this->headerSticky ? '1' : '0', 'header');
        Setting::set('header_theme_toggle', $this->headerThemeToggle ? '1' : '0', 'header');

        session()->flash('message', 'Full Corporate Design System & Header Navigation successfully published and synchronized.');
    }

    public function render()
    {
        return view('livewire.admin.theme.theme-studio', [
            'presets' => $this->presets,
        ])->title('Theme Customizer Studio | ' . Setting::get('site_name', 'Nordroy CMS'));
    }
}