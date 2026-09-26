@props([
    'variant' => 'default',
])

@php
    $classes = match ($variant) {
        'success' => 'bg-green-100 text-green-800',
        'danger' => 'bg-red-100 text-red-800',
        'warning' => 'bg-amber-100 text-amber-800',
        'info' => 'bg-blue-100 text-blue-800',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->class("inline-flex rounded px-2 py-1 text-xs font-medium {$classes}") }}>{{ $slot }}</span>
