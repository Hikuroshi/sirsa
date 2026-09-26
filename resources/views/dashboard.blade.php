<x-layouts.app>
    <x-slot:title>Dashboard</x-slot:title>

    <x-page-header title="Dashboard" />

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <x-card>
            <p class="text-sm text-gray-500">Organisasi</p>
            <p class="text-2xl font-semibold">{{ $organizationCount }}</p>
        </x-card>
        <x-card>
            <p class="text-sm text-gray-500">Laporan</p>
            <p class="text-2xl font-semibold">{{ $reportCount }}</p>
        </x-card>
        @if ($userCount !== null)
            <x-card>
                <p class="text-sm text-gray-500">Pengguna</p>
                <p class="text-2xl font-semibold">{{ $userCount }}</p>
            </x-card>
        @endif
    </div>
</x-layouts.app>
