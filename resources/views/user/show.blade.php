<x-layouts.app>
    <x-slot:title>Detail Pengguna</x-slot:title>

    <x-page-header title="Detail Pengguna" />

    <x-card class="mt-6">
        <dl class="grid gap-3">
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
    </x-card>

    <div class="mt-4 flex gap-3">
        <x-button :href="route('user.edit', $user)" variant="warning">Edit</x-button>
        <x-button :href="route('user.index')" variant="secondary">Kembali</x-button>
    </div>
</x-layouts.app>
