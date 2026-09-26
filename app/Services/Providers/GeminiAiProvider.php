<?php

namespace App\Services\Providers;

use App\Contracts\AiProvider;
use App\Models\AiApiKey;
use App\Models\Report;
use App\Services\ReportAnalysisPrompt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use UnexpectedValueException;

class GeminiAiProvider implements AiProvider
{
    public function __construct(private ReportAnalysisPrompt $prompt) {}

    public function estimateTokens(Report $report): int
    {
        return max(100, (int) ceil(mb_strlen($report->original_description) / 4) + ($report->images()->count() * 1000));
    }

    public function analyze(Report $report, AiApiKey $apiKey): array
    {
        $report->loadMissing(['organization.categories' => fn ($query) => $query->where('is_active', true), 'images']);

        $input = [[
            'type' => 'text',
            'text' => $this->prompt->render($report),
        ]];

        foreach ($report->images as $image) {
            if (Storage::exists($image->path)) {
                $input[] = [
                    'type' => 'image',
                    'data' => base64_encode(Storage::get($image->path)),
                    'mime_type' => Storage::mimeType($image->path),
                ];
            }
        }

        $response = Http::connectTimeout(5)
            ->timeout(45)
            ->withHeaders([
                'x-goog-api-key' => $apiKey->secret,
                'Api-Revision' => '2026-05-20',
            ])
            ->post('https://generativelanguage.googleapis.com/v1beta/interactions', [
                'model' => $apiKey->modelLimit->model,
                'input' => $input,
                'store' => false,
                'response_format' => [
                    'type' => 'text',
                    'mime_type' => 'application/json',
                    'schema' => $this->schema(),
                ],
            ])
            ->throw()
            ->json();

        $result = json_decode($this->outputText($response), true, flags: JSON_THROW_ON_ERROR);
        $categoryIds = $report->organization->categories->pluck('id');
        $categoryId = $categoryIds->contains($result['category_id'] ?? null) ? $result['category_id'] : null;
        [$inputTokens, $outputTokens] = $this->tokenUsage($response);

        return [
            'refined_description' => (string) ($result['refined_description'] ?? $report->original_description),
            'category_id' => $categoryId,
            'priority' => in_array($result['priority'] ?? null, ['low', 'medium', 'high', 'urgent'], true) ? $result['priority'] : 'medium',
            'reason' => $result['reason'] ?? null,
            'input_tokens' => $inputTokens,
            'output_tokens' => $outputTokens,
            'response' => $response,
        ];
    }

    /**
     * @param  array<string, mixed>  $response
     */
    private function outputText(array $response): string
    {
        foreach (array_reverse($response['steps'] ?? []) as $step) {
            if (($step['type'] ?? null) !== 'model_output') {
                continue;
            }

            foreach ($step['content'] ?? [] as $content) {
                if (($content['type'] ?? null) === 'text' && isset($content['text'])) {
                    return (string) $content['text'];
                }
            }
        }

        throw new UnexpectedValueException('Provider AI tidak mengembalikan keluaran teks.');
    }

    /**
     * @param  array<string, mixed>  $response
     * @return array{int, int}
     */
    private function tokenUsage(array $response): array
    {
        $inputTokens = (int) data_get($response, 'usage.total_input_tokens', 0);
        $outputTokens = (int) data_get($response, 'usage.total_output_tokens', 0);
        $totalTokens = (int) data_get($response, 'usage.total_tokens', $inputTokens + $outputTokens);

        $inputTokens += max(0, $totalTokens - $inputTokens - $outputTokens);

        return [$inputTokens, $outputTokens];
    }

    /** @return array<string, mixed> */
    private function schema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'refined_description' => ['type' => 'string'],
                'category_id' => ['type' => ['string', 'null']],
                'priority' => ['type' => 'string', 'enum' => ['low', 'medium', 'high', 'urgent']],
                'reason' => ['type' => ['string', 'null']],
            ],
            'required' => ['refined_description', 'category_id', 'priority', 'reason'],
        ];
    }
}
