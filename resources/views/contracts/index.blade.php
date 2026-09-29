<x-app-layout>
    <div x-data="{ 
        showModal: false, 
        isEdit: false, 
        contractId: null,
        formData: {
            customer_id: '',
            lot_id: '',
            total_amount: '',
            down_payment: '',
            monthly_payment: '',
            total_months: '',
            start_date: '',
            status: 'active'
        },
        openCreateModal() {
            this.isEdit = false;
            this.contractId = null;
            this.formData = { customer_id: '', lot_id: '', total_amount: '', down_payment: '', monthly_payment: '', total_months: '', start_date: '', status: 'active' };
            this.showModal = true;
        },
        openEditModal(contract) {
            this.isEdit = true;
            this.contractId = contract.id;
            this.formData = {
                customer_id: contract.customer_id,
                lot_id: contract.lot_id,
                total_amount: contract.total_amount,
                down_payment: contract.down_payment,
                monthly_payment: contract.monthly_payment,
                total_months: contract.total_months,
                start_date: contract.start_date.split(' ')[0], // just the date part
                status: contract.status
            };
            this.showModal = true;
        }
    }">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Contratos') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestiona las ventas y los acuerdos comerciales.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button @click="openCreateModal()" class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Contrato
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
                        <form action="{{ route('contracts.index') }}" method="GET" class="relative w-full sm:w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por cliente, lote, estado..." class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lote Adquirido</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Monto Total</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plazo</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($contracts as $contract)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $contract->customer->first_name }} {{ $contract->customer->last_name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Inicio: {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                Desarrollo: <span class="font-medium text-gray-900 dark:text-white">{{ $contract->lot->development->name }}</span>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                M.{{ $contract->lot->block }} L.{{ $contract->lot->lot_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-bold text-green-600 dark:text-green-400">
                                                ${{ number_format($contract->total_amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Enganche: ${{ number_format($contract->down_payment, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $contract->total_months }} meses</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">${{ number_format($contract->monthly_payment, 2) }}/mes</div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            @if($contract->status === 'active')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">Activo</span>
                                            @elseif($contract->status === 'completed')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200">Completado</span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200">Cancelado</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('contracts.show', $contract) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mr-4 transition-colors font-semibold">Amortización</a>
                                            <button @click="openEditModal({{ json_encode($contract) }})" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 mr-4 transition-colors font-semibold">Editar</button>
                                            <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este contrato?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors font-semibold">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-lg font-medium text-gray-900 dark:text-white">No hay contratos registrados</p>
                                                <p class="text-gray-500 dark:text-gray-400 mt-1">Registra tu primera venta creando un contrato.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contracts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $contracts->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal (Alpine.js) -->
    <div x-cloak x-show="showModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full border border-slate-100 dark:border-slate-700 max-h-[90vh] overflow-y-auto">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-8">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl leading-6 font-bold text-slate-900 dark:text-white" id="modal-title" x-text="isEdit ? 'Editar Contrato' : 'Crear Nuevo Contrato'"></h3>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form :action="isEdit ? '/contracts/' + contractId : '{{ route('contracts.store') }}'" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Customer -->
                            <div>
                                <x-input-label for="customer_id" :value="__('Cliente')" />
                                <select id="customer_id" name="customer_id" x-model="formData.customer_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Selecciona un cliente</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lot -->
                            <div>
                                <x-input-label for="lot_id" :value="__('Lote a Vender')" />
                                <select id="lot_id" name="lot_id" x-model="formData.lot_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">Selecciona un lote</option>
                                    @foreach($lots as $lot)
                                        <option value="{{ $lot->id }}">
                                            {{ $lot->development->name }} - Mz.{{ $lot->block }} Lt.{{ $lot->lot_number }} 
                                            @if($lot->status != 'available') ({{ ucfirst($lot->status) }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Total Amount -->
                            <div>
                                <x-input-label for="total_amount" :value="__('Monto Total ($)')" />
                                <x-text-input id="total_amount" class="block mt-1 w-full" type="number" step="0.01" name="total_amount" x-model="formData.total_amount" required />
                            </div>

                            <!-- Down Payment -->
                            <div>
                                <x-input-label for="down_payment" :value="__('Enganche ($)')" />
                                <x-text-input id="down_payment" class="block mt-1 w-full" type="number" step="0.01" name="down_payment" x-model="formData.down_payment" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Monthly Payment -->
                            <div>
                                <x-input-label for="monthly_payment" :value="__('Mensualidad ($)')" />
                                <x-text-input id="monthly_payment" class="block mt-1 w-full" type="number" step="0.01" name="monthly_payment" x-model="formData.monthly_payment" required />
                            </div>

                            <!-- Total Months -->
                            <div>
                                <x-input-label for="total_months" :value="__('Plazo (Meses)')" />
                                <x-text-input id="total_months" class="block mt-1 w-full" type="number" name="total_months" x-model="formData.total_months" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" :value="__('Fecha de Inicio')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" x-model="formData.start_date" required />
                            </div>

                            <!-- Status -->
                            <div x-show="isEdit">
                                <x-input-label for="status" :value="__('Estado del Contrato')" />
                                <select id="status" name="status" x-model="formData.status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="active">Activo</option>
                                    <option value="completed">Completado</option>
                                    <option value="cancelled">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <!-- Notice -->
                        <div x-show="!isEdit" class="mb-4 bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg flex items-start">
                            <svg class="h-5 w-5 text-blue-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-blue-800 dark:text-blue-200">Al crear el contrato, se generará automáticamente la tabla de amortización y el lote pasará a estado Vendido.</p>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-600 text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Guardar Contrato
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
