<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="$title" />

    <x-card class="mt-6">
        <form
            class="grid gap-4"
            action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
            method="POST"
        >
            @csrf
            @isset($category)
                @method('PUT')
            @endisset

            @if (isset($category))
                <div>
                    <p class="text-sm text-gray-500">Organisasi</p>
                    <p>{{ $category->organization->name }}</p>
                </div>
            @elseif (auth()->user()->isSuperadmin())
                <x-form.select label="Organisasi" name="organization_id">
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}" @selected(old('organization_id') === $organization->id)>
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </x-form.select>
            @endif

            <x-form.input label="Nama" name="name" :value="$category->name ?? ''" />
            <x-form.textarea label="Deskripsi" name="description" :value="$category->description ?? ''" />
            <x-form.checkbox label="Aktif" name="is_active" :checked="$category->is_active ?? true" />

            <div class="flex gap-3">
                <x-button type="submit">Simpan</x-button>
                <x-button :href="route('categories.index')" variant="secondary">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
