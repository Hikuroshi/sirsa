@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variantClass = match ($variant) {
        'secondary' => 'btn-neutral btn-outline',
        'danger' => 'btn-error',
        'warning' => 'btn-warning',
        'link' => 'btn-link',
        default => 'btn-primary',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class(['btn', $variantClass]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class(['btn', $variantClass]) }}>{{ $slot }}</button>
@endif

