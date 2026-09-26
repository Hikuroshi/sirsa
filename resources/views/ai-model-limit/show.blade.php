<x-layouts.app>
    <x-slot:title>Detail Model AI</x-slot:title>
    <x-page-header title="Detail Model AI" />

    <x-card class="mt-6">
        <dl class="grid gap-3 sm:grid-cols-2">
            <div>
                <dt class="font-semibold">Provider</dt>
                <dd>{{ $limit->provider }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Model</dt>
                <dd>{{ $limit->model }}</dd>
            </div>
            <div>
                <dt class="font-semibold">RPM</dt>
                <dd>{{ $limit->rpm }}</dd>
            </div>
            <div>
                <dt class="font-semibold">RPD</dt>
                <dd>{{ $limit->rpd }}</dd>
            </div>
            <div>
                <dt class="font-semibold">TPM</dt>
                <dd>{{ $limit->tpm }}</dd>
            </div>
            <div>
                <dt class="font-semibold">API key terkait</dt>
                <dd>{{ $limit->api_keys_count }}</dd>
            </div>
        </dl>
    </x-card>

    <div class="mt-4 flex gap-3">
        <x-button :href="route('ai-model-limits.edit', $limit)" variant="warning">Edit</x-button>
        <x-button :href="route('ai-model-limits.index')" variant="secondary">Kembali</x-button>
    </div>
</x-layouts.app>
