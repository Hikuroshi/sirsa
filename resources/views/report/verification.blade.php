<x-layouts.app>
    <x-slot:title>Verifikasi Laporan</x-slot:title>
    <x-page-header title="Verifikasi Laporan" />
    <x-button :href="route('reports.show', $report)" variant="link">Kembali ke detail</x-button>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-card class="grid gap-3">
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
                    @foreach ($categories as $category)
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
    </div>
</x-layouts.app>
