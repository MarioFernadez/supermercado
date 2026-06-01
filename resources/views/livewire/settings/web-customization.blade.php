<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-6 rounded-2xl border border-indigo-900/50 shadow-xl text-white">
            <div>
                <h2 class="text-3xl font-black tracking-tight flex items-center gap-2">
                    ✨ Personalización de Tienda
                </h2>
                <p class="text-indigo-200 text-sm mt-1">Configura la identidad, apariencia visual, banners promocionales y carrusel de tu tienda online.</p>
            </div>
            
            @if($activeTab === 'carrusel')
                <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold py-2.5 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-600/30 flex items-center gap-2 text-sm uppercase tracking-wider">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Banner
                </button>
            @endif
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-500/10 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-xl shadow-sm flex items-center gap-3" role="alert">
                <svg class="h-6 w-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm font-semibold">
                    {{ session('message') }}
                </div>
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="flex border-b border-gray-200 dark:border-gray-700 mb-8 bg-white dark:bg-gray-800 p-1.5 rounded-xl shadow-sm gap-2">
            <button wire:click="setTab('info')" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 rounded-lg text-sm font-bold uppercase tracking-wider transition-all duration-200 {{ $activeTab === 'info' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <span>🏷️ Marca & Info</span>
            </button>
            <button wire:click="setTab('style')" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 rounded-lg text-sm font-bold uppercase tracking-wider transition-all duration-200 {{ $activeTab === 'style' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <span>🎨 Diseño & Promos</span>
            </button>
            <button wire:click="setTab('carrusel')" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 rounded-lg text-sm font-bold uppercase tracking-wider transition-all duration-200 {{ $activeTab === 'carrusel' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <span>🎞️ Carrusel Principal</span>
            </button>
        </div>

        <!-- ==================== TAB 1: MARCA & INFO ==================== -->
        @if($activeTab === 'info')
            <form wire:submit.prevent="save">
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>🏷️</span> Identidad de Marca y Datos E-commerce
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sube logotipos, redes sociales y detalles operacionales de tu tienda online.</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-6 gap-6">
                            
                            <!-- Logos Upload Section -->
                            <div class="col-span-6 md:col-span-3 bg-slate-50 dark:bg-slate-900/40 p-4 rounded-xl border border-slate-100 dark:border-slate-700/50">
                                <label class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-3">Logo de la Tienda</label>
                                <div class="flex items-center gap-4">
                                    @if ($shop_logo)
                                        <img src="{{ $shop_logo->temporaryUrl() }}" class="h-16 w-auto rounded border bg-white shadow-sm p-1">
                                    @elseif ($shop_logo_path)
                                        <img src="{{ Storage::url($shop_logo_path) }}" class="h-16 w-auto rounded border bg-white shadow-sm p-1">
                                    @else
                                        <div class="h-16 w-16 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 dark:border-gray-600 bg-white dark:bg-gray-900">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <input type="file" wire:model="shop_logo" id="shop_logo" class="hidden">
                                    <div class="flex gap-2">
                                        <label for="shop_logo" class="cursor-pointer bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 dark:text-indigo-300 py-2 px-4 rounded-xl text-xs font-bold transition">
                                            Subir Logo
                                        </label>
                                        @if ($shop_logo || $shop_logo_path)
                                            <button type="button" wire:click="deleteLogo" class="bg-red-50 hover:bg-red-100 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300 py-2 px-4 rounded-xl text-xs font-bold transition">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div wire:loading wire:target="shop_logo" class="text-xs text-indigo-600 mt-1 dark:text-indigo-400">Cargando archivo...</div>
                                @error('shop_logo') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Favicon Upload Section -->
                            <div class="col-span-6 md:col-span-3 bg-slate-50 dark:bg-slate-900/40 p-4 rounded-xl border border-slate-100 dark:border-slate-700/50">
                                <label class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-1">Favicon (Pestaña del Navegador)</label>
                                <p class="text-[10px] text-gray-400 mb-3">Sube una imagen cuadrada (.png o .ico) de 32x32px.</p>
                                <div class="flex items-center gap-4">
                                    @if ($shop_favicon)
                                        <img src="{{ $shop_favicon->temporaryUrl() }}" class="h-10 w-10 rounded border bg-white shadow-sm p-1">
                                    @elseif ($shop_favicon_path)
                                        <img src="{{ Storage::url($shop_favicon_path) }}" class="h-10 w-10 rounded border bg-white shadow-sm p-1">
                                    @else
                                        <div class="h-10 w-10 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 dark:border-gray-600 bg-white dark:bg-gray-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <input type="file" wire:model="shop_favicon" id="shop_favicon" class="hidden">
                                    <div class="flex gap-2">
                                        <label for="shop_favicon" class="cursor-pointer bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 dark:text-indigo-300 py-2 px-4 rounded-xl text-xs font-bold transition">
                                            Subir Favicon
                                        </label>
                                        @if ($shop_favicon || $shop_favicon_path)
                                            <button type="button" wire:click="deleteFavicon" class="bg-red-50 hover:bg-red-100 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300 py-2 px-4 rounded-xl text-xs font-bold transition">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div wire:loading wire:target="shop_favicon" class="text-xs text-indigo-600 mt-1 dark:text-indigo-400">Cargando archivo...</div>
                                @error('shop_favicon') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- WhatsApp Sales Number -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_whatsapp" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">🟢 WhatsApp para Pedidos</label>
                                <div class="mt-1 flex rounded-lg shadow-sm dark:shadow-none">
                                    <span class="inline-flex items-center px-3.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-gray-400 font-bold">
                                        +595
                                    </span>
                                    <input type="text" wire:model="shop_whatsapp" id="shop_whatsapp" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-lg sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300" placeholder="981123456">
                                </div>
                                <p class="mt-1 text-xs text-gray-400">Ejemplo: 981123456 (sin el código de país +595).</p>
                                @error('shop_whatsapp') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Social Networks -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_facebook" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">📘 Enlace de Facebook</label>
                                <input type="text" wire:model="shop_facebook" id="shop_facebook" placeholder="https://facebook.com/..." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                @error('shop_facebook') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_instagram" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">📸 Enlace de Instagram</label>
                                <input type="text" wire:model="shop_instagram" id="shop_instagram" placeholder="https://instagram.com/..." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                @error('shop_instagram') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_tiktok" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">🎵 Enlace de TikTok</label>
                                <input type="text" wire:model="shop_tiktok" id="shop_tiktok" placeholder="https://tiktok.com/@..." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                @error('shop_tiktok') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Carousel Limit & Price List Toggle -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_banner_limit" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">🖼️ Banners Máximos en Carrusel</label>
                                <input type="number" wire:model="shop_banner_limit" id="shop_banner_limit" min="1" max="10" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                <p class="text-[10px] text-gray-400 mt-1">Recomendamos entre 3 y 5 banners para un óptimo rendimiento.</p>
                                @error('shop_banner_limit') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3 flex items-center h-full pt-6">
                                <label class="inline-flex items-start cursor-pointer select-none">
                                    <input type="checkbox" wire:model="shop_show_pricelist" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4.5 w-4.5 mt-0.5 dark:border-gray-600 dark:bg-gray-900">
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest text-xs">Descarga de Lista de Precios</span>
                                        <span class="block text-xs text-gray-400">Si se activa, los usuarios podrán descargar la lista de productos en formato plano.</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Working Hours / Schedule -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_schedule" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">🕒 Horarios de Atención (Multilínea)</label>
                                <textarea wire:model="shop_schedule" id="shop_schedule" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300" placeholder="Lunes a Viernes: 08:00 - 18:00&#10;Sábados: 08:00 - 13:00"></textarea>
                                @error('shop_schedule') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Shop Description (Appears in footer) -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="shop_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">📝 Descripción de la Tienda (Aparece en el Pie de Página)</label>
                                <textarea wire:model="shop_description" id="shop_description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300" placeholder="Somos ZonaShop, tu mejor aliado en tecnología y accesorios en Paraguay..."></textarea>
                                @error('shop_description') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Payment Instructions -->
                            <div class="col-span-6">
                                <label for="shop_payment_instructions" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">💳 Instrucciones de Pago (Mostradas al confirmar pedidos por transferencia)</label>
                                <textarea wire:model="shop_payment_instructions" id="shop_payment_instructions" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300" placeholder="Realiza tu transferencia bancaria a:&#10;Banco Itaú, Cuenta Corriente Nº: 1234567&#10;A nombre de: ZonaShop S.A.&#10;RUC: 80012345-6. Envía el comprobante al WhatsApp comercial."></textarea>
                                @error('shop_payment_instructions') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Google Maps Embed Code -->
                            <div class="col-span-6">
                                <label for="shop_maps_iframe" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">🗺️ Iframe de Google Maps</label>
                                <textarea wire:model="shop_maps_iframe" id="shop_maps_iframe" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300" placeholder="Pega el código HTML de inserción que provee Google Maps..."></textarea>
                                @error('shop_maps_iframe') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-900/50 text-right">
                        <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-md text-sm font-black rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition">
                            Guardar Identidad & Marca
                        </button>
                    </div>
                </div>
            </form>
        @endif

        <!-- ==================== TAB 2: DISEÑO & PROMOS ==================== -->
        @if($activeTab === 'style')
            <form wire:submit.prevent="save">
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>🎨</span> Apariencia Visual, Paleta de Colores y Banners
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Configura la barra de avisos superiores, los colores corporativos de la web, y los banners promocionales Cellshop.</p>
                    </div>

                    <div class="p-6 space-y-8">
                        
                        <!-- Top Bar Design Section -->
                        <div class="space-y-4">
                            <h4 class="text-md font-bold text-slate-800 dark:text-slate-200 border-b pb-2 flex items-center gap-2">
                                <span>📢</span> Barra de Anuncios Superior (Top Bar)
                            </h4>
                            <div class="grid grid-cols-6 gap-6 bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-100 dark:border-slate-800">
                                
                                <div class="col-span-6">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="top_bar_enabled" id="top_bar_enabled" class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4.5 w-4.5 dark:border-gray-600 dark:bg-gray-900">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">Activar barra superior</span>
                                            <span class="block text-xs text-gray-400">Si se marca, se mostrará un banner fijo arriba de todo en tu tienda online.</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-span-6 md:col-span-4" x-show="$wire.top_bar_enabled" x-cloak>
                                    <label for="top_bar_text" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Texto de Anuncio (Permite HTML)</label>
                                    <input type="text" wire:model="top_bar_text" id="top_bar_text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                    <p class="text-[10px] text-gray-400 mt-1">Soporta HTML básico, por ejemplo: Envíos gratis en compras mayores a &lt;b&gt;Gs. 200.000&lt;/b&gt;</p>
                                    @error('top_bar_text') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-3 md:col-span-1" x-show="$wire.top_bar_enabled" x-cloak>
                                    <label for="top_bar_bg_color" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Fondo Barra</label>
                                    <div class="mt-1 flex items-center gap-2">
                                        <input type="color" wire:model="top_bar_bg_color" id="top_bar_bg_color" class="h-9 w-9 rounded-xl border border-gray-300 cursor-pointer p-0 bg-transparent">
                                        <input type="text" wire:model="top_bar_bg_color" class="w-20 text-xs border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    </div>
                                    @error('top_bar_bg_color') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-3 md:col-span-1" x-show="$wire.top_bar_enabled" x-cloak>
                                    <label for="top_bar_text_color" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Texto Barra</label>
                                    <div class="mt-1 flex items-center gap-2">
                                        <input type="color" wire:model="top_bar_text_color" id="top_bar_text_color" class="h-9 w-9 rounded-xl border border-gray-300 cursor-pointer p-0 bg-transparent">
                                        <input type="text" wire:model="top_bar_text_color" class="w-20 text-xs border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    </div>
                                    @error('top_bar_text_color') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Brand Colors Styling Section -->
                        <div class="space-y-4">
                            <h4 class="text-md font-bold text-slate-800 dark:text-slate-200 border-b pb-2 flex items-center gap-2">
                                <span>🎨</span> Colores Globales de la Tienda
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-100 dark:border-slate-800">
                                
                                <div>
                                    <label for="shop_primary_color" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Color Primario de la Tienda</label>
                                    <div class="mt-2 flex items-center gap-3">
                                        <input type="color" wire:model="shop_primary_color" id="shop_primary_color" class="h-10 w-10 rounded-xl border border-gray-300 cursor-pointer p-0 bg-transparent">
                                        <input type="text" wire:model="shop_primary_color" class="w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-2">Determina el color de botones, badges, total de carrito y enlaces destacados.</p>
                                    @error('shop_primary_color') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="shop_primary_color_hover" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Color Primario Hover (Al pasar el cursor)</label>
                                    <div class="mt-2 flex items-center gap-3">
                                        <input type="color" wire:model="shop_primary_color_hover" id="shop_primary_color_hover" class="h-10 w-10 rounded-xl border border-gray-300 cursor-pointer p-0 bg-transparent">
                                        <input type="text" wire:model="shop_primary_color_hover" class="w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-2">Un color ligeramente más oscuro que el primario para dar feedback visual.</p>
                                    @error('shop_primary_color_hover') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Side-by-Side Promotional Banners (Cellshop Style) -->
                        <div class="space-y-4">
                            <h4 class="text-md font-bold text-slate-800 dark:text-slate-200 border-b pb-2 flex items-center gap-2">
                                <span>📢</span> Banners Promocionales (Estilo Cellshop)
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Estos dos banners se sitúan lado a lado (el izquierdo ocupa 2/3 y el derecho 1/3 del ancho en pantallas grandes) debajo del catálogo de ingresos en la home.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- Promo 1 (2/3 width) -->
                                <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
                                    <label class="block text-sm font-bold text-gray-800 dark:text-gray-200">Banner Izquierdo (Ancho - 2/3)</label>
                                    <p class="text-[10px] text-gray-400 mt-1 mb-3">Sube una imagen horizontal (Proporción aproximada 2.3:1 o resolución 1200x520px).</p>
                                    
                                    <div class="flex items-center gap-4">
                                        @if ($promo_banner_1)
                                            <img src="{{ $promo_banner_1->temporaryUrl() }}" class="h-16 w-auto rounded border shadow-sm">
                                        @elseif ($promo_banner_1_path)
                                            <img src="{{ Storage::url($promo_banner_1_path) }}" class="h-16 w-auto rounded border shadow-sm">
                                        @else
                                            <div class="h-16 w-16 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 dark:border-gray-600 bg-white dark:bg-gray-900">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        
                                        <input type="file" wire:model="promo_banner_1" id="promo_banner_1" class="hidden">
                                        <div class="flex gap-2">
                                            <label for="promo_banner_1" class="cursor-pointer bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 border border-gray-300 py-1.5 px-3 rounded-xl text-xs font-bold shadow-sm hover:bg-gray-50 transition">
                                                Seleccionar
                                            </label>
                                            @if ($promo_banner_1 || $promo_banner_1_path)
                                                <button type="button" wire:click="deletePromoBanner1" class="bg-red-50 hover:bg-red-100 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300 py-1.5 px-3 rounded-xl text-xs font-bold transition">
                                                    Eliminar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="promo_banner_1" class="text-xs text-indigo-600 mt-1">Cargando imagen...</div>
                                    @error('promo_banner_1') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                                    <div class="mt-4">
                                        <label for="promo_banner_1_link" class="block text-xs font-bold text-gray-500 dark:text-gray-400">Enlace de Redirección</label>
                                        <input type="text" wire:model="promo_banner_1_link" id="promo_banner_1_link" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="https://...">
                                        @error('promo_banner_1_link') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Promo 2 (1/3 width) -->
                                <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
                                    <label class="block text-sm font-bold text-gray-800 dark:text-gray-200">Banner Derecho (Angosto - 1/3)</label>
                                    <p class="text-[10px] text-gray-400 mt-1 mb-3">Sube una imagen cuadrada u horizontal corta (Proporción 1.15:1 o similar 600x520px).</p>
                                    
                                    <div class="flex items-center gap-4">
                                        @if ($promo_banner_2)
                                            <img src="{{ $promo_banner_2->temporaryUrl() }}" class="h-16 w-auto rounded border shadow-sm">
                                        @elseif ($promo_banner_2_path)
                                            <img src="{{ Storage::url($promo_banner_2_path) }}" class="h-16 w-auto rounded border shadow-sm">
                                        @else
                                            <div class="h-16 w-16 rounded-xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 dark:border-gray-600 bg-white dark:bg-gray-900">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        
                                        <input type="file" wire:model="promo_banner_2" id="promo_banner_2" class="hidden">
                                        <div class="flex gap-2">
                                            <label for="promo_banner_2" class="cursor-pointer bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 border border-gray-300 py-1.5 px-3 rounded-xl text-xs font-bold shadow-sm hover:bg-gray-50 transition">
                                                Seleccionar
                                            </label>
                                            @if ($promo_banner_2 || $promo_banner_2_path)
                                                <button type="button" wire:click="deletePromoBanner2" class="bg-red-50 hover:bg-red-100 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300 py-1.5 px-3 rounded-xl text-xs font-bold transition">
                                                    Eliminar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="promo_banner_2" class="text-xs text-indigo-600 mt-1">Cargando imagen...</div>
                                    @error('promo_banner_2') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                                    <div class="mt-4">
                                        <label for="promo_banner_2_link" class="block text-xs font-bold text-gray-500 dark:text-gray-400">Enlace de Redirección</label>
                                        <input type="text" wire:model="promo_banner_2_link" id="promo_banner_2_link" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" placeholder="https://...">
                                        @error('promo_banner_2_link') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Barra de Beneficios (Antes del Footer) -->
                        <div class="space-y-4">
                            <h4 class="text-md font-bold text-slate-800 dark:text-slate-200 border-b pb-2 flex items-center gap-2">
                                <span>🛡️</span> Barra de Beneficios (Antes del Footer)
                            </h4>
                            <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-4">
                                <div class="mb-4">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="benefits_enabled" id="benefits_enabled" class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4.5 w-4.5 dark:border-gray-600 dark:bg-gray-900">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">Habilitar barra de beneficios de compra</span>
                                            <span class="block text-xs text-gray-400">Si se marca, se mostrará una barra horizontal con 4 boxes informativos destacados arriba del pie de página.</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-show="$wire.benefits_enabled" x-cloak>
                                    
                                    <!-- Beneficio 1 -->
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                                        <span class="text-xs font-black uppercase text-indigo-600 dark:text-indigo-400 tracking-wider">🔒 Beneficio 1: Compra Segura</span>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Título</label>
                                            <input type="text" wire:model="benefit_1_title" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_1_title') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Subtítulo</label>
                                            <input type="text" wire:model="benefit_1_subtitle" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_1_subtitle') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <!-- Beneficio 2 -->
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                                        <span class="text-xs font-black uppercase text-indigo-600 dark:text-indigo-400 tracking-wider">🚚 Beneficio 2: Envíos</span>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Título</label>
                                            <input type="text" wire:model="benefit_2_title" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_2_title') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Subtítulo</label>
                                            <input type="text" wire:model="benefit_2_subtitle" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_2_subtitle') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <!-- Beneficio 3 -->
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                                        <span class="text-xs font-black uppercase text-indigo-600 dark:text-indigo-400 tracking-wider">🔄 Beneficio 3: Devoluciones</span>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Título</label>
                                            <input type="text" wire:model="benefit_3_title" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_3_title') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Subtítulo</label>
                                            <input type="text" wire:model="benefit_3_subtitle" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_3_subtitle') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <!-- Beneficio 4 -->
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700/60 shadow-sm space-y-3">
                                        <span class="text-xs font-black uppercase text-indigo-600 dark:text-indigo-400 tracking-wider">🎧 Beneficio 4: Atención</span>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Título</label>
                                            <input type="text" wire:model="benefit_4_title" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_4_title') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400">Subtítulo</label>
                                            <input type="text" wire:model="benefit_4_subtitle" class="mt-1 block w-full text-sm border-gray-300 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                            @error('benefit_4_subtitle') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-900/50 text-right">
                        <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-md text-sm font-black rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition">
                            Guardar Apariencia & Promos
                        </button>
                    </div>
                </div>
            </form>
        @endif

        <!-- ==================== TAB 3: CARRUSEL PRINCIPAL ==================== -->
        @if($activeTab === 'carrusel')
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>🎞️</span> Carrusel de Banners Principal (Swiper)
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Crea y edita los banners grandes deslizantes de la página de inicio. Soporta imágenes independientes para móvil.</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($banners as $banner)
                            <div class="border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition bg-white dark:bg-gray-900 group">
                                <div class="relative h-44 bg-slate-100 dark:bg-slate-800">
                                    <img src="{{ Storage::url($banner->image_path) }}" class="w-full h-full object-cover">
                                    <div class="absolute top-3 right-3 flex gap-2">
                                        <button wire:click="toggleActive('{{ $banner->id }}')" class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm {{ $banner->is_active ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }}">
                                            {{ $banner->is_active ? 'Activo' : 'Oculto' }}
                                        </button>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 truncate dark:text-white">{{ $banner->title ?: 'Sin Título' }}</h3>
                                    <p class="text-xs text-gray-400 truncate dark:text-gray-500 mt-0.5">{{ $banner->subtitle ?: 'Sin Subtítulo' }}</p>
                                    
                                    <div class="mt-3 flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">💻 Desktop</span>
                                        @if($banner->mobile_image_path)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">📱 Móvil</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between items-center pt-3 border-t border-dashed border-gray-100 dark:border-gray-700">
                                        <span class="text-xs font-bold text-gray-400">Orden: {{ $banner->order }}</span>
                                        <div class="flex gap-1.5">
                                            <button wire:click="edit('{{ $banner->id }}')" class="p-2 text-indigo-600 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:bg-indigo-950/50 rounded-xl transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button onclick="confirm('¿Estás seguro de que deseas eliminar este banner del carrusel?') || event.stopImmediatePropagation()" wire:click="delete('{{ $banner->id }}')" class="p-2 text-red-500 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50 rounded-xl transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(count($banners) == 0)
                        <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/40 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800 p-8 max-w-lg mx-auto mt-6">
                            <div class="p-4 bg-slate-100 dark:bg-slate-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-inner">
                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-slate-600 font-black dark:text-slate-300 text-lg uppercase tracking-tight">No hay banners configurados</p>
                            <p class="text-slate-400 text-sm mt-1 max-w-sm mx-auto dark:text-slate-500">Comienza agregando tu primer banner para el carrusel interactivo de la tienda online.</p>
                            <button wire:click="create()" class="mt-6 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold py-2.5 px-6 rounded-xl transition shadow-lg shadow-indigo-600/30 text-sm uppercase tracking-wider">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Agregar Primer Banner
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Banner Modal (CRUD) -->
            <x-dialog-modal wire:model.live="isOpen">
                <x-slot name="title">
                    <span class="font-black text-gray-900 dark:text-white">{{ $bannerId ? '✏️ Editar Banner del Carrusel' : '✨ Nuevo Banner del Carrusel' }}</span>
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-4 mt-2">
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Título Principal (Opcional)</label>
                            <input type="text" wire:model="title" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Subtítulo (Opcional)</label>
                            <input type="text" wire:model="subtitle" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Enlace de Redirección</label>
                                <input type="text" wire:model="link" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300" placeholder="https://...">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Orden de Visualización</label>
                                <input type="number" wire:model="order" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <!-- Desktop Banner -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Imagen Escritorio (Laptop/PC)</label>
                                <p class="text-[10px] text-gray-400 mb-2">Resolución recomendada: 1903x560px.</p>
                                <div class="flex justify-center px-4 py-4 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 bg-slate-50 dark:bg-slate-900">
                                    <div class="space-y-1 text-center">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" class="mx-auto h-24 w-auto rounded border p-1 bg-white">
                                        @elseif ($image_path)
                                            <img src="{{ Storage::url($image_path) }}" class="mx-auto h-24 w-auto rounded border p-1 bg-white">
                                        @else
                                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-44h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @endif
                                        <div class="flex text-xs text-gray-600 dark:text-gray-400 justify-center">
                                            <label for="image-upload" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                                <span>Subir Imagen</span>
                                                <input id="image-upload" wire:model="image" type="file" class="sr-only">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Mobile Banner -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Imagen Móvil (Smartphone)</label>
                                <p class="text-[10px] text-gray-400 mb-2">Resolución recomendada: 800x800px (1:1).</p>
                                <div class="flex justify-center px-4 py-4 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 bg-slate-50 dark:bg-slate-900">
                                    <div class="space-y-1 text-center">
                                        @if ($mobile_image)
                                            <img src="{{ $mobile_image->temporaryUrl() }}" class="mx-auto h-24 w-auto rounded border p-1 bg-white">
                                        @elseif ($mobile_image_path)
                                            <img src="{{ Storage::url($mobile_image_path) }}" class="mx-auto h-24 w-auto rounded border p-1 bg-white">
                                        @else
                                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-44h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        @endif
                                        <div class="flex text-xs text-gray-600 dark:text-gray-400 justify-center">
                                            <label for="mobile-image-upload" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                                <span>Subir Imagen</span>
                                                <input id="mobile-image-upload" wire:model="mobile_image" type="file" class="sr-only">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('mobile_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
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
        @endif

    </div>
</div>
