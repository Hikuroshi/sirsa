@props([
    'type' => 'success',
])

@php
    $classes = match ($type) {
        'error' => 'rounded bg-red-100 p-3 text-red-800',
        default => 'rounded bg-green-100 p-3 text-green-800',
    };
@endphp

<div role="alert" {{ $attributes->class($classes) }}>{{ $slot }}</div>
