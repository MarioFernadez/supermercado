<div class="py-12 bg-gray-50/50 min-h-screen dark:bg-gray-900/50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-4xl font-black text-gray-900 uppercase tracking-tighter dark:text-white">Utilidad Real</h2>
                <p class="text-gray-500 font-medium dark:text-gray-400">Análisis de rentabilidad neta del negocio</p>
            </div>
            
            <div class="bg-white p-2 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-2 dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                <input wire:model.live="dateFrom" type="date" class="border-none focus:ring-0 text-sm font-bold text-gray-600 bg-transparent dark:text-gray-200 dark:bg-transparent dark:[color-scheme:dark]">
                <span class="text-gray-300 font-black dark:text-gray-600">/</span>
                <input wire:model.live="dateTo" type="date" class="border-none focus:ring-0 text-sm font-bold text-gray-600 bg-transparent dark:text-gray-200 dark:bg-transparent dark:[color-scheme:dark]">
            </div>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            
            <!-- Revenue Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/30 relative overflow-hidden group dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50 dark:bg-emerald-900/30"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-2">Ingresos Totales</p>
                    <h3 class="text-3xl font-black text-gray-900 tabular-nums dark:text-white">₲ {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg dark:text-emerald-400">{{ $salesCount }} Ventas</span>
                        <span class="text-[10px] text-gray-400 font-bold tracking-tight dark:text-gray-400">Ticket Prom: ₲ {{ number_format($avgTicket, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/30 relative overflow-hidden group dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50 dark:bg-red-900/30"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-red-400 uppercase tracking-[0.2em] mb-2">Egresos Operativos</p>
                    <h3 class="text-3xl font-black text-gray-900 tabular-nums dark:text-white">₲ {{ number_format($totalExpenses, 0, ',', '.') }}</h3>
                    <p class="mt-4 text-[10px] text-gray-400 font-bold italic dark:text-gray-400">* Incluye todos los gastos registrados en el periodo</p>
                </div>
            </div>

            <!-- Net Profit Card (The Star) -->
            <div class="bg-gray-900 rounded-[2.5rem] p-8 border border-gray-800 shadow-2xl shadow-indigo-200/50 relative overflow-hidden group dark:shadow-none">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-2">Utilidad Neta Real</p>
                    <h3 class="text-4xl font-black text-white tabular-nums">₲ {{ number_format($netProfit, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="px-3 py-1 bg-indigo-500 text-white text-xs font-black rounded-full shadow-lg shadow-indigo-500/50">
                            Margen: {{ number_format($profitMargin, 1) }}%
                        </div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest dark:text-gray-400">Dinero Limpio</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-xl shadow-gray-200/30 dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
            <h4 class="text-xl font-black text-gray-900 uppercase tracking-tighter mb-8 dark:text-white">Desglose de la Operación</h4>
            
            <div class="space-y-10">
                <!-- Revenue Line -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest dark:text-gray-400">Ventas Brutas</span>
                        <span class="text-lg font-black text-gray-900 dark:text-white">₲ {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700">
                        <div class="h-full bg-emerald-400 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Cost of Goods Line -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-black text-gray-400 uppercase tracking-widest text-orange-400 dark:text-gray-400">Costo de Mercadería (Reposición)</span>
                            <x-tooltip text="Lo que te costó a ti comprar los productos que vendiste" />
                        </div>
                        <span class="text-lg font-black text-gray-900 dark:text-white">₲ {{ number_format($totalCost, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700">
                        @php $costPercent = $totalRevenue > 0 ? ($totalCost / $totalRevenue) * 100 : 0; @endphp
                        <div class="h-full bg-orange-400 rounded-full" style="width: {{ $costPercent }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-tight dark:text-gray-400">Representa el {{ number_format($costPercent, 1) }}% de tus ventas totales</p>
                </div>

                <!-- Operating Expenses Line -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest text-red-400 dark:text-gray-400">Gastos Operativos (Fijos/Variables)</span>
                        <span class="text-lg font-black text-gray-900 dark:text-white">₲ {{ number_format($totalExpenses, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700">
                        @php $expensePercent = $totalRevenue > 0 ? ($totalExpenses / $totalRevenue) * 100 : 0; @endphp
                        <div class="h-full bg-red-400 rounded-full" style="width: {{ $expensePercent }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-tight dark:text-gray-400">Representa el {{ number_format($expensePercent, 1) }}% de tus ventas totales</p>
                </div>

                <!-- Summary Table -->
                <div class="mt-12 pt-10 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-4">
                        <div class="flex justify-between py-2 border-b border-dashed border-gray-100 dark:border-gray-700">
                            <span class="text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Utilidad Bruta (Ventas - Costos)</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white">₲ {{ number_format($grossProfit, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-gray-100 dark:border-gray-700">
                            <span class="text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Total Gastos Operativos</span>
                            <span class="text-sm font-black text-red-500">- ₲ {{ number_format($totalExpenses, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-4 bg-gray-50 px-4 rounded-2xl dark:bg-gray-900">
                            <span class="text-sm font-black text-gray-900 uppercase dark:text-white">Utilidad Final</span>
                            <span class="text-xl font-black text-indigo-600 dark:text-indigo-400">₲ {{ number_format($netProfit, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-[2rem] p-8 border border-indigo-100 dark:bg-indigo-900/30 dark:border-indigo-800/50">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-white rounded-2xl text-indigo-500 shadow-sm dark:bg-gray-800 dark:shadow-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="space-y-2">
                                <p class="text-xs font-black text-indigo-900 uppercase tracking-widest dark:text-indigo-300">Análisis de Rentabilidad</p>
                                <p class="text-xs text-indigo-700 leading-relaxed dark:text-indigo-300">
                                    Por cada <strong class="dark:text-indigo-100">₲ 1.000</strong> que vendes, te quedan libres <strong class="dark:text-indigo-100">₲ {{ number_format(($netProfit / ($totalRevenue ?: 1)) * 1000, 0) }}</strong>. 
                                    @if($profitMargin > 30)
                                        <span class="font-bold">¡Tu margen es excelente!</span> Tienes un negocio muy saludable.
                                    @elseif($profitMargin > 15)
                                        <span class="font-bold">Tu margen es saludable.</span> Estás en el promedio del mercado retail.
                                    @else
                                        <span class="font-bold text-red-600 dark:text-red-400">Tu margen es ajustado.</span> Considera revisar tus costos o aumentar el volumen de ventas.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit Evolution Chart -->
        <div class="mt-10 bg-white rounded-[3rem] p-10 border border-gray-100 shadow-xl shadow-gray-200/30 dark:bg-gray-800 dark:border-gray-700 dark:shadow-none" wire:ignore>
            <h4 class="text-xl font-black text-gray-900 uppercase tracking-tighter mb-8 dark:text-white">Evolución de Rentabilidad Diaria</h4>
            <div x-data="profitChart(@js($evolutionData))" class="w-full">
                <div x-ref="chart"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('profitChart', (initialData) => ({
        chartData: initialData,
        chartInstance: null,
        
        init() {
            this.renderChart();
            
            Livewire.on('update-profit-chart', (payload) => {
                this.chartData = payload[0].data;
                this.chartInstance.updateSeries([
                    { data: this.chartData.map(i => i.revenue) },
                    { data: this.chartData.map(i => i.profit) }
                ]);
                this.chartInstance.updateOptions({ xaxis: { categories: this.chartData.map(i => i.date) } });
            });
        },
        
        renderChart() {
            let options = {
                series: [
                    { name: 'Ingresos Brutos', data: this.chartData.map(i => i.revenue) },
                    { name: 'Ganancia Neta', data: this.chartData.map(i => i.profit) }
                ],
                chart: { type: 'area', height: 400, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                colors: ['#34d399', '#4f46e5'], // Emerald 400, Indigo 500
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: { categories: this.chartData.map(i => i.date) },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "₲ " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            };
            this.chartInstance = new ApexCharts(this.$refs.chart, options);
            this.chartInstance.render();
        }
    }));
});
</script>
@endpush
