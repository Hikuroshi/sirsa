<?php

namespace App\Http\Controllers;

use App\Enums\ReportStatus;
use App\Models\Category;
use App\Models\Report;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $statusCounts = Report::query()->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        return view('home', [
            'title' => 'Beranda',
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'totalReports' => $statusCounts->sum(),
            'inProgressReports' => (int) $statusCounts->get(ReportStatus::Processing->value, 0),
            'resolvedReports' => (int) $statusCounts->get(ReportStatus::Completed->value, 0),
            'reports' => Report::query()->with('category')->latest()->limit(6)->get(),
            'statuses' => ReportStatus::cases(),
        ]);
    }
}
