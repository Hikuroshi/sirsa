<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiKeyState extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'cooldown_until', 'failure_count', 'last_used_at', 'last_error'];

    protected function casts(): array
    {
        return [
            'cooldown_until' => 'datetime',
            'last_used_at' => 'datetime',
        ];
    }
}
