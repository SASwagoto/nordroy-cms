<?php

namespace App\Services;

class SmartColorHelper
{
    /**
     * Normalize a color configuration array.
     */
    public static function normalize(mixed $config, string $defaultLight = '#ffffff', string $defaultDark = '#07131e'): array
    {
        if (empty($config) || !is_array($config)) {
            return [
                'mode'    => 'theme',
                'light'   => $defaultLight,
                'dark'    => $defaultDark,
                'opacity' => 100,
            ];
        }

        return [
            'mode'    => $config['mode'] ?? 'theme',
            'light'   => $config['light'] ?? $defaultLight,
            'dark'    => $config['dark'] ?? $defaultDark,
            'opacity' => (int) ($config['opacity'] ?? 100),
        ];
    }

    /**
     * Check if custom color mode is active.
     */
    public static function isCustom(mixed $config): bool
    {
        return is_array($config) && ($config['mode'] ?? 'theme') === 'custom';
    }

    /**
     * Generate inline CSS variables for light & dark styling.
     *
     * Example output:
     * --smart-bg-light: rgba(255,255,255,0.9); --smart-bg-dark: rgba(7,19,30,0.9);
     */
    public static function cssVars(mixed $config, string $varPrefix = 'smart-bg', string $defaultLight = '#ffffff', string $defaultDark = '#07131e'): string
    {
        $cfg = static::normalize($config, $defaultLight, $defaultDark);
        if ($cfg['mode'] !== 'custom') {
            return '';
        }

        $opacity = max(0, min(100, $cfg['opacity'])) / 100;
        $lightRgba = static::hexToRgba($cfg['light'], $opacity);
        $darkRgba  = static::hexToRgba($cfg['dark'], $opacity);

        return "--{$varPrefix}-light: {$lightRgba}; --{$varPrefix}-dark: {$darkRgba};";
    }

    /**
     * Convert HEX color string (#fff or #ffffff) to rgba(r,g,b,a)
     */
    public static function hexToRgba(string $hex, float $alpha = 1.0): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) !== 6) {
            return "rgba(255, 255, 255, {$alpha})";
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgba({$r}, {$g}, {$b}, {$alpha})";
    }
}
