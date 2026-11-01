<section class="mb-8">
    <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-lg font-bold">Aspirasi & Aduan Terkini</h2>
            <p class="text-sm text-base-content/60">Enam laporan terbaru yang tercatat di sistem.</p>
        </div>
        <div role="tablist" aria-label="Filter laporan terbaru" class="tabs tabs-box flex-wrap">
            <button
                type="button"
                role="tab"
                aria-selected="true"
                data-report-filter
                onclick="filterReports('all', this)"
                class="tab tab-active"
            >
                Semua
            </button>
            @foreach ($statuses as $status)
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-report-filter
                    onclick="filterReports(@js($status->value), this)"
                    class="tab"
                >
                    {{ $status->label() }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($reports as $report)
            <article
                class="report-card card border border-base-300 bg-base-100 shadow-xs"
                data-status="{{ $report->status->value }}"
            >
                <div class="card-body gap-3 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <span class="badge badge-outline badge-sm">{{ $report->status->label() }}</span>
                        <time
                            class="text-xs text-base-content/60"
                            datetime="{{ $report->created_at->toIso8601String() }}"
                        >
                            {{ $report->created_at->translatedFormat('d M Y') }}
                        </time>
                    </div>
                    <h3 class="card-title text-base">{{ $report->category?->name ?? 'Laporan warga' }}</h3>
                    <p class="text-sm leading-relaxed text-base-content/70">{{ Str::limit($report->description, 180) }}</p>
                    <div class="card-actions mt-2 items-center justify-between border-t border-base-200 pt-3">
                        <span class="text-xs text-base-content/60">{{ $report->reporter_name }}</span>
                        <a href="{{ route('reports.track', $report) }}" class="btn btn-ghost btn-sm">Lihat Laporan →</a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
    <p id="filtered-reports-empty" class="rounded-box border border-base-300 p-8 text-center text-sm text-base-content/60" @if ($reports->isNotEmpty()) hidden @endif>Belum ada laporan yang sesuai.</p>
</section>
