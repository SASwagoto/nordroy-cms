@php
    $customKey = $customKey ?? '';
    if (empty($customKey)) return;

    $customSections = \App\Models\Setting::getJson('home_custom_sections', []);
    $data = $customSections[$customKey] ?? null;
    if (!$data || !($data['is_enabled'] ?? true)) return;

    $type = $data['type'] ?? 'content_block';
    $title = $data['title'] ?? 'Custom Section';
    $badge = $data['badge'] ?? '';
    $subtitle = $data['subtitle'] ?? '';
    $content = $data['content'] ?? '';
    $align = $data['align'] ?? 'left';
    $bgType = $data['bg_type'] ?? 'theme_default';
    $bgLight = $data['bg_light'] ?? '#ffffff';
    $bgDark = $data['bg_dark'] ?? '#0b1b2b';
    $gradDir = $data['gradient_dir'] ?? '135deg';
    $gradFrom = $data['gradient_from'] ?? '#002538';
    $gradTo = $data['gradient_to'] ?? '#07131e';
    $glassOpacity = max(10, min(90, (int) ($data['glass_opacity'] ?? 90)));
    $width = $data['width'] ?? 'container';
    $padding = $data['padding'] ?? 'standard';

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
            $bgStyle = "background-color: {$bgLight};";
            break;
        case 'gradient':
            $bgClass = 'text-slate-900 dark:text-white';
            $bgStyle = "background: linear-gradient({$gradDir}, {$gradFrom}, {$gradTo});";
            break;
        default:
            $bgClass = 'bg-slate-50 dark:bg-[#0b1b2b] text-slate-900 dark:text-white';
            break;
    }

    $paddingClass = match($padding) {
        'compact' => 'py-12 sm:py-16',
        'spacious' => 'py-24 sm:py-32',
        default => 'py-16 sm:py-24 lg:py-28',
    };

    $containerClass = match($width) {
        'fluid' => 'w-full px-4 sm:px-8',
        'narrow' => 'w-full max-w-5xl mx-auto px-4 sm:px-8',
        default => 'w-full max-w-[1536px] mx-auto px-4 sm:px-8',
    };

    $textAlignClass = match($align) {
        'center' => 'text-center mx-auto items-center justify-center',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-left mr-auto ml-0 items-start justify-start',
    };
@endphp

<section id="{{ $customKey }}" 
         class="reveal-init reveal-fade-up border-b border-slate-200 dark:border-slate-800 transition-colors {{ $bgClass }} {{ $paddingClass }}"
         @if($bgStyle) style="{{ $bgStyle }}" @endif>
    <div class="{{ $containerClass }}">
        
        <!-- ==================== TYPE 1: CONTENT BLOCK ==================== -->
        @if($type === 'content_block')
            <div class="max-w-4xl {{ $textAlignClass }} space-y-4">
                @if($badge)
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#003C58]/10 dark:bg-cyan-500/10 border border-[#003C58]/20 dark:border-cyan-500/30 text-[#003C58] dark:text-cyan-400 text-xs font-bold uppercase tracking-wider">
                        <span>{{ $badge }}</span>
                    </div>
                @endif

                @if($title)
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
                        {{ $title }}
                    </h2>
                @endif

                @if($subtitle)
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif

                @if($content)
                    <div class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed pt-2 prose dark:prose-invert max-w-none">
                        {!! nl2br(e($content)) !!}
                    </div>
                @endif

                @if(!empty($data['cta_text']) && !empty($data['cta_url']))
                    <div class="pt-4 flex {{ $align === 'center' ? 'justify-center' : ($align === 'right' ? 'justify-end' : 'justify-start') }}">
                        <a href="{{ $data['cta_url'] }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md">
                            <span>{{ $data['cta_text'] }}</span>
                            <x-icon name="solid:arrow-right" class="w-4 h-4" />
                        </a>
                    </div>
                @endif
            </div>

        <!-- ==================== TYPE 2: CTA BANNER ==================== -->
        @elseif($type === 'cta_banner')
            <div class="p-8 sm:p-12 lg:p-16 rounded-3xl bg-gradient-to-br from-[#002538] via-[#003C58] to-[#07131e] text-white shadow-2xl border border-cyan-500/20 text-center space-y-6">
                @if($badge)
                    <span class="inline-block px-3 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-xs font-bold uppercase tracking-wider">
                        {{ $badge }}
                    </span>
                @endif

                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight max-w-3xl mx-auto leading-tight">
                    {{ $title }}
                </h2>

                @if($subtitle)
                    <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
                        {{ $subtitle }}
                    </p>
                @endif

                <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                    @if(!empty($data['cta1_text']) && !empty($data['cta1_url']))
                        <a href="{{ $data['cta1_url'] }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm bg-cyan-500 hover:bg-cyan-400 text-slate-950 shadow-lg shadow-cyan-500/30 transition-all">
                            <span>{{ $data['cta1_text'] }}</span>
                            <x-icon name="solid:arrow-right" class="w-4 h-4" />
                        </a>
                    @endif

                    @if(!empty($data['cta2_text']) && !empty($data['cta2_url']))
                        <a href="{{ $data['cta2_url'] }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all backdrop-blur-xs">
                            <span>{{ $data['cta2_text'] }}</span>
                        </a>
                    @endif
                </div>
            </div>

        <!-- ==================== TYPE 3: FEATURES GRID ==================== -->
        @elseif($type === 'features_grid')
            <div class="space-y-12">
                <div class="{{ $textAlignClass }} max-w-3xl space-y-3">
                    @if($badge)
                        <span class="inline-block px-3 py-1 rounded-full bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 text-xs font-bold uppercase tracking-wider">
                            {{ $badge }}
                        </span>
                    @endif
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">{{ $subtitle }}</p>
                    @endif
                </div>

                @php
                    $features = $data['features'] ?? [];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($features as $feat)
                        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-cyan-500 transition-all space-y-3">
                            <span class="w-10 h-10 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon :name="$feat['icon'] ?? 'solid:circle-check'" class="w-5 h-5" />
                            </span>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $feat['title'] ?? 'Feature' }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $feat['desc'] ?? '' }}</p>
                            @if(!empty($feat['url']))
                                <a href="{{ $feat['url'] }}" class="inline-flex items-center gap-1 text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:underline pt-1">
                                    <span>Learn more</span>
                                    <x-icon name="solid:chevron-right" class="w-3 h-3" />
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        <!-- ==================== TYPE 4: FAQ ACCORDION ==================== -->
        @elseif($type === 'faq_accordion')
            <div class="max-w-4xl mx-auto space-y-8" x-data="{ activeFaq: null }">
                <div class="{{ $textAlignClass }} space-y-3">
                    @if($badge)
                        <span class="inline-block px-3 py-1 rounded-full bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 text-xs font-bold uppercase tracking-wider">
                            {{ $badge }}
                        </span>
                    @endif
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight">{{ $title }}</h2>
                    @if($subtitle)
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">{{ $subtitle }}</p>
                    @endif
                </div>

                @php
                    $faqs = $data['faqs'] ?? [];
                @endphp
                <div class="space-y-3">
                    @foreach($faqs as $fIndex => $faq)
                        <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-2xs">
                            <button type="button" @click="activeFaq = (activeFaq === {{ $fIndex }} ? null : {{ $fIndex }})"
                                    class="w-full p-4 sm:p-5 text-left font-bold text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4 cursor-pointer">
                                <span>{{ $faq['q'] ?? 'Question' }}</span>
                                <span class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 shrink-0 transition-transform"
                                      :class="activeFaq === {{ $fIndex }} ? 'rotate-180 text-cyan-500' : ''">
                                    <x-icon name="solid:chevron-down" class="w-3.5 h-3.5" />
                                </span>
                            </button>
                            <div x-show="activeFaq === {{ $fIndex }}" x-collapse class="px-5 pb-5 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                                {!! nl2br(e($faq['a'] ?? '')) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        <!-- ==================== TYPE 5: CUSTOM HTML ==================== -->
        @elseif($type === 'custom_html')
            <div class="w-full">
                @if($title)
                    <div class="{{ $textAlignClass }} mb-6 space-y-2">
                        @if($badge)
                            <span class="inline-block px-3 py-1 rounded-full bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 text-xs font-bold uppercase tracking-wider">
                                {{ $badge }}
                            </span>
                        @endif
                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $title }}</h2>
                    </div>
                @endif

                <div class="custom-html-block w-full">
                    {!! $content !!}
                </div>
            </div>
        @endif

    </div>
</section>
