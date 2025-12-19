@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-3 py-2.5 bg-primary-600/10 text-primary-400 rounded-md group border border-primary-600/20 transition-all duration-200'
            : 'flex items-center px-3 py-2.5 text-dark-muted hover:bg-dark-border hover:text-white rounded-md group transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="{{ $icon }} w-6 text-center group-hover:scale-110 transition-transform duration-200"></i>
    <span class="ml-3 font-medium">{{ $slot }}</span>
</a>