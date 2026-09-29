@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-brand text-white shadow-md'
            : 'text-slate-300 hover:bg-slate-800 hover:text-white hover:shadow-brand/10 shadow-sm transition-all';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
