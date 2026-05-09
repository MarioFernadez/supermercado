@section('title', $product->name . ' | ' . ($settings['store_name'] ?? 'ZonaShop'))
@section('meta_description', Str::limit(strip_tags($product->description), 160) ?: 'Compra ' . $product->name . ' al mejor precio en ' . ($settings['store_name'] ?? 'nuestra tienda') . '.')

<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Breadcrumbs -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <nav class="flex text-sm font-bold uppercase tracking-widest text-gray-400 gap-2 items-center">
            <a href="{{ route('shop.index') }}" class="hover:text-indigo-600 transition">Inicio</a>
            <span>/</span>
            <a href="{{ route('shop.category', $product->category) }}" class="hover:text-indigo-600 transition">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-gray-900 truncate">{{ $product->name }}</span>
        </nav>
    </div>

    <!-- Product Detail -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-indigo-100/50 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Image Section -->
                <div class="p-8 sm:p-12 bg-white flex items-center justify-center border-b lg:border-b-0 lg:border-r border-gray-50">
                    <div class="relative w-full aspect-square group">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain transform group-hover:scale-105 transition duration-700">
                        @else
                            <div class="w-full h-full bg-gray-50 rounded-3xl flex items-center justify-center text-gray-200">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.5-9L11 14l-2.5-3L5 17h14l-4.5-7z"/></svg>
                            </div>
                        @endif

                        @if($product->discount_percentage > 0)
                        <div class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-4 py-2 rounded-2xl uppercase tracking-widest shadow-lg z-10">
                            OFERTA -{{ $product->discount_percentage }}%
                        </div>
                        @elseif($product->stock <= 0)
                        <div class="absolute top-0 left-0 bg-gray-500 text-white text-xs font-bold px-4 py-2 rounded-2xl uppercase tracking-widest shadow-lg z-10">
                            Agotado
                        </div>
                        @elseif($product->created_at && $product->created_at->gt(now()->subDays(7)))
                        <div class="absolute top-0 left-0 bg-indigo-600 text-white text-xs font-bold px-4 py-2 rounded-2xl uppercase tracking-widest shadow-lg z-10">
                            NUEVO
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Info Section -->
                <div class="p-8 sm:p-12 flex flex-col">
                    <div class="mb-6">
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-500 mb-2 block">
                            {{ $product->category->name }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-4">
                            {{ $product->name }}
                        </h1>
                        <div class="flex items-center gap-4 text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <span>SKU: <span class="text-gray-900">{{ $selectedVariation ? $selectedVariation->sku : ($product->sku ?? 'N/A') }}</span></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-200"></span>
                            @php
                                $currentStock = $selectedVariation ? $selectedVariation->stock : $product->stock;
                            @endphp
                            <span>Stock: <span class="{{ $currentStock > 5 ? 'text-emerald-500' : 'text-orange-500' }}">{{ $currentStock }} disponibles</span></span>
                        </div>
                    </div>

                    @if($product->has_variations && $product->variations->count() > 0)
                    <!-- Variation Selector -->
                    <div class="mb-8">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Seleccionar Opción</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->variations as $var)
                                <button 
                                    wire:click="selectVariation('{{ $var->id }}')"
                                    class="px-4 py-2 rounded-xl border-2 transition-all font-bold text-xs uppercase tracking-widest {{ $selectedVariation && $selectedVariation->id === $var->id ? 'border-indigo-600 bg-indigo-50 text-indigo-700 shadow-lg shadow-indigo-100' : 'border-gray-100 bg-white text-gray-500 hover:border-gray-300' }}"
                                >
                                    {{ $var->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="bg-gray-50 rounded-3xl p-6 sm:p-8 mb-8">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Precio Contado</p>
                        
                        @php
                            $displayPrice = $selectedVariation ? $selectedVariation->price_sale : $product->price_sale;
                            $displayEffectivePrice = $selectedVariation ? $selectedVariation->price_sale : $product->effective_price;
                            // If product has global discount, apply to variation? 
                            // Usually variations have their own prices. If variations don't have separate discount, we use effective_price logic.
                            // For simplicity, let's assume variation price is final or apply global discount if enabled.
                            if ($product->discount_percentage > 0 && $selectedVariation) {
                                $displayEffectivePrice = (int) round($displayPrice * (1 - $product->discount_percentage / 100));
                            }
                        @endphp

                        <div class="mb-4">
                            @if($product->discount_percentage > 0)
                                <div class="text-xs sm:text-sm font-bold text-red-500 line-through opacity-70 mb-1">
                                    Gs. {{ number_format($displayPrice, 0, ',', '.') }}
                                </div>
                            @endif
                            <div class="flex items-baseline gap-2">
                                <span class="text-xl font-bold text-gray-900">Gs.</span>
                                <span class="text-2xl sm:text-3xl font-bold text-gray-900">{{ number_format($displayEffectivePrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-t border-gray-200 pt-6">
                            @php 
                                $usd_rate = floatval($settings['currency_usd'] ?? 7500);
                                $ars_rate = floatval($settings['currency_ars'] ?? 20);
                                $price_usd = $displayEffectivePrice / ($usd_rate ?: 1);
                                $price_ars = $displayEffectivePrice / ($ars_rate ?: 1);
                            @endphp
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dólares</p>
                                <p class="text-lg font-bold text-emerald-600">U$ {{ number_format($price_usd, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Pesos Arg.</p>
                                <p class="text-lg font-bold text-blue-600">P$ {{ number_format($price_ars, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="mb-8">
                        <h3 class="text-sm font-bold uppercase tracking-widest text-gray-900 mb-4">Descripción</h3>
                        <div class="text-gray-600 leading-relaxed text-sm format-description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    @endif

                    <div class="mt-auto pt-8 border-t border-gray-100 flex flex-col sm:flex-row gap-4">
                        @if($currentStock > 0)
                        <button @click="addItem({
                            id: '{{ $product->id }}',
                            variation_id: '{{ $selectedVariation ? $selectedVariation->id : '' }}',
                            name: '{{ addslashes($product->name) }}{{ $selectedVariation ? ' (' . addslashes($selectedVariation->name) . ')' : '' }}',
                            price_sale: {{ $displayEffectivePrice }},
                            image_url: '{{ $product->image_path ? Storage::url($product->image_path) : '' }}',
                            category: '{{ addslashes($product->category->name) }}'
                        })" 
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2 transform active:scale-95 shadow-lg shadow-indigo-100/50 text-xs uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Añadir al carrito
                        </button>
                        @else
                        <button disabled 
                        class="flex-1 bg-gray-200 text-gray-400 font-bold py-3 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed text-xs uppercase tracking-widest">
                            Sin Stock
                        </button>
                        @endif
                        
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['shop_whatsapp'] ?? '') }}?text=Hola! Me interesa este producto: {{ urlencode(route('shop.product', $product)) }}" 
                           target="_blank"
                           class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-xl transition flex items-center justify-center gap-2 transform active:scale-95 shadow-lg shadow-emerald-100/50 text-xs uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.24-.581-.487-.503-.669-.512-.174-.01-.373-.012-.572-.012-.199 0-.523.074-.797.371-.273.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            Consultar
                        </a>

                        <!-- Share Button -->
                        <button onclick="shareProduct()" 
                                class="bg-gray-100 hover:bg-gray-200 text-gray-500 p-3 rounded-xl transition transform active:scale-95 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 100-2.684 3 3 0 000 2.684zm0 12.684a3 3 0 100-2.684 3 3 0 000 2.684z"></path></svg>
                        </button>
                    </div>

                    <script>
                        function shareProduct() {
                            if (navigator.share) {
                                navigator.share({
                                    title: '{{ addslashes($product->name) }}',
                                    text: '¡Mira este producto en {{ addslashes($settings['store_name'] ?? 'ZonaShop') }}!',
                                    url: window.location.href,
                                }).catch(console.error);
                            } else {
                                const el = document.createElement('textarea');
                                el.value = window.location.href;
                                document.body.appendChild(el);
                                el.select();
                                document.execCommand('copy');
                                document.body.removeChild(el);
                                alert('¡Enlace copiado al portapapeles!');
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 uppercase tracking-tighter">También te puede interesar</h2>
            <a href="{{ route('shop.category', $product->category) }}" class="text-xs font-bold uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition flex items-center gap-2">
                Ver más de esta categoría <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach($relatedProducts as $related)
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group flex flex-col h-full relative">
                <!-- Product Image -->
                <a href="{{ route('shop.product', $related) }}" class="relative h-48 sm:h-56 overflow-hidden bg-white p-4 block">
                    @if($related->image_path)
                        <img src="{{ Storage::url($related->image_path) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-500" loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-100">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.5-9L11 14l-2.5-3L5 17h14l-4.5-7z"/></svg>
                        </div>
                    @endif
                </a>

                <!-- Product Info -->
                <div class="p-4 sm:p-6 flex flex-col flex-1 border-t border-gray-50">
                    <a href="{{ route('shop.product', $related) }}" class="block">
                        <h4 class="text-xs sm:text-sm font-bold text-gray-800 leading-snug line-clamp-2 h-10 mb-4 uppercase tabular-nums hover:text-indigo-600 transition">{{ $related->name }}</h4>
                    </a>
                    
                    <div class="mt-auto">
                        <div class="text-md font-bold text-gray-900 mb-1">
                            <span class="text-sm font-medium mr-0.5">Gs.</span> {{ number_format($related->price_sale, 0, ',', '.') }}
                        </div>

                        <div class="flex items-center gap-3 text-[10px] font-bold text-gray-400">
                            @php 
                                $price_usd_rel = $related->price_sale / ($usd_rate ?: 1);
                            @endphp
                            <div class="flex items-center gap-1">
                                <span class="text-emerald-600">U$</span> {{ number_format($price_usd_rel, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <button @click="addItem({
                            id: '{{ $related->id }}',
                            name: '{{ addslashes($related->name) }}',
                            price_sale: {{ $related->price_sale }},
                            image_url: '{{ $related->image_path ? Storage::url($related->image_path) : '' }}',
                            category: '{{ addslashes($related->category->name) }}'
                        })" 
                        class="w-full mt-4 bg-gray-50 hover:bg-indigo-600 hover:text-white text-gray-900 font-bold py-2 rounded-xl text-xs transition flex items-center justify-center gap-2 transform active:scale-95 border border-gray-100 group-hover:border-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
