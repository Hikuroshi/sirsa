@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $classes = match ($variant) {
        'secondary' => 'rounded border px-4 py-2',
        'danger' => 'rounded px-3 py-2 text-red-600',
        'warning' => 'rounded bg-amber-500 px-4 py-2 text-white',
        'link' => 'rounded px-3 py-2 text-blue-600',
        default => 'rounded bg-blue-600 px-4 py-2 text-white',
    };

    $classes = "inline-flex min-h-10 items-center justify-center {$classes}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
