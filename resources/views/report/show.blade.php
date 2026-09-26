<x-layouts.app>
    <x-slot:title>Detail Laporan</x-slot:title>
    <x-page-header title="Detail Laporan" />
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-card class="grid gap-3">
            <p><strong>Pelapor:</strong> {{ $report->reporter_name }}</p>
            <p><strong>Kontak:</strong> {{ $report->reporter_contact ?? '-' }}</p>
            <p><strong>Status:</strong> <x-badge>{{ $report->status->label() }}</x-badge></p>
            <p><strong>AI:</strong> <x-badge>{{ $report->ai_status->label() }}</x-badge></p>
            <div>
                <strong>Deskripsi asli:</strong>
                <p class="whitespace-pre-line">{{ $report->original_description }}</p>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @foreach ($report->images as $image)
                    <img class="h-32 w-full rounded object-cover" src="{{ $image->url() }}" alt="Foto laporan" />
                @endforeach
            </div>
            @if ($report->aiResult)
                <div class="rounded bg-blue-50 p-3 text-sm">
                    <strong>Saran AI:</strong>
                    <p>{{ $report->aiResult->refined_description }}</p>
                    <p>
                        Kategori: {{ $report->aiResult->category?->name ?? '-' }} · Prioritas: {{ $report->aiResult->priority->label() }}
                    </p>
                </div>
            @endif
        </x-card>

        @can('update', $report)
            <x-card>
                <form class="grid gap-4" action="{{ route('reports.update', $report) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-form.textarea
                        class="min-h-40"
                        label="Deskripsi final"
                        name="description"
                        :value="$report->description"
                    />
                    <x-form.select label="Kategori" name="category_id">
                        <option value="">Tanpa kategori</option>
                        @foreach ($report->organization->categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id', $report->category_id) === $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-form.select>
                    <x-form.select label="Prioritas" name="priority">
                        @foreach ($priorities as $priority)
                            <option
                                value="{{ $priority->value }}"
                                @selected(old('priority', $report->priority->value) === $priority->value)
                            >
                                {{ $priority->label() }}
                            </option>
                        @endforeach
                    </x-form.select>
                    <x-form.select label="Status" name="status">
                        @foreach ($statuses as $status)
                            <option
                                value="{{ $status->value }}"
                                @selected(old('status', $report->status->value) === $status->value)
                            >
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </x-form.select>
                    <x-form.textarea label="Catatan publik" name="note" />
                    <x-button type="submit">Verifikasi / Simpan</x-button>
                </form>
            </x-card>
        @endcan
    </div>
</x-layouts.app>
