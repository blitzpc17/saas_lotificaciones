<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Configuración de Inmobiliaria</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Personaliza la apariencia y datos de tu portal.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden" 
         x-data="{ 
            previewName: '{{ addslashes(old('company_name', tenant('company'))) }}', 
            previewColor: '{{ old('theme_color', tenant('theme_color') ?? '#C5A017') }}',
            logoPreview: '{{ tenant('logo_image') ?? '' }}'
         }">
        
        <div class="p-6 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex flex-col md:flex-row gap-6 items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Vista Previa (Menú Lateral)</h3>
                <div class="flex items-center space-x-3 p-4 rounded-xl bg-slate-900 shadow-inner min-w-[250px]">
                    <!-- Logo Preview -->
                    <template x-if="logoPreview">
                        <img :src="logoPreview" class="h-8 w-8 object-contain">
                    </template>
                    <template x-if="!logoPreview">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-sm" :style="'background-color: ' + previewColor">
                            <span x-text="previewName ? previewName.substring(0,1).toUpperCase() : '?'"></span>
                        </div>
                    </template>
                    <!-- Name Preview -->
                    <span class="text-lg font-bold text-white tracking-tight" x-text="previewName || 'Tu Empresa'"></span>
                </div>
            </div>
            <div class="text-sm text-slate-500">
                Así se verá tu marca en el menú lateral para ti y tus clientes.
            </div>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-8">
            @csrf
            
            <!-- Company Name -->
            <div>
                <label for="company_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nombre de la Inmobiliaria</label>
                <input type="text" name="company_name" id="company_name" x-model="previewName"
                    class="block w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition-colors py-2.5 px-4"
                    placeholder="Ej. Desarrollos del Norte">
                @error('company_name') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Login Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Imagen de Fondo (Login)</label>
                    
                    <div x-data="{ fileName: '', dragOver: false, filePreview: '' }" 
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-xl transition-colors relative overflow-hidden"
                         :class="dragOver ? 'border-brand-500 bg-brand-50 dark:bg-brand-900/20' : 'border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900'"
                         @dragover.prevent="dragOver = true"
                         @dragleave.prevent="dragOver = false"
                         @drop.prevent="dragOver = false; $refs.login_input.files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0].name; filePreview = URL.createObjectURL($event.dataTransfer.files[0])">
                        
                        <!-- Background preview -->
                        <template x-if="filePreview">
                            <img :src="filePreview" class="absolute inset-0 w-full h-full object-cover opacity-30">
                        </template>

                        <div class="space-y-1 text-center relative z-10">
                            <template x-if="!filePreview">
                                <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </template>
                            <template x-if="filePreview">
                                <img :src="filePreview" class="mx-auto h-16 w-auto object-contain rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-1 mb-2">
                            </template>
                            
                            <div class="flex text-sm text-slate-600 dark:text-slate-400 justify-center">
                                <label for="login_image" class="relative cursor-pointer bg-transparent rounded-md font-medium text-brand-600 dark:text-brand-400 hover:text-brand-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500">
                                    <span x-text="fileName === '' ? 'Sube un archivo' : fileName" :class="fileName !== '' ? 'text-emerald-600 dark:text-emerald-400 font-bold' : ''"></span>
                                    <input id="login_image" x-ref="login_input" name="login_image" type="file" class="sr-only" accept="image/*" @change="fileName = $event.target.files[0].name; filePreview = URL.createObjectURL($event.target.files[0])">
                                </label>
                                <p class="pl-1" x-show="fileName === ''">o arrastra y suelta aquí</p>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-500" x-show="fileName === ''">PNG, JPG, GIF hasta 5MB</p>
                        </div>
                    </div>
                    @if(tenant('login_image'))
                        <div class="mt-2 text-sm text-slate-500">
                            Imagen actual guardada. Sube una nueva para reemplazarla.
                        </div>
                    @endif
                    @error('login_image') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>

                <!-- Logo Upload -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Logo de la Empresa (Menú)</label>
                    
                    <div x-data="{ fileName: '', dragOver: false, filePreview: '' }" 
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-xl transition-colors relative overflow-hidden"
                         :class="dragOver ? 'border-brand-500 bg-brand-50 dark:bg-brand-900/20' : 'border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900'"
                         @dragover.prevent="dragOver = true"
                         @dragleave.prevent="dragOver = false"
                         @drop.prevent="dragOver = false; $refs.logo_input.files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0].name; filePreview = URL.createObjectURL($event.dataTransfer.files[0]); logoPreview = filePreview">
                        
                        <div class="space-y-1 text-center relative z-10">
                            <template x-if="!filePreview">
                                <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </template>
                            <template x-if="filePreview">
                                <img :src="filePreview" class="mx-auto h-16 w-auto object-contain rounded-lg bg-slate-100 dark:bg-slate-800 p-2 shadow-sm mb-2">
                            </template>

                            <div class="flex text-sm text-slate-600 dark:text-slate-400 justify-center">
                                <label for="logo_image" class="relative cursor-pointer bg-transparent rounded-md font-medium text-brand-600 dark:text-brand-400 hover:text-brand-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500">
                                    <span x-text="fileName === '' ? 'Sube tu logo' : fileName" :class="fileName !== '' ? 'text-emerald-600 dark:text-emerald-400 font-bold' : ''"></span>
                                    <input id="logo_image" x-ref="logo_input" name="logo_image" type="file" class="sr-only" accept="image/*" @change="fileName = $event.target.files[0].name; filePreview = URL.createObjectURL($event.target.files[0]); logoPreview = filePreview">
                                </label>
                                <p class="pl-1" x-show="fileName === ''">o arrastra aquí</p>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-500" x-show="fileName === ''">PNG transparente ideal (Max 2MB)</p>
                        </div>
                    </div>
                    @if(tenant('logo_image'))
                        <div class="mt-2 flex items-center">
                            <img src="{{ tenant('logo_image') }}" alt="Logo Actual" class="h-8 object-contain mr-3 bg-slate-100 p-1 rounded">
                            <span class="text-sm text-slate-500">Logo actual</span>
                        </div>
                    @endif
                    @error('logo_image') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Color Theme -->
            <div>
                <label for="theme_color" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Color de Marca (Botones y Acentos)</label>
                <div class="flex items-center space-x-4">
                    <!-- Color picker to sync with text input -->
                    <div class="relative w-14 h-10 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden cursor-pointer" :style="'background-color: ' + previewColor">
                        <input type="color" x-model="previewColor" class="absolute -top-4 -left-4 w-32 h-32 opacity-0 cursor-pointer">
                    </div>
                    <!-- Text Input -->
                    <input type="text" name="theme_color" id="theme_color" x-model="previewColor" 
                        class="block w-40 rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-brand-500 focus:border-brand-500 sm:text-sm py-2 px-3"
                        placeholder="#C5A017 o rgb(197, 160, 23)">
                    <span class="text-sm text-slate-500 dark:text-slate-400 hidden sm:inline">HEX o RGB. Haz clic en el cuadro para usar la paleta visual.</span>
                </div>
                @error('theme_color') <p class="mt-1 text-sm text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-brand-500/30 transition-all">
                    Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
