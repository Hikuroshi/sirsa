<x-layouts.app>
    <x-slot:title>{{ isset($organization) ? 'Edit Organisasi' : 'Buat Organisasi' }}</x-slot:title>
    <x-page-header :title="isset($organization) ? 'Edit Organisasi' : 'Buat Organisasi'" />
    <x-card class="mt-6">
        <form
            class="grid gap-4"
            action="{{ isset($organization) ? route('organizations.update', $organization) : route('organizations.store') }}"
            method="POST"
        >
            @csrf
            @isset($organization)
                @method('PUT')
            @endisset
            <x-form.input label="Nama" name="name" :value="$organization->name ?? ''" />
            <x-form.input label="Slug link publik" name="slug" :value="$organization->slug ?? ''" />
            <x-form.textarea label="Deskripsi" name="description" :value="$organization->description ?? ''" />
            <x-form.checkbox label="Aktif" name="is_active" :checked="$organization->is_active ?? true" />
            <div class="flex gap-3">
                <x-button type="submit">Simpan</x-button>
                <x-button
                    :href="isset($organization) ? route('organizations.show', $organization) : route('organizations.index')"
                    variant="secondary"
                >Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
