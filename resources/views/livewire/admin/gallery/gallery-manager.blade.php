<div class="space-y-6">

    <!-- Unified Media Picker Modal at Root -->
    <x-media-picker-modal />

    <!-- Top Executive Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/10 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                    <x-icon name="solid:photo-film" class="w-4 h-4" />
                </div>
                <h1 class="text-xl font-bold font-heading text-slate-900 dark:text-white">Media Gallery &amp; Video Showcase</h1>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Curate high-resolution workshop photography, overhaul portfolios, and YouTube videos across structured albums.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if($currentTab === 'photos')
                <button type="button" 
                        @click="$dispatch('open-media-picker', { targetField: 'gallery_photos', multiple: true, defaultFolder: 'gallery' })"
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                    <x-icon name="solid:cloud-arrow-up" class="w-4 h-4" />
                    <span>Add / Upload Photos</span>
                </button>
            @elseif($currentTab === 'videos')
                <button type="button" 
                        wire:click="openCreateVideoModal"
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-rose-600 text-white hover:bg-rose-700 shadow-sm transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                    <x-icon name="solid:video" class="w-4 h-4" />
                    <span>Add YouTube Video</span>
                </button>
            @elseif($currentTab === 'albums')
                <button type="button" 
                        wire:click="openCreateAlbumModal"
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center justify-center gap-2 cursor-pointer">
                    <x-icon name="solid:folder-plus" class="w-4 h-4" />
                    <span>New Album / Category</span>
                </button>
            @endif

            <a href="{{ route('gallery') }}" target="_blank"
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

    <!-- Main Navigation Tabs -->
    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-2 flex-wrap gap-3">
        <div class="flex items-center gap-1.5 p-1 rounded-2xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
            <button type="button" wire:click="setTab('photos')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer {{ $currentTab === 'photos' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                <x-icon name="solid:images" class="w-4 h-4" />
                <span>Photo Gallery</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono {{ $currentTab === 'photos' ? 'bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400' : 'bg-slate-200 dark:bg-slate-800 text-slate-500' }}">
                    {{ $stats['total_photos'] }}
                </span>
            </button>

            <button type="button" wire:click="setTab('videos')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer {{ $currentTab === 'videos' ? 'bg-white dark:bg-slate-800 text-rose-600 dark:text-rose-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                <x-icon name="solid:video" class="w-4 h-4 text-rose-500" />
                <span>Video Gallery</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono {{ $currentTab === 'videos' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'bg-slate-200 dark:bg-slate-800 text-slate-500' }}">
                    {{ $stats['total_videos'] }}
                </span>
            </button>

            <button type="button" wire:click="setTab('albums')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer {{ $currentTab === 'albums' ? 'bg-white dark:bg-slate-800 text-[#003C58] dark:text-cyan-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                <x-icon name="solid:folder" class="w-4 h-4" />
                <span>Albums &amp; Categories</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono {{ $currentTab === 'albums' ? 'bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400' : 'bg-slate-200 dark:bg-slate-800 text-slate-500' }}">
                    {{ $stats['total_albums'] }}
                </span>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="relative w-full sm:w-64">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search title or caption..." 
                   class="w-full px-3.5 py-1.5 text-xs rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500" />
        </div>
    </div>

    <!-- Album Filter Pills (for Photos & Videos) -->
    @if($currentTab !== 'albums' && $albums->count() > 0)
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-1">Filter Album:</span>
            
            <button type="button" wire:click="$set('selectedAlbumId', null)"
                    class="px-3 py-1 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer {{ is_null($selectedAlbumId) ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50' }}">
                All Albums
            </button>

            @foreach($albums as $album)
                <button type="button" wire:click="$set('selectedAlbumId', {{ $album->id }})"
                        class="px-3 py-1 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer flex items-center gap-1.5 {{ $selectedAlbumId === $album->id ? 'bg-[#003C58] text-white dark:bg-cyan-500 dark:text-slate-950 shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50' }}">
                    <span>{{ $album->display_name }}</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[9px] font-mono {{ $selectedAlbumId === $album->id ? 'bg-black/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}">
                        {{ $currentTab === 'photos' ? $album->photos_count : $album->videos_count }}
                    </span>
                </button>
            @endforeach
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- TAB 1: PHOTO GALLERY -->
    <!-- ========================================================================= -->
    @if($currentTab === 'photos')
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
                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg text-[9px] font-bold bg-black/70 text-white backdrop-blur-xs truncate max-w-[80%]">
                                    {{ $photo->album->display_name }}
                                </span>
                            @endif

                            <!-- Quick Active Status -->
                            <button type="button" wire:click="togglePhotoActive({{ $photo->id }})"
                                    title="Toggle published status"
                                    class="absolute top-2 right-2 w-6 h-6 rounded-full flex items-center justify-center transition-all cursor-pointer {{ $photo->is_active ? 'bg-emerald-500 text-white shadow-xs' : 'bg-slate-700/80 text-slate-400' }}">
                                <x-icon name="solid:check" class="w-3 h-3" />
                            </button>

                            <!-- Hover Overlay with Actions -->
                            <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <button type="button" wire:click="editPhoto({{ $photo->id }})"
                                        class="p-2 rounded-xl bg-white text-slate-900 hover:bg-slate-100 transition-colors shadow-sm cursor-pointer"
                                        title="Edit Photo Info">
                                    <x-icon name="solid:pen-to-square" class="w-4 h-4" />
                                </button>
                                <button type="button" wire:click="confirmDelete('photo', {{ $photo->id }}, '{{ addslashes($photo->display_title ?: 'Photo #' . $photo->id) }}')"
                                        class="p-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700 transition-colors shadow-sm cursor-pointer"
                                        title="Delete Photo">
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
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">No Gallery Photos Yet</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Add high-resolution photography from your media library or upload new files directly.
                    </p>
                </div>
                <button type="button" 
                        @click="$dispatch('open-media-picker', { targetField: 'gallery_photos', multiple: true, defaultFolder: 'gallery' })"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                    <x-icon name="solid:cloud-arrow-up" class="w-4 h-4" />
                    <span>Upload or Select Photos</span>
                </button>
            </div>
        @endif
    @endif

    <!-- ========================================================================= -->
    <!-- TAB 2: VIDEO GALLERY -->
    <!-- ========================================================================= -->
    @if($currentTab === 'videos')
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($videos as $video)
                    <div wire:key="video-card-{{ $video->id }}" 
                         class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col">
                        
                        <!-- Video Thumbnail -->
                        <div class="relative aspect-video bg-black overflow-hidden group">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->display_title }}" class="w-full h-full object-cover">
                            
                            <!-- YouTube Overlay Play Button -->
                            <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" 
                               class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/60 transition-colors">
                                <div class="w-12 h-12 rounded-full bg-rose-600 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <x-icon name="solid:play" class="w-5 h-5 fill-current ml-0.5" />
                                </div>
                            </a>

                            <!-- YouTube Badge -->
                            <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded-lg bg-black/80 text-white text-[10px] font-mono font-bold flex items-center gap-1 backdrop-blur-xs">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>YouTube</span>
                            </div>

                            @if($video->album)
                                <span class="absolute top-2 left-2 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/70 text-white backdrop-blur-xs">
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
                                    <div class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1 prose dark:prose-invert">
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
                                            title="Edit Video">
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
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">No YouTube Videos Added</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Showcase workshop overhauls, dynamic balancing recordings, and ship engine room footage.
                    </p>
                </div>
                <button type="button" wire:click="openCreateVideoModal"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-rose-600 text-white hover:bg-rose-700 shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                    <x-icon name="solid:video" class="w-4 h-4" />
                    <span>Add First Video</span>
                </button>
            </div>
        @endif
    @endif

    <!-- ========================================================================= -->
    <!-- TAB 3: ALBUMS / CATEGORIES -->
    <!-- ========================================================================= -->
    @if($currentTab === 'albums')
        @if($albums->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($albums as $album)
                    <div wire:key="album-card-{{ $album->id }}" 
                         class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs flex flex-col">
                        
                        <!-- Album Cover -->
                        <div class="relative aspect-16/9 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            @if($album->coverImage)
                                <img src="{{ $album->coverImage->url }}" alt="{{ $album->display_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <x-icon name="solid:folder" class="w-12 h-12 opacity-30" />
                                </div>
                            @endif

                            <div class="absolute bottom-2 left-2 flex items-center gap-1.5">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/70 text-white backdrop-blur-xs flex items-center gap-1">
                                    <x-icon name="solid:images" class="w-3 h-3 text-cyan-400" />
                                    <span>{{ $album->photos_count }} photos</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-black/70 text-white backdrop-blur-xs flex items-center gap-1">
                                    <x-icon name="solid:video" class="w-3 h-3 text-rose-400" />
                                    <span>{{ $album->videos_count }} videos</span>
                                </span>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                    {{ $album->display_name }}
                                </h3>
                                <span class="font-mono text-[10px] text-slate-400 block mt-0.5">/{{ $album->slug }}</span>
                                @if(!empty($album->display_description))
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">
                                        {{ $album->display_description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 font-mono">Order: {{ $album->order }}</span>

                                <div class="flex items-center gap-1">
                                    <button type="button" wire:click="editAlbum({{ $album->id }})"
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                                            title="Edit Album">
                                        <x-icon name="solid:pen-to-square" class="w-3.5 h-3.5" />
                                    </button>
                                    <button type="button" wire:click="confirmDelete('album', {{ $album->id }}, '{{ addslashes($album->display_name) }}')"
                                            class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer"
                                            title="Delete Album">
                                        <x-icon name="solid:trash" class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center mx-auto">
                    <x-icon name="solid:folder-plus" class="w-7 h-7" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-white">No Albums Created Yet</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Create albums like "Workshop Overhauls", "Dynamic Balancing", "Vessel Attendances" to organize your media.
                    </p>
                </div>
                <button type="button" wire:click="openCreateAlbumModal"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-[#003C58] text-white hover:bg-[#024a6d] dark:bg-cyan-500 dark:text-slate-950 dark:hover:bg-cyan-400 shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                    <x-icon name="solid:folder-plus" class="w-4 h-4" />
                    <span>Create First Album</span>
                </button>
            </div>
        @endif
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
                                {{ $editingVideoId ? 'Edit Video Showcase' : 'Add YouTube Video to Gallery' }}
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
                                   class="w-full px-3.5 py-2.5 text-xs font-mono rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#003C58] dark:focus:ring-cyan-500">
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
                                    <input type="checkbox" wire:model="videoIsActive" class="w-4 h-4 rounded text-[#003C58]">
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
                            <div class="w-8 h-8 rounded-xl bg-[#003C58]/10 dark:bg-cyan-500/20 text-[#003C58] dark:text-cyan-400 flex items-center justify-center">
                                <x-icon name="solid:folder-plus" class="w-4 h-4" />
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ $editingAlbumId ? 'Edit Album' : 'Create New Gallery Album' }}
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
                            <textarea wire:model="albumDescriptionEn" rows="2" placeholder="Brief context about the photos and overhaul projects inside this album."
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
