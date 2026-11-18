@props([
    'label' => 'Destination Link',
    'help' => null,
    'showLabelInput' => false,
    'compact' => false,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $currentVal = ($wireModel && isset($this)) ? data_get($this, $wireModel) : null;
    $availablePages = \App\Services\LinkResolver::getAvailablePages();
    $sectionsMap = [
        'home'     => \App\Services\LinkResolver::getAvailableSections('home'),
        'services' => \App\Services\LinkResolver::getAvailableSections('services'),
        'about'    => \App\Services\LinkResolver::getAvailableSections('about'),
        'projects' => \App\Services\LinkResolver::getAvailableSections('projects'),
        'contact'  => \App\Services\LinkResolver::getAvailableSections('contact'),
    ];
    $dynamicServices = \App\Services\LinkResolver::getDynamicServices();

    $initType = is_array($currentVal) ? ($currentVal['type'] ?? 'internal') : 'internal';
    $initPage = is_array($currentVal) ? ($currentVal['page'] ?? 'contact') : 'contact';
    $initSection = is_array($currentVal) ? ($currentVal['section'] ?? 'rfq') : 'rfq';
    $initServiceSlug = is_array($currentVal) ? ($currentVal['service_slug'] ?? '') : '';
    $initUrl = is_array($currentVal) ? ($currentVal['url'] ?? '') : '';
    $initActionType = is_array($currentVal) ? ($currentVal['action_type'] ?? 'tel') : 'tel';
    $initActionValue = is_array($currentVal) ? ($currentVal['action_value'] ?? '') : '';
    $initTargetBlank = (is_array($currentVal) && !empty($currentVal['target_blank'])) ? 'true' : 'false';
    $initLabel = is_array($currentVal) ? ($currentVal['label'] ?? '') : '';
    $initQuick = $initType . ':' . ($initType === 'internal' ? ($initPage . ':' . $initSection) : ($initType === 'service' ? $initServiceSlug : ($initType === 'action' ? $initActionType : 'custom')));
@endphp

<div wire:ignore.self
     x-data="{
        isExpanded: false,
        showLabel: {{ $showLabelInput ? 'true' : 'false' }},
        type: '{{ addslashes($initType) }}',
        page: '{{ addslashes($initPage) }}',
        section: '{{ addslashes($initSection) }}',
        service_slug: '{{ addslashes($initServiceSlug) }}',
        url: '{{ addslashes($initUrl) }}',
        action_type: '{{ addslashes($initActionType) }}',
        action_value: '{{ addslashes($initActionValue) }}',
        target_blank: {{ $initTargetBlank }},
        label: '{{ addslashes($initLabel) }}',
        quickSelected: '{{ addslashes($initQuick) }}',

        applyQuickSelection(val) {
            if (!val) return;
            const parts = val.split(':');
            const kind = parts[0];
            if (kind === 'internal') {
                this.type = 'internal';
                this.page = parts[1] || 'home';
                this.section = parts[2] || '';
            } else if (kind === 'service') {
                this.type = 'service';
                this.service_slug = parts[1] || '';
            } else if (kind === 'action') {
                this.type = 'action';
                this.action_type = parts[1] || 'tel';
                if (!this.action_value) {
                    this.action_value = (parts[1] === 'mailto') ? 'operations@nordroy.com' : '+880 1800-000000';
                }
            } else if (kind === 'external') {
                this.type = 'external';
                if (!this.url) {
                    this.url = 'https://';
                }
                this.target_blank = true;
            }
            this.quickSelected = val;
            this.sync();
        },

        setType(newType) {
            this.type = newType;
            this.updateQuickSelected();
            this.sync();
        },

        updateQuickSelected() {
            if (this.type === 'internal') {
                this.quickSelected = `internal:${this.page || 'home'}:${this.section || ''}`;
            } else if (this.type === 'service') {
                this.quickSelected = `service:${this.service_slug || ''}`;
            } else if (this.type === 'action') {
                this.quickSelected = `action:${this.action_type || 'tel'}`;
            } else if (this.type === 'external') {
                this.quickSelected = 'external:custom';
            } else {
                this.quickSelected = '';
            }
        },

        sync() {
            const payload = {
                type: this.type,
                page: this.page,
                section: this.section,
                service_slug: this.service_slug,
                url: this.url,
                action_type: this.action_type,
                action_value: this.action_value,
                target_blank: !!this.target_blank,
                label: this.label
            };
            if ('{{ $wireModel }}' && $wire) {
                $wire.set('{{ $wireModel }}', payload);
            }
            window.dispatchEvent(new CustomEvent('smart-link-changed', {
                detail: { model: '{{ $wireModel }}', link: payload }
            }));
            if (this.$dispatch) {
                this.$dispatch('smart-link-changed', { model: '{{ $wireModel }}', link: payload });
            }
        },

        get typeBadgeLabel() {
            switch(this.type) {
                case 'internal': return 'Internal Page';
                case 'anchor': return 'Section Anchor';
                case 'service': return 'Marine Service';
                case 'external': return 'External URL';
                case 'action': return 'Direct Action';
                default: return 'Smart Link';
            }
        },

        get typeBadgeClass() {
            switch(this.type) {
                case 'internal': return 'bg-blue-100 text-blue-800 border border-blue-200 dark:bg-blue-500/20 dark:text-blue-400 dark:border-blue-500/30';
                case 'anchor': return 'bg-purple-100 text-purple-800 border border-purple-200 dark:bg-purple-500/20 dark:text-purple-400 dark:border-purple-500/30';
                case 'service': return 'bg-cyan-100 text-cyan-800 border border-cyan-200 dark:bg-cyan-500/20 dark:text-cyan-400 dark:border-cyan-500/30';
                case 'external': return 'bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-500/20 dark:text-amber-400 dark:border-amber-500/30';
                case 'action': return 'bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-500/20 dark:text-emerald-400 dark:border-emerald-500/30';
                default: return 'bg-slate-200 text-slate-700 border border-slate-300 dark:bg-slate-800 dark:text-slate-300';
            }
        },

        get resolvedSummaryText() {
            switch(this.type) {
                case 'internal':
                    const pName = (this.page || 'home').toUpperCase();
                    return this.section ? `${pName} > #${this.section}` : `${pName} Page`;
                case 'anchor':
                    return this.section ? `Jump to #${this.section}` : 'In-Page Anchor';
                case 'service':
                    return this.service_slug ? `Service: ${this.service_slug}` : 'All Services';
                case 'external':
                    return this.url || 'External Link';
                case 'action':
                    return `${(this.action_type || 'tel').toUpperCase()}: ${this.action_value || 'Default'}`;
                default:
                    return 'Configured Link';
            }
        },

        get resolvedPreviewUrl() {
            const host = window.location.origin;
            switch(this.type) {
                case 'internal':
                    const p = this.page === 'home' ? '' : `/${this.page}`;
                    const s = this.section ? `#${this.section}` : '';
                    return `${host}${p}${s}`;
                case 'anchor':
                    return `#${this.section || ''}`;
                case 'service':
                    return `${host}/services#${this.service_slug || ''}`;
                case 'external':
                    return this.url || 'https://...';
                case 'action':
                    if (this.action_type === 'tel') return `tel:${this.action_value || ''}`;
                    if (this.action_type === 'mailto') return `mailto:${this.action_value || ''}`;
                    if (this.action_type === 'whatsapp') return `https://wa.me/${this.action_value || ''}`;
                    return '#';
                default:
                    return '#';
            }
        }
     }"
     class="w-full space-y-2">

    @if ($label)
        <div class="flex items-center justify-between">
            <div>
                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">{{ $label }}</label>
                @if($help)
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 font-medium">{{ $help }}</p>
                @endif
            </div>
            <span class="text-[10px] font-mono font-extrabold px-2 py-0.5 rounded-md shrink-0" :class="typeBadgeClass" x-text="typeBadgeLabel"></span>
        </div>
    @endif

    <!-- Compact Trigger / Preview Bar (Entire bar is clickable) -->
    <div @click="isExpanded = !isExpanded"
         role="button"
         tabindex="0"
         @keydown.enter.prevent="isExpanded = !isExpanded"
         @keydown.space.prevent="isExpanded = !isExpanded"
         class="p-3 rounded-2xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-800 shadow-xs hover:border-[#003C58] dark:hover:border-cyan-400 transition-all flex items-center justify-between gap-3 cursor-pointer select-none group">
        
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-105" :class="typeBadgeClass">
                <template x-if="type === 'internal'">
                    <x-icon name="solid:file-lines" class="w-4 h-4" />
                </template>
                <template x-if="type === 'anchor'">
                    <x-icon name="solid:anchor" class="w-4 h-4" />
                </template>
                <template x-if="type === 'service'">
                    <x-icon name="solid:gear" class="w-4 h-4" />
                </template>
                <template x-if="type === 'external'">
                    <x-icon name="solid:arrow-up-right-from-square" class="w-4 h-4" />
                </template>
                <template x-if="type === 'action'">
                    <x-icon name="solid:bolt" class="w-4 h-4" />
                </template>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-xs font-extrabold text-slate-900 dark:text-white truncate group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors" 
                   x-text="resolvedSummaryText || 'Click to select destination'"></p>
                <p class="text-[11px] font-mono font-semibold text-slate-500 dark:text-slate-400 truncate" x-text="resolvedPreviewUrl || '#'"></p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="text-[11px] font-bold text-slate-500 group-hover:text-[#003C58] dark:group-hover:text-cyan-400 transition-colors hidden sm:inline"
                  x-text="isExpanded ? 'Close Settings' : 'Change Destination'"></span>
            
            <button type="button" 
                    @click.stop="isExpanded = !isExpanded"
                    class="px-3 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer shrink-0 inline-flex items-center gap-1.5 shadow-2xs"
                    :class="isExpanded ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 border border-slate-300 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700'">
                <span x-text="isExpanded ? 'Done' : 'Change'"></span>
                <x-icon name="solid:chevron-down" class="w-3 h-3 transition-transform duration-200" ::class="isExpanded ? 'rotate-180' : ''" />
            </button>
        </div>
    </div>

    <!-- Collapsible Configuration HUD / Dropdown Content -->
    <div x-show="isExpanded" 
         x-collapse
         class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-800 shadow-md space-y-4">
        
        <!-- 1. DIRECT QUICK DESTINATION SELECTOR -->
        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-800 shadow-xs space-y-2.5">
            <div class="flex items-center justify-between">
                <label class="block text-xs font-extrabold text-slate-900 dark:text-white flex items-center gap-1.5">
                    <x-icon name="solid:list-check" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                    <span>Quick Destination Dropdown</span>
                </label>
                <span class="text-[10px] text-[#003C58] dark:text-cyan-400 font-mono font-bold bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md border border-slate-300 dark:border-slate-700">1-Click Selection</span>
            </div>

            <select x-model="quickSelected" 
                    @change="applyQuickSelection($event.target.value)"
                    class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                <option value="">-- Choose destination from list --</option>
                <optgroup label="Website Pages &amp; Sections">
                    <option value="internal:contact:rfq">Contact Us - RFQ Quotation Form (/contact#rfq) [Recommended for CTA]</option>
                    <option value="internal:contact:">Contact Us Page (/contact)</option>
                    <option value="internal:services:">Services Overview (/services)</option>
                    <option value="internal:about:">About Company Profile (/about)</option>
                    <option value="internal:projects:">Projects &amp; Case Studies (/projects)</option>
                    <option value="internal:home:">Home Page (/)</option>
                </optgroup>
                <optgroup label="Marine Engineering Services">
                    @foreach ($dynamicServices as $svc)
                        <option value="service:{{ $svc['slug'] }}">{{ $svc['title'] }} (/services#{{ $svc['slug'] }})</option>
                    @endforeach
                </optgroup>
                <optgroup label="Direct Contact Actions">
                    <option value="action:tel">Direct Phone Call (tel:)</option>
                    <option value="action:whatsapp">WhatsApp Direct Chat (wa.me)</option>
                    <option value="action:mailto">Duty Email Message (mailto:)</option>
                </optgroup>
                <optgroup label="External Link">
                    <option value="external:custom">Custom External URL (https://...)</option>
                </optgroup>
            </select>
            <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                Selecting from the list instantly updates the link target. You can also fine-tune parameters below.
            </p>
        </div>

        <!-- 2. GRANULAR CUSTOM BUILDER -->
        <div class="space-y-3 pt-3 border-t-2 border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-800 dark:text-slate-300">
                    Granular Link Builder
                </span>
                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400">
                    Mode: <strong class="text-[#003C58] dark:text-cyan-400" x-text="typeBadgeLabel"></strong>
                </span>
            </div>

            <!-- Type Pill Selector -->
            <div class="flex items-center gap-1.5 p-1.5 rounded-xl bg-slate-200 dark:bg-slate-900 border border-slate-300 dark:border-slate-800 text-xs font-bold overflow-x-auto">
                <button type="button" 
                        @click="setType('internal')"
                        :class="{
                            'bg-[#003C58] text-white shadow-sm ring-2 ring-[#003C58]/30 font-extrabold dark:bg-cyan-500 dark:text-slate-950 dark:ring-cyan-400/40': type === 'internal',
                            'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-950 border border-slate-300 font-semibold dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 dark:hover:text-white': type !== 'internal'
                        }"
                        class="px-3 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <x-icon name="solid:file-lines" class="w-3.5 h-3.5" />
                    <span>Page</span>
                </button>

                <button type="button" 
                        @click="setType('anchor')"
                        :class="{
                            'bg-[#003C58] text-white shadow-sm ring-2 ring-[#003C58]/30 font-extrabold dark:bg-cyan-500 dark:text-slate-950 dark:ring-cyan-400/40': type === 'anchor',
                            'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-950 border border-slate-300 font-semibold dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 dark:hover:text-white': type !== 'anchor'
                        }"
                        class="px-3 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <x-icon name="solid:anchor" class="w-3.5 h-3.5" />
                    <span>#Section</span>
                </button>

                <button type="button" 
                        @click="setType('service')"
                        :class="{
                            'bg-[#003C58] text-white shadow-sm ring-2 ring-[#003C58]/30 font-extrabold dark:bg-cyan-500 dark:text-slate-950 dark:ring-cyan-400/40': type === 'service',
                            'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-950 border border-slate-300 font-semibold dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 dark:hover:text-white': type !== 'service'
                        }"
                        class="px-3 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <x-icon name="solid:gear" class="w-3.5 h-3.5" />
                    <span>Service</span>
                </button>

                <button type="button" 
                        @click="setType('external')"
                        :class="{
                            'bg-[#003C58] text-white shadow-sm ring-2 ring-[#003C58]/30 font-extrabold dark:bg-cyan-500 dark:text-slate-950 dark:ring-cyan-400/40': type === 'external',
                            'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-950 border border-slate-300 font-semibold dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 dark:hover:text-white': type !== 'external'
                        }"
                        class="px-3 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <x-icon name="solid:arrow-up-right-from-square" class="w-3.5 h-3.5" />
                    <span>External</span>
                </button>

                <button type="button" 
                        @click="setType('action')"
                        :class="{
                            'bg-[#003C58] text-white shadow-sm ring-2 ring-[#003C58]/30 font-extrabold dark:bg-cyan-500 dark:text-slate-950 dark:ring-cyan-400/40': type === 'action',
                            'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-950 border border-slate-300 font-semibold dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 dark:hover:text-white': type !== 'action'
                        }"
                        class="px-3 py-1.5 rounded-lg transition-all cursor-pointer flex items-center gap-1.5 shrink-0">
                    <x-icon name="solid:bolt" class="w-3.5 h-3.5" />
                    <span>Action</span>
                </button>
            </div>

            <!-- Optional Label Text Input -->
            <template x-if="showLabel">
                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Link Display Text</label>
                    <input type="text" 
                           x-model="label" 
                           @input.debounce.250ms="sync()"
                           placeholder="e.g. Request Instant RFQ" 
                           class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]" />
                </div>
            </template>

            <!-- TYPE 1: INTERNAL PAGE + SECTION ANCHOR -->
            <div x-show="type === 'internal'" class="space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Target Page</label>
                        <select x-model="page" 
                                @change="updateQuickSelected(); sync()"
                                class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                            @foreach ($availablePages as $p)
                                <option value="{{ $p['slug'] }}">{{ $p['title'] }} ({{ $p['url'] }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Jump to Section Anchor (Optional)</label>
                        <select x-model="section" 
                                @change="updateQuickSelected(); sync()"
                                class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                            <option value="">-- Top of Page (No Anchor) --</option>
                            @foreach ($sectionsMap as $pSlug => $secs)
                                <optgroup label="Sections on {{ ucfirst($pSlug) }} Page">
                                    @foreach ($secs as $sec)
                                        <option value="{{ $sec['id'] }}">#{{ $sec['id'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <span class="text-[11px] text-slate-700 dark:text-slate-300 font-bold font-mono">Or custom #anchor:</span>
                    <input type="text" 
                           x-model="section" 
                           @input.debounce.250ms="updateQuickSelected(); sync()"
                           placeholder="e.g. rfq, workshop, services" 
                           class="flex-1 px-3 py-1.5 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]" />
                </div>
            </div>

            <!-- TYPE 2: IN-PAGE ANCHOR (FOR ONE-PAGE SCROLLS) -->
            <div x-show="type === 'anchor'" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Section Anchor Identifier</label>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-2 rounded-xl bg-slate-200 dark:bg-slate-800 font-mono text-xs font-extrabold text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700">#</span>
                        <input type="text" 
                               x-model="section" 
                               @input.debounce.250ms="sync()"
                               placeholder="rfq (e.g. #rfq, #services, #workshop)" 
                               class="flex-1 px-3 py-2 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]" />
                    </div>
                </div>
                
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Quick Presets:</span>
                    @foreach ($sectionsMap['home'] as $quickSec)
                        <button type="button" 
                                @click="section = '{{ $quickSec['id'] }}'; sync()"
                                class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-[#003C58] hover:text-white hover:border-[#003C58] dark:hover:bg-cyan-500 dark:hover:text-slate-950 transition-colors cursor-pointer shadow-2xs">
                            #{{ $quickSec['id'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- TYPE 3: DYNAMIC SERVICE DIRECT LINK -->
            <div x-show="type === 'service'" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Select Marine Service</label>
                    <select x-model="service_slug" 
                            @change="updateQuickSelected(); sync()"
                            class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                        <option value="">-- All Services Page (/services) --</option>
                        @foreach ($dynamicServices as $svc)
                            <option value="{{ $svc['slug'] }}">{{ $svc['title'] }} (/services#{{ $svc['slug'] }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- TYPE 4: EXTERNAL WEB URL -->
            <div x-show="type === 'external'" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Full Destination URL</label>
                    <input type="url" 
                           x-model="url" 
                           @input.debounce.250ms="updateQuickSelected(); sync()"
                           placeholder="https://example.com/portal" 
                           class="w-full px-3 py-2 text-xs font-mono font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]" />
                </div>
            </div>

            <!-- TYPE 5: QUICK ACTION (PHONE, MAIL, WHATSAPP) -->
            <div x-show="type === 'action'" class="space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Action Protocol</label>
                        <select x-model="action_type" 
                                @change="updateQuickSelected(); sync()"
                                class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]">
                            <option value="tel">Direct Phone Call (tel:)</option>
                            <option value="mailto">Email Message (mailto:)</option>
                            <option value="whatsapp">WhatsApp Instant Chat (https://wa.me/)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Value (Leave blank for default)</label>
                        <input type="text" 
                               x-model="action_value" 
                               @input.debounce.250ms="sync()"
                               :placeholder="action_type === 'mailto' ? 'operations@nordroy.com' : '+880 1800-000000'" 
                               class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-slate-900 border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] focus:border-[#003C58]" />
                    </div>
                </div>
            </div>

            <!-- Bottom Controls: Target Blank & Computed Summary -->
            <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" 
                           x-model="target_blank" 
                           @change="sync()"
                           class="w-4 h-4 rounded text-[#003C58] focus:ring-0" />
                    <span class="text-slate-800 dark:text-slate-200 font-bold">Open in new tab (target="_blank")</span>
                </label>

                <span class="text-[11px] font-mono font-bold text-slate-700 dark:text-cyan-400 bg-slate-100 dark:bg-slate-900 px-2.5 py-1 rounded-lg border border-slate-300 dark:border-slate-800" x-text="'Resolved: ' + resolvedPreviewUrl"></span>
            </div>

        </div>

    </div>

</div>
