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
    public string $hero_title_highlight_style = 'gradient_cyan'; // 'gradient_cyan', 'gradient_amber', 'brand_primary', 'gradient_emerald', 'gradient_custom', 'solid_custom'
    public string $hero_title_highlight_custom = '#0ea5e9';
    public string $hero_title_size = 'standard'; // 'compact', 'standard', 'large', 'extra_large'
    public string $hero_title_weight = 'black'; // 'bold', 'extrabold', 'black'
    public string $hero_title_glow = 'none'; // 'none', 'subtle', 'cyan', 'amber', 'deep'
    // Custom Multi-color Gradient Controls for Headline Highlight
    public string $hero_title_grad_dir = '135deg';
    public string $hero_title_grad_from = '#00d2ff';
    public string $hero_title_grad_via = '#0084ff';
    public string $hero_title_grad_to = '#003C58';
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
    public string $hero_notice_link_type = 'internal'; // 'internal', 'external'

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
    public string $hero_visual_padding = 'spacious'; // 'none', 'compact', 'standard', 'spacious', 'extra_spacious'
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

    // ==========================================
    // SECTIONS ORDER & ORCHESTRATION
    // ==========================================
    public const DEFAULT_SECTIONS_ORDER = [
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

    public array $sectionsOrder = [];
    public array $sectionsEnabled = [];

    // 1. PARTNERS TICKER
    public bool $partners_enabled = true;
    public string $partners_tagline = 'Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms';
    public string $partners_mode = 'static'; // 'static', 'dynamic'
    public string $partners_speed = 'normal'; // 'slow', 'normal', 'fast'
    public string $partners_bg_style = 'theme_default'; // 'theme_default', 'clean_white', 'transparent'
    public string $partners_brands_list = 'Accelleron (ABB), MAN Energy Solutions, KBB Kompressorenbau, Napier Turbochargers, Mitsubishi Heavy Industries (MET), PBS Turbo, INNIO Waukesha, Ariel Compressors';

    // 2. ABOUT US & CORPORATE PILLARS
    public bool $about_enabled = true;
    public string $about_badge = 'Conglomerate Heritage & Vision';
    public string $about_title = 'A Heritage of Heavy Industrial Power, Maritime Integrity, & Turn-Key Engineering.';
    public string $about_description = 'Operating under the high standards of global marine engineering, Nordroy Marine & Turbochargers unites heavy mechanical overhaul workshops, non-destructive metallurgical testing (NDT), dynamic rotor calibration, and comprehensive spare parts logistics under one unified corporate umbrella.';
    public string $about_p1_icon = 'solid:anchor';
    public string $about_p1_title = 'Global Port Reach';
    public string $about_p1_desc = '24/7 flying squads equipped for anchorage and berth call overhauls.';
    public string $about_p2_icon = 'solid:gauge-high';
    public string $about_p2_title = 'Calibrated Precision';
    public string $about_p2_desc = 'Computerized Schenck dynamic balancing up to 100,000 RPM.';
    public string $about_p3_icon = 'solid:certificate';
    public string $about_p3_title = 'OEM Alliances';
    public string $about_p3_desc = 'Direct access to genuine replacement parts and calibrated drawings.';
    public string $about_quote_text = '"In maritime logistics and heavy power generation, downtime is measured in thousands of dollars per hour. Our mission is to restore engine efficiency with zero deviation from OEM tolerances."';
    public string $about_quote_author = 'Technical Operations';
    public string $about_quote_role = 'Turbomachinery Overhaul Division';
    public string $about_quote_initials = 'NR';

    // 3. PRECISION SERVICES
    public bool $services_enabled = true;
    public string $services_badge = 'Workshop & Port Capabilities';
    public string $services_title = 'Precision Overhaul Services';
    public string $services_subtitle = 'Engineered according to manufacturer tolerance protocols with calibrated German Schenck balancing rigs.';
    public string $services_mode = 'static'; // 'static', 'dynamic'
    public int $services_limit = 6;

    // 4. VIDEO BREAK
    public bool $video_break_enabled = true;
    public string $video_break_badge = 'Global Marine Engineering Excellence';
    public string $video_break_heading = '24/7 Rapid Emergency Response Across 40+ International Ports';
    public string $video_break_subtitle = 'Our certified flying squads board commercial vessels at anchorage or alongside berths to deliver on-site turbocharger diagnostics, cartridge swap-outs, and dynamic balancing.';
    public string $video_break_cta1_text = 'View Overhaul Capabilities →';
    public string $video_break_cta1_url = '/services';
    public string $video_break_cta2_text = 'Contact Port Operations';
    public string $video_break_cta2_url = '/contact';

    // 5. BLUEPRINT (MISSION, VISION, VALUES)
    public bool $blueprint_enabled = true;
    public string $blueprint_badge = 'Corporate Blueprint';
    public string $blueprint_title = 'Mission, Vision & Core Values';
    public string $blueprint_subtitle = 'Guiding principles that define our commitment to global shipowners, captive power operators, and heavy industries.';
    public string $blueprint_mission_icon = 'solid:bullseye';
    public string $blueprint_mission_title = 'Our Mission';
    public string $blueprint_mission_desc = 'To eliminate engine downtime by delivering certified, multi-brand turbocharger overhauls, high-speed dynamic balancing, and genuine OEM parts with unmatched turnaround speed, metallurgical precision, and total engineering transparency.';
    public string $blueprint_vision_icon = 'solid:eye';
    public string $blueprint_vision_title = 'Our Vision 2030';
    public string $blueprint_vision_desc = 'To be the premier independent maritime turbomachinery conglomerate in South Asia and global waters, recognized by international classification societies as the benchmark for quality, technical integrity, and decarbonization retrofits.';
    public string $blueprint_values_icon = 'solid:shield-halved';
    public string $blueprint_values_title = 'Core Values';
    public string $blueprint_value1 = 'Zero-Defect Quality: Strict adherence to ISO 9001 protocols.';
    public string $blueprint_value2 = 'Rapid Port Agility: 24/7 readiness for urgent port calls.';
    public string $blueprint_value3 = 'Technical Rigor: Calibrated testing and certified reports.';

    // 6. PROJECTS
    public bool $projects_enabled = true;
    public string $projects_badge = 'Execution Proven Track Record';
    public string $projects_title = 'Featured Industrial & Marine Projects';
    public string $projects_subtitle = 'A glimpse of recent turn-key overhauls completed on commercial ships and captive power plants.';

    // 7. VIDEOS
    public bool $videos_enabled = true;
    public string $videos_badge = 'Workshop & Port In Action';
    public string $videos_title = 'Video Gallery (Hover to Play)';
    public string $videos_subtitle = 'Hover your mouse over any video card to stream a live silent preview of our precision balancing and overhaul operations.';
    public string $videos_mode = 'static'; // 'static', 'dynamic'
    public int $videos_limit = 3;

    // 8. PHOTOS
    public bool $photos_enabled = true;
    public string $photos_badge = 'Visual Facilities';
    public string $photos_title = 'Workshop & Engineering Gallery';
    public string $photos_subtitle = 'Click on any photo below to inspect high-resolution images of our port workshops and overhaul facilities.';
    public string $photos_mode = 'static'; // 'static', 'dynamic'
    public int $photos_limit = 8;

    // 9. METRICS
    public bool $metrics_enabled = true;
    public string $metric_counter1_val = '30+';
    public string $metric_counter1_lbl = 'Years of Excellence';
    public string $metric_counter2_val = '1,450+';
    public string $metric_counter2_lbl = 'Turbomachines Overhauled';
    public string $metric_counter3_val = '12+';
    public string $metric_counter3_lbl = 'Global Ports Covered';
    public string $metric_counter4_val = '100%';
    public string $metric_counter4_lbl = 'Calibrated Schenck Testing';

    // 10. SPARE PARTS
    public bool $parts_enabled = true;
    public string $parts_badge = 'OEM Replacement Inventory';
    public string $parts_title = 'Genuine Spare Parts Catalog';
    public string $parts_subtitle = 'Traceable serial numbers with mill test certificates ready for immediate dispatch.';
    public string $parts_mode = 'static'; // 'static', 'dynamic'
    public int $parts_limit = 6;

    // 11. RFQ DUTY DESK
    public bool $rfq_enabled = true;
    public string $rfq_badge = '24/7 Operations Desk';
    public string $rfq_title = 'Request Instant Quotation or Emergency Port Call';
    public string $rfq_subtitle = 'Our duty marine engineering superintendents respond within 45 minutes of RFQ submission.';
    public string $rfq_btn_text = 'Submit Technical RFQ to Duty Desk';

    // 12. FOOTER STUDIO
    public bool $footer_enabled = true;
    public string $footer_bio = 'A premier industrial conglomerate and maritime engineering group specializing in authorized multi-brand exhaust gas turbocharger overhauls, dynamic rotor balancing up to 100,000 RPM, genuine OEM spare parts supply, and technical port assistance across global maritime hubs.';
    public bool $footer_show_social = true;
    public string $footer_cert_text = 'ISO 9001:2015 & DNV Certified';
    public string $footer_col2_title = 'OEM Spare Parts';
    public string $footer_col3_title = 'Technical Services';
    public string $footer_col4_title = 'Port & HQ Offices';
    public string $footer_workshop_addr = 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.';
    public string $footer_hq_addr = 'Gulshan Industrial Area, Dhaka, Bangladesh';
    public string $footer_phone = '+880 1800-000000';
    public string $footer_copyright = '© 2026 Nordroy Marine & Turbochargers. All rights reserved. Maritime Engineering & Industrial Overhauls.';
    public bool $footer_show_login = true;

    // Footer Studio Enhancements
    public bool $footer_show_logo = true;
    public string $footer_logo_type = 'site_logo'; // 'site_logo', 'custom_logo'
    public string $footer_custom_logo = '';
    public int $footer_logo_height = 40;
    public bool $footer_col1_enabled = true;
    public bool $footer_col2_enabled = true;
    public bool $footer_col3_enabled = true;
    public bool $footer_col4_enabled = true;
    public string $footer_col2_mode = 'custom'; // 'custom', 'menu'
    public ?int $footer_col2_menu_id = null;
    public array $footer_col2_links = [];
    public string $footer_col3_mode = 'custom'; // 'custom', 'menu'
    public ?int $footer_col3_menu_id = null;
    public array $footer_col3_links = [];
    public string $footer_email = 'operations@nordroy.com';
    public bool $footer_show_phone = true;
    public bool $footer_show_email = true;

    // ==========================================
    // UNIVERSAL SECTION STYLERS
    // ==========================================
    public array $sectionStylers = [];

    // ==========================================
    // CUSTOM SECTIONS STUDIO
    // ==========================================
    public array $customSections = [];
    public bool $showAddSectionModal = false;
    public string $newSectionType = 'content_block';
    public string $newSectionTitle = '';

    // ==========================================
    // REPEATERS FOR STATIC SECTIONS CONTENT
    // ==========================================
    public array $services_static_items = [];
    public array $parts_static_items = [];
    public array $photos_static_items = [];
    public array $videos_static_items = [];
    public array $metrics_items = [];

    // Precached link options
    public array $internalLinkOptions = [];

    public function mount(): void
    {
        $this->internalLinkOptions = $this->getInternalLinkOptions();
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
        $this->hero_title_size      = Setting::get('home_hero_title_size', 'standard');
        $this->hero_title_weight    = Setting::get('home_hero_title_weight', 'black');
        $this->hero_title_glow      = Setting::get('home_hero_title_glow', 'none');
        $this->hero_title_grad_dir  = Setting::get('home_hero_title_grad_dir', '135deg');
        $this->hero_title_grad_from = Setting::get('home_hero_title_grad_from', '#00d2ff');
        $this->hero_title_grad_via  = Setting::get('home_hero_title_grad_via', '#0084ff');
        $this->hero_title_grad_to   = Setting::get('home_hero_title_grad_to', '#003C58');

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
        $this->hero_notice_link_type = Setting::get('home_hero_notice_link_type', (str_starts_with($this->hero_notice_url, 'http://') || str_starts_with($this->hero_notice_url, 'https://')) ? 'external' : 'internal');

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
        $this->hero_visual_padding  = Setting::get('home_hero_visual_padding', 'spacious');
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

        // ==========================================
        // LOAD REORDERABLE BODY SECTIONS & FOOTER
        // ==========================================
        $storedOrder = Setting::get('home_sections_order');
        if ($storedOrder) {
            $decoded = is_array($storedOrder) ? $storedOrder : json_decode($storedOrder, true);
            $this->sectionsOrder = is_array($decoded) && !empty($decoded) ? array_values($decoded) : self::DEFAULT_SECTIONS_ORDER;
        } else {
            $this->sectionsOrder = self::DEFAULT_SECTIONS_ORDER;
        }

        // 1. Partners Ticker
        $this->partners_enabled     = (bool) Setting::get('home_partners_enabled', true);
        $this->partners_tagline     = Setting::get('home_partners_tagline', 'Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms');
        $this->partners_mode        = Setting::get('home_partners_mode', 'static');
        $this->partners_speed       = Setting::get('home_partners_speed', 'normal');
        $this->partners_bg_style    = Setting::get('home_partners_bg_style', 'theme_default');
        $this->partners_brands_list = Setting::get('home_partners_brands_list', 'Accelleron (ABB), MAN Energy Solutions, KBB Kompressorenbau, Napier Turbochargers, Mitsubishi Heavy Industries (MET), PBS Turbo, INNIO Waukesha, Ariel Compressors');

        // 2. About Us
        $this->about_enabled        = (bool) Setting::get('home_about_enabled', true);
        $this->about_badge          = Setting::get('home_about_badge', 'Conglomerate Heritage & Vision');
        $this->about_title          = Setting::get('home_about_title', 'A Heritage of Heavy Industrial Power, Maritime Integrity, & Turn-Key Engineering.');
        $this->about_description    = Setting::get('home_about_description', 'Operating under the high standards of global marine engineering, Nordroy Marine & Turbochargers unites heavy mechanical overhaul workshops, non-destructive metallurgical testing (NDT), dynamic rotor calibration, and comprehensive spare parts logistics under one unified corporate umbrella.');
        $this->about_p1_icon        = Setting::get('home_about_p1_icon', 'solid:anchor');
        $this->about_p1_title       = Setting::get('home_about_p1_title', 'Global Port Reach');
        $this->about_p1_desc        = Setting::get('home_about_p1_desc', '24/7 flying squads equipped for anchorage and berth call overhauls.');
        $this->about_p2_icon        = Setting::get('home_about_p2_icon', 'solid:gauge-high');
        $this->about_p2_title       = Setting::get('home_about_p2_title', 'Calibrated Precision');
        $this->about_p2_desc        = Setting::get('home_about_p2_desc', 'Computerized Schenck dynamic balancing up to 100,000 RPM.');
        $this->about_p3_icon        = Setting::get('home_about_p3_icon', 'solid:certificate');
        $this->about_p3_title       = Setting::get('home_about_p3_title', 'OEM Alliances');
        $this->about_p3_desc        = Setting::get('home_about_p3_desc', 'Direct access to genuine replacement parts and calibrated drawings.');
        $this->about_quote_text     = Setting::get('home_about_quote_text', '"In maritime logistics and heavy power generation, downtime is measured in thousands of dollars per hour. Our mission is to restore engine efficiency with zero deviation from OEM tolerances."');
        $this->about_quote_author   = Setting::get('home_about_quote_author', 'Technical Operations');
        $this->about_quote_role     = Setting::get('home_about_quote_role', 'Turbomachinery Overhaul Division');
        $this->about_quote_initials = Setting::get('home_about_quote_initials', 'NR');

        // 3. Precision Services
        $this->services_enabled     = (bool) Setting::get('home_services_enabled', true);
        $this->services_badge       = Setting::get('home_services_badge', 'Workshop & Port Capabilities');
        $this->services_title       = Setting::get('home_services_title', 'Precision Overhaul Services');
        $this->services_subtitle    = Setting::get('home_services_subtitle', 'Engineered according to manufacturer tolerance protocols with calibrated German Schenck balancing rigs.');
        $this->services_mode        = Setting::get('home_services_mode', 'static');
        $this->services_limit       = (int) Setting::get('home_services_limit', 6);

        // 4. Video Break
        $this->video_break_enabled  = (bool) Setting::get('home_video_break_enabled', Setting::get('theme_video_break_enabled', '1') == '1');
        $this->video_break_badge    = Setting::get('home_video_break_badge', 'Global Marine Engineering Excellence');
        $this->video_break_heading  = Setting::get('home_video_break_heading', '24/7 Rapid Emergency Response Across 40+ International Ports');
        $this->video_break_subtitle = Setting::get('home_video_break_subtitle', 'Our certified flying squads board commercial vessels at anchorage or alongside berths to deliver on-site turbocharger diagnostics, cartridge swap-outs, and dynamic balancing.');
        $this->video_break_cta1_text= Setting::get('home_video_break_cta1_text', 'View Overhaul Capabilities →');
        $this->video_break_cta1_url = Setting::get('home_video_break_cta1_url', '/services');
        $this->video_break_cta2_text= Setting::get('home_video_break_cta2_text', 'Contact Port Operations');
        $this->video_break_cta2_url = Setting::get('home_video_break_cta2_url', '/contact');

        // 5. Blueprint
        $this->blueprint_enabled    = (bool) Setting::get('home_blueprint_enabled', true);
        $this->blueprint_badge      = Setting::get('home_blueprint_badge', 'Corporate Blueprint');
        $this->blueprint_title      = Setting::get('home_blueprint_title', 'Mission, Vision & Core Values');
        $this->blueprint_subtitle   = Setting::get('home_blueprint_subtitle', 'Guiding principles that define our commitment to global shipowners, captive power operators, and heavy industries.');
        $this->blueprint_mission_icon = Setting::get('home_blueprint_mission_icon', 'solid:bullseye');
        $this->blueprint_mission_title= Setting::get('home_blueprint_mission_title', 'Our Mission');
        $this->blueprint_mission_desc = Setting::get('home_blueprint_mission_desc', 'To eliminate engine downtime by delivering certified, multi-brand turbocharger overhauls, high-speed dynamic balancing, and genuine OEM parts with unmatched turnaround speed, metallurgical precision, and total engineering transparency.');
        $this->blueprint_vision_icon  = Setting::get('home_blueprint_vision_icon', 'solid:eye');
        $this->blueprint_vision_title = Setting::get('home_blueprint_vision_title', 'Our Vision 2030');
        $this->blueprint_vision_desc  = Setting::get('home_blueprint_vision_desc', 'To be the premier independent maritime turbomachinery conglomerate in South Asia and global waters, recognized by international classification societies as the benchmark for quality, technical integrity, and decarbonization retrofits.');
        $this->blueprint_values_icon  = Setting::get('home_blueprint_values_icon', 'solid:shield-halved');
        $this->blueprint_values_title = Setting::get('home_blueprint_values_title', 'Core Values');
        $this->blueprint_value1       = Setting::get('home_blueprint_value1', 'Zero-Defect Quality: Strict adherence to ISO 9001 protocols.');
        $this->blueprint_value2       = Setting::get('home_blueprint_value2', 'Rapid Port Agility: 24/7 readiness for urgent port calls.');
        $this->blueprint_value3       = Setting::get('home_blueprint_value3', 'Technical Rigor: Calibrated testing and certified reports.');

        // 6. Featured Projects
        $this->projects_enabled     = (bool) Setting::get('home_projects_enabled', true);
        $this->projects_badge       = Setting::get('home_projects_badge', 'Execution Proven Track Record');
        $this->projects_title       = Setting::get('home_projects_title', 'Featured Industrial & Marine Projects');
        $this->projects_subtitle    = Setting::get('home_projects_subtitle', 'A glimpse of recent turn-key overhauls completed on commercial ships and captive power plants.');

        // 7. Video Gallery
        $this->videos_enabled       = (bool) Setting::get('home_videos_enabled', true);
        $this->videos_badge         = Setting::get('home_videos_badge', 'Workshop & Port In Action');
        $this->videos_title         = Setting::get('home_videos_title', 'Video Gallery (Hover to Play)');
        $this->videos_subtitle      = Setting::get('home_videos_subtitle', 'Hover your mouse over any video card to stream a live silent preview of our precision balancing and overhaul operations.');
        $this->videos_mode          = Setting::get('home_videos_mode', 'static');
        $this->videos_limit         = (int) Setting::get('home_videos_limit', 3);

        // 8. Photo Gallery
        $this->photos_enabled       = (bool) Setting::get('home_photos_enabled', true);
        $this->photos_badge         = Setting::get('home_photos_badge', 'Visual Facilities');
        $this->photos_title         = Setting::get('home_photos_title', 'Workshop & Engineering Gallery');
        $this->photos_subtitle      = Setting::get('home_photos_subtitle', 'Click on any photo below to inspect high-resolution images of our port workshops and overhaul facilities.');
        $this->photos_mode          = Setting::get('home_photos_mode', 'static');
        $this->photos_limit         = (int) Setting::get('home_photos_limit', 8);

        // 9. Metrics Counters
        $this->metrics_enabled      = (bool) Setting::get('home_metrics_enabled', true);
        $this->metric_counter1_val  = Setting::get('home_metrics_stat1_val', '30+');
        $this->metric_counter1_lbl  = Setting::get('home_metrics_stat1_lbl', 'Years of Excellence');
        $this->metric_counter2_val  = Setting::get('home_metrics_stat2_val', '1,450+');
        $this->metric_counter2_lbl  = Setting::get('home_metrics_stat2_lbl', 'Turbomachines Overhauled');
        $this->metric_counter3_val  = Setting::get('home_metrics_stat3_val', '12+');
        $this->metric_counter3_lbl  = Setting::get('home_metrics_stat3_lbl', 'Global Ports Covered');
        $this->metric_counter4_val  = Setting::get('home_metrics_stat4_val', '100%');
        $this->metric_counter4_lbl  = Setting::get('home_metrics_stat4_lbl', 'Calibrated Schenck Testing');

        // 10. Spare Parts
        $this->parts_enabled        = (bool) Setting::get('home_parts_enabled', true);
        $this->parts_badge          = Setting::get('home_parts_badge', 'OEM Replacement Inventory');
        $this->parts_title          = Setting::get('home_parts_title', 'Genuine Spare Parts Catalog');
        $this->parts_subtitle       = Setting::get('home_parts_subtitle', 'Traceable serial numbers with mill test certificates ready for immediate dispatch.');
        $this->parts_mode           = Setting::get('home_parts_mode', 'static');
        $this->parts_limit          = (int) Setting::get('home_parts_limit', 6);

        // 11. RFQ Duty Desk
        $this->rfq_enabled          = (bool) Setting::get('home_rfq_enabled', true);
        $this->rfq_badge            = Setting::get('home_rfq_badge', '24/7 Operations Desk');
        $this->rfq_title            = Setting::get('home_rfq_title', 'Request Instant Quotation or Emergency Port Call');
        $this->rfq_subtitle         = Setting::get('home_rfq_subtitle', 'Our duty marine engineering superintendents respond within 45 minutes of RFQ submission.');
        $this->rfq_btn_text         = Setting::get('home_rfq_btn_text', 'Submit Technical RFQ to Duty Desk');

        // 12. Corporate Footer
        $this->footer_enabled       = (bool) Setting::get('home_footer_enabled', true);
        $this->footer_show_logo     = (bool) Setting::get('home_footer_show_logo', true);
        $this->footer_logo_type     = Setting::get('home_footer_logo_type', 'site_logo');
        $this->footer_custom_logo   = Setting::get('home_footer_custom_logo', '');
        $this->footer_logo_height   = (int) Setting::get('home_footer_logo_height', 40);

        $this->footer_col1_enabled  = (bool) Setting::get('home_footer_col1_enabled', true);
        $this->footer_col2_enabled  = (bool) Setting::get('home_footer_col2_enabled', true);
        $this->footer_col3_enabled  = (bool) Setting::get('home_footer_col3_enabled', true);
        $this->footer_col4_enabled  = (bool) Setting::get('home_footer_col4_enabled', true);

        $this->footer_bio           = Setting::get('home_footer_bio', 'A premier industrial conglomerate and maritime engineering group specializing in authorized multi-brand exhaust gas turbocharger overhauls, dynamic rotor balancing up to 100,000 RPM, genuine OEM spare parts supply, and technical port assistance across global maritime hubs.');
        $this->footer_show_social   = (bool) Setting::get('home_footer_show_social', true);
        $this->footer_cert_text     = Setting::get('home_footer_cert_text', 'ISO 9001:2015 & DNV Certified');
        $this->footer_col2_title    = Setting::get('home_footer_col2_title', 'OEM Spare Parts');
        $this->footer_col2_mode     = Setting::get('home_footer_col2_mode', 'custom');
        $this->footer_col2_menu_id  = Setting::get('home_footer_col2_menu_id') ? (int) Setting::get('home_footer_col2_menu_id') : null;
        $this->footer_col2_links    = Setting::getJson('home_footer_col2_links', [
            ['text' => 'Turbine Blades & Rotors', 'url' => '/products'],
            ['text' => 'CHRA Replacement Cartridges', 'url' => '/products'],
            ['text' => 'Nozzle Rings & Diffusers', 'url' => '/products'],
            ['text' => 'Hydrodynamic Bearing Bushes', 'url' => '/products'],
            ['text' => 'Careers & Opportunities →', 'url' => '/careers'],
        ]);

        $this->footer_col3_title    = Setting::get('home_footer_col3_title', 'Technical Services');
        $this->footer_col3_mode     = Setting::get('home_footer_col3_mode', 'custom');
        $this->footer_col3_menu_id  = Setting::get('home_footer_col3_menu_id') ? (int) Setting::get('home_footer_col3_menu_id') : null;
        $this->footer_col3_links    = Setting::getJson('home_footer_col3_links', [
            ['text' => 'Dynamic Rotor Balancing', 'url' => '/services#balancing'],
            ['text' => 'Turbine Blading & Welding', 'url' => '/services#overhaul'],
            ['text' => 'Cartridge Reconditioning', 'url' => '/services#cartridge'],
            ['text' => 'Ultrasonic Chemical Cleaning', 'url' => '/services#ultrasonic'],
            ['text' => '24/7 Port Emergency Call', 'url' => '/services#flying-squad'],
        ]);

        $this->footer_col4_title    = Setting::get('home_footer_col4_title', 'Port & HQ Offices');
        $this->footer_workshop_addr = Setting::get('home_footer_workshop_addr', 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.');
        $this->footer_hq_addr       = Setting::get('home_footer_hq_addr', 'Gulshan Industrial Area, Dhaka, Bangladesh');
        $this->footer_phone         = Setting::get('home_footer_phone', Setting::get('contact_phone', '+880 1800-000000'));
        $this->footer_email         = Setting::get('home_footer_email', Setting::get('contact_email', 'operations@nordroy.com'));
        $this->footer_show_phone    = (bool) Setting::get('home_footer_show_phone', true);
        $this->footer_show_email    = (bool) Setting::get('home_footer_show_email', true);
        $this->footer_copyright     = Setting::get('home_footer_copyright', '© 2026 Nordroy Marine & Turbochargers. All rights reserved. Maritime Engineering & Industrial Overhauls.');
        $this->footer_show_login    = (bool) Setting::get('home_footer_show_login', true);

        // Load Static Repeaters
        $this->services_static_items = Setting::getJson('home_services_static_items', [
            ['title' => 'Dynamic Rotor Balancing (100k RPM)', 'category' => 'BALANCING', 'icon' => 'solid:gauge', 'excerpt' => 'Elimination of micro-vibrations with computerized dynamic balancing up to 100,000 RPM, certified with comprehensive tolerance test sheets.', 'url' => '/services#balancing'],
            ['title' => 'Turbine Blading & TIG Welding', 'category' => 'WELDING', 'icon' => 'solid:fire-flame-curved', 'excerpt' => 'Precision laser and micro-TIG rebuilding of eroded turbine blade profiles, shroud rings, and metallurgical crack restoration.', 'url' => '/services#overhaul'],
            ['title' => 'Cartridge (CHRA) Exchange', 'category' => 'CHRA', 'icon' => 'solid:arrows-rotate', 'excerpt' => 'Pre-assembled, factory-balanced cartridge replacement modules for rapid turnaround times during tight vessel port calls.', 'url' => '/services#cartridge'],
            ['title' => 'Ultrasonic Chemical Cleaning', 'category' => 'CHEMICAL', 'icon' => 'solid:spray-can', 'excerpt' => 'Multi-stage ultrasonic immersion tanks with specialized alkaline solvents to dissolve stubborn heavy fuel oil carbon deposits.', 'url' => '/services#ultrasonic'],
            ['title' => 'Bearing Journal Micro-Polishing', 'category' => 'MACHINING', 'icon' => 'solid:microchip', 'excerpt' => 'Superfinishing and micro-polishing of journal shaft bearing journals to mirror finish, ensuring hydrodynamic oil film integrity.', 'url' => '/services#bearing'],
            ['title' => '24/7 Port Emergency Flying Squads', 'category' => 'EMERGENCY', 'icon' => 'solid:helicopter', 'excerpt' => 'Mobilized within 60 minutes for outer anchorage or container terminal emergency berth call repairs and class society surveyor trials.', 'url' => '/contact#emergency'],
        ]);

        $this->parts_static_items = Setting::getJson('home_parts_static_items', [
            ['name' => 'Turbine Blades', 'part_number' => 'Nimonic 80A / 90', 'icon' => 'solid:fan', 'url' => '/products'],
            ['name' => 'Rotor Shafts', 'part_number' => 'Forged Alloy Steel', 'icon' => 'solid:circle-notch', 'url' => '/products'],
            ['name' => 'Nozzle Rings', 'part_number' => 'High-Temp Resistant', 'icon' => 'solid:ring', 'url' => '/products'],
            ['name' => 'Bearing Bushes', 'part_number' => 'Hydrodynamic Bronze', 'icon' => 'solid:compact-disc', 'url' => '/products'],
            ['name' => 'Sealing Bushes', 'part_number' => 'Labyrinth Alloy', 'icon' => 'solid:shield', 'url' => '/products'],
            ['name' => 'Compressor Wheels', 'part_number' => 'Milled Billet Ti/Al', 'icon' => 'solid:gear', 'url' => '/products'],
        ]);

        $this->photos_static_items = Setting::getJson('home_photos_static_items', [
            ['title' => 'Dynamic Balancing Bay', 'subtitle' => '100,000 RPM Schenck Rig', 'image_url' => 'assets/images/gallery/gallery-balancing.webp'],
            ['title' => 'Turbine Blading & Welding', 'subtitle' => 'Micro-TIG Rebuilding', 'image_url' => 'assets/images/gallery/gallery-welding.webp'],
            ['title' => 'CHRA Cartridge Assembly', 'subtitle' => 'Cleanroom Inspection', 'image_url' => 'assets/images/gallery/gallery-cartridge.webp'],
            ['title' => 'Ultrasonic Chemical Wash', 'subtitle' => 'Carbon Removal Baths', 'image_url' => 'assets/images/gallery/gallery-ultrasonic.webp'],
            ['title' => 'Compressor Wheel Machining', 'subtitle' => 'CNC 5-Axis Precision', 'image_url' => 'assets/images/gallery/gallery-cnc.webp'],
            ['title' => 'Non-Destructive Testing', 'subtitle' => 'Fluorescent Dye Penetrant', 'image_url' => 'assets/images/gallery/gallery-ndt.webp'],
            ['title' => 'Outer Anchorage Flying Squad', 'subtitle' => 'Container Vessel Boarding', 'image_url' => 'assets/images/gallery/gallery-shipboard.webp'],
            ['title' => 'Genuine OEM Spares Warehouse', 'subtitle' => 'Over 10,000 Spares in Stock', 'image_url' => 'assets/images/gallery/gallery-warehouse.webp'],
        ]);

        $this->videos_static_items = Setting::getJson('home_videos_static_items', [
            ['title' => 'Dynamic Rotor Balancing at 100,000 RPM', 'category' => 'BALANCING PROCEDURE', 'description' => 'Real-time sensor vibration diagnostics on Schenck calibration rig.', 'video_url' => 'assets/videos/background-marine.mp4', 'thumbnail_url' => 'assets/images/gallery/gallery-balancing.webp'],
            ['title' => 'Precision TIG Shroud Ring & Blade Rebuilding', 'category' => 'WELDING & METALLURGY', 'description' => 'Laser-guided profile restoration on eroded high-temp exhaust gas blades.', 'video_url' => 'assets/videos/background-marine.mp4', 'thumbnail_url' => 'assets/images/gallery/gallery-welding.webp'],
            ['title' => '24/7 Outer Anchorage Emergency Squad Mobilization', 'category' => 'PORT CALL MOBILIZATION', 'description' => 'Marine flying squads boarding bulk carrier at Chattogram outer anchorage.', 'video_url' => 'assets/videos/background-marine.mp4', 'thumbnail_url' => 'assets/images/gallery/gallery-shipboard.webp'],
        ]);

        $this->metrics_items = Setting::getJson('home_metrics_items', [
            ['value' => Setting::get('home_metrics_stat1_val', '30+'), 'label' => Setting::get('home_metrics_stat1_lbl', 'Years of Excellence'), 'icon' => 'solid:award'],
            ['value' => Setting::get('home_metrics_stat2_val', '1,450+'), 'label' => Setting::get('home_metrics_stat2_lbl', 'Turbomachines Overhauled'), 'icon' => 'solid:gears'],
            ['value' => Setting::get('home_metrics_stat3_val', '12+'), 'label' => Setting::get('home_metrics_stat3_lbl', 'Global Ports Covered'), 'icon' => 'solid:anchor'],
            ['value' => Setting::get('home_metrics_stat4_val', '100%'), 'label' => Setting::get('home_metrics_stat4_lbl', 'Calibrated Schenck Testing'), 'icon' => 'solid:shield-check'],
        ]);

        // Load Universal Section Stylers
        $stylerSections = self::DEFAULT_SECTIONS_ORDER;
        foreach ($stylerSections as $secKey) {
            $this->sectionStylers[$secKey] = [
                'bg_type'       => Setting::get("home_{$secKey}_bg_type", 'theme_default'),
                'bg_light'      => Setting::get("home_{$secKey}_bg_light", '#ffffff'),
                'bg_dark'       => Setting::get("home_{$secKey}_bg_dark", '#0b1b2b'),
                'gradient_dir'  => Setting::get("home_{$secKey}_gradient_dir", '135deg'),
                'gradient_from' => Setting::get("home_{$secKey}_gradient_from", '#002538'),
                'gradient_to'   => Setting::get("home_{$secKey}_gradient_to", '#07131e'),
                'glass_opacity' => max(10, min(90, (int) Setting::get("home_{$secKey}_glass_opacity", 90))),
                'align'         => Setting::get("home_{$secKey}_align", 'left'),
                'width'         => Setting::get("home_{$secKey}_width", 'container'),
                'padding'       => Setting::get("home_{$secKey}_padding", 'standard'),
            ];
        }

        // Load Custom Sections
        $this->customSections = Setting::getJson('home_custom_sections', []);
        foreach ($this->customSections as $cKey => $cData) {
            $this->sectionStylers[$cKey] = [
                'bg_type'       => $cData['bg_type'] ?? 'theme_default',
                'bg_light'      => $cData['bg_light'] ?? '#ffffff',
                'bg_dark'       => $cData['bg_dark'] ?? '#0b1b2b',
                'gradient_dir'  => $cData['gradient_dir'] ?? '135deg',
                'gradient_from' => $cData['gradient_from'] ?? '#002538',
                'gradient_to'   => $cData['gradient_to'] ?? '#07131e',
                'glass_opacity' => max(10, min(90, (int) ($cData['glass_opacity'] ?? 90))),
                'align'         => $cData['align'] ?? 'left',
                'width'         => $cData['width'] ?? 'container',
                'padding'       => $cData['padding'] ?? 'standard',
            ];
        }

        // Sections Enabled map
        $this->sectionsEnabled = [
            'partners'    => $this->partners_enabled,
            'about'       => $this->about_enabled,
            'services'    => $this->services_enabled,
            'video_break' => $this->video_break_enabled,
            'blueprint'   => $this->blueprint_enabled,
            'projects'    => $this->projects_enabled,
            'videos'      => $this->videos_enabled,
            'photos'      => $this->photos_enabled,
            'metrics'     => $this->metrics_enabled,
            'parts'       => $this->parts_enabled,
            'rfq'         => $this->rfq_enabled,
        ];

        foreach ($this->customSections as $cKey => $cData) {
            $this->sectionsEnabled[$cKey] = (bool) ($cData['is_enabled'] ?? true);
        }
    }

    public function selectSection(string $section): void
    {
        $allowed = array_merge(['header', 'hero', 'footer'], self::DEFAULT_SECTIONS_ORDER);
        if (in_array($section, $allowed) || str_starts_with($section, 'custom_')) {
            $this->selectedSection = $section;
        }
    }

    public function moveSectionUp(string $key): void
    {
        $index = array_search($key, $this->sectionsOrder);
        if ($index !== false && $index > 0) {
            $temp = $this->sectionsOrder[$index - 1];
            $this->sectionsOrder[$index - 1] = $this->sectionsOrder[$index];
            $this->sectionsOrder[$index] = $temp;
            $this->sectionsOrder = array_values($this->sectionsOrder);
            Setting::set('home_sections_order', json_encode($this->sectionsOrder), 'homepage', 'json');
            $this->dispatch('flash-message', [
                'type' => 'success',
                'message' => 'Homepage sections reordered successfully.',
            ]);
        }
    }

    public function moveSectionDown(string $key): void
    {
        $index = array_search($key, $this->sectionsOrder);
        if ($index !== false && $index < count($this->sectionsOrder) - 1) {
            $temp = $this->sectionsOrder[$index + 1];
            $this->sectionsOrder[$index + 1] = $this->sectionsOrder[$index];
            $this->sectionsOrder[$index] = $temp;
            $this->sectionsOrder = array_values($this->sectionsOrder);
            Setting::set('home_sections_order', json_encode($this->sectionsOrder), 'homepage', 'json');
            $this->dispatch('flash-message', [
                'type' => 'success',
                'message' => 'Homepage sections reordered successfully.',
            ]);
        }
    }

    public function toggleSectionEnabled(string $key): void
    {
        if (array_key_exists($key, $this->sectionsEnabled)) {
            $newState = !($this->sectionsEnabled[$key] ?? true);
            $this->sectionsEnabled[$key] = $newState;
            if (str_starts_with($key, 'custom_') && isset($this->customSections[$key])) {
                $this->customSections[$key]['is_enabled'] = $newState;
                Setting::set('home_custom_sections', json_encode($this->customSections), 'homepage', 'json');
            } else {
                $prop = $key . '_enabled';
                if (property_exists($this, $prop)) {
                    $this->{$prop} = $newState;
                }
                Setting::set('home_' . $key . '_enabled', $newState ? '1' : '0');
            }
            $this->dispatch('flash-message', [
                'type' => 'success',
                'message' => ucfirst(str_replace('_', ' ', $key)) . ' visibility toggled.',
            ]);
        }
    }

    public function resetSectionsOrder(): void
    {
        $this->sectionsOrder = self::DEFAULT_SECTIONS_ORDER;
        Setting::set('home_sections_order', json_encode($this->sectionsOrder), 'homepage', 'json');
        $this->dispatch('flash-message', [
            'type' => 'success',
            'message' => 'Homepage section order reset to corporate standard defaults.',
        ]);
    }

    // ==========================================
    // CUSTOM SECTIONS MANAGEMENT
    // ==========================================
    public function openAddSectionModal(): void
    {
        $this->newSectionTitle = '';
        $this->newSectionType = 'content_block';
        $this->showAddSectionModal = true;
    }

    public function closeAddSectionModal(): void
    {
        $this->showAddSectionModal = false;
    }

    public function addCustomSection(): void
    {
        $title = trim($this->newSectionTitle);
        if (empty($title)) {
            $this->addError('newSectionTitle', 'Section title is required.');
            return;
        }

        $id = 'custom_' . time();
        $this->customSections[$id] = [
            'id' => $id,
            'title' => $title,
            'type' => $this->newSectionType,
            'badge' => 'Special Capability',
            'subtitle' => 'Customized corporate module configured via Homepage Builder.',
            'content' => 'High-precision engineering and overhaul operations executed with certified metallurgical integrity.',
            'is_enabled' => true,
            'cta1_text' => 'Explore Services →',
            'cta1_url' => '/services',
            'cta2_text' => 'Contact Duty Desk',
            'cta2_url' => '/contact',
            'features' => [
                ['title' => 'Calibrated Precision', 'desc' => 'High quality marine engineering feature with certified tolerance test sheets.', 'icon' => 'solid:shield-check'],
                ['title' => 'Turn-Key Reliability', 'desc' => 'Precision laser inspection and dynamic balancing up to 100,000 RPM.', 'icon' => 'solid:gauge'],
                ['title' => '24/7 Rapid Mobilization', 'desc' => 'Global outer anchorage and berth call emergency response squads.', 'icon' => 'solid:anchor'],
            ],
            'faqs' => [
                ['question' => 'What is the standard turnaround time for emergency port calls?', 'answer' => 'Emergency flying squads are mobilized within 60 minutes for outer anchorage or container terminal calls.'],
                ['question' => 'Are non-destructive testing reports certified by classification societies?', 'answer' => 'Yes, all balancing and NDT reports are certified according to DNV and Lloyd\'s Register standards.'],
            ],
            'html_content' => '<div class="p-8 text-center text-slate-500 font-mono text-xs">Custom HTML Content Block</div>',
        ];

        $this->sectionStylers[$id] = [
            'bg_type' => 'theme_default',
            'bg_light' => '#ffffff',
            'bg_dark' => '#0b1b2b',
            'gradient_dir' => '135deg',
            'gradient_from' => '#002538',
            'gradient_to' => '#07131e',
            'glass_opacity' => 90,
            'align' => 'left',
            'width' => 'container',
            'padding' => 'standard',
        ];

        $this->sectionsOrder[] = $id;
        $this->sectionsEnabled[$id] = true;

        Setting::set('home_custom_sections', json_encode($this->customSections), 'homepage', 'json');
        Setting::set('home_sections_order', json_encode($this->sectionsOrder), 'homepage', 'json');
        $this->saveSectionStyler($id);

        $this->showAddSectionModal = false;
        $this->selectedSection = $id;

        $this->dispatch('flash-message', [
            'type' => 'success',
            'message' => "Custom section '{$title}' added successfully.",
        ]);
    }

    public function removeCustomSection(string $id): void
    {
        if (isset($this->customSections[$id])) {
            unset($this->customSections[$id]);
            unset($this->sectionStylers[$id]);
            unset($this->sectionsEnabled[$id]);
            $this->sectionsOrder = array_values(array_filter($this->sectionsOrder, fn($k) => $k !== $id));

            Setting::set('home_custom_sections', json_encode($this->customSections), 'homepage', 'json');
            Setting::set('home_sections_order', json_encode($this->sectionsOrder), 'homepage', 'json');

            if ($this->selectedSection === $id) {
                $this->selectedSection = 'header';
            }

            $this->dispatch('flash-message', [
                'type' => 'success',
                'message' => 'Custom section deleted successfully.',
            ]);
        }
    }

    public function saveCustomSection(string $id): void
    {
        if (!isset($this->customSections[$id])) return;

        if (isset($this->sectionStylers[$id])) {
            $styler = $this->sectionStylers[$id];
            $this->customSections[$id]['bg_type'] = $styler['bg_type'] ?? 'theme_default';
            $this->customSections[$id]['bg_light'] = $styler['bg_light'] ?? '#ffffff';
            $this->customSections[$id]['bg_dark'] = $styler['bg_dark'] ?? '#0b1b2b';
            $this->customSections[$id]['gradient_dir'] = $styler['gradient_dir'] ?? '135deg';
            $this->customSections[$id]['gradient_from'] = $styler['gradient_from'] ?? '#002538';
            $this->customSections[$id]['gradient_to'] = $styler['gradient_to'] ?? '#07131e';
            $this->customSections[$id]['glass_opacity'] = $styler['glass_opacity'] ?? 90;
            $this->customSections[$id]['align'] = $styler['align'] ?? 'left';
            $this->customSections[$id]['width'] = $styler['width'] ?? 'container';
            $this->customSections[$id]['padding'] = $styler['padding'] ?? 'standard';
        }

        Setting::set('home_custom_sections', json_encode($this->customSections), 'homepage', 'json');
        $this->saveSectionStyler($id);

        session()->flash('message', 'Custom section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Custom section saved.']);
    }

    public function addCustomSectionFeature(string $id): void
    {
        if (isset($this->customSections[$id])) {
            $this->customSections[$id]['features'][] = [
                'title' => 'New Engineering Feature',
                'desc' => 'Detailed technical specification and capability note.',
                'icon' => 'solid:circle-check',
            ];
        }
    }

    public function removeCustomSectionFeature(string $id, int $index): void
    {
        if (isset($this->customSections[$id]['features'][$index])) {
            unset($this->customSections[$id]['features'][$index]);
            $this->customSections[$id]['features'] = array_values($this->customSections[$id]['features']);
        }
    }

    public function addCustomSectionFaq(string $id): void
    {
        if (isset($this->customSections[$id])) {
            $this->customSections[$id]['faqs'][] = [
                'question' => 'New Question Title?',
                'answer' => 'Answer detailing corporate operational procedures.',
            ];
        }
    }

    public function removeCustomSectionFaq(string $id, int $index): void
    {
        if (isset($this->customSections[$id]['faqs'][$index])) {
            unset($this->customSections[$id]['faqs'][$index]);
            $this->customSections[$id]['faqs'] = array_values($this->customSections[$id]['faqs']);
        }
    }

    // ==========================================
    // UNIVERSAL SECTION STYLER SAVE METHOD
    // ==========================================
    public function saveSectionStyler(string $key): void
    {
        if (!isset($this->sectionStylers[$key])) return;
        $styler = $this->sectionStylers[$key];
        Setting::set("home_{$key}_bg_type", $styler['bg_type'] ?? 'theme_default');
        Setting::set("home_{$key}_bg_light", $styler['bg_light'] ?? '#ffffff');
        Setting::set("home_{$key}_bg_dark", $styler['bg_dark'] ?? '#0b1b2b');
        Setting::set("home_{$key}_gradient_dir", $styler['gradient_dir'] ?? '135deg');
        Setting::set("home_{$key}_gradient_from", $styler['gradient_from'] ?? '#002538');
        Setting::set("home_{$key}_gradient_to", $styler['gradient_to'] ?? '#07131e');
        Setting::set("home_{$key}_glass_opacity", max(10, min(90, (int) ($styler['glass_opacity'] ?? 90))));
        Setting::set("home_{$key}_align", $styler['align'] ?? 'left');
        Setting::set("home_{$key}_width", $styler['width'] ?? 'container');
        Setting::set("home_{$key}_padding", $styler['padding'] ?? 'standard');
    }

    // ==========================================
    // STATIC SECTIONS REPEATERS METHODS
    // ==========================================
    public function addStaticService(): void
    {
        $this->services_static_items[] = [
            'title' => 'New Precision Overhaul Service',
            'category' => 'CAPABILITY',
            'icon' => 'solid:wrench',
            'excerpt' => 'Description of specialized marine engineering capabilities.',
            'url' => '/services',
        ];
    }
    public function removeStaticService(int $index): void
    {
        if (isset($this->services_static_items[$index])) {
            unset($this->services_static_items[$index]);
            $this->services_static_items = array_values($this->services_static_items);
        }
    }

    public function addStaticPart(): void
    {
        $this->parts_static_items[] = [
            'name' => 'New OEM Replacement Part',
            'part_number' => 'OEM Standard Specification',
            'icon' => 'solid:gears',
            'url' => '/products',
        ];
    }
    public function removeStaticPart(int $index): void
    {
        if (isset($this->parts_static_items[$index])) {
            unset($this->parts_static_items[$index]);
            $this->parts_static_items = array_values($this->parts_static_items);
        }
    }

    public function addStaticPhoto(): void
    {
        $this->photos_static_items[] = [
            'title' => 'Workshop Facility Inspection',
            'subtitle' => 'High-Precision Bay',
            'image_url' => 'assets/images/gallery/gallery-balancing.webp',
        ];
    }
    public function removeStaticPhoto(int $index): void
    {
        if (isset($this->photos_static_items[$index])) {
            unset($this->photos_static_items[$index]);
            $this->photos_static_items = array_values($this->photos_static_items);
        }
    }

    public function addStaticVideo(): void
    {
        $this->videos_static_items[] = [
            'title' => 'Engineering Balancing Procedure',
            'category' => 'PROCEDURE',
            'description' => 'Real-time procedure demonstration with dynamic sensor readouts.',
            'video_url' => 'assets/videos/background-marine.mp4',
            'thumbnail_url' => 'assets/images/gallery/gallery-balancing.webp',
        ];
    }
    public function removeStaticVideo(int $index): void
    {
        if (isset($this->videos_static_items[$index])) {
            unset($this->videos_static_items[$index]);
            $this->videos_static_items = array_values($this->videos_static_items);
        }
    }

    public function addMetricItem(): void
    {
        $this->metrics_items[] = [
            'value' => '100%',
            'label' => 'New Metric Milestone',
            'icon' => 'solid:chart-simple',
        ];
    }
    public function removeMetricItem(int $index): void
    {
        if (isset($this->metrics_items[$index])) {
            unset($this->metrics_items[$index]);
            $this->metrics_items = array_values($this->metrics_items);
        }
    }

    public function addFooterCol2Link(): void
    {
        $this->footer_col2_links[] = [
            'text' => 'New Navigation Link',
            'url' => '/products',
        ];
    }
    public function removeFooterCol2Link(int $index): void
    {
        if (isset($this->footer_col2_links[$index])) {
            unset($this->footer_col2_links[$index]);
            $this->footer_col2_links = array_values($this->footer_col2_links);
        }
    }

    public function addFooterCol3Link(): void
    {
        $this->footer_col3_links[] = [
            'text' => 'New Navigation Link',
            'url' => '/services',
        ];
    }
    public function removeFooterCol3Link(int $index): void
    {
        if (isset($this->footer_col3_links[$index])) {
            unset($this->footer_col3_links[$index]);
            $this->footer_col3_links = array_values($this->footer_col3_links);
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
        Setting::set('home_hero_title_size', $this->hero_title_size);
        Setting::set('home_hero_title_weight', $this->hero_title_weight);
        Setting::set('home_hero_title_glow', $this->hero_title_glow);
        Setting::set('home_hero_title_grad_dir', $this->hero_title_grad_dir);
        Setting::set('home_hero_title_grad_from', trim($this->hero_title_grad_from));
        Setting::set('home_hero_title_grad_via', trim($this->hero_title_grad_via));
        Setting::set('home_hero_title_grad_to', trim($this->hero_title_grad_to));
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
        Setting::set('home_hero_notice_link_type', $this->hero_notice_link_type);

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
        Setting::set('home_hero_visual_padding', $this->hero_visual_padding);
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

    public function savePartners(): void
    {
        Setting::set('home_partners_enabled', $this->partners_enabled ? '1' : '0');
        Setting::set('home_partners_tagline', trim($this->partners_tagline));
        Setting::set('home_partners_mode', $this->partners_mode);
        Setting::set('home_partners_speed', $this->partners_speed);
        Setting::set('home_partners_bg_style', $this->partners_bg_style);
        Setting::set('home_partners_brands_list', trim($this->partners_brands_list));

        $this->saveSectionStyler('partners');
        $this->sectionsEnabled['partners'] = $this->partners_enabled;
        session()->flash('message', 'Partners & OEM Ticker section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Partners section saved.']);
    }

    public function saveAbout(): void
    {
        Setting::set('home_about_enabled', $this->about_enabled ? '1' : '0');
        Setting::set('home_about_badge', trim($this->about_badge));
        Setting::set('home_about_title', trim($this->about_title));
        Setting::set('home_about_description', trim($this->about_description));

        Setting::set('home_about_p1_icon', trim($this->about_p1_icon));
        Setting::set('home_about_p1_title', trim($this->about_p1_title));
        Setting::set('home_about_p1_desc', trim($this->about_p1_desc));

        Setting::set('home_about_p2_icon', trim($this->about_p2_icon));
        Setting::set('home_about_p2_title', trim($this->about_p2_title));
        Setting::set('home_about_p2_desc', trim($this->about_p2_desc));

        Setting::set('home_about_p3_icon', trim($this->about_p3_icon));
        Setting::set('home_about_p3_title', trim($this->about_p3_title));
        Setting::set('home_about_p3_desc', trim($this->about_p3_desc));

        Setting::set('home_about_quote_text', trim($this->about_quote_text));
        Setting::set('home_about_quote_author', trim($this->about_quote_author));
        Setting::set('home_about_quote_role', trim($this->about_quote_role));
        Setting::set('home_about_quote_initials', trim($this->about_quote_initials));

        $this->saveSectionStyler('about');
        $this->sectionsEnabled['about'] = $this->about_enabled;
        session()->flash('message', 'About Us & Pillars section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'About Us section saved.']);
    }

    public function saveServices(): void
    {
        Setting::set('home_services_enabled', $this->services_enabled ? '1' : '0');
        Setting::set('home_services_badge', trim($this->services_badge));
        Setting::set('home_services_title', trim($this->services_title));
        Setting::set('home_services_subtitle', trim($this->services_subtitle));
        Setting::set('home_services_mode', $this->services_mode);
        Setting::set('home_services_limit', (string) max(1, min(24, (int) $this->services_limit)));
        Setting::set('home_services_static_items', json_encode(array_values($this->services_static_items)), 'homepage', 'json');

        $this->saveSectionStyler('services');
        $this->sectionsEnabled['services'] = $this->services_enabled;
        session()->flash('message', 'Precision Services section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Services section saved.']);
    }

    public function saveVideoBreak(): void
    {
        Setting::set('home_video_break_enabled', $this->video_break_enabled ? '1' : '0');
        Setting::set('home_video_break_badge', trim($this->video_break_badge));
        Setting::set('home_video_break_heading', trim($this->video_break_heading));
        Setting::set('home_video_break_subtitle', trim($this->video_break_subtitle));
        Setting::set('home_video_break_cta1_text', trim($this->video_break_cta1_text));
        Setting::set('home_video_break_cta1_url', trim($this->video_break_cta1_url));
        Setting::set('home_video_break_cta2_text', trim($this->video_break_cta2_text));
        Setting::set('home_video_break_cta2_url', trim($this->video_break_cta2_url));

        $this->saveSectionStyler('video_break');
        $this->sectionsEnabled['video_break'] = $this->video_break_enabled;
        session()->flash('message', 'Marine Video Window Break section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Video Break saved.']);
    }

    public function saveBlueprint(): void
    {
        Setting::set('home_blueprint_enabled', $this->blueprint_enabled ? '1' : '0');
        Setting::set('home_blueprint_badge', trim($this->blueprint_badge));
        Setting::set('home_blueprint_title', trim($this->blueprint_title));
        Setting::set('home_blueprint_subtitle', trim($this->blueprint_subtitle));

        Setting::set('home_blueprint_mission_icon', trim($this->blueprint_mission_icon));
        Setting::set('home_blueprint_mission_title', trim($this->blueprint_mission_title));
        Setting::set('home_blueprint_mission_desc', trim($this->blueprint_mission_desc));

        Setting::set('home_blueprint_vision_icon', trim($this->blueprint_vision_icon));
        Setting::set('home_blueprint_vision_title', trim($this->blueprint_vision_title));
        Setting::set('home_blueprint_vision_desc', trim($this->blueprint_vision_desc));

        Setting::set('home_blueprint_values_icon', trim($this->blueprint_values_icon));
        Setting::set('home_blueprint_values_title', trim($this->blueprint_values_title));
        Setting::set('home_blueprint_value1', trim($this->blueprint_value1));
        Setting::set('home_blueprint_value2', trim($this->blueprint_value2));
        Setting::set('home_blueprint_value3', trim($this->blueprint_value3));

        $this->saveSectionStyler('blueprint');
        $this->sectionsEnabled['blueprint'] = $this->blueprint_enabled;
        session()->flash('message', 'Corporate Blueprint (Mission & Vision) saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Blueprint saved.']);
    }

    public function saveProjects(): void
    {
        Setting::set('home_projects_enabled', $this->projects_enabled ? '1' : '0');
        Setting::set('home_projects_badge', trim($this->projects_badge));
        Setting::set('home_projects_title', trim($this->projects_title));
        Setting::set('home_projects_subtitle', trim($this->projects_subtitle));

        $this->saveSectionStyler('projects');
        $this->sectionsEnabled['projects'] = $this->projects_enabled;
        session()->flash('message', 'Featured Projects section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Projects section saved.']);
    }

    public function saveVideos(): void
    {
        Setting::set('home_videos_enabled', $this->videos_enabled ? '1' : '0');
        Setting::set('home_videos_badge', trim($this->videos_badge));
        Setting::set('home_videos_title', trim($this->videos_title));
        Setting::set('home_videos_subtitle', trim($this->videos_subtitle));
        Setting::set('home_videos_mode', $this->videos_mode);
        Setting::set('home_videos_limit', (string) max(1, min(12, (int) $this->videos_limit)));
        Setting::set('home_videos_static_items', json_encode(array_values($this->videos_static_items)), 'homepage', 'json');

        $this->saveSectionStyler('videos');
        $this->sectionsEnabled['videos'] = $this->videos_enabled;
        session()->flash('message', 'Video Gallery section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Video Gallery saved.']);
    }

    public function savePhotos(): void
    {
        Setting::set('home_photos_enabled', $this->photos_enabled ? '1' : '0');
        Setting::set('home_photos_badge', trim($this->photos_badge));
        Setting::set('home_photos_title', trim($this->photos_title));
        Setting::set('home_photos_subtitle', trim($this->photos_subtitle));
        Setting::set('home_photos_mode', $this->photos_mode);
        Setting::set('home_photos_limit', (string) max(1, min(24, (int) $this->photos_limit)));
        Setting::set('home_photos_static_items', json_encode(array_values($this->photos_static_items)), 'homepage', 'json');

        $this->saveSectionStyler('photos');
        $this->sectionsEnabled['photos'] = $this->photos_enabled;
        session()->flash('message', 'Photo Gallery section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Photo Gallery saved.']);
    }

    public function saveMetrics(): void
    {
        Setting::set('home_metrics_enabled', $this->metrics_enabled ? '1' : '0');
        Setting::set('home_metrics_stat1_val', trim($this->metric_counter1_val));
        Setting::set('home_metrics_stat1_lbl', trim($this->metric_counter1_lbl));
        Setting::set('home_metrics_stat2_val', trim($this->metric_counter2_val));
        Setting::set('home_metrics_stat2_lbl', trim($this->metric_counter2_lbl));
        Setting::set('home_metrics_stat3_val', trim($this->metric_counter3_val));
        Setting::set('home_metrics_stat3_lbl', trim($this->metric_counter3_lbl));
        Setting::set('home_metrics_stat4_val', trim($this->metric_counter4_val));
        Setting::set('home_metrics_stat4_lbl', trim($this->metric_counter4_lbl));
        Setting::set('home_metrics_items', json_encode(array_values($this->metrics_items)), 'homepage', 'json');

        $this->saveSectionStyler('metrics');
        $this->sectionsEnabled['metrics'] = $this->metrics_enabled;
        session()->flash('message', 'Metrics Counters section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Metrics section saved.']);
    }

    public function saveParts(): void
    {
        Setting::set('home_parts_enabled', $this->parts_enabled ? '1' : '0');
        Setting::set('home_parts_badge', trim($this->parts_badge));
        Setting::set('home_parts_title', trim($this->parts_title));
        Setting::set('home_parts_subtitle', trim($this->parts_subtitle));
        Setting::set('home_parts_mode', $this->parts_mode);
        Setting::set('home_parts_limit', (string) max(1, min(24, (int) $this->parts_limit)));
        Setting::set('home_parts_static_items', json_encode(array_values($this->parts_static_items)), 'homepage', 'json');

        $this->saveSectionStyler('parts');
        $this->sectionsEnabled['parts'] = $this->parts_enabled;
        session()->flash('message', 'Genuine Spare Parts section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Parts section saved.']);
    }

    public function saveRfq(): void
    {
        Setting::set('home_rfq_enabled', $this->rfq_enabled ? '1' : '0');
        Setting::set('home_rfq_badge', trim($this->rfq_badge));
        Setting::set('home_rfq_title', trim($this->rfq_title));
        Setting::set('home_rfq_subtitle', trim($this->rfq_subtitle));
        Setting::set('home_rfq_btn_text', trim($this->rfq_btn_text));

        $this->saveSectionStyler('rfq');
        $this->sectionsEnabled['rfq'] = $this->rfq_enabled;
        session()->flash('message', '24/7 Operations RFQ Desk section saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'RFQ Desk saved.']);
    }

    public function saveFooter(): void
    {
        Setting::set('home_footer_enabled', $this->footer_enabled ? '1' : '0');
        Setting::set('home_footer_show_logo', $this->footer_show_logo ? '1' : '0');
        Setting::set('home_footer_logo_type', $this->footer_logo_type);
        Setting::set('home_footer_custom_logo', trim($this->footer_custom_logo));
        Setting::set('home_footer_logo_height', $this->footer_logo_height);

        Setting::set('home_footer_col1_enabled', $this->footer_col1_enabled ? '1' : '0');
        Setting::set('home_footer_col2_enabled', $this->footer_col2_enabled ? '1' : '0');
        Setting::set('home_footer_col3_enabled', $this->footer_col3_enabled ? '1' : '0');
        Setting::set('home_footer_col4_enabled', $this->footer_col4_enabled ? '1' : '0');

        Setting::set('home_footer_bio', trim($this->footer_bio));
        Setting::set('home_footer_show_social', $this->footer_show_social ? '1' : '0');
        Setting::set('home_footer_cert_text', trim($this->footer_cert_text));
        Setting::set('home_footer_col2_title', trim($this->footer_col2_title));
        Setting::set('home_footer_col2_mode', $this->footer_col2_mode);
        Setting::set('home_footer_col2_menu_id', $this->footer_col2_menu_id ? (string) $this->footer_col2_menu_id : '');
        Setting::set('home_footer_col2_links', json_encode(array_values($this->footer_col2_links)), 'homepage', 'json');

        Setting::set('home_footer_col3_title', trim($this->footer_col3_title));
        Setting::set('home_footer_col3_mode', $this->footer_col3_mode);
        Setting::set('home_footer_col3_menu_id', $this->footer_col3_menu_id ? (string) $this->footer_col3_menu_id : '');
        Setting::set('home_footer_col3_links', json_encode(array_values($this->footer_col3_links)), 'homepage', 'json');

        Setting::set('home_footer_col4_title', trim($this->footer_col4_title));
        Setting::set('home_footer_workshop_addr', trim($this->footer_workshop_addr));
        Setting::set('home_footer_hq_addr', trim($this->footer_hq_addr));
        Setting::set('home_footer_phone', trim($this->footer_phone));
        Setting::set('home_footer_email', trim($this->footer_email));
        Setting::set('home_footer_show_phone', $this->footer_show_phone ? '1' : '0');
        Setting::set('home_footer_show_email', $this->footer_show_email ? '1' : '0');
        Setting::set('home_footer_copyright', trim($this->footer_copyright));
        Setting::set('home_footer_show_login', $this->footer_show_login ? '1' : '0');

        session()->flash('message', 'Corporate Footer Studio saved successfully.');
        $this->dispatch('flash-message', ['type' => 'success', 'message' => 'Corporate Footer saved.']);
    }

    public function saveCurrentSection(): void
    {
        if (str_starts_with($this->selectedSection, 'custom_')) {
            $this->saveCustomSection($this->selectedSection);
            return;
        }

        match ($this->selectedSection) {
            'header'      => $this->saveHeader(),
            'hero'        => $this->saveHero(),
            'partners'    => $this->savePartners(),
            'about'       => $this->saveAbout(),
            'services'    => $this->saveServices(),
            'video_break' => $this->saveVideoBreak(),
            'blueprint'   => $this->saveBlueprint(),
            'projects'    => $this->saveProjects(),
            'videos'      => $this->saveVideos(),
            'photos'      => $this->savePhotos(),
            'metrics'     => $this->saveMetrics(),
            'parts'       => $this->saveParts(),
            'rfq'         => $this->saveRfq(),
            'footer'      => $this->saveFooter(),
            default       => $this->saveHeader(),
        };
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
        $this->hero_title_size      = 'standard';
        $this->hero_title_weight    = 'black';
        $this->hero_title_glow      = 'none';
        $this->hero_title_grad_dir  = '135deg';
        $this->hero_title_grad_from = '#00d2ff';
        $this->hero_title_grad_via  = '#0084ff';
        $this->hero_title_grad_to   = '#003C58';
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
        $this->hero_notice_link_type = 'internal';

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
        $this->hero_visual_padding  = 'spacious';
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

        // Reset Sections Order
        $this->sectionsOrder = self::DEFAULT_SECTIONS_ORDER;
        Setting::set('home_sections_order', json_encode($this->sectionsOrder), 'homepage', 'json');

        // 1. Partners
        $this->partners_enabled     = true;
        $this->partners_tagline     = 'Multi-Brand Authorized Engineering & Overhauls For Global OEM Platforms';
        $this->partners_mode        = 'static';
        $this->partners_speed       = 'normal';
        $this->partners_bg_style    = 'theme_default';
        $this->partners_brands_list = 'Accelleron (ABB), MAN Energy Solutions, KBB Kompressorenbau, Napier Turbochargers, Mitsubishi Heavy Industries (MET), PBS Turbo, INNIO Waukesha, Ariel Compressors';
        $this->savePartners();

        // 2. About
        $this->about_enabled        = true;
        $this->about_badge          = 'Conglomerate Heritage & Vision';
        $this->about_title          = 'A Heritage of Heavy Industrial Power, Maritime Integrity, & Turn-Key Engineering.';
        $this->about_description    = 'Operating under the high standards of global marine engineering, Nordroy Marine & Turbochargers unites heavy mechanical overhaul workshops, non-destructive metallurgical testing (NDT), dynamic rotor calibration, and comprehensive spare parts logistics under one unified corporate umbrella.';
        $this->about_p1_icon        = 'solid:anchor';
        $this->about_p1_title       = 'Global Port Reach';
        $this->about_p1_desc        = '24/7 flying squads equipped for anchorage and berth call overhauls.';
        $this->about_p2_icon        = 'solid:gauge-high';
        $this->about_p2_title       = 'Calibrated Precision';
        $this->about_p2_desc        = 'Computerized Schenck dynamic balancing up to 100,000 RPM.';
        $this->about_p3_icon        = 'solid:certificate';
        $this->about_p3_title       = 'OEM Alliances';
        $this->about_p3_desc        = 'Direct access to genuine replacement parts and calibrated drawings.';
        $this->about_quote_text     = '"In maritime logistics and heavy power generation, downtime is measured in thousands of dollars per hour. Our mission is to restore engine efficiency with zero deviation from OEM tolerances."';
        $this->about_quote_author   = 'Technical Operations';
        $this->about_quote_role     = 'Turbomachinery Overhaul Division';
        $this->about_quote_initials = 'NR';
        $this->saveAbout();

        // 3. Services
        $this->services_enabled     = true;
        $this->services_badge       = 'Workshop & Port Capabilities';
        $this->services_title       = 'Precision Overhaul Services';
        $this->services_subtitle    = 'Engineered according to manufacturer tolerance protocols with calibrated German Schenck balancing rigs.';
        $this->services_mode        = 'static';
        $this->services_limit       = 6;
        $this->saveServices();

        // 4. Video Break
        $this->video_break_enabled  = true;
        $this->video_break_badge    = 'Global Marine Engineering Excellence';
        $this->video_break_heading  = '24/7 Rapid Emergency Response Across 40+ International Ports';
        $this->video_break_subtitle = 'Our certified flying squads board commercial vessels at anchorage or alongside berths to deliver on-site turbocharger diagnostics, cartridge swap-outs, and dynamic balancing.';
        $this->video_break_cta1_text= 'View Overhaul Capabilities →';
        $this->video_break_cta1_url = '/services';
        $this->video_break_cta2_text= 'Contact Port Operations';
        $this->video_break_cta2_url = '/contact';
        $this->saveVideoBreak();

        // 5. Blueprint
        $this->blueprint_enabled    = true;
        $this->blueprint_badge      = 'Corporate Blueprint';
        $this->blueprint_title      = 'Mission, Vision & Core Values';
        $this->blueprint_subtitle   = 'Guiding principles that define our commitment to global shipowners, captive power operators, and heavy industries.';
        $this->blueprint_mission_icon = 'solid:bullseye';
        $this->blueprint_mission_title= 'Our Mission';
        $this->blueprint_mission_desc = 'To eliminate engine downtime by delivering certified, multi-brand turbocharger overhauls, high-speed dynamic balancing, and genuine OEM parts with unmatched turnaround speed, metallurgical precision, and total engineering transparency.';
        $this->blueprint_vision_icon  = 'solid:eye';
        $this->blueprint_vision_title = 'Our Vision 2030';
        $this->blueprint_vision_desc  = 'To be the premier independent maritime turbomachinery conglomerate in South Asia and global waters, recognized by international classification societies as the benchmark for quality, technical integrity, and decarbonization retrofits.';
        $this->blueprint_values_icon  = 'solid:shield-halved';
        $this->blueprint_values_title = 'Core Values';
        $this->blueprint_value1       = 'Zero-Defect Quality: Strict adherence to ISO 9001 protocols.';
        $this->blueprint_value2       = 'Rapid Port Agility: 24/7 readiness for urgent port calls.';
        $this->blueprint_value3       = 'Technical Rigor: Calibrated testing and certified reports.';
        $this->saveBlueprint();

        // 6. Projects
        $this->projects_enabled     = true;
        $this->projects_badge       = 'Execution Proven Track Record';
        $this->projects_title       = 'Featured Industrial & Marine Projects';
        $this->projects_subtitle    = 'A glimpse of recent turn-key overhauls completed on commercial ships and captive power plants.';
        $this->saveProjects();

        // 7. Videos
        $this->videos_enabled       = true;
        $this->videos_badge         = 'Workshop & Port In Action';
        $this->videos_title         = 'Video Gallery (Hover to Play)';
        $this->videos_subtitle      = 'Hover your mouse over any video card to stream a live silent preview of our precision balancing and overhaul operations.';
        $this->videos_mode          = 'static';
        $this->videos_limit         = 3;
        $this->saveVideos();

        // 8. Photos
        $this->photos_enabled       = true;
        $this->photos_badge         = 'Visual Facilities';
        $this->photos_title         = 'Workshop & Engineering Gallery';
        $this->photos_subtitle      = 'Click on any photo below to inspect high-resolution images of our port workshops and overhaul facilities.';
        $this->photos_mode          = 'static';
        $this->photos_limit         = 8;
        $this->savePhotos();

        // 9. Metrics
        $this->metrics_enabled      = true;
        $this->metric_counter1_val  = '30+';
        $this->metric_counter1_lbl  = 'Years of Excellence';
        $this->metric_counter2_val  = '1,450+';
        $this->metric_counter2_lbl  = 'Turbomachines Overhauled';
        $this->metric_counter3_val  = '12+';
        $this->metric_counter3_lbl  = 'Global Ports Covered';
        $this->metric_counter4_val  = '100%';
        $this->metric_counter4_lbl  = 'Calibrated Schenck Testing';
        $this->saveMetrics();

        // 10. Parts
        $this->parts_enabled        = true;
        $this->parts_badge          = 'OEM Replacement Inventory';
        $this->parts_title          = 'Genuine Spare Parts Catalog';
        $this->parts_subtitle       = 'Traceable serial numbers with mill test certificates ready for immediate dispatch.';
        $this->parts_mode           = 'static';
        $this->parts_limit          = 6;
        $this->saveParts();

        // 11. RFQ
        $this->rfq_enabled          = true;
        $this->rfq_badge            = '24/7 Operations Desk';
        $this->rfq_title            = 'Request Instant Quotation or Emergency Port Call';
        $this->rfq_subtitle         = 'Our duty marine engineering superintendents respond within 45 minutes of RFQ submission.';
        $this->rfq_btn_text         = 'Submit Technical RFQ to Duty Desk';
        $this->saveRfq();

        // Restore Static Repeaters
        $this->services_static_items = [
            ['title' => 'Dynamic Rotor Balancing (100k RPM)', 'category' => 'BALANCING', 'icon' => 'solid:gauge', 'excerpt' => 'Elimination of micro-vibrations with computerized dynamic balancing up to 100,000 RPM, certified with comprehensive tolerance test sheets.', 'url' => '/services#balancing'],
            ['title' => 'Turbine Blading & TIG Welding', 'category' => 'WELDING', 'icon' => 'solid:fire-flame-curved', 'excerpt' => 'Precision laser and micro-TIG rebuilding of eroded turbine blade profiles, shroud rings, and metallurgical crack restoration.', 'url' => '/services#overhaul'],
            ['title' => 'Cartridge (CHRA) Exchange', 'category' => 'CHRA', 'icon' => 'solid:arrows-rotate', 'excerpt' => 'Pre-assembled, factory-balanced cartridge replacement modules for rapid turnaround times during tight vessel port calls.', 'url' => '/services#cartridge'],
            ['title' => 'Ultrasonic Chemical Cleaning', 'category' => 'CHEMICAL', 'icon' => 'solid:spray-can', 'excerpt' => 'Multi-stage ultrasonic immersion tanks with specialized alkaline solvents to dissolve stubborn heavy fuel oil carbon deposits.', 'url' => '/services#ultrasonic'],
            ['title' => 'Bearing Journal Micro-Polishing', 'category' => 'MACHINING', 'icon' => 'solid:microchip', 'excerpt' => 'Superfinishing and micro-polishing of journal shaft bearing journals to mirror finish, ensuring hydrodynamic oil film integrity.', 'url' => '/services#bearing'],
            ['title' => '24/7 Port Emergency Flying Squads', 'category' => 'EMERGENCY', 'icon' => 'solid:helicopter', 'excerpt' => 'Mobilized within 60 minutes for outer anchorage or container terminal emergency berth call repairs and class society surveyor trials.', 'url' => '/contact#emergency'],
        ];
        $this->saveServices();

        $this->parts_static_items = [
            ['name' => 'Turbine Blades', 'part_number' => 'Nimonic 80A / 90', 'icon' => 'solid:fan', 'url' => '/products'],
            ['name' => 'Rotor Shafts', 'part_number' => 'Forged Alloy Steel', 'icon' => 'solid:circle-notch', 'url' => '/products'],
            ['name' => 'Nozzle Rings', 'part_number' => 'High-Temp Resistant', 'icon' => 'solid:ring', 'url' => '/products'],
            ['name' => 'Bearing Bushes', 'part_number' => 'Hydrodynamic Bronze', 'icon' => 'solid:compact-disc', 'url' => '/products'],
            ['name' => 'Sealing Bushes', 'part_number' => 'Labyrinth Alloy', 'icon' => 'solid:shield', 'url' => '/products'],
            ['name' => 'Compressor Wheels', 'part_number' => 'Milled Billet Ti/Al', 'icon' => 'solid:gear', 'url' => '/products'],
        ];
        $this->saveParts();

        $this->photos_static_items = [
            ['title' => 'Dynamic Balancing Bay', 'subtitle' => '100,000 RPM Schenck Rig', 'image_url' => 'assets/images/gallery/gallery-balancing.webp'],
            ['title' => 'Turbine Blading & Welding', 'subtitle' => 'Micro-TIG Rebuilding', 'image_url' => 'assets/images/gallery/gallery-welding.webp'],
            ['title' => 'CHRA Cartridge Assembly', 'subtitle' => 'Cleanroom Inspection', 'image_url' => 'assets/images/gallery/gallery-cartridge.webp'],
            ['title' => 'Ultrasonic Chemical Wash', 'subtitle' => 'Carbon Removal Baths', 'image_url' => 'assets/images/gallery/gallery-ultrasonic.webp'],
            ['title' => 'Compressor Wheel Machining', 'subtitle' => 'CNC 5-Axis Precision', 'image_url' => 'assets/images/gallery/gallery-cnc.webp'],
            ['title' => 'Non-Destructive Testing', 'subtitle' => 'Fluorescent Dye Penetrant', 'image_url' => 'assets/images/gallery/gallery-ndt.webp'],
            ['title' => 'Outer Anchorage Flying Squad', 'subtitle' => 'Container Vessel Boarding', 'image_url' => 'assets/images/gallery/gallery-shipboard.webp'],
            ['title' => 'Genuine OEM Spares Warehouse', 'subtitle' => 'Over 10,000 Spares in Stock', 'image_url' => 'assets/images/gallery/gallery-warehouse.webp'],
        ];
        $this->savePhotos();

        $this->videos_static_items = [
            ['title' => 'Dynamic Rotor Balancing at 100,000 RPM', 'category' => 'BALANCING PROCEDURE', 'description' => 'Real-time sensor vibration diagnostics on Schenck calibration rig.', 'video_url' => 'assets/videos/background-marine.mp4', 'thumbnail_url' => 'assets/images/gallery/gallery-balancing.webp'],
            ['title' => 'Precision TIG Shroud Ring & Blade Rebuilding', 'category' => 'WELDING & METALLURGY', 'description' => 'Laser-guided profile restoration on eroded high-temp exhaust gas blades.', 'video_url' => 'assets/videos/background-marine.mp4', 'thumbnail_url' => 'assets/images/gallery/gallery-welding.webp'],
            ['title' => '24/7 Outer Anchorage Emergency Squad Mobilization', 'category' => 'PORT CALL MOBILIZATION', 'description' => 'Marine flying squads boarding bulk carrier at Chattogram outer anchorage.', 'video_url' => 'assets/videos/background-marine.mp4', 'thumbnail_url' => 'assets/images/gallery/gallery-shipboard.webp'],
        ];
        $this->saveVideos();

        $this->metrics_items = [
            ['value' => '30+', 'label' => 'Years of Excellence', 'icon' => 'solid:award'],
            ['value' => '1,450+', 'label' => 'Turbomachines Overhauled', 'icon' => 'solid:gears'],
            ['value' => '12+', 'label' => 'Global Ports Covered', 'icon' => 'solid:anchor'],
            ['value' => '100%', 'label' => 'Calibrated Schenck Testing', 'icon' => 'solid:shield-check'],
        ];
        $this->saveMetrics();

        // Restore Universal Section Stylers
        foreach (self::DEFAULT_SECTIONS_ORDER as $secKey) {
            $this->sectionStylers[$secKey] = [
                'bg_type'       => 'theme_default',
                'bg_light'      => '#ffffff',
                'bg_dark'       => '#0b1b2b',
                'gradient_dir'  => '135deg',
                'gradient_from' => '#002538',
                'gradient_to'   => '#07131e',
                'glass_opacity' => 90,
                'align'         => 'left',
                'width'         => 'container',
                'padding'       => 'standard',
            ];
            $this->saveSectionStyler($secKey);
        }

        // 12. Footer
        $this->footer_enabled       = true;
        $this->footer_show_logo     = true;
        $this->footer_logo_type     = 'site_logo';
        $this->footer_custom_logo   = '';
        $this->footer_logo_height   = 40;
        $this->footer_col1_enabled  = true;
        $this->footer_col2_enabled  = true;
        $this->footer_col3_enabled  = true;
        $this->footer_col4_enabled  = true;
        $this->footer_col2_mode     = 'custom';
        $this->footer_col2_menu_id  = null;
        $this->footer_col2_links    = [
            ['text' => 'Turbine Blades & Rotors', 'url' => '/products'],
            ['text' => 'CHRA Replacement Cartridges', 'url' => '/products'],
            ['text' => 'Nozzle Rings & Diffusers', 'url' => '/products'],
            ['text' => 'Hydrodynamic Bearing Bushes', 'url' => '/products'],
            ['text' => 'Careers & Opportunities →', 'url' => '/careers'],
        ];
        $this->footer_col3_mode     = 'custom';
        $this->footer_col3_menu_id  = null;
        $this->footer_col3_links    = [
            ['text' => 'Dynamic Rotor Balancing', 'url' => '/services#balancing'],
            ['text' => 'Turbine Blading & Welding', 'url' => '/services#overhaul'],
            ['text' => 'Cartridge Reconditioning', 'url' => '/services#cartridge'],
            ['text' => 'Ultrasonic Chemical Cleaning', 'url' => '/services#ultrasonic'],
            ['text' => '24/7 Port Emergency Call', 'url' => '/services#flying-squad'],
        ];
        $this->footer_bio           = 'A premier industrial conglomerate and maritime engineering group specializing in authorized multi-brand exhaust gas turbocharger overhauls, dynamic rotor balancing up to 100,000 RPM, genuine OEM spare parts supply, and technical port assistance across global maritime hubs.';
        $this->footer_show_social   = true;
        $this->footer_cert_text     = 'ISO 9001:2015 & DNV Certified';
        $this->footer_col2_title    = 'OEM Spare Parts';
        $this->footer_col3_title    = 'Technical Services';
        $this->footer_col4_title    = 'Port & HQ Offices';
        $this->footer_workshop_addr = 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.';
        $this->footer_hq_addr       = 'Gulshan Industrial Area, Dhaka, Bangladesh';
        $this->footer_phone         = '+880 1800-000000';
        $this->footer_email         = 'operations@nordroy.com';
        $this->footer_show_phone    = true;
        $this->footer_show_email    = true;
        $this->footer_copyright     = '© 2026 Nordroy Marine & Turbochargers. All rights reserved. Maritime Engineering & Industrial Overhauls.';
        $this->footer_show_login    = true;
        $this->saveFooter();

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
            'internalLinkOptions'  => !empty($this->internalLinkOptions) ? $this->internalLinkOptions : $this->getInternalLinkOptions(),
        ]);
    }
}
