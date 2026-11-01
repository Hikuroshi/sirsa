import {
    ArcElement,
    CategoryScale,
    Chart,
    DoughnutController,
    LineController,
    LineElement,
    LinearScale,
    PointElement,
    Tooltip,
} from 'chart.js';

Chart.register(
    ArcElement,
    CategoryScale,
    DoughnutController,
    LineController,
    LineElement,
    LinearScale,
    PointElement,
    Tooltip,
);

export function initializeDashboardCharts(container) {
    const data = JSON.parse(container.dataset.chartData);
    const style = getComputedStyle(container);
    const color = (name) => style.getPropertyValue(`--color-${name}`).trim();
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        animation: window.matchMedia('(prefers-reduced-motion: reduce)').matches
            ? false
            : { duration: 500 },
        color: color('base-content'),
        font: { family: style.fontFamily },
        locale: 'id-ID',
        plugins: {
            tooltip: {
                backgroundColor: color('base-content'),
                titleColor: color('base-100'),
                bodyColor: color('base-100'),
                padding: 12,
                cornerRadius: 8,
                displayColors: false,
            },
        },
    };

    new Chart(container.querySelector('[data-report-trend]'), {
        type: 'line',
        data: {
            labels: data.trend.labels,
            datasets: [
                {
                    label: 'Laporan masuk',
                    data: data.trend.values,
                    borderColor: color('primary'),
                    backgroundColor: color('primary'),
                    pointHoverBackgroundColor: color('primary'),
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3,
                },
            ],
        },
        options: {
            ...options,
            interaction: { mode: 'index', intersect: false },
            scales: {
                x: {
                    border: { display: false },
                    grid: { display: false },
                    ticks: {
                        color: color('base-content'),
                        maxRotation: 0,
                        autoSkip: true,
                    },
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: 5,
                    border: { display: false },
                    grid: { color: color('base-200') },
                    ticks: { precision: 0, color: color('base-content') },
                },
            },
        },
    });

    const statusCanvas = container.querySelector('[data-report-status]');

    if (statusCanvas) {
        const colors = [
            ...container.querySelectorAll('[data-status-color]'),
        ].map((swatch) => getComputedStyle(swatch).backgroundColor);

        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: data.statuses.map((status) => status.label),
                datasets: [
                    {
                        label: 'Laporan',
                        data: data.statuses.map((status) => status.count),
                        backgroundColor: colors,
                        hoverBackgroundColor: colors,
                        borderColor: color('base-100'),
                        borderWidth: 4,
                        hoverOffset: 6,
                    },
                ],
            },
            options: { ...options, cutout: '72%', layout: { padding: 8 } },
        });
    }
}
