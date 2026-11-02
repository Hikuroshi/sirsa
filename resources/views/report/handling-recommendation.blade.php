@can('update', $report)
    <x-card>
        <h2 class="card-title text-base">Rekomendasi Penanganan</h2>
        @if ($report->aiResult?->handling_recommendation !== null)
            <p class="text-sm leading-relaxed wrap-anywhere whitespace-pre-line">
                {{ $report->aiResult->handling_recommendation }}
            </p>
        @else
            <p class="text-base-content/60 text-sm">Rekomendasi penanganan belum tersedia.</p>
        @endif
    </x-card>
@endcan
