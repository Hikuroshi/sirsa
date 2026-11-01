<script>
    function goToStep(stepNumber) {
        [1, 2, 3].forEach((step) => {
            document.getElementById(`step-pane-${step}`).classList.toggle('hidden', step !== stepNumber);
            document.getElementById(`mstep-${step}`).classList.toggle('step-primary', step <= stepNumber);
        });
    }

    function nextComplaintStep(stepNumber) {
        const pane = document.querySelector('#complaint-form > div:not(.hidden)');
        const invalid = [...pane.querySelectorAll('input, select, textarea')].find((field) => !field.checkValidity());

        if (invalid) {
            invalid.reportValidity();
            return;
        }

        goToStep(stepNumber);
    }

    function toggleAnonMode(isAnonymous) {
        const fields = document.getElementById('identitas-fields');
        fields.classList.toggle('opacity-40', isAnonymous);
        fields.querySelectorAll('input').forEach((field) => (field.disabled = isAnonymous));
    }

    function validateComplaint() {
        const form = document.getElementById('complaint-form');
        const invalid = [...form.querySelectorAll('input, select, textarea')].find((field) => !field.checkValidity());

        if (invalid) {
            goToStep(Number(invalid.closest('[id^="step-pane-"]').id.slice(-1)));
            invalid.reportValidity();
            return false;
        }

        form.querySelector('[type="submit"]').disabled = true;
        return true;
    }

    function filterReports(status, tab) {
        document.querySelectorAll('[data-report-filter]').forEach((button) => {
            const active = button === tab;
            button.classList.toggle('tab-active', active);
            button.setAttribute('aria-selected', String(active));
        });
        document.querySelectorAll('.report-card').forEach((card) => {
            card.classList.toggle('hidden', status !== 'all' && card.dataset.status !== status);
        });
        document.getElementById('filtered-reports-empty').hidden = [...document.querySelectorAll('.report-card')].some(
            (card) => !card.classList.contains('hidden'),
        );
    }

    toggleAnonMode(document.getElementById('modal-anon').checked);

    @if ($errors->any() && old('report_form') === 'home')
    document.getElementById('complaint_modal').showModal();
    @endif
</script>
