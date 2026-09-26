<?php

namespace App\Enums;

enum AiStatus: string
{
    case Disabled = 'disabled';
    case Queued = 'queued';
    case Processing = 'processing';
    case Completed = 'completed';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Disabled => 'Tidak Aktif',
            self::Queued => 'Antre',
            self::Processing => 'Diproses',
            self::Completed => 'Selesai',
            self::Failed => 'Gagal',
            self::Cancelled => 'Dibatalkan',
        };
    }
}
