<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm font-bold">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/2 flex flex-col sm:flex-row gap-2">
                    <div class="relative group flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por producto (nombre o SKU)..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                    <div class="w-full sm:w-48">
                        <select wire:model.live="typeFilter" class="shadow-sm border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <option value="">Todos los tipos</option>
                            <option value="in">Entradas (In)</option>
                            <option value="out">Salidas (Out)</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex w-full md:w-auto">
                    <button wire:click="openModal" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center justify-center w-full md:w-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Nuevo Ajuste
                    </button>
                </div>
            </div>

            <!-- Movimientos Table -->
            <div class="w-full">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle font-sans">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400">
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-4 text-left">Fecha</th>
                                    <th class="px-6 py-4 text-left">Producto</th>
                                    <th class="px-6 py-4 text-center">Tipo</th>
                                    <th class="px-6 py-4 text-center">Cant.</th>
                                    <th class="px-6 py-4 text-left">Motivo</th>
                                    <th class="px-6 py-4 text-left">Usuario</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($movements as $movement)
                                    <tr class="hover:bg-indigo-50/30 transition group">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $movement->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                            {{ $movement->product->name ?? 'Producto Eliminado' }}
                                            @if($movement->product)
                                            <span class="block text-[10px] text-gray-400 font-normal">Ref: {{ $movement->product->sku }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($movement->type === 'in')
                                                <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full bg-emerald-100 text-emerald-700">
                                                    Entrada
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 inline-flex text-[10px] font-black uppercase rounded-full bg-red-100 text-red-700">
                                                    Salida
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-bold {{ $movement->type === 'in' ? 'text-emerald-600' : 'text-red-600' }}">
                                            {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $movement->reason ?? '-' }}
                                            @if($movement->notes)
                                            <span class="block text-xs text-gray-400 mt-1" title="{{ $movement->notes }}">{{ Str::limit($movement->notes, 30) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $movement->user->name ?? 'Sistema' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 font-medium">
                                            No se encontraron movimientos de inventario.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $movements->links() }}
            </div>
            
            <!-- Crear Movimiento Modal -->
            @if($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" wire:click="$set('showModal', false)"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <form wire:submit.prevent="save">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-black text-gray-900 mb-6 uppercase tracking-tight" id="modal-title">
                                    Registrar Ajuste de Inventario
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-1">Producto <span class="text-red-500">*</span></label>
                                        <select wire:model="productId" class="shadow-sm border border-gray-200 rounded-xl w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" required>
                                            <option value="">Seleccione un producto...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }} (SKU: {{ $product->sku }}) - Stock actual: {{ $product->stock }}</option>
                                            @endforeach
                                        </select>
                                        @error('productId') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <div class="w-full sm:w-1/2">
                                            <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-1">Tipo de Movimiento <span class="text-red-500">*</span></label>
                                            <select wire:model="type" class="shadow-sm border border-gray-200 rounded-xl w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" required>
                                                <option value="in">Entrada (+)</option>
                                                <option value="out">Salida (-)</option>
                                            </select>
                                            @error('type') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-full sm:w-1/2">
                                            <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-1">Cantidad <span class="text-red-500">*</span></label>
                                            <input type="number" wire:model="quantity" min="1" class="shadow-sm border border-gray-200 rounded-xl w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" required>
                                            @error('quantity') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-1">Motivo / Razón</label>
                                        <input type="text" wire:model="reason" placeholder="Ej: Rotura, Obsequio, Error conteo..." class="shadow-sm border border-gray-200 rounded-xl w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        @error('reason') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-1">Notas Adicionales</label>
                                        <textarea wire:model="notes" rows="2" class="shadow-sm border border-gray-200 rounded-xl w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"></textarea>
                                        @error('notes') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                                    Registrar
                                </button>
                                <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
