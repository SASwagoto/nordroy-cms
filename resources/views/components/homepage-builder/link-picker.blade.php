@props([
    'model' => '',
    'placeholder' => 'Select a route or enter custom URL...',
    'options' => null
])

@php
    $wireModel = $attributes->wire('model')->value() ?: $model;
    $routeList = $options ?? (isset($internalLinkOptions) ? $internalLinkOptions : []);
@endphp

<div class="space-y-1.5 w-full">
    <div class="flex items-center gap-1.5">
        <select @change="if ($event.target.value) { $wire.set('{{ $wireModel }}', $event.target.value); }"
                class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 font-medium focus:ring-1 focus:ring-cyan-500">
            <option value="">-- Choose Predefined Route / Link --</option>
            @foreach($routeList as $category => $routes)
                <optgroup label="{{ $category }}">
                    @foreach($routes as $rUrl => $rLabel)
                        <option value="{{ $rUrl }}">{{ $rLabel }} ({{ $rUrl }})</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
    <div class="flex items-center gap-1.5">
        <input type="text" wire:model="{{ $wireModel }}" placeholder="{{ $placeholder }}"
               class="flex-1 px-2.5 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 font-mono text-slate-800 dark:text-slate-200">
        @if($wireModel)
        <button type="button" @click="$wire.set('{{ $wireModel }}', '')" class="px-2 py-1 text-[10px] font-bold text-slate-400 hover:text-rose-500 rounded border border-slate-200 dark:border-slate-800 shrink-0 cursor-pointer" title="Clear URL">
            Clear
        </button>
        @endif
    </div>
</div>
