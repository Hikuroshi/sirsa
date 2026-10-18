{{-- Modal Dialog daisyUI 5: Form Pengaduan 3 Langkah --}}
<dialog id="complaint_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box max-w-xl p-6">
        <div class="flex items-center justify-between border-b border-base-200 pb-3 mb-4">
            <h3 class="font-bold text-base text-base-content">Formulir Pengaduan Warga</h3>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
            </form>
        </div>

        {{-- Stepper Progress di Modal --}}
        <ul class="steps w-full text-xs mb-5">
            <li id="mstep-1" class="step step-primary">Isi Keluhan</li>
            <li id="mstep-2" class="step">Lokasi & Foto</li>
            <li id="mstep-3" class="step">Data Pelapor</li>
        </ul>

        <form id="complaint-form" onsubmit="event.preventDefault(); submitComplaint();">
            @include('pages.home.modal-step1')
            @include('pages.home.modal-step2-3')
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>


