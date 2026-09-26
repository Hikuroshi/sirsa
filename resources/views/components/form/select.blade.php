@props(['label', 'name'])

<label class="grid gap-1">
    <span>{{ $label }}</span>
    <select
        name="{{ $name }}"
        {{ $attributes->class(['w-full rounded border p-2', 'border-red-500' => $errors->has($name)]) }}
    >
        {{ $slot }}
    </select>
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</label>
