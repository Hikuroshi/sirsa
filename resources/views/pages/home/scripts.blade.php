<script>
    function selectCategoryAndOpen(categoryName) {
        const selectEl = document.getElementById('modal-category');
        if (selectEl) {
            for (let i = 0; i < selectEl.options.length; i++) {
                if (selectEl.options[i].text.includes(categoryName) || selectEl.options[i].value.includes(categoryName)) {
                    selectEl.selectedIndex = i;
                    break;
                }
            }
        }
        goToStep(1);
        complaint_modal.showModal();
    }

    function goToStep(stepNumber) {
        [1, 2, 3].forEach(s => {
            const pane = document.getElementById(`step-pane-${s}`);
            const stepItem = document.getElementById(`mstep-${s}`);
            if (pane) pane.classList.toggle('hidden', s !== stepNumber);
            if (stepItem) {
                if (s <= stepNumber) {
                    stepItem.classList.add('step-primary');
                } else {
                    stepItem.classList.remove('step-primary');
                }
            }
        });
    }

    function toggleAnonMode(isAnon) {
        const identitas = document.getElementById('identitas-fields');
        const nameInput = document.getElementById('modal-name');
        const nikInput = document.getElementById('modal-nik');
        if (isAnon) {
            identitas.classList.add('opacity-40', 'pointer-events-none');
            nameInput.value = 'Warga Anonim Desa Pangkah';
            nikInput.value = '3524000000000000';
        } else {
            identitas.classList.remove('opacity-40', 'pointer-events-none');
            nameInput.value = '';
            nikInput.value = '';
        }
    }

    function trackReport() {
        const val = document.getElementById('tracking-input').value.trim();
        const res = document.getElementById('tracking-result');
        const badge = document.getElementById('res-status-badge');
        const note = document.getElementById('tracker-note-text');
        const ticket = document.getElementById('res-ticket');
        const steps = document.getElementById('tracker-steps');

        if (!val) return;
        ticket.textContent = val.toUpperCase();

        if (val.toLowerCase().includes('selesai') || val.endsWith('21')) {
            badge.className = 'badge badge-success';
            badge.textContent = 'Selesai';
            note.innerHTML = '<strong>Catatan Petugas (Sekdes):</strong> Pekerjaan telah diselesaikan tim teknis lapangan. Bukti penanganan tersimpan.';
            steps.innerHTML = `
                <li class="step step-success" data-content="✓">Terkirim</li>
                <li class="step step-success" data-content="✓">Verifikasi Desa</li>
                <li class="step step-success" data-content="✓">Tindakan Lapangan</li>
                <li class="step step-success" data-content="✓">Selesai & Laporan</li>
            `;
        } else {
            badge.className = 'badge badge-warning';
            badge.textContent = 'Sedang Ditangani';
            note.innerHTML = '<strong>Catatan Petugas (Kaur Kesra):</strong> Komponen lampu LED pengganti sudah diambil dari logistik. Pemasangan sore ini jam 15:30 WIB.';
            steps.innerHTML = `
                <li class="step step-primary" data-content="✓">Terkirim</li>
                <li class="step step-primary" data-content="✓">Verifikasi Desa</li>
                <li class="step step-primary">Tindakan Lapangan</li>
                <li class="step">Selesai & Laporan</li>
            `;
        }
        res.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function filterReports(status, tabEl) {
        document.querySelectorAll('[role="tablist"] .tab').forEach(t => t.classList.remove('tab-active'));
        if (tabEl) tabEl.classList.add('tab-active');

        const cards = document.querySelectorAll('.report-card');
        cards.forEach(c => {
            if (status === 'all' || c.getAttribute('data-status') === status) {
                c.classList.remove('hidden');
            } else {
                c.classList.add('hidden');
            }
        });
    }

    function toggleUpvote(btn, baseCount) {
        const countEl = btn.querySelector('.upvote-count');
        const isUpvoted = btn.classList.contains('text-primary');
        if (isUpvoted) {
            btn.classList.remove('text-primary');
            countEl.textContent = baseCount;
        } else {
            btn.classList.add('text-primary');
            countEl.textContent = baseCount + 1;
        }
    }

    function submitComplaint() {
        const ticket = 'PKH-' + Math.floor(10000000 + Math.random() * 90000000);
        alert(`Laporan Anda berhasil dicatat!\n\nNomor Tiket: ${ticket}\nSimpan tiket ini untuk melacak proses penanganan.`);
        complaint_modal.close();
        document.getElementById('complaint-form').reset();
        goToStep(1);
        document.getElementById('tracking-input').value = ticket;
        trackReport();
    }
</script>


