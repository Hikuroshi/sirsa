<x-layouts.app>
    <x-slot:title>Daftar Laporan</x-slot:title>
    <x-page-header title="Daftar Laporan" />
    <div class="mt-6 overflow-x-auto rounded bg-white">
        <table class="w-full text-left">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="p-3">Pelapor</th>
                    <th class="p-3">Organisasi</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">AI</th>
                    <th class="p-3">Prioritas</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr class="border-b">
                        <td class="p-3">{{ $report->reporter_name }}</td>
                        <td class="p-3">{{ $report->organization->name }}</td>
                        <td class="p-3"><x-badge>{{ $report->status->label() }}</x-badge></td>
                        <td class="p-3"><x-badge>{{ $report->ai_status->label() }}</x-badge></td>
                        <td class="p-3"><x-badge>{{ $report->priority->label() }}</x-badge></td>
                        <td class="p-3">
                            <x-button :href="route('reports.show', $report)" variant="link">Detail</x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3 text-center text-gray-500" colspan="6">Belum ada laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $reports->links() }}</div>
</x-layouts.app>
