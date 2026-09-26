<?php

namespace App\Models;

use Database\Factories\AiModelLimitFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['provider', 'model', 'rpm', 'rpd', 'tpm'])]
class AiModelLimit extends Model
{
    /** @use HasFactory<AiModelLimitFactory> */
    use HasFactory, HasUuids;

    public function apiKeys(): HasMany
    {
        return $this->hasMany(AiApiKey::class);
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['provider', 'model'], 'like', "%{$search}%");
            });
        });
    }
}
