<dialog id="complaint_modal" class="modal modal-bottom sm:modal-middle" aria-labelledby="complaint-heading">
    <div class="modal-box max-w-xl p-6">
        <div class="mb-4 flex items-center justify-between border-b border-base-200 pb-3">
            <h2 id="complaint-heading" class="text-base font-bold">Formulir Pengaduan Warga</h2>
            <form method="dialog">
                <button class="btn btn-circle btn-ghost btn-sm" aria-label="Tutup formulir">✕</button>
            </form>
        </div>

        <ul class="steps mb-5 w-full text-xs" aria-label="Langkah pengiriman laporan">
            <li id="mstep-1" class="step step-primary">Isi Keluhan</li>
            <li id="mstep-2" class="step">Lokasi & Foto</li>
            <li id="mstep-3" class="step">Data Pelapor</li>
        </ul>

        @if ($errors->any() && old('report_form') === 'home')
            <x-alert type="error" class="mb-4">
                <ul class="list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form
            id="complaint-form"
            action="{{ route('public-reports.store') }}"
            method="POST"
            enctype="multipart/form-data"
            onsubmit="return validateComplaint();"
            novalidate
        >
            @csrf
            <input type="hidden" name="report_form" value="home" />
            @include ('pages.home.modal-step1')
            @include ('pages.home.modal-step2-3')
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>Tutup</button>
    </form>
</dialog>
