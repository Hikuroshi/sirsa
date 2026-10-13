@props(['report'])

<div data-report-description>
    <strong>Deskripsi:</strong>
    <p class="whitespace-pre-line" data-refined-description>{{ $report->description }}</p>

    @if ($report->aiResult && $report->description !== $report->original_description)
        <p class="whitespace-pre-line" data-original-description hidden>{{ $report->original_description }}</p>
        <button class="mt-2 text-sm text-blue-600" type="button" data-description-toggle aria-pressed="false">
            Lihat laporan asli
        </button>
    @endif
</div>
