<x-layouts.app>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
        <div>
            <p class="text-sm text-base-content/60">Dashboard · {{ config('app.name') }}</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">Halo, {{ auth()->user()->name }}.</h1>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-base-content/65">{{ auth()->user()->isAdmin() ? 'Pantau laporan warga dan kelola layanan pengaduan desa dari satu tempat.' : 'Sampaikan aspirasi Anda dan pantau perkembangan laporan yang sudah dikirim.' }}</p>
        </div>
        <x-button :href="route('public-reports.create')" class="btn-sm">
            <svg aria-hidden="true" class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Buat Laporan
        </x-button>
    </div>

    <div class="stats stats-vertical mt-8 w-full border border-base-300 bg-base-100 shadow-xs sm:stats-horizontal">
        <div class="stat min-w-0 gap-1">
            <div class="stat-title">{{ auth()->user()->isAdmin() ? 'Total laporan' : 'Laporan saya' }}</div>
            <div class="stat-value mt-1 text-4xl">{{ number_format($reportCount, 0, ',', '.') }}</div>
            <div class="stat-desc mt-1 whitespace-normal">
                {{ auth()->user()->isAdmin() ? 'Seluruh laporan yang tercatat di sistem' : 'Laporan yang terhubung dengan akun Anda' }}
            </div>
            <div class="stat-actions">
                <a href="{{ route('reports.index') }}" class="btn btn-ghost btn-sm">Lihat laporan →</a>
            </div>
        </div>
        @if ($userCount !== null)
            <div class="stat min-w-0 gap-1">
                <div class="stat-title">Total pengguna</div>
                <div class="stat-value mt-1 text-4xl">{{ number_format($userCount, 0, ',', '.') }}</div>
                <div class="stat-desc mt-1 whitespace-normal">Akun admin dan pelapor terdaftar</div>
                <div class="stat-actions">
                    <a href="{{ route('user.index') }}" class="btn btn-ghost btn-sm">Kelola pengguna →</a>
                </div>
            </div>
        @endif
    </div>

    <section
        class="mt-8 grid gap-4 lg:grid-cols-3"
        data-dashboard-charts
        data-chart-data="{{ \Illuminate\Support\Js::encode($chartData) }}"
        aria-label="Statistik laporan"
    >
        <x-card class="min-w-0 lg:col-span-2">
            <h2 id="report-trend-heading" class="card-title text-base">Tren laporan masuk</h2>
            <p class="text-sm text-base-content/60">Jumlah laporan per bulan selama enam bulan terakhir.</p>
            <div class="relative mt-4 h-64 sm:h-72">
                <canvas
                    data-report-trend
                    role="img"
                    aria-labelledby="report-trend-heading"
                    aria-describedby="report-trend-data"
                ></canvas>
            </div>
            <dl id="report-trend-data" class="sr-only">
                @foreach ($chartData['trend']['labels'] as $index => $month)
                    <dt>{{ $month }}</dt>
                    <dd>{{ $chartData['trend']['values'][$index] }} laporan</dd>
                @endforeach
            </dl>
        </x-card>

        <x-card class="min-w-0">
            <h2 id="report-status-heading" class="card-title text-base">Komposisi status</h2>
            <p class="text-sm text-base-content/60">{{ auth()->user()->isAdmin() ? 'Status terkini seluruh laporan warga.' : 'Status terkini dari seluruh laporan Anda.' }}</p>
            @if ($reportCount > 0)
                <div class="relative mt-2 h-52">
                    <canvas
                        data-report-status
                        role="img"
                        aria-labelledby="report-status-heading"
                        aria-describedby="report-status-data"
                    ></canvas>
                </div>
            @else
                <div
                    class="flex h-52 items-center justify-center rounded-box bg-base-200/50 p-6 text-center text-sm text-base-content/60"
                >
                    Belum ada laporan untuk ditampilkan.
                </div>
            @endif
            <dl id="report-status-data" class="mt-2 grid gap-3 text-sm">
                @foreach ($chartData['statuses'] as $status)
                    <div class="flex items-center justify-between gap-3">
                        <dt class="flex items-center gap-2">
                            <span
                                data-status-color
                                aria-hidden="true"
                                @class ([
                                'size-2.5 shrink-0 rounded-full',
                                'bg-info' => $status['value'] === 'accepted',
                                'bg-warning' => $status['value'] === 'processing',
                                'bg-success' => $status['value'] === 'completed',
                                'bg-error' => $status['value'] === 'rejected',
                            ])
                            ></span>
                            {{ $status['label'] }}
                        </dt>
                        <dd class="font-semibold tabular-nums">{{ number_format($status['count'], 0, ',', '.') }}</dd>
                    </div>
                @endforeach
            </dl>
        </x-card>
    </section>

    <section class="mt-8" aria-labelledby="quick-access-heading">
        <h2 id="quick-access-heading" class="text-lg font-bold">Akses cepat</h2>
        <p class="mt-1 text-sm text-base-content/60">Langsung menuju aktivitas yang Anda butuhkan.</p>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <x-card>
                <div class="mb-2 flex size-11 items-center justify-center rounded-2xl bg-base-200" aria-hidden="true">
                    <svg class="size-6 text-base-content/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="card-title text-base">
                    {{ auth()->user()->isAdmin() ? 'Kelola laporan warga' : 'Pantau laporan saya' }}
                </h3>
                <p class="text-sm leading-relaxed text-base-content/60">{{ auth()->user()->isAdmin() ? 'Tinjau laporan masuk, verifikasi informasi, dan perbarui status penanganan.' : 'Lihat status terbaru dan riwayat penanganan laporan yang Anda kirim.' }}</p>
                <div class="card-actions mt-3">
                    <a href="{{ route('reports.index') }}" class="btn btn-outline btn-sm">Buka Laporan →</a>
                </div>
            </x-card>
            @can ('viewAny', App\Models\Category::class)
                <x-card>
                    <div
                        class="mb-2 flex size-11 items-center justify-center rounded-2xl bg-base-200"
                        aria-hidden="true"
                    >
                        <svg class="size-6 text-base-content/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M3 5v6a2 2 0 00.586 1.414l8 8a2 2 0 002.828 0l6-6a2 2 0 000-2.828l-8-8A2 2 0 0011 3H5a2 2 0 00-2 2z" /></svg>
                    </div>
                    <h3 class="card-title text-base">Kategori pengaduan</h3>
                    <p class="text-sm leading-relaxed text-base-content/60">Atur kategori agar laporan warga lebih mudah dikelompokkan dan ditangani.</p>
                    <div class="card-actions mt-3">
                        <a href="{{ route('categories.index') }}" class="btn btn-outline btn-sm">Kelola Kategori →</a>
                    </div>
                </x-card>
            @else
                <x-card>
                    <h3 class="card-title text-base">Ada kendala di sekitar Anda?</h3>
                    <p class="text-sm leading-relaxed text-base-content/60">Ceritakan kejadian dan lokasinya dengan jelas. Sertakan foto bila ada agar petugas lebih mudah meninjau laporan.</p>
                    <div class="card-actions mt-3">
                        <a href="{{ route('public-reports.create') }}" class="btn btn-outline btn-sm">
                            Tulis Laporan →
                        </a>
                    </div>
                </x-card>
            @endcan
        </div>
    </section>
</x-layouts.app>
