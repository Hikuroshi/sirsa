<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Blaze\Blaze;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request): Limit {
            $login = Str::transliterate(Str::lower($request->string('login')->toString()));

            return Limit::perMinute(5)->by("login:{$login}|{$request->ip()}");
        });

        Blaze::optimize()->in(resource_path('views/components'));
    }
}
