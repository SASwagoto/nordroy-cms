<div class="space-y-6">

    <!-- Unified Media Picker Modal at Root (Pre-filtered to 'gallery' folder) -->
    <x-media-picker-modal />

    <!-- Top Executive Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                    <x-icon name="solid:images" class="w-4 h-4" />
                </div>
                <h1 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Photo Gallery</h1>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Curate workshop photography, precision balancing procedures, and overhaul albums.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <button type="button" 
                    @click="$dispatch('open-media-picker', { targetField: 'gallery_photos', multiple: true, defaultFolder: 'gallery' })"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                <x-icon name="solid:cloud-arrow-up" class="w-4 h-4" />
                <span>Add / Upload Photos</span>
            </button>

            <button type="button" 
                    wire:click="openCreateAlbumModal"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <x-icon name="solid:folder-plus" class="w-3.5 h-3.5 text-[#003C58] dark:text-cyan-400" />
                <span>New Album</span>
            </button>

            <a href="{{ route('photo-gallery') }}" target="_blank"
               class="px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <span>View Public Gallery</span>
                <x-icon name="solid:arrow-top-right-on-square" class="w-3.5 h-3.5 text-cyan-500" />
            </a>
        </div>
    </div>

    <!-- Flash Alert -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <x-icon name="solid:circle-check" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
            </button>
        </div>
    @endif

    <!-- Search & Filter Controls -->
    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Album Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar w-full sm:w-auto pb-1 sm:pb-0">
            <button type="button" wire:click="$set('selectedAlbumId', null)"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer {{ is_null($selectedAlbumId) ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                All Photos ({{ \App\Models\PhotoGallery::count() }})
            </button>

            @foreach($albums as $album)
                <div class="flex items-center shrink-0">
                    <button type="button" wire:click="$set('selectedAlbumId', {{ $album->id }})"
                            class="px-3 py-1.5 rounded-l-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $selectedAlbumId === $album->id ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                        <span>{{ $album->display_name }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] font-mono {{ $selectedAlbumId === $album->id ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-400' }}">
                            {{ $album->photos_count }}
                        </span>
                    </button>
                    <button type="button" wire:click="editAlbum({{ $album->id }})"
                            title="Edit album name &amp; cover"
                            class="px-2 py-1.5 rounded-r-xl border-l border-black/10 dark:border-white/10 text-xs transition-colors cursor-pointer {{ $selectedAlbumId === $album->id ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white' }}">
                        <x-icon name="solid:pencil" class="w-3 h-3" />
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Search Bar -->
        <div class="relative w-full sm:w-64">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search photo title..." 
                   class="w-full px-3.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500" />
        </div>
    </div>

    <!-- Curated Photos Grid -->
    @if($photos->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($photos as $photo)
                <div wire:key="photo-card-{{ $photo->id }}" 
                     class="group relative rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col">
                    
                    <!-- Image Container -->
                    <div class="relative aspect-4/3 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->display_title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                        <!-- Album Badge -->
                        @if($photo->album)
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-bold bg-black/75 text-white backdrop-blur-xs truncate max-w-[80%]">
                                {{ $photo->album->display_name }}
                            </span>
                        @endif

                        <!-- Quick Active Status Toggle -->
                        <button type="button" wire:click="togglePhotoActive({{ $photo->id }})"
                                title="Toggle published status"
                                class="absolute top-2 right-2 w-6 h-6 rounded-full flex items-center justify-center transition-all cursor-pointer {{ $photo->is_active ? 'bg-emerald-500 text-white shadow-xs' : 'bg-slate-700/80 text-slate-400' }}">
                            <x-icon name="solid:check" class="w-3 h-3" />
                        </button>

                        <!-- Hover Overlay with Actions -->
                        <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button type="button" wire:click="editPhoto({{ $photo->id }})"
                                    class="p-2 rounded-xl bg-white text-slate-900 hover:bg-slate-100 transition-colors shadow-sm cursor-pointer"
                                    title="Edit Photo Details">
                                <x-icon name="solid:pen-to-square" class="w-4 h-4" />
                            </button>
                            <button type="button" wire:click="confirmDelete('photo', {{ $photo->id }}, '{{ addslashes($photo->display_title ?: 'Photo #' . $photo->id) }}')"
                                    class="p-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700 transition-colors shadow-sm cursor-pointer"
                                    title="Remove from Gallery">
                                <x-icon name="solid:trash" class="w-4 h-4" />
                            </button>
                        </div>
                    </div>

                    <!-- Info Footer -->
                    <div class="p-2.5 space-y-0.5 flex-1 flex flex-col justify-between">
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate" title="{{ $photo->display_title }}">
                            {{ $photo->display_title ?: 'Untitled Photo' }}
                        </h4>
                        <div class="flex items-center justify-between text-[10px] text-slate-400">
                            <span>Order: {{ $photo->order }}</span>
                            <span class="{{ $photo->is_active ? 'text-emerald-500 font-semibold' : 'text-slate-400' }}">
                                {{ $photo->is_active ? 'Published' : 'Hidden' }}
                            </span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $photos->links() }}
        </div>
    @else
        <div class="p-12 text-center rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto">
                <x-icon name="solid:images" class="w-7 h-7" />
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">No Photos in This Album</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                    Add curated photos from your gallery media library or upload new files directly into this album.
                </p>
            </div>
            <button type="button" 
                    @click="$dispatch('open-media-picker', { targetField: 'gallery_photos', multiple: true, defaultFolder: 'gallery' })"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                <x-icon name="solid:cloud-arrow-up" class="w-4 h-4" />
                <span>Select / Upload Photos</span>
            </button>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL: EDIT PHOTO -->
    <!-- ========================================================================= -->
    @if($isPhotoModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs" wire:click="$set('isPhotoModalOpen', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10"
                     @click.stop>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <x-icon name="solid:pen-to-square" class="w-4 h-4 text-[#003C58] dark:text-cyan-400" />
                            <span>Edit Photo Details</span>
                        </h3>
                        <button type="button" wire:click="$set('isPhotoModalOpen', false)" class="text-slate-400 hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Title (English)</label>
                            <input type="text" wire:model="photoTitleEn" placeholder="e.g. Rotor Blade Ultrasonic Inspection"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Title (Bengali)</label>
                            <input type="text" wire:model="photoTitleBn" placeholder="যেমন: রোটর ব্লেড আল্ট্রাসনিক ইন্সপেকশন"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Caption / Procedure Summary (English)</label>
                            <textarea wire:model="photoCaptionEn" rows="2" placeholder="Brief technical note regarding this photo."
                                      class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Assign to Album</label>
                            <select wire:model="photoAlbumId" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white cursor-pointer">
                                <option value="">-- No Album (General Gallery) --</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->display_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Sort Order</label>
                                <input type="number" wire:model="photoOrder" min="0" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="photoIsActive" class="w-4 h-4 rounded text-[#003C58]">
                                    <span class="text-xs font-bold text-slate-800 dark:text-white">Publish Photo</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('isPhotoModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white cursor-pointer">Cancel</button>
                        <button type="button" wire:click="savePhoto" class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL: ADD / EDIT ALBUM -->
    <!-- ========================================================================= -->
    @if($isAlbumModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-950/75 backdrop-blur-xs" wire:click="$set('isAlbumModalOpen', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10"
                     @click.stop>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:folder-plus" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ $editingAlbumId ? 'Edit Photo Album' : 'Create New Photo Album' }}
                            </h3>
                        </div>
                        <button type="button" wire:click="$set('isAlbumModalOpen', false)" class="text-slate-400 hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Album Name (English) <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model.live.debounce.300ms="albumNameEn" placeholder="e.g. Dynamic High-Speed Balancing"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            @error('albumNameEn') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Album Name (Bengali)</label>
                            <input type="text" wire:model="albumNameBn" placeholder="যেমন: ডাইনামিক হাই-স্পিড ব্যালেন্সিং"
                                   class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">URL Slug</label>
                            <input type="text" wire:model="albumSlug" placeholder="e.g. dynamic-rotor-balancing"
                                   class="w-full px-3.5 py-2 text-xs font-mono rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Short Description</label>
                            <textarea wire:model="albumDescriptionEn" rows="2" placeholder="Brief context about the photos inside this album."
                                      class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white"></textarea>
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Album Cover Photo</label>
                            <div class="flex items-center gap-3">
                                <div class="w-16 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden border border-slate-200 dark:border-slate-700 flex items-center justify-center shrink-0">
                                    @if($albumCoverImageUrl)
                                        <img src="{{ $albumCoverImageUrl }}" class="w-full h-full object-cover">
                                    @else
                                        <x-icon name="solid:images" class="w-5 h-5 text-slate-400" />
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            @click="$dispatch('open-media-picker', { targetField: 'album_cover', multiple: false, defaultFolder: 'gallery' })"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 cursor-pointer">
                                        {{ $albumCoverImageUrl ? 'Replace Cover' : 'Select from Library' }}
                                    </button>
                                    @if($albumCoverImageUrl)
                                        <button type="button" wire:click="$set('albumCoverImageId', null); $set('albumCoverImageUrl', null)" class="text-xs font-bold text-rose-500 hover:underline">Remove</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Sort Order</label>
                                <input type="number" wire:model="albumOrder" min="0" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="albumIsActive" class="w-4 h-4 rounded text-[#003C58]">
                                    <span class="text-xs font-bold text-slate-800 dark:text-white">Active Album</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('isAlbumModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white cursor-pointer">Cancel</button>
                        <button type="button" wire:click="saveAlbum" class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 cursor-pointer">Save Album</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL: DELETE CONFIRMATION -->
    <!-- ========================================================================= -->
    @if($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs" wire:click="$set('isDeleteModalOpen', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10 text-center"
                     @click.stop>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-500 flex items-center justify-center mx-auto">
                        <x-icon name="solid:triangle-exclamation" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Confirm Removal</h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Are you sure you want to remove <strong class="text-slate-700 dark:text-slate-200">{{ $deleteName }}</strong>?
                        </p>
                    </div>
                    <div class="flex items-center justify-center gap-2 pt-2">
                        <button type="button" wire:click="$set('isDeleteModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white cursor-pointer">Cancel</button>
                        <button type="button" wire:click="executeDelete" class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl bg-rose-600 text-white hover:bg-rose-700 shadow-sm cursor-pointer">Yes, Remove</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
