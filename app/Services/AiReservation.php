<?php

namespace App\Services;

use App\Models\AiApiKey;

final readonly class AiReservation
{
    public function __construct(
        public ?AiApiKey $apiKey,
        public int $retryAfter = 0,
        public ?string $minuteBucketId = null,
        public ?string $dayBucketId = null,
        public int $estimatedTokens = 0,
    ) {}

    public function isAvailable(): bool
    {
        return $this->apiKey !== null;
    }
}
