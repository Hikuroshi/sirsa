<?php

namespace App\Models;

use App\Enums\Role;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['created_by', 'name', 'slug', 'description', 'is_active'])]
class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory, HasUuids;

    protected static function booted(): void
    {
        static::deleting(function (Organization $organization): void {
            $organization->reports()->eachById(fn (Report $report) => $report->delete());
        });
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class)->where('role', Role::Admin->value);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function aiApiKeys(): HasMany
    {
        return $this->hasMany(AiApiKey::class);
    }
}
