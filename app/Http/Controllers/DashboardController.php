<?php

namespace App\Http\Controllers;

use App\Models\Organization;
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
            'organizationCount' => $request->user()->isSuperadmin() ? Organization::query()->count() : (int) ($request->user()->organization_id !== null),
            'reportCount' => Report::query()
                ->when($request->user()->isAdmin(), fn ($query) => $query->where('organization_id', $request->user()->organization_id))
                ->when(! $request->user()->isAdmin() && ! $request->user()->isSuperadmin(), fn ($query) => $query->where('reporter_id', $request->user()->id))
                ->count(),
            'userCount' => $request->user()->isSuperadmin() ? User::query()->count() : null,
        ]);
    }
}
