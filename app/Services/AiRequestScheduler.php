<?php

namespace App\Services;

use App\Models\AiApiKey;
use App\Models\AiModelLimit;
use App\Models\AiUsageBucket;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AiRequestScheduler
{
    public function hasConfiguration(Organization $organization): bool
    {
        return $this->availableKeys($organization)->exists();
    }

    public function preferredModelLimit(Organization $organization): ?AiModelLimit
    {
        return $this->availableKeys($organization)
            ->with('modelLimit')
            ->first()
            ?->modelLimit;
    }

    public function reserve(Organization $organization, AiModelLimit $modelLimit, int $estimatedTokens): AiReservation
    {
        /** @var Collection<int, AiApiKey> $keys */
        $keys = $this->availableKeys($organization)
            ->whereBelongsTo($modelLimit, 'modelLimit')
            ->where(fn ($query) => $query
                ->whereNull('cooldown_until')
                ->orWhere('cooldown_until', '<=', now()))
            ->with('modelLimit')
            ->get();

        $retryAfter = PHP_INT_MAX;

        foreach ($keys as $apiKey) {
            $quota = DB::transaction(function () use ($apiKey, $estimatedTokens): array {
                $limits = $apiKey->effectiveLimits();
                $minute = $this->bucket($apiKey, 'minute', now()->startOfMinute());
                $day = $this->bucket($apiKey, 'day', now()->startOfDay());

                if ($day->requests >= $limits['rpd']) {
                    return ['wait' => max(1, now()->diffInSeconds(now()->addDay()->startOfDay()))];
                }

                if ($minute->requests >= $limits['rpm'] || $minute->tokens + $estimatedTokens > $limits['tpm']) {
                    return ['wait' => max(1, now()->diffInSeconds(now()->addMinute()->startOfMinute()))];
                }

                $minute->increment('requests');
                $minute->increment('tokens', $estimatedTokens);
                $day->increment('requests');
                $day->increment('tokens', $estimatedTokens);
                $apiKey->update(['last_used_at' => now()]);

                return [
                    'wait' => 0,
                    'minute_bucket_id' => $minute->id,
                    'day_bucket_id' => $day->id,
                ];
            }, 3);

            if ($quota['wait'] === 0) {
                return new AiReservation(
                    apiKey: $apiKey,
                    minuteBucketId: $quota['minute_bucket_id'],
                    dayBucketId: $quota['day_bucket_id'],
                    estimatedTokens: $estimatedTokens,
                );
            }

            $retryAfter = min($retryAfter, $quota['wait']);
        }

        return new AiReservation(null, $retryAfter === PHP_INT_MAX ? 60 : $retryAfter);
    }

    /** @return Builder<AiApiKey> */
    private function availableKeys(Organization $organization): Builder
    {
        return AiApiKey::query()
            ->where('is_active', true)
            ->where(fn ($query) => $query
                ->where('organization_id', $organization->id)
                ->orWhereNull('organization_id'))
            ->orderByRaw('CASE WHEN organization_id = ? THEN 0 ELSE 1 END', [$organization->id])
            ->orderBy('priority');
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

    public function markFailure(AiApiKey $apiKey): void
    {
        $apiKey->increment('failure_count', 1, [
            'cooldown_until' => now()->addMinute(),
            'last_error' => 'Permintaan ke provider AI gagal.',
        ]);
    }

    private function bucket(AiApiKey $apiKey, string $window, \DateTimeInterface $periodStartedAt): AiUsageBucket
    {
        AiUsageBucket::query()->insertOrIgnore([
            'id' => (string) Str::uuid(),
            'ai_api_key_id' => $apiKey->id,
            'window' => $window,
            'period_started_at' => $periodStartedAt,
            'requests' => 0,
            'tokens' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return AiUsageBucket::query()
            ->whereBelongsTo($apiKey)
            ->where('window', $window)
            ->where('period_started_at', $periodStartedAt)
            ->lockForUpdate()
            ->firstOrFail();
    }
}
