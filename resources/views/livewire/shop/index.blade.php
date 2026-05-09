@section('title', ($settings['store_name'] ?? 'ZonaShop') . ' - Tienda Online')
<div>
    
    <!-- Hero Carousel -->
    @if(count($banners) > 0)
    <section class="max-w-[1920px] mx-auto px-0 sm:px-4 mt-0 sm:mt-6">
        <div class="relative group">
            <div class="swiper main-swiper sm:rounded-3xl overflow-hidden shadow-2xl shadow-indigo-100/50">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                    <div class="swiper-slide relative aspect-[1903/560] overflow-hidden">
                        <img src="{{ Storage::url($banner->image_path) }}" class="w-full h-full object-cover transform transition duration-[10s] group-hover:scale-110">
                        @if($banner->title || $banner->subtitle)
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/20 to-transparent flex flex-col justify-center p-8 sm:p-20">
                            <div class="max-w-2xl" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                                <h2 x-show="show" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-8" class="text-3xl sm:text-6xl font-black text-white leading-tight uppercase tracking-tighter">{{ $banner->title }}</h2>
                                <p x-show="show" x-transition:enter="transition ease-out duration-700 delay-500" x-transition:enter-start="opacity-0 translate-y-8" class="text-lg sm:text-2xl text-white/90 mt-4 font-medium uppercase tracking-widest">{{ $banner->subtitle }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="swiper-pagination !bottom-8"></div>
                
                <!-- Navigation -->
                <div class="swiper-button-prev custom-nav-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </div>
                <div class="swiper-button-next custom-nav-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </div>
    </section>
    @endif



    <!-- Categories Section -->
    <section class="max-w-7xl mx-auto px-4 mt-12 relative">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-bold text-gray-900 uppercase tracking-tighter">Explorar Categorías</h3>
            <div class="flex gap-2">
                <div class="cat-prev cursor-pointer p-2 rounded-full border border-gray-100 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </div>
                <div class="cat-next cursor-pointer p-2 rounded-full border border-gray-100 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </div>

        <div class="swiper categories-swiper !pb-12">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                <div class="swiper-slide">
                    <a href="{{ route('shop.category', $category) }}" class="group relative bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-500 flex flex-col items-center p-4 sm:p-6 text-center h-full">
                        <div class="relative w-20 h-20 sm:w-24 sm:h-24 mb-4">
                            <div class="absolute inset-0 bg-indigo-50 rounded-full group-hover:scale-110 transition duration-500"></div>
                            @if($category->image_path)
                                <img src="{{ Storage::url($category->image_path) }}" class="relative z-10 w-full h-full object-contain p-2 group-hover:rotate-6 transition duration-500">
                            @else
                                <div class="relative z-10 w-full h-full flex items-center justify-center text-indigo-200">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold text-gray-900 uppercase tracking-tighter group-hover:text-indigo-600 transition truncate w-full">{{ $category->name }}</h3>
                        <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">{{ $category->products_count }} productos</p>
                    </a>
                </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination !bottom-0"></div>
        </div>
    </section>

    <!-- Recently Added -->
    <section class="max-w-7xl mx-auto px-4 mt-20 pb-20"
             x-data="{ 
                favorites: JSON.parse(localStorage.getItem('zonashop_favs') || '[]'),
                onlyFavs: false,
                toggleFav(id) {
                    if (this.favorites.includes(id)) {
                        this.favorites = this.favorites.filter(f => f !== id);
                    } else {
                        this.favorites.push(id);
                    }
                    localStorage.setItem('zonashop_favs', JSON.stringify(this.favorites));
                }
             }">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6 border-b border-gray-100 pb-8">
            <h3 class="text-2xl font-bold text-gray-900 uppercase tracking-tighter flex items-center gap-3">
                <span x-text="onlyFavs ? 'Mis Favoritos' : 'Nuevos Ingresos'"></span>
                <span x-show="onlyFavs" class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full animate-pulse" x-text="favorites.length"></span>
            </h3>

            <!-- Filter Favorites Button -->
            <button @click="onlyFavs = !onlyFavs" 
                    :class="onlyFavs ? 'bg-red-500 text-white border-red-500 shadow-red-100' : 'bg-white text-gray-400 border-gray-200 hover:border-red-400 hover:text-red-500'"
                    class="flex items-center gap-3 px-6 py-3 rounded-2xl border-2 font-bold text-[10px] uppercase tracking-widest transition-all transform active:scale-95 shadow-xl">
                <svg class="w-5 h-5" :fill="onlyFavs ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <span x-text="onlyFavs ? 'Ver Todo el Catálogo' : 'Ver mis Favoritos'"></span>
            </button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8">
            @foreach($recentProducts as $product)
            <div x-show="!onlyFavs || favorites.includes('{{ $product->id }}')"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full relative p-4">
                
                <!-- 1. Header: Category & Title -->
                <div class="mb-4">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-gray-300 mb-1">
                        {{ $product->category->name ?? 'Catálogo' }}
                    </div>
                    <a href="{{ route('shop.product', $product) }}" class="block group/title">
                        <h4 class="text-xs sm:text-sm font-bold text-gray-800 leading-snug line-clamp-2 h-10 uppercase tabular-nums group-hover/title:text-indigo-600 transition">{{ $product->name }}</h4>
                    </a>
                </div>

                <!-- 2. Middle: Image with Hover Actions -->
                <div class="relative h-48 sm:h-56 mb-4 flex items-center justify-center">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-100">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.5-9L11 14l-2.5-3L5 17h14l-4.5-7z"/></svg>
                        </div>
                    @endif

                    <!-- Badges -->
                    @if($product->discount_percentage > 0)
                        <div class="absolute top-0 left-0 bg-red-500 text-white text-[9px] font-bold px-2 py-1 rounded-lg uppercase tracking-widest z-10 shadow-sm">
                            -{{ $product->discount_percentage }}%
                        </div>
                    @elseif($product->stock <= 0)
                        <div class="absolute top-0 left-0 bg-gray-500 text-white text-[9px] font-bold px-2 py-1 rounded-lg uppercase tracking-widest z-10 shadow-sm">
                            Agotado
                        </div>
                    @endif

                    <!-- Hover Actions Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center gap-2 bg-white/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                        <!-- Favorites -->
                        <button @click="toggleFav('{{ $product->id }}')" 
                                :class="favorites.includes('{{ $product->id }}') ? 'bg-red-500 text-white scale-110' : 'bg-white text-gray-800'"
                                class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg hover:bg-red-500 hover:text-white transition transform active:scale-95 border border-gray-100">
                            <svg class="w-5 h-5" :fill="favorites.includes('{{ $product->id }}') ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>

                        <!-- Add to Cart / View Options -->
                        <div class="relative group/cart">
                            @if($product->has_variations)
                                <a href="{{ route('shop.product', $product) }}" 
                                   class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:bg-indigo-700 transition transform hover:scale-110 active:scale-95">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            @else
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-[10px] font-bold rounded shadow-xl whitespace-nowrap opacity-0 group-hover/cart:opacity-100 transition duration-200 pointer-events-none uppercase tracking-widest">
                                    Añadir al carrito
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900"></div>
                                </div>
                                <button @click="addItem({
                                             id: '{{ $product->id }}',
                                             name: '{{ addslashes($product->name) }}',
                                             price_sale: {{ $product->effective_price }},
                                             image_url: '{{ $product->image_path ? Storage::url($product->image_path) : '' }}',
                                             category: '{{ addslashes($product->category->name ?? 'Varios') }}'
                                         }); showCart = true;"
                                         @if($product->stock <= 0) disabled @endif
                                         class="w-14 h-14 bg-gray-900 text-white rounded-full flex items-center justify-center shadow-2xl hover:bg-indigo-600 transition transform hover:scale-110 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </button>
                            @endif
                        </div>

                        <!-- Quick View -->
                        <a href="{{ route('shop.product', $product) }}" 
                           class="w-10 h-10 bg-white text-gray-800 rounded-full flex items-center justify-center shadow-lg hover:bg-indigo-600 hover:text-white transition transform active:scale-95 border border-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- 3. Bottom: Price -->
                <div class="mt-auto">
                    @if($product->discount_percentage > 0)
                        <div class="text-[10px] font-bold text-red-400 line-through opacity-70 mb-0.5">
                            Gs. {{ number_format($product->price_sale, 0, ',', '.') }}
                        </div>
                    @endif
                    <div class="text-xl font-bold text-gray-900 leading-none tabular-nums">
                        <span class="text-xs font-medium mr-0.5">Gs.</span> {{ number_format($product->effective_price, 0, ',', '.') }}
                    </div>
                    
                    <!-- Multi-currency (Small/Clean) -->
                    <div class="mt-2 flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                        @php 
                            $usd_rate = floatval($settings['currency_usd'] ?? 7500);
                            $price_usd = $product->effective_price / ($usd_rate ?: 1);
                        @endphp
                        <span class="text-emerald-600">USD {{ number_format($price_usd, 2) }}</span>
                        <span>•</span>
                        <span>REF: {{ $product->sku ?? 'S/N' }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        <!-- Loading Skeletons -->
        <div wire:loading class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-8 mt-8">
            @for($i = 0; $i < 4; $i++)
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 p-4">
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
                    class="inline-flex items-center gap-3 px-8 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-bold rounded-2xl hover:bg-indigo-600 hover:text-white transition-all transform active:scale-95 group disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-indigo-100 text-sm">
                <span>VER MÁS</span>
                <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
        </div>
        @endif

        @if(count($recentProducts) == 0)
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-gray-400 font-bold">No encontramos productos que coincidan.</p>
            </div>
        @endif
    </section>

    <!-- Swiper Initialization -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            initSwiper();
        });
        
        window.addEventListener('load', () => {
            initSwiper();
        });

        function initSwiper() {
            if (document.querySelector('.main-swiper')) {
                new Swiper('.main-swiper', {
                    effect: 'slide',
                    speed: 600,
                    loop: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            }

            if (document.querySelector('.categories-swiper')) {
                new Swiper('.categories-swiper', {
                    slidesPerView: 2,
                    spaceBetween: 16,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.cat-next',
                        prevEl: '.cat-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 3, spaceBetween: 20 },
                        768: { slidesPerView: 4, spaceBetween: 24 },
                        1024: { slidesPerView: 6, spaceBetween: 30 }
                    }
                });
            }
        }
    </script>

    <style>
        .main-swiper .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #fff !important;
            opacity: 0.5;
            transition: all 0.4s ease;
            border-radius: 50%;
        }
        .main-swiper .swiper-pagination-bullet-active {
            width: 35px !important;
            background: #2936cc !important;
            opacity: 1;
            border-radius: 20px;
        }

        .categories-swiper .swiper-pagination-bullet-active {
            background: #2936cc !important;
            width: 20px !important;
            border-radius: 10px;
        }
        
        .custom-nav-btn {
            width: 38px !important;
            height: 38px !important;
            background: #fff !important;
            border-radius: 50% !important;
            color: #000 !important;
            opacity: 0;
            transition: all 0.3s ease !important;
        }
        .custom-nav-btn:after { display: none !important; }
        .main-swiper:hover .custom-nav-btn { opacity: 1; }
        .custom-nav-btn:hover { background: #2936cc !important; color: #fff !important; }

        .main-swiper .swiper-button-prev { left: 20px; }
        .main-swiper .swiper-button-next { right: 20px; }
        
        .skeleton {
            background-color: #f3f4f6;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</div>
