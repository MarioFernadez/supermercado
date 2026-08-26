<div>
    <x-page-header title="Proveedores" section="Tienda › Compras" :badge="$suppliers->total() . ' proveedores'">
        <x-slot name="actions">
            @if(count($selected) > 0)
                <button wire:click="deleteSelected" 
                        onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"
                        class="bg-red-50 text-red-600 hover:bg-red-100 font-bold py-2 px-3.5 rounded-xl text-xs transition flex items-center gap-1 dark:bg-red-900/30">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Borrar ({{ count($selected) }})
                </button>
            @endif
            <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Nuevo Proveedor
            </button>
        </x-slot>
    </x-page-header>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200/80 px-5 py-5 dark:bg-gray-800 dark:border-gray-700">
                
                @if (session()->has('message'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg text-sm mb-4 dark:bg-green-900/30 dark:text-green-300" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                    <div class="w-full md:w-1/2 font-sans">
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition dark:text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por Nombre, Contacto..." autocomplete="off" class="pl-10 shadow-sm border border-gray-200 rounded-xl w-full py-2 px-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900">
                        </div>
                    </div>
                </div>

            <!-- Create/Edit Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $supplierId ? 'Editar Proveedor' : 'Crear Proveedor' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store">
                        <button type="submit" class="hidden"></button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Nombre -->
                            <div class="col-span-1">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Nombre Empresa / Proveedor:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="name" wire:model="name">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Contacto -->
                            <div class="col-span-1">
                                <label for="contact_name" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Nombre de Contacto:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="contact_name" wire:model="contact_name">
                                @error('contact_name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Email -->
                            <div class="col-span-1">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Email:</label>
                                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="email" wire:model="email">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-span-1">
                                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Teléfono / Celular:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="phone" wire:model="phone">
                                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Address -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="address" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Dirección:</label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="address" wire:model="address" rows="2"></textarea>
                            </div>

                            <!-- Notes -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="notes" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Notas Adicionales:</label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="notes" wire:model="notes" rows="2" placeholder="Días de entrega, condiciones, etc."></textarea>
                            </div>

                            <!-- Activo -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="active" class="form-checkbox h-5 w-5 text-indigo-600 dark:text-indigo-400 dark:bg-gray-900">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Proveedor Activo</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>

                    <button class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2 px-6 rounded-xl transition text-xs uppercase tracking-widest" wire:click="store" wire:loading.attr="disabled">
                        Guardar
                    </button>
                </x-slot>
            </x-dialog-modal>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto -mx-4">
                <div class="inline-block min-w-full align-middle font-sans">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400 dark:bg-gray-900 dark:text-gray-400">
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <th class="px-6 py-4 text-left">
                                        <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4 dark:border-gray-600 dark:text-indigo-400 dark:bg-gray-900">
                                    </th>
                                    <th class="px-6 py-4 text-left">Nombre / Empresa</th>
                                    <th class="px-6 py-4 text-left font-bold">Contacto</th>
                                    <th class="px-6 py-4 text-left">E-mail</th>
                                    <th class="px-6 py-4 text-left font-bold">Teléfono</th>
                                    <th class="px-6 py-4 text-center">Estado</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($suppliers as $supplier)
                                <tr class="hover:bg-indigo-50/30 transition group">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" wire:model.live="selected" value="{{ $supplier->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4 dark:border-gray-600 dark:text-indigo-400">
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">{{ $supplier->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium dark:text-gray-400">{{ $supplier->contact_name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-[11px] text-gray-400 font-mono lower dark:text-gray-500">{{ $supplier->email ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 font-bold tracking-tighter dark:text-gray-400">{{ $supplier->phone ?? '—' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full {{ $supplier->active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $supplier->active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2 transition">
                                            <button wire:click="edit('{{ $supplier->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50 dark:text-indigo-400" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button wire:click="delete('{{ $supplier->id }}')" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
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
                @foreach($suppliers as $supplier)
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1 pr-12">
                                <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight dark:text-white">{{ $supplier->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] uppercase font-black {{ $supplier->active ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-1.5 py-0.5 rounded">
                                        {{ $supplier->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="text-sm text-gray-600 mb-4 space-y-2 dark:text-gray-400">
                            @if($supplier->contact_name)
                                <div>
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5 dark:text-gray-500">Contacto</span>
                                    <span class="font-bold text-gray-700 dark:text-gray-300">{{ $supplier->contact_name }}</span>
                                </div>
                            @endif
                            <div class="flex flex-wrap gap-4">
                                @if($supplier->phone) 
                                    <div class="bg-gray-50 px-2 py-1 rounded-lg border border-gray-100 flex items-center dark:bg-gray-900 dark:border-gray-700">
                                        <span class="text-xs mr-1">📞</span>
                                        <span class="font-bold text-gray-800 tracking-tighter dark:text-white">{{ $supplier->phone }}</span>
                                    </div> 
                                @endif
                                @if($supplier->email) 
                                    <div class="text-[11px] italic text-gray-400 flex items-center dark:text-gray-500">
                                        <span class="mr-1">✉️</span>
                                        {{ $supplier->email }}
                                    </div> 
                                @endif
                            </div>
                            @if($supplier->address) 
                                <div class="text-[10px] text-gray-400 mt-1 flex items-start dark:text-gray-500">
                                    <span class="mr-1 mt-0.5">📍</span>
                                    <span class="flex-1">{{ $supplier->address }}</span>
                                </div> 
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 mt-4 pt-4 border-t border-dashed border-gray-100 dark:border-gray-700">
                            <button wire:click="edit('{{ $supplier->id }}')" class="flex-1 bg-indigo-50 text-indigo-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-indigo-900/30 dark:text-indigo-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar
                            </button>
                            <button wire:click="delete('{{ $supplier->id }}')" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="flex-1 bg-red-50 text-red-500 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-red-900/30">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Borrar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</div>
