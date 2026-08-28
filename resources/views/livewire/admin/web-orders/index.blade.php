<div>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight uppercase tracking-tighter">
            {{ __('Gestión de Pedidos Web') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 dark:border-gray-700">
                <!-- Filters & Search -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="relative w-full md:w-1/3">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live="search" type="text" placeholder="Buscar por cliente o teléfono..." class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition text-sm dark:text-gray-300">
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <select wire:model.live="statusFilter" class="bg-gray-50 dark:bg-gray-900 border-none rounded-2xl py-2 px-4 text-sm focus:ring-2 focus:ring-indigo-500 transition font-bold uppercase tracking-tight dark:text-gray-300">
                            <option value="">Todos los estados</option>
                            <option value="Pendiente WhatsApp">Pendiente WhatsApp</option>
                            <option value="Atendido">Atendido</option>
                            <option value="Completado">Completado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="p-4 bg-green-50 text-green-700 text-sm font-bold uppercase tracking-widest text-center animate-pulse dark:bg-green-900/30 dark:text-green-400">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse font-sans">
                        <thead class="bg-gray-50/80 uppercase text-[11px] tracking-wider font-semibold text-gray-500 dark:bg-gray-900/60 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">Fecha</th>
                                <th class="px-6 py-4">Cliente</th>
                                <th class="px-6 py-4">Detalle</th>
                                <th class="px-6 py-4 text-right">Total</th>
                                <th class="px-6 py-4 text-center">Estado</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-mono text-gray-700 dark:text-gray-300 tabular-nums">{{ $order->created_at->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono tabular-nums dark:text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</div>
                                        <div class="text-xs text-indigo-600 font-medium tabular-nums dark:text-indigo-400">{{ $order->customer_phone }}</div>
                                        <div class="text-xs text-gray-400 truncate max-w-[200px] dark:text-gray-500">{{ $order->customer_address }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($order->items_json)
                                            <div class="space-y-1">
                                                @foreach($order->items_json as $item)
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                                        <span class="font-semibold text-indigo-500">{{ $item['quantity'] }}x</span> {{ $item['name'] }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $order->product->name ?? 'Producto no encontrado' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 tabular-nums"><span class="text-xs text-gray-400 font-normal mr-0.5">₲</span>{{ number_format($order->total, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-block relative">
                                            <select 
                                                wire:change="updateStatus('{{ $order->id }}', $event.target.value)"
                                                class="text-[10px] font-bold uppercase rounded-full px-3 py-1 border-none focus:ring-2 focus:ring-indigo-500 cursor-pointer @if($order->status == 'Pendiente WhatsApp') bg-yellow-100 text-yellow-700 @elseif($order->status == 'Atendido') bg-blue-100 text-blue-700 @elseif($order->status == 'Completado') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif dark:text-yellow-400 dark:bg-green-900/40">
                                                <option value="Pendiente WhatsApp" {{ $order->status == 'Pendiente WhatsApp' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="Atendido" {{ $order->status == 'Atendido' ? 'selected' : '' }}>Atendido</option>
                                                <option value="Completado" {{ $order->status == 'Completado' ? 'selected' : '' }}>Completado</option>
                                                <option value="Cancelado" {{ $order->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <button wire:click="viewOrder('{{ $order->id }}')" class="inline-flex p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm dark:bg-indigo-900/30 dark:text-indigo-400 dark:shadow-none" title="Ver Detalle">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>

                                        <!-- WhatsApp Action (Dynamic) -->
                                        @php
                                            $waBase = "https://wa.me/" . preg_replace('/[^0-9]/', '', $order->customer_phone);
                                            
                                            // Processed Notification
                                            $msgProcessed = "Hola *{$order->customer_name}*, tu pedido #{$order->id} ya fue procesado y está listo. Gracias por elegir ZonaShop.";
                                            $waUrlProcessed = $waBase . "?text=" . urlencode($msgProcessed);
                                            
                                            // Completed Notification
                                            $msgCompleted = "Hola *{$order->customer_name}*, tu pedido #{$order->id} ya fue entregado con éxito. ¡Esperamos que lo disfrutes!";
                                            $waUrlCompleted = $waBase . "?text=" . urlencode($msgCompleted);
                                        @endphp
                                        
                                        <div class="inline-flex gap-1">
                                            @if($order->status == 'Atendido')
                                                <a href="{{ $waUrlProcessed }}" target="_blank" class="inline-flex p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm dark:bg-indigo-900/30 dark:text-indigo-400 dark:shadow-none" title="Avisar que está listo">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </a>
                                            @elseif($order->status == 'Completado')
                                                <a href="{{ $waUrlCompleted }}" target="_blank" class="inline-flex p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm dark:bg-emerald-900/30 dark:shadow-none" title="Avisar entrega exitosa">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </a>
                                            @endif
                                            
                                            <a href="{{ $waBase }}?text={{ urlencode('Hola ' . $order->customer_name . ', te contacto por tu pedido...') }}" target="_blank" class="inline-flex p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all shadow-sm dark:bg-green-900/30 dark:shadow-none" title="Chat Libre">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412s-1.239 6.164-3.485 8.412c-2.245 2.247-5.231 3.487-8.412 3.487-2.045 0-4.039-.526-5.803-1.522l-6.101 1.605c-.097.026-.194.039-.291.039-.42 0-.792-.262-.914-.663zm3.765-18.423c-.347-.771-.711-.787-1.04-.801-.269-.012-.577-.012-.885-.012s-.808.115-1.231.577c-.423.462-1.616 1.578-1.616 3.849 0 2.27 1.654 4.464 1.885 4.772.231.308 3.256 4.972 7.888 6.971 3.854 1.664 4.639 1.333 5.486 1.256.847-.077 2.733-.513 3.118-.975.385-.462.385-1.385.269-1.578-.115-.192-.423-.308-.885-.539s-2.733-1.347-3.156-1.5c-.424-.154-.731-.231-1.04.231s-1.193 1.5-1.463 1.809c-.269.308-.539.346-1.001.115s-1.95-.719-3.712-2.289c-1.371-1.222-2.296-2.731-2.566-3.193s-.029-.714.202-.943c.208-.207.462-.539.693-.808.231-.269.308-.462.462-.77.154-.308.077-.577-.038-.808z"/></svg>
                                            </a>
                                        </div>

                                        <button wire:click="deleteOrder('{{ $order->id }}')" wire:confirm="¿Estás seguro de eliminar este registro?" class="inline-flex p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm dark:bg-red-900/30 dark:shadow-none" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic dark:text-gray-500">No se encontraron pedidos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    @if($showDetailsModal && $selectedOrder)
    <div class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-2xl w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/50">
                <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 uppercase tracking-tighter">Detalle del Pedido</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500 transition dark:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-8">
                <!-- Customer Section -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 dark:text-gray-500">Cliente</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase">{{ $selectedOrder->customer_name }}</p>
                        <p class="text-xs text-indigo-600 font-bold tabular-nums dark:text-indigo-400">{{ $selectedOrder->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 dark:text-gray-500">Método de Pago</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100 uppercase">
                            @if($selectedOrder->payment_method == 'transferencia')
                                <span class="text-indigo-600 dark:text-indigo-400">💳 Transferencia</span>
                            @else
                                <span class="text-emerald-600">💵 Efectivo</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 dark:text-gray-500">Dirección de Entrega</p>
                        <p class="text-xs text-gray-700 dark:text-gray-300 uppercase font-bold">{{ $selectedOrder->customer_address }}</p>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-4">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 dark:text-gray-500">Productos en el Pedido</p>
                    <div class="space-y-3">
                        @if($selectedOrder->items_json)
                            @foreach($selectedOrder->items_json as $item)
                                <div class="flex justify-between items-center text-sm font-bold">
                                    <span class="text-gray-700 dark:text-gray-300">
                                        <span class="text-indigo-500 mr-2">{{ $item['quantity'] }}x</span>
                                        {{ $item['name'] }}
                                    </span>
                                    <span class="text-gray-900 dark:text-gray-100 tabular-nums">₲ {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-gray-700 dark:text-gray-300">
                                    <span class="text-indigo-500 mr-2">1x</span>
                                    {{ $selectedOrder->product->name ?? 'Producto' }}
                                </span>
                                <span class="text-gray-900 dark:text-gray-100 tabular-nums">₲ {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-end">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">Total del Pedido</span>
                        <span class="text-2xl font-black text-indigo-600 tabular-nums dark:text-indigo-400">₲ {{ number_format($selectedOrder->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Notes / Additional Info if any -->
                @if($selectedOrder->notes)
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 dark:text-gray-500">Notas / Observaciones</p>
                    <p class="text-xs text-gray-700 dark:text-gray-300 italic">{{ $selectedOrder->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900/50 flex justify-end gap-3">
                <button wire:click="closeModal" class="px-6 py-2 bg-white dark:bg-gray-800 text-gray-500 font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition border border-gray-200 dark:border-gray-600 dark:text-gray-400">
                    Cerrar
                </button>
                @php
                    $waMsg = "Hola {$selectedOrder->customer_name}, recibimos tu pedido web por Gs. " . number_format($selectedOrder->total, 0, ',', '.') . ". ¿Cómo te podemos ayudar?";
                    $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $selectedOrder->customer_phone) . "?text=" . urlencode($waMsg);
                @endphp
                <a href="{{ $waLink }}" target="_blank" class="flex items-center gap-2 px-6 py-2 bg-green-500 text-white font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-green-600 transition shadow-lg shadow-green-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.24-.581-.487-.503-.669-.512-.174-.01-.373-.012-.572-.012-.199 0-.523.074-.797.371-.273.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    Contactar
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
