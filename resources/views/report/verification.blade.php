<x-layouts.app>
    <x-slot:title>Verifikasi Laporan</x-slot:title>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.show', $report) }}" class="btn btn-ghost btn-circle btn-xs">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h1 class="text-2xl font-bold text-base-content">Verifikasi Laporan #{{ $report->id }}</h1>
            </div>
            <p class="text-xs text-base-content/70 mt-1">Tinjau deskripsi, sesuaikan kategori/prioritas, dan perbarui status.</p>
        </div>

        <a href="{{ route('reports.show', $report) }}" class="btn btn-outline btn-sm">
            Kembali ke Detail
        </a>
    </div>

    @php
        $statusVariant = match ($report->status->value) {
            'completed' => 'success',
            'processing' => 'warning',
            'rejected' => 'error',
            default => 'neutral',
        };
        $priorityVariant = match ($report->priority->value) {
            'urgent' => 'error',
            'high' => 'warning',
            'medium' => 'info',
            default => 'ghost',
        };
        $aiVariant = match ($report->ai_status->value) {
            'completed' => 'success',
            'processing', 'queued' => 'warning',
            'failed' => 'error',
            default => 'ghost',
        };
    @endphp

    <div class="grid gap-6 lg:grid-cols-2">
        @include('report.verification-preview')
        @include('report.verification-form')
    </div>
</x-layouts.app>

