<?php

namespace App\Services;

class AiSlots
{
    /** @return list<AiSlot> */
    public function all(): array
    {
        return array_values(array_map(
            fn (array $slot): AiSlot => new AiSlot(...$slot),
            config('ai.slots', []),
        ));
    }

    public function hasAny(): bool
    {
        return config('ai.slots', []) !== [];
    }
}
