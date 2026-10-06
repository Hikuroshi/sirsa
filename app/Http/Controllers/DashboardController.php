<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'reportCount' => Report::query()
                ->when(! $request->user()->isAdmin(), fn ($query) => $query->where('reporter_id', $request->user()->id))
                ->count(),
            'userCount' => $request->user()->isAdmin() ? User::query()->count() : null,
        ]);
    }
}
