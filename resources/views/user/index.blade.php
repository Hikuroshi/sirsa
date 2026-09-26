<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="$title">
        <x-slot:actions>
            <x-button :href="route('user.create')">Tambah</x-button>
        </x-slot:actions>
    </x-page-header>

    @error('user')
        <x-alert class="mt-4" type="error">{{ $message }}</x-alert>
    @enderror

    <div class="mt-6 overflow-x-auto rounded bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Username</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->username }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">{{ $user->role->label() }}</td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <x-button :href="route('user.show', $user)" variant="link">Detail</x-button>
                                <x-button :href="route('user.edit', $user)" variant="link">Edit</x-button>
                                <form
                                    action="{{ route('user.destroy', $user) }}"
                                    method="POST"
                                    onsubmit="return confirm(@js($deletionWarnings[$user->id]))"
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
                        <td class="p-3 text-center text-gray-500" colspan="5">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</x-layouts.app>
