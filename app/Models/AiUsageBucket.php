<?php

namespace App\Models;

use Database\Factories\AiUsageBucketFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['ai_api_key_id', 'window', 'period_started_at', 'requests', 'tokens'])]
class AiUsageBucket extends Model
{
    /** @use HasFactory<AiUsageBucketFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return ['period_started_at' => 'datetime'];
    }

    public function aiApiKey(): BelongsTo
    {
        return $this->belongsTo(AiApiKey::class);
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['window'], 'like', "%{$search}%");
            });
        });
    }
}
