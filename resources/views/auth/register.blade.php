<x-layouts.app>
    <x-slot:title>Register</x-slot:title>

    <div class="mx-auto max-w-md rounded bg-white p-6">
        <h1 class="text-2xl font-semibold">Register</h1>

        <form class="mt-6 grid gap-4" action="{{ route('register.store') }}" method="POST">
            @csrf

            <label>
                <span class="block">Nama</span>
                <input
                    class="mt-1 w-full rounded border p-2"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    autofocus
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
                    value="{{ old('username') }}"
                />
                @error('username')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="block">Email</span>
                <input class="mt-1 w-full rounded border p-2" type="email" name="email" value="{{ old('email') }}" />
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="block">Password</span>
                <input class="mt-1 w-full rounded border p-2" type="password" name="password" />
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="block">Konfirmasi Password</span>
                <input class="mt-1 w-full rounded border p-2" type="password" name="password_confirmation" />
            </label>

            <button class="rounded bg-blue-600 px-4 py-2 text-white" type="submit">Register</button>
        </form>

        <p class="mt-4 text-sm">Sudah punya akun? <a class="text-blue-600" href="{{ route('login') }}">Login</a></p>
    </div>
</x-layouts.app>
