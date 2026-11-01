<x-layouts.app>
    <x-slot:title>
        Login
    </x-slot:title>

    <div class="mx-auto grid max-w-5xl gap-8 py-4 sm:py-8 lg:grid-cols-2 lg:items-center lg:gap-16">
        <section class="grid gap-5" aria-labelledby="welcome-heading">
            <span class="badge badge-outline h-auto py-2">Portal pengaduan warga</span>
            <h1 id="welcome-heading" class="text-3xl font-bold tracking-tight sm:text-4xl">
                Suara Anda,
                <br />
                langkah perubahan desa.
            </h1>
            <p class="max-w-md text-base leading-relaxed text-base-content/65">Sampaikan kendala di lingkungan Anda dan ikuti perkembangan penanganannya bersama {{ config('app.name') }}.</p>
            <div class="flex items-center gap-3 rounded-box border border-base-300 bg-base-200/50 p-4">
                <svg aria-hidden="true" class="size-6 shrink-0 text-base-content/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-sm leading-relaxed text-base-content/70">Laporan tersimpan, perkembangan penanganan dapat dipantau.</p>
            </div>
        </section>

        <x-card>
            <div class="mb-2">
                <h2 class="text-2xl font-bold tracking-tight">Selamat datang kembali</h2>
                <p class="mt-2 text-sm text-base-content/60">Masuk untuk melanjutkan aktivitas Anda.</p>
            </div>
            <form class="grid gap-3" action="{{ route('authenticate') }}" method="POST">
                @csrf

                <x-form.input
                    label="Username atau email"
                    name="login"
                    aria-label="Username atau email"
                    placeholder="Masukkan username atau email"
                    autocomplete="username"
                    required
                    autofocus
                />

                <x-form.input
                    label="Password"
                    name="password"
                    type="password"
                    aria-label="Password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                />

                <x-form.checkbox label="Ingat saya" name="remember" />

                <x-button type="submit" class="w-full">Masuk</x-button>
            </form>

            <p class="mt-4 text-center text-sm text-base-content/60">
                Belum punya akun?
                <a class="font-semibold underline underline-offset-4 hover:no-underline" href="{{ route('register') }}">
                    Daftar sekarang
                </a>
            </p>
        </x-card>
    </div>
    <p class="mt-4 text-center text-sm text-base-content/60">Ingin langsung menyampaikan aduan?
    <a href="{{ route('public-reports.create') }}" class="font-medium underline underline-offset-4 hover:no-underline">Lapor tanpa akun</a></p>
</x-layouts.app>
