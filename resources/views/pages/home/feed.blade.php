{{-- Feed Aduan Terkini --}}
<section class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div>
            <h2 class="text-lg font-bold text-base-content">Aspirasi & Aduan Terkini</h2>
            <p class="text-xs text-base-content/70">Daftar laporan warga yang dibuka untuk transparansi bersama</p>
        </div>
        
        <div role="tablist" class="tabs tabs-box tabs-xs">
            <button type="button" role="tab" onclick="filterReports('all', this)" class="tab tab-active">Semua</button>
            <button type="button" role="tab" onclick="filterReports('diproses', this)" class="tab">Diproses</button>
            <button type="button" role="tab" onclick="filterReports('selesai', this)" class="tab">Selesai</button>
        </div>
    </div>

    <div id="reports-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $sampleReports = [
                [
                    'id' => 1,
                    'ticket' => 'PKH-20261018-0842',
                    'title' => 'Lampu PJU Padam Depan RT 03 RW 01',
                    'desc' => 'Sudah 4 hari lampu padam. Daerah rawan saat malam warga pulang musholla.',
                    'category' => 'Lampu Jalan',
                    'status' => 'diproses',
                    'status_label' => 'Diproses',
                    'badge_class' => 'badge-warning',
                    'reporter' => 'Slamet R.',
                    'upvotes' => 12,
                ],
                [
                    'id' => 2,
                    'ticket' => 'PKH-20261017-0421',
                    'title' => 'Gorong-gorong Mampet di Jalan Krajan Bawah',
                    'desc' => 'Tersumbat sampah dedaunan dan lumpur sehingga air meluap ke badan jalan.',
                    'category' => 'Jalan & Gorong',
                    'status' => 'selesai',
                    'status_label' => 'Selesai',
                    'badge_class' => 'badge-success',
                    'reporter' => 'Anonim',
                    'upvotes' => 24,
                ],
                [
                    'id' => 3,
                    'ticket' => 'PKH-20261016-0119',
                    'title' => 'Permohonan Pengurukan Jalan Tani Dusun Krajan',
                    'desc' => 'Akses sepeda motor pengangkut gabah becek, mohon bantuan batu sirtu.',
                    'category' => 'Irigasi Sawah',
                    'status' => 'diproses',
                    'status_label' => 'Diproses',
                    'badge_class' => 'badge-warning',
                    'reporter' => 'Poktan Makmur',
                    'upvotes' => 19,
                ],
            ];
        @endphp

        @foreach ($sampleReports as $rep)
            <div class="card bg-base-100 border border-base-300 shadow-xs report-card" data-status="{{ $rep['status'] }}">
                <div class="card-body p-4 justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="badge {{ $rep['badge_class'] }} badge-sm font-semibold">{{ $rep['status_label'] }}</span>
                            <span class="font-mono text-[10px] text-base-content/50">{{ $rep['ticket'] }}</span>
                        </div>
                        <h3 class="font-bold text-sm text-base-content leading-snug mb-1">
                            {{ $rep['title'] }}
                        </h3>
                        <p class="text-xs text-base-content/70 line-clamp-3 mb-3">
                            {{ $rep['desc'] }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-base-200 flex items-center justify-between text-xs text-base-content/60">
                        <div class="flex items-center gap-1.5 truncate">
                            <span class="badge badge-neutral badge-outline badge-xs">{{ $rep['category'] }}</span>
                            <span class="truncate">{{ $rep['reporter'] }}</span>
                        </div>
                        <button
                            type="button"
                            onclick="toggleUpvote(this, {{ $rep['upvotes'] }})"
                            class="btn btn-ghost btn-xs gap-1 hover:text-primary"
                        >
                            <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                            <span class="upvote-count font-bold">{{ $rep['upvotes'] }}</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Banner Darurat --}}
<section class="card bg-error/10 border border-error/30 mb-12">
    <div class="card-body p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <span class="text-2xl">🚨</span>
            <div>
                <h3 class="font-bold text-sm text-error">Keadaan Darurat / Bencana Desa?</h3>
                <p class="text-xs text-base-content/70 mt-0.5">Untuk pohon tumbang, tanggul jebol, atau musibah segera kontak posko.</p>
            </div>
        </div>
        <a href="https://wa.me/6281234567890?text=Halo%20Posko%20Desa%20Pangkah,%20ada%20kondisi%20darurat:" target="_blank" class="btn btn-error btn-sm shrink-0">
            Hubungi Posko Siaga (WA)
        </a>
    </div>
</section>


