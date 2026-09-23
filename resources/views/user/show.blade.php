<x-layouts.app>
    <x-slot:title>Detail Pengguna</x-slot:title>

    <h1 class="text-2xl font-semibold">Detail Pengguna</h1>

    <dl class="mt-6 grid gap-3 rounded bg-white p-6">
        <div>
            <dt class="font-semibold">Nama</dt>
            <dd>{{ $user->name }}</dd>
        </div>
        <div>
            <dt class="font-semibold">Username</dt>
            <dd>{{ $user->username }}</dd>
        </div>
        <div>
            <dt class="font-semibold">Email</dt>
            <dd>{{ $user->email }}</dd>
        </div>
        <div>
            <dt class="font-semibold">Role</dt>
            <dd>{{ $user->role->label() }}</dd>
        </div>
    </dl>

    <div class="mt-4 flex gap-3">
        <a class="rounded bg-amber-500 px-4 py-2 text-white" href="{{ route('user.edit', $user) }}">Edit</a>
        <a class="rounded border px-4 py-2" href="{{ route('user.index') }}">Kembali</a>
    </div>
</x-layouts.app>
