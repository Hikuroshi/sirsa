@props(['placeholder' => 'Cari data...'])

<form method="GET" action="{{ url()->current() }}" {{ $attributes->class('mt-6 max-w-md') }}>
    <x-form.input
        label="Cari"
        name="search"
        type="search"
        :value="request('search')"
        :placeholder="$placeholder"
        autocomplete="off"
        oninput="clearTimeout(this.form.searchTimer); this.form.searchTimer = setTimeout(() => this.form.requestSubmit(), 500)"
    />
</form>
