@props(['label', 'name'])

<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    <select
        name="{{ $name }}"
        {{ $attributes->class(['select w-full', 'select-error' => $errors->has($name)]) }}
    >
        {{ $slot }}
    </select>
    @error($name)
        <p class="label text-error">{{ $message }}</p>
    @enderror
</fieldset>

