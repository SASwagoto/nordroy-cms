<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Static Page Content Studio | Corporate CMS')]
class PageContentManager extends Component
{
    #[Url(as: 'page')]
    public string $activePage = 'about'; // 'about', 'contact', 'careers', 'services', 'products', 'gallery'

    /**
     * Dictionary of editable page contents and toggles
     */
    public array $content = [];

    // Repeater helper states: About
    public array $aboutPartners = [];
    public string $newPartnerBrand = '';
    public string $newPartnerModels = '';

    public array $aboutCertifications = [];
    public string $newCertName = '';

    // Dynamic Pillars: Careers
    public array $careersCultureCards = [];
    public string $newPillarTitle = '';
    public string $newPillarDesc = '';
    public string $newPillarIcon = 'solid:shield-check';
    public string $newPillarColor = 'cyan';

    // Dynamic Facilities / Workshop Locations: Contact
    public array $contactFacilities = [];
    public string $newFacilityBadge = 'Branch Workshop';
    public string $newFacilityTitle = '';
    public string $newFacilityAddress = '';
    public string $newFacilityDesc = '';
    public string $newFacilityPhone = '';
    public string $newFacilityEmail = '';
    public string $newFacilityEmergency = '';

    public function mount(): void
    {
        $this->loadPageContent();
    }

    public function setPage(string $page): void
    {
        if (in_array($page, ['about', 'contact', 'careers', 'services', 'products', 'gallery'])) {
            $this->activePage = $page;
            $this->loadPageContent();
        }
    }

    public function loadPageContent(): void
    {
        $defaults = $this->getDefaults();

        foreach ($defaults as $key => $defaultVal) {
            if (is_array($defaultVal)) {
                $this->content[$key] = Setting::getJson($key, $defaultVal);
            } elseif (is_bool($defaultVal)) {
                $val = Setting::get($key);
                $this->content[$key] = ($val === null) ? $defaultVal : (bool) $val;
            } else {
                $this->content[$key] = Setting::get($key, $defaultVal);
            }
        }

        $this->aboutPartners = $this->content['about_partners_list'] ?? [];
        $this->aboutCertifications = $this->content['about_cert_list'] ?? [];
        $this->careersCultureCards = $this->content['careers_culture_cards'] ?? [];
        $this->contactFacilities = $this->content['contact_facilities_list'] ?? [];
    }

    public function updatedContent($value, $key): void
    {
        // Enforce Frosted Glass opacity between 10% and 90% (Strictly forbidden: 0% and 100%)
        if (str_ends_with($key, '_header_frosted_opacity')) {
            $this->content[$key] = max(10, min(90, (int) $value));
        }
    }

    // ==========================================
    // REPEATER: CONTACT FACILITIES / WORKSHOPS
    // ==========================================
    public function addFacility(): void
    {
        $title = trim($this->newFacilityTitle);
        if (!empty($title)) {
            $this->contactFacilities[] = [
                'id'        => 'facility_' . time() . '_' . rand(10, 99),
                'badge'     => trim($this->newFacilityBadge) ?: 'Facility Location',
                'title'     => $title,
                'address'   => trim($this->newFacilityAddress),
                'desc'      => trim($this->newFacilityDesc),
                'phone'     => trim($this->newFacilityPhone),
                'email'     => trim($this->newFacilityEmail),
                'emergency' => trim($this->newFacilityEmergency),
                'is_active' => true,
            ];
            $this->content['contact_facilities_list'] = $this->contactFacilities;

            $this->newFacilityBadge = 'Branch Workshop';
            $this->newFacilityTitle = '';
            $this->newFacilityAddress = '';
            $this->newFacilityDesc = '';
            $this->newFacilityPhone = '';
            $this->newFacilityEmail = '';
            $this->newFacilityEmergency = '';
        }
    }

    public function removeFacility(int $index): void
    {
        if (isset($this->contactFacilities[$index])) {
            unset($this->contactFacilities[$index]);
            $this->contactFacilities = array_values($this->contactFacilities);
            $this->content['contact_facilities_list'] = $this->contactFacilities;
        }
    }

    public function toggleFacility(int $index): void
    {
        if (isset($this->contactFacilities[$index])) {
            $this->contactFacilities[$index]['is_active'] = !($this->contactFacilities[$index]['is_active'] ?? true);
            $this->content['contact_facilities_list'] = $this->contactFacilities;
        }
    }

    // ==========================================
    // REPEATER: DYNAMIC CAREER PILLARS
    // ==========================================
    public function addPillar(): void
    {
        $title = trim($this->newPillarTitle);
        $desc = trim($this->newPillarDesc);

        if (!empty($title)) {
            $this->careersCultureCards[] = [
                'id'        => 'pillar_' . time() . '_' . rand(10, 99),
                'title'     => $title,
                'desc'      => $desc,
                'icon'      => $this->newPillarIcon ?: 'solid:check-circle',
                'color'     => $this->newPillarColor ?: 'cyan',
                'is_active' => true,
            ];
            $this->content['careers_culture_cards'] = $this->careersCultureCards;

            $this->newPillarTitle = '';
            $this->newPillarDesc = '';
            $this->newPillarIcon = 'solid:shield-check';
            $this->newPillarColor = 'cyan';
        }
    }

    public function removePillar(int $index): void
    {
        if (isset($this->careersCultureCards[$index])) {
            unset($this->careersCultureCards[$index]);
            $this->careersCultureCards = array_values($this->careersCultureCards);
            $this->content['careers_culture_cards'] = $this->careersCultureCards;
        }
    }

    public function togglePillar(int $index): void
    {
        if (isset($this->careersCultureCards[$index])) {
            $this->careersCultureCards[$index]['is_active'] = !($this->careersCultureCards[$index]['is_active'] ?? true);
            $this->content['careers_culture_cards'] = $this->careersCultureCards;
        }
    }

    // ==========================================
    // REPEATER: ABOUT OEM PARTNERS
    // ==========================================
    public function addPartner(): void
    {
        $brand = trim($this->newPartnerBrand);
        $models = trim($this->newPartnerModels);

        if (!empty($brand)) {
            $this->aboutPartners[] = [
                'brand'     => $brand,
                'models'    => $models,
                'is_active' => true,
            ];
            $this->content['about_partners_list'] = $this->aboutPartners;
            $this->newPartnerBrand = '';
            $this->newPartnerModels = '';
        }
    }

    public function removePartner(int $index): void
    {
        if (isset($this->aboutPartners[$index])) {
            unset($this->aboutPartners[$index]);
            $this->aboutPartners = array_values($this->aboutPartners);
            $this->content['about_partners_list'] = $this->aboutPartners;
        }
    }

    public function togglePartner(int $index): void
    {
        if (isset($this->aboutPartners[$index])) {
            $this->aboutPartners[$index]['is_active'] = !($this->aboutPartners[$index]['is_active'] ?? true);
            $this->content['about_partners_list'] = $this->aboutPartners;
        }
    }

    // ==========================================
    // REPEATER: ABOUT CERTIFICATIONS
    // ==========================================
    public function addCertification(): void
    {
        $cert = trim($this->newCertName);
        if (!empty($cert)) {
            $this->aboutCertifications[] = $cert;
            $this->content['about_cert_list'] = $this->aboutCertifications;
            $this->newCertName = '';
        }
    }

    public function removeCertification(int $index): void
    {
        if (isset($this->aboutCertifications[$index])) {
            unset($this->aboutCertifications[$index]);
            $this->aboutCertifications = array_values($this->aboutCertifications);
            $this->content['about_cert_list'] = $this->aboutCertifications;
        }
    }

    // ==========================================
    // SAVE PAGE CONTENT
    // ==========================================
    public function saveContent(): void
    {
        $this->content['about_partners_list'] = $this->aboutPartners;
        $this->content['about_cert_list'] = $this->aboutCertifications;
        $this->content['careers_culture_cards'] = $this->careersCultureCards;
        $this->content['contact_facilities_list'] = $this->contactFacilities;

        // Ensure opacity is strictly between 10% and 90% (never 0% and never 100%)
        foreach ($this->content as $key => $val) {
            if (str_ends_with($key, '_header_frosted_opacity')) {
                $this->content[$key] = max(10, min(90, (int) $val));
            }
        }

        $group = 'page_' . $this->activePage;

        foreach ($this->content as $key => $val) {
            $type = is_array($val) ? 'json' : (is_bool($val) ? 'boolean' : 'text');
            $valToStore = is_bool($val) ? ($val ? '1' : '0') : $val;
            Setting::set($key, $valToStore, $group, $type);
        }

        Setting::flushCache();

        session()->flash('message', "Content and layout settings for '" . ucfirst($this->activePage) . "' page updated successfully.");
    }

    public function resetToDefaults(): void
    {
        $defaults = $this->getDefaults();

        foreach ($defaults as $key => $val) {
            $type = is_array($val) ? 'json' : (is_bool($val) ? 'boolean' : 'text');
            $valToStore = is_bool($val) ? ($val ? '1' : '0') : $val;
            Setting::set($key, $valToStore, 'page_' . $this->activePage, $type);
        }

        Setting::flushCache();
        $this->loadPageContent();

        session()->flash('message', "Default corporate copy and section toggles restored for '" . ucfirst($this->activePage) . "' page.");
    }

    private function getDefaults(): array
    {
        return [
            // ==================== ABOUT US ====================
            'about_header_bg'              => 'transparent', // 'transparent', 'frosted', 'solid', 'slate', 'gradient', 'custom'
            'about_header_frosted_opacity' => 80, // 10 to 90
            'about_header_light_bg'        => '#ffffff',
            'about_header_dark_bg'         => '#07131e',
            'about_header_light_text'      => '#0f172a',
            'about_header_dark_text'       => '#f8fafc',
            'about_badge'                  => 'About Nordroy Group',
            'about_hero_title'             => 'A Legacy of Maritime Precision & Heavy Industrial Power.',
            'about_hero_subtitle'          => 'Operating at the nexus of international shipping lanes and heavy industrial power utilities, Nordroy Marine & Turbochargers delivers certified multi-brand turbomachinery maintenance, NDT metallurgical verification, and prompt port dispatch.',
            
            // Section toggles for About
            'about_show_overview'          => true,
            'about_show_partners'          => true,
            'about_show_mission'           => true,
            'about_show_vision'            => true,
            'about_show_certifications'    => true,

            'about_overview_title'         => 'Engineered for High-Pressure Environments',
            'about_overview_p1'            => 'Modern exhaust gas turbochargers spin upwards of 100,000 RPM at temperatures exceeding 650°C. Even microscopic unbalance or metallurgical fatigue can trigger catastrophic engine failure and vessel arrest at port.',
            'about_overview_p2'            => 'Our specialized engineering facilities in Chattogram Port and Dhaka are equipped with German Schenck computerized balancing rigs, ultrasonic chemical cleaning lines, and ASNT Level III non-destructive testing benches to ensure that every overhauled component operates at zero deviation from OEM tolerances.',
            'about_stat1_value'            => '100k RPM',
            'about_stat1_label'            => 'Balancing Rig Capacity',
            'about_stat2_value'            => '± 0.005mm',
            'about_stat2_label'            => 'Shaft Run-Out Accuracy',

            'about_partners_title'         => 'Authorized OEM Partnerships',
            'about_partners_list'          => [
                ['brand' => 'Accelleron (ABB)', 'models' => 'VTR, TPL, TPS, A100 & TPR series overhauls.', 'is_active' => true],
                ['brand' => 'MAN Energy Solutions', 'models' => 'NR, NA, TCR, TCA & radial designs.', 'is_active' => true],
                ['brand' => 'KBB', 'models' => 'M40, R-series, and HPR industrial compressors.', 'is_active' => true],
                ['brand' => 'Mitsubishi Heavy Industries', 'models' => 'MET-SR, MET-SC & MET-MA models.', 'is_active' => true],
            ],

            'about_mission_title'          => 'Our Corporate Mission',
            'about_mission_text'           => 'To protect commercial maritime operations and heavy industrial power grids from catastrophic machinery downtime by delivering rapid, certified, and fully calibrated turbocharger overhauls with complete engineering integrity.',
            'about_vision_title'           => 'Vision 2030',
            'about_vision_text'            => "To serve as South Asia's pre-eminent center of excellence for turbomachinery dynamics, setting new industry standards in decarbonization retrofits, bio-fuel turbine adaptations, and robotic welding restoration.",

            'about_cert_badge'             => 'Quality Framework',
            'about_cert_title'             => 'International Accreditations & Standards',
            'about_cert_list'              => [
                'ISO 9001:2015 CERTIFIED',
                'DNV CLASSIFIED FACILITY',
                'ASNT LEVEL III NDT BENCH',
                "LLOYD'S REGISTER STANDARDS",
            ],

            // ==================== CONTACT US ====================
            'contact_header_bg'              => 'transparent',
            'contact_header_frosted_opacity' => 80,
            'contact_header_light_bg'        => '#ffffff',
            'contact_header_dark_bg'         => '#07131e',
            'contact_header_light_text'      => '#0f172a',
            'contact_header_dark_text'       => '#f8fafc',
            'contact_badge'                  => 'Port Response & Headquarters',
            'contact_hero_title'             => 'Contact & 24/7 Marine Duty Desk.',
            'contact_hero_subtitle'          => 'Connect directly with our port superintendent engineers for immediate vessel assistance, dynamic balancing bookings, and genuine spare parts quotes.',
            
            // Section & Card toggles for Contact
            'contact_show_emergency'         => true,
            'contact_show_rfq_form'          => true,

            // Dynamic Facilities Repeater (No 2-office limit!)
            'contact_facilities_list'        => [
                [
                    'id'        => 'facility_port',
                    'badge'     => 'Primary Workshop Facility',
                    'title'     => 'Chattogram Port Workshop',
                    'address'   => 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.',
                    'desc'      => 'Equipped with heavy overhead gantry cranes, Schenck dynamic balancing benches, and ultrasonic clean bays.',
                    'phone'     => '+880 1800-000000',
                    'email'     => 'port.ops@nordroy.com',
                    'emergency' => '',
                    'is_active' => true,
                ],
                [
                    'id'        => 'facility_hq',
                    'badge'     => 'Corporate Headquarters',
                    'title'     => 'Dhaka Corporate HQ',
                    'address'   => 'Gulshan Industrial Area, Dhaka, Bangladesh.',
                    'desc'      => 'Executive administration, global procurement, and fleet service level agreement management.',
                    'phone'     => '+880 1700-000000',
                    'email'     => 'operations@nordroy.com',
                    'emergency' => '24/7 Port Helpline & Deep Anchorage Flying Squad Available Worldwide.',
                    'is_active' => true,
                ],
            ],

            // Legacy keys preserved for fallback
            'contact_port_title'             => 'Chattogram Port Workshop',
            'contact_hq_title'               => 'Dhaka Corporate HQ',
            'contact_emergency_note'         => '24/7 Port Helpline & Deep Anchorage Flying Squad Available Worldwide.',

            // ==================== CAREERS ====================
            'careers_header_bg'              => 'transparent',
            'careers_header_frosted_opacity' => 80,
            'careers_header_light_bg'        => '#ffffff',
            'careers_header_dark_bg'         => '#07131e',
            'careers_header_light_text'      => '#0f172a',
            'careers_header_dark_text'       => '#f8fafc',
            'careers_badge'                  => 'Talent & Engineering Careers',
            'careers_hero_title'             => 'Build Your Career in High-Precision Turbomachinery',
            'careers_hero_subtitle'          => 'Join our world-class marine engineering team in Chattogram & Dhaka. Operate hard-bearing dynamic balancing benches up to 100,000 RPM, board international ocean-going vessels at outer anchorage, and service heavy multi-brand industrial turbochargers.',
            
            // Section toggles for Careers
            'careers_show_culture'           => true,
            'careers_show_spontaneous'       => true,

            'careers_culture_cards'          => [
                [
                    'id'        => 'pillar_1',
                    'icon'      => 'solid:cpu-chip',
                    'title'     => 'Precision Instruments',
                    'desc'      => 'Schenck balancing, NDT testing & 5-axis CAD/CAM benches.',
                    'color'     => 'cyan',
                    'is_active' => true,
                ],
                [
                    'id'        => 'pillar_2',
                    'icon'      => 'solid:lifebuoy',
                    'title'     => 'Offshore Flying Squads',
                    'desc'      => 'Deep sea anchorage interventions with safety per-diem allowances.',
                    'color'     => 'rose',
                    'is_active' => true,
                ],
                [
                    'id'        => 'pillar_3',
                    'icon'      => 'solid:academic-cap',
                    'title'     => 'OEM Certifications',
                    'desc'      => 'Continuous training programs on ABB, MAN, and Napier series.',
                    'color'     => 'emerald',
                    'is_active' => true,
                ],
                [
                    'id'        => 'pillar_4',
                    'icon'      => 'solid:shield-check',
                    'title'     => 'Health & Safety (HSE)',
                    'desc'      => 'Full medical coverage, offshore insurance, and performance bonuses.',
                    'color'     => 'indigo',
                    'is_active' => true,
                ],
            ],

            'careers_spontaneous_badge'      => 'Spontaneous Application',
            'careers_spontaneous_title'      => "Don't See Your Specific Maritime Specialty?",
            'careers_spontaneous_desc'       => 'We are continuously recruiting certified marine superintendents, non-destructive testing (NDT) metallurgists, and sea-going flying squad fitters. Submit your CV directly to our general engineering talent pool.',
            'careers_form_title'             => 'Submit General Candidate Credentials',
            'careers_form_subtitle'          => 'Complete the form below to enter Nordroy Marine talent repository.',

            // ==================== SERVICES ====================
            'services_header_bg'              => 'transparent',
            'services_header_frosted_opacity' => 80,
            'services_header_light_bg'        => '#ffffff',
            'services_header_dark_bg'         => '#07131e',
            'services_header_light_text'      => '#0f172a',
            'services_header_dark_text'       => '#f8fafc',
            'services_badge'                  => 'Technical Capabilities',
            'services_hero_title'             => 'Precision Overhaul Services & Port Flying Squads.',
            'services_hero_subtitle'          => 'Operating with calibrated German balancing rigs and certified marine engineers to guarantee that every turbocharger overhaul achieves maximum boost pressure and zero vibration.',
            
            // Grid, Pagination & Filter settings for Services
            'services_grid_cols'              => '1', // '1' (detailed horizontal split), '2', '3'
            'services_per_page'               => '12', // '6', '9', '12', '18', 'all'
            'services_show_categories'        => true,
            'services_show_quote_btn'         => true,
            'services_show_scope_btn'         => true,

            // ==================== PRODUCTS ====================
            'products_header_bg'              => 'transparent',
            'products_header_frosted_opacity' => 80,
            'products_header_light_bg'        => '#ffffff',
            'products_header_dark_bg'         => '#07131e',
            'products_header_light_text'      => '#0f172a',
            'products_header_dark_text'       => '#f8fafc',
            'products_badge'                  => 'Genuine OEM & Precision Parts',
            'products_hero_title'             => 'Marine Turbocharger Spare Parts & Assemblies.',
            'products_hero_subtitle'          => 'Comprehensive inventory of genuine OEM turbocharger spare parts, complete factory-balanced rotating cartridges (CHRA), turbine blades, and high-precision nozzle rings backed by 12 months marine class warranty.',
            
            // Grid, Pagination & Filter settings for Products Catalog
            'products_grid_cols'              => '4', // '2', '3', '4', '6'
            'products_per_page'               => '16', // '8', '12', '16', '24', 'all'
            'products_show_category_filter'   => true,
            'products_show_search'            => true,
            'products_show_brochure_btn'      => true,
            'products_show_inquiry_btn'       => true,

            // ==================== GALLERY ====================
            'photo_gallery_header_bg'              => 'transparent',
            'photo_gallery_header_frosted_opacity' => 80,
            'photo_gallery_header_light_bg'        => '#ffffff',
            'photo_gallery_header_dark_bg'         => '#07131e',
            'photo_gallery_header_light_text'      => '#0f172a',
            'photo_gallery_header_dark_text'       => '#f8fafc',
            'photo_gallery_badge'                  => 'Visual Engineering Archive',
            'photo_gallery_title'                  => 'Overhaul Workshops & Maritime Operations Gallery.',
            'photo_gallery_subtitle'               => 'Inspection records, Schenck balancing operations, turbine blading overhauls, and deep-sea flying squad interventions documented from our ports.',
            
            // Grid, Pagination & Filter settings for Photo Gallery
            'photo_gallery_grid_cols'              => '4', // '2', '3', '4', '5'
            'photo_gallery_per_page'               => '24', // '12', '24', '36', 'all'
            'photo_gallery_show_albums'            => true,
            'photo_gallery_show_captions'          => true,

            'video_gallery_header_bg'              => 'transparent',
            'video_gallery_header_frosted_opacity' => 80,
            'video_gallery_header_light_bg'        => '#ffffff',
            'video_gallery_header_dark_bg'         => '#07131e',
            'video_gallery_header_light_text'      => '#0f172a',
            'video_gallery_header_dark_text'       => '#f8fafc',
            'video_gallery_badge'                  => 'Technical Video Archive',
            'video_gallery_title'                  => 'Turbocharger Maintenance & Workshop Procedures.',
            'video_gallery_subtitle'               => 'Watch dynamic balancing procedures, high-speed spin tests, and ultrasonic cleaning walkthroughs directly from our engineering team.',
            
            // Grid, Pagination & Filter settings for Video Gallery
            'video_gallery_grid_cols'              => '3', // '1', '2', '3', '4'
            'video_gallery_per_page'               => '12', // '6', '9', '12', '18', 'all'
            'video_gallery_show_albums'            => true,
            'video_gallery_show_play_btn'          => true,
        ];
    }

    public function render()
    {
        return view('livewire.admin.pages.page-content-manager');
    }
}
