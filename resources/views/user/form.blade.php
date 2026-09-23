<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h1 class="text-2xl font-semibold">{{ $title }}</h1>

    <form
        class="mt-6 grid gap-4 rounded bg-white p-6"
        method="POST"
        action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}"
    >
        @csrf
        @isset($user)
            @method('PUT')
        @endisset

        <label>
            <span class="block">Nama</span>
            <input
                class="mt-1 w-full rounded border p-2"
                type="text"
                name="name"
                value="{{ old('name', $user->name ?? '') }}"
            />
            @error('name')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span class="block">Username</span>
            <input
                class="mt-1 w-full rounded border p-2"
                type="text"
                name="username"
                value="{{ old('username', $user->username ?? '') }}"
            />
            @error('username')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span class="block">Email</span>
            <input
                class="mt-1 w-full rounded border p-2"
                type="email"
                name="email"
                value="{{ old('email', $user->email ?? '') }}"
            />
            @error('email')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span class="block">Role</span>
            <select class="mt-1 w-full rounded border p-2" name="role">
                @foreach ($roles as $role)
                    <option
                        value="{{ $role->value }}"
                        @selected(old('role', isset($user) ? $user->role->value : '') === $role->value)
                    >
                        {{ $role->label() }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span class="block">Password {{ isset($user) ? '(opsional)' : '' }}</span>
            <input class="mt-1 w-full rounded border p-2" type="password" name="password" />
            @error('password')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span class="block">Konfirmasi Password</span>
            <input class="mt-1 w-full rounded border p-2" type="password" name="password_confirmation" />
        </label>

        <div class="flex gap-3">
            <button class="rounded bg-blue-600 px-4 py-2 text-white" type="submit">Simpan</button>
            <a class="rounded border px-4 py-2" href="{{ route('user.index') }}">Batal</a>
        </div>
    </form>
</x-layouts.app>
