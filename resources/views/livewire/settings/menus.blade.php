<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3">
                    <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar menús..." class="shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-end gap-2 w-full md:w-auto">
                    <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg">
                        Nuevo Elemento
                    </button>
                </div>
            </div>

            <!-- Modal Create/Edit -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $menu_id ? 'Editar Menú' : 'Crear Menú' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" class="shadow border rounded w-full py-2 px-3 text-gray-700" wire:model="name">
                            @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Enlace:</label>
                            <select wire:model="type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <option value="custom">URL Personalizada</option>
                                <option value="category">Categoría</option>
                                <option value="route">Ruta Laravel</option>
                            </select>
                        </div>

                        @if($type === 'custom' || $type === 'route')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">{{ $type === 'custom' ? 'URL' : 'Nombre de Ruta' }}:</label>
                            <input type="text" class="shadow border rounded w-full py-2 px-3 text-gray-700" wire:model="url">
                        </div>
                        @endif

                        @if($type === 'category')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">ID Categoría:</label>
                            <input type="number" class="shadow border rounded w-full py-2 px-3 text-gray-700" wire:model="reference_id">
                        </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Orden:</label>
                            <input type="number" class="shadow border rounded w-full py-2 px-3 text-gray-700" wire:model="order">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Menú Padre (Para submenús):</label>
                            <select wire:model="parent_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <option value="">Ninguno (Raíz)</option>
                                @foreach($parentMenus as $parent)
                                    @if($parent->id !== $menu_id)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="is_active" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 text-gray-700">Activo</span>
                            </label>
                        </div>
                    </form>
                </x-slot>

                <x-slot name="footer">
                    <button wire:click="closeModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancelar
                    </button>
                    <button wire:click="store()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar
                    </button>
                </x-slot>
            </x-dialog-modal>

            <!-- Lista de Menús -->
            <div class="overflow-x-auto mt-4 rounded-xl shadow ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Orden</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Nombre</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">URL / Destino</th>
                            <th class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Estado</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-xs font-semibold text-gray-900 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($menus as $menu)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $menu->order }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 font-medium">
                                {{ $menu->parent_id ? '— ' : '' }}{{ $menu->name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $menu->url }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($menu->is_active)
                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Activo</span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Inactivo</span>
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <button wire:click="edit({{ $menu->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                                <button wire:click="delete({{ $menu->id }})" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No hay menús registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $menus->links() }}
            </div>

        </div>
    </div>
</div>
