<?php

namespace App\Models;

use Database\Factories\AiModelLimitFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
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
}
