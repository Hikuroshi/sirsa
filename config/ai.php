<?php

use App\Services\Providers\GeminiAiProvider;

return [
    'providers' => [
        'gemini' => [
            'label' => 'Gemini',
            'class' => GeminiAiProvider::class,
        ],
    ],
];
