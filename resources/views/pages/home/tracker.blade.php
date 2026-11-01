<section id="tracking-section" class="card mb-8 border border-base-300 bg-base-100">
    <div class="card-body p-5">
        <h2 class="card-title text-base">Lacak Progres Laporan Anda</h2>
        <p class="text-sm text-base-content/60">Masukkan ID laporan yang diberikan setelah pengiriman.</p>
        <form action="{{ route('reports.lookup') }}" method="GET" class="mt-3 flex flex-col gap-2 sm:flex-row">
            <label for="tracking-input" class="sr-only">ID laporan</label>
            <input
                id="tracking-input"
                name="report_id"
                type="text"
                value="{{ old('report_id') }}"
                placeholder="ID laporan (UUID)"
                class="input input-sm min-w-0 flex-1 font-mono"
                required
            />
            <button type="submit" class="btn btn-primary btn-sm">Periksa Status</button>
        </form>
        @error ('report_id')
            <p role="alert" class="text-sm text-error">{{ $message }}</p>
        @enderror
    </div>
</section>
