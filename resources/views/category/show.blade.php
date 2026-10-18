<x-layouts.app>
    <x-slot:title>Detail Kategori</x-slot:title>
    <x-page-header title="Detail Kategori" />

    <div class="card bg-base-100 mt-6 shadow-sm">
        <div class="card-body">
            <dl class="grid gap-4">
                <div>
                    <dt class="text-base-content/60 text-sm">Nama</dt>
                    <dd class="font-medium">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-base-content/60 text-sm">Deskripsi</dt>
                    <dd class="font-medium">{{ $category->description ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-base-content/60 text-sm">Jumlah laporan</dt>
                    <dd>
                        <span class="badge badge-accent badge-soft">{{ $category->reports_count }}</span>
                    </dd>
                </div>
            </dl>

            <div class="card-actions mt-4">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('categories.index') }}" class="btn btn-ghost btn-sm">Kembali</a>
            </div>
        </div>
    </div>
</x-layouts.app>
