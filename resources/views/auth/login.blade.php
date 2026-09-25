<x-layouts.app>
    <x-slot:title>Login</x-slot:title>

    <x-card class="mx-auto max-w-md">
        <h1 class="text-2xl font-semibold">Login</h1>

        @if (session('success'))
            <x-alert class="mt-4">{{ session('success') }}</x-alert>
        @endif

        <form class="mt-6 grid gap-4" action="{{ route('authenticate') }}" method="POST">
            @csrf

            <x-form.input label="Username atau Email" name="login" autofocus />

            <x-form.input label="Password" name="password" type="password" />

            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" value="1" />
                <span>Ingat saya</span>
            </label>

            <x-button type="submit">Login</x-button>
        </form>

        <p class="mt-4 text-sm">
            Belum punya akun? <a class="text-blue-600" href="{{ route('register') }}">Register</a>
        </p>
    </x-card>
</x-layouts.app>
