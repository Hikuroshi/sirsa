@props(['label', 'name', 'type' => 'text', 'value' => ''])

<fieldset class="fieldset">
    <legend class="fieldset-legend">{{ $label }}</legend>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $type === 'password' ? '' : old($name, $value) }}"
        {{ $attributes->class(['input w-full', 'input-error' => $errors->has($name)]) }}
    />
    @error($name)
        <p class="label text-error">{{ $message }}</p>
    @enderror
</fieldset>
