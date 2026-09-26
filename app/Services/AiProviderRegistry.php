<?php

namespace App\Services;

use App\Contracts\AiProvider;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class AiProviderRegistry
{
    public function __construct(private Container $container) {}

    /** @return array<string, string> */
    public function options(): array
    {
        return collect(config('ai.providers', []))
            ->mapWithKeys(fn (array $provider, string $key): array => [$key => $provider['label']])
            ->all();
    }

    public function supports(string $provider): bool
    {
        return array_key_exists($provider, config('ai.providers', []));
    }

    public function resolve(string $provider): AiProvider
    {
        $providerClass = config("ai.providers.{$provider}.class");

        if (! is_string($providerClass) || ! is_a($providerClass, AiProvider::class, true)) {
            throw new InvalidArgumentException("Provider AI [{$provider}] tidak didukung.");
        }

        return $this->container->make($providerClass);
    }
}
