{{-- STEP 2 --}}
<div id="step-pane-2" class="space-y-4 hidden">
    <fieldset class="fieldset">
        <label class="fieldset-label text-xs font-semibold">Dusun / Lingkungan</label>
        <select id="modal-dusun" class="select select-sm w-full" required>
            <option value="" disabled selected>Pilih Dusun</option>
            <option value="Krajan">Dusun Krajan</option>
            <option value="Pangkah Barat">Dusun Pangkah Barat</option>
            <option value="Pangkah Timur">Dusun Pangkah Timur</option>
            <option value="Kebonsari">Dusun Kebonsari</option>
        </select>
    </fieldset>

    <fieldset class="fieldset">
        <label class="fieldset-label text-xs font-semibold">Patokan / Alamat Lengkap</label>
        <input id="modal-location" type="text" placeholder="Contoh: Depan rumah RT 02 / samping musholla" class="input input-sm w-full" required />
    </fieldset>

    <fieldset class="fieldset">
        <label class="fieldset-label text-xs font-semibold">Foto Bukti (Opsional)</label>
        <input id="modal-file" type="file" accept="image/*" class="file-input file-input-sm w-full" />
        <label class="fieldset-label text-[11px] text-base-content/60">Format foto jpg/png maks 5MB</label>
    </fieldset>

    <div class="modal-action justify-between mt-6">
        <button type="button" onclick="goToStep(1)" class="btn btn-sm btn-outline">← Kembali</button>
        <button type="button" onclick="goToStep(3)" class="btn btn-sm btn-primary">Lanjut: Data Pelapor →</button>
    </div>
</div>

{{-- STEP 3 --}}
<div id="step-pane-3" class="space-y-4 hidden">
    <div class="flex items-center justify-between p-3 rounded-lg bg-base-200">
        <div>
            <div class="font-bold text-xs">Lapor Sebagai Anonim?</div>
            <div class="text-[11px] text-base-content/60">Identitas disembunyikan dari publik</div>
        </div>
        <input id="modal-anon" type="checkbox" class="toggle toggle-primary toggle-sm" onchange="toggleAnonMode(this.checked)" />
    </div>

    <div id="identitas-fields" class="space-y-4">
        <fieldset class="fieldset">
            <label class="fieldset-label text-xs font-semibold">Nama Lengkap (Sesuai KTP)</label>
            <input id="modal-name" type="text" placeholder="Nama Warga" class="input input-sm w-full" />
        </fieldset>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <fieldset class="fieldset">
                <label class="fieldset-label text-xs font-semibold">NIK (16 Digit)</label>
                <input id="modal-nik" type="text" maxlength="16" placeholder="3524..." class="input input-sm w-full font-mono" />
            </fieldset>
            <fieldset class="fieldset">
                <label class="fieldset-label text-xs font-semibold">Nomor WhatsApp Aktif</label>
                <input id="modal-phone" type="tel" placeholder="08..." class="input input-sm w-full font-mono" />
            </fieldset>
        </div>
    </div>

    <div class="modal-action justify-between mt-6">
        <button type="button" onclick="goToStep(2)" class="btn btn-sm btn-outline">← Kembali</button>
        <button type="submit" class="btn btn-sm btn-success text-white">Kirim Laporan Resmi</button>
    </div>
</div>


