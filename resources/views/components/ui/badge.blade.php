@props(['type' => 'default'])

@php
$style = match($type) {
    'success' => 'bg-emerald-600 text-white',
    default => 'bg-white border text-slate-600'
};
@endphp

<span class="px-3 py-1 rounded-full text-[11px] {{ $style }}">
    {{ $slot }}
</span>
