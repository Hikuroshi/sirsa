@props(['title'])

<div {{ $attributes->class('flex items-center justify-between gap-4') }}>
    <h1 class="text-2xl font-semibold">{{ $title }}</h1>

    @isset($actions)
        <div class="flex gap-3">{{ $actions }}</div>
    @endisset
</div>
