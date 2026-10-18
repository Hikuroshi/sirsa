{{-- STEP 1 --}}
<div id="step-pane-1" class="space-y-4">
    <fieldset class="fieldset">
        <label class="fieldset-label text-xs font-semibold">Kategori Laporan</label>
        <select id="modal-category" class="select select-sm w-full" required>
            <option value="" disabled selected>Pilih Kategori</option>
            <option value="Jalan & Gorong">Jalan & Gorong-gorong</option>
            <option value="Lampu Jalan">Lampu Penerangan Jalan (PJU)</option>
            <option value="Sampah & Lingkungan">Sampah & Kebersihan Lingkungan</option>
            <option value="Irigasi Sawah">Irigasi Pertanian & Saluran Air</option>
            <option value="Surat Pengantar">Layanan Administrasi Surat</option>
            <option value="Bantuan Sosial">Bantuan Sosial & Kemasyarakatan</option>
            <option value="Lainnya">Lainnya / Aspirasi</option>
        </select>
    </fieldset>

    <fieldset class="fieldset">
        <label class="fieldset-label text-xs font-semibold">Judul Ringkas Aduan</label>
        <input id="modal-title" type="text" placeholder="Contoh: Aspal amblas depan pos RW 02" class="input input-sm w-full" required />
    </fieldset>

    <fieldset class="fieldset">
        <label class="fieldset-label text-xs font-semibold">Uraian Masalah</label>
        <textarea id="modal-desc" class="textarea textarea-sm w-full h-24" placeholder="Jelaskan kendala secara rinci..." required></textarea>
    </fieldset>

    <div class="modal-action mt-6">
        <button type="button" onclick="goToStep(2)" class="btn btn-sm btn-primary">Lanjut: Lokasi & Foto →</button>
    </div>
</div>


