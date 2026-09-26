<x-layouts.app>
    <x-slot:title>Detail API Key AI</x-slot:title>
    <x-page-header title="Detail API Key AI" />

    <x-card class="mt-6">
        @php($limits = $key->effectiveLimits())
        <dl class="grid gap-3 sm:grid-cols-2">
            <div>
                <dt class="font-semibold">Nama</dt>
                <dd>{{ $key->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold">API key</dt>
                <dd>••••{{ $key->suffix }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Provider</dt>
                <dd>{{ $key->modelLimit->provider }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Model</dt>
                <dd>{{ $key->modelLimit->model }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Cakupan</dt>
                <dd>{{ $key->organization?->name ?? 'Global' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Status</dt>
                <dd>{{ $key->is_active ? 'Aktif' : 'Tidak aktif' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Prioritas</dt>
                <dd>{{ $key->priority }}</dd>
            </div>
            <div>
                <dt class="font-semibold">RPM efektif</dt>
                <dd>{{ $limits['rpm'] }}</dd>
            </div>
            <div>
                <dt class="font-semibold">RPD efektif</dt>
                <dd>{{ $limits['rpd'] }}</dd>
            </div>
            <div>
                <dt class="font-semibold">TPM efektif</dt>
                <dd>{{ $limits['tpm'] }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Terakhir digunakan</dt>
                <dd>{{ $key->last_used_at?->format('d M Y H:i') ?? '-' }}</dd>
            </div>
        </dl>
    </x-card>

    <div class="mt-4 flex gap-3">
        <x-button :href="route('ai-keys.edit', $key)" variant="warning">Edit</x-button>
        <x-button :href="route('ai-keys.index')" variant="secondary">Kembali</x-button>
    </div>
</x-layouts.app>
