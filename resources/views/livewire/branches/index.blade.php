<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-gray-800">
            
            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3 dark:bg-green-900/40 dark:shadow-none" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3 dark:bg-red-900/40 dark:shadow-none" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3 space-y-2 font-sans">
                    <div class="flex items-center">
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-indigo-200 shadow-sm flex items-center gap-1 dark:text-indigo-400 dark:shadow-none">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $branches->total() }} Sucursales
                        </span>
                    </div>
                    <div class="relative group font-sans">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition dark:text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar sucursal..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900">
                    </div>
                </div>
                <div class="flex space-x-2 w-full md:w-auto">
                    <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center justify-center w-full md:w-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Nueva Sucursal
                    </button>
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $branchId ? 'Editar Sucursal' : 'Crear Sucursal' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store" class="font-sans space-y-4">
                        <button type="submit" class="hidden"></button>
                        <div class="mb-2">
                            <label for="name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-500">Nombre de la Sucursal</label>
                            <input type="text" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-bold dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900" id="name" wire:model="name" placeholder="Ej: Sucursal Centro">
                            @error('name') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-2">
                            <label for="address" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-500">Dirección</label>
                            <input type="text" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900" id="address" wire:model="address" placeholder="Av. Principal 123...">
                            @error('address') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-2">
                            <label for="phone" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-500">Teléfono</label>
                            <input type="text" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900" id="phone" wire:model="phone" placeholder="0981 123 456">
                            @error('phone') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span>@enderror
                        </div>
                        <div class="flex items-center pt-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="sr-only peer dark:bg-gray-900 dark:text-gray-300">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-xs font-black text-gray-500 uppercase tracking-widest dark:text-gray-400">Habilitar Sucursal</span>
                            </label>
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
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-bold text-gray-400 dark:bg-gray-900 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4 text-left">Nombre</th>
                                <th class="px-6 py-4 text-left">Dirección</th>
                                <th class="px-6 py-4 text-left">Teléfono</th>
                                <th class="px-6 py-4 text-center">Estado</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($branches as $branch)
                                <tr class="hover:bg-indigo-50/30 transition group">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">{{ $branch->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 font-medium dark:text-gray-400">{{ $branch->address ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 font-medium dark:text-gray-400">{{ $branch->phone ?? '—' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full {{ $branch->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $branch->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2 transition">
                                            <button wire:click="edit('{{ $branch->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50 dark:text-indigo-400" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button wire:click="delete('{{ $branch->id }}')" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
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
                @foreach($branches as $branch)
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight dark:text-white">{{ $branch->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] uppercase font-black {{ $branch->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} px-1.5 py-0.5 rounded">
                                        {{ $branch->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-sm text-gray-500 mb-2 dark:text-gray-400">
                            <strong>Dirección:</strong> {{ $branch->address ?? 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-500 mb-4 dark:text-gray-400">
                            <strong>Teléfono:</strong> {{ $branch->phone ?? 'N/A' }}
                        </div>

                        <div class="flex gap-2 mt-4 pt-4 border-t border-dashed border-gray-100 dark:border-gray-700">
                            <button wire:click="edit('{{ $branch->id }}')" class="flex-1 bg-indigo-50 text-indigo-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-indigo-900/30 dark:text-indigo-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar
                            </button>
                            <button wire:click="delete('{{ $branch->id }}')" onclick="confirm('¿Estás seguro?')" class="flex-1 bg-red-50 text-red-500 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-red-900/30">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Borrar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
</div>
