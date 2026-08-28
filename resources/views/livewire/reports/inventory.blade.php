<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-gray-800">
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight dark:text-white">Reporte de Inventario</h2>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl transition text-xs shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Exportar a PDF / Imprimir
                    </button>
                </div>

            </div>

            <!-- Dashboard de Inventario -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Items -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-indigo-500 dark:bg-gray-900/50 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider dark:text-gray-400">Total Productos</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($this->totals['products_count'], 0) }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total Value -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-blue-500 dark:bg-gray-900/50 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider dark:text-gray-400">Valor Inventario (Costo)</p>
                            <p class="text-xl font-bold text-gray-900 font-mono dark:text-white">₲ {{ format_pyg($this->totals['total_value']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-yellow-500 dark:bg-gray-900/50 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-yellow-50 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider dark:text-gray-400">Stock Bajo</p>
                            <p class="text-xl font-bold text-yellow-600">{{ $this->totals['low_stock'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-red-500 dark:bg-gray-900/50 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider dark:text-gray-400">Sin Stock</p>
                            <p class="text-xl font-bold text-red-600">{{ $this->totals['out_of_stock'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 mb-8 dark:border-gray-700 dark:bg-gray-900/50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1 dark:text-gray-400">Buscar Producto</label>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Nombre o SKU..." 
                               class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition text-sm py-2 px-3 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1 dark:text-gray-400">Categoría</label>
                        <select wire:model.live="filterCategory" 
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition text-sm py-2 px-3 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Todas las Categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1 dark:text-gray-400">Proveedor</label>
                        <select wire:model.live="filterSupplier" 
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition text-sm py-2 px-3 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Todos los Proveedores</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1 dark:text-gray-400">Estado de Existencia</label>
                        <select wire:model.live="filterStock" 
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition text-sm py-2 px-3 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Todos los Estados</option>
                            <option value="ok">Stock OK (Suficiente)</option>
                            <option value="low">⚠️ Stock Bajo</option>
                            <option value="out">🛑 Sin Stock</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded-2xl border border-gray-100 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                <table class="w-full text-left border-collapse font-sans">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-semibold tracking-wider border-b border-gray-100 dark:text-gray-400 dark:border-gray-700 dark:bg-gray-900/60">
                            <th class="px-6 py-4">Producto / Código</th>
                            <th class="px-6 py-4">Categoría / Prov.</th>
                            <th class="px-6 py-4 text-center">Existencia</th>
                            <th class="px-6 py-4 text-right">Precio Costo</th>
                            <th class="px-6 py-4 text-right">Valor en Stock</th>
                            <th class="px-6 py-4 text-right w-10">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($products as $product)
                            @php
                                $stockStatus = 'ok';
                                if($product->manage_stock) {
                                    $totalStock = $product->has_variations ? $product->variations->sum('stock') : $product->stock;
                                    if($totalStock <= 0) $stockStatus = 'out';
                                    elseif($totalStock <= $product->min_stock) $stockStatus = 'low';
                                }
                            @endphp
                            <tr class="group hover:bg-gray-50/60 transition duration-150 {{ $product->has_variations ? 'bg-gray-50/30' : '' }} dark:hover:bg-gray-700/30">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition dark:text-white">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400 font-mono dark:text-gray-400">{{ $product->sku ?? 'SIN SKU' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 font-medium dark:text-white">{{ $product->category->name ?? '—' }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-400">{{ $product->supplier->name ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->has_variations)
                                        <div class="flex flex-col items-center gap-1">
                                            @foreach($product->variations as $v)
                                                <div class="flex items-center gap-2 text-[10px]">
                                                    <span class="text-gray-400 uppercase truncate max-w-[80px] dark:text-gray-400">{{ $v->name }}:</span>
                                                    <span class="font-semibold tabular-nums {{ $v->stock <= $product->min_stock ? 'text-red-600' : 'text-gray-700 dark:text-gray-200' }}">{{ number_format($v->stock, 0) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full tabular-nums {{ $stockStatus === 'out' ? 'bg-red-50 text-red-700 border border-red-200/60 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800/40' : ($stockStatus === 'low' ? 'bg-amber-50 text-amber-700 border border-amber-200/60 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800/40' : 'bg-emerald-50 text-emerald-700 border border-emerald-200/60 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/40') }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $stockStatus === 'out' ? 'bg-red-500' : ($stockStatus === 'low' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                            {{ $product->manage_stock ? number_format($product->stock, 2, ',', '.') : '∞' }}
                                        </span>
                                    @endif
                                    @if($product->manage_stock && $product->min_stock > 0 && !$product->has_variations)
                                        <div class="text-[10px] text-gray-400 mt-1 dark:text-gray-400">Mín: {{ number_format($product->min_stock, 0) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white tabular-nums"><span class="text-xs text-gray-400 font-normal mr-0.5">₲</span>{{ format_pyg($product->price_cost) }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-semibold tabular-nums {{ ($product->has_variations ? $product->variations->sum('stock') : $product->stock) > 0 ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-300 dark:text-gray-600' }}">
                                        @if($product->has_variations)
                                            <span class="text-xs text-gray-400 font-normal mr-0.5">₲</span>{{ format_pyg($product->variations->sum(fn($v) => $v->stock * ($v->price_cost ?: $product->price_cost))) }}
                                        @else
                                            <span class="text-xs text-gray-400 font-normal mr-0.5">₲</span>{{ $product->manage_stock ? format_pyg($product->stock * $product->price_cost) : '—' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($product->manage_stock && !$product->has_variations)
                                        <button x-on:click="$dispatch('open-stock-modal', { id: {{ $product->id }}, name: '{{ $product->name }}', stock: {{ $product->stock }} })" class="text-gray-400 hover:text-indigo-600 transition p-1 dark:text-gray-400" title="Ajuste Rápido">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        @endif
                                        <a href="{{ route('products.index', ['search' => $product->name]) }}" class="text-gray-400 hover:text-gray-600 transition p-1 dark:text-gray-400" title="Editar Producto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        <p class="text-gray-400 font-medium dark:text-gray-400">No se encontraron productos en el inventario.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- Modal de Ajuste de Stock --}}
    <div x-data="{ open: false, id: null, name: '', stock: 0 }"
         x-on:open-stock-modal.window="open = true; id = $event.detail.id; name = $event.detail.name; stock = $event.detail.stock"
         x-show="open"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full dark:bg-gray-800">
                <div class="bg-indigo-600 px-8 py-6">
                    <h3 class="text-white font-black text-xl uppercase tracking-tight">Ajuste de Stock</h3>
                    <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest mt-1" x-text="name"></p>
                </div>
                <div class="p-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Nuevo Stock Físico</label>
                            <input type="number" x-model="stock" class="shadow-sm border border-gray-200 rounded-2xl w-full py-4 text-center text-2xl font-black text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition dark:shadow-none dark:border-gray-700 dark:text-white dark:bg-gray-900">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-4 flex justify-end gap-3 dark:bg-gray-900">
                    <button x-on:click="open = false" class="text-xs font-black uppercase text-gray-400 tracking-widest px-4 dark:text-gray-400">Cancelar</button>
                    <button x-on:click="$wire.adjustStock(id, stock); open = false" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition text-xs uppercase tracking-widest shadow-lg shadow-indigo-100">
                        Confirmar Ajuste
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

