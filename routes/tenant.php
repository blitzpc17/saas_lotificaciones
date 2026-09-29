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
        return redirect()->route('login');
    });

    Route::get('/setup-admin', function () {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@inmobiliaria.com'],
            [
                'name' => 'Administrador Principal',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]
        );
        $user->assignRole('admin');
        return "¡Usuario administrador creado! Correo: admin@inmobiliaria.com | Contraseña: password123. Ya puedes ir a /login";
    });

    Route::get('/dashboard', function () {
        $metrics = [
            'total_customers' => \App\Models\Customer::count(),
            'total_sales' => \App\Models\Contract::whereIn('status', ['active', 'completed'])->sum('total_amount'),
            'total_collected' => \App\Models\Payment::where('status', 'paid')->sum('amount'),
            'lots_available' => \App\Models\Lot::where('status', 'available')->count(),
            'lots_sold' => \App\Models\Lot::where('status', 'sold')->count(),
            'recent_payments' => \App\Models\Payment::with(['contract.customer'])->latest()->take(5)->get(),
        ];

        // Chart Data: Last 6 months of payments
        $months = collect();
        $chartData = [
            'labels' => [],
            'data' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M y'); // e.g., 'Ene 24'
            
            $total = \App\Models\Payment::where('status', 'paid')
                                        ->whereYear('paid_date', $date->year)
                                        ->whereMonth('paid_date', $date->month)
                                        ->sum('amount');

            $chartData['labels'][] = ucfirst($monthName);
            $chartData['data'][] = $total;
        }

        return view('dashboard', compact('metrics', 'chartData'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('developments', \App\Http\Controllers\DevelopmentController::class)->except(['show']);
        Route::resource('lots', \App\Http\Controllers\LotController::class)->except(['show']);
        Route::resource('customers', \App\Http\Controllers\CustomerController::class)->except(['show']);
        Route::resource('contracts', \App\Http\Controllers\ContractController::class);
        Route::resource('payments', \App\Http\Controllers\PaymentController::class)->except(['show']);
        
        // Users (Admins only, but we'll protect this later via middleware, or they can just use it for now)
        Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show']);
        
        // Tenant Settings (Customization)
        Route::get('/settings', function () {
            return view('settings.index');
        })->name('settings.index');

        Route::post('/settings', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'login_image' => 'nullable|image|max:5120',
                'logo_image' => 'nullable|image|max:2048',
                'theme_color' => 'nullable|string|max:25',
                'company_name' => 'nullable|string|max:255',
            ]);

            $tenant = tenant();
            $data = [
                'theme_color' => $request->theme_color,
                'company' => $request->company_name,
            ];

            if ($request->hasFile('login_image')) {
                $file = $request->file('login_image');
                $filename = 'login_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/tenants/' . $tenant->id), $filename);
                $data['login_image'] = '/uploads/tenants/' . $tenant->id . '/' . $filename;
            }

            if ($request->hasFile('logo_image')) {
                $file = $request->file('logo_image');
                $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/tenants/' . $tenant->id), $filename);
                $data['logo_image'] = '/uploads/tenants/' . $tenant->id . '/' . $filename;
            }

            $tenant->update($data);

            return back()->with('success', 'Configuración actualizada exitosamente.');
        })->name('settings.update');
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
