<div id="step-pane-1" class="space-y-4">
    <x-form.select
        label="Kategori laporan (opsional)"
        name="category_id"
        id="modal-category"
        aria-label="Kategori laporan"
    >
        <option value="">Tentukan otomatis atau ditinjau petugas</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected (old('category_id') === $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </x-form.select>

    <x-form.input
        label="Judul ringkas aduan"
        name="title"
        id="modal-title"
        aria-label="Judul ringkas aduan"
        placeholder="Contoh: Jalan berlubang di depan pos ronda"
        maxlength="255"
        required
    />
    <x-form.textarea
        label="Uraian masalah"
        name="description"
        id="modal-desc"
        aria-label="Uraian masalah"
        class="min-h-24"
        placeholder="Jelaskan kondisi dan dampaknya, minimal 20 karakter."
        minlength="20"
        maxlength="10000"
        required
    />

    <div class="modal-action mt-6">
        <button type="button" onclick="nextComplaintStep(2)" class="btn btn-primary btn-sm">
            Lanjut: Lokasi & Foto →
        </button>
    </div>
</div>
