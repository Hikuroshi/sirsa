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


