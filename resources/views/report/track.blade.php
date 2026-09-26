<x-layouts.app>
    <x-slot:title>Pelacakan Laporan</x-slot:title>
    <x-page-header title="Pelacakan Laporan" />
    <x-card class="mt-6 grid gap-3">
        <p><strong>Kode:</strong> {{ $report->tracking_code }}</p>
        <p><strong>Organisasi:</strong> {{ $report->organization->name }}</p>
        <p><strong>Status:</strong> <x-badge>{{ $report->status->label() }}</x-badge></p>
        <p><strong>AI:</strong> <x-badge>{{ $report->ai_status->label() }}</x-badge></p>
        @if ($report->verified_at)
            <p><strong>Prioritas:</strong> {{ $report->priority->label() }}</p>
            <p><strong>Kategori:</strong> {{ $report->category?->name ?? '-' }}</p>
            <div>
                <strong>Deskripsi:</strong>
                <p class="whitespace-pre-line">{{ $report->description }}</p>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @foreach ($report->images as $image)
                    <img class="h-32 w-full rounded object-cover" src="{{ $image->url() }}" alt="Foto laporan" />
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Laporan sedang ditinjau oleh organisasi.</p>
        @endif
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
