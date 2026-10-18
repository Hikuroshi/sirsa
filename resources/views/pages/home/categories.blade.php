{{-- Kategori Cepat --}}
<section class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-bold text-base-content">Kategori Pelaporan</h2>
            <p class="text-xs text-base-content/70">Pilih kategori untuk mempermudah alur penanganan</p>
        </div>
        <button type="button" onclick="complaint_modal.showModal()" class="text-xs link link-primary">Semua Kategori</button>
    </div>

    <div class="flex flex-wrap gap-3">
        @foreach ($categories as $item)
            <button
                type="button"
                onclick="selectCategoryAndOpen('{{ $item['name'] }}')"
                class="card bg-base-100 border border-base-300 hover:border-primary transition-all text-left p-3 cursor-pointer group"
            >
                <div class="font-bold text-sm text-base-content">{{ $item['name'] }}</div>
            </button>
        @endforeach
    </div>
</section>


