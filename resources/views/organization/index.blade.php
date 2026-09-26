<x-layouts.app>
    <x-slot:title>Organisasi</x-slot:title>
    <x-page-header title="Daftar Organisasi">
        <x-slot:actions>
            <x-button :href="route('organizations.create')">Tambah</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-search placeholder="Cari nama, slug, atau deskripsi..." />

    <div class="mt-4 overflow-x-auto rounded bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Admin</th>
                    <th class="p-3">Laporan</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($organizations as $organization)
                    <tr class="border-b">
                        <td class="p-3">{{ $organization->name }}</td>
                        <td class="p-3"><x-badge>{{ $organization->is_active ? 'Aktif' : 'Tidak aktif' }}</x-badge></td>
                        <td class="p-3">{{ $organization->admins_count }}</td>
                        <td class="p-3">{{ $organization->reports_count }}</td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <x-button :href="route('organizations.show', $organization)" variant="link"
                                    >Detail</x-button>
                                <x-button :href="route('organizations.edit', $organization)" variant="link"
                                    >Edit</x-button>
                                <form
                                    action="{{ route('organizations.destroy', $organization) }}"
                                    method="POST"
                                    onsubmit="return confirm(@js($deletionWarnings[$organization->id]))"
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
                        <td class="p-3 text-center text-gray-500" colspan="5">Belum ada organisasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $organizations->links() }}</div>
</x-layouts.app>
