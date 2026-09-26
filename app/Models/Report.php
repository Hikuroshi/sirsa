<?php

namespace App\Models;

use App\Enums\AiStatus;
use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['organization_id', 'reporter_id', 'category_id', 'verified_by', 'tracking_code', 'reporter_name', 'reporter_contact', 'original_description', 'description', 'priority', 'status', 'ai_status', 'verified_at', 'ai_cancelled_at', 'ai_processed_at'])]
class Report extends Model
{
    /** @use HasFactory<ReportFactory> */
    use HasFactory, HasUuids;

    protected static function booted(): void
    {
        static::deleting(function (Report $report): void {
            $report->images()->eachById(fn (Image $image) => $image->delete());
        });
    }

    protected function casts(): array
    {
        return [
            'priority' => ReportPriority::class,
            'status' => ReportStatus::class,
            'ai_status' => AiStatus::class,
            'verified_at' => 'datetime',
            'ai_cancelled_at' => 'datetime',
            'ai_processed_at' => 'datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('sort_order');
    }

    public function aiResult(): HasOne
    {
        return $this->hasOne(ReportAiResult::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ReportStatusHistory::class)->oldest();
    }
}
