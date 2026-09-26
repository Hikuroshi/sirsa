<x-layouts.app>
    <x-slot:title>Daftar Kategori</x-slot:title>

    <x-page-header title="Daftar Kategori">
        <x-slot:actions>
            <x-button :href="route('categories.create')">Tambah</x-button>
        </x-slot:actions>
    </x-page-header>

    <div class="mt-6 overflow-x-auto rounded bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3">Nama</th>
                    @if (auth()->user()->isSuperadmin())
                        <th class="p-3">Organisasi</th>
                    @endif
                    <th class="p-3">Status</th>
                    <th class="p-3">Laporan</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="p-3">{{ $category->name }}</td>
                        @if (auth()->user()->isSuperadmin())
                            <td class="p-3">{{ $category->organization->name }}</td>
                        @endif
                        <td class="p-3"><x-badge>{{ $category->is_active ? 'Aktif' : 'Tidak aktif' }}</x-badge></td>
                        <td class="p-3">{{ $category->reports_count }}</td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <x-button :href="route('categories.show', $category)" variant="link">Detail</x-button>
                                <x-button :href="route('categories.edit', $category)" variant="link">Edit</x-button>
                                <form
                                    action="{{ route('categories.destroy', $category) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus kategori ini?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger">Hapus</x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3 text-center text-gray-500" colspan="5">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
</x-layouts.app>
