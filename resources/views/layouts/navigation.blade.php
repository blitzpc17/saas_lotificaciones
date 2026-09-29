<!-- Sidebar Backdrop (Mobile) -->
<div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-20 transition-opacity bg-slate-900 bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

<!-- Sidebar Component -->
<div x-cloak x-bind:class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', sidebarCollapsed ? 'w-20' : 'w-64']" class="fixed inset-y-0 left-0 z-30 overflow-y-auto transition-all duration-300 transform bg-slate-900 border-r border-slate-800 lg:translate-x-0 lg:static lg:inset-0 shadow-xl flex flex-col">
    
    <!-- Logo -->
    <div class="flex items-center justify-between mt-6 px-4 h-12">
        <div class="flex items-center space-x-3 overflow-hidden" x-bind:class="sidebarCollapsed ? 'justify-center w-full space-x-0' : ''">
            @if(tenant('logo_image'))
                <img src="{{ tenant('logo_image') }}" alt="Logo" class="flex-shrink-0 h-10 w-auto object-contain drop-shadow-md" x-bind:class="sidebarCollapsed ? 'max-w-[40px]' : 'max-w-[56px]'">
            @else
                <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shadow-lg" style="background-color: rgb(var(--color-brand))">
                    {{ substr(tenant('company') ?? 'L', 0, 1) }}
                </div>
            @endif
            
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms class="text-xl font-bold text-white tracking-tight truncate">{{ tenant('company') ?? 'Lotificadora' }}</span>
        </div>
        <!-- Toggle compress button (only visible on large screens) -->
        <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:block text-slate-400 hover:text-white focus:outline-none" x-show="!sidebarCollapsed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
        </button>
    </div>

    <!-- Re-open button when collapsed -->
    <div class="hidden lg:flex items-center justify-center mt-4" x-show="sidebarCollapsed">
        <button @click="sidebarCollapsed = false" class="text-slate-400 hover:text-white focus:outline-none p-2 rounded-lg hover:bg-slate-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-8 px-3 space-y-2 flex-1">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
            <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Dashboard') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('developments.index')" :active="request()->routeIs('developments.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
            <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Desarrollos') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('lots.index')" :active="request()->routeIs('lots.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
            <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Lotes') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
            <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Clientes') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
            <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Contratos') }}</span>
        </x-nav-link>

        <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
            <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Pagos') }}</span>
        </x-nav-link>

        @role('admin')
        <div class="pt-4 mt-4 border-t border-slate-800">
            <p x-show="!sidebarCollapsed" class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Administración</p>
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
                <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Usuarios') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')" class="flex items-center py-3 text-sm font-medium transition-colors rounded-lg group" x-bind:class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
                <svg class="w-6 h-6 transition-colors" x-bind:class="sidebarCollapsed ? '' : 'mr-3'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>{{ __('Configuración') }}</span>
            </x-nav-link>
        </div>
        @endrole
    </nav>
</div>
