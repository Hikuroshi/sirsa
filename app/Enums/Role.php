<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Reporter = 'reporter';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Reporter => 'Pelapor',
        };
    }
}
