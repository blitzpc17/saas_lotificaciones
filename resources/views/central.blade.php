<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin | Lotificadora SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="h-full text-slate-100 flex overflow-hidden">

    <!-- Sidebar -->
    <div class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="text-xl font-bold tracking-wide text-brand-500">SaaS<span class="text-white">Admin</span></span>
            </div>
            <div class="p-4">
                <a href="#" class="flex items-center px-4 py-3 bg-brand-600/10 text-brand-400 rounded-lg font-medium">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    Inmobiliarias
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 rounded-lg font-medium mt-2 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
                    Configuración
                </a>
            </div>
        </div>
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center font-bold text-sm">SA</div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Super Admin</p>
                    <p class="text-xs text-slate-500">admin@saas.com</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto bg-slate-900 relative">
        <!-- Glow effect -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-brand-600/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="p-8 relative z-10 max-w-6xl mx-auto" x-data="{ showModal: false }">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Inmobiliarias (Tenants)</h1>
                    <p class="text-slate-400 mt-1">Gestiona las instancias y clientes del sistema SaaS.</p>
                </div>
                <button @click="showModal = true" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-lg font-medium shadow-lg shadow-brand-500/30 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Tenant
                </button>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Cards / Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tenants as $tenant)
                <div class="bg-slate-800/50 border border-slate-700/50 p-6 rounded-2xl hover:border-brand-500/50 transition group relative overflow-hidden backdrop-blur-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-brand-500/10 text-brand-400 rounded-xl flex items-center justify-center font-bold text-xl border border-brand-500/20">
                            {{ substr($tenant->company ?? $tenant->id, 0, 1) }}
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-semibold rounded-full border border-emerald-500/20">Activo</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $tenant->company ?? 'Sin nombre' }}</h3>
                    <p class="text-slate-400 text-sm mb-4">ID: {{ $tenant->id }}</p>
                    
                    <div class="space-y-2 mb-6">
                        @foreach($tenant->domains as $domain)
                        <div class="flex items-center text-sm text-slate-300">
                            <svg class="w-4 h-4 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                            <a href="http://{{ $domain->domain }}:8080" target="_blank" class="hover:text-brand-400 hover:underline">{{ $domain->domain }}</a>
                        </div>
                        @endforeach
                        <div class="flex items-center text-sm text-slate-300">
                            <svg class="w-4 h-4 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Creado: {{ $tenant->created_at->format('d M Y') }}
                        </div>
                    </div>

                    <div class="flex space-x-3 mt-auto">
                        <a href="http://{{ $tenant->domains->first()?->domain }}:8080" target="_blank" class="flex-1 bg-slate-700/50 hover:bg-slate-700 text-white text-center py-2 rounded-lg text-sm font-medium transition border border-slate-600/50">Visitar</a>
                        <form action="{{ route('central.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('¿Eliminar este tenant y su base de datos por completo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 flex items-center justify-center rounded-lg transition border border-rose-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-slate-800/30 border border-slate-700/50 rounded-2xl border-dashed">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-1">Sin inmobiliarias</h3>
                    <p class="text-slate-400">Comienza creando tu primer tenant (cliente).</p>
                    <button @click="showModal = true" class="mt-4 px-4 py-2 bg-brand-600/10 text-brand-400 hover:bg-brand-600 hover:text-white rounded-lg font-medium transition-colors">
                        Crear Tenant
                    </button>
                </div>
                @endforelse
            </div>

            <!-- Create Modal -->
            <div x-cloak x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" aria-hidden="true" @click="showModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    
                    <div x-show="showModal" x-transition.scale.origin.bottom class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-slate-800 border border-slate-700 rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div class="flex justify-between items-start mb-5">
                            <h3 class="text-xl font-bold text-white" id="modal-title">Crear Nuevo Tenant</h3>
                            <button @click="showModal = false" class="text-slate-400 hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        
                        <form action="{{ route('central.tenants.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-1">ID (Nombre corto)</label>
                                    <input type="text" name="id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition" placeholder="ej: miproyecto">
                                    <p class="text-xs text-slate-500 mt-1">Usado internamente para la BD y nombre del inquilino.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-1">Nombre de la Empresa</label>
                                    <input type="text" name="company" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition" placeholder="ej: Mi Inmobiliaria S.A. de C.V.">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-1">Subdominio</label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <input type="text" name="domain" required class="flex-1 min-w-0 block w-full px-4 py-2.5 rounded-none rounded-l-lg bg-slate-900 border border-slate-700 text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition" placeholder="miproyecto">
                                        <span class="inline-flex items-center px-4 rounded-r-lg border border-l-0 border-slate-700 bg-slate-800 text-slate-400 text-sm">
                                            .localhost
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end space-x-3">
                                <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition">Cancelar</button>
                                <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-lg font-medium shadow-lg shadow-brand-500/30 transition">Crear e Inicializar DB</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
