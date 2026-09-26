<?php

namespace App\Models;

use Database\Factories\AiApiKeyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['organization_id', 'ai_model_limit_id', 'name', 'secret', 'suffix', 'priority', 'is_active', 'rpm', 'rpd', 'tpm', 'cooldown_until', 'failure_count', 'last_used_at', 'last_error'])]
#[Hidden(['secret'])]
class AiApiKey extends Model
{
    /** @use HasFactory<AiApiKeyFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'secret' => 'encrypted',
            'is_active' => 'boolean',
            'cooldown_until' => 'datetime',
            'last_used_at' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function modelLimit(): BelongsTo
    {
        return $this->belongsTo(AiModelLimit::class, 'ai_model_limit_id');
    }

    public function usageBuckets(): HasMany
    {
        return $this->hasMany(AiUsageBucket::class);
    }

    /** @return array{rpm: int, rpd: int, tpm: int} */
    public function effectiveLimits(): array
    {
        return [
            'rpm' => $this->rpm ?? $this->modelLimit->rpm,
            'rpd' => $this->rpd ?? $this->modelLimit->rpd,
            'tpm' => $this->tpm ?? $this->modelLimit->tpm,
        ];
    }
}
