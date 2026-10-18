@props(['label', 'name', 'value' => ''])

<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    <textarea
        name="{{ $name }}"
        {{ $attributes->class(['textarea w-full', 'textarea-error' => $errors->has($name)]) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="label text-error">{{ $message }}</p>
    @enderror
</fieldset>
