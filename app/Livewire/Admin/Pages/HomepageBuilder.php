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

    // Modular Custom Topbar Items Repeater
    public array $topbar_custom_items = [];
    public string $newCustomZone = 'left'; // 'left', 'right'
    public string $newCustomText = '';
    public string $newCustomIcon = 'solid:info';
    public string $newCustomUrl = '';
    public string $newCustomTarget = '_self'; // '_self', '_blank'

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
    public string $header_cta_icon = 'solid:clipboard-document-list';
    public string $header_cta_style = 'primary_gradient'; // 'primary_gradient', 'outline', 'solid_dark'

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
        $this->header_cta_icon          = Setting::get('header_cta_icon', 'solid:clipboard-document-list');
        $this->header_cta_style         = Setting::get('header_cta_style', 'primary_gradient');
    }

    public function selectSection(string $section): void
    {
        // Enforce focus strictly on 'header' as requested by user
        $this->selectedSection = 'header';
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

        $this->saveHeader();

        session()->flash('message', 'Real production design restored perfectly.');
        $this->dispatch('flash-message', [
            'type'    => 'success',
            'message' => 'Real production header design restored perfectly.',
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

    public function render()
    {
        $availableMenus = Menu::orderBy('name')->get();
        $selectedMenu = $this->header_menu_id ? Menu::with('rootItems.children')->find($this->header_menu_id) : null;

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
        ]);
    }
}
