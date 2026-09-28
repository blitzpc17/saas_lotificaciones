<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';

});

// TENANT API ROUTES
Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api')->group(function () {

    // Aquí irán las rutas de la API (móvil/escritorio)
    Route::get('/ping', function () {
        return response()->json(['message' => 'Tenant API is working!', 'tenant' => tenant('id')]);
    });

    Route::apiResource('developments', \App\Http\Controllers\Api\DevelopmentController::class);
    Route::apiResource('lots', \App\Http\Controllers\Api\LotController::class);
    Route::apiResource('customers', \App\Http\Controllers\Api\CustomerController::class);
    Route::apiResource('contracts', \App\Http\Controllers\Api\ContractController::class);
    Route::apiResource('payments', \App\Http\Controllers\Api\PaymentController::class);

});
