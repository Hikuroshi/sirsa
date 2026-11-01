<div id="step-pane-2" class="hidden space-y-4">
    <x-form.input
        label="Dusun / lingkungan"
        name="hamlet"
        id="modal-dusun"
        aria-label="Dusun atau lingkungan"
        placeholder="Nama dusun atau lingkungan Anda"
        maxlength="100"
        required
    />
    <x-form.input
        label="Patokan / alamat kejadian"
        name="location"
        id="modal-location"
        aria-label="Patokan atau alamat kejadian"
        placeholder="Contoh: Depan pos RT 02 RW 01"
        maxlength="500"
        required
    />

    <fieldset class="fieldset">
        <label for="modal-file" class="fieldset-legend">Foto bukti (opsional)</label>
        <input
            id="modal-file"
            name="photos[]"
            type="file"
            accept="image/jpeg,image/png,image/webp"
            multiple
            class="file-input file-input-sm w-full"
        />
        <p class="text-xs text-base-content/60">Maksimal 3 foto JPEG, PNG, atau WebP. Masing-masing maksimal 4 MB.</p>
        @error ('photos')
            <p class="text-xs text-error">{{ $message }}</p>
        @enderror
        @error ('photos.*')
            <p class="text-xs text-error">{{ $message }}</p>
        @enderror
    </fieldset>

    <div class="modal-action mt-6 justify-between">
        <button type="button" onclick="goToStep(1)" class="btn btn-outline btn-sm">← Kembali</button>
        <button type="button" onclick="nextComplaintStep(3)" class="btn btn-primary btn-sm">
            Lanjut: Data Pelapor →
        </button>
    </div>
</div>

<div id="step-pane-3" class="hidden space-y-4">
    <label class="flex cursor-pointer items-center justify-between gap-4 rounded-box bg-base-200 p-3" for="modal-anon">
        <span>
            <span class="block text-sm font-semibold">Lapor sebagai anonim</span>
            <span class="text-xs text-base-content/60">Nama dan kontak tidak dicantumkan pada laporan.</span>
        </span>
        <input type="hidden" name="anonymous" value="0" />
        <input
            id="modal-anon"
            name="anonymous"
            value="1"
            type="checkbox"
            class="toggle toggle-sm"
            @checked (old('anonymous'))
            onchange="toggleAnonMode(this.checked)"
        />
    </label>

    <div id="identitas-fields" class="space-y-4">
        <x-form.input
            label="Nama pelapor"
            name="reporter_name"
            id="modal-name"
            aria-label="Nama pelapor"
            :value="auth()->user()?->name ?? ''"
            maxlength="255"
            required
        />
        <x-form.input
            label="Kontak (WhatsApp / email, opsional)"
            name="reporter_contact"
            id="modal-phone"
            aria-label="Kontak pelapor"
            :value="auth()->user()?->email ?? ''"
            maxlength="255"
        />
    </div>

    <div class="modal-action mt-6 justify-between">
        <button type="button" onclick="goToStep(2)" class="btn btn-outline btn-sm">← Kembali</button>
        <button type="submit" class="btn btn-primary btn-sm">Kirim Laporan</button>
    </div>
</div>
