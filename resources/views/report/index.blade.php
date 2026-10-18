<x-layouts.app>
    <x-slot:title>Daftar Laporan</x-slot:title>
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Daftar Laporan</h1>
            <p class="text-xs text-base-content/70 mt-1">Daftar aduan dan aspirasi warga desa yang tercatat di sistem.</p>
        </div>
        <a href="{{ route('public-reports.create') }}" class="btn btn-primary btn-sm">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan
        </a>
    </div>

    <x-search placeholder="Cari ID, pelapor, kontak, atau deskripsi..." />

    <div class="card bg-base-100 border border-base-300 shadow-xs mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm">
                <thead class="bg-base-200/60 text-xs font-semibold text-base-content/80">
                    <tr>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>AI Analisis</th>
                        <th>Prioritas</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
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
                        <tr class="hover">
                            <td>
                                <div class="font-bold text-sm text-base-content">{{ $report->reporter_name }}</div>
                                <div class="font-mono text-[11px] text-base-content/60">#{{ $report->id }}</div>
                            </td>
                            <td>
                                <span class="badge badge-neutral badge-outline badge-xs">
                                    {{ $report->category?->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td>
                                <x-badge :variant="$statusVariant">{{ $report->status->label() }}</x-badge>
                            </td>
                            <td>
                                <x-badge :variant="$aiVariant">{{ $report->ai_status->label() }}</x-badge>
                            </td>
                            <td>
                                <x-badge :variant="$priorityVariant">{{ $report->priority->label() }}</x-badge>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('reports.show', $report) }}" class="btn btn-ghost btn-xs text-primary font-semibold">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-8 text-center text-base-content/60" colspan="6">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="size-8 text-base-content/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Belum ada laporan yang cocok atau tersimpan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $reports->links() }}
    </div>
</x-layouts.app>

