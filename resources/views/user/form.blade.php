<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-page-header :title="$title" />

    <x-card class="mt-6">
        <form class="grid gap-4" method="POST" action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}">
            @csrf
            @isset($user)
                @method('PUT')
            @endisset

            <x-form.input label="Nama" name="name" :value="$user->name ?? ''" />
            <x-form.input label="Username" name="username" :value="$user->username ?? ''" />
            <x-form.input label="Email" name="email" type="email" :value="$user->email ?? ''" />

            <x-form.select label="Role" name="role">
                @foreach ($roles as $role)
                    <option
                        value="{{ $role->value }}"
                        @selected(old('role', isset($user) ? $user->role->value : '') === $role->value)
                    >
                        {{ $role->label() }}
                    </option>
                @endforeach
            </x-form.select>

            <x-form.input :label="isset($user) ? 'Password (opsional)' : 'Password'" name="password" type="password" />
            <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password" />

            <div class="flex gap-3">
                <x-button type="submit">Simpan</x-button>
                <x-button :href="route('user.index')" variant="secondary">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
