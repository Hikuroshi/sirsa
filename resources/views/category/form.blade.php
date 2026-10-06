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
