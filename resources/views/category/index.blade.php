<x-layouts.app>
    <x-slot:title>Daftar Kategori</x-slot:title>

    <x-page-header title="Daftar Kategori">
        <x-slot:actions>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">Tambah</a>
        </x-slot:actions>
    </x-page-header>

    <x-search placeholder="Cari nama atau deskripsi kategori..." />

    <div class="mt-4 overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Laporan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <span class="badge badge-accent -soft">{{ $category->reports_count }}</span>
                        </td>
                        <td>
                            <div class="flex flex-wrap gap-1">
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-ghost">Detail</a>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-ghost">Edit</a>
                                <form
                                    action="{{ route('categories.destroy', $category) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus kategori ini?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error btn-soft">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-base-content/50" colspan="3">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
</x-layouts.app>
