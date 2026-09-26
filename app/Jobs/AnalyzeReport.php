<?php

namespace App\Jobs;

use App\Enums\AiStatus;
use App\Enums\ReportPriority;
use App\Models\Report;
use App\Models\ReportAiResult;
use App\Services\AiProviderRegistry;
use App\Services\AiRequestScheduler;
use DateTimeInterface;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Throwable;

class AnalyzeReport implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $timeout = 60;

    public int $tries = 20;

    public function __construct(public Report $report)
    {
        $this->afterCommit();
    }

    public function uniqueId(): string
    {
        return $this->report->id;
    }

    public function retryUntil(): DateTimeInterface
    {
        return now()->addDay();
    }

    public function handle(AiRequestScheduler $scheduler, AiProviderRegistry $providers): void
    {
        $report = $this->report->fresh(['organization.categories', 'images']);

        if ($report === null || $report->ai_cancelled_at !== null || $report->verified_at !== null) {
            return;
        }

        $modelLimit = $scheduler->preferredModelLimit($report->organization);

        if ($modelLimit === null) {
            Report::query()
                ->whereKey($report->id)
                ->whereNull('ai_cancelled_at')
                ->whereNull('verified_at')
                ->update(['ai_status' => AiStatus::Disabled]);

            return;
        }

        $provider = $providers->resolve($modelLimit->provider);
        $estimatedTokens = $provider->estimateTokens($report);
        $reservation = $scheduler->reserve($report->organization, $modelLimit, $estimatedTokens);

        if (! $reservation->isAvailable()) {
            $this->release($reservation->retryAfter);

            return;
        }

        $started = Report::query()
            ->whereKey($report->id)
            ->whereNull('ai_cancelled_at')
            ->whereNull('verified_at')
            ->update(['ai_status' => AiStatus::Processing]);

        if ($started === 0) {
            return;
        }

        $report->refresh();

        try {
            $result = $provider->analyze($report, $reservation->apiKey);
        } catch (Throwable) {
            $scheduler->markFailure($reservation->apiKey);
            $this->release(60);

            return;
        }

        $scheduler->reconcile(
            $reservation,
            $result['input_tokens'] + $result['output_tokens'],
        );

        DB::transaction(function () use ($report, $reservation, $result): void {
            $lockedReport = Report::query()->lockForUpdate()->find($report->id);

            if ($lockedReport === null || $lockedReport->ai_cancelled_at !== null || $lockedReport->verified_at !== null) {
                return;
            }

            ReportAiResult::query()->updateOrCreate(
                ['report_id' => $lockedReport->id],
                [
                    'category_id' => $result['category_id'],
                    'ai_api_key_id' => $reservation->apiKey->id,
                    'refined_description' => $result['refined_description'],
                    'priority' => $result['priority'],
                    'reason' => $result['reason'],
                    'provider' => $reservation->apiKey->modelLimit->provider,
                    'model' => $reservation->apiKey->modelLimit->model,
                    'input_tokens' => $result['input_tokens'],
                    'output_tokens' => $result['output_tokens'],
                    'response' => $result['response'],
                ],
            );

            $lockedReport->update([
                'description' => $result['refined_description'],
                'category_id' => $result['category_id'],
                'priority' => $result['priority'],
                'ai_status' => AiStatus::Completed,
                'ai_processed_at' => now(),
            ]);
        }, 3);
    }

    public function failed(?Throwable $exception): void
    {
        $report = $this->report->fresh();

        if ($report === null || $report->ai_cancelled_at !== null) {
            return;
        }

        $report->update([
            'description' => $report->original_description,
            'category_id' => null,
            'priority' => ReportPriority::Medium,
            'ai_status' => AiStatus::Failed,
            'ai_processed_at' => now(),
        ]);
    }
}
