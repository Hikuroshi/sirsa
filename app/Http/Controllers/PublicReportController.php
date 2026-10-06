<?php

namespace App\Http\Controllers;

use App\Enums\AiStatus;
use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Jobs\AnalyzeReport;
use App\Models\Report;
use App\Services\AiRequestScheduler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class PublicReportController extends Controller
{
    public function create(): View
    {
        return view('report.form', [
            'title' => 'Laporkan',
        ]);
    }

    public function store(Request $request, AiRequestScheduler $scheduler): RedirectResponse
    {
        $validated = $request->validate([
            'reporter_name' => ['required', 'string', 'max:255'],
            'reporter_contact' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20', 'max:10000'],
            'photos' => ['nullable', 'array', 'max:3'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $aiEnabled = $scheduler->hasConfiguration();
        $storedImages = [];

        try {
            $report = DB::transaction(function () use ($request, $validated, $aiEnabled, &$storedImages): Report {
                $report = Report::create([
                    'reporter_id' => Auth::id(),
                    'tracking_code' => Str::lower(Str::random(24)),
                    'reporter_name' => $validated['reporter_name'],
                    'reporter_contact' => $validated['reporter_contact'] ?? null,
                    'original_description' => $validated['description'],
                    'description' => $validated['description'],
                    'priority' => ReportPriority::Medium,
                    'status' => ReportStatus::Accepted,
                    'ai_status' => $aiEnabled ? AiStatus::Queued : AiStatus::Disabled,
                ]);

                foreach ($request->file('photos', []) as $index => $photo) {
                    $path = $photo->store("reports/{$report->id}", 'public');
                    $storedImages[] = $path;
                    $report->images()->create([
                        'path' => $path,
                        'sort_order' => $index,
                    ]);
                }

                $report->statusHistories()->create(['to_status' => ReportStatus::Accepted]);
                if ($aiEnabled) {
                    AnalyzeReport::dispatch($report);
                }

                return $report;
            });
        } catch (Throwable $exception) {
            Storage::delete($storedImages);

            throw $exception;
        }

        return redirect()->route('reports.track', $report->tracking_code)
            ->with('success', 'Laporan berhasil dikirim. Simpan kode pelacakan Anda.');
    }

    public function track(string $trackingCode): View
    {
        $report = Report::query()
            ->where('tracking_code', $trackingCode)
            ->with(['category', 'images', 'statusHistories.changedBy'])
            ->firstOrFail();

        return view('report.track', [
            'title' => 'Laporan',
            'report' => $report,
        ]);
    }
}
