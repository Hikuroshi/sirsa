<x-layouts.app>
    <x-slot:title>
        Detail Pengguna
    </x-slot:title>

    <div class="mx-auto max-w-4xl">
        <a href="{{ route('user.index') }}" class="btn btn-ghost btn-sm mb-4">← Daftar Pengguna</a>
        <h1 class="text-2xl font-bold tracking-tight">Detail Pengguna</h1>
        <p class="mt-1 text-sm text-base-content/60">Informasi profil dan peran akun pengguna.</p>

        <x-card class="mt-6">
            <div class="flex flex-col gap-4 border-b border-base-300 pb-6 sm:flex-row sm:items-center">
                <div class="avatar avatar-placeholder" aria-hidden="true">
                    <div class="size-16 rounded-2xl bg-base-200 text-base-content/70">
                        <span class="text-2xl font-bold">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="wrap-anywhere text-xl font-bold">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm text-base-content/60">{{ $user->username }}</p>
                </div>
                <x-badge :variant="$user->isAdmin() ? 'info' : 'ghost'">{{ $user->role->label() }}</x-badge>
            </div>
            <dl class="mt-4 grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-base-content/60">Nama lengkap</dt>
                    <dd class="mt-1 wrap-anywhere font-medium">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-base-content/60">Username</dt>
                    <dd class="mt-1 wrap-anywhere font-medium">{{ $user->username }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-base-content/60">Email</dt>
                    <dd class="mt-1 wrap-anywhere font-medium">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-base-content/60">Terdaftar sejak</dt>
                    <dd class="mt-1 font-medium">{{ $user->created_at?->translatedFormat('d F Y') ?? '—' }}</dd>
                </div>
            </dl>
            <div class="card-actions mt-4 flex-col gap-2 border-t border-base-300 pt-6 sm:flex-row">
                <x-button :href="route('user.edit', $user)" class="w-full sm:w-auto">Edit Pengguna</x-button>
                <a href="{{ route('user.index') }}" class="btn btn-ghost w-full sm:w-auto">Kembali</a>
            </div>
        </x-card>
    </div>
</x-layouts.app>
