<x-layouts.app>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">{{ $title }}</h1>
            <p class="mt-1 text-sm text-base-content/60">Kelola akun dan peran pengguna {{ config('app.name') }}.</p>
        </div>
        <x-button :href="route('user.create')" class="btn-sm">
            <svg aria-hidden="true" class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Pengguna
        </x-button>
    </div>

    @error ('user')
        <x-alert class="mt-4" type="error">{{ $message }}</x-alert>
    @enderror

    <x-search placeholder="Cari nama, username, atau email..." />

    <div class="card mt-6 overflow-hidden border border-base-300 bg-base-100 shadow-xs">
        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-base-300 px-5 py-4">
            <h2 class="text-sm font-semibold">Akun terdaftar</h2>
            <span class="badge badge-ghost badge-sm">
                {{ $users->total() }} pengguna{{ request()->filled('search') ? ' ditemukan' : '' }}
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead class="bg-base-200/60 text-base-content/70">
                    <tr>
                        <th scope="col">Pengguna</th>
                        <th scope="col">Email</th>
                        <th scope="col">Peran</th>
                        <th scope="col" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="hover:bg-base-200/50">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-placeholder" aria-hidden="true">
                                        <div class="size-10 rounded-full bg-base-200 text-base-content/70">
                                            <span class="text-sm font-semibold">
                                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold">{{ $user->name }}</div>
                                        <div class="text-xs text-base-content/60">{{ $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <x-badge :variant="$user->isAdmin() ? 'info' : 'ghost'" class="badge-sm">
                                    {{ $user->role->label() }}
                                </x-badge>
                            </td>
                            <td>
                                <div class="flex justify-end gap-1">
                                    <a href="{{ route('user.show', $user) }}" class="btn btn-ghost btn-sm">Detail</a>
                                    <a href="{{ route('user.edit', $user) }}" class="btn btn-ghost btn-sm">Edit</a>
                                    <form
                                        action="{{ route('user.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm(@js($deletionWarnings[$user->id]))"
                                    >
                                        @csrf
                                        @method ('DELETE')
                                        <button type="submit" class="btn btn-error btn-soft btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-12 text-center" colspan="4">
                                <p class="font-semibold">{{ request()->filled('search') ? 'Pengguna tidak ditemukan' : 'Belum ada pengguna' }}</p>
                                <p class="mt-1 text-sm text-base-content/60">{{ request()->filled('search') ? 'Coba nama, username, atau email yang lain.' : 'Tambahkan pengguna untuk mulai mengelola akun.' }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
</x-layouts.app>
