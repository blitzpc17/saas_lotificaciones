<x-app-layout>
    <div x-data="{ 
        showModal: false, 
        isEdit: false, 
        lotId: null,
        formData: {
            development_id: '',
            block: '',
            lot_number: '',
            area: '',
            price: '',
            status: 'available'
        },
        openCreateModal() {
            this.isEdit = false;
            this.lotId = null;
            this.formData = { development_id: '', block: '', lot_number: '', area: '', price: '', status: 'available' };
            this.showModal = true;
        },
        openEditModal(lot) {
            this.isEdit = true;
            this.lotId = lot.id;
            this.formData = {
                development_id: lot.development_id,
                block: lot.block,
                lot_number: lot.lot_number,
                area: lot.area,
                price: lot.price,
                status: lot.status
            };
            this.showModal = true;
        }
    }">
    
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Lotes') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Administra los lotes o terrenos de cada desarrollo.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button @click="openCreateModal()" class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Lote
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
                        <form action="{{ route('lots.index') }}" method="GET" class="relative w-full sm:w-1/3">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar lote o desarrollo..." class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Desarrollo</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Manzana/Lote</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Área/Precio</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($lots as $lot)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $lot->development->name }}</div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                Manzana: <span class="font-semibold text-gray-900 dark:text-white">{{ $lot->block }}</span>
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                Lote: <span class="font-semibold text-gray-900 dark:text-white">{{ $lot->lot_number }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                                {{ $lot->area }} m²
                                            </div>
                                            <div class="text-sm font-bold text-green-600 dark:text-green-400 mt-1">
                                                ${{ number_format($lot->price, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            @if($lot->status === 'available')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200">Disponible</span>
                                            @elseif($lot->status === 'reserved')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-200">Reservado</span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200">Vendido</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="openEditModal({{ json_encode($lot) }})" class="text-brand-600 dark:text-brand-400 hover:text-brand-900 dark:hover:text-brand-300 mr-4 transition-colors font-semibold">Editar</button>
                                            <form action="{{ route('lots.destroy', $lot) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este lote?');">
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
                                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                                <p class="text-lg font-medium text-gray-900 dark:text-white">No hay lotes registrados</p>
                                                <p class="text-gray-500 dark:text-gray-400 mt-1">Comienza agregando el primer terreno a un desarrollo.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($lots->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $lots->links() }}
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
                        <h3 class="text-xl leading-6 font-bold text-slate-900 dark:text-white" id="modal-title" x-text="isEdit ? 'Editar Lote' : 'Crear Nuevo Lote'"></h3>
                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form :action="isEdit ? '/lots/' + lotId : '{{ route('lots.store') }}'" method="POST">
                        @csrf
                        <!-- We use alpine to render a hidden _method input when editing -->
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <!-- Development -->
                        <div class="mb-4">
                            <x-input-label for="development_id" :value="__('Desarrollo')" />
                            <select id="development_id" name="development_id" x-model="formData.development_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 dark:focus:border-brand-600 focus:ring-brand-500 dark:focus:ring-brand-600 rounded-md shadow-sm" required>
                                <option value="" disabled>Selecciona un desarrollo</option>
                                @foreach($developments as $development)
                                    <option value="{{ $development->id }}">{{ $development->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Block -->
                            <div>
                                <x-input-label for="block" :value="__('Manzana')" />
                                <x-text-input id="block" class="block mt-1 w-full" type="text" name="block" x-model="formData.block" required />
                            </div>

                            <!-- Lot Number -->
                            <div>
                                <x-input-label for="lot_number" :value="__('Lote')" />
                                <x-text-input id="lot_number" class="block mt-1 w-full" type="text" name="lot_number" x-model="formData.lot_number" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Area -->
                            <div>
                                <x-input-label for="area" :value="__('Área (m²)')" />
                                <x-text-input id="area" class="block mt-1 w-full" type="number" step="0.01" name="area" x-model="formData.area" required />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Precio Total ($)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" x-model="formData.price" required />
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Estado')" />
                            <select id="status" name="status" x-model="formData.status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 dark:focus:border-brand-600 focus:ring-brand-500 dark:focus:ring-brand-600 rounded-md shadow-sm" required>
                                <option value="available">Disponible</option>
                                <option value="reserved">Reservado</option>
                                <option value="sold">Vendido</option>
                            </select>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-600 text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Guardar Lote
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
