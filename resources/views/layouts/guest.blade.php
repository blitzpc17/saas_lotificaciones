@if(tenant())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ tenant('company') ?? config('app.name', 'SaaS Lotificaciones') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            gold: { 400: '#D4AF37', 500: '#C5A017', 600: '#AA8811' },
                            charcoal: { 800: '#1A1C20', 900: '#111215' }
                        }
                    }
                }
            }
        </script>
        <style>
            .glass-form {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .bg-architecture {
                background-image: url('{{ tenant('login_image') ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop' }}');
                background-size: cover;
                background-position: center;
            }
            .dynamic-bg { background-color: {{ tenant('theme_color') ?? '#C5A017' }} !important; }
            .dynamic-text { color: {{ tenant('theme_color') ?? '#D4AF37' }} !important; }
            .dynamic-border { border-color: {{ tenant('theme_color') ?? '#C5A017' }} !important; }
            .dynamic-ring:focus { --tw-ring-color: {{ tenant('theme_color') ?? '#C5A017' }} !important; }
        </style>
    </head>
    <body class="h-full font-sans text-slate-800 flex overflow-hidden bg-slate-100">
        
        <div class="hidden lg:flex lg:w-1/2 relative bg-architecture items-end p-12">
            <div class="absolute inset-0 bg-gradient-to-t from-charcoal-900/90 via-charcoal-900/40 to-transparent"></div>
            <div class="relative z-10 w-full max-w-xl">
                <div class="w-16 h-16 dynamic-bg rounded-xl flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    El futuro del <span class="dynamic-text">desarrollo inmobiliario</span>
                </h1>
                <p class="text-slate-300 text-lg">
                    Gestión integral de lotificaciones, contratos, clientes y cobranza en una sola plataforma diseñada para la excelencia.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white relative">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgMjAgMTAgTSAxMCAwIEwgMTAgMjAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgwLDAsMCwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIwLjUiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-50"></div>
            
            <div class="w-full max-w-md relative z-10 glass-form p-8 sm:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
                <div class="flex lg:hidden flex-col items-center mb-8">
                    <div class="w-14 h-14 dynamic-bg rounded-xl flex items-center justify-center shadow-lg mb-3">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-charcoal-900 tracking-tight">{{ tenant('company') ?? 'Lotificadora SaaS' }}</h2>
                </div>

                {{ $slot }}
                
                <p class="text-center text-slate-400 text-xs mt-10">
                    &copy; {{ date('Y') }} {{ tenant('company') ?? 'Lotificadora SaaS' }}. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </body>
</html>
@else
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0a0a0e] antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Super Admin | Master Control</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            mono: ['JetBrains Mono', 'monospace'],
                        },
                        colors: {
                            brand: {
                                400: '#38bdf8', // Light blue
                                500: '#0ea5e9',
                                600: '#0284c7',
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            .dynamic-bg { background-color: #0ea5e9 !important; }
            .dynamic-text { color: #0ea5e9 !important; }
            .dynamic-border { border-color: #0ea5e9 !important; }
            .dynamic-ring:focus { --tw-ring-color: #0ea5e9 !important; }
            .cyber-grid {
                background-size: 40px 40px;
                background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            }
        </style>
    </head>
    <body class="h-full font-sans text-slate-300 flex items-center justify-center overflow-hidden relative bg-[#0a0a0e]">
        
        <!-- Animated Tech Background -->
        <div class="absolute inset-0 z-0 cyber-grid">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-500 rounded-full mix-blend-screen filter blur-[120px] opacity-10"></div>
        </div>

        <div class="z-10 w-full max-w-md px-6 py-12">
            <div class="flex flex-col items-center mb-10">
                <div class="w-16 h-16 bg-[#13131a] border border-slate-800 rounded-2xl flex items-center justify-center shadow-2xl mb-5 relative group">
                    <div class="absolute inset-0 bg-brand-500 opacity-20 rounded-2xl blur group-hover:opacity-40 transition-opacity"></div>
                    <svg class="w-8 h-8 text-brand-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-white font-mono">SYSTEM.<span class="text-brand-400">CORE</span></h1>
                <p class="text-slate-500 text-sm mt-2 font-mono tracking-widest uppercase">Master Control Node</p>
            </div>

            <div class="bg-[#0f1117]/90 backdrop-blur-2xl border border-slate-700/50 rounded-3xl shadow-[0_0_40px_rgba(14,165,233,0.15)] p-8 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-brand-500 to-transparent opacity-50"></div>
                
                <!-- CSS overrides for the shared login view to give it the Cyber aesthetic -->
                <style>
                    /* Typography overrides */
                    h2 { color: #f8fafc !important; font-family: 'JetBrains Mono', monospace !important; font-weight: 700 !important; }
                    h2 + p { color: #94a3b8 !important; font-family: 'JetBrains Mono', monospace !important; font-size: 0.875rem !important; }
                    label.text-charcoal-800 { color: #cbd5e1 !important; font-family: 'JetBrains Mono', monospace !important; font-size: 0.75rem !important; text-transform: uppercase; letter-spacing: 0.05em; }
                    
                    /* Input fields */
                    input[type="email"], input[type="password"] {
                        background-color: rgba(15, 23, 30, 0.8) !important;
                        border: 1px solid rgba(56, 189, 248, 0.2) !important;
                        color: #e2e8f0 !important;
                        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2) !important;
                        border-radius: 0.75rem !important;
                        transition: all 0.3s ease !important;
                        font-family: 'JetBrains Mono', monospace !important;
                    }
                    input[type="email"]:focus, input[type="password"]:focus {
                        border-color: #38bdf8 !important;
                        box-shadow: 0 0 15px rgba(56, 189, 248, 0.2), inset 0 2px 4px 0 rgba(0, 0, 0, 0.2) !important;
                        background-color: rgba(15, 23, 30, 0.95) !important;
                    }
                    /* Icons inside inputs */
                    .absolute.inset-y-0 svg {
                        color: #0ea5e9 !important;
                        opacity: 0.8;
                    }
                    
                    /* Submit Button */
                    button[type="submit"] {
                        background: linear-gradient(135deg, #0284c7, #0369a1) !important;
                        border: 1px solid rgba(56, 189, 248, 0.5) !important;
                        box-shadow: 0 4px 20px rgba(2, 132, 199, 0.4), inset 0 1px 0 rgba(255,255,255,0.1) !important;
                        color: #ffffff !important;
                        font-family: 'JetBrains Mono', monospace !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.1em !important;
                        border-radius: 0.75rem !important;
                        position: relative;
                        overflow: hidden;
                        transition: all 0.3s ease;
                    }
                    button[type="submit"]:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 6px 25px rgba(2, 132, 199, 0.6), inset 0 1px 0 rgba(255,255,255,0.2) !important;
                        background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
                    }
                    
                    /* Checkbox & Links */
                    input[type="checkbox"] {
                        background-color: rgba(15, 23, 30, 0.8) !important;
                        border: 1px solid rgba(56, 189, 248, 0.4) !important;
                        border-radius: 0.25rem !important;
                    }
                    input[type="checkbox"]:checked {
                        background-color: #0ea5e9 !important;
                        border-color: #0ea5e9 !important;
                    }
                    label[for="remember_me"] {
                        color: #94a3b8 !important;
                        font-family: 'JetBrains Mono', monospace !important;
                        font-size: 0.75rem !important;
                    }
                    a {
                        color: #38bdf8 !important;
                        font-family: 'JetBrains Mono', monospace !important;
                        font-size: 0.75rem !important;
                        text-decoration: none !important;
                        transition: all 0.2s ease;
                    }
                    a:hover {
                        color: #7dd3fc !important;
                        text-shadow: 0 0 8px rgba(56, 189, 248, 0.6);
                    }
                </style>
                {{ $slot }}
            </div>
            
            <p class="text-center text-slate-600 font-mono text-xs mt-8">
                SECURE CONNECTION ESTABLISHED
            </p>
        </div>
    </body>
</html>
@endif
