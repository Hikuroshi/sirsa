<div class="card bg-base-100 border border-base-300 shadow-xs">
    <div class="card-body p-6 space-y-4">
        <h2 class="card-title text-base text-base-content">Informasi Laporan Masuk</h2>

        <div class="grid grid-cols-2 gap-3 text-xs bg-base-200/50 p-3 rounded-lg">
            <div>
                <span class="text-base-content/60 block">Pelapor:</span>
                <span class="font-bold text-base-content">{{ $report->reporter_name }}</span>
            </div>
            <div>
                <span class="text-base-content/60 block">Kontak:</span>
                <span class="font-medium text-base-content">{{ $report->reporter_contact ?? '-' }}</span>
            </div>
            <div>
                <span class="text-base-content/60 block">Status Saat Ini:</span>
                <x-badge :variant="$statusVariant">{{ $report->status->label() }}</x-badge>
            </div>
            <div>
                <span class="text-base-content/60 block">AI Analisis:</span>
                <x-badge :variant="$aiVariant">{{ $report->ai_status->label() }}</x-badge>
            </div>
        </div>

        <div class="text-xs">
            <x-report-description :report="$report" />
        </div>

        @if ($report->images->isNotEmpty())
            <div class="pt-2">
                <span class="text-xs font-semibold text-base-content/70 block mb-2">Foto Lampiran:</span>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($report->images as $image)
                        <a href="{{ $image->url() }}" target="_blank" class="block rounded border border-base-300 overflow-hidden aspect-video bg-base-200">
                            <img class="h-full w-full object-cover" src="{{ $image->url() }}" alt="Foto laporan" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>


