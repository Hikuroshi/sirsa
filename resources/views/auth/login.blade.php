<x-layouts.app>
    <x-slot:title>Login</x-slot:title>

    <div class="mx-auto max-w-md rounded bg-white p-6">
        <h1 class="text-2xl font-semibold">Login</h1>

        @if (session('success'))
            <p class="mt-4 rounded bg-green-100 p-3 text-green-800">{{ session('success') }}</p>
        @endif

        <form class="mt-6 grid gap-4" action="{{ route('authenticate') }}" method="POST">
            @csrf

            <label>
                <span class="block">Username atau Email</span>
                <input
                    class="mt-1 w-full rounded border p-2"
                    type="text"
                    name="login"
                    value="{{ old('login') }}"
                    autofocus
                />
                @error('login')
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

            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" value="1" />
                <span>Ingat saya</span>
            </label>

            <button class="rounded bg-blue-600 px-4 py-2 text-white" type="submit">Login</button>
        </form>

        <p class="mt-4 text-sm">
            Belum punya akun? <a class="text-blue-600" href="{{ route('register') }}">Register</a>
        </p>
    </div>
</x-layouts.app>
