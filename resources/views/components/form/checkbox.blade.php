@props(['label', 'name', 'checked' => false])

<div class="grid gap-1">
    <label class="flex items-center gap-2">
        <input type="hidden" name="{{ $name }}" value="0" />
        <input
            type="checkbox"
            name="{{ $name }}"
            value="1"
            @checked(old($name, $checked))
            {{ $attributes->class('rounded border') }}
        />
        <span>{{ $label }}</span>
    </label>
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
