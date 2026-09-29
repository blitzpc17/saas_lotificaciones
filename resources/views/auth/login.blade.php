<x-guest-layout>
    <div class="mb-8 text-center lg:text-left">
        <h2 class="text-3xl font-bold text-charcoal-900 mb-2">Bienvenido de nuevo</h2>
        <p class="text-slate-500">Ingresa tus credenciales para continuar</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-6 text-sm font-medium text-emerald-600 bg-emerald-50 p-4 rounded-xl border border-emerald-100">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-charcoal-800 mb-1.5">Correo Electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-charcoal-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:dynamic-ring focus:dynamic-border sm:text-sm transition-all"
                    placeholder="ejemplo@correo.com">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-charcoal-800 mb-1.5">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-charcoal-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:dynamic-ring focus:dynamic-border sm:text-sm transition-all"
                    placeholder="••••••••">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 bg-slate-50 border-slate-300 rounded dynamic-text focus:dynamic-ring transition-colors cursor-pointer" style="color: {{ tenant('theme_color') ?? '#C5A017' }};">
                <label for="remember_me" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">
                    Recordarme
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium dynamic-text hover:opacity-80 transition-opacity">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white dynamic-bg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:dynamic-ring transition-all transform hover:-translate-y-0.5">
                Iniciar Sesión
            </button>
        </div>
    </form>
</x-guest-layout>
