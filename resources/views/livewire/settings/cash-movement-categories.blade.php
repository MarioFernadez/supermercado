<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
            
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('settings.general') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 dark:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white uppercase tracking-tight">Categorías de Movimientos</h2>
                </div>
                <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nueva Categoría
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/40 dark:text-green-400" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <!-- Filtros -->
            <div class="mb-6">
                <input wire:model.live="search" type="text" placeholder="Buscar categoría..." class="w-full sm:w-1/3 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:shadow-none">
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto border border-gray-100 dark:border-gray-700 rounded-xl">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">Aplica a</th>
                            <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition group">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">{{ $cat->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 uppercase font-black text-[10px] tracking-widest dark:text-gray-400">
                                    @if($cat->type == 'income')
                                        <span class="px-2 py-1 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg border border-green-100 dark:border-green-800">Ingresos</span>
                                    @elseif($cat->type == 'expense')
                                        <span class="px-2 py-1 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg border border-red-100 dark:border-red-800">Egresos</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg border border-blue-100 dark:border-blue-800">Ambos</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-[10px] font-black uppercase rounded-full {{ $cat->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300' }}">
                                        {{ $cat->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit('{{ $cat->id }}')" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">Editar</button>
                                    <button onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" wire:click="delete('{{ $cat->id }}')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Eliminar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 italic">No hay categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full font-sans border border-gray-100 dark:border-gray-700">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-8 sm:pb-4">
                        <h3 class="text-xl leading-6 font-black text-gray-900 dark:text-white mb-6 uppercase tracking-tight" id="modal-title">
                            {{ $categoryId ? 'Editar Categoría' : 'Nueva Categoría de Movimiento' }}
                        </h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Nombre del Motivo (ej: Reposición de Sencillo)</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition dark:shadow-none">
                                @error('name') <span class="text-red-500 text-[10px] font-bold uppercase mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Tipo de Movimiento</label>
                                <select wire:model="type" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition font-bold text-sm dark:shadow-none">
                                    <option value="income">Sólo Ingresos 🟢</option>
                                    <option value="expense">Sólo Egresos 🔴</option>
                                    <option value="both">Ambos ⚪</option>
                                </select>
                                @error('type') <span class="text-red-500 text-[10px] font-bold uppercase mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <input type="checkbox" wire:model="is_active" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg dark:text-indigo-400">
                                <label class="block text-sm text-gray-700 dark:text-gray-300 font-bold uppercase tracking-tight">Categoría Activa</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg px-6 py-2.5 bg-indigo-600 text-xs font-black uppercase tracking-widest text-white hover:bg-indigo-700 focus:outline-none transition">
                            {{ $categoryId ? 'Actualizar' : 'Guardar Categoría' }}
                        </button>
                        <button wire:click="$set('isOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm px-6 py-2.5 bg-white dark:bg-gray-800 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none transition sm:mt-0 dark:shadow-none">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
