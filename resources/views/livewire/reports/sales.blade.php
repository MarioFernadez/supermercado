<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p class="font-bold">Info</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Reporte de Ventas</h2>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <a href="{{ route('reports.sales.print', ['from' => $dateFrom, 'to' => $dateTo]) }}" target="_blank" class="flex-1 md:flex-none bg-gray-900 hover:bg-black text-white font-bold py-2.5 px-6 rounded-xl transition shadow-lg flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        PDF
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 mb-8">
                <div class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-auto">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 shadow-sm">Desde</label>
                        <input wire:model.live="dateFrom" type="date" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm py-2">
                    </div>
                    <div class="w-full md:w-auto">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Hasta</label>
                        <input wire:model.live="dateTo" type="date" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm py-2">
                    </div>
                    
                    <div class="flex gap-2 w-full md:w-auto">
                        <button wire:click="filterToday" class="flex-1 md:flex-none px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition shadow-sm">
                            Hoy
                        </button>
                        <button wire:click="filterWeek" class="flex-1 md:flex-none px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition shadow-sm">
                            Semana
                        </button>
                    </div>

                    <div class="w-full md:w-auto">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 shadow-sm">Canal</label>
                        <select wire:model.live="channel" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm py-2">
                            <option value="all">Todos los Canales</option>
                            <option value="pos">🛒 Venta en Tienda</option>
                            <option value="web">🌐 Venta Web</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Financial Dashboard -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Sales -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ventas Totales</p>
                            <p class="text-xl font-bold text-gray-900">₲ {{ format_pyg($this->profitStats['sales']) }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Cost -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-red-500 group">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-red-50 text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Costo Estimado</p>
                            <p class="text-xl font-bold text-gray-900">₲ {{ format_pyg($this->profitStats['cost']) }}</p>
                        </div>
                    </div>
                    <div class="h-1 w-full bg-red-50 mt-3 rounded-full overflow-hidden">
                        <div class="h-full bg-red-400 rounded-full" style="width: 65%"></div>
                    </div>
                </div>

                <!-- Profit -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-green-500 relative">
                    <div class="absolute right-4 top-4">
                        <div class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-2 py-1 rounded-lg">
                            {{ number_format($this->profitStats['margin'], 1) }}%
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-50 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ganancia Estimada</p>
                            <p class="text-xl font-bold text-green-600">₲ {{ format_pyg($this->profitStats['profit']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payments -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-blue-500">
                    <div class="flex items-center mb-3">
                        <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="ml-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Medios de Pago</p>
                    </div>
                    <div class="space-y-1">
                        @foreach($this->paymentMethods as $payment)
                            <div class="flex justify-between items-center bg-gray-50 px-2 py-1 rounded">
                                <span class="text-[9px] font-bold text-gray-500 uppercase">{{ $payment->method }}</span>
                                <span class="text-[10px] font-black text-gray-900">{{ format_pyg($payment->total) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>    
            <!-- Sales Table -->
            <div class="overflow-x-auto bg-white rounded-3xl border border-gray-100 shadow-sm mt-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 uppercase text-[10px] tracking-widest border-b border-gray-100">
                            <th class="px-6 py-4 font-black">ID / Fecha</th>
                            <th class="px-6 py-4 font-black">Cliente</th>
                            <th class="px-6 py-4 font-black">Vendedor</th>
                            <th class="px-6 py-4 font-black text-center">Canal</th>
                            <th class="px-6 py-4 font-black text-right">Total</th>
                            <th class="px-6 py-4 font-black text-center">Estado</th>
                            <th class="px-6 py-4 font-black text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($sales as $sale)
                            <tr class="group hover:bg-gray-50/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition truncate max-w-[100px]">{{ $sale->id }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium">{{ $sale->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800">{{ $sale->customer->name ?? 'Consumidor Final' }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $sale->customer->ruc ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $sale->seller->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($sale->web_order_id)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-tighter border border-indigo-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"></path></svg>
                                            Web
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-gray-50 text-gray-500 text-[9px] font-black uppercase tracking-tighter border border-gray-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Tienda
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-black text-gray-900">₲ {{ format_pyg($sale->total) }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($sale->status === 'voided')
                                        <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px] font-black uppercase">Anulada</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase">Completada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition">
                                        <button wire:click="viewDetails('{{ $sale->id }}')" class="text-blue-500 hover:text-blue-700 p-2 rounded-xl hover:bg-blue-50 transition" title="Ver Detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        @if($sale->status !== 'voided')
                                            <button wire:click="reprintReceipt('{{ $sale->id }}')" class="text-indigo-500 hover:text-indigo-700 p-2 rounded-xl hover:bg-indigo-50 transition" title="Reimprimir Ticket">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            </button>
                                            @if(auth()->user()->can('admin') || auth()->user()->can('gerente'))
                                                <button wire:click="voidSale('{{ $sale->id }}')" 
                                                        wire:confirm="¿Estás seguro de que deseas anular esta venta? Esta acción no se puede deshacer y restaurará el stock."
                                                        class="text-red-400 hover:text-red-600 p-2 rounded-xl hover:bg-red-50 transition"
                                                        title="Anular Venta">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay ventas registradas en este periodo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Products & Suppliers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 pt-8 border-t border-gray-200">
                
                <!-- Products Table -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Productos Vendidos</h3>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 bg-gray-100 font-medium text-gray-700">Producto</th>
                                    <th class="px-4 py-2 bg-gray-100 font-medium text-gray-700 text-center">Cant.</th>
                                    <th class="px-4 py-2 bg-gray-100 font-medium text-gray-700 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->soldProducts as $item)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-4 py-2 text-gray-900">{{ $item->product_name }}</td>
                                        <td class="px-4 py-2 text-gray-900 text-center">{{ $item->total_qty }}</td>
                                        <td class="px-4 py-2 font-bold text-gray-900 text-right">₲ {{ format_pyg($item->total_amount) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">Sin datos.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Suppliers Table -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ventas por Proveedor</h3>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 bg-gray-100 font-medium text-gray-700">Proveedor</th>
                                    <th class="px-4 py-2 bg-gray-100 font-medium text-gray-700 text-center">Items</th>
                                    <th class="px-4 py-2 bg-gray-100 font-medium text-gray-700 text-right">Total Ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->salesBySupplier as $supplier)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-4 py-2 font-bold text-indigo-700">{{ $supplier->supplier_name }}</td>
                                        <td class="px-4 py-2 text-gray-900 text-center">{{ $supplier->items_count }}</td>
                                        <td class="px-4 py-2 font-bold text-gray-900 text-right">₲ {{ format_pyg($supplier->total_sales) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">Sin datos.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="mt-4">
                {{ $sales->links() }}
            </div>

            <!-- Sale Details Modal -->
            <x-dialog-modal wire:model="showingSaleDetails" maxWidth="4xl">
                <x-slot name="title">
                    <div class="flex items-center justify-between font-sans">
                        <span class="uppercase tracking-tight font-black">Detalles de Venta #{{ $selectedSale?->id }}</span>
                        @if($selectedSale?->status === 'voided')
                            <span class="px-3 py-1 bg-red-100 text-red-600 text-[10px] font-black uppercase rounded-full">Anulada</span>
                        @endif
                    </div>
                </x-slot>

                <x-slot name="content">
                    @if($selectedSale)
                        <div class="font-sans space-y-6">
                            <!-- Header Info -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-6 rounded-3xl border border-gray-100">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Información General</p>
                                    <p class="text-sm font-bold text-gray-900 mt-1">Fecha: {{ $selectedSale->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-xs text-gray-500">Cajero: {{ $selectedSale->user->name }}</p>
                                    <p class="text-xs text-gray-500">Vendedor: {{ $selectedSale->seller->name ?? '—' }}</p>
                                    <div class="mt-2">
                                        @if($selectedSale->web_order_id)
                                            <span class="px-2 py-0.5 bg-indigo-600 text-white text-[9px] font-black uppercase rounded shadow-sm">Pedido Web #{{ $selectedSale->web_order_id }}</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-gray-600 text-white text-[9px] font-black uppercase rounded shadow-sm">Venta en Tienda</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Cliente</p>
                                    <p class="text-sm font-bold text-gray-900 mt-1">{{ $selectedSale->customer->name ?? 'Consumidor Final' }}</p>
                                    <p class="text-xs text-gray-500 font-mono">RUC: {{ $selectedSale->customer->ruc ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Condición / Total</p>
                                    <p class="text-sm font-black text-indigo-600 mt-1 text-right uppercase">{{ $selectedSale->payment_condition }}</p>
                                    <p class="text-2xl font-black text-gray-900 text-right">₲ {{ format_pyg($selectedSale->total) }}</p>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="overflow-hidden border border-gray-100 rounded-2xl shadow-sm">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-50 text-gray-400 uppercase text-[9px] font-black tracking-widest border-b border-gray-100">
                                        <tr>
                                            <th class="px-6 py-3">Producto</th>
                                            <th class="px-6 py-3 text-center">Cant.</th>
                                            <th class="px-6 py-3 text-right">Precio Unit.</th>
                                            <th class="px-6 py-3 text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($selectedSale->items as $item)
                                            <tr>
                                                <td class="px-6 py-3">
                                                    <div class="text-sm font-bold text-gray-900">{{ $item->product_name }}</div>
                                                    <div class="text-[10px] font-mono text-gray-400">{{ $item->product?->sku ?? '—' }}</div>
                                                </td>
                                                <td class="px-6 py-3 text-center text-sm font-bold text-gray-900">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-3 text-right text-xs text-gray-500 font-medium">
                                                    {{ format_pyg($item->price_unit) }}
                                                </td>
                                                <td class="px-6 py-3 text-right text-sm font-black text-gray-900">
                                                    {{ format_pyg($item->subtotal) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Payments -->
                            @if($selectedSale->payments->isNotEmpty())
                                <div>
                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Historial de Pagos</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($selectedSale->payments as $payment)
                                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-white rounded-lg text-emerald-600 shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    </div>
                                                    <span class="text-[10px] font-black text-emerald-700 uppercase">{{ $payment->method }}</span>
                                                </div>
                                                <span class="text-sm font-black text-emerald-900">₲ {{ format_pyg($payment->amount) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="closeDetails" wire:loading.attr="disabled">
                        Cerrar
                    </x-secondary-button>

                    @if($selectedSale && $selectedSale->status !== 'voided')
                        <button wire:click="reprintReceipt('{{ $selectedSale->id }}')" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                             Reimprimir Ticket
                        </button>
                    @endif
                </x-slot>
            </x-dialog-modal>
</div>
<script>
    document.addEventListener('print-ticket', function(event) {
        let saleId = event.detail.saleId; 
        if(!saleId && event.detail[0]) saleId = event.detail[0].saleId;

        if(saleId) {
            let url = "{{ route('sales.ticket', ':id') }}".replace(':id', saleId);
            window.open(url, 'Ticket', 'width=400,height=600,scrollbars=yes');
        }
    });
</script>

