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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
            'anonymous' => ['sometimes', 'boolean'],
            'reporter_name' => ['required_unless:anonymous,1', 'nullable', 'string', 'max:255'],
            'reporter_contact' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'hamlet' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:500'],
            'category_id' => ['nullable', Rule::exists('categories', 'id')],
            'description' => ['required', 'string', 'min:20', 'max:10000'],
            'photos' => ['nullable', 'array', 'max:3'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $description = collect([
            filled($validated['title'] ?? null) ? 'Judul: '.$validated['title'] : null,
            filled($validated['hamlet'] ?? null) ? 'Dusun / lingkungan: '.$validated['hamlet'] : null,
            filled($validated['location'] ?? null) ? 'Lokasi: '.$validated['location'] : null,
            $validated['description'],
        ])->filter()->implode("\n\n");

        if (mb_strlen($description) > 10000) {
            throw ValidationException::withMessages(['description' => 'Deskripsi beserta judul dan lokasi maksimal 10.000 karakter.']);
        }

        $anonymous = $request->boolean('anonymous');
        $aiEnabled = $scheduler->hasConfiguration();
        $storedImages = [];

        try {
            $report = DB::transaction(function () use ($request, $validated, $description, $anonymous, $aiEnabled, &$storedImages): Report {
                $report = Report::create([
                    'reporter_id' => $anonymous ? null : Auth::id(),
                    'reporter_name' => $anonymous ? 'Warga Anonim' : $validated['reporter_name'],
                    'reporter_contact' => $anonymous ? null : ($validated['reporter_contact'] ?? null),
                    'category_id' => $validated['category_id'] ?? null,
                    'original_description' => $description,
                    'description' => $description,
                    'priority' => ReportPriority::Medium,
                    'status' => ReportStatus::Accepted,
                    'ai_status' => $aiEnabled ? AiStatus::Queued : AiStatus::Disabled,
                ]);

                foreach ($request->file('photos', []) as $index => $photo) {
                    $path = $photo->store("reports/{$report->id}");
                    $storedImages[] = $path;
                    $report->images()->create([
                        'path' => $path,
                        'sort_order' => $index,
                    ]);
                }

                $report->statusHistories()->create(['to_status' => ReportStatus::Accepted]);

                return $report;
            });
        } catch (Throwable $exception) {
            Storage::delete($storedImages);

            throw $exception;
        }

        if ($aiEnabled) {
            try {
                AnalyzeReport::dispatch($report);
            } catch (Throwable) {
                Report::query()->whereKey($report->id)
                    ->where('ai_status', AiStatus::Queued)
                    ->whereNull('verified_at')
                    ->whereNull('ai_cancelled_at')
                    ->update(['ai_status' => AiStatus::Failed, 'ai_processed_at' => now()]);
                Log::error('Laporan tersimpan, tetapi gagal dikirim ke antrean AI.', ['report_id' => $report->id]);
            }
        }

        return redirect()->route('reports.track', $report)
            ->with('success', 'Laporan berhasil dikirim. Simpan ID laporan Anda.');
    }

    public function lookup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'report_id' => ['required', 'uuid', Rule::exists('reports', 'id')],
        ]);

        return redirect()->route('reports.track', $validated['report_id']);
    }

    public function track(Report $report): View
    {
        $report->load(['category', 'images', 'aiResult:id,report_id', 'statusHistories']);

        return view('report.show', [
            'title' => 'Pelacakan Laporan',
            'report' => $report,
            'tracking' => true,
        ]);
    }
}
