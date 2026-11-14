<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Str;

class LinkResolver
{
    /**
     * Get all pre-configured and dynamic system pages.
     */
    public static function getAvailablePages(): array
    {
        $systemPages = [
            ['slug' => 'home',     'url' => '/',         'title' => 'Home Page (Landing)'],
            ['slug' => 'about',    'url' => '/about',    'title' => 'About Us (Company Profile)'],
            ['slug' => 'services', 'url' => '/services', 'title' => 'Services (All Overhauls)'],
            ['slug' => 'projects', 'url' => '/projects', 'title' => 'Projects (Case Studies)'],
            ['slug' => 'contact',  'url' => '/contact',  'title' => 'Contact & Duty Desk'],
        ];

        // Merge with dynamic pages from database if present
        try {
            $dbPages = Page::where('status', 'published')
                ->get()
                ->map(fn($p) => [
                    'slug'  => $p->slug,
                    'url'   => '/' . ltrim($p->slug, '/'),
                    'title' => is_array($p->title) ? ($p->title['en'] ?? reset($p->title)) : $p->title,
                ])
                ->toArray();

            // Avoid duplicate slugs
            $existingSlugs = array_column($systemPages, 'slug');
            foreach ($dbPages as $dp) {
                if (!in_array($dp['slug'], $existingSlugs)) {
                    $systemPages[] = $dp;
                }
            }
        } catch (\Throwable $e) {
            // Fallback gracefully to system pages
        }

        return $systemPages;
    }

    /**
     * Get identifiable anchor sections per page for smooth in-page scrolling.
     */
    public static function getAvailableSections(?string $pageSlug = 'home'): array
    {
        $pageSlug = $pageSlug ?: 'home';

        $sectionsMap = [
            'home' => [
                ['id' => 'hero',           'name' => '#hero (Precision Turbine Dial & Value Prop)'],
                ['id' => 'partners',       'name' => '#partners (OEM Authorized Brand Ticker)'],
                ['id' => 'about',          'name' => '#about (Company Precision Profile)'],
                ['id' => 'services',       'name' => '#services (Featured Marine Services Grid)'],
                ['id' => 'workshop',       'name' => '#workshop (Balancing & Cleanroom Facility)'],
                ['id' => 'metrics',        'name' => '#metrics (Operations & Fleet Metrics)'],
                ['id' => 'case-studies',   'name' => '#case-studies (Maritime Case Studies)'],
                ['id' => 'flying-squad',   'name' => '#flying-squad (24/7 Port Emergency Squad)'],
                ['id' => 'certifications', 'name' => '#certifications (Class Approvals: DNV / Lloyd\'s)'],
                ['id' => 'rfq',            'name' => '#rfq (Interactive Technical RFQ Desk)'],
            ],
            'services' => [
                ['id' => 'overview',       'name' => '#overview (Overhaul Services Scope)'],
                ['id' => 'categories',     'name' => '#categories (Turbocharger, Rotor, Balancing)'],
                ['id' => 'capabilities',   'name' => '#capabilities (Dynamic Balancing Tolerances)'],
                ['id' => 'inquiry',        'name' => '#inquiry (Request Service Quotation)'],
            ],
            'about' => [
                ['id' => 'story',          'name' => '#story (Maritime Engineering Heritage)'],
                ['id' => 'leadership',     'name' => '#leadership (Superintendents & Directors)'],
                ['id' => 'certifications', 'name' => '#certifications (ISO & Maritime Quality)'],
            ],
            'projects' => [
                ['id' => 'featured',       'name' => '#featured (Flagship Vessel Overhauls)'],
                ['id' => 'archive',        'name' => '#archive (Project Archive & Timeline)'],
            ],
            'contact' => [
                ['id' => 'rfq',            'name' => '#rfq (Technical Inquiry Form)'],
                ['id' => 'bases',          'name' => '#bases (Chattogram & Mongla Port Bases)'],
                ['id' => 'emergency',      'name' => '#emergency (24/7 Flying Squad Hotlines)'],
            ],
        ];

        return $sectionsMap[$pageSlug] ?? [];
    }

    /**
     * Get active dynamic Services from database for one-click direct linking.
     */
    public static function getDynamicServices(): array
    {
        try {
            return Service::where('is_active', true)
                ->orderBy('order')
                ->get()
                ->map(fn($s) => [
                    'id'    => $s->id,
                    'slug'  => $s->slug,
                    'title' => $s->display_title ?: $s->slug,
                    'url'   => '/services#' . $s->slug,
                ])
                ->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Universal Link Resolver: Converts structured link array or legacy string into absolute URL & attributes.
     *
     * @param mixed $linkData
     * @return array ['url' => string, 'target' => string, 'rel' => string, 'is_external' => bool, 'label' => string]
     */
    public static function resolve(mixed $linkData): array
    {
        // 1. Fallback for Empty Input
        if (empty($linkData)) {
            return [
                'url'         => '#',
                'target'      => '_self',
                'rel'         => '',
                'is_external' => false,
                'label'       => '',
            ];
        }

        // 2. Backward Compatibility for Legacy Plain URL Strings (e.g. "/services" or "https://...")
        if (is_string($linkData)) {
            $trimmed = trim($linkData);
            if (empty($trimmed) || $trimmed === '#') {
                return ['url' => '#', 'target' => '_self', 'rel' => '', 'is_external' => false, 'label' => ''];
            }

            $isExternal = str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://');
            return [
                'url'         => $isExternal ? $trimmed : url($trimmed),
                'target'      => $isExternal ? '_blank' : '_self',
                'rel'         => $isExternal ? 'noopener noreferrer' : '',
                'is_external' => $isExternal,
                'label'       => '',
            ];
        }

        // 3. Structured Array Format
        $type = $linkData['type'] ?? 'internal';
        $targetBlank = !empty($linkData['target_blank']);
        $label = $linkData['label'] ?? '';

        switch ($type) {
            case 'internal':
                $pageSlug = $linkData['page'] ?? 'home';
                $sectionId = !empty($linkData['section']) ? trim($linkData['section']) : null;
                
                // Map system pages to clean routes
                $pageBase = match ($pageSlug) {
                    'home'     => url('/'),
                    'about'    => url('/about'),
                    'services' => url('/services'),
                    'projects' => url('/projects'),
                    'contact'  => url('/contact'),
                    default    => url('/' . ltrim($pageSlug, '/')),
                };

                $finalUrl = $sectionId ? ($pageBase . '#' . ltrim($sectionId, '#')) : $pageBase;

                return [
                    'url'         => $finalUrl,
                    'target'      => $targetBlank ? '_blank' : '_self',
                    'rel'         => $targetBlank ? 'noopener noreferrer' : '',
                    'is_external' => false,
                    'label'       => $label,
                ];

            case 'anchor':
                $section = ltrim($linkData['section'] ?? '', '#');
                return [
                    'url'         => $section ? ('#' . $section) : '#',
                    'target'      => '_self',
                    'rel'         => '',
                    'is_external' => false,
                    'label'       => $label,
                ];

            case 'service':
                $serviceSlug = $linkData['service_slug'] ?? null;
                $url = $serviceSlug ? url('/services#' . $serviceSlug) : url('/services');
                return [
                    'url'         => $url,
                    'target'      => $targetBlank ? '_blank' : '_self',
                    'rel'         => $targetBlank ? 'noopener noreferrer' : '',
                    'is_external' => false,
                    'label'       => $label,
                ];

            case 'action':
                $actionType = $linkData['action_type'] ?? 'tel';
                $actionVal = trim($linkData['action_value'] ?? '');

                if (empty($actionVal)) {
                    $actionVal = match ($actionType) {
                        'tel'      => Setting::get('contact_phone', '+880 1700-000000'),
                        'mailto'   => Setting::get('contact_email', 'contact@nordroy.com'),
                        'whatsapp' => Setting::get('whatsapp_number', '+880 1700-000000'),
                        default    => '',
                    };
                }

                $url = match ($actionType) {
                    'tel'      => 'tel:' . preg_replace('/[^\d+]/', '', $actionVal),
                    'mailto'   => 'mailto:' . $actionVal,
                    'whatsapp' => 'https://wa.me/' . preg_replace('/[^\d]/', '', $actionVal),
                    default    => '#',
                };

                return [
                    'url'         => $url,
                    'target'      => $actionType === 'whatsapp' ? '_blank' : '_self',
                    'rel'         => $actionType === 'whatsapp' ? 'noopener noreferrer' : '',
                    'is_external' => ($actionType === 'whatsapp'),
                    'label'       => $label,
                ];

            case 'external':
            default:
                $rawUrl = trim($linkData['url'] ?? '#');
                $isExternal = str_starts_with($rawUrl, 'http://') || str_starts_with($rawUrl, 'https://');
                $target = $targetBlank ? '_blank' : ($isExternal ? '_blank' : '_self');

                return [
                    'url'         => $rawUrl ?: '#',
                    'target'      => $target,
                    'rel'         => $target === '_blank' ? 'noopener noreferrer' : '',
                    'is_external' => $isExternal,
                    'label'       => $label,
                ];
        }
    }

    /**
     * Helper to get just the URL string cleanly.
     */
    public static function url(mixed $linkData): string
    {
        return static::resolve($linkData)['url'] ?? '#';
    }

    /**
     * Helper to get HTML attributes (href, target, rel).
     */
    public static function attributes(mixed $linkData): string
    {
        $res = static::resolve($linkData);
        $attrs = 'href="' . htmlspecialchars($res['url'], ENT_QUOTES, 'UTF-8') . '"';

        if (!empty($res['target']) && $res['target'] !== '_self') {
            $attrs .= ' target="' . htmlspecialchars($res['target'], ENT_QUOTES, 'UTF-8') . '"';
        }

        if (!empty($res['rel'])) {
            $attrs .= ' rel="' . htmlspecialchars($res['rel'], ENT_QUOTES, 'UTF-8') . '"';
        }

        return $attrs;
    }
}
