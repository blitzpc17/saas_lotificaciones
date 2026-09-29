<?php

use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains', ['localhost']) as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function() {
            return redirect('/login');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', function () {
                $tenants = \App\Models\Tenant::with('domains')->get();
                return view('central', compact('tenants'));
            })->name('dashboard'); // Name it dashboard so Breeze redirects correctly
            
            // Alias for backward compatibility if needed in central view
            Route::get('/central', function() {
                return redirect()->route('dashboard');
            })->name('central.dashboard');

            Route::post('/tenants', function (\Illuminate\Http\Request $request) {
                $request->validate([
                    'id' => 'required|string|unique:tenants,id',
                    'domain' => 'required|string|unique:domains,domain',
                    'company' => 'required|string',
                ]);

                $tenant = \App\Models\Tenant::create([
                    'id' => $request->id,
                    'company' => $request->company,
                ]);

                $tenant->domains()->create([
                    'domain' => $request->domain . '.localhost', // Adjust based on env
                ]);

                return redirect()->route('dashboard')->with('success', 'Inmobiliaria (Tenant) creada exitosamente. Dominio: ' . $request->domain . '.localhost');
            })->name('central.tenants.store');

            Route::delete('/tenants/{tenant}', function (\App\Models\Tenant $tenant) {
                $tenant->delete();
                return redirect()->route('dashboard')->with('success', 'Inmobiliaria (Tenant) eliminada.');
            })->name('central.tenants.destroy');

            Route::get('/run-seeder', function () {
                \Illuminate\Support\Facades\Artisan::call('tenants:seed', ['--class' => 'TenantRoleSeeder']);
                return "Seeder ejecutado con éxito! Los roles han sido creados en todos los tenants.";
            });
        });

        Route::get('/run-central-migrations', function () {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return "Migraciones centrales ejecutadas con éxito. Ya puedes ir a /setup-super-admin";
        });

        Route::get('/setup-super-admin', function () {
            \App\Models\User::firstOrCreate(
                ['email' => 'admin@lotificadora.com'],
                [
                    'name' => 'Super Administrador',
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                ]
            );
            return "¡Super Admin creado! Correo: admin@lotificadora.com | Contraseña: password123. Ve a /login";
        });

        Route::get('/login', function () {
            return view('auth.login');
        })->name('central.login')->middleware('guest');

        Route::post('/login', function (\Illuminate\Http\Request $request) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('email');
        });

        Route::post('/logout', function (\Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        })->name('central.logout');
    });
}
