@props(['label', 'name', 'value' => ''])

<label class="grid gap-1">
    <span>{{ $label }}</span>
    <textarea
        name="{{ $name }}"
        {{ $attributes->class(['w-full rounded border p-2', 'border-red-500' => $errors->has($name)]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</label>
