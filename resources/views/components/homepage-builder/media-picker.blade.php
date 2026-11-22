@props([
    'model' => '',
    'value' => '',
    'label' => null,
    'placeholder' => 'assets/images/...'
])

@php
    $wireModel = $attributes->wire('model')->value() ?: $model;
    $val = $value;
@endphp

<div class="space-y-1 w-full">
    @if($label)
    <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">{{ $label }}</label>
    @endif
    
    <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 overflow-hidden flex items-center justify-center shrink-0">
            @if($val)
                <img src="{{ asset($val) }}" alt="Preview" class="w-full h-full object-cover" onerror="this.style.display='none'">
            @else
                <x-icon name="solid:image" class="w-4 h-4 text-slate-400" />
            @endif
        </div>

        <div class="flex-1 flex items-center gap-1.5 min-w-0">
            <input type="text" wire:model="{{ $wireModel }}" placeholder="{{ $placeholder }}"
                   class="flex-1 px-2.5 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-800 dark:text-slate-200 min-w-0">
            
            <button type="button" 
                    @click="$dispatch('open-media-picker', { targetField: '{{ $wireModel }}' })"
                    class="px-2.5 py-1 rounded-lg text-xs font-bold bg-[#003C58] hover:bg-[#002f45] dark:bg-cyan-500 dark:hover:bg-cyan-400 text-white dark:text-slate-950 flex items-center gap-1 shrink-0 cursor-pointer shadow-2xs"
                    title="Open Media Library & Upload">
                <x-icon name="solid:images" class="w-3.5 h-3.5" />
                <span class="text-[11px]">Pick Media</span>
            </button>
            @if($val)
            <button type="button" @click="$wire.set('{{ $wireModel }}', '')" class="p-1 text-slate-400 hover:text-rose-500 rounded border border-slate-200 dark:border-slate-800 shrink-0 cursor-pointer" title="Remove Image">
                <x-icon name="solid:xmark" class="w-3.5 h-3.5" />
            </button>
            @endif
        </div>
    </div>
</div>
