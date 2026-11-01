<x-layouts.app>
    <x-slot:title>
        Daftar Akun
    </x-slot:title>

    <div class="mx-auto grid max-w-5xl gap-8 py-4 sm:py-8 lg:grid-cols-2 lg:items-center lg:gap-16">
        <section class="grid gap-5" aria-labelledby="register-heading">
            <span class="badge badge-outline h-auto py-2">Bersama membangun desa</span>
            <h1 id="register-heading" class="text-3xl font-bold tracking-tight sm:text-4xl">
                Satu akun untuk
                <br />
                setiap aspirasi Anda.
            </h1>
            <p class="max-w-md text-base leading-relaxed text-base-content/65">Bergabung dengan {{ config('app.name') }} dan simpan laporan Anda dalam satu tempat.</p>
            <ul class="grid gap-4 text-sm text-base-content/70">
                <li class="flex items-center gap-3">
                    <span
                        class="flex size-7 shrink-0 items-center justify-center rounded-full bg-base-200 font-semibold"
                        aria-hidden="true"
                    >
                        1
                    </span>
                    Kirim laporan tentang lingkungan sekitar.
                </li>
                <li class="flex items-center gap-3">
                    <span
                        class="flex size-7 shrink-0 items-center justify-center rounded-full bg-base-200 font-semibold"
                        aria-hidden="true"
                    >
                        2
                    </span>
                    Temukan kembali laporan dalam akun Anda.
                </li>
                <li class="flex items-center gap-3">
                    <span
                        class="flex size-7 shrink-0 items-center justify-center rounded-full bg-base-200 font-semibold"
                        aria-hidden="true"
                    >
                        3
                    </span>
                    Ikuti perkembangan penanganannya.
                </li>
            </ul>
        </section>

        <x-card>
            <div class="mb-2">
                <h2 class="text-2xl font-bold tracking-tight">Buat akun pelapor</h2>
                <p class="mt-2 text-sm text-base-content/60">Lengkapi data berikut untuk memulai.</p>
            </div>
            <form class="grid gap-3" action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="grid gap-x-4 gap-y-2 sm:grid-cols-2">
                    <x-form.input
                        label="Nama lengkap"
                        name="name"
                        aria-label="Nama lengkap"
                        placeholder="Nama Anda"
                        autocomplete="name"
                        required
                        autofocus
                    />
                    <x-form.input
                        label="Username"
                        name="username"
                        aria-label="Username"
                        placeholder="Username Anda"
                        autocomplete="username"
                        required
                    />
                </div>
                <x-form.input
                    label="Email"
                    name="email"
                    type="email"
                    aria-label="Email"
                    placeholder="nama@contoh.com"
                    autocomplete="email"
                    required
                />
                <x-form.input
                    label="Password"
                    name="password"
                    type="password"
                    aria-label="Password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                    minlength="8"
                    required
                />
                <x-form.input
                    label="Konfirmasi password"
                    name="password_confirmation"
                    type="password"
                    aria-label="Konfirmasi password"
                    placeholder="Ulangi password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                />

                <x-button type="submit" class="mt-2 w-full">Daftar Akun</x-button>
            </form>

            <p class="mt-4 text-center text-sm text-base-content/60">Sudah punya akun?
            <a class="font-semibold underline underline-offset-4 hover:no-underline" href="{{ route('login') }}">Masuk di sini</a></p>
        </x-card>
    </div>
</x-layouts.app>
