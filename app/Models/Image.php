<?php

namespace App\Models;

use Database\Factories\ImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['path', 'sort_order'])]
class Image extends Model
{
    /** @use HasFactory<ImageFactory> */
    use HasFactory, HasUuids;

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::deleting(function (Image $image): void {
            if ($image->path) {
                Storage::delete($image->path);
            }
        });
    }

    public function url(): string
    {
        return Storage::url($this->path);
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['path'], 'like', "%{$search}%");
            });
        });
    }
}
