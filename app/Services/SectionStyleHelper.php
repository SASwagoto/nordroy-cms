<?php

namespace App\Services;

class SectionStyleHelper
{
    /**
     * Default common settings schema for every section.
     */
    public static function defaults(): array
    {
        return [
            'container_width' => 'default', // 'default', '1280px', '1440px', '1536px', '1680px', '100%'
            'padding_y'       => 'default', // 'default', 'none', 'compact', 'normal', 'generous', 'grand'
            'margin_y'        => 'none',    // 'none', 'small', 'medium', 'large'
            'border'          => 'none',    // 'none', 'subtle', 'accent_top', 'full'
            'shadow'          => 'none',    // 'none', 'shadow-sm', 'shadow-md', 'shadow-lg', 'glow'
            'bg_color'        => [
                'mode'    => 'theme',
                'light'   => '#ffffff',
                'dark'    => '#07131e',
                'opacity' => 100,
            ],
        ];
    }

    /**
     * Normalize settings with defaults.
     */
    public static function normalize(?array $settings): array
    {
        $defaults = static::defaults();
        if (empty($settings)) {
            return $defaults;
        }

        $merged = array_merge($defaults, $settings);
        $merged['bg_color'] = SmartColorHelper::normalize($settings['bg_color'] ?? []);

        return $merged;
    }

    /**
     * Generate HTML classes for section wrapper.
     */
    public static function classes(?array $settings): string
    {
        $s = static::normalize($settings);
        $classes = [];

        // Vertical Padding
        $classes[] = match ($s['padding_y']) {
            'none'     => 'py-0',
            'compact'  => 'py-10 sm:py-14',
            'normal'   => 'py-16 sm:py-24',
            'generous' => 'py-20 sm:py-28',
            'grand'    => 'py-28 sm:py-36',
            default    => 'py-16 sm:py-24', // Default matches theme var(--section-padding)
        };

        // Vertical Margin
        $classes[] = match ($s['margin_y']) {
            'small'  => 'my-6',
            'medium' => 'my-12',
            'large'  => 'my-20',
            default  => '',
        };

        // Border styling
        $classes[] = match ($s['border']) {
            'subtle'     => 'border-y border-slate-200/90 dark:border-slate-800/90',
            'accent_top' => 'border-t-2 border-[#003C58] dark:border-cyan-400',
            'full'       => 'border border-slate-200/90 dark:border-slate-800/90 rounded-3xl',
            default      => '',
        };

        // Shadow
        $classes[] = match ($s['shadow']) {
            'shadow-sm' => 'shadow-sm',
            'shadow-md' => 'shadow-md',
            'shadow-lg' => 'shadow-xl',
            'glow'      => 'shadow-[0_0_50px_rgba(0,60,88,0.12)] dark:shadow-[0_0_50px_rgba(14,165,233,0.12)]',
            default     => '',
        };

        // Custom Background classes
        if (SmartColorHelper::isCustom($s['bg_color'])) {
            $classes[] = 'smart-custom-bg transition-colors duration-200';
        }

        return trim(implode(' ', array_filter($classes)));
    }

    /**
     * Generate inline styles for section wrapper (including CSS custom variables for light/dark background).
     */
    public static function styles(?array $settings): string
    {
        $s = static::normalize($settings);
        $styles = [];

        if (SmartColorHelper::isCustom($s['bg_color'])) {
            $styles[] = SmartColorHelper::cssVars($s['bg_color'], 'sec-bg');
            $styles[] = 'background-color: var(--sec-bg-light);';
        }

        return implode(' ', $styles);
    }

    /**
     * Generate classes for the inner container (width constraints).
     */
    public static function containerClass(?array $settings): string
    {
        $s = static::normalize($settings);

        return match ($s['container_width']) {
            '100%'   => 'w-full px-4 sm:px-8',
            '1280px' => 'max-w-7xl mx-auto px-4 sm:px-8',
            '1440px' => 'max-w-[1440px] mx-auto px-4 sm:px-8',
            '1536px' => 'max-w-[1536px] mx-auto px-4 sm:px-8',
            '1680px' => 'max-w-[1680px] mx-auto px-4 sm:px-8',
            default  => 'max-w-[1536px] mx-auto px-4 sm:px-8',
        };
    }
}
