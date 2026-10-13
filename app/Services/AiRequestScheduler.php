<?php

namespace App\Services;

use App\Models\AiKeyState;
use App\Models\AiUsageBucket;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AiRequestScheduler
{
    public function __construct(private AiSlots $slots, private AiProviderRegistry $providers) {}

    public function hasConfiguration(): bool
    {
        return $this->slots->hasAny();
    }

    public function reserve(Report $report): AiReservation
    {
        $retryAfter = PHP_INT_MAX;
        $hasCapableSlot = false;

        foreach ($this->slots->all() as $slot) {
            $estimatedTokens = $this->providers->resolve($slot->provider)->estimateTokens($report);

            if ($estimatedTokens > $slot->tpm) {
                continue;
            }

            $hasCapableSlot = true;

            $quota = DB::transaction(function () use ($slot, $estimatedTokens): array {
                AiKeyState::query()->insertOrIgnore([
                    'id' => $slot->id(),
                    'failure_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                /** @var AiKeyState $state */
                $state = AiKeyState::query()->lockForUpdate()->findOrFail($slot->id());

                if ($state->cooldown_until?->isFuture()) {
                    return ['wait' => max(1, now()->diffInSeconds($state->cooldown_until))];
                }

                $minute = $this->bucket($state, 'minute', now()->startOfMinute());
                $day = $this->bucket($state, 'day', now()->startOfDay());

                if ($day->requests >= $slot->rpd) {
                    return ['wait' => max(1, now()->diffInSeconds(now()->addDay()->startOfDay()))];
                }

                if ($minute->requests >= $slot->rpm || $minute->tokens + $estimatedTokens > $slot->tpm) {
                    return ['wait' => max(1, now()->diffInSeconds(now()->addMinute()->startOfMinute()))];
                }

                $minute->increment('requests');
                $minute->increment('tokens', $estimatedTokens);
                $day->increment('requests');
                $day->increment('tokens', $estimatedTokens);
                $state->update(['last_used_at' => now()]);

                return [
                    'wait' => 0,
                    'minute_bucket_id' => $minute->id,
                    'day_bucket_id' => $day->id,
                ];
            }, 3);

            if ($quota['wait'] === 0) {
                return new AiReservation(
                    slot: $slot,
                    minuteBucketId: $quota['minute_bucket_id'],
                    dayBucketId: $quota['day_bucket_id'],
                    estimatedTokens: $estimatedTokens,
                );
            }

            $retryAfter = min($retryAfter, $quota['wait']);
        }

        if (! $hasCapableSlot) {
            return new AiReservation(null, impossible: true);
        }

        return new AiReservation(null, $retryAfter);
    }

    public function reconcile(AiReservation $reservation, int $actualTokens): void
    {
        $difference = $actualTokens - $reservation->estimatedTokens;

        if ($difference === 0 || $reservation->minuteBucketId === null || $reservation->dayBucketId === null) {
            return;
        }

        DB::transaction(function () use ($reservation, $difference): void {
            AiUsageBucket::query()
                ->whereKey([$reservation->minuteBucketId, $reservation->dayBucketId])
                ->lockForUpdate()
                ->get()
                ->each(function (AiUsageBucket $bucket) use ($difference): void {
                    $bucket->update(['tokens' => max(0, $bucket->tokens + $difference)]);
                });
        }, 3);
    }

    public function markFailure(AiSlot $slot): void
    {
        AiKeyState::query()->findOrFail($slot->id())->increment('failure_count', 1, [
            'cooldown_until' => now()->addMinute(),
            'last_error' => 'Permintaan ke provider AI gagal.',
        ]);
    }

    private function bucket(AiKeyState $state, string $window, \DateTimeInterface $periodStartedAt): AiUsageBucket
    {
        AiUsageBucket::query()->insertOrIgnore([
            'id' => (string) Str::uuid(),
            'ai_key_state_id' => $state->id,
            'window' => $window,
            'period_started_at' => $periodStartedAt,
            'requests' => 0,
            'tokens' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return AiUsageBucket::query()
            ->where('ai_key_state_id', $state->id)
            ->where('window', $window)
            ->where('period_started_at', $periodStartedAt)
            ->lockForUpdate()
            ->firstOrFail();
    }
}
