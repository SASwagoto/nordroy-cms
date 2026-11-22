@props([
    'model' => '',
    'value' => 'solid:wrench',
    'label' => 'Icon'
])

@php
    $wireModel = $attributes->wire('model')->value() ?: $model;
@endphp

<div class="space-y-1">
    @if($label)
    <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400">{{ $label }}</label>
    @endif
    <div @click="$dispatch('open-icon-picker', { targetField: '{{ $wireModel }}' })"
         class="flex items-center gap-2 px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-cyan-500 cursor-pointer transition-all h-[34px]">
        <div class="w-5 h-5 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 text-[#003C58] dark:text-cyan-400">
            <x-icon :name="$value ?: 'solid:wrench'" class="w-3.5 h-3.5" />
        </div>
        <span class="text-xs font-mono text-slate-700 dark:text-slate-300 truncate flex-1">{{ $value ?: 'Select Icon' }}</span>
        <span class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 shrink-0">Pick</span>
    </div>
</div>
