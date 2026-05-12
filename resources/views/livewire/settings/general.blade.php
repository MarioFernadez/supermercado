<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Section: Datos del Comercio -->
        <div class="mb-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Datos del Comercio</h3>
            <p class="mt-1 text-sm text-gray-600">
                Esta información se utilizará en los tickets, reportes y cabeceras del sistema.
            </p>
        </div>

        <div class="mt-2 mb-10">
            <form wire:submit.prevent="save">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="store_name" class="block text-sm font-medium text-gray-700">Nombre del Comercio</label>
                                <input type="text" wire:model="store_name" id="store_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('store_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="store_address" class="block text-sm font-medium text-gray-700">Dirección</label>
                                <input type="text" wire:model="store_address" id="store_address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('store_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="store_ruc" class="block text-sm font-medium text-gray-700">RUC / Razón Social</label>
                                <input type="text" wire:model="store_ruc" id="store_ruc" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('store_ruc') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="store_phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" wire:model="store_phone" id="store_phone" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('store_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="store_email" class="block text-sm font-medium text-gray-700">Email (Visible en tickets)</label>
                                <input type="email" wire:model="store_email" id="store_email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('store_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="ticket_footer" class="block text-sm font-medium text-gray-700">Mensaje Pie de Ticket</label>
                                <input type="text" wire:model="ticket_footer" id="ticket_footer" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Gracias por su compra">
                                @error('ticket_footer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Descuentos -->
                            <div class="col-span-6 border-t pt-4 mt-2">
                                <h4 class="text-sm font-semibold text-gray-800 mb-3">🏷️ Funcionalidades de Descuento</h4>
                                <div class="space-y-3">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="discount_product_enabled" id="discount_product_enabled"
                                            class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700">Descuento por producto</span>
                                            <span class="block text-xs text-gray-400">Permite asignar un % de descuento fijo a cada producto desde el catálogo.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="discount_manual_enabled" id="discount_manual_enabled"
                                            class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700">Descuento manual en el POS</span>
                                            <span class="block text-xs text-gray-400">Permite al cajero aplicar un % de descuento al total de la venta en el momento.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Configuración Ecommerce -->
                            @if(\App\Services\LicenseService::isEcommerceEnabled())
                            <div class="col-span-6 border-t pt-4 mt-2">
                                <h4 class="text-sm font-semibold text-gray-800 mb-3">🛒 Configuración E-commerce (ZonaShop)</h4>
                                <div class="grid grid-cols-6 gap-6">
                                    <!-- WhatsApp pedidos -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="shop_whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp para Ventas</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                +595
                                            </span>
                                            <input type="text" wire:model="shop_whatsapp" id="shop_whatsapp" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="981123456">
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Sin el código de país. Ej: 981123456</p>
                                        @error('shop_whatsapp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>



                                    <!-- Social Media -->
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="shop_facebook" class="block text-sm font-medium text-gray-700">📘 Facebook URL</label>
                                        <input type="text" wire:model="shop_facebook" id="shop_facebook" placeholder="https://facebook.com/..." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('shop_facebook') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="shop_instagram" class="block text-sm font-medium text-gray-700">📸 Instagram URL</label>
                                        <input type="text" wire:model="shop_instagram" id="shop_instagram" placeholder="https://instagram.com/..." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('shop_instagram') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="shop_tiktok" class="block text-sm font-medium text-gray-700">🎵 TikTok URL</label>
                                        <input type="text" wire:model="shop_tiktok" id="shop_tiktok" placeholder="https://tiktok.com/@..." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('shop_tiktok') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Logo de la Tienda</label>
                                        <div class="mt-1 flex items-center gap-4">
                                            @if ($shop_logo)
                                                <img src="{{ $shop_logo->temporaryUrl() }}" class="h-12 w-auto rounded border shadow-sm">
                                            @elseif ($shop_logo_path)
                                                <img src="{{ Storage::url($shop_logo_path) }}" class="h-12 w-auto rounded border shadow-sm">
                                            @else
                                                <div class="h-12 w-12 rounded border border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <input type="file" wire:model="shop_logo" id="shop_logo" class="hidden">
                                            <div class="flex gap-2">
                                                <label for="shop_logo" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Seleccionar Logo
                                                </label>
                                                @if ($shop_logo || $shop_logo_path)
                                                    <button type="button" wire:click="deleteLogo" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        Eliminar
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="shop_logo" class="text-xs text-indigo-600 mt-1">Cargando...</div>
                                        @error('shop_logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Favicon (Ícono de pestaña)</label>
                                        <p class="text-[10px] text-gray-400 mb-2">Recomendado: PNG o ICO (32x32px), fondo transparente.</p>
                                        <div class="mt-1 flex items-center gap-4">
                                            @if ($shop_favicon)
                                                <img src="{{ $shop_favicon->temporaryUrl() }}" class="h-8 w-8 rounded border shadow-sm">
                                            @elseif ($shop_favicon_path)
                                                <img src="{{ Storage::url($shop_favicon_path) }}" class="h-8 w-8 rounded border shadow-sm">
                                            @else
                                                <div class="h-8 w-8 rounded border border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <input type="file" wire:model="shop_favicon" id="shop_favicon" class="hidden">
                                            <div class="flex gap-2">
                                                <label for="shop_favicon" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Seleccionar Ícono
                                                </label>
                                                @if ($shop_favicon || $shop_favicon_path)
                                                    <button type="button" wire:click="deleteFavicon" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        Eliminar
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="shop_favicon" class="text-xs text-indigo-600 mt-1">Cargando...</div>
                                        @error('shop_favicon') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model="shop_show_pricelist" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700 font-bold uppercase tracking-widest">Habilitar descarga de lista de precios (TXT)</span>
                                        </label>
                                        <p class="text-[10px] text-gray-400 ml-7">Si se activa, aparecerá un botón en la tienda para bajar los precios en formato texto.</p>
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="shop_schedule" class="block text-sm font-medium text-gray-700">🕒 Horario de Atención (Multilínea)</label>
                                        <textarea wire:model="shop_schedule" id="shop_schedule" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Lun a Vie 07:00 - 12:00&#10;Sáb 08:00 - 15:00"></textarea>
                                        @error('shop_schedule') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="shop_banner_limit" class="block text-sm font-medium text-gray-700">🖼️ Máximo de Banners en Carrusel</label>
                                        <input type="number" wire:model="shop_banner_limit" id="shop_banner_limit" min="1" max="10" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <p class="text-[10px] text-gray-400 mt-1">Límite recomendado: 3 a 5 para mejor velocidad.</p>
                                        @error('shop_banner_limit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="shop_description" class="block text-sm font-medium text-gray-700">📝 Descripción de la Tienda (Aparece en el footer)</label>
                                        <textarea wire:model="shop_description" id="shop_description" rows="2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Somos una tienda líder en tecnología en Ciudad del Este..."></textarea>
                                        @error('shop_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="shop_payment_instructions" class="block text-sm font-medium text-gray-700">💳 Instrucciones de Pago (Aparecen al confirmar pedido)</label>
                                        <textarea wire:model="shop_payment_instructions" id="shop_payment_instructions" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Transferencia Bancaria:&#10;Banco: Itau&#10;Cuenta: 1234567&#10;Nombre: ZonaShop S.A."></textarea>
                                        <p class="text-[10px] text-gray-400 mt-1">Escribe aquí los datos de tus cuentas bancarias, números de giros, etc. Se mostrarán al cliente al elegir 'Transferencia'.</p>
                                        @error('shop_payment_instructions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="shop_maps_iframe" class="block text-sm font-medium text-gray-700">🗺️ Código Iframe de Google Maps</label>
                                        <textarea wire:model="shop_maps_iframe" id="shop_maps_iframe" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'></textarea>
                                        <p class="text-[10px] text-gray-400 mt-1">Pega aquí el código "Insertar mapa" que te da Google Maps.</p>
                                        @error('shop_maps_iframe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>

            @if (session()->has('message'))
                <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <div>
                        <p class="font-bold">Guardado</p>
                        <p>{{ session('message') }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="border-t border-gray-200 mb-10"></div>

        <!-- Section: Métodos de Pago Dinámicos -->
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900 uppercase tracking-tight font-black">Métodos de Pago</h3>
                <p class="mt-1 text-sm text-gray-600 font-medium">
                    Gestiona las opciones de pago disponibles en el POS y Gastos.
                </p>
            </div>
            <a href="{{ route('settings.payment-methods') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-lg text-xs uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Configurar Métodos
            </a>
        </div>

        <div class="border-t border-gray-200 mb-10"></div>

        <!-- Section: Respaldo del Sistema -->
        <div class="mb-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Respaldo del Sistema</h3>
            <p class="mt-1 text-sm text-gray-600">
                Descarga una copia completa de la base de datos y archivos del sistema.
            </p>
        </div>

        <div class="mt-2 mb-10">
            <div class="shadow overflow-hidden sm:rounded-md bg-white">
                <div class="px-4 py-5 sm:p-6">
                    <div class="text-sm text-gray-500 mb-4">
                        Al pulsar el botón, el sistema generará un archivo ZIP con todos los datos. Esto puede tardar unos segundos.
                    </div>
                    @if (session()->has('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    <form action="{{ route('settings.backup.run') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Generar y Descargar Respaldo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
