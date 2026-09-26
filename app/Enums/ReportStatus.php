<?php

namespace App\Enums;

enum ReportStatus: string
{
    case Accepted = 'accepted';
    case Processing = 'processing';
    case Completed = 'completed';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Accepted => 'Diterima',
            self::Processing => 'Diproses',
            self::Completed => 'Selesai',
            self::Rejected => 'Ditolak',
        };
    }

    /** @return list<self> */
    public function transitions(): array
    {
        return match ($this) {
            self::Accepted => [self::Processing, self::Rejected],
            self::Processing => [self::Completed, self::Rejected],
            self::Completed, self::Rejected => [],
        };
    }
}
