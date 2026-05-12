<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            @if (session()->has('message'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="w-full md:w-1/3 space-y-2">
                    <div class="flex items-center">
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-indigo-200 shadow-sm flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            {{ $products->total() }} Productos
                        </span>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por Nombre o SKU..." autocomplete="off" class="pl-10 shadow-sm appearance-none border border-gray-200 rounded-xl w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-end gap-2 w-full md:w-auto mt-2 md:mt-0">
                    @if(count($selected) > 0)
                        <button wire:click="deleteSelected" 
                                onclick="confirm('¿Estás seguro de eliminar los productos seleccionados?') || event.stopImmediatePropagation()"
                                class="bg-red-50 text-red-600 hover:bg-red-100 font-bold py-2 px-4 rounded-xl transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Borrar ({{ count($selected) }})
                        </button>
                    @endif
                    <a href="{{ route('products.export') }}" class="bg-green-50 text-green-600 hover:bg-green-100 font-bold py-2 px-4 rounded-xl transition flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Exportar
                    </a>
                    <button x-data @click="$dispatch('open-import-modal')" class="bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold py-2 px-4 rounded-xl transition flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Importar
                    </button>
                    <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl transition shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Nuevo Producto
                    </button>

                    <a href="{{ route('settings.units') }}" class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition shadow-sm" title="Gestionar Unidades">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Import Modal -->
            <div x-data="{ show: false }" x-show="show" @open-import-modal.window="show = true" @close-import-modal.window="show = false" style="display: none;">
                <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full font-sans border border-gray-100">
                            <div class="bg-indigo-600 px-6 py-6 text-white">
                                <h3 class="text-xl font-black uppercase tracking-tight flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Importar Productos
                                </h3>
                                <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest mt-1 opacity-80">Importación masiva mediante Excel/CSV</p>
                            </div>
                            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="bg-white px-8 pt-8 pb-6">
                                    <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl mb-6">
                                        <p class="text-xs text-blue-800 leading-relaxed font-medium">
                                            Sube un archivo Excel (.xlsx) o CSV para importar productos masivamente.
                                            <a href="{{ route('products.template') }}" class="block mt-2 text-indigo-600 hover:text-indigo-900 font-black uppercase text-[10px] tracking-widest">
                                                ⬇️ Descargar Plantilla Oficial
                                            </a>
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Seleccionar Archivo</label>
                                        <div class="relative group">
                                            <input type="file" name="file" required 
                                                class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer bg-gray-50 border border-gray-200 rounded-2xl p-2 font-bold">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-8 py-6 sm:flex sm:flex-row-reverse gap-3 rounded-b-3xl">
                                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-8 rounded-xl transition text-[10px] uppercase tracking-widest shadow-lg shadow-indigo-100">
                                        Iniciar Importación
                                    </button>
                                    <button @click="show = false" type="button" class="mt-3 sm:mt-0 w-full sm:w-auto bg-white border border-gray-200 text-gray-500 font-black py-2.5 px-8 rounded-xl transition text-[10px] uppercase tracking-widest hover:bg-gray-100">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create/Edit Modal -->
            <x-dialog-modal wire:model="isOpen">
                <x-slot name="title">
                    {{ $productId ? 'Editar Producto' : 'Crear Producto' }}
                </x-slot>

                <x-slot name="content">
                    <form wire:submit.prevent="store">
                        <button type="submit" class="hidden"></button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- SKU -->
                            <div class="col-span-1">
                                <label for="sku" class="block text-gray-700 text-sm font-bold mb-2">SKU / Código (Opcional):</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="sku" wire:model="sku" placeholder="Vacío = Auto-generar">
                                @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Categoría -->
                            <div class="col-span-1">
                                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                                <select wire:model="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Seleccionar Categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Unit Type -->
                            <div class="col-span-1">
                                <label for="unit_type" class="block text-gray-700 text-sm font-bold mb-2">Unidad de Medida:</label>
                                <select wire:model="unit_type" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="unit">Unidad (Default)</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->name }}">{{ $unit->name }} ({{ $unit->abbreviation }})</option>
                                    @endforeach
                                </select>
                                @error('unit_type') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Proveedor -->
                            <div class="col-span-1">
                                <label for="supplier_id" class="block text-gray-700 text-sm font-bold mb-2">Proveedor:</label>
                                <select wire:model="supplier_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Seleccionar Proveedor</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                        <!-- Nombre (Full Width) -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" wire:model="name">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        <!-- Descripción (Full Width) -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción (Opcional - Aparece en la Tienda):</label>
                            <textarea id="description" wire:model="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ej: Especificaciones técnicas, garantía, etc."></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        <!-- Precio Costo -->
                        <div class="col-span-1" x-data="{ 
                            value: @entangle('price_cost'),
                            format(val) {
                                if (!val) return '';
                                return val.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            },
                            update(event) {
                                let raw = event.target.value.replace(/\./g, '');
                                this.value = this.format(raw);
                            }
                        }">
                            <label for="price_cost" class="block text-gray-700 text-sm font-bold mb-2">Precio Costo (₲):</label>
                            <input type="text" x-model="value" @input="update" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="0">
                            @error('price_cost') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        <!-- Precio Venta -->
                        <div class="col-span-1" x-data="{ 
                            value: @entangle('price_sale'),
                            format(val) {
                                if (!val) return '';
                                return val.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            },
                            update(event) {
                                let raw = event.target.value.replace(/\./g, '');
                                this.value = this.format(raw);
                            }
                        }">
                            <label for="price_sale" class="block text-gray-700 text-sm font-bold mb-2">Precio Venta (₲):</label>
                            <input type="text" x-model="value" @input="update" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="0">
                            @error('price_sale') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        <!-- Manage Stock Checkbox -->
                        <div class="col-span-1 md:col-span-2">
                                <label class="inline-flex items-center">
                                <input type="checkbox" wire:model.live="manage_stock" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 text-gray-700 font-bold">Controlar Stock</span>
                            </label>
                        </div>

                        @if($manage_stock)
                            <!-- Stock -->
                            <div class="col-span-1">
                                <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock Actual:</label>
                                <input type="number" step="0.001" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="stock" wire:model="stock">
                                @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>

                            <!-- Stock Mínimo -->
                            <div class="col-span-1">
                                <label for="min_stock" class="block text-gray-700 text-sm font-bold mb-2">Stock Mínimo (Alerta):</label>
                                <input type="number" step="0.001" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="min_stock" wire:model="min_stock">
                                @error('min_stock') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                        @endif

                        <!-- Activo -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="is_active" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 text-gray-700">Producto Activo / Disponible para venta</span>
                            </label>
                        </div>

                        <!-- Has Variations Toggle -->
                        <div class="col-span-1 md:col-span-2 border-t pt-4 mt-2">
                            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-100 p-2 rounded-xl text-indigo-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-black text-indigo-900 uppercase tracking-tight">Producto con Variantes</h4>
                                            <p class="text-[10px] text-indigo-600 font-bold uppercase opacity-70">Talles, Colores, Sabores, etc.</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="has_variations" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>

                                @if($has_variations)
                                    <div class="mt-6 space-y-4">
                                        <div class="flex justify-between items-center">
                                            <h5 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Lista de Variantes</h5>
                                            <button type="button" wire:click="addVariation" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-sm flex items-center gap-1.5 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Agregar
                                            </button>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-indigo-100">
                                                <thead>
                                                    <tr class="text-[9px] font-black text-indigo-300 uppercase tracking-widest text-left">
                                                        <th class="pb-2 pr-2">Nombre / Opción</th>
                                                        <th class="pb-2 pr-2">SKU</th>
                                                        <th class="pb-2 pr-2">Venta (₲)</th>
                                                        <th class="pb-2 pr-2">Stock</th>
                                                        <th class="pb-2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-indigo-50">
                                                    @foreach($variations as $index => $var)
                                                        <tr wire:key="var-{{ $index }}">
                                                            <td class="py-2 pr-2">
                                                                <input type="text" wire:model="variations.{{ $index }}.name" placeholder="Ej: Rojo L" class="w-full text-xs font-bold border-indigo-100 rounded-lg bg-white focus:ring-indigo-500 py-1.5 shadow-sm">
                                                            </td>
                                                            <td class="py-2 pr-2">
                                                                <input type="text" wire:model="variations.{{ $index }}.sku" placeholder="SKU-VAR" class="w-full text-[10px] font-mono border-indigo-100 rounded-lg bg-white focus:ring-indigo-500 py-1.5 shadow-sm">
                                                            </td>
                                                            <td class="py-2 pr-2">
                                                                <input type="text" wire:model="variations.{{ $index }}.price_sale" placeholder="0" class="w-full text-xs font-bold border-indigo-100 rounded-lg bg-white focus:ring-indigo-500 py-1.5 shadow-sm text-right">
                                                            </td>
                                                            <td class="py-2 pr-2">
                                                                <input type="number" wire:model="variations.{{ $index }}.stock" placeholder="0" class="w-20 text-xs font-bold border-indigo-100 rounded-lg bg-white focus:ring-indigo-500 py-1.5 shadow-sm text-center">
                                                            </td>
                                                            <td class="py-2 text-right">
                                                                <button type="button" wire:click="removeVariation({{ $index }})" class="text-red-400 hover:text-red-600 transition">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if(empty($variations))
                                                <div class="text-center py-4 bg-white/50 rounded-xl border border-dashed border-indigo-100">
                                                    <p class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest italic">No hay variantes definidas</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($discountProductEnabled)
                        <!-- Descuento por Producto -->
                        <div class="col-span-1 md:col-span-2 border-t pt-3 mt-1"
                             x-data="{ pct: $wire.entangle('discount_percentage') }">
                            <label class="block text-gray-700 text-sm font-bold mb-1">
                                🏷️ Descuento sobre el producto
                                <span class="font-normal text-gray-400">(0 = sin descuento)</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="relative w-32">
                                    <input type="number" wire:model.live="discount_percentage"
                                        min="0" max="100" step="1"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-7">
                                    <span class="absolute right-2 top-2 text-gray-500 text-sm">%</span>
                                </div>
                                <span x-show="pct > 0" class="text-sm text-green-700 font-medium">
                                    → Precio efectivo: <strong>₲ {{ $discount_percentage > 0 ? number_format((int)round((int)(preg_replace('/[^0-9]/', '', $price_sale ?: '0')) * (1 - $discount_percentage / 100)), 0, ',', '.') : '–' }}</strong>
                                </span>
                                <span x-show="pct == 0 || !pct" class="text-sm text-gray-400">Sin descuento activo</span>
                            </div>
                            @error('discount_percentage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <!-- Imagen del Producto -->
                        <div class="col-span-1 md:col-span-2 border-t pt-3 mt-1">
                            <label class="block text-gray-700 text-sm font-bold mb-2">📸 Imagen del Producto (E-commerce):</label>
                            <div class="flex items-center gap-4">
                                @if ($product_image)
                                    <img src="{{ $product_image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-xl border shadow-sm">
                                @elseif ($product_image_path)
                                    <img src="{{ Storage::url($product_image_path) }}" class="h-20 w-20 object-cover rounded-xl border shadow-sm">
                                @else
                                    <div class="h-20 w-20 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <input type="file" wire:model="product_image" id="product_image" class="hidden">
                                    <label for="product_image" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 font-bold rounded-xl hover:bg-indigo-100 transition text-xs uppercase tracking-widest">
                                        Seleccionar Imagen
                                    </label>
                                    <p class="text-[10px] text-gray-400 mt-1">JPG, PNG hasta 1MB. Recomendado: Cuadrada 800x800px.</p>
                                    <div wire:loading wire:target="product_image" class="text-[10px] text-indigo-600 font-bold">Cargando imagen...</div>
                                </div>
                            </div>
                            @error('product_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

            <!-- Product Grid (Desktop & Mobile) -->
            <div class="w-full">
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto -mx-4">
                    <div class="inline-block min-w-full align-middle font-sans">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400">
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-4 text-left w-10">
                                        <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4"> 
                                    </th>
                                    <th class="px-6 py-4 text-left">Producto</th>
                                    <th class="px-6 py-4 text-left font-mono">SKU</th>
                                    <th class="px-6 py-4 text-left">Categoría</th>
                                    <th class="px-6 py-4 text-right">Costo</th>
                                    <th class="px-6 py-4 text-right">Precio Venta</th>
                                    <th class="px-6 py-4 text-center">Stock</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($products as $product)
                                    <tr class="hover:bg-indigo-50/30 transition group">
                                        <td class="px-6 py-4">
                                            <input type="checkbox" wire:model.live="selected" value="{{ $product->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($product->image_path)
                                                    <img src="{{ Storage::url($product->image_path) }}" class="h-10 w-10 rounded-lg object-cover border border-gray-100 shadow-sm">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-300 border border-dashed">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                                    @if($product->discount_percentage > 0)
                                                        <span class="inline-flex items-center text-[9px] font-black bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full uppercase tracking-tighter mt-1">
                                                            {{ $product->discount_percentage }}% OFF
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-mono text-gray-400 lowercase">{{ $product->sku }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-400 text-right font-medium">₲ {{ number_format($product->price_cost, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="text-sm font-black text-gray-900">₲ {{ number_format($product->price_sale, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($product->manage_stock)
                                                <span class="px-2.5 py-1 inline-flex text-[10px] font-black rounded-full {{ $product->stock <= $product->min_stock ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                    {{ number_format($product->stock, ($product->unit_type === 'unit' ? 0 : 2), ',', '.') }}
                                                </span>
                                            @else
                                                <span class="text-gray-300 text-[10px] uppercase font-bold tracking-widest italic">Infinito</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                                <button wire:click="edit('{{ $product->id }}')" class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-lg hover:bg-indigo-50" title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <button wire:click="delete('{{ $product->id }}')" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50" title="Eliminar" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
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
                    @foreach($products as $product)
                        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm relative active:scale-[0.98] transition">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1 pr-12">
                                    <h3 class="font-black text-gray-900 text-lg leading-tight uppercase tracking-tight">{{ $product->name }}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded">SKU: {{ $product->sku }}</span>
                                        @if($product->manage_stock)
                                            <span class="text-[10px] uppercase font-black {{ $product->stock <= $product->min_stock ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }} px-1.5 py-0.5 rounded">
                                                Stock: {{ number_format($product->stock, ($product->unit_type === 'unit' ? 0 : 2), ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-2 gap-4 py-3 border-t border-b border-dashed border-gray-100">
                                <div>
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Categoría</span>
                                    <span class="font-bold text-gray-700 text-sm">{{ $product->category ? $product->category->name : 'N/A' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Precio</span>
                                    <div class="font-black text-indigo-700 text-lg">₲ {{ number_format($product->price_sale, 0, ',', '.') }}</div>
                                    @if($product->discount_percentage > 0)
                                        <span class="text-[9px] text-amber-600 font-extrabold uppercase">🏷️ {{ $product->discount_percentage }}% OFF</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2 mt-4 pt-4">
                                <button wire:click="edit('{{ $product->id }}')" class="flex-1 bg-indigo-50 text-indigo-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Editar
                                </button>
                                <button wire:click="delete('{{ $product->id }}')" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="flex-1 bg-red-50 text-red-500 font-bold py-2 rounded-xl text-xs flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Borrar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
