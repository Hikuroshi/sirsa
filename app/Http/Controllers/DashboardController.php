<?php

namespace App\Http\Controllers;

use App\Enums\ReportStatus;
use App\Models\Report;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $reports = Report::query()
            ->when(! $request->user()->isAdmin(), fn ($query) => $query->where('reporter_id', $request->user()->id));
        $statusCounts = (clone $reports)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($total): int => (int) $total);

        $currentMonth = CarbonImmutable::now()->startOfMonth();
        $months = collect(range(5, 0))->map(fn (int $offset): CarbonImmutable => $currentMonth->subMonths($offset));
        $monthlyCounts = (clone $reports)
            ->where('created_at', '>=', $months->first())
            ->where('created_at', '<', $currentMonth->addMonth())
            ->selectRaw('SUBSTR(created_at, 1, 7) as period, COUNT(*) as total')
            ->groupBy('period')
            ->pluck('total', 'period');

        $chartData = [
            'trend' => [
                'labels' => $months->map(fn (CarbonImmutable $month): string => $month->translatedFormat('M Y'))->all(),
                'values' => $months->map(fn (CarbonImmutable $month): int => (int) $monthlyCounts->get($month->format('Y-m'), 0))->all(),
            ],
            'statuses' => collect(ReportStatus::cases())->map(fn (ReportStatus $status): array => [
                'value' => $status->value,
                'label' => $status->label(),
                'count' => $statusCounts->get($status->value, 0),
            ])->all(),
        ];

        return view('dashboard', [
            'title' => 'Dashboard',
            'reportCount' => $statusCounts->sum(),
            'userCount' => $request->user()->isAdmin() ? User::query()->count() : null,
            'chartData' => $chartData,
        ]);
    }
}
