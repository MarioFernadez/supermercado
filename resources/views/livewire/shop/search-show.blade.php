@section('title', 'Resultados para "' . $query . '" | ' . ($settings['store_name'] ?? 'ZonaShop'))

<div class="min-h-screen bg-gray-50 pb-20 dark:bg-gray-900">
    <!-- Header results -->
    <div class="bg-white border-b border-gray-100 pt-32 pb-12 dark:bg-gray-800 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 dark:text-white">
                Resultados para: <span class="text-indigo-600 dark:text-indigo-400">"{{ $query }}"</span>
            </h1>
            <p class="text-gray-500 font-medium dark:text-gray-400">Búsqueda global en toda la tienda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        @if($results->count() > 0)
            <div class="flex items-center justify-between mb-8">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest dark:text-gray-500">Se encontraron {{ $totalResults }} productos</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
                @foreach($results as $product)
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
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.5-9L11 14l-2.5-3L5 17h14l-4.5-7z"/></svg>
                            </div>
                        @endif
                        
                        @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center backdrop-blur-[1px]">
                            <span class="bg-red-500 text-white text-[10px] font-bold px-4 py-1.5 rounded-full shadow-lg uppercase tracking-widest">Agotado</span>
                        </div>
                        @endif
                    </a>

                    <!-- Product Info -->
                    <div class="p-4 sm:p-6 flex flex-col flex-1 border-t border-gray-50">
                        <div class="mb-4">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-500 block mb-1">
                                {{ $product->category->name ?? 'Varios' }}
                            </span>
                            <a href="{{ route('shop.product', $product) }}" class="block">
                                <h4 class="text-xs sm:text-sm font-bold text-gray-800 leading-snug line-clamp-2 h-10 uppercase tabular-nums hover:text-indigo-600 transition dark:text-white">{{ $product->name }}</h4>
                            </a>
                        </div>
                        
                        <div class="mt-auto">
                            <div class="flex items-baseline gap-1.5 mb-4">
                                @if($product->price_sale > $product->effective_price)
                                <span class="text-[10px] font-bold text-red-500 line-through opacity-70">Gs. {{ number_format($product->price_sale, 0, ',', '.') }}</span>
                                @endif
                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    <span class="text-xs font-medium mr-0.5 whitespace-nowrap">Gs.</span> {{ number_format($product->effective_price, 0, ',', '.') }}
                                </div>
                            </div>

                            @if($product->stock > 0)
                            <button @click="addItem({
                                id: '{{ $product->id }}',
                                name: '{{ addslashes($product->name) }}',
                                price_sale: {{ $product->effective_price }},
                                image_url: '{{ $product->image_path ? Storage::url($product->image_path) : '' }}',
                                category: '{{ addslashes($product->category->name ?? 'Varios') }}'
                            })" 
                            class="w-full bg-gray-50 hover:bg-indigo-600 hover:text-white text-gray-900 font-bold py-2 rounded-xl text-xs transition flex items-center justify-center gap-2 transform active:scale-95 border border-gray-100 active:bg-indigo-700 dark:bg-gray-900 dark:text-white dark:border-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Añadir al carrito
                            </button>
                            @else
                            <button disabled class="w-full bg-gray-50 text-gray-300 font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-2 cursor-not-allowed border border-gray-100 dark:bg-gray-900 dark:border-gray-700">
                                Agotado
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($hasMore)
            <div class="mt-16 text-center" wire:loading.remove>
                <button wire:click="loadMore" 
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-3 px-8 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-bold rounded-2xl hover:bg-indigo-600 hover:text-white transition-all transform active:scale-95 group disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-indigo-100 text-sm dark:bg-gray-800 dark:text-indigo-400">
                    <span>VER MÁS RESULTADOS</span>
                    <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
            </div>
            @endif
        @else
            <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 dark:bg-gray-900">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2 dark:text-white">No se encontraron productos</h2>
                <p class="text-gray-500 mb-8 font-medium dark:text-gray-400">No hay coincidencias para "{{ $query }}" en nuestro catálogo actual.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-700 transition dark:text-indigo-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver a la tienda
                </a>
            </div>
        @endif
    </div>
</div>
