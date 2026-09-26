<x-layouts.app>
    <x-slot:title>{{ $organization->name }}</x-slot:title>
    <x-page-header :title="$organization->name">
        @can('update', $organization)
            <x-slot:actions>
                <x-button :href="route('organizations.edit', $organization)" variant="warning">Edit</x-button>
            </x-slot:actions>
        @endcan
    </x-page-header>

    <x-card class="mt-6">
        <dl class="grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-gray-500">Slug</dt>
                <dd>{{ $organization->slug }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Status</dt>
                <dd>{{ $organization->is_active ? 'Aktif' : 'Tidak aktif' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Pembuat</dt>
                <dd>{{ $organization->creator->name }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Dibuat</dt>
                <dd>{{ $organization->created_at->format('d M Y H:i') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-sm text-gray-500">Deskripsi</dt>
                <dd>{{ $organization->description ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Admin</dt>
                <dd>{{ $organization->admins_count }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Kategori</dt>
                <dd>{{ $organization->categories_count }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Laporan</dt>
                <dd>{{ $organization->reports_count }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">API key</dt>
                <dd>{{ $organization->ai_api_keys_count }}</dd>
            </div>
        </dl>
    </x-card>

    <x-card class="mt-4">
        <p class="text-sm text-gray-500">Link laporan publik</p>
        <a
            class="break-all text-blue-600"
            href="{{ route('public-reports.create', $organization) }}"
        >{{ route('public-reports.create', $organization) }}</a>
    </x-card>
</x-layouts.app>
