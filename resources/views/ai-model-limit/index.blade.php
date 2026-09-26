<x-layouts.app>
    <x-slot:title>Model AI</x-slot:title>
    <x-page-header title="Model AI">
        <x-slot:actions>
            <x-button :href="route('ai-model-limits.create')">Tambah</x-button>
        </x-slot:actions>
    </x-page-header>

    @error('model')
        <x-alert class="mt-4" type="error">{{ $message }}</x-alert>
    @enderror

    <div class="mt-6 overflow-x-auto rounded bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3">Provider</th>
                    <th class="p-3">Model</th>
                    <th class="p-3">RPM</th>
                    <th class="p-3">RPD</th>
                    <th class="p-3">TPM</th>
                    <th class="p-3">API key</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($limits as $limit)
                    <tr class="border-b">
                        <td class="p-3">{{ $limit->provider }}</td>
                        <td class="p-3">{{ $limit->model }}</td>
                        <td class="p-3">{{ $limit->rpm }}</td>
                        <td class="p-3">{{ $limit->rpd }}</td>
                        <td class="p-3">{{ $limit->tpm }}</td>
                        <td class="p-3">{{ $limit->api_keys_count }}</td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <x-button :href="route('ai-model-limits.show', $limit)" variant="link">Detail</x-button>
                                <x-button :href="route('ai-model-limits.edit', $limit)" variant="link">Edit</x-button>
                                <form
                                    action="{{ route('ai-model-limits.destroy', $limit) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus konfigurasi model ini?');"
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
                        <td class="p-3 text-center text-gray-500" colspan="7">Belum ada model AI.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $limits->links() }}</div>
</x-layouts.app>
