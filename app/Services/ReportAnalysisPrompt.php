<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Report;
use Illuminate\Filesystem\Filesystem;

class ReportAnalysisPrompt
{
    public function __construct(private Filesystem $files) {}

    public function render(Report $report): string
    {
        $categories = Category::query()->where('is_active', true)->orderBy('name')->get()
            ->map(fn ($category): string => "{$category->id}: {$category->name}")
            ->implode("\n");

        return strtr($this->files->get(resource_path('prompts/report-analysis.md')), [
            '{{categories}}' => $categories,
            '{{description}}' => $report->original_description,
        ]);
    }
}
