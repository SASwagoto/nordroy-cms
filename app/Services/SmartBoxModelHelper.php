<?php

namespace App\Services;

class SmartBoxModelHelper
{
    /**
     * Default box model schema.
     */
    public static function defaults(): array
    {
        return [
            'padding' => [
                'mode'   => 'axis', // 'axis' (y/x), 'independent' (top/right/bottom/left), 'linked' (all)
                'top'    => '16px',
                'bottom' => '16px',
                'left'   => '24px',
                'right'  => '24px',
                'all'    => '16px',
                'y'      => '16px',
                'x'      => '24px',
            ],
            'margin' => [
                'top'    => '0px',
                'bottom' => '0px',
                'center' => true,
            ],
            'border' => [
                'enabled' => false,
                'width'   => '0px',
                'side'    => 'bottom', // 'all', 'top', 'bottom', 'y'
                'style'   => 'solid',  // 'solid', 'dashed', 'dotted', 'none'
                'radius'  => '0px',
                'color'   => '#e2e8f0',
            ],
            'shadow' => 'none', // 'none', '2xs', 'xs', 'sm', 'md', 'lg', 'xl', '2xl'
            'width'  => '1536px', // '1280px', '1440px', '1536px', '1680px', '100%', or custom
        ];
    }

    /**
     * Normalize box model configuration with sensible defaults.
     */
    public static function normalize(mixed $config, array $overrides = []): array
    {
        $base = array_replace_recursive(static::defaults(), $overrides);

        if (!is_array($config) || empty($config)) {
            return $base;
        }

        return array_replace_recursive($base, $config);
    }

    /**
     * Generate inline CSS styles specifically for padding.
     */
    public static function paddingCss(mixed $config): string
    {
        $cfg = static::normalize($config);
        $styles = [];

        $p = $cfg['padding'] ?? [];
        $pMode = $p['mode'] ?? 'axis';

        if ($pMode === 'linked') {
            $val = !empty($p['all']) ? $p['all'] : '16px';
            $styles[] = "padding: {$val};";
        } elseif ($pMode === 'axis') {
            $y = !empty($p['y']) ? $p['y'] : ($p['top'] ?? '16px');
            $x = !empty($p['x']) ? $p['x'] : ($p['left'] ?? '24px');
            $styles[] = "padding-top: {$y};";
            $styles[] = "padding-bottom: {$y};";
            $styles[] = "padding-left: {$x};";
            $styles[] = "padding-right: {$x};";
        } else {
            $t = !empty($p['top']) ? $p['top'] : '0px';
            $r = !empty($p['right']) ? $p['right'] : '0px';
            $b = !empty($p['bottom']) ? $p['bottom'] : '0px';
            $l = !empty($p['left']) ? $p['left'] : '0px';
            $styles[] = "padding: {$t} {$r} {$b} {$l};";
        }

        return implode(' ', $styles);
    }

    /**
     * Generate inline CSS styles from box model configuration.
     */
    public static function toCss(mixed $config): string
    {
        $cfg = static::normalize($config);
        $styles = [];

        // 1. Padding
        $p = $cfg['padding'] ?? [];
        $pMode = $p['mode'] ?? 'axis';

        if ($pMode === 'linked') {
            $val = !empty($p['all']) ? $p['all'] : '16px';
            $styles[] = "padding: {$val};";
        } elseif ($pMode === 'axis') {
            $y = !empty($p['y']) ? $p['y'] : ($p['top'] ?? '16px');
            $x = !empty($p['x']) ? $p['x'] : ($p['left'] ?? '24px');
            $styles[] = "padding-top: {$y};";
            $styles[] = "padding-bottom: {$y};";
            $styles[] = "padding-left: {$x};";
            $styles[] = "padding-right: {$x};";
        } else {
            // Independent
            $t = !empty($p['top']) ? $p['top'] : '0px';
            $r = !empty($p['right']) ? $p['right'] : '0px';
            $b = !empty($p['bottom']) ? $p['bottom'] : '0px';
            $l = !empty($p['left']) ? $p['left'] : '0px';
            $styles[] = "padding: {$t} {$r} {$b} {$l};";
        }

        // 2. Margin
        $m = $cfg['margin'] ?? [];
        if (!empty($m['top']) && $m['top'] !== '0' && $m['top'] !== '0px') {
            $styles[] = "margin-top: {$m['top']};";
        }
        if (!empty($m['bottom']) && $m['bottom'] !== '0' && $m['bottom'] !== '0px') {
            $styles[] = "margin-bottom: {$m['bottom']};";
        }
        if (!empty($m['center'])) {
            $styles[] = "margin-left: auto; margin-right: auto;";
        }

        // 3. Border
        $b = $cfg['border'] ?? [];
        if (!empty($b['width']) && $b['width'] !== '0' && $b['width'] !== '0px') {
            $side = $b['side'] ?? 'all';
            $w = $b['width'];
            $st = $b['style'] ?? 'solid';
            $c = $b['color'] ?? 'currentColor';

            if ($side === 'bottom') {
                $styles[] = "border-bottom: {$w} {$st} {$c};";
            } elseif ($side === 'top') {
                $styles[] = "border-top: {$w} {$st} {$c};";
            } elseif ($side === 'y') {
                $styles[] = "border-top: {$w} {$st} {$c}; border-bottom: {$w} {$st} {$c};";
            } else {
                $styles[] = "border: {$w} {$st} {$c};";
            }
        }
        if (!empty($b['radius']) && $b['radius'] !== '0' && $b['radius'] !== '0px') {
            $styles[] = "border-radius: {$b['radius']};";
        }

        // 4. Shadow
        $sh = $cfg['shadow'] ?? 'none';
        if ($sh && $sh !== 'none') {
            $shadowCss = static::resolveShadow($sh);
            if ($shadowCss) {
                $styles[] = "box-shadow: {$shadowCss};";
            }
        }

        // 5. Width
        $w = $cfg['width'] ?? null;
        if (!empty($w)) {
            $styles[] = "max-width: {$w}; width: 100%;";
        }

        return implode(' ', $styles);
    }

    /**
     * Resolve Tailwind shadow tokens to CSS box-shadow values.
     */
    public static function resolveShadow(string $shadow): ?string
    {
        return match ($shadow) {
            '2xs'  => '0 1px rgb(0 0 0 / 0.05)',
            'xs'   => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
            'sm'   => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
            'md'   => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
            'lg'   => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
            'xl'   => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
            '2xl'  => '0 25px 50px -12px rgb(0 0 0 / 0.25)',
            'glow' => '0 0 20px rgba(14, 165, 233, 0.35)',
            default => null,
        };
    }
}
