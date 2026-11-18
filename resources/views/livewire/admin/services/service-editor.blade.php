<div class="space-y-6">

    <!-- Pickers Included at Root -->
    <x-icon-picker-modal />
    <x-media-picker-modal />

    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('admin.services') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                    Services &amp; Overhauls
                </a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200 font-semibold">
                    {{ $isEditing ? 'Edit Service' : 'Add New Service' }}
                </span>
            </nav>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center shrink-0">
                    <x-icon :name="$icon ?: 'solid:wrench'" class="w-5 h-5" />
                </div>
                <div>
                    <h1 class="text-2xl font-black font-heading text-slate-900 dark:text-white tracking-tight">
                        {{ $isEditing ? ($title_en ?: 'Edit Service') : 'Create New Marine Service' }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $isEditing ? 'Modify service specifications, rich descriptions, YouTube video showcase, and media.' : 'Register a new precision overhaul or dynamic balancing service.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.services') }}" 
               class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition-colors inline-flex items-center gap-2 cursor-pointer shadow-2xs">
                <x-icon name="solid:arrow-left" class="w-3.5 h-3.5" />
                <span>Cancel &amp; Back</span>
            </a>

            <button type="button" wire:click="save"
                    class="px-5 py-2.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 text-xs font-bold uppercase tracking-wider shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer active:scale-95">
                <x-icon name="solid:floppy-disk" class="w-4 h-4" />
                <span>{{ $isEditing ? 'Save Changes' : 'Create Service' }}</span>
            </button>
        </div>
    </div>

    <!-- Main Editor Grid Form -->
    <form wire:submit="save">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: Content & Localized Information (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- 1. Localized Identity & Multi-Language Section -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-5">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3 flex-wrap gap-2">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400">
                                Localized Information
                            </h3>
                            <p class="text-[11px] text-slate-400">Manage service title, summary, and rich text across all configured languages.</p>
                        </div>

                        <!-- Language Switcher Tabs -->
                        <div class="flex items-center gap-1.5 p-1 rounded-xl bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            @foreach($languages as $lang)
                                <button type="button" 
                                        wire:click="setLocale('{{ $lang->code }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer {{ $activeLocale === $lang->code ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' }}">
                                    <span>{{ $lang->flag_icon ?? '🌐' }}</span>
                                    <span>{{ $lang->native_name ?? strtoupper($lang->code) }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Localized Inputs for Each Language -->
                    @foreach($languages as $lang)
                        <div wire:key="service-lang-pane-{{ $lang->code }}" 
                             x-show="$wire.activeLocale === '{{ $lang->code }}'" 
                             class="space-y-4"
                             style="{{ $activeLocale === $lang->code ? '' : 'display: none;' }}">

                            <!-- Title -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Service Title ({{ $lang->name }})
                                    @if($lang->code === 'en') <span class="text-rose-500">*</span> @endif
                                </label>
                                @if($lang->code === 'en')
                                    <input type="text" wire:model.live.debounce.300ms="title_en" placeholder="e.g. Dynamic High-Speed Balancing (Rotor &amp; Shaft)"
                                           class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                                    @error('title_en') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                @elseif($lang->code === 'bn')
                                    <input type="text" wire:model="title_bn" placeholder="যেমন: হাই-স্পিড ডাইনামিক ব্যালেন্সিং"
                                           class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                                @else
                                    <input type="text" wire:model="title.{{ $lang->code }}" placeholder="Title in {{ $lang->name }}"
                                           class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                                @endif
                            </div>

                            <!-- Short Summary -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Short Summary ({{ $lang->name }})
                                </label>
                                @if($lang->code === 'en')
                                    <textarea wire:model="short_summary_en" rows="2" placeholder="Brief 1-2 sentence executive overview shown on service cards and grids."
                                              class="w-full px-3.5 py-2.5 text-xs font-normal rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500"></textarea>
                                @elseif($lang->code === 'bn')
                                    <textarea wire:model="short_summary_bn" rows="2" placeholder="সার্ভিস কার্ড এবং তালিকায় প্রদর্শনের জন্য সংক্ষিপ্ত বিবরণ।"
                                              class="w-full px-3.5 py-2.5 text-xs font-normal rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500"></textarea>
                                @else
                                    <textarea wire:model="short_summary.{{ $lang->code }}" rows="2" placeholder="Short summary in {{ $lang->name }}"
                                              class="w-full px-3.5 py-2.5 text-xs font-normal rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500"></textarea>
                                @endif
                            </div>

                            <!-- Rich Content with Quill Editor -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Comprehensive Description &amp; Engineering Scope ({{ $lang->name }})
                                </label>
                                @if($lang->code === 'en')
                                    <x-quill-editor wire:model="content_en" placeholder="Write full service breakdown, technical procedures, machinery used..." minHeight="240px" />
                                @elseif($lang->code === 'bn')
                                    <x-quill-editor wire:model="content_bn" placeholder="সার্ভিসের পূর্ণ বিবরণ, প্রযুক্তিগত প্রক্রিয়া, কাজের পরিধি..." minHeight="240px" />
                                @else
                                    <x-quill-editor wire:model="content.{{ $lang->code }}" placeholder="Full content in {{ $lang->name }}" minHeight="240px" />
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>

                <!-- 2. URL Slug & Identifiers -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 border-b border-slate-100 dark:border-slate-800 pb-2">
                        Routing &amp; Identifiers
                    </h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                            URL Slug <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center">
                            <span class="px-3.5 py-2.5 text-xs font-mono bg-slate-100 dark:bg-slate-800 border border-r-0 border-slate-200 dark:border-slate-700 text-slate-400 rounded-l-xl">
                                {{ url('/services') }}/
                            </span>
                            <input type="text" wire:model="slug" placeholder="e.g. dynamic-rotor-balancing"
                                   class="flex-1 px-3.5 py-2.5 text-xs font-mono rounded-r-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                        </div>
                        @error('slug') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDEBAR COLUMN: Media, Icon, Video & Publishing Controls (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Publishing Status Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">
                        Publishing Status
                    </h3>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="w-4 h-4 rounded text-[#003C58] focus:ring-[#003C58]">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Active Online</span>
                            <span class="block text-[11px] text-slate-400">Visible to public visitors in services catalog.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50 cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="w-4 h-4 rounded text-amber-500 focus:ring-amber-500">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Featured on Homepage</span>
                            <span class="block text-[11px] text-slate-400">Highlights this service on the landing page showcase grid.</span>
                        </div>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                            Display Sort Order
                        </label>
                        <input type="number" wire:model="order" min="0" 
                               class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        <p class="text-[10px] text-slate-400 mt-1">Lower numbers appear first in the catalog.</p>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs uppercase tracking-wider shadow-md active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <x-icon name="solid:floppy-disk" class="w-4 h-4" />
                        <span>{{ $isEditing ? 'Save Changes' : 'Create Service' }}</span>
                    </button>
                </div>

                <!-- Service Icon Selector Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                            Service Icon
                        </h3>
                        <span class="text-[10px] font-mono text-slate-400">{{ $icon }}</span>
                    </div>

                    <div class="flex items-center gap-4 p-3 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                        <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-[#003C58] dark:text-cyan-400 flex items-center justify-center shrink-0 shadow-xs">
                            <x-icon :name="$icon ?: 'solid:wrench'" class="w-7 h-7" />
                        </div>
                        <div class="flex-1">
                            <button type="button" 
                                    @click="$dispatch('open-icon-picker', { targetField: 'icon' })"
                                    class="w-full py-2 px-3 rounded-xl bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <x-icon name="solid:shapes" class="w-3.5 h-3.5" />
                                <span>Change Icon</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Featured Cover Image Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                            Service Cover Image
                        </h3>
                        @if($featured_image_url)
                            <button type="button" wire:click="removeAsset('featured_image')" class="text-[10px] font-bold text-rose-500 hover:underline cursor-pointer">Remove</button>
                        @endif
                    </div>

                    <div class="relative aspect-16/10 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 overflow-hidden flex items-center justify-center">
                        @if($featured_image_url)
                            <img src="{{ $featured_image_url }}" alt="Featured Image" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-4 text-slate-400">
                                <x-icon name="solid:photo-film" class="w-10 h-10 mx-auto opacity-50 mb-1" />
                                <span class="text-[11px] block">No cover photo selected</span>
                            </div>
                        @endif
                    </div>

                    <button type="button" 
                            @click="$dispatch('open-media-picker', { targetField: 'featured_image', multiple: false, defaultFolder: 'services' })"
                            class="w-full py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <x-icon name="solid:images" class="w-3.5 h-3.5" />
                        <span>{{ $featured_image_url ? 'Replace Cover Image' : 'Select from Media Library' }}</span>
                    </button>
                </div>

                <!-- Video Showcase Card (YouTube) -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <div class="flex items-center gap-2">
                            <x-icon name="solid:video" class="w-4 h-4 text-rose-500" />
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                Service Video (YouTube)
                            </h3>
                        </div>
                        @if(!empty($video_url))
                            <button type="button" wire:click="$set('video_url', '')" class="text-[10px] font-bold text-rose-500 hover:underline cursor-pointer">Clear</button>
                        @endif
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                            YouTube Video URL
                        </label>
                        <input type="text" wire:model.live.debounce.300ms="video_url" 
                               placeholder="e.g. https://www.youtube.com/watch?v=9No-FiEInLA"
                               class="w-full px-3 py-2 text-xs font-mono rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                        <p class="text-[10px] text-slate-400 mt-1">Supports standard YouTube URLs, short links (youtu.be), or shorts.</p>
                    </div>

                    @if($this->youtubeId)
                        <div class="space-y-1.5 pt-1">
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                <x-icon name="solid:check-circle" class="w-3.5 h-3.5" />
                                Valid YouTube ID: <span class="font-mono">{{ $this->youtubeId }}</span>
                            </span>
                            <div class="relative aspect-video rounded-xl overflow-hidden bg-slate-950 border border-slate-200 dark:border-slate-700 shadow-inner">
                                <iframe src="https://www.youtube-nocookie.com/embed/{{ $this->youtubeId }}" 
                                        class="w-full h-full" 
                                        title="YouTube video preview" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </form>

</div>
