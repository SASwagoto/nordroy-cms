<div class="space-y-6">
    <!-- Top Action Bar & Header Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight font-heading">
                    Products &amp; Spare Parts
                </h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span>
                    Industrial Catalog
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Manage OEM marine turbocharger spare parts, rotor shafts, core cartridges, nozzle rings, and technical datasheets.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('products') }}" target="_blank"
               class="px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
                <x-icon name="solid:arrow-top-right-on-square" class="w-3.5 h-3.5" />
                <span>Public Catalog</span>
            </a>

            <button type="button" 
                    wire:click="openManageTaxonomiesModal('categories')"
                    class="px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 cursor-pointer">
                <x-icon name="solid:tag" class="w-3.5 h-3.5 text-cyan-500" />
                <span>Categories &amp; Brands</span>
            </button>

            <button type="button" 
                    wire:click="createProduct"
                    class="px-4 py-2 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs shadow-md transition-all flex items-center gap-2 cursor-pointer active:scale-95">
                <x-icon name="solid:plus" class="w-4 h-4" />
                <span>Add Spare Part</span>
            </button>
        </div>
    </div>

    <!-- Flash Notification -->
    @if (session()->has('message'))
        <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-500" />
                <span>{{ session('message') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Quick Metrics Strip -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block mb-1">Total Catalog</span>
            <span class="text-xl font-black text-slate-900 dark:text-white font-mono">{{ $totalCount }}</span>
            <span class="text-[10px] text-slate-400 ml-1">Items</span>
        </div>
        <div class="p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-500 block mb-1">Active / Published</span>
            <span class="text-xl font-black text-emerald-600 dark:text-emerald-400 font-mono">{{ $activeCount }}</span>
            <span class="text-[10px] text-slate-400 ml-1">Live</span>
        </div>
        <div class="p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
            <span class="text-[10px] uppercase font-bold tracking-wider text-cyan-500 block mb-1">In Stock (Warehouse)</span>
            <span class="text-xl font-black text-[#003C58] dark:text-cyan-400 font-mono">{{ $inStockCount }}</span>
            <span class="text-[10px] text-slate-400 ml-1">Ready</span>
        </div>
        <div class="p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs">
            <span class="text-[10px] uppercase font-bold tracking-wider text-amber-500 block mb-1">Lead Time</span>
            <span class="text-base font-black text-slate-900 dark:text-white">24-48 Hours</span>
            <span class="text-[10px] text-slate-400 block">Port Delivery</span>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col md:flex-row items-center gap-3">
        <!-- Search Input -->
        <div class="relative flex-1 w-full">
            <x-icon name="solid:magnifying-glass" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   placeholder="Search by part number, model, brand, or title..." 
                   class="w-full pl-9 pr-4 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500" />
            @if(!empty($search))
                <button type="button" wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-slate-600">&times;</button>
            @endif
        </div>

        <!-- Filter: Category -->
        <select wire:model.live="categoryFilter" 
                class="w-full md:w-44 px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
            <option value="all">All Categories</option>
            @foreach($categoriesList as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

        <!-- Filter: Brand -->
        <select wire:model.live="brandFilter" 
                class="w-full md:w-48 px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
            <option value="all">All Manufacturers</option>
            @foreach($brandsList as $b)
                <option value="{{ $b }}">{{ $b }}</option>
            @endforeach
        </select>

        <!-- Filter: Status -->
        <select wire:model.live="statusFilter" 
                class="w-full md:w-32 px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
            <option value="all">All Status</option>
            <option value="active">Active Only</option>
            <option value="inactive">Inactive Only</option>
        </select>
    </div>

    <!-- Products Table -->
    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-950/70 border-b border-slate-200 dark:border-slate-800 text-[10px] uppercase font-bold text-slate-500 tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Part / Image</th>
                        <th class="py-3 px-4">Part Number &amp; OEM Code</th>
                        <th class="py-3 px-4">Category &amp; Brand</th>
                        <th class="py-3 px-4">Condition &amp; Stock</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 font-medium">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <!-- Image + Title -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden shrink-0 flex items-center justify-center shadow-2xs">
                                        @if($product->featuredImage)
                                            <img src="{{ $product->featuredImage->url }}" alt="{{ $product->display_title }}" class="w-full h-full object-cover">
                                        @else
                                            <x-icon name="solid:cog" class="w-6 h-6 text-slate-400" />
                                        @endif
                                    </div>
                                    <div class="min-w-0 max-w-xs">
                                        <a href="{{ route('product.details', $product->slug) }}" target="_blank" 
                                           class="font-bold text-slate-900 dark:text-white hover:text-[#003C58] dark:hover:text-cyan-400 transition-colors block truncate"
                                           title="{{ $product->display_title }}">
                                            {{ $product->display_title }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block truncate">
                                            {{ $product->compatible_models ?: 'Marine & Industrial Turbochargers' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Part Number -->
                            <td class="py-3.5 px-4">
                                @if(!empty($product->part_number))
                                    <span class="inline-flex items-center gap-1 font-mono text-[11px] font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                                        <x-icon name="solid:tag" class="w-3 h-3 text-[#003C58] dark:text-cyan-400" />
                                        <span>{{ $product->part_number }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">No Part #</span>
                                @endif
                            </td>

                            <!-- Category & Brand -->
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800 dark:text-slate-200 block">
                                    {{ $product->category }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    {{ $product->brand }}
                                </span>
                            </td>

                            <!-- Condition & Stock -->
                            <td class="py-3.5 px-4">
                                <div class="space-y-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 border border-[#003C58]/20 dark:border-cyan-500/30">
                                        {{ $product->condition }}
                                    </span>
                                    <span class="block text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">
                                        &bull; {{ $product->stock_status }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-3.5 px-4 text-center">
                                <button type="button" 
                                        wire:click="toggleStatus({{ $product->id }})"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition-all cursor-pointer {{ $product->is_active ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $product->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $product->is_active ? 'Active' : 'Draft' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Public Link -->
                                    <a href="{{ route('product.details', $product->slug) }}" target="_blank"
                                       title="View Public Details Page"
                                       class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-cyan-500 hover:border-cyan-500 transition-colors">
                                        <x-icon name="solid:arrow-top-right-on-square" class="w-3.5 h-3.5" />
                                    </a>

                                    <!-- Duplicate -->
                                    <button type="button" 
                                            wire:click="duplicateProduct({{ $product->id }})"
                                            title="Duplicate Part"
                                            class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors cursor-pointer">
                                        <x-icon name="solid:document-duplicate" class="w-3.5 h-3.5" />
                                    </button>

                                    <!-- Edit -->
                                    <button type="button" 
                                            wire:click="editProduct({{ $product->id }})"
                                            title="Edit Part Details"
                                            class="p-1.5 rounded-lg bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-300 hover:bg-[#003C58]/20 transition-colors cursor-pointer">
                                        <x-icon name="solid:pencil-square" class="w-3.5 h-3.5" />
                                    </button>

                                    <!-- Delete -->
                                    <button type="button" 
                                            wire:click="confirmDelete({{ $product->id }})"
                                            title="Delete Part"
                                            class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-500 hover:border-rose-300 transition-colors cursor-pointer">
                                        <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <x-icon name="solid:cog" class="w-10 h-10 mx-auto text-slate-300 dark:text-slate-700 mb-2" />
                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">No spare parts found.</p>
                                <p class="text-xs text-slate-400 mt-0.5">Try changing your search terms or create a new spare part entry.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- ==================== CREATE / EDIT MODAL ==================== -->
    @if($isFormModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" wire:click="$set('isFormModalOpen', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-4xl rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 space-y-6">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white font-heading">
                                {{ $editingProductId ? 'Edit Spare Part: ' . $title_en : 'Add New Spare Part / Product' }}
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Specify part identification, technical tolerances, metallurgy, and compatible marine models.
                            </p>
                        </div>
                        <button type="button" wire:click="$set('isFormModalOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold">&times;</button>
                    </div>

                    @if (session()->has('taxonomy_quick_success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                             class="p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center justify-between shadow-xs">
                            <div class="flex items-center gap-2">
                                <x-icon name="solid:check-circle" class="w-4 h-4 text-emerald-500" />
                                <span>{{ session('taxonomy_quick_success') }}</span>
                            </div>
                            <button type="button" @click="show = false" class="text-emerald-500 cursor-pointer">&times;</button>
                        </div>
                    @endif

                    <!-- Modal Body / Form Grid -->
                    <form wire:submit.prevent="saveProduct" class="space-y-6">

                        <!-- Multi-Language Switcher Tabs -->
                        <div class="flex items-center justify-between p-2 rounded-2xl bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-2">Language:</span>
                                @foreach($this->languages as $lang)
                                    <button type="button" 
                                            wire:click="setLocale('{{ $lang->code }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $activeLocale === $lang->code ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-900 hover:text-slate-900 dark:hover:text-white' }}">
                                        <span>{{ $lang->flag_icon ?? '🌐' }}</span>
                                        <span>{{ $lang->name }} ({{ strtoupper($lang->code) }})</span>
                                        @if($lang->is_default)
                                            <span class="text-[9px] px-1.5 py-0.5 rounded-md bg-white/20 font-mono">Default</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 hidden sm:inline">
                                Editing: <strong class="text-slate-800 dark:text-slate-200 uppercase">{{ $activeLocale }}</strong>
                            </span>
                        </div>

                        <!-- Row 1: Active Language Title -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                    Part Title ({{ strtoupper($activeLocale) }})
                                    @if($activeLocale === 'en')
                                        <span class="text-rose-500">*</span>
                                    @else
                                        <span class="text-[10px] font-normal text-slate-400">(Optional - defaults to English)</span>
                                    @endif
                                </label>
                            </div>
                            <input type="text" 
                                   wire:model.live="title.{{ $activeLocale }}" 
                                   placeholder="e.g. MAN NR24/R Rotor Assembly ({{ strtoupper($activeLocale) }})"
                                   dir="{{ $this->activeLanguageDirection }}"
                                   class="w-full px-3 py-2 text-xs font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#003C58]">
                            @error('title.' . $activeLocale) <span class="text-[10px] text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Row 2: Part Number, Slug, Category, Brand -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Part Number / OEM Code
                                </label>
                                <input type="text" wire:model.live="part_number" placeholder="e.g. MAN-NR24-RTR-901"
                                       class="w-full px-3 py-2 text-xs font-mono font-bold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    URL Slug <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" wire:model.live="slug" placeholder="man-nr24r-rotor-assembly"
                                       class="w-full px-3 py-2 text-xs font-mono rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                @error('slug') <span class="text-[10px] text-rose-500 font-semibold">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                        Category <span class="text-rose-500">*</span>
                                    </label>
                                    <button type="button" 
                                            wire:click="openQuickCategoryModal" 
                                            class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 hover:underline inline-flex items-center gap-0.5 cursor-pointer">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span>+ New</span>
                                    </button>
                                </div>
                                <select wire:model.live="category" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categoriesList as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                        Manufacturer / Brand <span class="text-rose-500">*</span>
                                    </label>
                                    <button type="button" 
                                            wire:click="openQuickBrandModal" 
                                            class="text-[10px] font-bold text-[#003C58] dark:text-cyan-400 hover:underline inline-flex items-center gap-0.5 cursor-pointer">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span>+ New</span>
                                    </button>
                                </div>
                                <select wire:model.live="brand" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="">-- Select Brand --</option>
                                    @foreach($brandsList as $b)
                                        <option value="{{ $b }}">{{ $b }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: Compatible Models, Condition, Stock Status, Lead Time -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Compatible Engine / Turbos
                                </label>
                                <input type="text" wire:model.live="compatible_models" placeholder="MAN NR15, NR20, NR24"
                                       class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Condition
                                </label>
                                <select wire:model.live="condition" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                    <option value="Genuine New OEM">Genuine New OEM</option>
                                    <option value="Class Certified Reconditioned">Class Certified Reconditioned</option>
                                    <option value="Pre-Balanced Exchange Core">Pre-Balanced Exchange Core</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Stock Availability
                                </label>
                                <input type="text" wire:model.live="stock_status" placeholder="In Stock (Central Warehouse)"
                                       class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Dispatch Lead Time
                                </label>
                                <input type="text" wire:model.live="lead_time" placeholder="Immediate Port Dispatch (24h)"
                                       class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>

                        <!-- Row 4: Technical Specifications Repeater (Key-Value) -->
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <x-icon name="solid:cpu-chip" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                                    <span>Technical Specifications &amp; Engineering Metrics</span>
                                </span>
                                <button type="button" 
                                        wire:click="addSpecItem"
                                        class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#003C58]/10 text-[#003C58] dark:bg-cyan-500/20 dark:text-cyan-400 hover:bg-[#003C58]/20 transition-colors flex items-center gap-1 cursor-pointer">
                                    <x-icon name="solid:plus" class="w-3 h-3" />
                                    <span>Add Parameter</span>
                                </button>
                            </div>

                            <div class="space-y-2">
                                @forelse($specs as $sIdx => $spec)
                                    <div class="flex items-center gap-2">
                                        <input type="text" 
                                               wire:model.live="specs.{{ $sIdx }}.key" 
                                               placeholder="Parameter (e.g. Max Speed, Metallurgy, Balancing Grade)"
                                               class="w-1/3 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                        <input type="text" 
                                               wire:model.live="specs.{{ $sIdx }}.value" 
                                               placeholder="Value (e.g. 48,000 RPM, Inconel 713C, ISO 1940 Grade G1.0)"
                                               class="flex-1 px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white">
                                        <button type="button" 
                                                wire:click="removeSpecItem({{ $sIdx }})"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 transition-colors cursor-pointer"
                                                title="Remove Parameter">
                                            <x-icon name="solid:trash" class="w-4 h-4" />
                                        </button>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No technical parameters added yet. Click &quot;Add Parameter&quot; to define tolerances.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Row 5: Summary & Description (Active Language) -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Short Summary / Scope ({{ strtoupper($activeLocale) }})
                                </label>
                                <textarea wire:model.live="summary.{{ $activeLocale }}" rows="2" 
                                          placeholder="Brief technical summary in {{ strtoupper($activeLocale) }}..."
                                          dir="{{ $this->activeLanguageDirection }}"
                                          class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Full Engineering Description &amp; Inspection Protocols ({{ strtoupper($activeLocale) }})
                                </label>
                                <textarea wire:model.live="description.{{ $activeLocale }}" rows="4" 
                                          placeholder="Detailed metallurgical overview, balancing certification, and warranty in {{ strtoupper($activeLocale) }}..."
                                          dir="{{ $this->activeLanguageDirection }}"
                                          class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                            </div>
                        </div>

                        <!-- Row 6: Image & Brochure Attachment -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800">
                            <!-- Featured Image -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Part Photo / Image
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($featured_image_url)
                                            <img src="{{ $featured_image_url }}" alt="Preview" class="w-full h-full object-cover">
                                        @else
                                            <x-icon name="solid:photo" class="w-6 h-6 text-slate-400" />
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <button type="button" 
                                                wire:click="openMediaPicker('featured_image')"
                                                class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:border-[#003C58] text-slate-700 dark:text-slate-200 cursor-pointer shadow-2xs">
                                            Browse Library
                                        </button>
                                        @if($featured_image_id)
                                            <button type="button" wire:click="removeAsset('featured_image')" class="block text-[10px] text-rose-500 font-semibold hover:underline">Remove</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- PDF Datasheet -->
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Technical Datasheet (PDF)
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 shrink-0 flex items-center justify-center">
                                        <x-icon name="solid:document-arrow-down" class="w-6 h-6 text-cyan-600 dark:text-cyan-400" />
                                    </div>
                                    <div class="space-y-1">
                                        <button type="button" 
                                                wire:click="openMediaPicker('brochure')"
                                                class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:border-[#003C58] text-slate-700 dark:text-slate-200 cursor-pointer shadow-2xs">
                                            {{ $brochure_media_id ? 'Change PDF' : 'Attach PDF File' }}
                                        </button>
                                        @if($brochure_media_id)
                                            <button type="button" wire:click="removeAsset('brochure')" class="block text-[10px] text-rose-500 font-semibold hover:underline">Remove</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Toggle -->
                        <div class="flex items-center justify-between pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" wire:model.live="is_active" class="w-4 h-4 rounded text-[#003C58]">
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Publish immediately to public catalog</span>
                            </label>

                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="$set('isFormModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700 dark:hover:text-white">Cancel</button>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#003C58] hover:bg-[#024a6d] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 font-bold text-xs shadow-md cursor-pointer">
                                    {{ $editingProductId ? 'Save Changes' : 'Create Spare Part' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- ==================== DELETE MODAL ==================== -->
    @if($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="w-full max-w-md rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 space-y-4 shadow-xl">
                <div class="flex items-center gap-3 text-rose-600">
                    <x-icon name="solid:exclamation-triangle" class="w-6 h-6" />
                    <h3 class="text-base font-bold font-heading">Delete Spare Part?</h3>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400">
                    Are you sure you want to permanently delete <strong>{{ $productNameToDelete }}</strong>? This action cannot be undone.
                </p>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" wire:click="$set('isDeleteModalOpen', false)" class="px-3 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-400">Cancel</button>
                    <button type="button" wire:click="deleteProduct" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold cursor-pointer">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ==================== MEDIA PICKER MODAL ==================== -->
    @if($isMediaPickerOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" wire:click="$set('isMediaPickerOpen', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-3xl rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 space-y-4 shadow-2xl">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Select from Media Library</h3>
                        <button type="button" wire:click="$set('isMediaPickerOpen', false)" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
                    </div>

                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 max-h-96 overflow-y-auto p-1">
                        @forelse($mediaAssets as $asset)
                            <div wire:click="selectAsset({{ $asset->id }}, '{{ $asset->url }}')"
                                 class="group relative aspect-square rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden cursor-pointer hover:ring-2 hover:ring-[#003C58] dark:hover:ring-cyan-500 transition-all">
                                @if(str_starts_with($asset->mime_type ?? '', 'image/'))
                                    <img src="{{ $asset->url }}" alt="{{ $asset->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center p-2 text-center">
                                        <x-icon name="solid:document-text" class="w-8 h-8 text-cyan-500" />
                                        <span class="text-[9px] font-bold text-slate-600 dark:text-slate-400 truncate w-full mt-1">{{ $asset->name }}</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="px-2 py-1 rounded bg-white text-slate-900 text-[10px] font-bold">Select</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-6 py-8 text-center text-slate-400 text-xs">
                                No media uploaded yet. Upload images in Media Manager first.
                            </div>
                        @endforelse
                    </div>

                    <div class="flex justify-end pt-2 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('isMediaPickerOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ==================== QUICK CREATE CATEGORY MODAL ==================== -->
    @if($showQuickCategoryModal)
        <div class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" wire:click="closeQuickCategoryModal"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:tag" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Quick Add Category</h3>
                        </div>
                        <button type="button" wire:click="closeQuickCategoryModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Category Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="newCategoryName" 
                               wire:keydown.enter.prevent="saveQuickCategory"
                               placeholder="e.g. Heat Exchangers &amp; Coolers" 
                               autofocus
                               class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                        @error('newCategoryName') 
                            <span class="text-rose-500 text-[10px] font-semibold block">{{ $message }}</span> 
                        @enderror
                        <p class="text-[11px] text-slate-400">
                            The category will be saved to the database immediately and auto-selected for this product.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" 
                                wire:click="closeQuickCategoryModal" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" 
                                wire:click="saveQuickCategory" 
                                class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm cursor-pointer">
                            Create &amp; Select
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ==================== QUICK CREATE BRAND MODAL ==================== -->
    @if($showQuickBrandModal)
        <div class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" wire:click="closeQuickBrandModal"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:building" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Quick Add Manufacturer / Brand</h3>
                        </div>
                        <button type="button" wire:click="closeQuickBrandModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            Manufacturer / Brand Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="newBrandName" 
                               wire:keydown.enter.prevent="saveQuickBrand"
                               placeholder="e.g. IHI Corporation" 
                               autofocus
                               class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                        @error('newBrandName') 
                            <span class="text-rose-500 text-[10px] font-semibold block">{{ $message }}</span> 
                        @enderror
                        <p class="text-[11px] text-slate-400">
                            The brand will be saved to the database immediately and auto-selected for this product.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" 
                                wire:click="closeQuickBrandModal" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                            Cancel
                        </button>
                        <button type="button" 
                                wire:click="saveQuickBrand" 
                                class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm cursor-pointer">
                            Create &amp; Select
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ==================== TAXONOMIES MANAGEMENT MODAL ==================== -->
    @if($showManageTaxonomiesModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" wire:click="closeManageTaxonomiesModal"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-2xl rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Taxonomies Manager</span>
                            <h2 class="text-base font-bold text-slate-900 dark:text-white font-heading">
                                Product Categories &amp; Brands
                            </h2>
                        </div>
                        <button type="button" wire:click="closeManageTaxonomiesModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    @if (session()->has('taxonomy_manager_success'))
                        <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold flex items-center justify-between">
                            <span>{{ session('taxonomy_manager_success') }}</span>
                            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500">&times;</button>
                        </div>
                    @endif

                    <!-- Tabs: Categories vs Brands -->
                    <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <button type="button" 
                                wire:click="$set('taxonomyActiveTab', 'categories')"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $taxonomyActiveTab === 'categories' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                            Categories ({{ $allCategories->count() }})
                        </button>
                        <button type="button" 
                                wire:click="$set('taxonomyActiveTab', 'brands')"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $taxonomyActiveTab === 'brands' ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                            Brands / Manufacturers ({{ $allBrands->count() }})
                        </button>
                    </div>

                    <!-- Add New Item Inline Form -->
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               wire:model="taxonomyNewName" 
                               wire:keydown.enter.prevent="addTaxonomyItem"
                               placeholder="{{ $taxonomyActiveTab === 'categories' ? 'Add new category name...' : 'Add new brand / manufacturer name...' }}"
                               class="flex-1 px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                        <button type="button" 
                                wire:click="addTaxonomyItem" 
                                class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 cursor-pointer">
                            Add Item
                        </button>
                    </div>
                    @error('taxonomyNewName') 
                        <span class="text-rose-500 text-[10px] font-semibold block">{{ $message }}</span> 
                    @enderror

                    <!-- Items List -->
                    <div class="max-h-72 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800 border border-slate-100 dark:border-slate-800 rounded-2xl">
                        @if($taxonomyActiveTab === 'categories')
                            @forelse($allCategories as $cat)
                                <div class="px-4 py-2.5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-900/50">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="solid:tag" class="w-3.5 h-3.5 text-cyan-500" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">{{ $cat->name }}</span>
                                        <span class="text-[10px] font-mono text-slate-400">({{ $cat->slug }})</span>
                                    </div>
                                    <button type="button" 
                                            wire:click="deleteCategory({{ $cat->id }})" 
                                            wire:confirm="Are you sure you want to delete category '{{ $cat->name }}'?"
                                            class="text-rose-500 hover:text-rose-700 p-1 cursor-pointer">
                                        <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-slate-400">No categories found.</div>
                            @endforelse
                        @else
                            @forelse($allBrands as $brand)
                                <div class="px-4 py-2.5 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-900/50">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="solid:building" class="w-3.5 h-3.5 text-cyan-500" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">{{ $brand->name }}</span>
                                        <span class="text-[10px] font-mono text-slate-400">({{ $brand->slug }})</span>
                                    </div>
                                    <button type="button" 
                                            wire:click="deleteBrand({{ $brand->id }})" 
                                            wire:confirm="Are you sure you want to delete brand '{{ $brand->name }}'?"
                                            class="text-rose-500 hover:text-rose-700 p-1 cursor-pointer">
                                        <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-slate-400">No brands found.</div>
                            @endforelse
                        @endif
                    </div>

                    <div class="flex justify-end pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="closeManageTaxonomiesModal" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl cursor-pointer">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
