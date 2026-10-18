<div class="card bg-base-100 border border-base-300 shadow-xs">
    <div class="card-body p-6 space-y-4">
        <h2 class="card-title text-base text-base-content">Informasi Aduan</h2>

        <div class="bg-base-200/50 p-4 rounded-lg text-sm text-base-content">
            <x-report-description :report="$report" />
        </div>

        @if ($report->images->isNotEmpty())
            <div>
                <div class="text-xs font-semibold text-base-content/70 mb-2">Foto Lampiran:</div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($report->images as $image)
                        <a href="{{ $image->url() }}" target="_blank" class="block group overflow-hidden rounded-lg border border-base-300 aspect-video bg-base-200">
                            <img class="h-full w-full object-cover group-hover:scale-105 transition-transform" src="{{ $image->url() }}" alt="Foto laporan" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<div class="card bg-base-100 border border-base-300 shadow-xs">
    <div class="card-body p-6">
        <h2 class="card-title text-base text-base-content mb-4">Riwayat Penanganan</h2>

        @if ($report->statusHistories->isNotEmpty())
            <ul class="timeline timeline-vertical timeline-compact">
                @foreach ($report->statusHistories as $history)
                    <li>
                        <hr />

                        <div class="timeline-middle text-primary">
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="timeline-end timeline-box bg-base-200/60 border-base-300 mb-4 p-3 text-xs w-full">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-bold text-sm text-base-content">{{ $history->to_status->label() }}</span>
                                <span class="text-base-content/50 font-mono">{{ $history->created_at->format('d M Y H:i') }}</span>
                            </div>
                            @if ($history->note)
                                <p class="mt-1 text-base-content/80">{{ $history->note }}</p>
                            @endif
                        </div>
                        <hr />
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-xs text-base-content/60">Belum ada catatan riwayat penanganan.</p>
        @endif
    </div>
</div>


