<x-layouts.app>
    <x-slot:title>API Key AI</x-slot:title>
    <x-page-header title="API Key AI">
        <x-slot:actions>
            <x-button :href="route('ai-keys.create')">Tambah</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-search placeholder="Cari nama atau akhiran API key..." />

    <div class="mt-4 overflow-x-auto rounded bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Provider / Model</th>
                    <th class="p-3">Key</th>
                    <th class="p-3">Prioritas</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($keys as $key)
                    <tr class="border-b">
                        <td class="p-3">{{ $key->name }}</td>
                        <td class="p-3">{{ $key->modelLimit->provider }} / {{ $key->modelLimit->model }}</td>
                        <td class="p-3">••••{{ $key->suffix }}</td>
                        <td class="p-3">{{ $key->priority }}</td>
                        <td class="p-3"><x-badge>{{ $key->is_active ? 'Aktif' : 'Tidak aktif' }}</x-badge></td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <x-button :href="route('ai-keys.show', $key)" variant="link">Detail</x-button>
                                <x-button :href="route('ai-keys.edit', $key)" variant="link">Edit</x-button>
                                <form
                                    action="{{ route('ai-keys.destroy', $key) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus API key ini?');"
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
                        <td class="p-3 text-center text-gray-500" colspan="6">Belum ada API key.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $keys->links() }}</div>
</x-layouts.app>
