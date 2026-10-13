<?php

use App\Models\AiUsageBucket;
use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:work --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('model:prune', ['--model' => [AiUsageBucket::class]])
    ->daily()
    ->withoutOverlapping();
