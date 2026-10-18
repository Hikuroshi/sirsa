<div class="card bg-base-100 border border-base-300 shadow-xs">
    <div class="card-body p-6">
        <h2 class="card-title text-base text-base-content mb-2">Penyesuaian & Tindakan</h2>

        <form class="space-y-4" action="{{ route('reports.update', $report) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.textarea
                class="min-h-32 text-xs"
                label="Deskripsi Final (Disempurnakan)"
                name="description"
                :value="$report->description"
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <x-form.select label="Kategori Laporan" name="category_id">
                    <option value="">Tanpa kategori</option>
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id', $report->category_id) === $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-form.select>

                <x-form.select label="Tingkat Prioritas" name="priority">
                    @foreach ($priorities as $priority)
                        <option
                            value="{{ $priority->value }}"
                            @selected(old('priority', $report->priority->value) === $priority->value)
                        >
                            {{ $priority->label() }}
                        </option>
                    @endforeach
                </x-form.select>
            </div>

            <x-form.select label="Status Tindak Lanjut" name="status">
                @foreach ($statuses as $status)
                    <option
                        value="{{ $status->value }}"
                        @selected(old('status', $report->status->value) === $status->value)
                    >
                        {{ $status->label() }}
                    </option>
                @endforeach
            </x-form.select>

            <x-form.textarea
                class="min-h-24 text-xs"
                label="Catatan Publik untuk Warga"
                name="note"
                placeholder="Contoh: Petugas telah memeriksa dan tindak lanjut dijadwalkan besok."
            />

            <div class="card-actions justify-end pt-2">
                <button type="submit" class="btn btn-primary w-full sm:w-auto">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>


