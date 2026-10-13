<?php

namespace App\Contracts;

use App\Models\Report;
use App\Services\AiSlot;

interface AiProvider
{
    public function estimateTokens(Report $report): int;

    /**
     * @return array{refined_description: string, category_id: string|null, priority: string, reason: string|null, input_tokens: int, output_tokens: int, response: array<string, mixed>}
     */
    public function analyze(Report $report, AiSlot $slot): array;
}
