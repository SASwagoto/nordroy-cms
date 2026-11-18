<div class="space-y-6">

    <!-- Top Action Bar & Stats Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                    <x-icon name="solid:globe" class="w-4 h-4" />
                </div>
                <h1 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Localization &amp; Languages</h1>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400">
                    {{ $stats['total'] }} LANGUAGES
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Configure international languages, RTL script support, and primary site locale.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" 
                    wire:click="createLanguage" 
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="whitespace-nowrap">Add New Language</span>
            </button>
        </div>
    </div>

    <!-- Flash Notifications -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('message') }}</span>
            </div>
            <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show"
             class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-xs flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" @click="show = false" class="text-rose-500 hover:text-rose-700 cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Quick Stats Cards Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Languages</span>
                <div class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $stats['total'] }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center">
                <x-icon name="solid:globe" class="w-5 h-5" />
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Active Locales</span>
                <div class="text-xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['active'] }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <x-icon name="solid:check" class="w-5 h-5" />
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Default Locale</span>
                <div class="text-xl font-black text-[#003C58] dark:text-cyan-400 mt-1">{{ $stats['default'] }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                <x-icon name="solid:star" class="w-5 h-5" />
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="relative w-full sm:w-80">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   placeholder="Search languages by name or code..."
                   class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500 transition-all">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Languages Table Card -->
    <div class="rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-900">
                    <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-900 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900">Language</th>
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900">Code</th>
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900">Direction</th>
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900">Default</th>
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900">Status</th>
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900 text-center">Order</th>
                        <th class="py-3.5 px-4 bg-slate-100 dark:bg-slate-900 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($languages as $lang)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl shrink-0 select-none">{{ $lang->flag_icon ?: '🌐' }}</span>
                                    <div>
                                        <div class="font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                            <span>{{ $lang->name }}</span>
                                            @if($lang->is_default)
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 uppercase tracking-wider">
                                                    Default
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-slate-400 font-medium block">
                                            {{ $lang->native_name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                    {{ $lang->code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $lang->direction === 'rtl' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                                    {{ strtoupper($lang->direction) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($lang->is_default)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                                        <x-icon name="solid:check-circle" class="w-4 h-4 text-emerald-500" />
                                        Primary
                                    </span>
                                @else
                                    <button type="button" 
                                            wire:click="setDefault({{ $lang->id }})" 
                                            class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors cursor-pointer border border-slate-200 dark:border-slate-800">
                                        Set Default
                                    </button>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <button type="button" 
                                        wire:click="toggleActive({{ $lang->id }})"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold transition-all cursor-pointer {{ $lang->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500/20' : 'bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-300 dark:hover:bg-slate-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $lang->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $lang->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-500 dark:text-slate-400">
                                {{ $lang->order }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" 
                                            wire:click="editLanguage({{ $lang->id }})" 
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                                            title="Edit Language">
                                        <x-icon name="solid:pencil" class="w-3.5 h-3.5" />
                                    </button>
                                    @if(!$lang->is_default)
                                        <button type="button" 
                                                wire:click="confirmDelete({{ $lang->id }})" 
                                                class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                                title="Delete Language">
                                            <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <x-icon name="solid:globe" class="w-8 h-8 mx-auto text-slate-300 dark:text-slate-700 mb-2" />
                                <span class="font-bold">No languages found matching your criteria.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($languages->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $languages->links() }}
            </div>
        @endif
    </div>

    <!-- ==================== CREATE / EDIT LANGUAGE MODAL ==================== -->
    <div x-data="{ open: @entangle('isFormModalOpen') }" 
         x-show="open" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;" 
         role="dialog" 
         aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="$wire.closeModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-lg rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 space-y-6">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Localization Setting</span>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white font-heading">
                            {{ $editingLanguageId ? 'Edit Language' : 'Add New Language' }}
                        </h2>
                    </div>
                    <button type="button" @click="$wire.closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-lg font-bold cursor-pointer">&times;</button>
                </div>

                <form wire:submit="saveLanguage" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Language Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                Language Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="name" 
                                   placeholder="e.g. Arabic, German"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('name') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Language Code (ISO) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                ISO Code <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="code" 
                                   placeholder="e.g. ar, de, es, fr"
                                   class="w-full px-3.5 py-2 text-xs font-mono rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('code') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Native Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                Native Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="native_name" 
                                   placeholder="e.g. العربية, Deutsch"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('native_name') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Flag Icon (Emoji) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                Flag Emoji / Icon
                            </label>
                            <input type="text" 
                                   wire:model="flag_icon" 
                                   placeholder="e.g. 🇸🇦, 🇩🇪, 🇫🇷, 🇪🇸"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('flag_icon') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Script Direction -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                Script Direction <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model="direction"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                                <option value="ltr">LTR (Left to Right)</option>
                                <option value="rtl">RTL (Right to Left - Arabic, Hebrew)</option>
                            </select>
                            @error('direction') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                Display Order
                            </label>
                            <input type="number" 
                                   wire:model="order" 
                                   min="0"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
                            @error('order') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Toggles: Active & Default -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Active Language</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_default" class="rounded text-[#003C58] dark:text-cyan-500 focus:ring-0">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Set as Primary Default</span>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-2.5">
                        <button type="button" 
                                wire:click="closeModal" 
                                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all cursor-pointer">
                            {{ $editingLanguageId ? 'Save Changes' : 'Create Language' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- ==================== DELETE CONFIRMATION MODAL ==================== -->
    <div x-data="{ open: @entangle('isDeleteModalOpen') }" 
         x-show="open" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;" 
         role="dialog" 
         aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="$wire.isDeleteModalOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-md rounded-3xl bg-white dark:bg-[#0b1b2b] border border-slate-200 dark:border-slate-800 shadow-2xl p-6 space-y-4">
                <div class="flex items-center gap-3 text-rose-600">
                    <x-icon name="solid:triangle-exclamation" class="w-6 h-6" />
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete Language?</h3>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Are you sure you want to permanently delete this language? Items translated in this language will remain in database but won't be displayed.
                </p>
                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" 
                            @click="$wire.isDeleteModalOpen = false" 
                            class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
                        Cancel
                    </button>
                    <button type="button" 
                            wire:click="deleteLanguage" 
                            class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-600 text-white hover:bg-rose-500 shadow-sm cursor-pointer">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
