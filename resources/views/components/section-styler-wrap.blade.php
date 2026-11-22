@props([
    'sectionKey' => '',
    'id' => '',
    'defaultBg' => 'theme_default',
    'defaultAlign' => 'left',
    'defaultWidth' => 'container',
    'defaultPadding' => 'standard',
    'class' => '',
])

@php
    $bgType = \App\Models\Setting::get("home_{$sectionKey}_bg_type", $defaultBg);
    $bgLight = \App\Models\Setting::get("home_{$sectionKey}_bg_light", '#ffffff');
    $bgDark = \App\Models\Setting::get("home_{$sectionKey}_bg_dark", '#0b1b2b');
    $gradDir = \App\Models\Setting::get("home_{$sectionKey}_gradient_dir", '135deg');
    $gradFrom = \App\Models\Setting::get("home_{$sectionKey}_gradient_from", '#002538');
    $gradTo = \App\Models\Setting::get("home_{$sectionKey}_gradient_to", '#07131e');
    $glassOpacity = max(10, min(90, (int) \App\Models\Setting::get("home_{$sectionKey}_glass_opacity", 90)));
    
    $align = \App\Models\Setting::get("home_{$sectionKey}_align", $defaultAlign);
    $width = \App\Models\Setting::get("home_{$sectionKey}_width", $defaultWidth);
    $padding = \App\Models\Setting::get("home_{$sectionKey}_padding", $defaultPadding);

    // Background Class & Style
    $bgClass = '';
    $bgStyle = '';

    switch ($bgType) {
        case 'clean_white':
            $bgClass = 'bg-white dark:bg-[#07131e] text-slate-900 dark:text-white';
            break;
        case 'transparent':
            $bgClass = 'bg-transparent text-slate-900 dark:text-white';
            break;
        case 'glass':
            $bgClass = 'backdrop-blur-md text-slate-900 dark:text-white';
            $bgStyle = "background-color: rgba(255, 255, 255, " . ($glassOpacity / 100) . ");";
            break;
        case 'solid_custom':
            $bgClass = 'text-slate-900 dark:text-white';
            $bgStyle = "--section-bg-light: {$bgLight}; --section-bg-dark: {$bgDark};";
            break;
        case 'gradient':
            $bgClass = 'text-slate-900 dark:text-white';
            $bgStyle = "background: linear-gradient({$gradDir}, {$gradFrom}, {$gradTo});";
            break;
        default: // 'theme_default'
            $bgClass = 'bg-slate-50 dark:bg-[#0b1b2b] text-slate-900 dark:text-white';
            break;
    }

    // Vertical Padding Class
    $paddingClass = match($padding) {
        'compact' => 'py-12 sm:py-16',
        'spacious' => 'py-24 sm:py-32',
        default => 'py-16 sm:py-24 lg:py-28',
    };

    // Container Width Class
    $containerClass = match($width) {
        'fluid' => 'w-full px-4 sm:px-8',
        'narrow' => 'w-full max-w-5xl mx-auto px-4 sm:px-8',
        default => 'w-full max-w-[1536px] mx-auto px-4 sm:px-8',
    };

    // Alignment Class
    $textAlignClass = match($align) {
        'center' => 'text-center mx-auto items-center justify-center',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-left mr-auto ml-0 items-start justify-start',
    };

    $headerAlignClass = match($align) {
        'center' => 'text-center items-center justify-center mx-auto',
        'right' => 'text-right items-end justify-end ml-auto',
        default => 'text-left items-start justify-start',
    };
@endphp

<section @if($id) id="{{ $id }}" @endif 
         class="reveal-init reveal-fade-up border-b border-slate-200 dark:border-slate-800 transition-colors {{ $bgClass }} {{ $paddingClass }} {{ $class }}"
         @if($bgStyle) style="{{ $bgStyle }}" @endif>
    <div class="{{ $containerClass }}">
        {{ $slot }}
    </div>
</section>
