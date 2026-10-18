@props(['variant' => 'neutral'])

@php
    $colorClass = match ($variant) {
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'accent' => 'badge-accent',
        'info' => 'badge-info',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'error', 'danger' => 'badge-error',
        'ghost' => 'badge-ghost',
        'outline' => 'badge-outline',
        default => 'badge-neutral badge-outline',
    };
@endphp

<span {{ $attributes->class(['badge', $colorClass]) }}>{{ $slot }}</span>

