{{-- Hero Section --}}
<div class="hero bg-base-200 rounded-box border border-base-300 py-8 px-4 mb-8">
    <div class="hero-content text-center max-w-2xl">
        <div>
            <span class="badge badge-primary badge-outline mb-3 h-auto">Portal Resmi Pelaporan Warga Desa Pangkah</span>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-base-content">
                Sugeng Rawuh ing SIRSA Desa Pangkah
            </h1>
            <p class="py-4 text-sm sm:text-base text-base-content/80">
                Sampaikan aduan, aspirasi, atau kendala fasilitas desa langsung ke pihak pemerintah desa. Terbuka, tanggap, dan terpantau sampai tuntas.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-2">
                <button type="button" onclick="complaint_modal.showModal()" class="btn btn-primary w-full sm:w-auto">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tulis Laporan Warga
                </button>
                <a href="#tracking-section" class="btn btn-outline w-full sm:w-auto">
                    Lacak Status Aduan
                </a>
            </div>

            <div class="stats stats-vertical sm:stats-horizontal shadow-xs bg-base-100 border border-base-300 mt-6 w-full">
                <div class="stat py-3">
                    <div class="stat-title text-xs">Total Laporan</div>
                    <div class="stat-value text-2xl text-primary">{{ $totalReports ?? '128' }}</div>
                    <div class="stat-desc text-xs">Sejak awal tahun</div>
                </div>
                <div class="stat py-3">
                    <div class="stat-title text-xs">Sedang Diproses</div>
                    <div class="stat-value text-2xl text-warning">{{ $inProgressReports ?? '14' }}</div>
                    <div class="stat-desc text-xs">Penanganan teknis</div>
                </div>
                <div class="stat py-3">
                    <div class="stat-title text-xs">Terselesaikan</div>
                    <div class="stat-value text-2xl text-success">{{ $resolvedReports ?? '112' }}</div>
                    <div class="stat-desc text-xs">Tingkat selesai tinggi</div>
                </div>
            </div>
        </div>
    </div>
</div>


