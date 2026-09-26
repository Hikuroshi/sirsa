<?php

use App\Http\Controllers\AiApiKeyController;
use App\Http\Controllers\AiModelLimitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/o/{organization:slug}/lapor', [PublicReportController::class, 'create'])->name('public-reports.create');
Route::post('/o/{organization:slug}/lapor', [PublicReportController::class, 'store'])->middleware('throttle:10,1')->name('public-reports.store');
Route::get('/laporan/{trackingCode}', [PublicReportController::class, 'track'])->name('reports.track');

Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->middleware('throttle:login')->name('authenticate');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('register.store');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->names('user');
    Route::resource('organizations', OrganizationController::class);
    Route::resource('categories', CategoryController::class);

    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::put('{report}', [ReportController::class, 'update'])->name('reports.update');
    });

    Route::resource('ai-keys', AiApiKeyController::class);
    Route::resource('ai-model-limits', AiModelLimitController::class);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
