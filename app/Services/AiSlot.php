<?php

namespace App\Services;

final readonly class AiSlot
{
    public function __construct(
        public int $number,
        public string $name,
        public string $provider,
        public string $model,
        public string $key,
        public int $rpm,
        public int $rpd,
        public int $tpm,
    ) {}

    public function id(): string
    {
        return hash('sha256', implode("\0", [$this->provider, $this->model, $this->key]));
    }
}
