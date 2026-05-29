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

            <!-- Total Receivable Banner -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 font-sans">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-amber-500 md:col-span-2 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">Total por Cobrar en la Calle</p>
                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-tighter dark:text-gray-500">Suma total de deudas de clientes activos</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-black text-gray-900 tracking-tighter dark:text-white">₲ {{ format_pyg($totalReceivable) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Mini Stats Placeholder or Legend -->
                <div class="bg-indigo-600 overflow-hidden shadow-lg rounded-xl p-6 text-white relative group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition duration-500">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest">Base de Clientes</p>
                        <p class="text-3xl font-black mt-1">{{ $customers->total() }}</p>
                        <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mt-2">Registrados en sistema</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3 space-y-2 font-sans">
                    <div class="flex items-center">
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-indigo-200 shadow-sm flex items-center gap-1 dark:text-indigo-400 dark:shadow-none">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $customers->total() }} Clientes
                        </span>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition dark:text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por Nombre o RUC..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900">
                    </div>
                </div>
                <div class="flex flex-wrap justify-center md:justify-end gap-2 w-full md:w-auto">
                    @can('admin')
                        @if(count($selected) > 0)
                            <button wire:click="deleteSelected" 
                                    onclick="confirm('¿Estás seguro de eliminar los clientes seleccionados?') || event.stopImmediatePropagation()"
                                    class="bg-red-50 text-red-600 hover:bg-red-100 font-bold py-2.5 px-4 rounded-xl transition flex items-center dark:bg-red-900/30">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Borrar ({{ count($selected) }})
                            </button>
                        @endif
                    @endcan
                    <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center justify-center w-full md:w-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Nuevo Cliente
                    </button>
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $customerId ? 'Editar Cliente' : 'Crear Cliente' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store">
                        <button type="submit" class="hidden"></button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- RUC -->
                            <div class="col-span-1">
                                <label for="ruc" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">RUC / CI:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="ruc" wire:model="ruc">
                                @error('ruc') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Nombre -->
                            <div class="col-span-1">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Razón Social / Nombre:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="name" wire:model="name">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Email -->
                            <div class="col-span-1">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Email:</label>
                                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="email" wire:model="email">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-span-1">
                                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Teléfono:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="phone" wire:model="phone">
                                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Address -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="address" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Dirección:</label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="address" wire:model="address"></textarea>
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Activo -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="is_active" class="form-checkbox h-5 w-5 text-indigo-600 dark:text-indigo-400 dark:bg-gray-900">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Cliente Activo</span>
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

            <!-- Customers Grid (Desktop & Mobile) -->
            <div class="w-full">
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto -mx-4">
                    <div class="inline-block min-w-full align-middle font-sans">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400 dark:bg-gray-900 dark:text-gray-400">
                                <tr>
                                    @can('admin')
                                    <th class="px-6 py-4 text-left">
                                        <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4 dark:border-gray-600 dark:text-indigo-400 dark:bg-gray-900">
                                    </th>
                                    @endcan
                                    <th class="px-6 py-4 text-left">RUC / CI</th>
                                    <th class="px-6 py-4 text-left">Cliente</th>
                                    <th class="px-6 py-4 text-left">Teléfono</th>
                                    <th class="px-6 py-4 text-center">Estado</th>
                                    <th class="px-6 py-4 text-right">Saldo Deudor</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($customers as $customer)
                                    <tr class="hover:bg-blue-50/30 transition group">
                                        @can('admin')
                                        <td class="px-6 py-4">
                                            <input type="checkbox" wire:model.live="selected" value="{{ $customer->id }}" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600">
                                        </td>
                                        @endcan
                                        <td class="px-6 py-4 text-sm font-mono text-gray-400 dark:text-gray-500">{{ $customer->ruc }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900 leading-tight dark:text-white">{{ $customer->name }}</div>
                                            <div class="text-[10px] text-gray-400 truncate max-w-[150px] dark:text-gray-500">{{ $customer->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $customer->phone ?? '—' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full {{ $customer->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $customer->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-sm font-black {{ $customer->balance > 0 ? 'text-blue-700' : 'text-gray-400' }}">
                                                {{ format_pyg($customer->balance) }} ₲
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2 transition">
                                                <button wire:click="openPaymentModal('{{ $customer->id }}')" class="text-emerald-600 hover:text-emerald-900 p-1.5 rounded-lg hover:bg-emerald-50" title="Cobrar Cuenta">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                </button>
                                                <button wire:click="openHistoryModal('{{ $customer->id }}')" class="text-blue-600 hover:text-blue-900 p-1.5 rounded-lg hover:bg-blue-50" title="Ver Cuenta Corriente">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                                </button>
                                                <button wire:click="edit('{{ $customer->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50 dark:text-indigo-400" title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                @can('admin')
                                                <button wire:click="delete('{{ $customer->id }}')" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                                @endcan
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
                @foreach($customers as $customer)
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1 pr-12">
                                <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight dark:text-white">{{ $customer->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded dark:text-gray-500 dark:bg-gray-900">{{ $customer->ruc }}</span>
                                    <span class="text-[10px] uppercase font-black {{ $customer->is_active ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-1.5 py-0.5 rounded">
                                        {{ $customer->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                            <!-- Selection Checkbox (Admin Only) -->
                            @can('admin')
                            <div class="absolute top-4 right-4 h-6 w-6">
                                <input type="checkbox" wire:model.live="selected" value="{{ $customer->id }}" class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500 h-5 w-5 dark:border-gray-600">
                            </div>
                            @endcan
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-t border-gray-50 pt-3 mt-3">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider dark:text-gray-500">Saldo Pendiente</p>
                                <p class="text-xl font-black {{ $customer->balance > 0 ? 'text-blue-700' : 'text-gray-300' }}">
                                    {{ format_pyg($customer->balance) }} ₲
                                </p>
                            </div>
                            <div class="text-right flex flex-col items-end justify-center">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1 dark:text-gray-500">Contacto</p>
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $customer->phone ?? 'Sin teléfono' }}</span>
                            </div>
                        </div>

                        <!-- Mobile Action Buttons -->
                        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-dashed border-gray-100 dark:border-gray-700">
                            <button wire:click="openPaymentModal('{{ $customer->id }}')" class="flex-1 bg-emerald-50 text-emerald-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-emerald-900/30 dark:text-emerald-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Cobrar
                            </button>
                            <button wire:click="openHistoryModal('{{ $customer->id }}')" class="flex-1 bg-blue-50 text-blue-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-blue-900/30 dark:text-blue-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Cuenta
                            </button>
                            <button wire:click="edit('{{ $customer->id }}')" class="flex-1 bg-indigo-50 text-indigo-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-indigo-900/30 dark:text-indigo-400">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar
                            </button>
                            @can('admin')
                            <button wire:click="delete('{{ $customer->id }}')" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="bg-red-50 text-red-500 font-bold py-2 px-3 rounded-xl text-xs flex items-center justify-center dark:bg-red-900/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
            <!-- Payment Modal -->
            <x-dialog-modal wire:model="showPaymentModal">
                <x-slot name="title">
                    Registrar Cobro
                </x-slot>

                <x-slot name="content">
                    <div class="font-sans">
                        <div class="flex items-center gap-4 mb-6 bg-indigo-50 p-4 rounded-2xl border border-indigo-100 dark:bg-indigo-900/30">
                            <div class="p-3 bg-white rounded-xl shadow-sm text-indigo-600 dark:bg-gray-800 dark:shadow-none dark:text-indigo-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Cliente</p>
                                <p class="text-lg font-black text-indigo-900 leading-tight">{{ $paymentCustomerName }}</p>
                                <p class="text-[11px] font-bold text-indigo-600 mt-0.5 dark:text-indigo-400">Saldo Pendiente: ₲ {{ format_pyg($paymentCustomerBalance) }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-5">
                            <div class="bg-white dark:bg-gray-800">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-500">Monto a Cobrar</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 font-black text-xl font-mono tracking-tighter">₲</span>
                                    <input type="number" wire:model="paymentAmount" 
                                        class="pl-10 shadow-sm border border-gray-200 rounded-xl w-full py-4 px-4 text-gray-900 text-2xl font-black text-center focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition placeholder-gray-200 dark:shadow-none dark:border-gray-700 dark:text-white dark:bg-gray-900" 
                                        placeholder="0">
                                </div>
                                @error('paymentAmount') <p class="text-red-500 text-[10px] font-bold uppercase mt-1.5 ml-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-500">Método de Pago</label>
                                    <select wire:model="paymentMethod" class="shadow-sm border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-bold text-sm dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900">
                                        <option value="efectivo">Efectivo (Entra a Caja)</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="qr">QR</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-500">Referencia / Descripción</label>
                                    <input type="text" wire:model="paymentDescription" class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900" placeholder="Ej: Pago de factura #123">
                                </div>
                            </div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="closePaymentModal" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>

                    <button class="ml-2 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2.5 px-8 rounded-xl transition text-xs uppercase tracking-widest shadow-lg shadow-emerald-100" wire:click="registerPayment" wire:loading.attr="disabled">
                        Registrar Cobro
                    </button>
                </x-slot>
            </x-dialog-modal>

            <!-- History Modal -->
            <x-dialog-modal wire:model="showHistoryModal" maxWidth="3xl">
                <x-slot name="title">
                    Historial de Movimientos: {{ $historyCustomerName }}
                </x-slot>

                <x-slot name="content">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Descripción</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Monto</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-10 dark:text-gray-400"></th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($historyTransactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'debit' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $transaction->type === 'debit' ? 'Deuda (Venta)' : 'Pago (Cobro)' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium {{ $transaction->type === 'debit' ? 'text-red-600' : 'text-green-600' }}">
                                            {{ number_format($transaction->amount, 0, ',', '.') }} ₲
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap">
                                            @if($transaction->reference_type === 'sale')
                                                <a href="{{ route('reports.sales', ['saleId' => $transaction->reference_id]) }}" class="text-indigo-400 hover:text-indigo-600 transition p-1" title="Ver Detalle de Venta">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                            @endif
                                            @if($transaction->reference_type === 'payment')
                                                <button class="text-emerald-400 hover:text-emerald-600 transition p-1" title="Imprimir Recibo">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                </button>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Sin movimientos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <a href="{{ route('customers.statement', $paymentCustomerId ?: 0) }}" target="_blank" class="mr-auto inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-black uppercase tracking-widest rounded-xl transition shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:shadow-none">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                         Imprimir Estado
                    </a>
                    <x-secondary-button wire:click="closeHistoryModal" wire:loading.attr="disabled">
                        Cerrar
                    </x-secondary-button>
                </x-slot>
            </x-dialog-modal>
        </div>
    </div>
</div>
