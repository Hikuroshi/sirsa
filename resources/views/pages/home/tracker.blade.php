{{-- Tracker Section --}}
<section id="tracking-section" class="card bg-base-100 border border-base-300 mb-8">
    <div class="card-body p-5">
        <h2 class="card-title text-base text-base-content flex items-center gap-2">
            <svg class="size-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Lacak Progres Laporan Anda
        </h2>
        <p class="text-xs text-base-content/70 -mt-1">Ketik nomor tiket laporan atau NIK pelapor untuk memantau status terkini.</p>

        <form onsubmit="event.preventDefault(); trackReport();" class="mt-3 flex flex-col sm:flex-row gap-2">
            <div class="join flex-1">
                <span class="join-item btn btn-sm no-animation bg-base-200 border-base-300 text-xs">TIKET</span>
                <input
                    id="tracking-input"
                    type="text"
                    placeholder="Contoh: PKH-20261018-0842"
                    value="PKH-20261018-0842"
                    class="input input-sm join-item w-full font-mono text-xs focus:outline-hidden"
                />
            </div>
            <button type="submit" class="btn btn-sm btn-primary">
                Periksa Status
            </button>
        </form>

        <div id="tracking-result" class="mt-6 pt-5 border-t border-base-200">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-4 bg-base-200/50 p-3 rounded-lg">
                <div>
                    <div class="text-xs text-base-content/60">Nomor Registrasi:</div>
                    <div id="res-ticket" class="font-mono font-bold text-sm text-base-content">PKH-20261018-0842</div>
                </div>
                <div>
                    <div class="text-xs text-base-content/60">Topik Pengaduan:</div>
                    <div id="res-title" class="font-medium text-sm text-base-content">Lampu PJU Padam Depan RT 03 RW 01</div>
                </div>
                <div>
                    <span id="res-status-badge" class="badge badge-warning">Sedang Ditangani</span>
                </div>
            </div>

            <ul id="tracker-steps" class="steps steps-vertical lg:steps-horizontal w-full text-xs">
                <li class="step step-primary" data-content="✓">Terkirim</li>
                <li class="step step-primary" data-content="✓">Verifikasi Desa</li>
                <li class="step step-primary">Tindakan Lapangan</li>
                <li class="step">Selesai & Laporan</li>
            </ul>

            <div id="tracker-note-box" class="alert alert-info alert-soft mt-5 text-xs py-2">
                <svg class="size-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span id="tracker-note-text"><strong>Catatan Petugas (Kaur Kesra):</strong> Komponen lampu LED pengganti sudah diambil dari logistik kecamatan. Pemasangan sore ini jam 15:30 WIB.</span>
            </div>
        </div>
    </div>
</section>


