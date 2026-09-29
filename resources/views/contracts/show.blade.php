<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Contrato #{{ str_pad($contract->id, 5, '0', STR_PAD_LEFT) }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Cliente: {{ $contract->customer->first_name }} {{ $contract->customer->last_name }}</p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('contracts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Contract Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Resumen del Contrato</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Desarrollo / Lote</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $contract->lot->development->name }} - {{ $contract->lot->identifier }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total a Pagar</p>
                        <p class="font-bold text-brand-600 dark:text-brand-400">${{ number_format($contract->total_amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mensualidad ({{ $contract->total_months }} meses)</p>
                        <p class="font-medium text-gray-900 dark:text-white">${{ number_format($contract->monthly_payment, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Enganche</p>
                        <p class="font-medium text-gray-900 dark:text-white">${{ number_format($contract->down_payment, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Inicio</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado</p>
                        @if($contract->status === 'active')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Activo</span>
                        @elseif($contract->status === 'completed')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">Completado</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Cancelado</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Amortization Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tabla de Amortización (Mensualidades)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">No.</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vencimiento</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capital</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Interés/Mora</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Cuota</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Abonado</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($contract->installments as $installment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        #{{ $installment->installment_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}
                                        @if($installment->status === 'pending' && \Carbon\Carbon::parse($installment->due_date)->isPast())
                                            <span class="ml-2 text-xs text-red-500 font-bold">¡Atrasado!</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        ${{ number_format($installment->principal_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400 font-medium">
                                        ${{ number_format($installment->interest_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-600 dark:text-brand-400">
                                        ${{ number_format($installment->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        ${{ number_format($installment->paid_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($installment->status === 'paid')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Pagado ({{ \Carbon\Carbon::parse($installment->paid_date)->format('d/m/Y') }})</span>
                                        @elseif($installment->status === 'late')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Vencido</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Pendiente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No hay mensualidades registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
