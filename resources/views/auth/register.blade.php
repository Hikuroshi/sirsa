<x-layouts.app>
    <x-slot:title>Register</x-slot:title>

    <x-card class="mx-auto max-w-md">
        <h1 class="text-2xl font-semibold">Register</h1>

        <form class="mt-6 grid gap-4" action="{{ route('register.store') }}" method="POST">
            @csrf

            <x-form.input label="Nama" name="name" autofocus />
            <x-form.input label="Username" name="username" />
            <x-form.input label="Email" name="email" type="email" />
            <x-form.select label="Tipe Akun" name="role">
                <option value="reporter" @selected(old('role') === 'reporter')>Pelapor</option>
                <option value="admin" @selected(old('role') === 'admin')>Admin Organisasi</option>
            </x-form.select>
            <x-form.input label="Password" name="password" type="password" />
            <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password" />

            <x-button type="submit">Register</x-button>
        </form>

        <p class="mt-4 text-sm">Sudah punya akun? <a class="text-blue-600" href="{{ route('login') }}">Login</a></p>
    </x-card>
</x-layouts.app>
