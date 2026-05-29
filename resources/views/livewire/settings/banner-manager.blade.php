<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-gray-800">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">🎞️ Gestión de Carrusel</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Administra los banners que aparecen en la página principal del e-commerce.</p>
                </div>
                <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo Banner
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3 dark:bg-green-900/40 dark:shadow-none" role="alert">
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($banners as $banner)
                    <div class="border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition bg-white group dark:shadow-none dark:bg-gray-800">
                        <div class="relative h-48 bg-gray-100 dark:bg-gray-700">
                            <img src="{{ Storage::url($banner->image_path) }}" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <button wire:click="toggleActive('{{ $banner->id }}')" class="px-2 py-1 rounded-full text-[10px] font-black uppercase {{ $banner->is_active ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }}">
                                    {{ $banner->is_active ? 'Activo' : 'Oculto' }}
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 truncate dark:text-white">{{ $banner->title ?: 'Sin título' }}</h3>
                            <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ $banner->subtitle ?: 'Sin subtítulo' }}</p>
                            
                            <div class="mt-4 flex justify-between items-center pt-4 border-t border-dashed">
                                <span class="text-xs font-bold text-gray-400 dark:text-gray-500">Orden: {{ $banner->order }}</span>
                                <div class="flex gap-2">
                                    <button wire:click="edit('{{ $banner->id }}')" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition dark:text-indigo-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button onclick="confirm('¿Eliminar este banner?') || event.stopImmediatePropagation()" wire:click="delete('{{ $banner->id }}')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(count($banners) == 0)
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-gray-400 dark:text-gray-500">No hay banners configurados.</p>
                </div>
            @endif

            <!-- Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $bannerId ? 'Editar Banner' : 'Nuevo Banner' }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título (Opcional)</label>
                            <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subtítulo (Opcional)</label>
                            <input type="text" wire:model="subtitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link (Opcional)</label>
                                <input type="text" wire:model="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300" placeholder="https://...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Orden</label>
                                <input type="number" wire:model="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen del Banner</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600">
                                <div class="space-y-1 text-center">
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="mx-auto h-32 w-auto rounded border">
                                    @else
                                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-44h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    @endif
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="image-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 dark:bg-gray-800 dark:text-indigo-400">
                                            <span>Subir un archivo</span>
                                            <input id="image-upload" wire:model="image" type="file" class="sr-only dark:bg-gray-900 dark:text-gray-300">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB (Recomendado: 1200x400px)</p>
                                </div>
                            </div>
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>
                    <x-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
                        Guardar Banner
                    </x-button>
                </x-slot>
            </x-dialog-modal>

        </div>
    </div>
</div>
