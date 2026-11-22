@php
    $rfqEnabled = (bool) \App\Models\Setting::get('home_rfq_enabled', true);
    if (!$rfqEnabled) return;

    $rfqBadge = \App\Models\Setting::get('home_rfq_badge', '24/7 Operations Desk');
    $rfqTitle = \App\Models\Setting::get('home_rfq_title', 'Request Instant Quotation or Emergency Port Call');
    $rfqSubtitle = \App\Models\Setting::get('home_rfq_subtitle', 'Our duty marine engineering superintendents respond within 45 minutes of RFQ submission.');
    $rfqBtnText = \App\Models\Setting::get('home_rfq_btn_text', 'Submit Technical RFQ to Duty Desk');

    $align = \App\Models\Setting::get('home_rfq_align', 'center');
    $headerAlignClass = match($align) {
        'left' => 'text-left mr-auto ml-0 items-start justify-start',
        'right' => 'text-right ml-auto mr-0 items-end justify-end',
        default => 'text-center mx-auto items-center justify-center',
    };
@endphp

<!-- =====================================================================
     INTERACTIVE RAPID RFQ / DUTY DESK
     ===================================================================== -->
<x-section-styler-wrap sectionKey="rfq" id="rfq">
    
    <div class="reveal-init reveal-scale reveal-delay-150 max-w-4xl mx-auto rounded-3xl p-8 sm:p-12 bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl space-y-8">
        
        <div class="space-y-2 {{ $headerAlignClass }}">
            <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800 inline-block">
                {{ __($rfqBadge) }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                {{ __($rfqTitle) }}
            </h2>
            <p class="text-xs text-slate-600 dark:text-slate-400">
                {{ __($rfqSubtitle) }}
            </p>
        </div>

        <!-- Integrated Livewire RFQ Component if present, or Clean Standard Form -->
        <livewire:frontend.rfq-lead-form />

    </div>

</x-section-styler-wrap>