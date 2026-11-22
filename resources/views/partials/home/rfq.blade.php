@php
    $rfqEnabled = (bool) \App\Models\Setting::get('home_rfq_enabled', true);
    if (!$rfqEnabled) return;

    $rfqBadge = \App\Models\Setting::get('home_rfq_badge', '24/7 Operations Desk');
    $rfqTitle = \App\Models\Setting::get('home_rfq_title', 'Request Instant Quotation or Emergency Port Call');
    $rfqSubtitle = \App\Models\Setting::get('home_rfq_subtitle', 'Our duty marine engineering superintendents respond within 45 minutes of RFQ submission.');
    $rfqBtnText = \App\Models\Setting::get('home_rfq_btn_text', 'Submit Technical RFQ to Duty Desk');
@endphp

<!-- =====================================================================
     INTERACTIVE RAPID RFQ / DUTY DESK
     ===================================================================== -->
<section id="rfq" class="reveal-init reveal-fade-up py-20 lg:py-28 bg-slate-50 dark:bg-[#06121d] text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-[1536px] mx-auto px-4 sm:px-8">
        
        <div class="reveal-init reveal-scale reveal-delay-150 max-w-4xl mx-auto rounded-3xl p-8 sm:p-12 bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xl space-y-8">
            
            <div class="text-center space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-800">
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

    </div>
</section>
