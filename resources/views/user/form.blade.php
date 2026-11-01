<x-layouts.app>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <div class="mx-auto max-w-4xl">
        <a href="{{ route('user.index') }}" class="btn btn-ghost btn-sm mb-4">← Daftar Pengguna</a>
        <h1 class="text-2xl font-bold tracking-tight">{{ $title }}</h1>
        <p class="mt-1 text-sm text-base-content/60">{{ isset($user) ? 'Perbarui informasi dan akses akun pengguna.' : 'Lengkapi informasi untuk membuat akun pengguna baru.' }}</p>

        <x-card class="mt-6">
            <form
                class="grid gap-6"
                method="POST"
                action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}"
            >
                @csrf
                @isset ($user)
                    @method ('PUT')
                @endisset

                <section aria-labelledby="account-heading">
                    <h2 id="account-heading" class="font-semibold">Informasi akun</h2>
                    <p class="mt-1 text-sm text-base-content/60">Nama, identitas login, dan peran pengguna.</p>
                    <div class="mt-3 grid gap-x-6 gap-y-2 sm:grid-cols-2">
                        <x-form.input
                            label="Nama lengkap"
                            name="name"
                            :value="$user->name ?? ''"
                            aria-label="Nama lengkap"
                            autocomplete="name"
                            required
                        />
                        <x-form.input
                            label="Username"
                            name="username"
                            :value="$user->username ?? ''"
                            aria-label="Username"
                            autocomplete="username"
                            required
                        />
                        <x-form.input
                            label="Email"
                            name="email"
                            type="email"
                            :value="$user->email ?? ''"
                            aria-label="Email"
                            autocomplete="email"
                            required
                        />

                        <x-form.select label="Peran" name="role" aria-label="Peran" required>
                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->value }}"
                                    @selected (old('role', $user->role->value ?? App\Enums\Role::Reporter->value) === $role->value)
                                >
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>
                </section>

                <section class="border-t border-base-300 pt-6" aria-labelledby="password-heading">
                    <h2 id="password-heading" class="font-semibold">Keamanan akun</h2>
                    <p class="mt-1 text-sm text-base-content/60">{{ isset($user) ? 'Kosongkan kedua kolom untuk mempertahankan password saat ini.' : 'Gunakan password minimal 8 karakter.' }}</p>
                    <div class="mt-3 grid gap-x-6 gap-y-2 sm:grid-cols-2">
                        <x-form.input
                            :label="isset($user) ? 'Password baru (opsional)' : 'Password'"
                            name="password"
                            type="password"
                            aria-label="Password"
                            autocomplete="new-password"
                            minlength="8"
                            :required="! isset($user)"
                        />
                        <x-form.input
                            label="Konfirmasi password"
                            name="password_confirmation"
                            type="password"
                            aria-label="Konfirmasi password"
                            autocomplete="new-password"
                            minlength="8"
                            :required="! isset($user)"
                        />
                    </div>
                </section>

                <div class="card-actions flex-col gap-2 border-t border-base-300 pt-6 sm:flex-row">
                    <x-button type="submit" class="w-full sm:w-auto">Simpan Pengguna</x-button>
                    <a href="{{ route('user.index') }}" class="btn btn-ghost w-full sm:w-auto">Batal</a>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
