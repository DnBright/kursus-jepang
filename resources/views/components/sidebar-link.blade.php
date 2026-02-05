@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3 bg-red-50 text-red-700 rounded-lg font-bold border-l-4 border-red-600 shadow-sm transition-all'
            : 'flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-lg font-medium border-l-4 border-transparent transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
