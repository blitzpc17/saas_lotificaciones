<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('Editar Usuario:') }} <span class="text-brand-600 dark:text-brand-400">{{ $user->name }}</span>
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Actualiza los datos o cambia la contraseña.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors duration-200">
                <div class="p-8">

                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nombre Completo')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Correo Electrónico')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Nueva Contraseña (Opcional)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Déjalo en blanco para no cambiar" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Role -->
                            <div class="md:col-span-2">
                                <x-input-label for="role" :value="__('Rol del Usuario')" />
                                <select id="role" name="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 dark:focus:border-brand-600 focus:ring-brand-500 dark:focus:ring-brand-600 rounded-md shadow-sm" required>
                                    <option value="" disabled>Selecciona un rol</option>
                                    @php
                                        $currentRole = $user->roles->first()?->name;
                                    @endphp
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white font-medium mr-6 transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                {{ __('Actualizar Usuario') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
