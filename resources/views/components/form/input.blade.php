@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
])

<label class="grid gap-1">
    <span>{{ $label }}</span>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $type === 'password' ? '' : old($name, $value) }}"
        {{ $attributes->class(['w-full rounded border p-2', 'border-red-500' => $errors->has($name)]) }}
    />
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</label>
