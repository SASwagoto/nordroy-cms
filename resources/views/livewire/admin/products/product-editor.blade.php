<div class="space-y-6 max-w-7xl mx-auto pb-16">

    <!-- Top Navigation & Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                <a href="{{ route('admin.products') }}" wire:navigate class="hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors flex items-center gap-1">
                    <x-icon name="solid:arrow-left" class="w-3.5 h-3.5" />
                    <span>Back to Products</span>
                </a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-300 font-bold">
                    {{ $isEditing ? 'Edit Spare Part' : 'Add New Spare Part' }}
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                {{ $isEditing ? ($title[$activeLocale] ?? $title['en'] ?? 'Edit Spare Part') : 'Create New Spare Part' }}
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Configure technical specifications, OEM identifiers, multi-language descriptions, and media assets.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.products') }}" wire:navigate
               class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Cancel
            </a>

            <button type="button" wire:click="saveProduct" wire:loading.attr="disabled"
                    class="px-6 py-2.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs uppercase tracking-wider shadow-md active:scale-95 transition-all flex items-center gap-2 cursor-pointer disabled:opacity-60">
                <span wire:loading.remove wire:target="saveProduct" class="inline-flex items-center gap-1.5">
                    <x-icon name="solid:floppy-disk" class="w-3.5 h-3.5" />
                    <span>{{ $isEditing ? 'Update Spare Part' : 'Save & Publish' }}</span>
                </span>
                <span wire:loading.inline-flex wire:target="saveProduct" class="items-center gap-1.5" style="display: none;">
                    <svg class="animate-spin h-3.5 w-3.5 text-current" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Saving...</span>
                </span>
            </button>
        </div>
    </div>

    <!-- Quick Toast Notification for Instant Taxonomies -->
    @if(session()->has('taxonomy_quick_success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500" />
                <span>{{ session('taxonomy_quick_success') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer text-sm font-bold">&times;</button>
        </div>
    @endif

    <form wire:submit="saveProduct" class="space-y-6">

        <!-- Multi-Language Bar Strip -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mr-2 shrink-0">Localization:</span>
                @foreach($languages as $lang)
                    <button type="button" 
                            wire:click="setLocale('{{ $lang->code }}')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $activeLocale === $lang->code ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white' }}">
                        <span>{{ $lang->flag_icon ?: '🌐' }}</span>
                        <span>{{ $lang->native_name ?: strtoupper($lang->code) }}</span>
                    </button>
                @endforeach
            </div>
            <span class="text-[11px] text-slate-500 dark:text-slate-400 hidden sm:inline">
                Currently editing: <strong>{{ strtoupper($activeLocale) }}</strong>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- LEFT MAIN COLUMN: Core Info & Specs (8 cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- 1. Primary Identification & Titles -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 border-b border-slate-100 dark:border-slate-800 pb-2">
                        Product Title &amp; OEM Part Identifiers
                    </h3>

                    <!-- Title for Active Locale -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                Product / Part Title ({{ strtoupper($activeLocale) }}) <span class="text-rose-500">*</span>
                            </label>
                            @if($activeLocale === 'en')
                                <span class="text-[10px] text-cyan-600 dark:text-cyan-400 font-semibold">Primary (Slug Source)</span>
                            @endif
                        </div>
                        <input type="text" wire:model.live="title.{{ $activeLocale }}" 
                               placeholder="{{ $activeLocale === 'en' ? 'e.g. MAN NR24 Rotor Assembly Complete' : 'e.g. ম্যান NR24 সম্পূর্ণ রটার অ্যাসেম্বলি' }}"
                               class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                        @error("title.{$activeLocale}") <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        @error('title.en') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Part Number -->
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                OEM Part Number
                            </label>
                            <input type="text" wire:model="part_number" placeholder="e.g. MAN-NR24-RA-998"
                                   class="w-full px-3.5 py-2 text-xs font-mono font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            @error('part_number') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                URL Slug <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="slug" placeholder="e.g. man-nr24-rotor-assembly-complete"
                                   class="w-full px-3.5 py-2 text-xs font-mono font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            @error('slug') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Short Summary / Excerpt -->
                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                            Short Summary / Excerpt ({{ strtoupper($activeLocale) }})
                        </label>
                        <textarea wire:model="summary.{{ $activeLocale }}" rows="2"
                                  placeholder="One or two sentence summary displayed on product cards..."
                                  class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                    </div>

                    <!-- Detailed Description -->
                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                            Full Engineering Description ({{ strtoupper($activeLocale) }})
                        </label>
                        <textarea wire:model="description.{{ $activeLocale }}" rows="4"
                                  placeholder="Comprehensive technical details, manufacturing metallurgical standards, balancing compliance..."
                                  class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                    </div>
                </div>

                <!-- 2. Dynamic Category & Brand Taxonomies with Instant Quick-Add -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400 border-b border-slate-100 dark:border-slate-800 pb-2">
                        Taxonomy &amp; Manufacturer Classification
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Category Select + Quick Add Button -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                    Category <span class="text-rose-500">*</span>
                                </label>
                                <button type="button" 
                                        wire:click="openQuickCategoryModal" 
                                        class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 hover:bg-[#003C58]/20 transition-all inline-flex items-center gap-1 cursor-pointer">
                                    <x-icon name="solid:plus" class="w-3 h-3" />
                                    <span>New</span>
                                </button>
                            </div>
                            <select wire:model.live="category" class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="">-- Select Category --</option>
                                @foreach($categoriesList as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Brand Select + Quick Add Button -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                    Manufacturer / Brand <span class="text-rose-500">*</span>
                                </label>
                                <button type="button" 
                                        wire:click="openQuickBrandModal" 
                                        class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 hover:bg-[#003C58]/20 transition-all inline-flex items-center gap-1 cursor-pointer">
                                    <x-icon name="solid:plus" class="w-3 h-3" />
                                    <span>New</span>
                                </button>
                            </div>
                            <select wire:model.live="brand" class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="">-- Select Brand --</option>
                                @foreach($brandsList as $b)
                                    <option value="{{ $b }}">{{ $b }}</option>
                                @endforeach
                            </select>
                            @error('brand') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Commercial Logistics Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Compatible Engine / Turbocharger Models
                            </label>
                            <input type="text" wire:model="compatible_models" placeholder="e.g. MAN NR24/R, NR20, NR26"
                                   class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Part Condition
                            </label>
                            <select wire:model="condition" class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                <option value="Genuine New OEM">Genuine New OEM</option>
                                <option value="OEM Reconditioned &amp; Balanced">OEM Reconditioned &amp; Balanced</option>
                                <option value="Exchange Standard (CHRA)">Exchange Standard (CHRA)</option>
                                <option value="Marine Class Certified">Marine Class Certified</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Stock Status &amp; Warehouse Location
                            </label>
                            <input type="text" wire:model="stock_status" placeholder="e.g. In Stock (Central Warehouse)"
                                   class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Dispatch Lead Time
                            </label>
                            <input type="text" wire:model="lead_time" placeholder="e.g. Immediate Port Dispatch (24h)"
                                   class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                            Class Warranty Coverage
                        </label>
                        <input type="text" wire:model="warranty" placeholder="e.g. 12 Months Marine Warranty"
                               class="w-full px-3.5 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                    </div>
                </div>

                <!-- 3. Dynamic Technical Specifications Repeater -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-[#003C58] dark:text-cyan-400">
                                Engineering Specifications (Key-Value Pairs)
                            </h3>
                            <p class="text-[11px] text-slate-400">Dynamic technical rows rendered on the public product details table.</p>
                        </div>
                        <button type="button" wire:click="addSpecItem"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors inline-flex items-center gap-1 cursor-pointer">
                            <x-icon name="solid:plus" class="w-3.5 h-3.5" />
                            <span>Add Row</span>
                        </button>
                    </div>

                    <div class="space-y-2.5">
                        @foreach($specs as $index => $item)
                            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200/80 dark:border-slate-800">
                                <input type="text" wire:model="specs.{{ $index }}.key" placeholder="Parameter (e.g. Max RPM)"
                                       class="w-1/3 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                <input type="text" wire:model="specs.{{ $index }}.value" placeholder="Engineering Value (e.g. 48,000 RPM)"
                                       class="flex-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white">
                                <button type="button" wire:click="removeSpecItem({{ $index }})" 
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 transition-colors cursor-pointer" title="Remove row">
                                    <x-icon name="solid:trash" class="w-4 h-4" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDEBAR COLUMN: Media & Publishing Controls (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Publishing Status Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">
                        Catalog Visibility
                    </h3>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="w-4 h-4 rounded text-[#003C58] focus:ring-[#003C58]">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Publish to Public Catalog</span>
                            <span class="block text-[11px] text-slate-400">If unchecked, this part will be saved as an internal draft.</span>
                        </div>
                    </label>

                    <button type="submit" class="w-full py-3 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs uppercase tracking-wider shadow-md active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <x-icon name="solid:floppy-disk" class="w-4 h-4" />
                        <span>{{ $isEditing ? 'Save Changes' : 'Create Spare Part' }}</span>
                    </button>
                </div>

                <!-- Featured Image Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                            Featured Product Photo
                        </h3>
                        @if($featured_image_url)
                            <button type="button" wire:click="removeAsset('featured_image')" class="text-[10px] font-bold text-rose-500 hover:underline cursor-pointer">Remove</button>
                        @endif
                    </div>

                    <div class="relative aspect-4/3 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 overflow-hidden flex items-center justify-center">
                        @if($featured_image_url)
                            <img src="{{ $featured_image_url }}" alt="Featured Image" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-4 text-slate-400">
                                <x-icon name="solid:photo-film" class="w-10 h-10 mx-auto opacity-50 mb-1" />
                                <span class="text-[11px] block">No image selected</span>
                            </div>
                        @endif
                    </div>

                    <button type="button" 
                            @click="$dispatch('open-media-picker', { targetField: 'featured_image', multiple: false, defaultFolder: 'products' })"
                            class="w-full py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <x-icon name="solid:images" class="w-3.5 h-3.5" />
                        <span>{{ $featured_image_url ? 'Replace Image' : 'Select from Media Library' }}</span>
                    </button>
                </div>

                <!-- Product Gallery Photos Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                Product Gallery Photos
                            </h3>
                            <span class="text-[10px] text-slate-400">Additional angles &amp; details ({{ count($gallery_images) }})</span>
                        </div>
                        <button type="button" 
                                @click="$dispatch('open-media-picker', { targetField: 'gallery', multiple: true, selectedIds: @js(array_values(array_map(fn($item) => (int) $item['id'], $gallery_images))), defaultFolder: 'products' })"
                                class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-all inline-flex items-center gap-1 cursor-pointer">
                            <x-icon name="solid:plus" class="w-3 h-3" />
                            <span>Add Photo</span>
                        </button>
                    </div>

                    @if(count($gallery_images) > 0)
                        <div class="grid grid-cols-3 gap-2.5 max-h-60 overflow-y-auto p-1">
                            @foreach($gallery_images as $index => $gImg)
                                <div class="group relative aspect-square rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden shadow-2xs">
                                    <img src="{{ $gImg['url'] }}" alt="Gallery Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1">
                                        <button type="button" wire:click="removeGalleryImage({{ $index }})" 
                                                class="p-1 rounded-md bg-rose-600 hover:bg-rose-700 text-white cursor-pointer transition-colors"
                                                title="Delete photo">
                                            <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                    <span class="absolute bottom-1 left-1 px-1 py-0.5 rounded text-[8px] font-mono font-bold bg-black/60 text-white pointer-events-none">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 rounded-xl border border-dashed border-slate-200 dark:border-slate-800 text-center text-slate-400 space-y-1">
                            <x-icon name="solid:images" class="w-6 h-6 mx-auto opacity-40" />
                            <p class="text-[11px]">No gallery photos attached yet.</p>
                            <button type="button" 
                                    @click="$dispatch('open-media-picker', { targetField: 'gallery', multiple: true, selectedIds: @js(array_values(array_map(fn($item) => (int) $item['id'], $gallery_images))), defaultFolder: 'products' })"
                                    class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 hover:underline cursor-pointer">
                                + Add photo from Media Library
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Technical PDF Brochure Card -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                            Technical Spec Sheet (PDF)
                        </h3>
                        @if($brochure_media_url)
                            <button type="button" wire:click="removeAsset('brochure')" class="text-[10px] font-bold text-rose-500 hover:underline cursor-pointer">Remove</button>
                        @endif
                    </div>

                    @if($brochure_media_url)
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 truncate">
                                <x-icon name="solid:file-pdf" class="w-5 h-5 text-rose-500 shrink-0" />
                                <span class="text-xs font-mono font-bold truncate text-slate-800 dark:text-slate-200">Attached PDF</span>
                            </div>
                            <a href="{{ $brochure_media_url }}" target="_blank" class="text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:underline shrink-0">Preview</a>
                        </div>
                    @else
                        <p class="text-xs text-slate-400">Attach an engineering blueprint, tolerance sheet, or class certificate PDF for customer download.</p>
                    @endif

                    <button type="button" 
                            @click="$dispatch('open-media-picker', { targetField: 'brochure', multiple: false, defaultFolder: 'products' })"
                            class="w-full py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <x-icon name="solid:file-pdf" class="w-3.5 h-3.5" />
                        <span>{{ $brochure_media_url ? 'Replace Document' : 'Attach Technical Document' }}</span>
                    </button>
                </div>

                <!-- Video Showcase Card (YouTube) -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <div class="flex items-center gap-2">
                            <x-icon name="solid:video" class="w-4 h-4 text-rose-500" />
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-white">
                                Product Video (YouTube)
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
                               placeholder="e.g. https://www.youtube.com/watch?v=dQw4w9WgXcQ"
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

    <!-- ==================== QUICK ADD CATEGORY MODAL (Clean Z-50 On Page) ==================== -->
    @if($showQuickCategoryModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" wire:click="closeQuickCategoryModal"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10"
                     @click.stop>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:folder-plus" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Quick Add Category</h3>
                        </div>
                        <button type="button" wire:click="closeQuickCategoryModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Category Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="newCategoryName" placeholder="e.g. Turbine Casings &amp; Inlets"
                                   wire:keydown.enter.prevent="saveQuickCategory"
                                   class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('newCategoryName') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                            The category will be immediately saved to the database and auto-selected for this spare part.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="closeQuickCategoryModal" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" wire:click="saveQuickCategory"
                                class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm cursor-pointer">
                            Save &amp; Select
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ==================== QUICK ADD BRAND MODAL (Clean Z-50 On Page) ==================== -->
    @if($showQuickBrandModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" wire:click="closeQuickBrandModal"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10"
                     @click.stop>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:industry" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Quick Add Manufacturer</h3>
                        </div>
                        <button type="button" wire:click="closeQuickBrandModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Manufacturer / Brand Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model="newBrandName" placeholder="e.g. KBB Turbochargers"
                                   wire:keydown.enter.prevent="saveQuickBrand"
                                   class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('newBrandName') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                            The brand will be immediately saved to the database and auto-selected for this spare part.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="closeQuickBrandModal" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" wire:click="saveQuickBrand"
                                class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm cursor-pointer">
                            Save &amp; Select
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Global Unified Media Library & In-Modal Upload Modal (Single & Multi-Select) -->
    <x-media-picker-modal />

</div>
