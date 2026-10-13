<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['ai_key_state_id', 'window', 'period_started_at', 'requests', 'tokens'])]
class AiUsageBucket extends Model
{
    use HasUuids, MassPrunable;

    public function prunable(): Builder
    {
        return static::query()->where('period_started_at', '<', now()->subDays(2));
    }

    protected function casts(): array
    {
        return ['period_started_at' => 'datetime'];
    }
}
