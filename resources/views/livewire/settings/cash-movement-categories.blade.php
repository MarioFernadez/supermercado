<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
            
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('settings.general') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 dark:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Categorías de Movimientos</h2>
                </div>
                <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl text-xs flex items-center gap-1.5 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nueva Categoría
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl text-xs dark:bg-emerald-900/30 dark:text-emerald-400" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <!-- Filtros -->
            <div class="mb-6">
                <input wire:model.live="search" type="text" placeholder="Buscar categoría..." class="w-full sm:w-1/3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 shadow-xs text-xs py-2 px-3">
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto border border-gray-100 dark:border-gray-700 rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50/80 dark:bg-gray-900/60">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nombre</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Aplica a</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Estado</th>
                            <th class="px-6 py-3.5 text-right text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-900 dark:text-white">{{ $cat->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cat->type === 'in' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : ($cat->type === 'out' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300' : 'bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300') }}">
                                        {{ $cat->type === 'in' ? 'Ingresos' : ($cat->type === 'out' ? 'Egresos' : 'Ambos') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cat->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $cat->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-2">
                                    <button wire:click="edit('{{ $cat->id }}')" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400">Editar</button>
                                    <button wire:click="delete('{{ $cat->id }}')" wire:confirm="¿Seguro que deseas eliminar esta categoría?" class="text-rose-600 hover:text-rose-900 font-semibold dark:text-rose-400">Eliminar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-xs italic dark:text-gray-500">No hay categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
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
