<div class="card bg-base-100 border border-base-300 shadow-xs">
    <div class="card-body p-5 space-y-3">
        <h3 class="font-bold text-sm text-base-content">Klasifikasi & Status</h3>

        <div class="divide-y divide-base-200 text-xs">
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Status:</span>
                <x-badge :variant="$statusVariant">{{ $report->status->label() }}</x-badge>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Prioritas:</span>
                <x-badge :variant="$priorityVariant">{{ $report->priority->label() }}</x-badge>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Kategori:</span>
                <span class="font-medium text-base-content">{{ $report->category?->name ?? 'Tanpa Kategori' }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Status AI:</span>
                <x-badge :variant="$aiVariant">{{ $report->ai_status->label() }}</x-badge>
            </div>
        </div>
    </div>
</div>

<div class="card bg-base-100 border border-base-300 shadow-xs">
    <div class="card-body p-5 space-y-3">
        <h3 class="font-bold text-sm text-base-content">Data Pelapor</h3>

        <div class="divide-y divide-base-200 text-xs">
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Nama:</span>
                <span class="font-bold text-base-content">{{ $report->reporter_name }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Kontak:</span>
                <span class="font-medium text-base-content">{{ $report->reporter_contact ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-base-content/60">Waktu Masuk:</span>
                <span class="font-mono text-base-content/70">{{ $report->created_at?->format('d M Y H:i') ?? '-' }}</span>
            </div>
        </div>
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
                            <div class="flex flex-wrap items-center justify-between gap-2">
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


