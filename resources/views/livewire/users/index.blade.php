<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- License Usage Stats -->
            @php $stats = \App\Services\LicenseService::getUsageStats(); @endphp
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Plan Actual</p>
                        <p class="text-lg font-black text-indigo-700 uppercase">{{ $stats['tier'] }}</p>
                    </div>
                    <div class="bg-indigo-600 p-2 rounded-xl text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 20l9 2 9-2-1.382-14.016z"></path></svg>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Usuarios</p>
                        <p class="text-xl font-black text-gray-900">{{ $stats['users']['current'] }} / {{ $stats['users']['max'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full border-4 border-gray-50 flex items-center justify-center relative">
                        @php $percent = $stats['users']['max'] > 0 ? ($stats['users']['current'] / $stats['users']['max']) * 100 : 0; @endphp
                        <div class="absolute inset-0 rounded-full border-4 {{ $percent >= 100 ? 'border-red-500' : 'border-indigo-500' }}" style="clip-path: inset(0 0 0 0); opacity: 0.2"></div>
                        <span class="text-[10px] font-black text-gray-400">{{ round($percent) }}%</span>
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Disponibles</p>
                        <p class="text-xl font-black {{ $stats['users']['available'] > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $stats['users']['available'] }} cupos
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3 space-y-2 font-sans">
                    <div class="flex items-center">
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-indigo-200 shadow-sm flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ $users->total() }} Usuarios
                        </span>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar usuarios..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                </div>
                <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center w-full md:w-auto justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Nuevo Usuario
                </button>
            </div>

            <!-- Create/Edit Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $userId ? 'Editar Usuario' : 'Crear Usuario' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store">
                        <button type="submit" class="hidden"></button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-sans">
                            <!-- Nombre -->
                            <div class="mb-2">
                                <label for="name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Nombre Completo</label>
                                <input type="text" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="name" wire:model="name" placeholder="Ej: Juan Pérez">
                                @error('name') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-2">
                                <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Correo Electrónico</label>
                                <input type="email" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-mono text-sm" id="email" wire:model="email" placeholder="usuario@ejemplo.com">
                                @error('email') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-2">
                                <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Contraseña {{ $userId ? '(Opcional)' : '' }}</label>
                                <input type="password" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="password" wire:model="password" placeholder="••••••••">
                                @error('password') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                            </div>

                            <!-- Role -->
                            <div class="mb-2">
                                <label for="role" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Permisos / Rol</label>
                                <select wire:model="role" class="shadow-sm border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    <option value="cajero">Cajero (Ventas y Caja)</option>
                                    <option value="gerente">Gerente (Reportes y Stock)</option>
                                    <option value="admin">Administrador (Control Total)</option>
                                </select>
                                @error('role') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </form>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>

                    <x-button class="ml-2 bg-indigo-600 hover:bg-indigo-500" wire:click="store" wire:loading.attr="disabled">
                        Guardar
                    </x-button>
                </x-slot>
            </x-dialog-modal>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto -mx-4">
                <div class="inline-block min-w-full align-middle font-sans">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-bold text-gray-400">
                            <tr>
                                <th class="px-6 py-4 text-left">Nombre</th>
                                <th class="px-6 py-4 text-left">E-mail</th>
                                <th class="px-6 py-4 text-center">Rol</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-indigo-50/30 transition group">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-center uppercase tracking-tighter">
                                        <span class="px-2.5 py-1 inline-flex text-[10px] font-black rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'gerente' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                            <button wire:click="edit('{{ $user->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button wire:click="delete('{{ $user->id }}')" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden space-y-4 font-sans">
                @foreach($users as $user)
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight">{{ $user->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded">{{ $user->email }}</span>
                                    <span class="text-[10px] uppercase font-black {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-600' : ($user->role === 'gerente' ? 'bg-indigo-50 text-indigo-600' : 'bg-gray-50 text-gray-600') }} px-1.5 py-0.5 rounded">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-4 pt-4 border-t border-dashed border-gray-100">
                            <button wire:click="edit('{{ $user->id }}')" class="flex-1 bg-indigo-50 text-indigo-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar
                            </button>
                            <button wire:click="delete('{{ $user->id }}')" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="flex-1 bg-red-50 text-red-500 font-bold py-2 rounded-xl text-xs flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Borrar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
