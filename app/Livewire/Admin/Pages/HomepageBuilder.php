<?php

namespace App\Livewire\Admin\Pages;

use App\Models\CustomIcon;
use App\Models\Menu;
use App\Models\Setting;
use App\Services\IconRegistry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Homepage Builder & Section Studio | Corporate CMS')]
class HomepageBuilder extends Component
{
    use WithFileUploads;

    // Selection State: Currently ONLY 'header' is available and locked
    #[Url(as: 'section')]
    public string $selectedSection = 'header';

    #[Url(as: 'tab')]
    public string $headerTab = 'topbar'; // 'topbar', 'navbar', 'menu', 'cta'

    // Icon Picker Modal helper states
    public $modalUploadedFile = null;
    public ?string $modalTargetField = null;
    public ?int $modalTargetIndex = null;
    public ?string $modalTargetTypeField = null;

    // ==========================================
    // TOPBAR STATE (Header Row 1)
    // ==========================================
    public bool $topbar_enabled = true;
    public string $topbar_width = 'container'; // 'container' (boxed), 'fluid' (full width), 'narrow'
    public string $topbar_bg_type = 'theme_default'; // 'theme_default', 'transparent', 'solid_custom', 'gradient', 'glass'
    public int $topbar_glass_opacity = 90;
    public string $topbar_light_bg = '#ffffff';
    public string $topbar_dark_bg = '#050f18';
    public string $topbar_light_text = '#334155';
    public string $topbar_dark_text = '#cbd5e1';

    // Topbar Gradient Controls
    public string $topbar_gradient_dir = 'to right'; // 'to right', 'to left', 'to bottom', '135deg', '45deg'
    public string $topbar_gradient_from = '#003C58';
    public string $topbar_gradient_via = '';
    public string $topbar_gradient_to = '#0e7490';

    // Topbar Column Modules & Features
    public bool $topbar_show_badge = true;
    public string $topbar_badge_text = '24/7 Port Call & Emergency Squads';
    public string $topbar_badge_icon = 'solid:phone-volume';

    public bool $topbar_show_tagline = true;
    public string $topbar_tagline = 'Authorized Multi-Brand Turbocharger Engineering';

    public bool $topbar_show_phone = true;
    public string $topbar_phone = '+880 1800-000000';
    public string $topbar_phone_icon = 'solid:phone';

    public bool $topbar_show_email = true;
    public string $topbar_email = 'operations@nordroy.com';
    public string $topbar_email_icon = 'solid:envelope';

    public bool $topbar_show_social = false;
    public bool $topbar_show_lang = true;
    public bool $topbar_show_portal = true;
    public string $topbar_portal_text = 'Admin Portal →';
    public string $topbar_portal_url = '/admin/dashboard';
    public string $topbar_portal_link_type = 'internal'; // 'internal', 'external'

    // Modular Custom Topbar Items Repeater
    public array $topbar_custom_items = [];
    public string $newCustomZone = 'left'; // 'left', 'right'
    public string $newCustomText = '';
    public string $newCustomIcon = 'solid:info';
    public string $newCustomUrl = '';
    public string $newCustomTarget = '_self'; // '_self', '_blank'
    public string $newCustomLinkType = 'internal'; // 'internal', 'external'

    // ==========================================
    // MAIN NAVBAR STATE (Header Row 2)
    // ==========================================
    public string $header_width = 'container'; // 'container', 'fluid', 'narrow'
    public bool $header_sticky = true;
    public string $header_height = '80px';
    public string $header_bg_type = 'glass'; // 'glass', 'theme_default', 'transparent', 'solid_custom', 'gradient'
    public int $header_glass_opacity = 85; // Clamped 10% to 90%
    public string $header_custom_light_bg = '#ffffff';
    public string $header_custom_dark_bg = '#07131e';
    public string $header_custom_light_text = '#0f172a';
    public string $header_custom_dark_text = '#f8fafc';

    // Navbar Gradient Controls
    public string $header_gradient_dir = 'to right';
    public string $header_gradient_from = '#002538';
    public string $header_gradient_via = '#003C58';
    public string $header_gradient_to = '#024d70';

    // Navbar Branding & Logos
    public string $header_brand_title = 'Nordroy Marine';
    public string $header_logo_light = 'assets/images/logo.png';
    public string $header_logo_dark = 'assets/images/logo-dark.png';
    public int $header_logo_height = 40;

    // Navbar Menu & Behavior
    public ?int $header_menu_id = null;
    public bool $header_shrink_on_scroll = false;
    public string $header_border_style = 'border'; // 'border', 'none', 'shadow'

    // Navbar Actions & CTA
    public bool $header_show_theme_toggle = true;
    public bool $header_cta_enabled = true;
    public string $header_cta_text = 'Request RFQ';
    public string $header_cta_url = '/contact#rfq';
    public string $header_cta_link_type = 'internal'; // 'internal', 'external'
    public string $header_cta_icon = 'solid:clipboard-document-list';
    public string $header_cta_style = 'primary_gradient'; // 'primary_gradient', 'outline', 'solid_dark'

    // ==========================================
    // HERO BANNER STATE & ADVANCED STUDIO
    // ==========================================
    #[Url(as: 'hero_tab')]
    public string $heroTab = 'layout'; // 'layout', 'content', 'actions', 'instrument'

    public bool $hero_enabled = true;
    public string $hero_width = 'container'; // 'container', 'fluid', 'fluid_full', 'ultrawide', 'desktop', 'narrow', 'content_focused'
    public string $hero_padding = 'standard'; // 'standard', 'compact', 'spacious', 'extra_spacious'
    public bool $hero_grid_enabled = true;
    public string $hero_column_split = '7_5'; // '7_5', '6_6', '8_4', '5_7'
    public string $hero_column_order = 'content_first'; // 'content_first', 'visual_first'
    public string $hero_alignment = 'left'; // 'left', 'center', 'right'
    public bool $home_scroll_animations = true;

    // Hero Background Engine
    public string $hero_bg_type = 'frosted'; // 'frosted', 'transparent', 'subtle_tint', 'solid_custom', 'gradient', 'glass'
    public int $hero_glass_opacity = 90; // Clamped 10% - 90%
    public string $hero_light_bg = '#ffffff';
    public string $hero_light_text = '#0f172a';
    public string $hero_dark_bg = '#07131e';
    public string $hero_dark_text = '#f8fafc';

    // Hero Gradient Controls
    public string $hero_gradient_dir = '135deg';
    public string $hero_gradient_from = '#002538';
    public string $hero_gradient_via = '#003C58';
    public string $hero_gradient_to = '#07131e';

    // Hero Badges
    public bool $hero_badge1_enabled = true;
    public string $hero_badge1_text = 'Authorized Multi-Brand Turbocharger Engineering';
    public string $hero_badge1_icon = 'solid:shield-check';

    public bool $hero_badge2_enabled = true;
    public string $hero_badge2_text = 'ISO 9001:2015 • DNV Certified';
    public string $hero_badge2_icon = 'solid:award';

    // Hero Typography & Multicolor Headline
    public string $hero_title = 'Precision Turbocharger Overhauls & Marine Propulsion Support.';
    public bool $hero_title_highlight_enabled = true;
    public string $hero_title_prefix = 'Precision Turbocharger Overhauls &';
    public string $hero_title_highlight = 'Marine Propulsion Support.';
    public string $hero_title_suffix = '';
    public string $hero_title_highlight_style = 'gradient_cyan'; // 'gradient_cyan', 'gradient_amber', 'brand_primary', 'gradient_emerald', 'solid_custom'
    public string $hero_title_highlight_custom = '#0ea5e9';
    public string $hero_subtitle = 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil & gas terminals.';

    // Extra Content: Capability Feature Bullets
    public bool $hero_bullets_enabled = true;
    public bool $hero_bullet1_enabled = true;
    public string $hero_bullet1_text = '24/7 Rapid Outer Anchorage Squads';
    public string $hero_bullet1_icon = 'solid:circle-check';
    public bool $hero_bullet2_enabled = true;
    public string $hero_bullet2_text = 'Dynamic Balancing to 100,000 RPM';
    public string $hero_bullet2_icon = 'solid:circle-check';
    public bool $hero_bullet3_enabled = true;
    public string $hero_bullet3_text = "Class Society Certified Reports (DNV • Lloyd's)";
    public string $hero_bullet3_icon = 'solid:circle-check';
    public bool $hero_bullet4_enabled = true;
    public string $hero_bullet4_text = 'OEM Spare Parts Logistics & Exchange Cartridges';
    public string $hero_bullet4_icon = 'solid:circle-check';

    // Extra Content: Optional Emergency Advisory Notice Bar
    public bool $hero_notice_enabled = false;
    public string $hero_notice_text = 'Emergency Port Calls & Anchorage Squads on standby 24/7';
    public string $hero_notice_icon = 'solid:bullhorn';
    public string $hero_notice_url = '/contact#emergency';

    // Hero CTAs
    public bool $hero_cta1_enabled = true;
    public string $hero_cta1_text = 'Explore Overhaul Services';
    public string $hero_cta1_url = '/services';
    public string $hero_cta1_link_type = 'internal'; // 'internal', 'external'
    public string $hero_cta1_icon = 'solid:arrow-right';
    public string $hero_cta1_style = 'primary_gradient'; // 'primary_gradient', 'solid_dark', 'outline'

    public bool $hero_cta2_enabled = true;
    public string $hero_cta2_text = 'Request Instant RFQ';
    public string $hero_cta2_url = '/contact#rfq';
    public string $hero_cta2_link_type = 'internal'; // 'internal', 'external'
    public string $hero_cta2_icon = 'solid:clipboard-document-list';
    public string $hero_cta2_style = 'surface_border'; // 'surface_border', 'outline', 'solid_dark'

    // Hero Key Technical Metrics Strip
    public bool $hero_metrics_enabled = true;
    public string $hero_metric1_value = '100,000';
    public string $hero_metric1_label = 'RPM Dynamic Balancing';
    public string $hero_metric2_value = '24/7/365';
    public string $hero_metric2_label = 'Flying Squads to Port';
    public string $hero_metric3_value = '10,000+';
    public string $hero_metric3_label = 'OEM Spares in Stock';

    // Hero Visual Showcase (Turbine Tachometer Dial)
    public bool $hero_visual_enabled = true;
    public string $hero_visual_type = 'tachometer'; // 'tachometer', 'image'
    public string $hero_visual_size = 'standard'; // 'compact', 'standard', 'large', 'extra_large'
    public string $hero_visual_bg_style = 'cockpit_card'; // 'cockpit_card', 'frosted_glass', 'transparent', 'ambient_glow', 'solid_custom'
    public string $hero_visual_custom_bg = '#07131e';
    public string $hero_visual_border = 'border'; // 'border', 'thick_ring', 'none'
    public bool $hero_tacho_animated = true;
    public string $hero_tacho_speed = 'normal'; // 'slow', 'normal', 'fast', 'boost'
    public string $hero_tacho_direction = 'normal'; // 'normal', 'reverse'

    // Tachometer Quadrant Texts with individual toggle
    public bool $hero_tacho_top_enabled = true;
    public string $hero_tacho_top = '0° / RPM';
    public bool $hero_tacho_right_enabled = true;
    public string $hero_tacho_right = '90°';
    public bool $hero_tacho_bottom_enabled = true;
    public string $hero_tacho_bottom = '180°';
    public bool $hero_tacho_left_enabled = true;
    public string $hero_tacho_left = '270°';

    // Center Readout
    public bool $hero_tacho_center_enabled = false;
    public string $hero_tacho_center_label = 'DYNAMIC ROTOR';
    public string $hero_tacho_center_val = '100K RPM';

    // Technical HUD Box under dial with individual line toggles
    public bool $hero_hud_enabled = true;
    public bool $hero_hud_l1_enabled = true;
    public string $hero_hud_l1_label = 'EQUIPMENT:';
    public string $hero_hud_l1_val = 'HEAVY EXHAUST TURBOCHARGER';
    public bool $hero_hud_l2_enabled = true;
    public string $hero_hud_l2_label = 'AUTHORIZED:';
    public string $hero_hud_l2_val = 'ABB • MAN • KBB • MHI • NAPIER';
    public bool $hero_hud_l3_enabled = true;
    public string $hero_hud_l3_label = 'WORKSHOP RADIUS:';
    public string $hero_hud_l3_val = 'CHATTOGRAM • MONGLA • GLOBAL';

    public function mount(): void
    {
        $this->loadSettings();
    }

    public function loadSettings(): void
    {
        // Topbar
        $this->topbar_enabled       = (bool) Setting::get('header_topbar_enabled', true);
        $this->topbar_width         = Setting::get('header_topbar_width', 'container');
        $this->topbar_bg_type       = Setting::get('header_topbar_bg_type', 'theme_default');
        $this->topbar_glass_opacity = max(10, min(90, (int) Setting::get('header_topbar_glass_opacity', 90)));
        $this->topbar_light_bg      = Setting::get('header_topbar_light_bg', '#ffffff');
        $this->topbar_dark_bg       = Setting::get('header_topbar_dark_bg', '#050f18');
        $this->topbar_light_text    = Setting::get('header_topbar_light_text', '#334155');
        $this->topbar_dark_text     = Setting::get('header_topbar_dark_text', '#cbd5e1');

        $this->topbar_gradient_dir  = Setting::get('header_topbar_gradient_dir', 'to right');
        $this->topbar_gradient_from = Setting::get('header_topbar_gradient_from', '#003C58');
        $this->topbar_gradient_via  = Setting::get('header_topbar_gradient_via', '');
        $this->topbar_gradient_to   = Setting::get('header_topbar_gradient_to', '#0e7490');

        $this->topbar_show_badge    = (bool) Setting::get('header_topbar_show_badge', true);
        $this->topbar_badge_text    = Setting::get('header_topbar_badge_text', '24/7 Port Call & Emergency Squads');
        $this->topbar_badge_icon    = Setting::get('header_topbar_badge_icon', 'solid:phone-volume');

        $this->topbar_show_tagline  = (bool) Setting::get('header_topbar_show_tagline', true);
        $this->topbar_tagline       = Setting::get('header_topbar_tagline', 'Authorized Multi-Brand Turbocharger Engineering');

        $this->topbar_show_phone    = (bool) Setting::get('header_topbar_show_phone', true);
        $this->topbar_phone         = Setting::get('header_topbar_phone') ?: Setting::get('contact_phone', '+880 1800-000000');
        $this->topbar_phone_icon    = Setting::get('header_topbar_phone_icon', 'solid:phone');

        $this->topbar_show_email    = (bool) Setting::get('header_topbar_show_email', true);
        $this->topbar_email         = Setting::get('header_topbar_email') ?: Setting::get('contact_email', 'operations@nordroy.com');
        $this->topbar_email_icon    = Setting::get('header_topbar_email_icon', 'solid:envelope');

        $this->topbar_show_social   = (bool) Setting::get('header_topbar_show_social', false);
        $this->topbar_show_lang     = (bool) Setting::get('header_topbar_show_lang', true);
        $this->topbar_show_portal   = (bool) Setting::get('header_topbar_show_portal', true);
        $this->topbar_portal_text   = Setting::get('header_topbar_portal_text', 'Admin Portal →');
        $this->topbar_portal_url    = Setting::get('header_topbar_portal_url', '/admin/dashboard');
        $this->topbar_portal_link_type = (str_starts_with($this->topbar_portal_url, 'http://') || str_starts_with($this->topbar_portal_url, 'https://')) ? 'external' : 'internal';

        // Custom Topbar Items
        $storedCustomItems = Setting::get('header_topbar_custom_items');
        if ($storedCustomItems) {
            $this->topbar_custom_items = is_array($storedCustomItems) ? $storedCustomItems : (json_decode($storedCustomItems, true) ?? []);
        } else {
            $this->topbar_custom_items = [];
        }

        // Main Navbar
        $this->header_width            = Setting::get('header_width', 'container');
        $this->header_sticky           = (bool) Setting::get('header_sticky', true);
        $this->header_height           = Setting::get('header_height', '80px');
        $this->header_bg_type          = Setting::get('header_bg_type') ?: (Setting::get('header_bg_style') ?: 'glass');
        $this->header_glass_opacity    = max(10, min(90, (int) Setting::get('header_glass_opacity', (int) Setting::get('header_frosted_opacity', 85))));
        $this->header_custom_light_bg  = Setting::get('header_custom_light_bg', '#ffffff');
        $this->header_custom_dark_bg   = Setting::get('header_custom_dark_bg', '#07131e');
        $this->header_custom_light_text = Setting::get('header_custom_light_text', '#0f172a');
        $this->header_custom_dark_text = Setting::get('header_custom_dark_text', '#f8fafc');

        $this->header_gradient_dir     = Setting::get('header_gradient_dir', 'to right');
        $this->header_gradient_from    = Setting::get('header_gradient_from', '#002538');
        $this->header_gradient_via     = Setting::get('header_gradient_via', '#003C58');
        $this->header_gradient_to      = Setting::get('header_gradient_to', '#024d70');

        $this->header_brand_title      = Setting::get('header_brand_title') ?: Setting::get('site_name', 'Nordroy Marine');
        $this->header_logo_light       = Setting::get('header_logo_light') ?: Setting::get('site_logo', 'assets/images/logo.png');
        $this->header_logo_dark        = Setting::get('header_logo_dark') ?: (Setting::get('site_logo_dark') ?: 'assets/images/logo-dark.png');
        $this->header_logo_height      = (int) Setting::get('header_logo_height', 40);

        $this->header_shrink_on_scroll = (bool) Setting::get('header_shrink_on_scroll', false);
        $this->header_border_style     = Setting::get('header_border_style', 'border');

        // Menu
        $this->header_menu_id          = Setting::get('header_menu_id') ? (int) Setting::get('header_menu_id') : null;
        if (!$this->header_menu_id) {
            $defaultMenu = Menu::where('location', 'primary')->first();
            if ($defaultMenu) {
                $this->header_menu_id = $defaultMenu->id;
            }
        }

        // Actions & CTA
        $this->header_show_theme_toggle = (bool) Setting::get('header_show_theme_toggle', true);
        $this->header_cta_enabled       = (bool) Setting::get('header_cta_enabled', true);
        $this->header_cta_text          = Setting::get('header_cta_text', 'Request RFQ');
        $this->header_cta_url           = Setting::get('header_cta_url', '/contact#rfq');
        $this->header_cta_link_type     = (str_starts_with($this->header_cta_url, 'http://') || str_starts_with($this->header_cta_url, 'https://')) ? 'external' : 'internal';
        $this->header_cta_icon          = Setting::get('header_cta_icon', 'solid:clipboard-document-list');
        $this->header_cta_style         = Setting::get('header_cta_style', 'primary_gradient');

        // ==========================================
        // LOAD HERO BANNER SETTINGS
        // ==========================================
        // HERO BANNER SETTINGS
        // ==========================================
        $this->hero_enabled         = (bool) Setting::get('home_hero_enabled', true);
        $this->hero_width           = Setting::get('home_hero_width', 'container');
        $this->hero_padding         = Setting::get('home_hero_padding', 'standard');
        $this->hero_grid_enabled    = (bool) Setting::get('home_hero_grid_enabled', true);
        $this->hero_column_split    = Setting::get('home_hero_column_split', '7_5');
        $this->hero_column_order    = Setting::get('home_hero_column_order', 'content_first');
        $this->hero_alignment       = Setting::get('home_hero_alignment', 'left');
        $this->home_scroll_animations = (bool) Setting::get('theme_scroll_animations', true);

        $this->hero_bg_type         = Setting::get('home_hero_bg_type', Setting::get('theme_hero_backdrop', 'frosted'));
        $this->hero_glass_opacity   = max(10, min(90, (int) Setting::get('home_hero_glass_opacity', 90)));
        $this->hero_light_bg        = Setting::get('home_hero_light_bg', '#ffffff');
        $this->hero_light_text      = Setting::get('home_hero_light_text', '#0f172a');
        $this->hero_dark_bg         = Setting::get('home_hero_dark_bg', '#07131e');
        $this->hero_dark_text       = Setting::get('home_hero_dark_text', '#f8fafc');

        $this->hero_gradient_dir    = Setting::get('home_hero_gradient_dir', '135deg');
        $this->hero_gradient_from   = Setting::get('home_hero_gradient_from', '#002538');
        $this->hero_gradient_via    = Setting::get('home_hero_gradient_via', '#003C58');
        $this->hero_gradient_to     = Setting::get('home_hero_gradient_to', '#07131e');

        $this->hero_badge1_enabled  = (bool) Setting::get('home_hero_badge1_enabled', true);
        $this->hero_badge1_text     = Setting::get('home_hero_badge1', 'Authorized Multi-Brand Turbocharger Engineering');
        $this->hero_badge1_icon     = Setting::get('home_hero_badge1_icon', 'solid:shield-check');

        $this->hero_badge2_enabled  = (bool) Setting::get('home_hero_badge2_enabled', true);
        $this->hero_badge2_text     = Setting::get('home_hero_badge2', 'ISO 9001:2015 • DNV Certified');
        $this->hero_badge2_icon     = Setting::get('home_hero_badge2_icon', 'solid:award');

        $this->hero_title           = Setting::get('home_hero_title', 'Precision Turbocharger Overhauls & Marine Propulsion Support.');
        $this->hero_title_highlight_enabled = (bool) Setting::get('home_hero_title_highlight_enabled', true);
        $this->hero_title_prefix    = Setting::get('home_hero_title_prefix', 'Precision Turbocharger Overhauls &');
        $this->hero_title_highlight = Setting::get('home_hero_title_highlight', 'Marine Propulsion Support.');
        $this->hero_title_suffix    = Setting::get('home_hero_title_suffix', '');
        $this->hero_title_highlight_style = Setting::get('home_hero_title_highlight_style', 'gradient_cyan');
        $this->hero_title_highlight_custom = Setting::get('home_hero_title_highlight_custom', '#0ea5e9');

        $this->hero_subtitle        = Setting::get('home_hero_subtitle', 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil & gas terminals.');

        // Extra Content: Feature Bullets
        $this->hero_bullets_enabled = (bool) Setting::get('home_hero_bullets_enabled', true);
        $this->hero_bullet1_enabled = (bool) Setting::get('home_hero_bullet1_enabled', true);
        $this->hero_bullet1_text    = Setting::get('home_hero_bullet1_text', '24/7 Rapid Outer Anchorage Squads');
        $this->hero_bullet1_icon    = Setting::get('home_hero_bullet1_icon', 'solid:circle-check');
        $this->hero_bullet2_enabled = (bool) Setting::get('home_hero_bullet2_enabled', true);
        $this->hero_bullet2_text    = Setting::get('home_hero_bullet2_text', 'Dynamic Balancing to 100,000 RPM');
        $this->hero_bullet2_icon    = Setting::get('home_hero_bullet2_icon', 'solid:circle-check');
        $this->hero_bullet3_enabled = (bool) Setting::get('home_hero_bullet3_enabled', true);
        $this->hero_bullet3_text    = Setting::get('home_hero_bullet3_text', "Class Society Certified Reports (DNV • Lloyd's)");
        $this->hero_bullet3_icon    = Setting::get('home_hero_bullet3_icon', 'solid:circle-check');
        $this->hero_bullet4_enabled = (bool) Setting::get('home_hero_bullet4_enabled', true);
        $this->hero_bullet4_text    = Setting::get('home_hero_bullet4_text', 'OEM Spare Parts Logistics & Exchange Cartridges');
        $this->hero_bullet4_icon    = Setting::get('home_hero_bullet4_icon', 'solid:circle-check');

        // Extra Content: Notice Bar
        $this->hero_notice_enabled  = (bool) Setting::get('home_hero_notice_enabled', false);
        $this->hero_notice_text     = Setting::get('home_hero_notice_text', 'Emergency Port Calls & Anchorage Squads on standby 24/7');
        $this->hero_notice_icon     = Setting::get('home_hero_notice_icon', 'solid:bullhorn');
        $this->hero_notice_url      = Setting::get('home_hero_notice_url', '/contact#emergency');

        // CTAs
        $this->hero_cta1_enabled    = (bool) Setting::get('home_hero_cta1_enabled', true);
        $this->hero_cta1_text       = Setting::get('home_hero_cta1_text', 'Explore Overhaul Services');
        $this->hero_cta1_url        = Setting::get('home_hero_cta1_url', '/services');
        $this->hero_cta1_link_type  = (str_starts_with($this->hero_cta1_url, 'http://') || str_starts_with($this->hero_cta1_url, 'https://')) ? 'external' : 'internal';
        $this->hero_cta1_icon       = Setting::get('home_hero_cta1_icon', 'solid:arrow-right');
        $this->hero_cta1_style      = Setting::get('home_hero_cta1_style', 'primary_gradient');

        $this->hero_cta2_enabled    = (bool) Setting::get('home_hero_cta2_enabled', true);
        $this->hero_cta2_text       = Setting::get('home_hero_cta2_text', 'Request Instant RFQ');
        $this->hero_cta2_url        = Setting::get('home_hero_cta2_url', '/contact#rfq');
        $this->hero_cta2_link_type  = (str_starts_with($this->hero_cta2_url, 'http://') || str_starts_with($this->hero_cta2_url, 'https://')) ? 'external' : 'internal';
        $this->hero_cta2_icon       = Setting::get('home_hero_cta2_icon', 'solid:clipboard-document-list');
        $this->hero_cta2_style      = Setting::get('home_hero_cta2_style', 'surface_border');

        // Metrics
        $this->hero_metrics_enabled = (bool) Setting::get('home_hero_metrics_enabled', true);
        $this->hero_metric1_value   = Setting::get('home_metric1_value', '100,000');
        $this->hero_metric1_label   = Setting::get('home_metric1_label', 'RPM Dynamic Balancing');
        $this->hero_metric2_value   = Setting::get('home_metric2_value', '24/7/365');
        $this->hero_metric2_label   = Setting::get('home_metric2_label', 'Flying Squads to Port');
        $this->hero_metric3_value   = Setting::get('home_metric3_value', '10,000+');
        $this->hero_metric3_label   = Setting::get('home_metric3_label', 'OEM Spares in Stock');

        // Visual Showcase
        $this->hero_visual_enabled  = (bool) Setting::get('home_hero_visual_enabled', true);
        $this->hero_visual_type     = Setting::get('home_hero_visual_type', 'tachometer');
        $this->hero_visual_size     = Setting::get('home_hero_visual_size', 'standard');
        $this->hero_visual_bg_style = Setting::get('home_hero_visual_bg_style', 'cockpit_card');
        $this->hero_visual_custom_bg = Setting::get('home_hero_visual_custom_bg', '#07131e');
        $this->hero_visual_border   = Setting::get('home_hero_visual_border', 'border');

        $this->hero_tacho_animated  = (bool) Setting::get('home_hero_tacho_animated', true);
        $this->hero_tacho_speed     = Setting::get('home_hero_tacho_speed', 'normal');
        $this->hero_tacho_direction = Setting::get('home_hero_tacho_direction', 'normal');

        $this->hero_tacho_top_enabled   = (bool) Setting::get('home_hero_tacho_top_enabled', true);
        $this->hero_tacho_top           = Setting::get('home_hero_tacho_top', '0° / RPM');
        $this->hero_tacho_right_enabled = (bool) Setting::get('home_hero_tacho_right_enabled', true);
        $this->hero_tacho_right         = Setting::get('home_hero_tacho_right', '90°');
        $this->hero_tacho_bottom_enabled = (bool) Setting::get('home_hero_tacho_bottom_enabled', true);
        $this->hero_tacho_bottom        = Setting::get('home_hero_tacho_bottom', '180°');
        $this->hero_tacho_left_enabled  = (bool) Setting::get('home_hero_tacho_left_enabled', true);
        $this->hero_tacho_left          = Setting::get('home_hero_tacho_left', '270°');

        $this->hero_tacho_center_enabled = (bool) Setting::get('home_hero_tacho_center_enabled', false);
        $this->hero_tacho_center_label   = Setting::get('home_hero_tacho_center_label', 'DYNAMIC ROTOR');
        $this->hero_tacho_center_val     = Setting::get('home_hero_tacho_center_val', '100K RPM');

        $this->hero_hud_enabled     = (bool) Setting::get('home_hero_hud_enabled', true);
        $this->hero_hud_l1_enabled  = (bool) Setting::get('home_hero_hud_l1_enabled', true);
        $this->hero_hud_l1_label    = Setting::get('home_hero_hud_l1_label', 'EQUIPMENT:');
        $this->hero_hud_l1_val      = Setting::get('home_hero_hud_l1_val', 'HEAVY EXHAUST TURBOCHARGER');
        $this->hero_hud_l2_enabled  = (bool) Setting::get('home_hero_hud_l2_enabled', true);
        $this->hero_hud_l2_label    = Setting::get('home_hero_hud_l2_label', 'AUTHORIZED:');
        $this->hero_hud_l2_val      = Setting::get('home_hero_hud_l2_val', 'ABB • MAN • KBB • MHI • NAPIER');
        $this->hero_hud_l3_enabled  = (bool) Setting::get('home_hero_hud_l3_enabled', true);
        $this->hero_hud_l3_label    = Setting::get('home_hero_hud_l3_label', 'WORKSHOP RADIUS:');
        $this->hero_hud_l3_val      = Setting::get('home_hero_hud_l3_val', 'CHATTOGRAM • MONGLA • GLOBAL');
    }

    public function selectSection(string $section): void
    {
        if (in_array($section, ['header', 'hero'])) {
            $this->selectedSection = $section;
        }
    }

    public function setHeroTab(string $tab): void
    {
        $this->heroTab = $tab;
    }

    public function setHeaderTab(string $tab): void
    {
        $this->headerTab = $tab;
    }

    public function addCustomTopbarItem(): void
    {
        $text = trim($this->newCustomText);
        if (empty($text)) return;

        $this->topbar_custom_items[] = [
            'id'        => 'topbar_item_' . uniqid(),
            'zone'      => $this->newCustomZone,
            'text'      => $text,
            'icon'      => $this->newCustomIcon ?: 'solid:info',
            'url'       => trim($this->newCustomUrl),
            'target'    => $this->newCustomTarget ?: '_self',
            'is_active' => true,
        ];

        $this->newCustomText = '';
        $this->newCustomUrl = '';
    }

    public function removeCustomTopbarItem(int $index): void
    {
        if (isset($this->topbar_custom_items[$index])) {
            unset($this->topbar_custom_items[$index]);
            $this->topbar_custom_items = array_values($this->topbar_custom_items);
        }
    }

    public function toggleCustomTopbarItem(int $index): void
    {
        if (isset($this->topbar_custom_items[$index])) {
            $this->topbar_custom_items[$index]['is_active'] = !($this->topbar_custom_items[$index]['is_active'] ?? true);
        }
    }

    public function saveHeader(): void
    {
        // Enforce clamped opacity: NEVER 0% or 100%
        $this->topbar_glass_opacity = max(10, min(90, (int) $this->topbar_glass_opacity));
        $this->header_glass_opacity = max(10, min(90, (int) $this->header_glass_opacity));

        // Save Topbar Settings
        Setting::set('header_topbar_enabled', $this->topbar_enabled ? '1' : '0');
        Setting::set('header_topbar_width', $this->topbar_width);
        Setting::set('header_topbar_bg_type', $this->topbar_bg_type);
        Setting::set('header_topbar_glass_opacity', (string) $this->topbar_glass_opacity);
        Setting::set('header_topbar_light_bg', trim($this->topbar_light_bg));
        Setting::set('header_topbar_dark_bg', trim($this->topbar_dark_bg));
        Setting::set('header_topbar_light_text', trim($this->topbar_light_text));
        Setting::set('header_topbar_dark_text', trim($this->topbar_dark_text));

        Setting::set('header_topbar_gradient_dir', $this->topbar_gradient_dir);
        Setting::set('header_topbar_gradient_from', trim($this->topbar_gradient_from));
        Setting::set('header_topbar_gradient_via', trim($this->topbar_gradient_via));
        Setting::set('header_topbar_gradient_to', trim($this->topbar_gradient_to));

        Setting::set('header_topbar_show_badge', $this->topbar_show_badge ? '1' : '0');
        Setting::set('header_topbar_badge_text', trim($this->topbar_badge_text));
        Setting::set('header_topbar_badge_icon', trim($this->topbar_badge_icon));

        Setting::set('header_topbar_show_tagline', $this->topbar_show_tagline ? '1' : '0');
        Setting::set('header_topbar_tagline', trim($this->topbar_tagline));

        Setting::set('header_topbar_show_phone', $this->topbar_show_phone ? '1' : '0');
        Setting::set('header_topbar_phone', trim($this->topbar_phone));
        Setting::set('header_topbar_phone_icon', trim($this->topbar_phone_icon));

        Setting::set('header_topbar_show_email', $this->topbar_show_email ? '1' : '0');
        Setting::set('header_topbar_email', trim($this->topbar_email));
        Setting::set('header_topbar_email_icon', trim($this->topbar_email_icon));

        Setting::set('header_topbar_show_social', $this->topbar_show_social ? '1' : '0');
        Setting::set('header_topbar_show_lang', $this->topbar_show_lang ? '1' : '0');
        Setting::set('header_topbar_show_portal', $this->topbar_show_portal ? '1' : '0');
        Setting::set('header_topbar_portal_text', trim($this->topbar_portal_text));
        Setting::set('header_topbar_portal_url', trim($this->topbar_portal_url));

        Setting::set('header_topbar_custom_items', json_encode($this->topbar_custom_items, JSON_UNESCAPED_UNICODE), 'homepage', 'json');

        // Save Navbar Settings
        Setting::set('header_width', $this->header_width);
        Setting::set('header_sticky', $this->header_sticky ? '1' : '0');
        Setting::set('header_height', trim($this->header_height));
        Setting::set('header_bg_type', $this->header_bg_type);
        Setting::set('header_bg_style', $this->header_bg_type); // Backward compatibility
        Setting::set('header_glass_opacity', (string) $this->header_glass_opacity);
        Setting::set('header_frosted_opacity', (string) $this->header_glass_opacity); // Backward compatibility

        Setting::set('header_custom_light_bg', trim($this->header_custom_light_bg));
        Setting::set('header_custom_dark_bg', trim($this->header_custom_dark_bg));
        Setting::set('header_custom_light_text', trim($this->header_custom_light_text));
        Setting::set('header_custom_dark_text', trim($this->header_custom_dark_text));

        Setting::set('header_gradient_dir', $this->header_gradient_dir);
        Setting::set('header_gradient_from', trim($this->header_gradient_from));
        Setting::set('header_gradient_via', trim($this->header_gradient_via));
        Setting::set('header_gradient_to', trim($this->header_gradient_to));

        Setting::set('header_brand_title', trim($this->header_brand_title));
        Setting::set('header_logo_light', trim($this->header_logo_light));
        Setting::set('header_logo_dark', trim($this->header_logo_dark));
        Setting::set('header_logo_height', (string) $this->header_logo_height);

        Setting::set('header_shrink_on_scroll', $this->header_shrink_on_scroll ? '1' : '0');
        Setting::set('header_border_style', $this->header_border_style);

        // Save Menu Settings
        if ($this->header_menu_id) {
            Setting::set('header_menu_id', (string) $this->header_menu_id);
        }

        // Save Actions & CTA Settings
        Setting::set('header_show_theme_toggle', $this->header_show_theme_toggle ? '1' : '0');
        Setting::set('header_cta_enabled', $this->header_cta_enabled ? '1' : '0');
        Setting::set('header_cta_text', trim($this->header_cta_text));
        Setting::set('header_cta_url', trim($this->header_cta_url));
        Setting::set('header_cta_icon', trim($this->header_cta_icon));
        Setting::set('header_cta_style', $this->header_cta_style);

        session()->flash('message', 'Homepage Header configuration saved successfully.');
        $this->dispatch('flash-message', [
            'type'    => 'success',
            'message' => 'Header (Topbar & Navbar) saved successfully.',
        ]);
    }

    public function saveHero(): void
    {
        // Enforce clamped opacity: NEVER 0% or 100%
        $this->hero_glass_opacity = max(10, min(90, (int) $this->hero_glass_opacity));

        Setting::set('home_hero_enabled', $this->hero_enabled ? '1' : '0');
        Setting::set('home_hero_width', $this->hero_width);
        Setting::set('home_hero_padding', $this->hero_padding);
        Setting::set('home_hero_grid_enabled', $this->hero_grid_enabled ? '1' : '0');
        Setting::set('home_hero_column_split', $this->hero_column_split);
        Setting::set('home_hero_column_order', $this->hero_column_order);
        Setting::set('home_hero_alignment', $this->hero_alignment);
        Setting::set('theme_scroll_animations', $this->home_scroll_animations ? '1' : '0');

        Setting::set('home_hero_bg_type', $this->hero_bg_type);
        Setting::set('theme_hero_backdrop', $this->hero_bg_type); // Backward compatibility
        Setting::set('home_hero_glass_opacity', (string) $this->hero_glass_opacity);
        Setting::set('home_hero_light_bg', trim($this->hero_light_bg));
        Setting::set('home_hero_light_text', trim($this->hero_light_text));
        Setting::set('home_hero_dark_bg', trim($this->hero_dark_bg));
        Setting::set('home_hero_dark_text', trim($this->hero_dark_text));

        Setting::set('home_hero_gradient_dir', $this->hero_gradient_dir);
        Setting::set('home_hero_gradient_from', trim($this->hero_gradient_from));
        Setting::set('home_hero_gradient_via', trim($this->hero_gradient_via));
        Setting::set('home_hero_gradient_to', trim($this->hero_gradient_to));

        Setting::set('home_hero_badge1_enabled', $this->hero_badge1_enabled ? '1' : '0');
        Setting::set('home_hero_badge1', trim($this->hero_badge1_text));
        Setting::set('home_hero_badge1_icon', trim($this->hero_badge1_icon));

        Setting::set('home_hero_badge2_enabled', $this->hero_badge2_enabled ? '1' : '0');
        Setting::set('home_hero_badge2', trim($this->hero_badge2_text));
        Setting::set('home_hero_badge2_icon', trim($this->hero_badge2_icon));

        Setting::set('home_hero_title', trim($this->hero_title));
        Setting::set('home_hero_title_highlight_enabled', $this->hero_title_highlight_enabled ? '1' : '0');
        Setting::set('home_hero_title_prefix', trim($this->hero_title_prefix));
        Setting::set('home_hero_title_highlight', trim($this->hero_title_highlight));
        Setting::set('home_hero_title_suffix', trim($this->hero_title_suffix));
        Setting::set('home_hero_title_highlight_style', $this->hero_title_highlight_style);
        Setting::set('home_hero_title_highlight_custom', trim($this->hero_title_highlight_custom));
        Setting::set('home_hero_subtitle', trim($this->hero_subtitle));

        // Extra Content: Bullets & Notice
        Setting::set('home_hero_bullets_enabled', $this->hero_bullets_enabled ? '1' : '0');
        Setting::set('home_hero_bullet1_enabled', $this->hero_bullet1_enabled ? '1' : '0');
        Setting::set('home_hero_bullet1_text', trim($this->hero_bullet1_text));
        Setting::set('home_hero_bullet1_icon', trim($this->hero_bullet1_icon));
        Setting::set('home_hero_bullet2_enabled', $this->hero_bullet2_enabled ? '1' : '0');
        Setting::set('home_hero_bullet2_text', trim($this->hero_bullet2_text));
        Setting::set('home_hero_bullet2_icon', trim($this->hero_bullet2_icon));
        Setting::set('home_hero_bullet3_enabled', $this->hero_bullet3_enabled ? '1' : '0');
        Setting::set('home_hero_bullet3_text', trim($this->hero_bullet3_text));
        Setting::set('home_hero_bullet3_icon', trim($this->hero_bullet3_icon));
        Setting::set('home_hero_bullet4_enabled', $this->hero_bullet4_enabled ? '1' : '0');
        Setting::set('home_hero_bullet4_text', trim($this->hero_bullet4_text));
        Setting::set('home_hero_bullet4_icon', trim($this->hero_bullet4_icon));

        Setting::set('home_hero_notice_enabled', $this->hero_notice_enabled ? '1' : '0');
        Setting::set('home_hero_notice_text', trim($this->hero_notice_text));
        Setting::set('home_hero_notice_icon', trim($this->hero_notice_icon));
        Setting::set('home_hero_notice_url', trim($this->hero_notice_url));

        Setting::set('home_hero_cta1_enabled', $this->hero_cta1_enabled ? '1' : '0');
        Setting::set('home_hero_cta1_text', trim($this->hero_cta1_text));
        Setting::set('home_hero_cta1_url', trim($this->hero_cta1_url));
        Setting::set('home_hero_cta1_icon', trim($this->hero_cta1_icon));
        Setting::set('home_hero_cta1_style', $this->hero_cta1_style);

        Setting::set('home_hero_cta2_enabled', $this->hero_cta2_enabled ? '1' : '0');
        Setting::set('home_hero_cta2_text', trim($this->hero_cta2_text));
        Setting::set('home_hero_cta2_url', trim($this->hero_cta2_url));
        Setting::set('home_hero_cta2_icon', trim($this->hero_cta2_icon));
        Setting::set('home_hero_cta2_style', $this->hero_cta2_style);

        Setting::set('home_hero_metrics_enabled', $this->hero_metrics_enabled ? '1' : '0');
        Setting::set('home_metric1_value', trim($this->hero_metric1_value));
        Setting::set('home_metric1_label', trim($this->hero_metric1_label));
        Setting::set('home_metric2_value', trim($this->hero_metric2_value));
        Setting::set('home_metric2_label', trim($this->hero_metric2_label));
        Setting::set('home_metric3_value', trim($this->hero_metric3_value));
        Setting::set('home_metric3_label', trim($this->hero_metric3_label));

        Setting::set('home_hero_visual_enabled', $this->hero_visual_enabled ? '1' : '0');
        Setting::set('home_hero_visual_type', $this->hero_visual_type);
        Setting::set('home_hero_visual_size', $this->hero_visual_size);
        Setting::set('home_hero_visual_bg_style', $this->hero_visual_bg_style);
        Setting::set('home_hero_visual_custom_bg', trim($this->hero_visual_custom_bg));
        Setting::set('home_hero_visual_border', $this->hero_visual_border);

        Setting::set('home_hero_tacho_animated', $this->hero_tacho_animated ? '1' : '0');
        Setting::set('home_hero_tacho_speed', $this->hero_tacho_speed);
        Setting::set('home_hero_tacho_direction', $this->hero_tacho_direction);

        Setting::set('home_hero_tacho_top_enabled', $this->hero_tacho_top_enabled ? '1' : '0');
        Setting::set('home_hero_tacho_top', trim($this->hero_tacho_top));
        Setting::set('home_hero_tacho_right_enabled', $this->hero_tacho_right_enabled ? '1' : '0');
        Setting::set('home_hero_tacho_right', trim($this->hero_tacho_right));
        Setting::set('home_hero_tacho_bottom_enabled', $this->hero_tacho_bottom_enabled ? '1' : '0');
        Setting::set('home_hero_tacho_bottom', trim($this->hero_tacho_bottom));
        Setting::set('home_hero_tacho_left_enabled', $this->hero_tacho_left_enabled ? '1' : '0');
        Setting::set('home_hero_tacho_left', trim($this->hero_tacho_left));

        Setting::set('home_hero_tacho_center_enabled', $this->hero_tacho_center_enabled ? '1' : '0');
        Setting::set('home_hero_tacho_center_label', trim($this->hero_tacho_center_label));
        Setting::set('home_hero_tacho_center_val', trim($this->hero_tacho_center_val));

        Setting::set('home_hero_hud_enabled', $this->hero_hud_enabled ? '1' : '0');
        Setting::set('home_hero_hud_l1_enabled', $this->hero_hud_l1_enabled ? '1' : '0');
        Setting::set('home_hero_hud_l1_label', trim($this->hero_hud_l1_label));
        Setting::set('home_hero_hud_l1_val', trim($this->hero_hud_l1_val));
        Setting::set('home_hero_hud_l2_enabled', $this->hero_hud_l2_enabled ? '1' : '0');
        Setting::set('home_hero_hud_l2_label', trim($this->hero_hud_l2_label));
        Setting::set('home_hero_hud_l2_val', trim($this->hero_hud_l2_val));
        Setting::set('home_hero_hud_l3_enabled', $this->hero_hud_l3_enabled ? '1' : '0');
        Setting::set('home_hero_hud_l3_label', trim($this->hero_hud_l3_label));
        Setting::set('home_hero_hud_l3_val', trim($this->hero_hud_l3_val));

        session()->flash('message', 'Homepage Hero Banner configuration saved successfully.');
        $this->dispatch('flash-message', [
            'type'    => 'success',
            'message' => 'Hero Banner saved successfully.',
        ]);
    }

    public function saveCurrentSection(): void
    {
        if ($this->selectedSection === 'hero') {
            $this->saveHero();
        } else {
            $this->saveHeader();
        }
    }

    /**
     * Restore 100% Real Production Design (Zero Demo Data!)
     */
    public function restoreProductionDesign(): void
    {
        // Real Production Topbar
        $this->topbar_enabled       = true;
        $this->topbar_width         = 'container';
        $this->topbar_bg_type       = 'theme_default';
        $this->topbar_glass_opacity = 90;
        $this->topbar_light_bg      = '#ffffff';
        $this->topbar_dark_bg       = '#050f18';
        $this->topbar_light_text    = '#334155';
        $this->topbar_dark_text     = '#cbd5e1';

        $this->topbar_show_badge    = true;
        $this->topbar_badge_text    = '24/7 Port Call & Emergency Squads';
        $this->topbar_badge_icon    = 'solid:phone-volume';

        $this->topbar_show_tagline  = true;
        $this->topbar_tagline       = 'Authorized Multi-Brand Turbocharger Engineering';

        $this->topbar_show_phone    = true;
        $this->topbar_phone         = '+880 1800-000000';
        $this->topbar_phone_icon    = 'solid:phone';

        $this->topbar_show_email    = true;
        $this->topbar_email         = 'operations@nordroy.com';
        $this->topbar_email_icon    = 'solid:envelope';

        $this->topbar_show_social   = false;
        $this->topbar_show_lang     = true;
        $this->topbar_show_portal   = true;
        $this->topbar_portal_text   = 'Admin Portal →';
        $this->topbar_portal_url    = '/admin/dashboard';
        $this->topbar_custom_items  = [];

        // Real Production Navbar
        $this->header_width            = 'container';
        $this->header_sticky           = true;
        $this->header_height           = '80px';
        $this->header_bg_type          = 'glass';
        $this->header_glass_opacity    = 85;
        $this->header_custom_light_bg  = '#ffffff';
        $this->header_custom_dark_bg   = '#07131e';
        $this->header_custom_light_text = '#0f172a';
        $this->header_custom_dark_text = '#f8fafc';

        $this->header_brand_title      = 'Nordroy Marine';
        $this->header_logo_light       = 'assets/images/logo.png';
        $this->header_logo_dark        = 'assets/images/logo-dark.png';
        $this->header_logo_height      = 40;
        $this->header_shrink_on_scroll = false;
        $this->header_border_style     = 'border';

        $primaryMenu = Menu::where('location', 'primary')->first();
        if ($primaryMenu) {
            $this->header_menu_id = $primaryMenu->id;
        }

        $this->header_show_theme_toggle = true;
        $this->header_cta_enabled       = true;
        $this->header_cta_text          = 'Request RFQ';
        $this->header_cta_url           = '/contact#rfq';
        $this->header_cta_icon          = 'solid:clipboard-document-list';
        $this->header_cta_style         = 'primary_gradient';

        // Real Production Hero Banner
        $this->hero_enabled         = true;
        $this->hero_width           = 'container';
        $this->hero_padding         = 'standard';
        $this->hero_grid_enabled    = true;
        $this->hero_column_split    = '7_5';
        $this->hero_column_order    = 'content_first';
        $this->hero_alignment       = 'left';
        $this->home_scroll_animations = true;

        $this->hero_bg_type         = 'frosted';
        $this->hero_glass_opacity   = 90;
        $this->hero_light_bg        = '#ffffff';
        $this->hero_light_text      = '#0f172a';
        $this->hero_dark_bg         = '#07131e';
        $this->hero_dark_text       = '#f8fafc';

        $this->hero_gradient_dir    = '135deg';
        $this->hero_gradient_from   = '#002538';
        $this->hero_gradient_via    = '#003C58';
        $this->hero_gradient_to     = '#07131e';

        $this->hero_badge1_enabled  = true;
        $this->hero_badge1_text     = 'Authorized Multi-Brand Turbocharger Engineering';
        $this->hero_badge1_icon     = 'solid:shield-check';

        $this->hero_badge2_enabled  = true;
        $this->hero_badge2_text     = 'ISO 9001:2015 • DNV Certified';
        $this->hero_badge2_icon     = 'solid:award';

        $this->hero_title           = 'Precision Turbocharger Overhauls & Marine Propulsion Support.';
        $this->hero_title_highlight_enabled = true;
        $this->hero_title_prefix    = 'Precision Turbocharger Overhauls &';
        $this->hero_title_highlight = 'Marine Propulsion Support.';
        $this->hero_title_suffix    = '';
        $this->hero_title_highlight_style = 'gradient_cyan';
        $this->hero_title_highlight_custom = '#0ea5e9';
        $this->hero_subtitle        = 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil & gas terminals.';

        // Feature Bullets
        $this->hero_bullets_enabled = true;
        $this->hero_bullet1_enabled = true;
        $this->hero_bullet1_text    = '24/7 Rapid Outer Anchorage Squads';
        $this->hero_bullet1_icon    = 'solid:circle-check';
        $this->hero_bullet2_enabled = true;
        $this->hero_bullet2_text    = 'Dynamic Balancing to 100,000 RPM';
        $this->hero_bullet2_icon    = 'solid:circle-check';
        $this->hero_bullet3_enabled = true;
        $this->hero_bullet3_text    = "Class Society Certified Reports (DNV • Lloyd's)";
        $this->hero_bullet3_icon    = 'solid:circle-check';
        $this->hero_bullet4_enabled = true;
        $this->hero_bullet4_text    = 'OEM Spare Parts Logistics & Exchange Cartridges';
        $this->hero_bullet4_icon    = 'solid:circle-check';

        $this->hero_notice_enabled  = false;
        $this->hero_notice_text     = 'Emergency Port Calls & Anchorage Squads on standby 24/7';
        $this->hero_notice_icon     = 'solid:bullhorn';
        $this->hero_notice_url      = '/contact#emergency';

        $this->hero_cta1_enabled    = true;
        $this->hero_cta1_text       = 'Explore Overhaul Services';
        $this->hero_cta1_url        = '/services';
        $this->hero_cta1_icon       = 'solid:arrow-right';
        $this->hero_cta1_style      = 'primary_gradient';

        $this->hero_cta2_enabled    = true;
        $this->hero_cta2_text       = 'Request Instant RFQ';
        $this->hero_cta2_url        = '/contact#rfq';
        $this->hero_cta2_icon       = 'solid:clipboard-document-list';
        $this->hero_cta2_style      = 'surface_border';

        $this->hero_metrics_enabled = true;
        $this->hero_metric1_value   = '100,000';
        $this->hero_metric1_label   = 'RPM Dynamic Balancing';
        $this->hero_metric2_value   = '24/7/365';
        $this->hero_metric2_label   = 'Flying Squads to Port';
        $this->hero_metric3_value   = '10,000+';
        $this->hero_metric3_label   = 'OEM Spares in Stock';

        $this->hero_visual_enabled  = true;
        $this->hero_visual_type     = 'tachometer';
        $this->hero_visual_size     = 'standard';
        $this->hero_visual_bg_style = 'cockpit_card';
        $this->hero_visual_custom_bg = '#07131e';
        $this->hero_visual_border   = 'border';

        $this->hero_tacho_animated  = true;
        $this->hero_tacho_speed     = 'normal';
        $this->hero_tacho_direction = 'normal';

        $this->hero_tacho_top_enabled   = true;
        $this->hero_tacho_top           = '0° / RPM';
        $this->hero_tacho_right_enabled = true;
        $this->hero_tacho_right         = '90°';
        $this->hero_tacho_bottom_enabled = true;
        $this->hero_tacho_bottom        = '180°';
        $this->hero_tacho_left_enabled  = true;
        $this->hero_tacho_left          = '270°';

        $this->hero_tacho_center_enabled = false;
        $this->hero_tacho_center_label   = 'DYNAMIC ROTOR';
        $this->hero_tacho_center_val     = '100K RPM';

        $this->hero_hud_enabled     = true;
        $this->hero_hud_l1_enabled  = true;
        $this->hero_hud_l1_label    = 'EQUIPMENT:';
        $this->hero_hud_l1_val      = 'HEAVY EXHAUST TURBOCHARGER';
        $this->hero_hud_l2_enabled  = true;
        $this->hero_hud_l2_label    = 'AUTHORIZED:';
        $this->hero_hud_l2_val      = 'ABB • MAN • KBB • MHI • NAPIER';
        $this->hero_hud_l3_enabled  = true;
        $this->hero_hud_l3_label    = 'WORKSHOP RADIUS:';
        $this->hero_hud_l3_val      = 'CHATTOGRAM • MONGLA • GLOBAL';

        $this->saveHeader();
        $this->saveHero();

        session()->flash('message', 'Real production design restored perfectly.');
        $this->dispatch('flash-message', [
            'type'    => 'success',
            'message' => 'Real production design restored perfectly.',
        ]);
    }

    /**
     * Alias for resetting to production defaults
     */
    public function resetDefaults(): void
    {
        $this->restoreProductionDesign();
    }

    // ==========================================
    // ICON PICKER INTEGRATION
    // ==========================================
    public function selectIconAsset(string $field, ?int $index = null, string $icon = '', ?string $typeField = null): void
    {
        if (str_starts_with($field, 'topbar_custom_items.') && $index !== null && isset($this->topbar_custom_items[$index])) {
            $this->topbar_custom_items[$index]['icon'] = $icon;
            return;
        }

        if (property_exists($this, $field)) {
            $this->{$field} = $icon;
        }
    }

    public function uploadCustomIcon(?string $targetField = null, ?int $targetIndex = null, ?string $targetTypeField = null, string $title = ''): void
    {
        $this->validate([
            'modalUploadedFile' => 'required|image|mimes:svg,png,webp,jpg,jpeg|max:2048',
        ]);

        $path = $this->modalUploadedFile->store('custom-icons', 'public');
        $name = !empty($title) ? $title : pathinfo($this->modalUploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $type = strtolower($this->modalUploadedFile->getClientOriginalExtension()) === 'svg' ? 'svg' : 'raster';

        $customIcon = CustomIcon::create([
            'title'     => $name,
            'file_path' => $path,
            'type'      => $type,
            'is_active' => true,
        ]);

        $iconPath = "storage/{$path}";
        $this->selectIconAsset($targetField ?? '', $targetIndex, $iconPath, $targetTypeField);

        $this->modalUploadedFile = null;
        $this->dispatch('custom-icon-saved', [
            'id'    => $customIcon->id,
            'name'  => $customIcon->title,
            'path'  => $iconPath,
            'title' => $customIcon->title,
        ]);
    }

    public function saveRawSvgIcon(?string $targetField = null, ?int $targetIndex = null, ?string $targetTypeField = null, string $svgCode = '', string $title = ''): void
    {
        $svgCode = trim($svgCode);
        if (empty($svgCode)) return;

        $name = !empty($title) ? $title : 'Custom Raw SVG ' . (CustomIcon::count() + 1);
        $customIcon = CustomIcon::create([
            'title'    => $name,
            'svg_code' => $svgCode,
            'type'     => 'svg',
            'is_active'=> true,
        ]);

        $iconId = "raw_svg:{$customIcon->id}";
        $this->selectIconAsset($targetField ?? '', $targetIndex, $iconId, $targetTypeField);

        $this->dispatch('custom-icon-saved', [
            'id'    => $customIcon->id,
            'name'  => $customIcon->title,
            'path'  => $iconId,
            'title' => $customIcon->title,
        ]);
    }

    public function deleteCustomIcon(int $id): void
    {
        $icon = CustomIcon::find($id);
        if ($icon) {
            if ($icon->file_path && !str_starts_with($icon->file_path, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($icon->file_path);
            }
            $iconPath = $icon->type === 'svg' ? "raw_svg:{$icon->id}" : ($icon->file_path ?: "custom_icon:{$icon->id}");
            $iconId = $icon->id;
            $icon->delete();

            IconRegistry::flushCache($iconId);

            $this->dispatch('custom-icon-deleted', [
                'iconId'   => $iconId,
                'iconPath' => $iconPath,
            ]);
        }
    }

    /**
     * Provide comprehensive internal page and anchor route choices
     * so admins never need to manually remember or type routes.
     */
    public function getInternalLinkOptions(): array
    {
        $options = [
            'Core Public Pages' => [
                '/' => 'Home Page (Landing Page)',
                '/about' => 'About Us (Company Overview)',
                '/about#overview' => 'About Us → Corporate Heritage & Profile',
                '/about#mission' => 'About Us → Mission, Vision & Core Values',
                '/about#certifications' => 'About Us → ISO 9001:2015 & DNV Standards',
                '/services' => 'Services (All Precision Overhauls)',
                '/services#balancing' => 'Services → Dynamic Rotor Balancing (100k RPM)',
                '/services#overhaul' => 'Services → Turbine Blading & TIG Welding',
                '/services#cartridge' => 'Services → Cartridge (CHRA) Exchange',
                '/services#ultrasonic' => 'Services → Ultrasonic Chemical Cleaning',
                '/services#flying-squad' => 'Services → 24/7 Port Emergency Flying Squads',
                '/products' => 'Products & Spares Catalog',
                '/projects' => 'Featured Projects & Case Studies',
                '/photo-gallery' => 'Photo Gallery & Workshops',
                '/video-gallery' => 'Video Gallery & Procedures',
                '/careers' => 'Careers & Open Positions',
                '/contact' => 'Contact Desk',
                '/contact#rfq' => 'Contact Desk → Technical RFQ Form',
            ],
            'Admin Portals & Management' => [
                '/admin/dashboard' => 'Admin Portal / Dashboard',
                '/admin/enquiries' => 'Admin → Inquiries & RFQ Leads',
                '/admin/services' => 'Admin → Precision Services Manager',
                '/admin/products' => 'Admin → Products & Spares Manager',
                '/admin/theme' => 'Admin → Theme Studio',
                '/admin/menus' => 'Admin → Navigation Menus',
                '/admin/settings' => 'Admin → Global Settings',
            ],
        ];

        // Add dynamic published pages
        try {
            $dbPages = \App\Models\Page::where('status', 'published')->get();
            if ($dbPages->count() > 0) {
                foreach ($dbPages as $page) {
                    $slug = '/' . ltrim($page->slug, '/');
                    $title = is_array($page->title) ? ($page->title[app()->getLocale()] ?? reset($page->title)) : $page->title;
                    $options['Custom CMS Pages'][$slug] = $title . " ({$slug})";
                }
            }
        } catch (\Throwable $e) {}

        // Add dynamic services
        try {
            $dbServices = \App\Models\Service::where('is_active', true)->orderBy('order')->get();
            if ($dbServices->count() > 0) {
                foreach ($dbServices as $service) {
                    $slug = '/services/' . $service->slug;
                    $options['Dynamic Services'][$slug] = ($service->display_title ?: $service->slug) . " ({$slug})";
                }
            }
        } catch (\Throwable $e) {}

        return $options;
    }

    public function render()
    {
        $availableMenus = Menu::orderBy('name')->get();
        $selectedMenu = $this->header_menu_id ? Menu::find($this->header_menu_id) : null;

        // Retrieve settings social links
        $storedSocial = Setting::get('social_links_data');
        $availableSocialLinks = [];
        if ($storedSocial) {
            $availableSocialLinks = is_array($storedSocial) ? $storedSocial : (json_decode($storedSocial, true) ?? []);
        }

        return view('livewire.admin.pages.homepage-builder', [
            'availableMenus'       => $availableMenus,
            'selectedMenu'         => $selectedMenu,
            'availableSocialLinks' => $availableSocialLinks,
            'internalLinkOptions'  => $this->getInternalLinkOptions(),
        ]);
    }
}
