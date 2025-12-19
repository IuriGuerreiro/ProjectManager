@props(['variant' => 'primary', 'size' => 'md', 'href' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-bg disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 shadow-lg shadow-blue-900/20',
        'secondary' => 'bg-dark-bg text-dark-text border border-dark-border hover:bg-dark-border focus:ring-dark-muted',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 shadow-lg shadow-red-900/20',
        'ghost' => 'text-dark-muted hover:text-white hover:bg-dark-border focus:ring-dark-muted',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
