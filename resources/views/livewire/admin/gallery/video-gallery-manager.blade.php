<div class="space-y-6">

    <!-- Unified Media Picker Modal for Custom Thumbnails / Covers -->
    <x-media-picker-modal />

    <!-- Top Executive Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center">
                    <x-icon name="solid:video" class="w-4 h-4" />
                </div>
                <h1 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Video Gallery</h1>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Curate YouTube video portfolios, dynamic balancing live demos, and ship engine room footage.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <button type="button" 
                    wire:click="openCreateVideoModal"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-rose-600 text-white hover:bg-rose-700 shadow-sm transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                <x-icon name="solid:video" class="w-4 h-4" />
                <span>Add YouTube Video</span>
            </button>

            <button type="button" 
                    wire:click="openCreateAlbumModal"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <x-icon name="solid:folder-plus" class="w-3.5 h-3.5 text-rose-500" />
                <span>New Album</span>
            </button>

            <a href="{{ route('video-gallery') }}" target="_blank"
               class="px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <span>View Public Videos</span>
                <x-icon name="solid:arrow-top-right-on-square" class="w-3.5 h-3.5 text-rose-500" />
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
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer {{ is_null($selectedAlbumId) ? 'bg-rose-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                All Videos ({{ \App\Models\VideoGallery::count() }})
            </button>

            @foreach($albums as $album)
                <div class="flex items-center shrink-0">
                    <button type="button" wire:click="$set('selectedAlbumId', {{ $album->id }})"
                            class="px-3 py-1.5 rounded-l-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $selectedAlbumId === $album->id ? 'bg-rose-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                        <span>{{ $album->display_name }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] font-mono {{ $selectedAlbumId === $album->id ? 'bg-black/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-400' }}">
                            {{ $album->videos_count }}
                        </span>
                    </button>
                    <button type="button" wire:click="editAlbum({{ $album->id }})"
                            title="Edit video album"
                            class="px-2 py-1.5 rounded-r-xl border-l border-black/10 dark:border-white/10 text-xs transition-colors cursor-pointer {{ $selectedAlbumId === $album->id ? 'bg-rose-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-white' }}">
                        <x-icon name="solid:pencil" class="w-3 h-3" />
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Search Bar -->
        <div class="relative w-full sm:w-64">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search video title..." 
                   class="w-full px-3.5 py-1.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500">
        </div>
    </div>

    <!-- Curated Videos Grid -->
    @if($videos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <div wire:key="video-card-{{ $video->id }}" 
                     class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col">
                    
                    <!-- Video Thumbnail with YouTube Overlay -->
                    <div class="relative aspect-video bg-black overflow-hidden group">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->display_title }}" class="w-full h-full object-cover">
                        
                        <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" 
                           class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/60 transition-colors">
                            <div class="w-12 h-12 rounded-full bg-rose-600 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <x-icon name="solid:play" class="w-5 h-5 fill-current ml-0.5" />
                            </div>
                        </a>

                        <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded-lg bg-black/80 text-white text-[10px] font-mono font-bold flex items-center gap-1 backdrop-blur-xs">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>YouTube</span>
                        </div>

                        @if($video->album)
                            <span class="absolute top-2 left-2 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/75 text-white backdrop-blur-xs">
                                {{ $video->album->display_name }}
                            </span>
                        @endif
                    </div>

                    <!-- Body & Metadata -->
                    <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-1" title="{{ $video->display_title }}">
                                {{ $video->display_title }}
                            </h3>
                            @if(!empty($video->display_description))
                                <div class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1.5 prose dark:prose-invert">
                                    {!! strip_tags($video->display_description) !!}
                                </div>
                            @endif
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="toggleVideoActive({{ $video->id }})"
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition-colors {{ $video->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}">
                                    &bull; {{ $video->is_active ? 'Published' : 'Hidden' }}
                                </button>
                                <span class="text-[10px] text-slate-400 font-mono">Order: {{ $video->order }}</span>
                            </div>

                            <div class="flex items-center gap-1">
                                <button type="button" wire:click="editVideo({{ $video->id }})"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                                        title="Edit Video Details">
                                    <x-icon name="solid:pen-to-square" class="w-3.5 h-3.5" />
                                </button>
                                <button type="button" wire:click="confirmDelete('video', {{ $video->id }}, '{{ addslashes($video->display_title) }}')"
                                        class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                        title="Delete Video">
                                    <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $videos->links() }}
        </div>
    @else
        <div class="p-12 text-center rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-500 flex items-center justify-center mx-auto">
                <x-icon name="solid:video" class="w-7 h-7" />
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">No Videos in This Album</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                    Showcase dynamic balancing procedures, workshop overhauls, and ship engine room recordings.
                </p>
            </div>
            <button type="button" wire:click="openCreateVideoModal"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-rose-600 text-white hover:bg-rose-700 shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                <x-icon name="solid:video" class="w-4 h-4" />
                <span>Add Video</span>
            </button>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL: ADD / EDIT VIDEO (WITH QUILL RICH TEXT & YOUTUBE PREVIEW) -->
    <!-- ========================================================================= -->
    @if($isVideoModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-950/75 backdrop-blur-xs" wire:click="$set('isVideoModalOpen', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10 max-h-[90vh] overflow-y-auto"
                     @click.stop>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-500 flex items-center justify-center">
                                <x-icon name="solid:video" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ $editingVideoId ? 'Edit Video Showcase' : 'Add YouTube Video' }}
                            </h3>
                        </div>
                        <button type="button" wire:click="$set('isVideoModalOpen', false)" class="text-slate-400 hover:text-white text-lg font-bold cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-4">
                        <!-- YouTube URL -->
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                YouTube Video URL <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" wire:model.live.debounce.300ms="videoYoutubeUrl" 
                                   placeholder="e.g. https://www.youtube.com/watch?v=9No-FiEInLA"
                                   class="w-full px-3.5 py-2.5 text-xs font-mono rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500">
                            @error('videoYoutubeUrl') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Live Preview If ID Valid -->
                        @if($this->youtubePreviewId)
                            <div class="relative aspect-video rounded-2xl overflow-hidden bg-black shadow-inner border border-slate-800">
                                <iframe src="https://www.youtube-nocookie.com/embed/{{ $this->youtubePreviewId }}" 
                                        class="w-full h-full" 
                                        title="Preview" 
                                        frameborder="0" 
                                        allowfullscreen></iframe>
                            </div>
                        @endif

                        <!-- Multi-Language Titles -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Video Title (English) <span class="text-rose-500">*</span></label>
                                <input type="text" wire:model="videoTitleEn" placeholder="e.g. Marine Turbocharger Dynamic Balancing"
                                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                @error('videoTitleEn') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Video Title (Bengali)</label>
                                <input type="text" wire:model="videoTitleBn" placeholder="যেমন: মেরিন টার্বোচার্জার ডাইনামিক ব্যালেন্সিং"
                                       class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>
                        </div>

                        <!-- Quill Editor Rich Description -->
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Video Description &amp; Technical Notes (Quill Rich Text)
                            </label>
                            <x-quill-editor wire:model="videoDescriptionEn" placeholder="Describe the overhaul procedure shown in this video..." minHeight="140px" />
                        </div>

                        <!-- Album & Placement -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Album / Category</label>
                                <select wire:model="videoAlbumId" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white cursor-pointer">
                                    <option value="">-- General Videos --</option>
                                    @foreach($albums as $album)
                                        <option value="{{ $album->id }}">{{ $album->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">Sort Order</label>
                                <input type="number" wire:model="videoOrder" min="0" class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                            </div>

                            <div class="flex items-center pt-5">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="videoIsActive" class="w-4 h-4 rounded text-rose-600">
                                    <span class="text-xs font-bold text-slate-800 dark:text-white">Publish Video</span>
                                </label>
                            </div>
                        </div>

                        <!-- Custom Thumbnail (Optional) -->
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-bold text-slate-800 dark:text-white block">Custom Thumbnail Cover</span>
                                <span class="text-[10px] text-slate-400">Leave empty to use automatic YouTube HQ thumbnail.</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($videoThumbnailUrl)
                                    <img src="{{ $videoThumbnailUrl }}" class="w-10 h-7 object-cover rounded border border-slate-700">
                                    <button type="button" wire:click="$set('videoThumbnailId', null); $set('videoThumbnailUrl', null)" class="text-[10px] font-bold text-rose-500 hover:underline">Clear</button>
                                @endif
                                <button type="button" 
                                        @click="$dispatch('open-media-picker', { targetField: 'video_thumbnail', multiple: false, defaultFolder: 'gallery' })"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 cursor-pointer">
                                    {{ $videoThumbnailUrl ? 'Replace' : 'Select Custom' }}
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('isVideoModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white cursor-pointer">Cancel</button>
                        <button type="button" wire:click="saveVideo" class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl bg-rose-600 text-white hover:bg-rose-700 shadow-sm cursor-pointer">Save Video</button>
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
                            <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-500 flex items-center justify-center">
                                <x-icon name="solid:folder-plus" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ $editingAlbumId ? 'Edit Video Album' : 'Create New Video Album' }}
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
                            <textarea wire:model="albumDescriptionEn" rows="2" placeholder="Brief context about videos inside this album."
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
                                    <input type="checkbox" wire:model="albumIsActive" class="w-4 h-4 rounded text-rose-600">
                                    <span class="text-xs font-bold text-slate-800 dark:text-white">Active Album</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('isAlbumModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white cursor-pointer">Cancel</button>
                        <button type="button" wire:click="saveAlbum" class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl bg-rose-600 text-white hover:bg-rose-700 shadow-sm cursor-pointer">Save Album</button>
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
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Confirm Deletion</h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Are you sure you want to permanently delete: <strong class="text-slate-700 dark:text-slate-200">{{ $deleteName }}</strong>?
                        </p>
                    </div>
                    <div class="flex items-center justify-center gap-2 pt-2">
                        <button type="button" wire:click="$set('isDeleteModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white cursor-pointer">Cancel</button>
                        <button type="button" wire:click="executeDelete" class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl bg-rose-600 text-white hover:bg-rose-700 shadow-sm cursor-pointer">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
