<x-layouts.app>
    <x-slot:title>Daftar Pengguna</x-slot:title>

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Daftar Pengguna</h1>
        <a class="rounded bg-blue-600 px-4 py-2 text-white" href="{{ route('user.create') }}">Tambah</a>
    </div>

    @if (session('success'))
        <p class="mt-4 rounded bg-green-100 p-3 text-green-800">{{ session('success') }}</p>
    @endif

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
                                <a class="text-blue-600" href="{{ route('user.show', $user) }}">Detail</a>
                                <a class="text-amber-600" href="{{ route('user.edit', $user) }}">Edit</a>
                                <form action="{{ route('user.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600" type="submit">Hapus</button>
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
