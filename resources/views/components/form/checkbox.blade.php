@props (['label', 'name', 'checked' => false])

<div class="grid gap-1">
    <label class="flex min-h-11 cursor-pointer items-center gap-3 text-sm">
        <input type="hidden" name="{{ $name }}" value="0" />
        <input
            type="checkbox"
            name="{{ $name }}"
            value="1"
            @checked (old($name, $checked))
            {{ $attributes->class(['checkbox checkbox-sm', 'checkbox-error' => $errors->has($name)]) }}
        />
        <span>{{ $label }}</span>
    </label>
    @error ($name)
        <span class="text-sm text-error">{{ $message }}</span>
    @enderror
</div>
