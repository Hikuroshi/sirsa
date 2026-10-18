<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.index') }}" class="btn btn-ghost btn-circle btn-xs">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h1 class="text-2xl font-bold text-base-content">{{ $title }}</h1>
            </div>
            <p class="text-xs text-base-content/70 mt-1 font-mono">Kode Aduan: #{{ $report->id }}</p>
        </div>

        @if (! $tracking)
            @can('update', $report)
                <a href="{{ route('reports.verification', $report) }}" class="btn btn-warning btn-sm">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Verifikasi Laporan
                </a>
            @endcan
        @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @include('report.show-detail')
        </div>
        <div class="space-y-6">
            @include('report.show-sidebar')
        </div>
    </div>
</x-layouts.app>

