<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3 space-y-2">
                    <div class="flex items-center">
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-indigo-200 shadow-sm flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $sellers->total() }} Vendedores
                        </span>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por nombre, código o teléfono..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-end gap-2 w-full md:w-auto">
                    <button wire:click="openCreate" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-xl transition shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Nuevo Vendedor
                    </button>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto -mx-4">
                <div class="inline-block min-w-full align-middle font-sans">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-bold text-gray-400">
                            <tr>
                                <th class="px-6 py-4 text-left">Código</th>
                                <th class="px-6 py-4 text-left">Nombre</th>
                                <th class="px-6 py-4 text-left">Turno</th>
                                <th class="px-6 py-4 text-left">Teléfono</th>
                                <th class="px-6 py-4 text-center">Estado</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($sellers as $seller)
                                <tr class="hover:bg-indigo-50/30 transition group">
                                    <td class="px-6 py-4 text-sm font-mono text-gray-400">{{ $seller->code ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $seller->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($seller->shift)
                                            <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full {{ $seller->shift === 'mañana' ? 'bg-yellow-100 text-yellow-700' : ($seller->shift === 'tarde' ? 'bg-orange-100 text-orange-700' : 'bg-indigo-100 text-indigo-700') }}">
                                                {{ $seller->shift }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $seller->phone ?? '—' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button wire:click="toggleActive('{{ $seller->id }}')" class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full transition {{ $seller->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $seller->is_active ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                            <button wire:click="edit('{{ $seller->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button wire:click="delete('{{ $seller->id }}')" wire:confirm="¿Eliminar al vendedor {{ $seller->name }}? Esta acción es irreversible." class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">No se encontraron vendedores.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden space-y-4 font-sans">
                @forelse($sellers as $seller)
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1 pr-12">
                                <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight">{{ $seller->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded">{{ $seller->code ?? '—' }}</span>
                                    @if($seller->shift)
                                        <span class="text-[10px] uppercase font-black px-1.5 py-0.5 rounded {{ $seller->shift === 'mañana' ? 'bg-yellow-50 text-yellow-600' : ($seller->shift === 'tarde' ? 'bg-orange-50 text-orange-600' : 'bg-indigo-50 text-indigo-600') }}">
                                            {{ $seller->shift }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute top-4 right-4">
                                <button wire:click="toggleActive('{{ $seller->id }}')" class="px-2 py-1 text-[10px] font-black uppercase rounded-full {{ $seller->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $seller->is_active ? 'Activo' : 'Inactivo' }}
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-50 pt-3 mt-3">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Teléfono</p>
                                <p class="text-sm font-black text-indigo-700">{{ $seller->phone ?? '—' }}</p>
                            </div>
                            
                            <div class="flex gap-2">
                                <button wire:click="edit('{{ $seller->id }}')" class="bg-indigo-50 text-indigo-700 p-2 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="delete('{{ $seller->id }}')" wire:confirm="¿Borrar?" class="bg-red-50 text-red-500 p-2 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 italic">No se encontraron vendedores.</div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $sellers->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">{{ $editingId ? 'Editar Vendedor' : 'Nuevo Vendedor' }}</x-slot>
        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nombre *</label>
                    <input wire:model="name" type="text"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full text-sm"
                        placeholder="Nombre completo del vendedor">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Código <span class="font-normal text-gray-400">(Opcional)</span></label>
                        <input wire:model="code" type="text"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full text-sm"
                            placeholder="Ej: V001">
                        @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Turno</label>
                        <select wire:model="shift"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full text-sm">
                            <option value="">— Sin turno —</option>
                            <option value="mañana">☀️ Mañana</option>
                            <option value="tarde">🌤 Tarde</option>
                            <option value="noche">🌙 Noche</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Teléfono <span class="font-normal text-gray-400">(Opcional)</span></label>
                    <input wire:model="phone" type="text"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full text-sm"
                        placeholder="Ej: 0981-123456">
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" wire:model="isActive" id="sellerActive"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="sellerActive" class="text-sm text-gray-700">Vendedor activo</label>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">Cancelar</x-secondary-button>
            <x-button wire:click="save" class="ms-2">Guardar</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
