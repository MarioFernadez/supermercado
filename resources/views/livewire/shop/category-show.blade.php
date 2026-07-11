@section('title', $category->name . ' | ' . ($settings['store_name'] ?? 'ZonaShop'))
@section('meta_description', 'Explora nuestra colección de ' . $category->name . ' en ' . ($settings['store_name'] ?? 'nuestra tienda') . '. Encuentra los mejores precios y ofertas.')
@section('og_type', 'website')
@if($category->image_path)
    @section('og_image', url(Storage::url($category->image_path)))
@endif

<div class="min-h-screen bg-gray-50 pb-20 dark:bg-gray-900">
    <!-- Category Header -->
    <div class="relative h-64 sm:h-80 bg-indigo-900 overflow-hidden">
        @if($category->image_path)
            <img src="{{ Storage::url($category->image_path) }}" class="w-full h-full object-cover opacity-40">
        @endif
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-3xl sm:text-5xl font-bold text-white uppercase tracking-tighter mb-4">
                {{ $category->name }}
            </h1>
            <div class="flex items-center gap-2 text-indigo-200 text-sm font-bold uppercase tracking-widest">
                <a href="{{ route('shop.index') }}" class="hover:text-white transition">Inicio</a>
                <span>/</span>
                <span class="text-white">{{ $category->name }}</span>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 p-6 sm:p-10 dark:bg-gray-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 uppercase dark:text-white">Explorar productos</h2>
                    <p class="text-gray-500 font-medium dark:text-gray-400">Mostrando todos los modelos disponibles en {{ $category->name }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <!-- Sorting -->
                    <div class="relative">
                        <select wire:model.live="sort" class="w-full sm:w-48 pl-4 pr-10 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold cursor-pointer dark:bg-gray-900 dark:text-gray-300">
                            <option value="latest">Más recientes</option>
                            <option value="price_asc">Menor Precio</option>
                            <option value="price_desc">Mayor Precio</option>
                        </select>
                    </div>

                    <!-- Internal Search -->
                    <div class="relative w-full md:w-72">
                        <input type="text" wire:model.live="search" 
                               placeholder="Buscar en esta sección..." 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold dark:bg-gray-900 dark:text-gray-300">
                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group flex flex-col h-full relative dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                    <!-- SKU / Ref Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="text-[10px] font-bold uppercase text-gray-400 dark:text-gray-500">Ref: {{ $product->sku ?? 'S/N' }}</span>
                    </div>

                    <!-- Product Image -->
                    <a href="{{ route('shop.product', $product) }}" class="relative h-48 sm:h-56 overflow-hidden bg-white p-4 block dark:bg-gray-800">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="w-full h-full object-contain img-zoom-hover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-100">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.5-9L11 14l-2.5-3L5 17h14l-4.5-7z"/></svg>
                            </div>
                        @endif
                        @if($product->discount_percentage > 0)
                        <div class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg uppercase tracking-widest z-10">
                            -{{ $product->discount_percentage }}%
                        </div>
                        @elseif($product->stock <= 0)
                        <div class="absolute top-3 left-3 bg-gray-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg uppercase tracking-widest z-10">
                            Agotado
                        </div>
                        @elseif($product->created_at && $product->created_at->gt(now()->subDays(7)))
                        <div class="absolute top-3 left-3 bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded-lg uppercase tracking-widest z-10">
                            NUEVO
                        </div>
                        @endif
                    </a>

                    <!-- Product Info -->
                    <div class="p-4 sm:p-6 flex flex-col flex-1 border-t border-gray-50">
                        <a href="{{ route('shop.product', $product) }}" class="block">
                            <h4 class="text-xs sm:text-sm font-bold text-gray-800 leading-snug line-clamp-2 h-10 mb-4 uppercase tabular-nums hover:text-indigo-600 transition dark:text-white">{{ $product->name }}</h4>
                        </a>
                        
                        <div class="mt-auto">
                            <!-- Main Price (Guaranies) -->
                            <div class="mb-1">
                                @if($product->discount_percentage > 0)
                                    <div class="text-[10px] font-bold text-red-400 line-through opacity-70">
                                        Gs. {{ number_format($product->price_sale, 0, ',', '.') }}
                                    </div>
                                @endif
                                <div class="text-base sm:text-lg font-bold text-gray-900 leading-none dark:text-white">
                                    <span class="text-xs font-medium mr-0.5">Gs.</span> {{ number_format($product->effective_price, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Secondary Currencies -->
                            <div class="flex items-center gap-4 text-[11px] font-bold text-gray-400 dark:text-gray-500">
                                @php 
                                    $usd_rate = floatval($settings['currency_usd'] ?? 7500);
                                    $ars_rate = floatval($settings['currency_ars'] ?? 20);
                                    $price_usd = $product->effective_price / ($usd_rate ?: 1);
                                    $price_ars = $product->effective_price / ($ars_rate ?: 1);
                                @endphp
                                <div class="flex items-center gap-1">
                                    <span class="text-emerald-600">U$</span> {{ number_format($price_usd, 0, ',', '.') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-gray-500 dark:text-gray-400">P$</span> {{ number_format($price_ars, 0, ',', '.') }}
                                </div>
                            </div>
                            
                            @if($product->stock > 0)
                            <button @click="addItem({
                                id: '{{ $product->id }}',
                                name: '{{ addslashes($product->name) }}',
                                price_sale: {{ $product->effective_price }},
                                image_url: '{{ $product->image_path ? Storage::url($product->image_path) : '' }}',
                                category: '{{ addslashes($category->name) }}'
                            })" 
                            class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl text-xs transition flex items-center justify-center gap-2 transform active:scale-95 shadow-lg shadow-indigo-100/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Añadir al carrito
                            </button>
                            @else
                            <button disabled 
                            class="w-full mt-4 bg-gray-200 text-gray-400 font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-2 cursor-not-allowed dark:text-gray-500">
                                Sin Stock
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Loading Skeletons -->
            <div wire:loading class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8 mt-8">
                @for($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 p-4 dark:bg-gray-800 dark:border-gray-700">
                    <div class="aspect-square skeleton rounded-2xl mb-4"></div>
                    <div class="h-4 w-2/3 skeleton rounded mb-2"></div>
                    <div class="h-4 w-1/2 skeleton rounded mb-4"></div>
                    <div class="h-10 w-full skeleton rounded-xl"></div>
                </div>
                @endfor
            </div>

            @if($hasMore)
            <div class="mt-16 text-center" wire:loading.remove>
                <button wire:click="loadMore" 
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-3 px-8 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-bold rounded-2xl hover:bg-indigo-600 hover:text-white transition-all transform active:scale-95 group disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-indigo-100 text-sm dark:bg-gray-800 dark:text-indigo-400">
                    <span>VER MÁS</span>
                    <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
            </div>
            @endif
            @else
            <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-100 dark:bg-gray-900 dark:border-gray-700">
                <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg dark:bg-gray-800">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 uppercase dark:text-white">Sin productos disponibles</h3>
                <p class="text-gray-500 font-medium max-w-xs mx-auto mt-2 dark:text-gray-400">Próximamente estaremos reponiendo stock de esta categoría.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 mt-8 text-indigo-600 font-bold hover:gap-3 transition-all dark:text-indigo-400">
                    Ver todos los productos <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
