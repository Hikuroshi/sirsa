<x-layouts.app>
    <x-slot:title>Kirim Laporan</x-slot:title>
    <x-card class="mx-auto max-w-2xl">
        <h1 class="text-2xl font-semibold">Lapor ke {{ $organization->name }}</h1>
        <p class="mt-2 text-gray-600">{{ $organization->description }}</p>
        <form
            class="mt-6 grid gap-4"
            action="{{ route('public-reports.store', $organization) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            <x-form.input label="Nama Pelapor" name="reporter_name" :value="auth()->user()?->name ?? ''" required />
            <x-form.input label="Kontak (opsional)" name="reporter_contact" :value="auth()->user()?->email ?? ''" />
            <x-form.textarea class="min-h-40" label="Deskripsi" name="description" required />
            <label class="grid gap-1">
                <span>Foto (maksimal 3)</span>
                <input
                    class="rounded border p-2"
                    type="file"
                    name="photos[]"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                />
                @error('photos')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
                @error('photos.*')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </label>
            <x-button type="submit">Kirim Laporan</x-button>
        </form>
    </x-card>
</x-layouts.app>
