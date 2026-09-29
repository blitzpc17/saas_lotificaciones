<x-app-layout>
    <div x-data="{ 
        showModal: false, 
        isEdit: false, 
        customerId: null,
        formData: {
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            address: '',
            curp: '',
            rfc: ''
        },
        openCreateModal() {
            this.isEdit = false;
            this.customerId = null;
            this.formData = { first_name: '', last_name: '', email: '', phone: '', address: '', curp: '', rfc: '' };
            this.showModal = true;
        },
        openEditModal(customer) {
            this.isEdit = true;
            this.customerId = customer.id;
            this.formData = {
                first_name: customer.first_name,
                last_name: customer.last_name,
                email: customer.email,
                phone: customer.phone,
                address: customer.address,
                curp: customer.curp,
                rfc: customer.rfc
            };
            this.showModal = true;
        }
    }">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Clientes') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Administra la base de datos de tus compradores.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button @click="openCreateModal()" class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Cliente
            </button>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors duration-200">
                <div class="p-0">
                    
                    @if (session('success'))
                        <div class="m-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="m-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <ul class="text-sm font-medium text-red-800 dark:text-red-200">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <form action="{{ route('customers.index') }}" method="GET" class="relative w-full sm:w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar cliente..." class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre Completo</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contacto</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Identificación</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($customers as $customer)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-brand-100 dark:bg-brand-900/50 flex items-center justify-center text-brand-700 dark:text-brand-300 font-bold text-lg">
                                                    {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $customer->first_name }} {{ $customer->last_name }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $customer->address ?? 'Sin dirección' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                {{ $customer->email ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ $customer->phone ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                CURP: <span class="font-medium">{{ $customer->curp ?? 'N/A' }}</span>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                RFC: <span class="font-medium">{{ $customer->rfc ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="openEditModal({{ json_encode($customer) }})" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 mr-4 transition-colors font-semibold">Editar</button>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors font-semibold">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                <p class="text-lg font-medium text-gray-900 dark:text-white">No hay clientes registrados</p>
                                                <p class="text-gray-500 dark:text-gray-400 mt-1">Comienza agregando los datos de tu primer comprador.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($customers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $customers->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal (Alpine.js) -->
    <div x-cloak x-show="showModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background backdrop -->
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showModal = false"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100 dark:border-slate-700 max-h-[90vh] overflow-y-auto">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-8">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl leading-6 font-bold text-slate-900 dark:text-white" id="modal-title" x-text="isEdit ? 'Editar Cliente' : 'Crear Nuevo Cliente'"></h3>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form :action="isEdit ? '/customers/' + customerId : '{{ route('customers.store') }}'" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('Nombre(s)')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" x-model="formData.first_name" required autofocus />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Apellidos')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" x-model="formData.last_name" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Correo Electrónico')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" x-model="formData.email" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Teléfono')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" x-model="formData.phone" />
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <x-input-label for="address" :value="__('Dirección Completa')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" x-model="formData.address" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- CURP -->
                            <div>
                                <x-input-label for="curp" :value="__('CURP')" />
                                <x-text-input id="curp" class="block mt-1 w-full" type="text" name="curp" x-model="formData.curp" />
                            </div>

                            <!-- RFC -->
                            <div>
                                <x-input-label for="rfc" :value="__('RFC')" />
                                <x-text-input id="rfc" class="block mt-1 w-full" type="text" name="rfc" x-model="formData.rfc" />
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-600 text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Guardar Cliente
                            </button>
                            <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    </div> <!-- End x-data -->
</x-app-layout>
