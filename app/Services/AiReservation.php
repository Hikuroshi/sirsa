<?php

namespace App\Services;

final readonly class AiReservation
{
    public function __construct(
        public ?AiSlot $slot,
        public int $retryAfter = 0,
        public ?string $minuteBucketId = null,
        public ?string $dayBucketId = null,
        public int $estimatedTokens = 0,
        public bool $impossible = false,
    ) {}

    public function isAvailable(): bool
    {
        return $this->slot !== null;
    }
}
