<div class="flex h-screen w-full bg-gray-100">
    <!-- Left Section: Products -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Header / Search -->
        <div class="bg-white p-4 shadow-sm z-10">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('dashboard') }}" class="text-green-500 font-bold text-xl flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    ZonaPOS
                </a>
                <div class="flex items-center gap-4">
                    <div class="text-sm font-medium text-gray-500 hidden md:block">
                        Usuario: <span class="text-gray-900 font-bold">{{ auth()->user()->name }}</span>
                    </div>
                    @if($currentRegisterName)
                    <div class="hidden md:flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-700 px-2.5 py-1 rounded-lg text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $currentRegisterName }} · desde {{ $sessionOpenedAt }}
                    </div>
                    @endif

                    <!-- Web Orders Button -->
                    <button type="button" wire:click="openWebOrdersModal" class="relative bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-lg transition-all flex items-center justify-center shadow-sm active:scale-95" title="Pedidos Web Pendientes">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($pendingWebOrdersCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full border-2 border-white animate-bounce shadow-md">
                                {{ $pendingWebOrdersCount }}
                            </span>
                        @endif
                    </button>


                    <button type="button" wire:click="openMovementModal('in')" wire:loading.attr="disabled" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm font-bold border border-gray-300 transition-colors flex items-center justify-center" title="Registrar Movimientos">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </button>

                    <button wire:click="openStatusModal" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-2 rounded-lg text-sm font-bold border border-indigo-200 transition-colors flex items-center justify-center" title="Estado de Caja">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </button>

                    <button wire:click="openVoidModal" class="bg-orange-50 text-orange-600 hover:bg-orange-100 px-3 py-2 rounded-lg text-sm font-bold border border-orange-200 transition-colors flex items-center justify-center" title="Anular Venta">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    @if($lastSaleId)
                        <button wire:click="printLastTicket" class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 px-3 py-2 rounded-lg text-sm font-bold border border-yellow-200 transition-colors flex items-center justify-center" title="Imprimir último ticket">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </button>
                    @endif



                    <a href="{{ route('cash.index') }}" class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-2 rounded-lg text-sm font-bold border border-red-200 transition-colors flex items-center justify-center" title="Cerrar Caja (Finalizar Sesión)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </a>
                </div>
            </div>
            
            <div class="flex gap-2">
                <!-- Rest of search... -->
                <div class="relative flex-1">
                    <input id="product-search-input" wire:model.live.debounce.150ms="search" type="text" 
                        class="w-full pl-10 pr-12 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm text-lg" 
                        placeholder="Buscar producto por nombre o código (SKU)..." autofocus>
                    <div class="absolute left-3 top-3.5 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div class="absolute right-3 top-3.5">
                        <span class="text-xs font-bold text-gray-400 border border-gray-300 rounded px-1.5 py-1 bg-gray-50">F2</span>
                    </div>
                </div>
            </div>
            
            <!-- Category Filter Pills -->
            <div class="flex gap-2 mt-3 overflow-x-auto pb-1 scrollbar-hide">
                <button wire:click="filterCategory(null)" 
                    class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ is_null($selectedCategory) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Todos
                </button>
                @foreach($categories as $category)
                    <button wire:click="filterCategory('{{ $category->id }}')" 
                        class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition-colors {{ $selectedCategory === $category->id ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Product Grid -->
        <div class="flex-1 overflow-y-auto p-4 content-start products-h">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                    @php
                        $isOutOfStock = $product->manage_stock && $product->stock <= 0;
                        $isLowStock = $product->manage_stock && !$isOutOfStock && $product->stock <= $product->min_stock;
                    @endphp
                    <div 
                        wire:key="{{ $product->id }}"
                        wire:click="addToCart('{{ $product->id }}')" 
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all overflow-hidden border h-full flex flex-col relative group cursor-pointer hover:-translate-y-1 {{ $isLowStock ? 'border-orange-400 ring-1 ring-orange-200' : ($isOutOfStock ? 'border-red-300 ring-1 ring-red-100' : 'border-gray-100') }}"
                    >
                        @if($isOutOfStock)
                            <div class="absolute inset-0 z-10 pointer-events-none flex items-center justify-center">
                                <span class="bg-red-600/90 text-white text-xs font-bold px-2 py-1 rounded shadow-lg transform rotate-[-12deg] border border-white">SIN STOCK</span>
                            </div>
                        @elseif($isLowStock)
                            <div class="absolute top-2 right-2 z-10">
                                <span class="bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm animate-pulse">BAJO STOCK</span>
                            </div>
                        @endif

                        <div class="p-3 flex-1 flex flex-col justify-between h-full">
                            <div>
                                <div class="text-xs text-gray-500 mb-1 font-mono">{{ $product->sku }}</div>
                                <h3 class="font-bold text-gray-800 leading-tight text-sm mb-1 line-clamp-2">{{ $product->name }}</h3>
                            </div>
                            <div class="mt-2 flex justify-between items-end border-t border-gray-50 pt-2">
                                @if($discountProductEnabled && $product->discount_percentage > 0)
                                    <div>
                                        <div class="flex items-center gap-1">
                                            <span class="line-through text-gray-400 text-xs">&#8370; {{ number_format($product->price_sale, 0, ',', '.') }}</span>
                                            <span class="bg-red-500 text-white text-[9px] font-bold px-1 rounded">-{{ $product->discount_percentage }}%</span>
                                        </div>
                                        <span class="text-green-600 font-bold text-base">&#8370; {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <span class="text-primary-600 font-bold text-base">&#8370; {{ number_format($product->price_sale, 0, ',', '.') }}</span>
                                @endif
                                <div class="text-[10px] px-1.5 py-0.5 rounded {{ $isLowStock ? 'bg-orange-100 text-orange-800 font-bold' : ($isOutOfStock ? 'bg-red-100 text-red-800 font-bold' : 'bg-gray-100 text-gray-500') }}">
                                    @if($product->manage_stock)
                                        Stock: {{ $product->stock }}
                                    @else
                                        ∞
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(count($products) === 0)
                <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-lg">No se encontraron productos</p>
                    <button wire:click="openCreateProductModal" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Crear Nuevo Producto
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Section: Cart -->
    <div class="w-96 bg-white shadow-2xl z-20 flex flex-col h-full border-l border-gray-200 hidden md:flex">
        <!-- Cart Header -->
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Carrito
                </h2>
                @if($importingWebOrderId)
                    <div class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-tighter animate-pulse">
                        Pedido Web Importado
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">{{ count($cart) }} Items</span>
                    @if(count($cart) > 0)
                        <button wire:click="clearCart" wire:confirm="¿Vaciar carrito?" class="text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded transition" title="Vaciar Carrito">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Customer Selector -->
            <div class="relative">
                @if($selectedCustomer)
                    <div class="flex justify-between items-center bg-white border border-green-200 rounded-lg p-2 shadow-sm">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-1.5 rounded-full text-green-600 mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="leading-tight">
                                <div class="font-bold text-gray-800 text-sm truncate max-w-[150px]">{{ $selectedCustomer['name'] }}</div>
                                <div class="text-[10px] text-gray-500">{{ $selectedCustomer['ruc'] }}</div>
                            </div>
                        </div>
                        <button wire:click="removeCustomer" class="text-gray-400 hover:text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @else
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input id="customer-search-input" wire:model.live.debounce.300ms="customerSearch" type="text" 
                            class="w-full pl-9 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                            placeholder="Buscar Cliente (Nombre / RUC)...">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                             <span class="text-[10px] font-bold text-gray-400 border border-gray-300 rounded px-1 bg-gray-50">F8</span>
                        </div>
                    </div>

                    @if(!empty($customerSearch) && !$selectedCustomer)
                        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-48 overflow-y-auto">
                            @forelse($searchResults as $result)
                                <button wire:click="selectCustomer('{{ $result['id'] }}')" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex justify-between items-center border-b border-gray-50 last:border-0">
                                    <span class="font-medium text-gray-700">{{ $result['name'] }}</span>
                                    <span class="text-xs text-gray-500">{{ $result['ruc'] }}</span>
                                </button>
                            @empty
                                <div class="px-4 py-2 text-sm text-gray-500 text-center">
                                    No encontrado
                                    <button wire:click="openCreateCustomerModal" class="block w-full mt-1 text-indigo-600 font-bold hover:underline">
                                        + Crear Nuevo Cliente
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 cart-h">
            @if(count($cart) > 0)
                <div class="space-y-4">
                    @foreach($cart as $cartKey => $item)
                        <div class="flex justify-between items-start pb-4 border-b border-gray-100 last:border-0" wire:key="cart-{{ $cartKey }}">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 text-sm line-clamp-2">{{ $item['name'] }}</h4>
                                <div class="text-xs text-gray-500 mt-1">Ref: {{ $item['sku'] }}</div>
                                <div class="text-indigo-600 font-bold mt-1">₲ {{ format_pyg($item['price']) }}</div>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-center bg-gray-100 rounded-lg p-0.5">
                                    <button wire:click="updateQuantity('{{ $cartKey }}', -1)" class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm rounded transition">-</button>
                                    
                                    @if(isset($item['unit_type']) && $item['unit_type'] !== 'unit')
                                        <input 
                                            type="number" 
                                            step="0.001"
                                            value="{{ $item['quantity'] }}"
                                            wire:blur="setQuantity('{{ $cartKey }}', $event.target.value)"
                                            class="w-16 text-center text-sm font-bold bg-transparent border-0 focus:ring-0 p-0 appearance-none"
                                        >
                                    @else
                                        <span class="w-8 text-center text-sm font-bold">{{ $item['quantity'] }}</span>
                                    @endif
                                    
                                    <button wire:click="updateQuantity('{{ $cartKey }}', 1)" class="w-7 h-7 flex items-center justify-center text-green-600 hover:bg-white hover:shadow-sm rounded transition">+</button>
                                </div>
                                @if(isset($item['unit_type']) && $item['unit_type'] !== 'unit')
                                    <div class="text-[10px] text-gray-400 mt-0.5 text-right pr-1">{{ $item['unit_type'] }}</div>
                                @endif
                                <div class="mt-2 font-bold text-gray-900">
                                    ₲ {{ format_pyg($item['price'] * $item['quantity']) }}
                                </div>
                                <button wire:click="removeFromCart('{{ $cartKey }}')" class="text-[10px] text-red-500 hover:underline mt-1 uppercase font-bold">Quitar</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-400 opacity-50">
                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p>Carrito vacío</p>
                </div>
            @endif
        </div>

        <!-- Cart Footer / Totals -->
        <div class="bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">

            @if($discountManualEnabled && count($cart) > 0)
            <div class="flex items-center gap-2 mb-3 bg-orange-50 border border-orange-200 rounded-lg px-3 py-2">
                <span class="text-sm font-medium text-orange-700 whitespace-nowrap">🏷️ Descuento:</span>
                <div class="relative flex-1 max-w-[80px]">
                    <input type="number" wire:model.live.debounce.300ms="manualDiscountPct"
                        min="0" max="100" step="1"
                        class="w-full text-center border border-orange-300 rounded py-1 text-sm font-bold text-orange-700 focus:outline-none focus:ring-1 focus:ring-orange-400 bg-white pr-5">
                    <span class="absolute right-1.5 top-1 text-orange-500 text-xs font-bold">%</span>
                </div>
                @if($discountAmount > 0)
                <span class="text-xs text-orange-600 font-medium">- &#8370; {{ number_format($discountAmount, 0, ',', '.') }}</span>
                @endif
            </div>
            @endif

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-gray-600 text-sm">
                    <span>Subtotal</span>
                    <span>&#8370; {{ number_format($subtotalBeforeDiscount ?: $total, 0, ',', '.') }}</span>
                </div>
                @if($discountAmount > 0)
                <div class="flex justify-between text-red-600 text-sm font-medium">
                    <span>Descuento @if($manualDiscountPct > 0)({{ $manualDiscountPct }}%)@endif</span>
                    <span>- &#8370; {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-gray-600 text-sm">
                    <span>IVA (10%)</span>
                    <!-- Simplified tax calc for display -->
                    <span>&#8370; {{ number_format($total / 11, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-dashed border-gray-300">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-indigo-700">&#8370; {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <!-- Multi-Currency Display -->
                @if($total > 0 && (array_sum($rates) > 0))
                <div class="mt-2 pt-2 border-t border-gray-100 grid grid-cols-2 gap-2 text-xs text-gray-500">
                    @if($rates['usd'] > 0)
                        <div class="flex justify-between">
                            <span>USD ({{ number_format($rates['usd'], 0, ',', '.') }})</span>
                            <span class="font-bold text-gray-700">U$ {{ number_format($total / $rates['usd'], 2, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($rates['brl'] > 0)
                        <div class="flex justify-between">
                            <span>BRL ({{ number_format($rates['brl'], 0, ',', '.') }})</span>
                            <span class="font-bold text-gray-700">R$ {{ number_format($total / $rates['brl'], 2, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($rates['ars'] > 0)
                        <div class="flex justify-between">
                            <span>ARS ({{ number_format($rates['ars'], 2, ',', '.') }})</span>
                            <span class="font-bold text-gray-700">$ {{ number_format($total / $rates['ars'], 2, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($rates['eur'] > 0)
                        <div class="flex justify-between">
                            <span>EUR ({{ number_format($rates['eur'], 0, ',', '.') }})</span>
                            <span class="font-bold text-gray-700">€ {{ number_format($total / $rates['eur'], 2, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>
            
            @if (session()->has('success'))
                <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4 text-center animate-pulse-once">
                    <div class="mb-3 text-green-600 font-bold text-lg flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        ¡Venta Exitosa!
                    </div>
                    
                    @if(session('last_sale_id'))
                        <a href="{{ route('sales.ticket', session('last_sale_id')) }}" target="_blank" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow transition-colors flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            IMPRIMIR TICKET
                        </a>
                        <button wire:click="$set('lastSaleId', null)" class="mt-3 text-sm text-gray-500 underline hover:text-gray-700">Nueva Venta</button>
                    @endif
                </div>
            @else
                <button 
                    id="btn-pay"
                    wire:click="openPaymentModal" 
                    @if(count($cart) === 0) disabled @endif
                    class="w-full font-bold py-4 rounded-xl shadow-lg transform active:scale-95 transition-all text-lg flex justify-center items-center {{ count($cart) > 0 ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                    <span>COBRAR <small class="opacity-80 font-normal ml-1">(F4)</small></span>
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </button>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 animate-shake" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Movement Modal (Raw HTML) -->
    @if($showMovementModal)
        <div class="fixed z-[100] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    Registrar Movimiento
                                </h3>
                                
                                <!-- Type Switcher -->
                                <div class="flex rounded-md shadow-sm mb-4" role="group">
                                    <button type="button" wire:click="$set('movementType', 'in')" class="flex-1 py-2 text-sm font-medium border rounded-l-lg focus:z-10 focus:ring-2 {{ $movementType === 'in' ? 'bg-green-600 text-white border-green-600 hover:bg-green-700' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                        🟢 Ingreso Extra
                                    </button>
                                    <button type="button" wire:click="$set('movementType', 'out')" class="flex-1 py-2 text-sm font-medium border rounded-r-lg focus:z-10 focus:ring-2 {{ $movementType === 'out' ? 'bg-red-600 text-white border-red-600 hover:bg-red-700' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                        🔴 Gasto / Retiro
                                    </button>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Monto</label>
                                        <input wire:model="movementAmount" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="0">
                                        @error('movementAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción / Motivo</label>
                                        <input wire:model="movementDescription" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ej: Compra de insumos, Pago delivery, etc.">
                                        @error('movementDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Categoría (Opcional)</label>
                                        <select wire:model="movementCategory" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            <option value="">Sin categoría</option>
                                            @if($movementType === 'in')
                                                @foreach($movementCategories['in'] as $key => $label)
                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            @else
                                                @foreach($movementCategories['out'] as $key => $label)
                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('movementCategory') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click="saveMovement" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5 {{ $movementType === 'in' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                                {{ $movementType === 'in' ? 'Guardar Ingreso' : 'Guardar Salida' }}
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <button wire:click="$set('showMovementModal', false)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancelar
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Cash Status Modal -->
    <!-- Cash Status Modal (Consistent Raw HTML) -->
    @if($showStatusModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    Estado de Caja
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                                        <span class="text-gray-600">Apertura:</span>
                                        <span class="font-mono font-bold">{{ \Carbon\Carbon::parse($sessionDetails['opened_at'])->format('d/m/Y H:i') }}</span>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Monto Inicial:</span>
                                            <span class="font-bold text-gray-800">₲ {{ format_pyg($sessionDetails['opening_amount']) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Ventas Efectivo:</span>
                                            <span class="font-bold text-green-600">+ ₲ {{ format_pyg($sessionDetails['sales_cash'] ?? 0) }}</span>
                                        </div>
                                        @if(($sessionDetails['sales_total'] - ($sessionDetails['sales_cash'] ?? 0)) > 0)
                                            <div class="flex justify-between items-center text-xs text-gray-400">
                                                <span>Otros (Tarjeta/Crédito):</span>
                                                <span>₲ {{ format_pyg($sessionDetails['sales_total'] - ($sessionDetails['sales_cash'] ?? 0)) }}</span>
                                            </div>
                                        @endif
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Ingresos Extra:</span>
                                            <span class="font-bold text-green-600">+ ₲ {{ format_pyg($sessionDetails['total_in']) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Gastos / Retiros:</span>
                                            <span class="font-bold text-red-600">- ₲ {{ format_pyg($sessionDetails['total_out']) }}</span>
                                        </div>
                                        
                                        <div class="border-t pt-2 mt-2">
                                            <div class="flex justify-between items-center text-lg">
                                                <span class="font-bold text-gray-800">Total en Caja:</span>
                                                <span class="font-bold text-indigo-600">₲ {{ format_pyg($sessionDetails['expected_total']) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click="$set('showStatusModal', false)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cerrar
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Success/Error Toast -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:session-status-changed.window="message = 'Movimiento registrado'; type = 'success'; show = true; setTimeout(() => show = false, 3000)"
         x-on:success-movement.window="message = $event.detail; type = 'success'; show = true; setTimeout(() => show = false, 3000)"
         x-on:error-movement.window="message = $event.detail; type = 'error'; show = true; setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 z-50">
        <div x-show="show" x-transition 
             :class="type === 'success' ? 'bg-gray-800 text-white' : 'bg-red-600 text-white'"
             class="px-6 py-3 rounded-lg shadow-lg flex items-center">
            
            <!-- Success Icon -->
            <svg x-show="type === 'success'" class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            
            <!-- Error Icon -->
            <svg x-show="type === 'error'" class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            
            <span x-text="message"></span>
        </div>
    </div>

    <!-- Customer Modal (Matches Customers Module) -->
    @if($showCustomerModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="saveNewCustomer">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Registrar Nuevo Cliente
                            </h3>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <!-- RUC -->
                                <div class="col-span-1">
                                    <label for="newCustomerRuc" class="block text-gray-700 text-sm font-bold mb-2">RUC / CI <span class="text-red-500">*</span></label>
                                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="newCustomerRuc" wire:model="newCustomerRuc">
                                    @error('newCustomerRuc') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Name -->
                                <div class="col-span-1">
                                    <label for="newCustomerName" class="block text-gray-700 text-sm font-bold mb-2">Razón Social / Nombre <span class="text-red-500">*</span></label>
                                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="newCustomerName" wire:model="newCustomerName">
                                    @error('newCustomerName') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Email -->
                                <div class="col-span-1">
                                    <label for="newCustomerEmail" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                    <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="newCustomerEmail" wire:model="newCustomerEmail">
                                    @error('newCustomerEmail') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-span-1">
                                    <label for="newCustomerPhone" class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
                                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="newCustomerPhone" wire:model="newCustomerPhone">
                                    @error('newCustomerPhone') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Address -->
                                <div class="col-span-1 md:col-span-2">
                                    <label for="newCustomerAddress" class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
                                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="newCustomerAddress" wire:model="newCustomerAddress" rows="2"></textarea>
                                    @error('newCustomerAddress') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Activo -->
                                <div class="col-span-1 md:col-span-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="newCustomerIsActive" class="form-checkbox h-5 w-5 text-indigo-600">
                                        <span class="ml-2 text-gray-700">Cliente Activo</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Guardar Cliente
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button wire:click="$set('showCustomerModal', false)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Cancelar
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Product Modal (Consistent Style) -->
    @if($showProductModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="saveNewProduct">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Registrar Nuevo Producto
                            </h3>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- SKU -->
                                <div class="col-span-1">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">SKU / Código (Opcional)</label>
                                    <input type="text" wire:model="newProductSku" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Vacío = Auto-generar">
                                    @error('newProductSku') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Category -->
                                <div class="col-span-1">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                                    <select wire:model="newProductCategoryId" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">Seleccionar Categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('newProductCategoryId') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Unit Type -->
                                <div class="col-span-1">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Unidad de Medida</label>
                                    <select wire:model="newProductUnitType" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="unit">Unidad (Default)</option>
                                        <option value="kg">Kilogramo (kg)</option>
                                        <option value="liter">Litro</option>
                                        <option value="meter">Metro</option>
                                    </select>
                                    @error('newProductUnitType') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Name -->
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="newProductName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('newProductName') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Cost Price -->
                                <div class="col-span-1">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Precio Costo (₲) <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="newProductPriceCost" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    @error('newProductPriceCost') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Sale Price -->
                                <div class="col-span-1">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Precio Venta (₲) <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="newProductPriceSale" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    @error('newProductPriceSale') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <!-- Manage Stock Checkbox -->
                                <div class="col-span-1 md:col-span-2">
                                     <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model.live="newProductManageStock" class="form-checkbox h-5 w-5 text-indigo-600">
                                        <span class="ml-2 text-gray-700 font-bold">Controlar Stock</span>
                                    </label>
                                </div>

                                @if($newProductManageStock)
                                    <!-- Stock -->
                                    <div class="col-span-1">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Stock Inicial <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.001" wire:model="newProductStock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @error('newProductStock') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>

                                    <!-- Min Stock -->
                                    <div class="col-span-1">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Stock Mínimo</label>
                                        <input type="number" step="0.001" wire:model="newProductMinStock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @error('newProductMinStock') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                @endif

                                <!-- Active -->
                                <div class="col-span-1 md:col-span-2">
                                     <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="newProductIsActive" class="form-checkbox h-5 w-5 text-indigo-600">
                                        <span class="ml-2 text-gray-700">Producto Activo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Guardar Producto
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button wire:click="$set('showProductModal', false)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Cancelar
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Payment Processing Modal -->
    @if($showPaymentModal)
        <div class="fixed z-[60] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-4">
                        <div class="text-center mb-4">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Confirmar Pago</h3>
                            <div class="mt-2">
                                <p class="text-xs text-gray-500">Total a Pagar</p>
                                <p class="text-3xl font-extrabold text-indigo-600">₲ {{ format_pyg($total) }}</p>
                            </div>
                        </div>

                        <!-- Condition Selection -->
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Condición de Venta</label>
                            <div class="flex items-center space-x-6 mt-1">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="paymentCondition" value="contado" wire:model.live="paymentCondition" class="form-radio h-3 w-3 text-indigo-600 transition duration-150 ease-in-out">
                                    <span class="ml-2 text-xs font-bold text-gray-700">Contado</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="paymentCondition" value="credito" wire:model.live="paymentCondition" class="form-radio h-3 w-3 text-orange-600 transition duration-150 ease-in-out">
                                    <span class="ml-2 text-xs font-bold text-gray-700">Crédito</span>
                                </label>
                            </div>
                        </div>

                        @if($paymentCondition === 'contado')
                            <!-- Seller Selector -->
                            <div class="mb-2">
                                <label class="block text-xs font-bold text-indigo-800 mb-1">Vendedor</label>
                                <select wire:model="sellerId" class="block w-full text-xs border-indigo-300 rounded-md py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">— Sin vendedor —</option>
                                    @foreach($sellerOptions as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Method Selection -->
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-700 mb-2">Método de Pago</label>
                                <div class="grid grid-cols-3 gap-1">
                                    <button type="button" wire:click="$set('paymentMethod', 'efectivo')" class="flex items-center justify-center px-2 py-2 border rounded-md shadow-sm text-xs font-bold transition-colors {{ $paymentMethod === 'efectivo' ? 'bg-indigo-600 border-transparent text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        💵 Efectivo
                                    </button>
                                    <button type="button" wire:click="$set('paymentMethod', 'tarjeta')" class="flex items-center justify-center px-2 py-2 border rounded-md shadow-sm text-xs font-bold transition-colors {{ $paymentMethod === 'tarjeta' ? 'bg-indigo-600 border-transparent text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        💳 Tarjeta
                                    </button>
                                    <button type="button" wire:click="$set('paymentMethod', 'qr')" class="flex items-center justify-center px-2 py-2 border rounded-md shadow-sm text-xs font-bold transition-colors {{ $paymentMethod === 'qr' ? 'bg-indigo-600 border-transparent text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                         QR 📱
                                    </button>
                                    <button type="button" wire:click="$set('paymentMethod', 'transferencia')" class="flex items-center justify-center px-2 py-2 border rounded-md shadow-sm text-xs font-bold transition-colors {{ $paymentMethod === 'transferencia' ? 'bg-indigo-600 border-transparent text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        🏦 Transf.
                                    </button>
                                    <button type="button" wire:click="$set('paymentMethod', 'cheque')" class="flex items-center justify-center px-2 py-2 border rounded-md shadow-sm text-xs font-bold transition-colors {{ $paymentMethod === 'cheque' ? 'bg-indigo-600 border-transparent text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        🎫 Cheque
                                    </button>
                                    <button type="button" wire:click="$set('paymentMethod', 'multiple')" class="flex items-center justify-center px-2 py-2 border rounded-md shadow-sm text-xs font-bold transition-colors {{ $paymentMethod === 'multiple' ? 'bg-indigo-600 border-transparent text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                        🔀 Múltiple
                                    </button>
                                </div>
                            </div>

                            <!-- Cash Payment Logic -->
                            @if($paymentMethod === 'efectivo')
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    <div class="mb-3">
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Monto Recibido</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">₲</span>
                                            </div>
                                            <input type="number" wire:model.live.debounce.300ms="receivedAmount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-base border-gray-300 rounded-md py-2 text-right font-bold text-gray-900" placeholder="0">
                                        </div>
                                        @error('receivedAmount') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                        <span class="text-gray-600 font-bold text-xs">Vuelto / Cambio:</span>
                                        <span class="text-2xl font-bold {{ $change < 0 ? 'text-red-600' : 'text-green-600' }}">₲ {{ format_pyg($change) }}</span>
                                    </div>
                                </div>
                            @elseif($paymentMethod === 'cheque')
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 space-y-2">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 mb-1">Banco 🏦</label>
                                        <input type="text" wire:model="chequeDetails.bank_name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5" placeholder="Nombre del Banco">
                                        @error('chequeDetails.bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 mb-1">Nro. Cheque 🔢</label>
                                            <input type="text" wire:model="chequeDetails.cheque_number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5" placeholder="00000000">
                                            @error('chequeDetails.cheque_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 mb-1">Fecha Cobro 📅</label>
                                            <input type="date" wire:model="chequeDetails.due_date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5">
                                            @error('chequeDetails.due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="bg-blue-50 p-2 rounded text-center mt-2">
                                        <p class="text-blue-800 text-xs font-bold">Total a Pagar: ₲ {{ format_pyg($total) }}</p>
                                    </div>
                                </div>
                            @elseif($paymentMethod === 'multiple')
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 space-y-2">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 mb-1">Efectivo 💵</label>
                                            <input type="number" wire:model.live.debounce.300ms="multiplePayments.efectivo" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5 text-right" placeholder="0">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 mb-1">Tarjeta 💳</label>
                                            <input type="number" wire:model.live.debounce.300ms="multiplePayments.tarjeta" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5 text-right" placeholder="0">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 mb-1">Transferencia 🏦</label>
                                            <input type="number" wire:model.live.debounce.300ms="multiplePayments.transferencia" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5 text-right" placeholder="0">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 mb-1">QR 📱</label>
                                            <input type="number" wire:model.live.debounce.300ms="multiplePayments.qr" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-xs border-gray-300 rounded-md py-1.5 text-right" placeholder="0">
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                        <span class="text-gray-600 font-bold text-xs">Total Pagado:</span>
                                        <span class="text-sm font-bold text-gray-800">₲ {{ format_pyg(array_sum($multiplePayments)) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 font-bold text-xs">Faltante / Vuelto:</span>
                                        <span class="text-sm font-bold {{ $change < 0 ? 'text-red-600' : 'text-green-600' }}">₲ {{ format_pyg($change) }}</span>
                                    </div>
                                    @error('multiplePayments') <span class="text-red-500 text-xs font-bold block text-center">{{ $message }}</span> @enderror
                                </div>
                            @else
                                <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 text-center">
                                    <p class="text-blue-800 text-xs">Se registrará el pago por el monto exacto.</p>
                                    <p class="text-base font-bold text-blue-900 mt-1">₲ {{ format_pyg($total) }}</p>
                                </div>
                            @endif
                        @else
                            <!-- Credit Info -->
                             <div class="bg-orange-50 p-3 rounded-lg border border-orange-200 text-center mb-4">
                                <p class="text-orange-800 text-xs font-bold">VENTA A CRÉDITO</p>
                                <p class="text-xs text-gray-600 mt-1">La venta se registrará como pendiente de cobro.</p>
                                <p class="text-base font-bold text-orange-900 mt-1">₲ {{ format_pyg($total) }}</p>
                            </div>
                        @endif

                    </div>
                    <div class="bg-gray-50 px-4 py-2 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click="processSale" type="button" 
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 text-sm leading-6 font-bold text-white shadow-sm focus:outline-none focus:shadow-outline-indigo transition ease-in-out duration-150 {{ $paymentCondition === 'contado' ? 'bg-green-600 hover:bg-green-500 focus:border-green-700' : 'bg-orange-600 hover:bg-orange-500 focus:border-orange-700' }}"
                                @if($paymentCondition === 'contado' && (($paymentMethod === 'efectivo' && $change < 0) || ($paymentMethod === 'multiple' && $change < 0))) disabled opacity-50 @endif
                            >
                                {{ $paymentCondition === 'contado' ? 'CONFIRMAR PAGO' : 'CONFIRMAR CRÉDITO' }}
                            </button>
                        </span>
                        <span class="mt-2 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <button wire:click="$set('showPaymentModal', false)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150">
                                Cancelar
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Mobile Cart FAB -->
    <button 
        wire:click="toggleMobileCart" 
        class="md:hidden fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full p-4 shadow-2xl z-40 transition-transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
        <div class="relative">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            @if(count($cart) > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full border border-white min-w-[1.25rem] text-center">{{ count($cart) }}</span>
            @endif
        </div>
    </button>

    <!-- Mobile Cart Overlay -->
    @if($showMobileCart)
        <div class="fixed inset-0 z-50 bg-white flex flex-col md:hidden">
            <!-- Mobile Cart Header -->
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Carrito ({{ count($cart) }})
                </h2>
                <button wire:click="toggleMobileCart" class="text-gray-500 hover:text-red-500 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Mobile Cart Content (Copied logic) -->
            <div class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <!-- Customer Mobile -->
                <div class="mb-4">
                     @if($selectedCustomer)
                        <div class="flex justify-between items-center bg-white border border-green-200 rounded-lg p-2 shadow-sm">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-1.5 rounded-full text-green-600 mr-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="leading-tight">
                                    <div class="font-bold text-gray-800 text-sm truncate max-w-[200px]">{{ $selectedCustomer['name'] }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $selectedCustomer['ruc'] }}</div>
                                </div>
                            </div>
                            <button wire:click="removeCustomer" class="text-gray-400 hover:text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @else
                        <div class="relative">
                            <input wire:model.live.debounce.300ms="customerSearch" type="text" 
                                class="w-full pl-3 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                placeholder="Buscar Cliente...">
                        </div>
                        @if(!empty($customerSearch) && !$selectedCustomer)
                            <div class="mt-2 bg-white border border-gray-200 rounded-md shadow-lg max-h-40 overflow-y-auto">
                                @forelse($searchResults as $result)
                                    <button wire:click="selectCustomer('{{ $result['id'] }}')" class="w-full text-left px-4 py-3 text-sm hover:bg-gray-50 flex justify-between items-center border-b border-gray-50">
                                        <span class="font-medium text-gray-700">{{ $result['name'] }}</span>
                                    </button>
                                @empty
                                    <div class="px-4 py-2 text-sm text-gray-500">No encontrado</div>
                                @endforelse
                            </div>
                        @endif
                    @endif
                </div>

                @if(count($cart) > 0)
                    <div class="space-y-3">
                        @foreach($cart as $item)
                            <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $item['name'] }}</h4>
                                        <div class="text-indigo-600 font-bold mt-1 text-sm">₲ {{ format_pyg($item['price']) }}</div>
                                    </div>
                                    <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                        <button wire:click="updateQuantity('{{ $item['id'] }}', -1)" class="w-8 h-8 flex items-center justify-center text-gray-600 bg-white rounded shadow-sm font-bold">-</button>
                                        <span class="w-8 text-center text-sm font-bold">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $item['id'] }}', 1)" class="w-8 h-8 flex items-center justify-center text-green-600 bg-white rounded shadow-sm font-bold">+</button>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-50 flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Total Item:</span>
                                    <span class="font-bold text-gray-900">₲ {{ format_pyg($item['price'] * $item['quantity']) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                        <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p>Carrito vacío</p>
                    </div>
                @endif
            </div>

            <!-- Mobile Cart Footer -->
            <div class="bg-white border-t border-gray-200 p-4 shadow-up z-20">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-bold text-gray-800">Total a Pagar</span>
                    <span class="text-2xl font-extrabold text-indigo-700">₲ {{ format_pyg($total) }}</span>
                </div>
                
                @if(count($cart) > 0)
                    <button 
                        wire:click="openPaymentModal"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg text-lg flex justify-center items-center"
                    >
                        COBRAR (₲ {{ format_pyg($total) }})
                    </button>
                    <button wire:click="clearCart" wire:confirm="¿Vaciar todo?" class="w-full mt-2 text-red-500 text-sm font-medium py-2">
                        Vaciar Carrito
                    </button>
                @endif
            </div>
        </div>
    @endif

<script>
    document.addEventListener('keydown', function(event) {
        if(event.key === 'F2') { event.preventDefault(); document.getElementById('product-search-input')?.focus(); }
        if(event.key === 'F8') { event.preventDefault(); setTimeout(() => document.getElementById('customer-search-input')?.focus(), 50); }
        if(event.key === 'F4') { event.preventDefault(); document.getElementById('btn-pay')?.click(); }
        if(event.key === 'Escape') { 
            let active = document.activeElement;
            if(active.id === 'product-search-input') { 
                @this.set('search', ''); 
                active.blur(); 
            }
            else if(active.id === 'customer-search-input') { 
                @this.set('customerSearch', ''); 
                active.blur(); 
            }
            else { 
                active.blur(); 
            }
        }
    });

    document.addEventListener('print-ticket', function(event) {
        // Livewire 3: event.detail is the array/object passed in dispatch
        // dispatch('print-ticket', ['saleId' => 123]) -> detail: { saleId: 123 }
        let saleId = event.detail.saleId; 
        if(!saleId && event.detail[0]) saleId = event.detail[0].saleId; // Fallback

        if(saleId) {
            let url = "{{ route('sales.ticket', ':id') }}".replace(':id', saleId);
            window.open(url, 'Ticket', 'width=400,height=600,scrollbars=yes');
        } else {
            console.error('No Sale ID provided for printing');
        }
    });
</script>

@if(session()->has('last_sale_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let saleId = "{{ session('last_sale_id') }}";
            let url = "{{ route('sales.ticket', ':id') }}".replace(':id', saleId);
            // Open in a popup window (width 400px is enough for thermal receipt)
            window.open(url, 'Ticket', 'width=400,height=600,scrollbars=yes');
        });
    </script>
@endif

<!-- ============ VOID SALE MODAL ============ -->
@if($showVoidModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4" x-data>       
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800">🚫 Anular Venta</h3>
            <button wire:click="$set('showVoidModal', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="px-6 py-4">
            <input wire:model.live.debounce.400ms="voidSearch" type="text"
                placeholder="Buscar por cliente o ID..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-4 focus:ring-orange-300 focus:border-orange-400">

            <div class="space-y-2 max-h-64 overflow-y-auto">
                @forelse($recentSales as $sale)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg px-4 py-2.5 border border-gray-200">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $sale['customer']['name'] ?? 'Sin cliente' }}
                                <span class="text-xs text-gray-400 ml-2">{{ substr($sale['id'], -8) }}</span>
                            </p>
                            <p class="text-xs text-gray-500">
                                ₲ {{ number_format($sale['total'] ?? 0, 0, ',', '.') }}
                                · {{ isset($sale['created_at']) ? \Carbon\Carbon::parse($sale['created_at'])->format('H:i') : '' }}
                            </p>
                        </div>
                        <button wire:click="voidSale('{{ $sale['id'] }}')"
                            onclick="return confirm('¿Anular esta venta?')"
                            class="ml-4 px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-lg hover:bg-red-200 transition">
                            Anular
                        </button>
                    </div>
                @empty
                    <p class="text-center text-sm text-gray-400 py-4">No hay ventas que mostrar.</p>
                @endforelse
            </div>
        </div>

        <div class="px-6 py-3 bg-gray-50 rounded-b-xl border-t">
            <p class="text-xs text-gray-400">Se muestran las ventas del día de hoy. El stock se restaura automáticamente.</p>
        </div>
    </div>
</div>
@endif

    <!-- Web Orders List Modal -->
    @if($showWebOrdersModal)
        <div class="fixed z-[100] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
                    <div class="bg-gray-50/50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-600 p-2 rounded-xl text-white shadow-lg shadow-indigo-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Pedidos Web Pendientes</h3>
                        </div>
                        <button wire:click="$set('showWebOrdersModal', false)" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6">
                        @if(empty($pendingWebOrders))
                            <div class="flex flex-col items-center justify-center py-12 text-gray-400 italic">
                                <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-lg font-bold tracking-tight uppercase">No hay pedidos web pendientes</p>
                            </div>
                        @else
                            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            <th class="px-4 py-3">Fecha</th>
                                            <th class="px-4 py-3">Cliente</th>
                                            <th class="px-4 py-3">Productos</th>
                                            <th class="px-4 py-3 text-right">Total</th>
                                            <th class="px-4 py-3 text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($pendingWebOrders as $order)
                                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                                <td class="px-4 py-4">
                                                    <div class="text-[10px] font-bold text-gray-900 uppercase">{{ \Carbon\Carbon::parse($order['created_at'])->diffForHumans() }}</div>
                                                    <div class="text-[9px] text-gray-400 tabular-nums">{{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i') }}</div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="text-xs font-black text-gray-900 uppercase truncate max-w-[150px]">{{ $order['customer_name'] }}</div>
                                                    <div class="text-[10px] font-bold text-indigo-600 tabular-nums">{{ $order['customer_phone'] }}</div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="text-[10px] text-gray-600 line-clamp-2">
                                                        @if(!empty($order['items_json']))
                                                            @foreach($order['items_json'] as $item)
                                                                <span class="font-bold text-indigo-500">{{ $item['quantity'] }}x</span> {{ $item['name'] }}{{ !$loop->last ? ',' : '' }}
                                                            @endforeach
                                                        @else
                                                            {{ $order['product']['name'] ?? 'Producto' }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-right">
                                                    <div class="text-sm font-black text-gray-900 tabular-nums">₲ {{ number_format($order['total'], 0, ',', '.') }}</div>
                                                    <div class="text-[9px] font-bold uppercase {{ $order['payment_method'] === 'transferencia' ? 'text-indigo-500' : 'text-emerald-500' }}">
                                                        {{ $order['payment_method'] }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <button wire:click="importWebOrder('{{ $order['id'] }}')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-indigo-100 active:scale-95">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                        Importar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end">
                        <button wire:click="$set('showWebOrdersModal', false)" class="px-6 py-2 bg-white text-gray-500 font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 transition border border-gray-200">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Variation Selection Modal -->
    @if($showVariationModal && $selectingProduct)
        <div class="fixed z-[100] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('showVariationModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter" id="modal-title">
                                    Seleccionar Variante
                                </h3>
                                <p class="text-sm text-gray-500 font-bold">{{ $selectingProduct->name }}</p>
                            </div>
                            <button wire:click="$set('showVariationModal', false)" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-3 max-h-[60vh] overflow-y-auto pr-2">
                            @foreach($selectingProduct->variations as $var)
                                @php
                                    $varOutOfStock = $selectingProduct->manage_stock && $var->stock <= 0;
                                @endphp
                                <button 
                                    wire:click="selectVariation('{{ $var->id }}')"
                                    @if($varOutOfStock) disabled @endif
                                    class="flex justify-between items-center p-4 rounded-xl border-2 transition-all group {{ $varOutOfStock ? 'bg-gray-50 border-gray-100 opacity-60 cursor-not-allowed' : 'border-gray-100 hover:border-indigo-500 hover:bg-indigo-50' }}"
                                >
                                    <div class="text-left">
                                        <div class="font-black text-gray-900 uppercase tracking-tight group-hover:text-indigo-700">{{ $var->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">{{ $var->sku }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-black text-indigo-600">₲ {{ format_pyg($var->price_sale) }}</div>
                                        <div class="text-[10px] {{ $var->stock <= 0 ? 'text-red-500' : 'text-gray-500' }}">
                                            Stock: {{ $var->stock }}
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-end">
                        <button wire:click="$set('showVariationModal', false)" type="button" class="px-6 py-2 bg-white text-gray-500 font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 transition border border-gray-200">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
