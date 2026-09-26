<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="$title" />

    <x-card class="mt-6">
        <form
            class="grid gap-4"
            action="{{ isset($limit) ? route('ai-model-limits.update', $limit) : route('ai-model-limits.store') }}"
            method="POST"
        >
            @csrf
            @isset($limit)
                @method('PUT')
            @endisset

            <x-form.select label="Provider" name="provider">
                @foreach ($providers as $value => $label)
                    <option value="{{ $value }}" @selected(old('provider', $limit->provider ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </x-form.select>
            <x-form.input label="Nama model" name="model" :value="$limit->model ?? ''" />
            <div class="grid gap-3 sm:grid-cols-3">
                <x-form.input label="RPM" name="rpm" type="number" :value="$limit->rpm ?? ''" />
                <x-form.input label="RPD" name="rpd" type="number" :value="$limit->rpd ?? ''" />
                <x-form.input label="TPM" name="tpm" type="number" :value="$limit->tpm ?? ''" />
            </div>

            <div class="flex gap-3">
                <x-button type="submit">Simpan</x-button>
                <x-button :href="route('ai-model-limits.index')" variant="secondary">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
