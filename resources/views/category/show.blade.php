<x-layouts.app>
    <x-slot:title>Detail Kategori</x-slot:title>
    <x-page-header title="Detail Kategori" />

    <x-card class="mt-6">
        <dl class="grid gap-3">
            <div>
                <dt class="font-semibold">Nama</dt>
                <dd>{{ $category->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Organisasi</dt>
                <dd>{{ $category->organization->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Deskripsi</dt>
                <dd>{{ $category->description ?: '-' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Status</dt>
                <dd>{{ $category->is_active ? 'Aktif' : 'Tidak aktif' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Jumlah laporan</dt>
                <dd>{{ $category->reports_count }}</dd>
            </div>
        </dl>
    </x-card>

    <div class="mt-4 flex gap-3">
        <x-button :href="route('categories.edit', $category)" variant="warning">Edit</x-button>
        <x-button :href="route('categories.index')" variant="secondary">Kembali</x-button>
    </div>
</x-layouts.app>
