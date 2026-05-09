<div class="py-10 bg-gray-50/50 min-h-screen">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tighter uppercase">Panel de Control</h1>
                <p class="text-gray-500 text-sm font-medium mt-1">Resumen operativo para {{ auth()->user()->name }} • {{ now()->isoFormat('LL') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('pos.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-widest rounded-2xl transition-all shadow-xl shadow-indigo-100 hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Nueva Venta (Caja)
                </a>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <!-- Sales Today -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Ventas Hoy</p>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none tabular-nums">₲ {{ number_format($totalSalesToday, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg w-fit">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Actualizado
                    </div>
                </div>
            </div>

            <!-- Profit -->
            @can('gerente')
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Ganancia (Est.)</p>
                    <h3 class="text-2xl font-bold text-emerald-600 leading-none tabular-nums">₲ {{ number_format($estimatedProfit, 0, ',', '.') }}</h3>
                    <div class="mt-4 text-[10px] font-bold text-gray-400">Basado en costo de compra</div>
                </div>
            </div>
            @endcan

            <!-- Pending Web Orders -->
            <a href="{{ route('admin.web-orders.index') }}" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:border-orange-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1">Pedidos Web</p>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ $pendingWebOrdersCount }}</h3>
                    <div class="mt-4 flex items-center text-[10px] font-bold {{ $pendingWebOrdersCount > 0 ? 'text-orange-600 bg-orange-50 animate-pulse' : 'text-gray-400 bg-gray-50' }} px-2 py-1 rounded-lg w-fit uppercase">
                        {{ $pendingWebOrdersCount > 0 ? 'Pendientes de atención' : 'Sin pendientes' }}
                    </div>
                </div>
            </a>

            <!-- Customers -->
            <a href="{{ route('customers.index') }}" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:border-blue-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Total Clientes</p>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ $totalCustomers }}</h3>
                    <div class="mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-tighter italic">Creciendo contigo</div>
                </div>
            </a>

            <!-- Open Sessions -->
            <a href="{{ route('cash.index') }}" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:border-purple-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-purple-400 uppercase tracking-widest mb-1">Cajas Abiertas</p>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ $openSessionsCount }}</h3>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-lg w-fit">
                        En operación
                    </div>
                </div>
            </a>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Tendencia de Ventas (7 Días)</h3>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">En Guaraníes</span>
                </div>
                <div class="h-[300px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Top Productos</h3>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">30 Días</span>
                </div>
                <div class="h-[300px]">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Lists Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Sales -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Últimas Ventas</h3>
                    <a href="{{ route('reports.sales') }}" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-tighter">Ver todas</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4">Hora</th>
                                <th class="px-6 py-4">Cliente</th>
                                <th class="px-6 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentSales as $sale)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold text-gray-400">{{ $sale->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $sale->customer ? $sale->customer->name : 'Consumidor Final' }}</p>
                                    <p class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">{{ $sale->user->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-black text-gray-900 tabular-nums">₲ {{ number_format($sale->total, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs">Sin actividad reciente</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-black text-red-600 uppercase tracking-widest flex items-center">
                        <span class="relative flex h-2 w-2 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        Alertas de Stock
                    </h3>
                    <a href="{{ route('products.index') }}" class="text-[10px] font-black text-gray-400 hover:text-red-600 uppercase tracking-tighter">Gestionar</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-red-50/30 text-[10px] font-black text-red-400 uppercase tracking-widest">
                                <th class="px-6 py-4">Producto</th>
                                <th class="px-6 py-4 text-center">Actual</th>
                                <th class="px-6 py-4 text-center">Mínimo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($lowStockProducts as $product)
                            <tr class="hover:bg-red-50/20 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-0.5 rounded-lg bg-red-100 text-red-700 font-black text-xs">{{ $product->stock }}</span>
                                </td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-gray-400">{{ $product->min_stock }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-emerald-500 font-black uppercase text-xs">Stock optimizado</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => initDashboardCharts());
        window.addEventListener('load', () => initDashboardCharts());

        function initDashboardCharts() {
            // Line Chart: Sales Trend
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                if (window.salesChartInstance) window.salesChartInstance.destroy();
                window.salesChartInstance = new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: @json($salesLabels),
                        datasets: [{
                            data: @json($salesData),
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.05)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { grid: { color: '#f9fafb' }, ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af' } },
                            x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af' } }
                        }
                    }
                });
            }

            // Bar Chart: Top Products
            const topCtx = document.getElementById('topProductsChart');
            if (topCtx) {
                if (window.topChartInstance) window.topChartInstance.destroy();
                window.topChartInstance = new Chart(topCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($topProducts->pluck('product_name')),
                        datasets: [{
                            data: @json($topProducts->pluck('total_qty')),
                            backgroundColor: '#6366f1',
                            borderRadius: 8
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af' } },
                            y: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af' } }
                        }
                    }
                });
            }
        }
    </script>
    @endpush
</div>
