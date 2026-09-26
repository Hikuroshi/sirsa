<?php

namespace App\Models;

use App\Enums\ReportPriority;
use Database\Factories\ReportAiResultFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['report_id', 'category_id', 'ai_api_key_id', 'refined_description', 'priority', 'reason', 'provider', 'model', 'input_tokens', 'output_tokens', 'response'])]
class ReportAiResult extends Model
{
    /** @use HasFactory<ReportAiResultFactory> */
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return ['priority' => ReportPriority::class, 'response' => 'array'];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function aiApiKey(): BelongsTo
    {
        return $this->belongsTo(AiApiKey::class);
    }
}
