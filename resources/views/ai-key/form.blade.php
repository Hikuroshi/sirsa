<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="$title" />

    <x-card class="mt-6">
        <form
            class="grid gap-4"
            action="{{ isset($key) ? route('ai-keys.update', $key) : route('ai-keys.store') }}"
            method="POST"
        >
            @csrf
            @isset($key)
                @method('PUT')
            @endisset

            <x-form.input label="Nama" name="name" :value="$key->name ?? ''" />
            <x-form.select label="Provider / Model" name="ai_model_limit_id">
                @foreach ($modelLimits as $limit)
                    <option
                        value="{{ $limit->id }}"
                        @selected(old('ai_model_limit_id', $key->ai_model_limit_id ?? '') === $limit->id)
                    >
                        {{ $limit->provider }} / {{ $limit->model }}
                    </option>
                @endforeach
            </x-form.select>
            <x-form.input
                :label="isset($key) ? 'API Key baru (saat ini ••••'.$key->suffix.')' : 'API Key'"
                name="secret"
                type="password"
            />
            <x-form.checkbox label="Aktif" name="is_active" :checked="$key->is_active ?? true" />

            <details>
                <summary class="cursor-pointer">Pengaturan lanjutan</summary>
                <div class="mt-3 grid gap-3 sm:grid-cols-4">
                    <x-form.input label="Prioritas" name="priority" type="number" :value="$key->priority ?? 100" />
                    <x-form.input label="RPM" name="rpm" type="number" :value="$key->rpm ?? ''" />
                    <x-form.input label="RPD" name="rpd" type="number" :value="$key->rpd ?? ''" />
                    <x-form.input label="TPM" name="tpm" type="number" :value="$key->tpm ?? ''" />
                </div>
                <p class="mt-2 text-sm text-gray-500">Kosongkan limit untuk mengikuti konfigurasi model.</p>
            </details>

            <div class="flex gap-3">
                <x-button type="submit">Simpan</x-button>
                <x-button :href="route('ai-keys.index')" variant="secondary">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
