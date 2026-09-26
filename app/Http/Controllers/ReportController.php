<?php

namespace App\Http\Controllers;

use App\Enums\AiStatus;
use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Report::class);
        $query = Report::query()
            ->with(['organization', 'category'])
            ->search($request->string('search')->trim()->toString())
            ->latest();

        if ($request->user()->isAdmin()) {
            $query->where('organization_id', $request->user()->organization_id);
        } elseif (! $request->user()->isSuperadmin()) {
            $query->where('reporter_id', $request->user()->id);
        }

        return view('report.index', [
            'title' => 'Daftar Laporan',
            'reports' => $query->paginate(15)->withQueryString(),
        ]);
    }

    public function show(Report $report): View
    {
        Gate::authorize('view', $report);
        $report->load(['organization.categories', 'category', 'images', 'aiResult.category', 'statusHistories.changedBy']);

        return view('report.show', [
            'title' => 'Laporan',
            'report' => $report,
            'priorities' => ReportPriority::cases(),
            'statuses' => ReportStatus::cases(),
        ]);
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        Gate::authorize('update', $report);
        $validated = $request->validate([
            'description' => ['required', 'string', 'min:20', 'max:10000'],
            'category_id' => ['nullable', Rule::exists('categories', 'id')->where('organization_id', $report->organization_id)],
            'priority' => ['required', Rule::enum(ReportPriority::class)],
            'status' => ['required', Rule::enum(ReportStatus::class)],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);
        DB::transaction(function () use ($request, $report, $validated): void {
            $lockedReport = Report::query()->lockForUpdate()->findOrFail($report->id);
            $nextStatus = ReportStatus::from($validated['status']);

            if ($nextStatus !== $lockedReport->status && ! in_array($nextStatus, $lockedReport->status->transitions(), true)) {
                throw ValidationException::withMessages(['status' => 'Perubahan status tidak diizinkan.']);
            }

            $previousStatus = $lockedReport->status;
            $shouldCancelAi = in_array($lockedReport->ai_status, [AiStatus::Queued, AiStatus::Processing], true);
            $lockedReport->update([
                'description' => $validated['description'],
                'category_id' => $validated['category_id'] ?? null,
                'priority' => $validated['priority'],
                'status' => $nextStatus,
                'verified_at' => $lockedReport->verified_at ?? now(),
                'verified_by' => $request->user()->id,
                'ai_status' => $shouldCancelAi ? AiStatus::Cancelled : $lockedReport->ai_status,
                'ai_cancelled_at' => $shouldCancelAi ? now() : $lockedReport->ai_cancelled_at,
            ]);

            if ($nextStatus !== $previousStatus) {
                $lockedReport->statusHistories()->create([
                    'changed_by' => $request->user()->id,
                    'from_status' => $previousStatus,
                    'to_status' => $nextStatus,
                    'note' => $validated['note'] ?? null,
                ]);
            }
        });

        return back()->with('success', 'Laporan berhasil diperbarui.');
    }
}
