@props(['placeholder' => 'Cari data...'])

<form
    method="GET"
    role="search"
    action="{{ url()->current() }}"
    {{ $attributes->class('mt-4 flex max-w-md items-center gap-2') }}
>
    <div class="join w-full">
        <input
            name="search"
            type="search"
            value="{{ request('search') }}"
            placeholder="{{ $placeholder }}"
            {{ request()->has('search') ? 'autofocus' : '' }}
            autocomplete="off"
            class="input input-sm join-item w-full"
            onfocus="this.setSelectionRange(this.value.length, this.value.length)"
            oninput="
                clearTimeout(this.form.searchTimer);
                this.form.searchTimer = setTimeout(() => this.form.requestSubmit(), 500);
            "
        />
        <button type="submit" class="btn btn-sm btn-primary join-item">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari
        </button>
    </div>
</form>

