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
                'mode'     => 'theme',
                'type'     => 'solid',
                'light'    => $defaultLight,
                'dark'     => $defaultDark,
                'opacity'  => 100,
                'gradient' => [
                    'direction'  => '135deg',
                    'light_from' => $defaultLight,
                    'light_to'   => '#f1f5f9',
                    'dark_from'  => $defaultDark,
                    'dark_to'    => '#0c1e30',
                ],
                'glass'    => [
                    'blur'    => '12px',
                    'opacity' => 80,
                    'border'  => true,
                ],
            ];
        }

        $type = $config['type'] ?? 'solid';
        $gradient = is_array($config['gradient'] ?? null) ? $config['gradient'] : [];
        $glass = is_array($config['glass'] ?? null) ? $config['glass'] : [];

        return [
            'mode'     => $config['mode'] ?? 'theme',
            'type'     => in_array($type, ['solid', 'gradient', 'glass']) ? $type : 'solid',
            'light'    => $config['light'] ?? $defaultLight,
            'dark'     => $config['dark'] ?? $defaultDark,
            'opacity'  => (int) ($config['opacity'] ?? 100),
            'gradient' => [
                'direction'  => $gradient['direction'] ?? '135deg',
                'light_from' => $gradient['light_from'] ?? ($config['light'] ?? $defaultLight),
                'light_to'   => $gradient['light_to'] ?? '#f1f5f9',
                'dark_from'  => $gradient['dark_from'] ?? ($config['dark'] ?? $defaultDark),
                'dark_to'    => $gradient['dark_to'] ?? '#0c1e30',
            ],
            'glass'    => [
                'blur'    => $glass['blur'] ?? '12px',
                'opacity' => (int) ($glass['opacity'] ?? 80),
                'border'  => !empty($glass['border']),
            ],
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
     * Check if custom gradient is active.
     */
    public static function isGradient(mixed $config): bool
    {
        return static::isCustom($config) && (($config['type'] ?? '') === 'gradient');
    }

    /**
     * Check if custom glass effect is active.
     */
    public static function isGlass(mixed $config): bool
    {
        return static::isCustom($config) && (($config['type'] ?? '') === 'glass');
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

        $type = $cfg['type'] ?? 'solid';

        if ($type === 'gradient') {
            $dir = $cfg['gradient']['direction'] ?? '135deg';
            $lFrom = $cfg['gradient']['light_from'] ?? $cfg['light'];
            $lTo   = $cfg['gradient']['light_to'] ?? '#f1f5f9';
            $dFrom = $cfg['gradient']['dark_from'] ?? $cfg['dark'];
            $dTo   = $cfg['gradient']['dark_to'] ?? '#0c1e30';

            return "--{$varPrefix}-light: linear-gradient({$dir}, {$lFrom}, {$lTo}); --{$varPrefix}-dark: linear-gradient({$dir}, {$dFrom}, {$dTo}); --{$varPrefix}-type: gradient;";
        }

        if ($type === 'glass') {
            $glassOp = max(0, min(100, (int) ($cfg['glass']['opacity'] ?? 80))) / 100;
            $blur    = $cfg['glass']['blur'] ?? '12px';
            $lightRgba = static::hexToRgba($cfg['light'], $glassOp);
            $darkRgba  = static::hexToRgba($cfg['dark'], $glassOp);

            return "--{$varPrefix}-light: {$lightRgba}; --{$varPrefix}-dark: {$darkRgba}; --{$varPrefix}-blur: {$blur}; --{$varPrefix}-type: glass; backdrop-filter: blur({$blur}); -webkit-backdrop-filter: blur({$blur});";
        }

        // Solid (Default)
        $opacity = max(0, min(100, $cfg['opacity'])) / 100;
        $lightRgba = static::hexToRgba($cfg['light'], $opacity);
        $darkRgba  = static::hexToRgba($cfg['dark'], $opacity);

        return "--{$varPrefix}-light: {$lightRgba}; --{$varPrefix}-dark: {$darkRgba}; --{$varPrefix}-type: solid;";
    }

    /**
     * Get preview background style for client-side / blade mockup canvas.
     */
    public static function previewCss(mixed $config, bool $isDark = false): string
    {
        $cfg = static::normalize($config);
        if ($cfg['mode'] !== 'custom') {
            return '';
        }

        $type = $cfg['type'] ?? 'solid';

        if ($type === 'gradient') {
            $dir = $cfg['gradient']['direction'] ?? '135deg';
            $from = $isDark ? ($cfg['gradient']['dark_from'] ?? $cfg['dark']) : ($cfg['gradient']['light_from'] ?? $cfg['light']);
            $to   = $isDark ? ($cfg['gradient']['dark_to'] ?? '#0c1e30') : ($cfg['gradient']['light_to'] ?? '#f1f5f9');
            return "background: linear-gradient({$dir}, {$from}, {$to});";
        }

        if ($type === 'glass') {
            $glassOp = max(0, min(100, (int) ($cfg['glass']['opacity'] ?? 80))) / 100;
            $blur    = $cfg['glass']['blur'] ?? '12px';
            $color   = $isDark ? $cfg['dark'] : $cfg['light'];
            $rgba    = static::hexToRgba($color, $glassOp);
            return "background-color: {$rgba}; backdrop-filter: blur({$blur}); -webkit-backdrop-filter: blur({$blur});";
        }

        $opacity = max(0, min(100, $cfg['opacity'])) / 100;
        $color   = $isDark ? $cfg['dark'] : $cfg['light'];
        $rgba    = static::hexToRgba($color, $opacity);
        return "background-color: {$rgba};";
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
