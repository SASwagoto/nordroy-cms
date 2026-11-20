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
    public string $activePage = 'about'; // 'about', 'contact', 'careers', 'home', 'services', 'products', 'gallery'

    /**
     * Dictionary of editable page contents
     */
    public array $content = [];

    // Repeater helper states
    public array $aboutPartners = [];
    public string $newPartnerBrand = '';
    public string $newPartnerModels = '';

    public array $aboutCertifications = [];
    public string $newCertName = '';

    public array $careersCultureCards = [];

    public function mount(): void
    {
        $this->loadPageContent();
    }

    public function setPage(string $page): void
    {
        if (in_array($page, ['about', 'contact', 'careers', 'home', 'services', 'products', 'gallery'])) {
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
            } else {
                $this->content[$key] = Setting::get($key, $defaultVal);
            }
        }

        $this->aboutPartners = $this->content['about_partners_list'] ?? [];
        $this->aboutCertifications = $this->content['about_cert_list'] ?? [];
        $this->careersCultureCards = $this->content['careers_culture_cards'] ?? [];
    }

    // ==========================================
    // REPEATER ACTIONS: ABOUT PARTNERS
    // ==========================================
    public function addPartner(): void
    {
        $brand = trim($this->newPartnerBrand);
        $models = trim($this->newPartnerModels);

        if (!empty($brand)) {
            $this->aboutPartners[] = [
                'brand'  => $brand,
                'models' => $models,
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

    // ==========================================
    // REPEATER ACTIONS: ABOUT CERTIFICATIONS
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

        $group = 'page_' . $this->activePage;

        foreach ($this->content as $key => $val) {
            Setting::set($key, $val, $group, is_array($val) ? 'json' : 'text');
        }

        Setting::flushCache();

        session()->flash('message', "Content for '" . ucfirst($this->activePage) . "' page updated successfully.");
    }

    public function resetToDefaults(): void
    {
        $defaults = $this->getDefaults();

        foreach ($defaults as $key => $val) {
            Setting::set($key, $val, 'page_' . $this->activePage, is_array($val) ? 'json' : 'text');
        }

        Setting::flushCache();
        $this->loadPageContent();

        session()->flash('message', "Default corporate copy restored for '" . ucfirst($this->activePage) . "' page.");
    }

    private function getDefaults(): array
    {
        return [
            // ==================== ABOUT US ====================
            'about_badge'           => 'About Nordroy Group',
            'about_hero_title'      => 'A Legacy of Maritime Precision & Heavy Industrial Power.',
            'about_hero_subtitle'   => 'Operating at the nexus of international shipping lanes and heavy industrial power utilities, Nordroy Marine & Turbochargers delivers certified multi-brand turbomachinery maintenance, NDT metallurgical verification, and prompt port dispatch.',
            
            'about_overview_title'  => 'Engineered for High-Pressure Environments',
            'about_overview_p1'     => 'Modern exhaust gas turbochargers spin upwards of 100,000 RPM at temperatures exceeding 650°C. Even microscopic unbalance or metallurgical fatigue can trigger catastrophic engine failure and vessel arrest at port.',
            'about_overview_p2'     => 'Our specialized engineering facilities in Chattogram Port and Dhaka are equipped with German Schenck computerized balancing rigs, ultrasonic chemical cleaning lines, and ASNT Level III non-destructive testing benches to ensure that every overhauled component operates at zero deviation from OEM tolerances.',
            'about_stat1_value'     => '100k RPM',
            'about_stat1_label'     => 'Balancing Rig Capacity',
            'about_stat2_value'     => '± 0.005mm',
            'about_stat2_label'     => 'Shaft Run-Out Accuracy',

            'about_partners_title'  => 'Authorized OEM Partnerships',
            'about_partners_list'   => [
                ['brand' => 'Accelleron (ABB)', 'models' => 'VTR, TPL, TPS, A100 & TPR series overhauls.'],
                ['brand' => 'MAN Energy Solutions', 'models' => 'NR, NA, TCR, TCA & radial designs.'],
                ['brand' => 'KBB', 'models' => 'M40, R-series, and HPR industrial compressors.'],
                ['brand' => 'Mitsubishi Heavy Industries', 'models' => 'MET-SR, MET-SC & MET-MA models.'],
            ],

            'about_mission_title'   => 'Our Corporate Mission',
            'about_mission_text'    => 'To protect commercial maritime operations and heavy industrial power grids from catastrophic machinery downtime by delivering rapid, certified, and fully calibrated turbocharger overhauls with complete engineering integrity.',
            'about_vision_title'    => 'Vision 2030',
            'about_vision_text'     => "To serve as South Asia's pre-eminent center of excellence for turbomachinery dynamics, setting new industry standards in decarbonization retrofits, bio-fuel turbine adaptations, and robotic welding restoration.",

            'about_cert_badge'      => 'Quality Framework',
            'about_cert_title'      => 'International Accreditations & Standards',
            'about_cert_list'       => [
                'ISO 9001:2015 CERTIFIED',
                'DNV CLASSIFIED FACILITY',
                'ASNT LEVEL III NDT BENCH',
                "LLOYD'S REGISTER STANDARDS",
            ],

            // ==================== CONTACT US ====================
            'contact_badge'         => 'Port Response & Headquarters',
            'contact_hero_title'    => 'Contact & 24/7 Marine Duty Desk.',
            'contact_hero_subtitle' => 'Connect directly with our port superintendent engineers for immediate vessel assistance, dynamic balancing bookings, and genuine spare parts quotes.',
            
            'contact_port_badge'    => 'Primary Workshop Facility',
            'contact_port_title'    => 'Chattogram Port Workshop',
            'contact_port_address'  => 'Near Marine Academy Jetty, Chattogram Port, Bangladesh.',
            'contact_port_desc'     => 'Equipped with heavy overhead gantry cranes, Schenck dynamic balancing benches, and ultrasonic clean bays.',
            'contact_port_phone'    => '+880 1800-000000',
            'contact_port_email'    => 'port.ops@nordroy.com',

            'contact_hq_badge'      => 'Corporate Headquarters',
            'contact_hq_title'      => 'Dhaka Corporate HQ',
            'contact_hq_address'    => 'Gulshan Industrial Area, Dhaka, Bangladesh.',
            'contact_hq_phone'      => '+880 1700-000000',
            'contact_hq_email'      => 'operations@nordroy.com',
            'contact_emergency_note'=> '24/7 Port Helpline & Deep Anchorage Flying Squad Available Worldwide.',
            'contact_maps_url'      => 'https://maps.google.com',

            // ==================== CAREERS ====================
            'careers_badge'         => 'Talent & Engineering Careers',
            'careers_hero_title'    => 'Build Your Career in High-Precision Turbomachinery',
            'careers_hero_subtitle' => 'Join our world-class marine engineering team in Chattogram & Dhaka. Operate hard-bearing dynamic balancing benches up to 100,000 RPM, board international ocean-going vessels at outer anchorage, and service heavy multi-brand industrial turbochargers.',
            
            'careers_culture_cards' => [
                [
                    'icon'  => 'solid:cpu-chip',
                    'title' => 'Precision Instruments',
                    'desc'  => 'Schenck balancing, NDT testing & 5-axis CAD/CAM benches.',
                ],
                [
                    'icon'  => 'solid:lifebuoy',
                    'title' => 'Offshore Flying Squads',
                    'desc'  => 'Deep sea anchorage interventions with safety per-diem allowances.',
                ],
                [
                    'icon'  => 'solid:academic-cap',
                    'title' => 'OEM Certifications',
                    'desc'  => 'Continuous training programs on ABB, MAN, and Napier series.',
                ],
                [
                    'icon'  => 'solid:shield-check',
                    'title' => 'Health & Safety (HSE)',
                    'desc'  => 'Full medical coverage, offshore insurance, and performance bonuses.',
                ],
            ],

            'careers_spontaneous_badge' => 'Spontaneous Application',
            'careers_spontaneous_title' => "Don't See Your Specific Maritime Specialty?",
            'careers_spontaneous_desc'  => 'We are continuously recruiting certified marine superintendents, non-destructive testing (NDT) metallurgists, and sea-going flying squad fitters. Submit your CV directly to our general engineering talent pool.',
            'careers_form_title'        => 'Submit General Candidate Credentials',
            'careers_form_subtitle'     => 'Complete the form below to enter Nordroy Marine talent repository.',

            // ==================== HOME PAGE ====================
            'home_hero_badge1'      => 'Authorized Multi-Brand Turbocharger Engineering',
            'home_hero_badge2'      => 'ISO 9001:2015 • DNV Certified',
            'home_hero_title'       => 'Precision Turbocharger Overhauls & Marine Propulsion Support.',
            'home_hero_subtitle'    => 'Specialized multi-brand maintenance, dynamic rotor balancing up to 100,000 RPM, and global OEM spare parts logistics for oceangoing commercial vessels, industrial captive power plants, and oil & gas terminals.',
            'home_hero_cta1_text'   => 'Explore Overhaul Services',
            'home_hero_cta1_url'    => '/services',
            'home_hero_cta2_text'   => 'Request Instant RFQ',
            'home_hero_cta2_url'    => '/contact#rfq',

            'home_metric1_value'    => '100,000',
            'home_metric1_label'    => 'RPM Dynamic Balancing',
            'home_metric2_value'    => '24/7/365',
            'home_metric2_label'    => 'Emergency Port Flying Squads',
            'home_metric3_value'    => '10,000+',
            'home_metric3_label'    => 'OEM Spares in Stock',

            // ==================== SERVICES ====================
            'services_badge'        => 'Technical Capabilities',
            'services_hero_title'   => 'Precision Overhaul Services & Port Flying Squads.',
            'services_hero_subtitle'=> 'Operating with calibrated German balancing rigs and certified marine engineers to guarantee that every turbocharger overhaul achieves maximum boost pressure and zero vibration.',

            // ==================== PRODUCTS ====================
            'products_badge'        => 'Genuine OEM & Precision Parts',
            'products_hero_title'   => 'Marine Turbocharger Spare Parts & Assemblies.',
            'products_hero_subtitle'=> 'Comprehensive inventory of genuine OEM turbocharger spare parts, complete factory-balanced rotating cartridges (CHRA), turbine blades, and high-precision nozzle rings backed by 12 months marine class warranty.',

            // ==================== GALLERY ====================
            'photo_gallery_badge'   => 'Visual Engineering Archive',
            'photo_gallery_title'   => 'Overhaul Workshops & Maritime Operations Gallery.',
            'photo_gallery_subtitle'=> 'Inspection records, Schenck balancing operations, turbine blading overhauls, and deep-sea flying squad interventions documented from our ports.',
            
            'video_gallery_badge'   => 'Technical Video Archive',
            'video_gallery_title'   => 'Turbocharger Maintenance & Workshop Procedures.',
            'video_gallery_subtitle'=> 'Watch dynamic balancing procedures, high-speed spin tests, and ultrasonic cleaning walkthroughs directly from our engineering team.',
        ];
    }

    public function render()
    {
        return view('livewire.admin.pages.page-content-manager');
    }
}
