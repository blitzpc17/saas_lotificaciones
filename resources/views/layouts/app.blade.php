<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" x-bind:class="{'dark': darkMode}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Lotificadora') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @php
            $themeVal = tenant() ? (tenant('theme_color') ?? '#4f46e5') : '#0ea5e9';
            $rgb = "79 70 229"; // fallback
            if (str_contains($themeVal, 'rgb')) {
                // Extract numbers from rgb(10, 20, 30) or rgba(...)
                preg_match_all('/\d+/', $themeVal, $matches);
                if (count($matches[0]) >= 3) {
                    $rgb = $matches[0][0] . ' ' . $matches[0][1] . ' ' . $matches[0][2];
                }
            } elseif (str_contains($themeVal, ',')) {
                // Extract from raw "10, 20, 30"
                $parts = explode(',', $themeVal);
                if (count($parts) >= 3) {
                    $rgb = trim($parts[0]) . ' ' . trim($parts[1]) . ' ' . trim($parts[2]);
                }
            } else {
                $hex = ltrim($themeVal, '#');
                if (strlen($hex) == 3) {
                    $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                    $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                    $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                } elseif (strlen($hex) >= 6) {
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                }
                if(isset($r) && isset($g) && isset($b)) {
                    $rgb = "$r $g $b";
                }
            }
        @endphp

        <style>
            :root {
                --color-brand: {{ $rgb }};
            }
        </style>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            brand: 'rgb(var(--color-brand) / <alpha-value>)',
                        }
                    }
                }
            }
        </script>
        <style>
            body { font-family: 'Outfit', sans-serif; }
            /* Custom scrollbar for modern look */
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            .dark ::-webkit-scrollbar-thumb { background: #475569; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
    </head>
    <body class="h-full bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300" x-data="{ sidebarOpen: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" x-init="$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))">
        
        <!-- Sidebar layout -->
        <div class="flex h-screen overflow-hidden">
            
            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <!-- Top Header -->
                <header class="sticky top-0 z-30 flex items-center justify-between px-4 py-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300 lg:hidden focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        

                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode" class="p-2 text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 focus:outline-none transition-colors">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            <svg x-cloak x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </button>

                        <!-- Profile Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 p-1 border border-transparent rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <svg class="fill-current h-4 w-4 text-slate-500 dark:text-slate-400 hidden sm:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Mi Perfil') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
                
            </div>
        </div>
        
        @stack('scripts')
    </body>
</html>
