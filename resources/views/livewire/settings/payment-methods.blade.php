<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('settings.general') }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-tight">Métodos de Pago</h2>
                </div>
                <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo Método
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <!-- Filtros -->
            <div class="mb-6">
                <input wire:model.live="search" type="text" placeholder="Buscar método..." class="w-full sm:w-1/3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto border border-gray-100 rounded-xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($methods as $method)
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $method->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 uppercase font-black text-[10px] tracking-widest">
                                    <span class="px-2 py-1 bg-gray-100 rounded-lg border border-gray-200">{{ $method->type }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-[10px] font-black uppercase rounded-full {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $method->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit('{{ $method->id }}')" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                                    <button onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" wire:click="delete('{{ $method->id }}')" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No hay métodos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $methods->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full font-sans">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-4">
                        <h3 class="text-xl leading-6 font-black text-gray-900 mb-6 uppercase tracking-tight" id="modal-title">
                            {{ $methodId ? 'Editar Método' : 'Nuevo Método de Pago' }}
                        </h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Nombre (ej: Banco Itaú Transferencia)</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                                @error('name') <span class="text-red-500 text-[10px] font-bold uppercase mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Tipo de Método</label>
                                <select wire:model="type" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition font-bold text-sm">
                                    <option value="cash">Efectivo</option>
                                    <option value="transfer">Transferencia</option>
                                    <option value="card">Tarjeta (POS)</option>
                                    <option value="qr">QR / Billetera</option>
                                </select>
                                @error('type') <span class="text-red-500 text-[10px] font-bold uppercase mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <input type="checkbox" wire:model="is_active" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-lg">
                                <label class="block text-sm text-gray-700 font-bold uppercase tracking-tight">Método Activo</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg px-6 py-2.5 bg-indigo-600 text-xs font-black uppercase tracking-widest text-white hover:bg-indigo-700 focus:outline-none transition">
                            {{ $methodId ? 'Actualizar' : 'Guardar Método' }}
                        </button>
                        <button wire:click="$set('isOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-6 py-2.5 bg-white text-xs font-black uppercase tracking-widest text-gray-500 hover:bg-gray-50 focus:outline-none transition sm:mt-0">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
