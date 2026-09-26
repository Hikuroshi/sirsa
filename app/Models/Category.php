<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['organization_id', 'name', 'description', 'is_active'])]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['name', 'description'], 'like', "%{$search}%");
            });
        });
    }
}
