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

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3 space-y-2">
                    <div class="flex items-center">
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-indigo-200 shadow-sm flex items-center gap-1 dark:text-indigo-400 dark:shadow-none">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            {{ $categories->total() }} Categorías
                        </span>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition dark:text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar categorías..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:shadow-none dark:border-gray-700 dark:text-gray-300 dark:bg-gray-900">
                    </div>
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-end gap-2 w-full md:w-auto">
                    @if(count($selected) > 0)
                        <button wire:click="deleteSelected" 
                                onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"
                                class="bg-red-50 text-red-600 hover:bg-red-100 font-bold py-2.5 px-4 rounded-xl transition flex items-center dark:bg-red-900/30">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Borrar ({{ count($selected) }})
                        </button>
                    @endif
                    <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Nueva Categoría
                    </button>
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $categoryId ? 'Editar Categoría' : 'Crear Categoría' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store">
                        <button type="submit" class="hidden"></button>
                        <div class="mt-4">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Nombre:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900" id="name" wire:model="name">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="parent_id" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">Categoría Padre (Opcional):</label>
                                <select wire:model="parent_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-900">
                                    <option value="">Ninguna</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="is_active" class="form-checkbox h-5 w-5 text-indigo-600 dark:text-indigo-400 dark:bg-gray-900">
                                    <span class="ml-2 text-gray-700 dark:text-gray-300">Activo</span>
                                </label>
                            </div>

                            <!-- Imagen de Categoría -->
                            <div class="border-t pt-4 mt-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-300">📸 Imagen de la Categoría:</label>
                                <div class="flex items-center gap-4">
                                    @if ($category_image)
                                        <img src="{{ $category_image->temporaryUrl() }}" class="h-24 w-24 object-contain rounded-xl border bg-gray-50 shadow-sm dark:bg-gray-900 dark:shadow-none">
                                    @elseif ($category_image_path)
                                        <img src="{{ Storage::url($category_image_path) }}" class="h-24 w-24 object-contain rounded-xl border bg-gray-50 shadow-sm dark:bg-gray-900 dark:shadow-none">
                                    @else
                                        <div class="h-24 w-24 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300 dark:border-gray-700">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <input type="file" wire:model="category_image" id="category_image" class="hidden dark:bg-gray-900 dark:text-gray-300">
                                        <label for="category_image" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 font-bold rounded-xl hover:bg-indigo-100 transition text-[10px] uppercase tracking-widest dark:bg-indigo-900/30 dark:text-indigo-400">
                                            Seleccionar Imagen
                                        </label>
                                        <p class="text-[9px] text-gray-400 mt-1 uppercase font-black tracking-tighter dark:text-gray-500">Fondo blanco recomendado (800x800px)</p>
                                        <div wire:loading wire:target="category_image" class="text-[10px] text-indigo-600 font-bold dark:text-indigo-400">Procesando...</div>
                                    </div>
                                </div>
                                @error('category_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

            <!-- Categories Grid (Desktop & Mobile) -->
            <div class="w-full">
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto -mx-4">
                    <div class="inline-block min-w-full align-middle font-sans">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400 dark:bg-gray-900 dark:text-gray-400">
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <th class="px-6 py-4 text-left w-10">
                                        <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4 dark:border-gray-600 dark:text-indigo-400 dark:bg-gray-900"> 
                                    </th>
                                    <th class="px-6 py-4 text-left w-16">Imagen</th>
                                    <th class="px-6 py-4 text-left">Nombre</th>
                                    <th class="px-6 py-4 text-left">Slug</th>
                                    <th class="px-6 py-4 text-left">Padre</th>
                                    <th class="px-6 py-4 text-center">Estado</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($categories as $category)
                                    <tr class="hover:bg-indigo-50/30 transition group">
                                        <td class="px-6 py-4">
                                            <input type="checkbox" wire:model.live="selected" value="{{ $category->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4 dark:border-gray-600 dark:text-indigo-400">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="h-10 w-10 rounded-lg bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center dark:bg-gray-900 dark:border-gray-700">
                                                @if($category->image_path)
                                                    <img src="{{ Storage::url($category->image_path) }}" class="h-full w-full object-contain">
                                                @else
                                                    <svg class="w-5 h-5 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">{{ $category->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-400 font-mono dark:text-gray-500">{{ $category->slug }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 font-medium dark:text-gray-400">{{ $category->parent ? $category->parent->name : '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $category->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2 transition">
                                                <button wire:click="edit('{{ $category->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50 dark:text-indigo-400" title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <button wire:click="delete('{{ $category->id }}')" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
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

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-4 font-sans">
                    @foreach($categories as $category)
                        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3 pr-12">
                                    <div class="h-12 w-12 rounded-xl bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center flex-shrink-0 dark:bg-gray-900 dark:border-gray-700">
                                        @if($category->image_path)
                                            <img src="{{ Storage::url($category->image_path) }}" class="h-full w-full object-contain">
                                        @else
                                            <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight dark:text-white">{{ $category->name }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded dark:text-gray-500 dark:bg-gray-900">/{{ $category->slug }}</span>
                                            <span class="text-[10px] uppercase font-black {{ $category->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} px-1.5 py-0.5 rounded">
                                                {{ $category->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm text-gray-600 mb-4 dark:text-gray-400">
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 dark:text-gray-500">Padre</span>
                                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $category->parent ? $category->parent->name : 'N/A' }}</span>
                            </div>

                            <div class="flex gap-2 mt-4 pt-4 border-t border-dashed border-gray-100 dark:border-gray-700">
                                <button wire:click="edit('{{ $category->id }}')" class="flex-1 bg-indigo-50 text-indigo-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-indigo-900/30 dark:text-indigo-400">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Editar
                                </button>
                                <button wire:click="delete('{{ $category->id }}')" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="flex-1 bg-red-50 text-red-500 font-bold py-2 rounded-xl text-xs flex items-center justify-center dark:bg-red-900/30">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Borrar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
