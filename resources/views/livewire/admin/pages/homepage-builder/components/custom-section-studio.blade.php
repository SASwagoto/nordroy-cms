@props(['customKey'])

@php
    $cData = $customSections[$customKey] ?? [];
    $type = $cData['type'] ?? 'content_block';
@endphp

<div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="p-1.5 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400">
                    <x-icon name="solid:puzzle-piece" class="w-4 h-4" />
                </span>
                <h2 class="text-base font-black text-slate-900 dark:text-white">Custom Section Studio</h2>
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-300 uppercase">
                    {{ str_replace('_', ' ', $type) }}
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">Configure content, dynamic layout, and universal styling for this custom homepage unit.</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" wire:click="removeCustomSection('{{ $customKey }}')"
                    wire:confirm="Are you sure you want to permanently delete this custom section?"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 border border-rose-200 dark:border-rose-900 transition-colors cursor-pointer">
                <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                <span>Delete Section</span>
            </button>
            <label class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer select-none">
                <input type="checkbox" wire:model.live="customSections.{{ $customKey }}.is_enabled" class="w-4 h-4 rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Enable Section</span>
            </label>
        </div>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6 {{ ($cData['is_enabled'] ?? true) ? '' : 'opacity-40 pointer-events-none' }}">
        
        <!-- 1. Universal Section Styler Component -->
        <x-homepage-builder.section-styler :prefix="$customKey" />

        <!-- 2. Section Type & Title -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:bars-progress" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Section Architecture &amp; Type</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Section Type</label>
                    <select wire:model.live="customSections.{{ $customKey }}.type"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                        <option value="content_block">Rich Content Block (Heading, Text &amp; CTAs)</option>
                        <option value="cta_banner">Action Callout Banner (Wide CTA Bar)</option>
                        <option value="features_grid">Features Grid (Multi-Column Card Items)</option>
                        <option value="faq_accordion">FAQ Accordion (Expandable Q&amp;A)</option>
                        <option value="custom_html">Raw Custom HTML / Embed</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Badge Label (Optional)</label>
                    <input type="text" wire:model="customSections.{{ $customKey }}.badge" placeholder="Special Feature"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Section Title</label>
                    <input type="text" wire:model="customSections.{{ $customKey }}.title" placeholder="Engineering Title"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Subtitle / Tagline</label>
                <input type="text" wire:model="customSections.{{ $customKey }}.subtitle" placeholder="Detailed subtitle explaining the section..."
                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium">
            </div>
        </div>

        <!-- ==================== TYPE 1: CONTENT BLOCK ==================== -->
        @if($type === 'content_block')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:align-left" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Content Body &amp; Actions</span>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Main Paragraph Body</label>
                <textarea wire:model="customSections.{{ $customKey }}.content" rows="4" placeholder="Detailed technical content or description..."
                          class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white font-medium"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2 p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Call-to-Action 1</span>
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta1_text" placeholder="Button Label"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta1_url" placeholder="/services"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                </div>

                <div class="space-y-2 p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Call-to-Action 2 (Optional)</span>
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta2_text" placeholder="Button Label"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta2_url" placeholder="/contact"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                </div>
            </div>
        </div>
        @endif

        <!-- ==================== TYPE 2: CTA BANNER ==================== -->
        @if($type === 'cta_banner')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:bullhorn" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Call-to-Action Buttons</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2 p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Primary Button</span>
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta1_text" placeholder="Explore Services →"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta1_url" placeholder="/services"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                </div>

                <div class="space-y-2 p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Secondary Button</span>
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta2_text" placeholder="Contact Duty Desk"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                    <input type="text" wire:model="customSections.{{ $customKey }}.cta2_url" placeholder="/contact"
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                </div>
            </div>
        </div>
        @endif

        <!-- ==================== TYPE 3: FEATURES GRID ==================== -->
        @if($type === 'features_grid')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:table-cells-large" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Features Cards Repeater</span>
                </div>
                <button type="button" wire:click="addCustomSectionFeature('{{ $customKey }}')"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 transition-colors cursor-pointer flex items-center gap-1">
                    <x-icon name="solid:plus" class="w-3 h-3" />
                    <span>Add Feature Card</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(($cData['features'] ?? []) as $fIdx => $feature)
                <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 relative group">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400">Card 0{{ $fIdx + 1 }}</span>
                        <button type="button" wire:click="removeCustomSectionFeature('{{ $customKey }}', {{ $fIdx }})"
                                class="w-5 h-5 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove Feature">
                            <x-icon name="solid:xmark" class="w-3 h-3" />
                        </button>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Card Title</label>
                        <input type="text" wire:model="customSections.{{ $customKey }}.features.{{ $fIdx }}.title"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Card Description</label>
                        <textarea wire:model="customSections.{{ $customKey }}.features.{{ $fIdx }}.desc" rows="2"
                                  class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">Icon Identifier</label>
                        <input type="text" wire:model="customSections.{{ $customKey }}.features.{{ $fIdx }}.icon"
                               class="w-full px-2.5 py-1 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-mono">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ==================== TYPE 4: FAQ ACCORDION ==================== -->
        @if($type === 'faq_accordion')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-icon name="solid:circle-question" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Q&amp;A Accordion Repeater</span>
                </div>
                <button type="button" wire:click="addCustomSectionFaq('{{ $customKey }}')"
                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-950/40 border border-cyan-200 dark:border-cyan-800 transition-colors cursor-pointer flex items-center gap-1">
                    <x-icon name="solid:plus" class="w-3 h-3" />
                    <span>Add Question</span>
                </button>
            </div>

            <div class="space-y-3">
                @foreach(($cData['faqs'] ?? []) as $qIdx => $faq)
                <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2 relative group">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono font-bold text-cyan-600 dark:text-cyan-400">Q 0{{ $qIdx + 1 }}</span>
                        <button type="button" wire:click="removeCustomSectionFaq('{{ $customKey }}', {{ $qIdx }})"
                                class="w-5 h-5 rounded text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/60 flex items-center justify-center cursor-pointer" title="Remove FAQ">
                            <x-icon name="solid:xmark" class="w-3 h-3" />
                        </button>
                    </div>

                    <input type="text" wire:model="customSections.{{ $customKey }}.faqs.{{ $qIdx }}.question" placeholder="Question Title..."
                           class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 font-bold">

                    <textarea wire:model="customSections.{{ $customKey }}.faqs.{{ $qIdx }}.answer" rows="2" placeholder="Answer text..."
                              class="w-full px-3 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800"></textarea>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ==================== TYPE 5: CUSTOM HTML ==================== -->
        @if($type === 'custom_html')
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center gap-2">
                <x-icon name="solid:code" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                <span class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Custom HTML &amp; Embed Content</span>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Raw HTML Markup / Embeds</label>
                <textarea wire:model="customSections.{{ $customKey }}.html_content" rows="6" placeholder="<div>Your custom markup...</div>"
                          class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-900 dark:text-white"></textarea>
            </div>
        </div>
        @endif

    </div>

    <!-- Footer Controls -->
    <div class="p-4 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-[11px] text-slate-500 dark:text-slate-400">Changes apply directly to this custom homepage unit.</span>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="saveCustomSection('{{ $customKey }}')" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-950 transition-all shadow-md active:scale-95 cursor-pointer disabled:opacity-50">
                <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                <span>Save Custom Section</span>
            </button>
        </div>
    </div>
</div>
