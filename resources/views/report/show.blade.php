<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="$title" />
    @if (! $tracking)
        @can('update', $report)
            <x-button :href="route('reports.verification', $report)">Verifikasi Laporan</x-button>
        @endcan
    @endif
    <x-card class="mt-6 grid gap-3">
        <p><strong>Kode:</strong> {{ $report->id }}</p>
        <p><strong>Pelapor:</strong> {{ $report->reporter_name }}</p>
        <p><strong>Kontak:</strong> {{ $report->reporter_contact ?? '-' }}</p>
        <p><strong>Status:</strong> <x-badge>{{ $report->status->label() }}</x-badge></p>
        <p><strong>AI:</strong> <x-badge>{{ $report->ai_status->label() }}</x-badge></p>
        <p><strong>Kategori:</strong> {{ $report->category?->name ?? '-' }}</p>
        <p><strong>Prioritas:</strong> {{ $report->priority->label() }}</p>
        <x-report-description :report="$report" />
        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
            @foreach ($report->images as $image)
                <img class="h-32 w-full rounded object-cover" src="{{ $image->url() }}" alt="Foto laporan" />
            @endforeach
        </div>
    </x-card>
    <x-card class="mt-4">
        <h2 class="font-semibold">Perkembangan</h2>
        <div class="mt-3 grid gap-3">
            @foreach ($report->statusHistories as $history)
                <div class="border-l-2 pl-3">
                    <p>{{ $history->to_status->label() }} · {{ $history->created_at->format('d M Y H:i') }}</p>
                    @if ($history->note)
                        <p class="text-sm text-gray-600">{{ $history->note }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </x-card>
</x-layouts.app>
