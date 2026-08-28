<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
            
            {{-- Header & Toolbar --}}
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Gestor de Medios</h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">Administra los archivos e imágenes del sistema</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button wire:click="$set('showNewFolderModal', true)" class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold py-2 px-4 rounded-xl transition text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Nueva Carpeta
                    </button>
                    
                    <div class="relative">
                        <input type="file" wire:model="uploads" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="file-upload">
                        <label for="file-upload" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2 px-4 rounded-xl transition text-xs flex items-center gap-2 shadow-sm cursor-pointer relative z-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span wire:loading.remove wire:target="uploads">Subir Archivos</span>
                            <span wire:loading wire:target="uploads">Subiendo...</span>
                        </label>
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-emerald-50 text-emerald-700 p-4 border-b border-emerald-100 text-xs font-bold uppercase tracking-wide flex items-center gap-2 dark:bg-emerald-900/30 dark:border-emerald-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row h-[70vh]">
                
                {{-- Main Media Area --}}
                <div class="flex-1 flex flex-col bg-white dark:bg-gray-800 relative">
                    
                    {{-- Breadcrumbs --}}
                    <div class="flex items-center gap-2 px-6 py-3 border-b border-gray-100 dark:border-gray-700 text-sm">
                        <button wire:click="goToRoot" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Inicio
                        </button>
                        
                        @foreach($this->breadcrumbs as $breadcrumb)
                            <span class="text-gray-400 dark:text-gray-600">/</span>
                            <button wire:click="openDirectory('{{ $breadcrumb['path'] }}')" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">
                                {{ $breadcrumb['name'] }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Loading Overlay --}}
                    <div wire:loading wire:target="openDirectory, goUp, goToRoot, deleteSelected, uploads" class="absolute inset-0 bg-white/70 dark:bg-gray-800/70 z-10 flex items-center justify-center backdrop-blur-sm">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                    </div>

                    {{-- Files Grid --}}
                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50/30 dark:bg-gray-900/30">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                            
                            {{-- Back Button --}}
                            @if(!empty($currentDirectory))
                                <div wire:click="goUp" class="aspect-square bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition group shadow-sm">
                                    <svg class="w-10 h-10 text-gray-400 group-hover:text-indigo-500 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-300">Atrás</span>
                                </div>
                            @endif

                            {{-- Directories --}}
                            @foreach($this->directories as $dir)
                                <div wire:click="openDirectory('{{ $dir['path'] }}')" class="aspect-square bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-indigo-300 hover:shadow-md transition group p-2 text-center shadow-sm">
                                    <svg class="w-14 h-14 text-indigo-200 dark:text-indigo-900 group-hover:text-indigo-400 transition mb-2" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300 truncate w-full px-2" title="{{ $dir['name'] }}">{{ $dir['name'] }}</span>
                                </div>
                            @endforeach

                            {{-- Files --}}
                            @foreach($this->files as $file)
                                <div wire:click="selectFile('{{ $file['path'] }}')" class="aspect-square rounded-xl cursor-pointer relative group overflow-hidden border-2 transition {{ $selectedFile && $selectedFile['path'] === $file['path'] ? 'border-indigo-500 shadow-md ring-2 ring-indigo-200 dark:ring-indigo-900' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300' }}">
                                    @if($file['is_image'])
                                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-100 dark:bg-gray-800 flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            <span class="text-[10px] font-bold text-gray-500 uppercase">{{ pathinfo($file['name'], PATHINFO_EXTENSION) }}</span>
                                        </div>
                                    @endif
                                    
                                    {{-- Selected Overlay --}}
                                    @if($selectedFile && $selectedFile['path'] === $file['path'])
                                        <div class="absolute inset-0 bg-indigo-600/20 flex items-start justify-end p-2">
                                            <div class="w-5 h-5 bg-indigo-600 rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                        
                        @if(empty($this->directories) && empty($this->files))
                            <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm font-medium">Esta carpeta está vacía.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar Details --}}
                <div class="w-full md:w-80 bg-gray-50 dark:bg-gray-800/80 border-l border-gray-100 dark:border-gray-700 p-6 overflow-y-auto">
                    @if($selectedFile)
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 dark:text-gray-500">Detalles del Archivo</h3>
                        
                        <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                            @if($selectedFile['is_image'])
                                <a href="{{ $selectedFile['url'] }}" target="_blank" class="block aspect-video bg-gray-100 dark:bg-gray-800 relative group">
                                    <img src="{{ $selectedFile['url'] }}" alt="{{ $selectedFile['name'] }}" class="w-full h-full object-contain">
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </div>
                                </a>
                            @else
                                <div class="aspect-video bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4 text-sm">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider dark:text-gray-500">Nombre</p>
                                <p class="font-medium text-gray-900 dark:text-white break-all">{{ $selectedFile['name'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider dark:text-gray-500">Subido el</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $selectedFile['last_modified'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider dark:text-gray-500">Tamaño</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $selectedFile['size'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider dark:text-gray-500 mb-1">URL Pública</p>
                                <div class="flex">
                                    <input type="text" readonly value="{{ $selectedFile['url'] }}" class="flex-1 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-l-lg text-xs p-2 text-gray-600 dark:text-gray-300 focus:outline-none">
                                    <button onclick="navigator.clipboard.writeText('{{ $selectedFile['url'] }}'); alert('URL copiada al portapapeles');" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 px-3 rounded-r-lg border border-l-0 border-gray-200 dark:border-gray-700 transition" title="Copiar URL">
                                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button wire:click="deleteSelected" onclick="confirm('¿Estás seguro de que quieres eliminar este archivo? Esta acción no se puede deshacer.') || event.stopImmediatePropagation()" class="w-full bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 font-bold py-2.5 px-4 rounded-xl transition text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Eliminar Archivo
                            </button>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-400 text-center">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm font-medium">Selecciona un archivo para ver sus detalles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Nueva Carpeta --}}
    <x-dialog-modal wire:model="showNewFolderModal">
        <x-slot name="title">
            <span class="font-black uppercase tracking-tight">Crear Nueva Carpeta</span>
        </x-slot>
        <x-slot name="content">
            <div class="mt-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nombre de la carpeta</label>
                <input type="text" wire:model.defer="newFolderName" class="shadow-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-xl w-full py-3 px-4 text-sm focus:ring-2 focus:ring-indigo-500" placeholder="ej_fotos_verano" @keydown.enter="$wire.createFolder()">
                @error('newFolderName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showNewFolderModal', false)">Cancelar</x-secondary-button>
            <button wire:click="createFolder" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition text-xs uppercase tracking-widest">
                Crear
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
