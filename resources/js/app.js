document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-description-toggle]');

    if (!button) {
        return;
    }

    const container = button.closest('[data-report-description]');
    const refined = container.querySelector('[data-refined-description]');
    const original = container.querySelector('[data-original-description]');
    const showingOriginal = button.getAttribute('aria-pressed') === 'true';

    refined.hidden = !showingOriginal;
    original.hidden = showingOriginal;
    button.setAttribute('aria-pressed', String(!showingOriginal));
    button.textContent = showingOriginal ? 'Lihat laporan asli' : 'Lihat laporan yang dirapikan';
});
