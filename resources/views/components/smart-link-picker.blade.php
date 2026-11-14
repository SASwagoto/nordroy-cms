@props([
    'label' => 'Destination Link',
    'showLabelInput' => false,
    'compact' => false,
])

@php
    $wireModel = $attributes->wire('model')->value();
    $availablePages = \App\Services\LinkResolver::getAvailablePages();
    $sectionsMap = [
        'home'     => \App\Services\LinkResolver::getAvailableSections('home'),
        'services' => \App\Services\LinkResolver::getAvailableSections('services'),
        'about'    => \App\Services\LinkResolver::getAvailableSections('about'),
        'projects' => \App\Services\LinkResolver::getAvailableSections('projects'),
        'contact'  => \App\Services\LinkResolver::getAvailableSections('contact'),
    ];
    $dynamicServices = \App\Services\LinkResolver::getDynamicServices();
@endphp

<div x-data="nordroySmartLinkPicker({
        linkData: @if($wireModel) $wire.entangle('{{ $wireModel }}') @else {} @endif,
        sectionsMap: @json($sectionsMap),
        showLabel: {{ $showLabelInput ? 'true' : 'false' }}
    })"
    class="w-full space-y-2">

    @if ($label)
        <div class="flex items-center justify-between">
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $label }}</label>
            <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold" x-text="typeBadgeLabel"></span>
        </div>
    @endif

    <!-- Compact Trigger / Preview Bar -->
    <div class="p-2.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xs hover:border-[#003C58] dark:hover:border-cyan-400 transition-all flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 min-w-0 flex-1">
            <div class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0" :class="typeBadgeClass">
                <template x-if="link.type === 'internal'">
                    <x-icon name="solid:file-lines" class="w-3.5 h-3.5" />
                </template>
                <template x-if="link.type === 'anchor'">
                    <x-icon name="solid:anchor" class="w-3.5 h-3.5" />
                </template>
                <template x-if="link.type === 'service'">
                    <x-icon name="solid:gear" class="w-3.5 h-3.5" />
                </template>
                <template x-if="link.type === 'external'">
                    <x-icon name="solid:arrow-up-right-from-square" class="w-3.5 h-3.5" />
                </template>
                <template x-if="link.type === 'action'">
                    <x-icon name="solid:bolt" class="w-3.5 h-3.5" />
                </template>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-800 dark:text-white truncate" x-text="resolvedSummaryText || 'Click configure to set link'"></p>
                <p class="text-[10px] font-mono text-slate-400 truncate" x-text="resolvedPreviewUrl || '#'"></p>
            </div>
        </div>

        <button type="button" 
                @click="isExpanded = !isExpanded"
                class="px-2.5 py-1.5 rounded-xl text-xs font-bold transition-colors cursor-pointer shrink-0 inline-flex items-center gap-1.5"
                :class="isExpanded ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'">
            <span x-text="isExpanded ? 'Done' : 'Configure'"></span>
            <x-icon :name="isExpanded ? 'solid:chevron-up' : 'solid:chevron-down'" class="w-3 h-3" />
        </button>
    </div>

    <!-- Collapsible Configuration HUD -->
    <div x-show="isExpanded" 
         x-collapse
         class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-4">
        
        <!-- Type Pill Selector -->
        <div class="flex items-center gap-1.5 p-1 rounded-xl bg-slate-200/80 dark:bg-slate-900 text-xs font-bold overflow-x-auto">
            <button type="button" 
                    @click="setType('internal')"
                    :class="link.type === 'internal' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                    class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 shrink-0">
                <x-icon name="solid:file-lines" class="w-3 h-3" />
                <span>Page</span>
            </button>

            <button type="button" 
                    @click="setType('anchor')"
                    :class="link.type === 'anchor' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                    class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 shrink-0">
                <x-icon name="solid:anchor" class="w-3 h-3" />
                <span>#Section</span>
            </button>

            <button type="button" 
                    @click="setType('service')"
                    :class="link.type === 'service' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                    class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 shrink-0">
                <x-icon name="solid:gear" class="w-3 h-3" />
                <span>Service</span>
            </button>

            <button type="button" 
                    @click="setType('external')"
                    :class="link.type === 'external' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                    class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 shrink-0">
                <x-icon name="solid:arrow-up-right-from-square" class="w-3 h-3" />
                <span>External</span>
            </button>

            <button type="button" 
                    @click="setType('action')"
                    :class="link.type === 'action' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                    class="px-3 py-1.5 rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 shrink-0">
                <x-icon name="solid:bolt" class="w-3 h-3" />
                <span>Action</span>
            </button>
        </div>

        <!-- Optional Label Text Input -->
        <template x-if="showLabel">
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Link Display Text</label>
                <input type="text" 
                       x-model="link.label" 
                       @input="syncToLivewire()"
                       placeholder="e.g. Request Instant RFQ" 
                       class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
            </div>
        </template>

        <!-- TYPE 1: INTERNAL PAGE + SECTION ANCHOR -->
        <div x-show="link.type === 'internal'" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Target Page</label>
                    <select x-model="link.page" 
                            @change="onPageChange()"
                            class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        @foreach ($availablePages as $page)
                            <option value="{{ $page['slug'] }}">{{ $page['title'] }} ({{ $page['url'] }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Jump to Section Anchor (Optional)</label>
                    <select x-model="link.section" 
                            @change="syncToLivewire()"
                            class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="">-- Top of Page --</option>
                        <template x-for="sec in currentAvailableSections" :key="sec.id">
                            <option :value="sec.id" x-text="sec.name"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- TYPE 2: IN-PAGE ANCHOR (FOR ONE-PAGE SCROLLS) -->
        <div x-show="link.type === 'anchor'" class="space-y-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Section Anchor Identifier</label>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1.5 rounded-xl bg-slate-200 dark:bg-slate-800 font-mono text-xs font-bold text-slate-500">#</span>
                    <input type="text" 
                           x-model="link.section" 
                           @input="syncToLivewire()"
                           placeholder="rfq (e.g. #rfq, #services, #workshop)" 
                           class="flex-1 px-3 py-1.5 text-xs font-mono rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                </div>
            </div>
            
            <div class="flex flex-wrap gap-1.5">
                <span class="text-[10px] text-slate-400 self-center">Quick Presets:</span>
                @foreach ($sectionsMap['home'] as $quickSec)
                    <button type="button" 
                            @click="link.section = '{{ $quickSec['id'] }}'; syncToLivewire()"
                            class="px-2 py-0.5 rounded-md text-[10px] font-mono bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:border-cyan-400 cursor-pointer">
                        #{{ $quickSec['id'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- TYPE 3: DYNAMIC SERVICE DIRECT LINK -->
        <div x-show="link.type === 'service'" class="space-y-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Select Marine Service</label>
                <select x-model="link.service_slug" 
                        @change="syncToLivewire()"
                        class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                    <option value="">-- All Services Page (/services) --</option>
                    @foreach ($dynamicServices as $svc)
                        <option value="{{ $svc['slug'] }}">{{ $svc['title'] }} (/services#{{ $svc['slug'] }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- TYPE 4: EXTERNAL WEB URL -->
        <div x-show="link.type === 'external'" class="space-y-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Full Destination URL</label>
                <input type="url" 
                       x-model="link.url" 
                       @input="syncToLivewire()"
                       placeholder="https://example.com/portal" 
                       class="w-full px-3 py-1.5 text-xs font-mono rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
            </div>
        </div>

        <!-- TYPE 5: QUICK ACTION (PHONE, MAIL, WHATSAPP) -->
        <div x-show="link.type === 'action'" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Action Protocol</label>
                    <select x-model="link.action_type" 
                            @change="syncToLivewire()"
                            class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]">
                        <option value="tel">Direct Phone Call (tel:)</option>
                        <option value="mailto">Email Message (mailto:)</option>
                        <option value="whatsapp">WhatsApp Instant Chat (https://wa.me/)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Value (Leave blank for default)</label>
                    <input type="text" 
                           x-model="link.action_value" 
                           @input="syncToLivewire()"
                           :placeholder="link.action_type === 'mailto' ? 'duty@nordroy.com' : '+880 1700-000000'" 
                           class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58]" />
                </div>
            </div>
        </div>

        <!-- Bottom Controls: Target Blank & Computed Summary -->
        <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" 
                       x-model="link.target_blank" 
                       @change="syncToLivewire()"
                       class="w-3.5 h-3.5 rounded text-[#003C58] focus:ring-0" />
                <span class="text-slate-600 dark:text-slate-300 font-medium">Open in new tab (target="_blank")</span>
            </label>

            <span class="text-[10px] font-mono text-slate-400" x-text="'Resolved: ' + resolvedPreviewUrl"></span>
        </div>

    </div>

</div>

<script>
    if (typeof window.nordroySmartLinkPicker !== 'function') {
        window.nordroySmartLinkPicker = function(config) {
            return {
                isExpanded: false,
                sectionsMap: config.sectionsMap || {},
                showLabel: config.showLabel || false,
                link: {
                    type: 'internal',
                    page: 'home',
                    section: '',
                    service_slug: '',
                    url: '',
                    action_type: 'tel',
                    action_value: '',
                    target_blank: false,
                    label: '',
                },

                init() {
                    if (config.linkData) {
                        this.loadData(config.linkData);
                    }
                    this.$watch('config.linkData', (val) => {
                        this.loadData(val);
                    });
                },

                loadData(data) {
                    if (!data) return;
                    if (typeof data === 'string') {
                        if (data.startsWith('http://') || data.startsWith('https://')) {
                            this.link.type = 'external';
                            this.link.url = data;
                            this.link.target_blank = true;
                        } else if (data.startsWith('#')) {
                            this.link.type = 'anchor';
                            this.link.section = data.replace(/^#/, '');
                        } else if (data.startsWith('tel:') || data.startsWith('mailto:')) {
                            this.link.type = 'action';
                            this.link.action_type = data.startsWith('tel:') ? 'tel' : 'mailto';
                            this.link.action_value = data.split(':')[1] || '';
                        } else {
                            this.link.type = 'internal';
                            this.link.page = data.replace(/^\//, '').split('#')[0] || 'home';
                            this.link.section = data.split('#')[1] || '';
                        }
                    } else if (typeof data === 'object') {
                        this.link = Object.assign({}, this.link, data);
                    }
                },

                setType(newType) {
                    this.link.type = newType;
                    this.syncToLivewire();
                },

                onPageChange() {
                    this.link.section = '';
                    this.syncToLivewire();
                },

                get currentAvailableSections() {
                    const p = this.link.page || 'home';
                    return this.sectionsMap[p] || [];
                },

                get typeBadgeLabel() {
                    switch(this.link.type) {
                        case 'internal': return 'Internal Page';
                        case 'anchor': return 'Section Anchor';
                        case 'service': return 'Marine Service';
                        case 'external': return 'External URL';
                        case 'action': return 'Direct Action';
                        default: return 'Smart Link';
                    }
                },

                get typeBadgeClass() {
                    switch(this.link.type) {
                        case 'internal': return 'bg-blue-500/10 text-blue-600 dark:text-blue-400';
                        case 'anchor': return 'bg-purple-500/10 text-purple-600 dark:text-purple-400';
                        case 'service': return 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400';
                        case 'external': return 'bg-amber-500/10 text-amber-600 dark:text-amber-400';
                        case 'action': return 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400';
                        default: return 'bg-slate-100 text-slate-500';
                    }
                },

                get resolvedSummaryText() {
                    switch(this.link.type) {
                        case 'internal':
                            const pName = (this.link.page || 'home').toUpperCase();
                            return this.link.section ? `${pName} > #${this.link.section}` : `${pName} Page`;
                        case 'anchor':
                            return this.link.section ? `Jump to #${this.link.section}` : 'In-Page Anchor';
                        case 'service':
                            return this.link.service_slug ? `Service: ${this.link.service_slug}` : 'All Services';
                        case 'external':
                            return this.link.url || 'External Link';
                        case 'action':
                            return `${(this.link.action_type || 'tel').toUpperCase()}: ${this.link.action_value || 'Default'}`;
                        default:
                            return 'Configured Link';
                    }
                },

                get resolvedPreviewUrl() {
                    const host = window.location.origin;
                    switch(this.link.type) {
                        case 'internal':
                            const p = this.link.page === 'home' ? '' : `/${this.link.page}`;
                            const s = this.link.section ? `#${this.link.section}` : '';
                            return `${host}${p}${s}`;
                        case 'anchor':
                            return `#${this.link.section || ''}`;
                        case 'service':
                            return `${host}/services#${this.link.service_slug || ''}`;
                        case 'external':
                            return this.link.url || 'https://...';
                        case 'action':
                            if (this.link.action_type === 'tel') return `tel:${this.link.action_value || ''}`;
                            if (this.link.action_type === 'mailto') return `mailto:${this.link.action_value || ''}`;
                            if (this.link.action_type === 'whatsapp') return `https://wa.me/${this.link.action_value || ''}`;
                            return '#';
                        default:
                            return '#';
                    }
                },

                syncToLivewire() {
                    if (config.linkData && typeof config.linkData === 'object') {
                        // Deep clone to avoid proxy reactivity loops
                        const payload = JSON.parse(JSON.stringify(this.link));
                        for (let k in payload) {
                            config.linkData[k] = payload[k];
                        }
                    }
                }
            };
        };
    }
</script>
