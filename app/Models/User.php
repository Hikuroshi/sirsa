<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['organization_id', 'name', 'username', 'email', 'role', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    protected static function booted(): void
    {
        static::deleting(function (User $user): void {
            $user->createdOrganizations()->eachById(fn (Organization $organization) => $organization->delete());
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function createdOrganizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'created_by');
    }

    public function verifiedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'verified_by');
    }

    public function statusChanges(): HasMany
    {
        return $this->hasMany(ReportStatusHistory::class, 'changed_by');
    }

    public function isSuperadmin(): bool
    {
        return $this->role === Role::Superadmin;
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['name', 'username', 'email'], 'like', "%{$search}%");
            });
        });
    }
}
