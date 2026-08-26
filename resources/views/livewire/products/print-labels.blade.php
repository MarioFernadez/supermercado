<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                    🖨️ Imprimir Etiquetas
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configura el formato y la cantidad de etiquetas a imprimir para los productos seleccionados.</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>

        @if (session()->has('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Configuración -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Opciones de Formato -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Formato de Impresión</h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 p-3 border rounded-xl cursor-pointer transition-colors {{ $format === 'a4' ? 'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/20 dark:border-indigo-800' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            <input type="radio" wire:model="format" value="a4" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <span class="block font-bold text-gray-900 dark:text-white">Formato A4 (Plantilla)</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Ideal para impresoras de hogar/oficina usando hojas de etiquetas pre-cortadas. (Imprime varias etiquetas por página).</span>
                            </div>
                        </label>
                        
                        <label class="flex items-start gap-3 p-3 border rounded-xl cursor-pointer transition-colors {{ $format === 'thermal' ? 'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/20 dark:border-indigo-800' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                            <input type="radio" wire:model="format" value="thermal" class="mt-1 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <span class="block font-bold text-gray-900 dark:text-white">Rollo Térmico (50x25mm)</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Ideal para impresoras de etiquetas dedicadas (Zebra, Xprinter). Genera una etiqueta individual por página.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Opciones de Diseño -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Opciones de Diseño</h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="include_name" class="rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Incluir Nombre del Producto</span>
                        </label>
                        
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="include_price" class="rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Incluir Precio de Venta</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button wire:click="generate" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Generar Vista Previa e Imprimir
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-2">Se abrirá en una nueva pestaña</p>
                </div>
            </div>

            <!-- Columna Derecha: Cantidades -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Productos Seleccionados</h3>
                        <span class="text-xs font-semibold text-gray-500">{{ count($products) }} productos</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider">Producto</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código (SKU)</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cantidad de Etiquetas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($products as $product)
                                    @if(empty($product->sku))
                                        <tr class="bg-red-50/50 dark:bg-red-900/10">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden flex items-center justify-center">
                                                        @if($product->image_path)
                                                            <img class="h-10 w-10 object-cover" src="{{ Storage::url($product->image_path) }}" alt="">
                                                        @else
                                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $product->name }}</div>
                                                        <div class="text-xs text-red-500">Error: No tiene código cargado</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-400">-</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="text-xs font-bold text-red-500 bg-red-100 px-2 py-1 rounded">No se puede imprimir</span>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden flex items-center justify-center">
                                                        @if($product->image_path)
                                                            <img class="h-10 w-10 object-cover" src="{{ Storage::url($product->image_path) }}" alt="">
                                                        @else
                                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $product->name }}</div>
                                                        <div class="text-xs text-gray-500">₲ {{ format_pyg($product->price_sale) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-gray-800 dark:text-gray-200">{{ $product->sku }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <input type="number" min="0" max="999" wire:model="quantities.{{ $product->id }}" class="w-20 text-center shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">No se encontraron productos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-print-tab', (data) => {
            window.open(data.url, '_blank');
        });
    });
</script>
