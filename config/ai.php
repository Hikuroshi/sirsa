<?php

use App\Services\Providers\GeminiAiProvider;

$providers = [
    'gemini' => [
        'class' => GeminiAiProvider::class,
    ],
];

$numbers = [];

foreach (array_keys(array_merge($_SERVER, $_ENV)) as $variable) {
    if (preg_match('/^AI_([1-9][0-9]*)_(NAME|PROVIDER|MODEL|KEY|RPM|RPD|TPM)$/', $variable, $matches)) {
        $numbers[(int) $matches[1]] = true;
    }
}

ksort($numbers, SORT_NUMERIC);
$slots = [];
$warnings = [];

foreach (array_keys($numbers) as $number) {
    $values = [];
    $invalid = [];

    foreach (['NAME', 'PROVIDER', 'MODEL', 'KEY', 'RPM', 'RPD', 'TPM'] as $field) {
        $value = env("AI_{$number}_{$field}");
        $values[strtolower($field)] = is_string($value) ? trim($value) : $value;

        if ($values[strtolower($field)] === null || $values[strtolower($field)] === '' || (in_array($field, ['NAME', 'PROVIDER', 'MODEL', 'KEY'], true) && ! is_string($values[strtolower($field)]))) {
            $invalid[] = $field;
        }
    }

    if (! is_string($values['provider']) || ! array_key_exists($values['provider'], $providers)) {
        $invalid[] = 'PROVIDER';
    }

    foreach (['rpm', 'rpd', 'tpm'] as $limit) {
        if (filter_var($values[$limit], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            $invalid[] = strtoupper($limit);
        }
    }

    if ($invalid !== []) {
        $warnings[] = "Slot AI_{$number} diabaikan: ".implode(', ', array_unique($invalid));

        continue;
    }

    $slots[$number] = [
        'number' => $number,
        'name' => $values['name'],
        'provider' => $values['provider'],
        'model' => $values['model'],
        'key' => $values['key'],
        'rpm' => (int) $values['rpm'],
        'rpd' => (int) $values['rpd'],
        'tpm' => (int) $values['tpm'],
    ];
}

return [
    'providers' => $providers,
    'slots' => $slots,
    'warnings' => $warnings,
];
