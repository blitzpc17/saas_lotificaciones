<x-app-layout>
    <div x-data="{ 
        showModal: false, 
        isEdit: false, 
        paymentId: null,
        contracts: {{ Js::from($contracts) }},
        availableInstallments: [],
        formData: {
            contract_id: '',
            installment_id: '',
            amount: '',
            payment_date: '{{ date('Y-m-d') }}',
            payment_method: 'transfer',
            reference: '',
            notes: ''
        },
        updateInstallments() {
            let selectedContract = this.contracts.find(c => c.id == this.formData.contract_id);
            if (selectedContract) {
                this.availableInstallments = selectedContract.installments;
                if(this.availableInstallments.length > 0 && !this.isEdit) {
                    this.formData.installment_id = this.availableInstallments[0].id;
                    this.formData.amount = this.availableInstallments[0].total_amount - this.availableInstallments[0].paid_amount;
                }
            } else {
                this.availableInstallments = [];
                this.formData.installment_id = '';
            }
        },
        openCreateModal() {
            this.isEdit = false;
            this.paymentId = null;
            this.formData = { 
                contract_id: '', 
                installment_id: '', 
                amount: '', 
                payment_date: '{{ date('Y-m-d') }}', 
                payment_method: 'transfer', 
                reference: '', 
                notes: '' 
            };
            this.availableInstallments = [];
            this.showModal = true;
        },
        openEditModal(payment) {
            this.isEdit = true;
            this.paymentId = payment.id;
            this.formData = {
                contract_id: payment.contract_id,
                installment_id: payment.installment_id || '',
                amount: payment.amount,
                payment_date: payment.payment_date.split(' ')[0],
                payment_method: payment.payment_method,
                reference: payment.reference || '',
                notes: payment.notes || ''
            };
            this.updateInstallments();
            this.showModal = true;
        }
    }">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Pagos') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Registra y controla los abonos de tus clientes.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button @click="openCreateModal()" class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Pago
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
                        <form action="{{ route('payments.index') }}" method="GET" class="relative w-full sm:w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por referencia, cliente..." class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha / Ref</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente y Lote</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Monto</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Método</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($payments as $payment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ref: <span class="font-mono">{{ $payment->reference ?? 'N/A' }}</span></div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white font-medium">
                                                {{ $payment->contract->customer->first_name }} {{ $payment->contract->customer->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Mz.{{ $payment->contract->lot->block }} Lt.{{ $payment->contract->lot->lot_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-bold text-green-600 dark:text-green-400">
                                                ${{ number_format($payment->amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 capitalize">
                                                {{ $payment->payment_method }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="openEditModal({{ json_encode($payment) }})" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 mr-4 transition-colors font-semibold">Editar</button>
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este pago?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors font-semibold">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p class="text-lg font-medium text-gray-900 dark:text-white">No hay pagos registrados</p>
                                                <p class="text-gray-500 dark:text-gray-400 mt-1">Registra el primer abono de un cliente.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($payments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $payments->links() }}
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
            
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-left shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100 dark:border-slate-700 max-h-[90vh] overflow-y-auto">
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-8">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl leading-6 font-bold text-slate-900 dark:text-white" id="modal-title" x-text="isEdit ? 'Editar Pago' : 'Registrar Nuevo Pago'"></h3>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form :action="isEdit ? '/payments/' + paymentId : '{{ route('payments.store') }}'" method="POST">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <!-- Contract -->
                        <div class="mb-4">
                            <x-input-label for="contract_id" :value="__('Contrato (Cliente - Lote)')" />
                            <select id="contract_id" name="contract_id" x-model="formData.contract_id" @change="updateInstallments()" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Selecciona un contrato</option>
                                <template x-for="contract in contracts" :key="contract.id">
                                    <option :value="contract.id" x-text="contract.customer.first_name + ' ' + contract.customer.last_name + ' - Mz.' + contract.lot.block + ' Lt.' + contract.lot.lot_number"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Installment -->
                        <div class="mb-4" x-show="!isEdit">
                            <x-input-label for="installment_id" :value="__('Mes a Pagar')" />
                            <select id="installment_id" name="installment_id" x-model="formData.installment_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full" :required="!isEdit">
                                <option value="">Selecciona una mensualidad</option>
                                <template x-for="installment in availableInstallments" :key="installment.id">
                                    <option :value="installment.id" x-text="'Mes ' + installment.installment_number + ' - Vence: ' + installment.due_date.split('T')[0] + ' (Deuda: $' + (installment.total_amount - installment.paid_amount).toFixed(2) + ')'"></option>
                                </template>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Amount -->
                            <div>
                                <x-input-label for="amount" :value="__('Monto Pagado ($)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" x-model="formData.amount" required />
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="payment_date" :value="__('Fecha de Pago')" />
                                <x-text-input id="payment_date" class="block mt-1 w-full" type="date" name="payment_date" x-model="formData.payment_date" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Method -->
                            <div>
                                <x-input-label for="payment_method" :value="__('Método de Pago')" />
                                <select id="payment_method" name="payment_method" x-model="formData.payment_method" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="cash">Efectivo</option>
                                    <option value="transfer">Transferencia</option>
                                    <option value="card">Tarjeta</option>
                                    <option value="check">Cheque</option>
                                </select>
                            </div>

                            <!-- Reference -->
                            <div>
                                <x-input-label for="reference" :value="__('Folio/Referencia')" />
                                <x-text-input id="reference" class="block mt-1 w-full" type="text" name="reference" x-model="formData.reference" />
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('Notas Adicionales')" />
                            <textarea id="notes" name="notes" x-model="formData.notes" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm block mt-1 w-full" rows="2"></textarea>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-600 text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Guardar Pago
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
