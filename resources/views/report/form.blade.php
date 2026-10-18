<x-layouts.app>
    <x-slot:title>Kirim Laporan</x-slot:title>

    <div class="mx-auto max-w-2xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-base-content">Lapor ke {{ config('app.name') }}</h1>
            <p class="text-xs text-base-content/70 mt-1">Sampaikan keluhan, aspirasi, atau aduan fasilitas lingkungan secara terbuka.</p>
        </div>

        <div class="card bg-base-100 border border-base-300 shadow-xs">
            <div class="card-body p-6">
                <form
                    class="space-y-4"
                    action="{{ route('public-reports.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <x-form.input label="Nama Pelapor" name="reporter_name" :value="auth()->user()?->name ?? ''" required />
                    <x-form.input label="Kontak (Nomor WhatsApp / Email)" name="reporter_contact" :value="auth()->user()?->email ?? ''" />
                    <x-form.textarea class="min-h-36" label="Deskripsi Pengaduan" name="description" placeholder="Jelaskan kendala secara lengkap dan jelas (min. 20 karakter)..." required />
                    
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Foto Bukti (Maksimal 3 foto, @4MB)</legend>
                        <input
                            class="file-input file-input-bordered file-input-sm w-full"
                            type="file"
                            name="photos[]"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                        />
                        @error('photos')
                            <p class="label text-error">{{ $message }}</p>
                        @enderror
                        @error('photos.*')
                            <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <div class="card-actions justify-end pt-3">
                        <button type="submit" class="btn btn-primary w-full sm:w-auto">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

