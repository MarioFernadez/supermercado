<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 dark:bg-gray-800">
            
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-gray-600 dark:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Unidades de Medida</h2>
                </div>
                <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl text-xs flex items-center gap-1.5 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nueva Unidad
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl text-xs dark:bg-emerald-900/30 dark:text-emerald-400" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <!-- Filtros -->
            <div class="mb-6">
                <input wire:model.live="search" type="text" placeholder="Buscar unidad..." class="w-full sm:w-1/3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 shadow-xs text-xs py-2 px-3 dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto border border-gray-100 rounded-2xl dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50/80 dark:bg-gray-900/60">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nombre</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Abreviación</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Estado</th>
                            <th class="px-6 py-3.5 text-right text-[11px] font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($units as $unit)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/40 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-900 dark:text-white">{{ $unit->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 font-mono dark:text-gray-400">{{ $unit->abbreviation }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $unit->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $unit->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-2">
                                    <button wire:click="edit('{{ $unit->id }}')" class="text-indigo-600 hover:text-indigo-900 font-semibold dark:text-indigo-400">Editar</button>
                                    <button wire:click="delete('{{ $unit->id }}')" wire:confirm="¿Seguro que deseas eliminar esta unidad?" class="text-rose-600 hover:text-rose-900 font-semibold dark:text-rose-400">Eliminar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-xs italic dark:text-gray-500">No hay unidades registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $units->links() }}
            </div>

            <!-- Modal Formulario -->
            @if($showModal)
                <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        
                        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <form wire:submit.prevent="save">
                                <div class="bg-white px-6 pt-6 pb-4 dark:bg-gray-800">
                                    <h3 class="text-lg font-bold text-gray-900 mb-5 dark:text-white" id="modal-title">
                                        {{ $isEditing ? 'Editar Unidad de Medida' : 'Nueva Unidad de Medida' }}
                                    </h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Nombre (ej: Kilogramo)</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition dark:border-gray-700 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                                @error('name') <span class="text-red-500 text-[10px] font-bold uppercase mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Abreviación (ej: kg)</label>
                                <input type="text" wire:model="abbreviation" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition dark:border-gray-700 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                                @error('abbreviation') <span class="text-red-500 text-[10px] font-bold uppercase mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100 dark:bg-gray-900 dark:border-gray-700">
                                <input type="checkbox" wire:model="is_active" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-lg dark:text-indigo-400 dark:border-gray-600 dark:bg-gray-900">
                                <label class="block text-sm text-gray-700 font-bold uppercase tracking-tight dark:text-gray-300">Unidad Activa</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl dark:bg-gray-900">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg px-6 py-2.5 bg-indigo-600 text-xs font-black uppercase tracking-widest text-white hover:bg-indigo-700 focus:outline-none transition">
                            {{ $unitId ? 'Actualizar' : 'Guardar Unidad' }}
                        </button>
                        <button wire:click="$set('isOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-6 py-2.5 bg-white text-xs font-black uppercase tracking-widest text-gray-500 hover:bg-gray-50 focus:outline-none transition sm:mt-0 dark:border-gray-700 dark:shadow-none dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
