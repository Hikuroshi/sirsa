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


