@props(['placeholder' => 'Cari data...'])

<form
    method="GET"
    role="search"
    action="{{ url()->current() }}"
    {{ $attributes->class('mt-6 flex max-w-md items-end gap-2') }}
>
    <div class="min-w-0 flex-1">
        <x-form.input
            label="Cari"
            name="search"
            type="search"
            :value="request('search')"
            :placeholder="$placeholder"
            :autofocus="request()->has('search')"
            autocomplete="off"
            onfocus="this.setSelectionRange(this.value.length, this.value.length)"
            oninput="
                clearTimeout(this.form.searchTimer);
                this.form.searchTimer = setTimeout(() => this.form.requestSubmit(), 500);
            "
        />
    </div>
    <x-button type="submit">Cari</x-button>
</form>
