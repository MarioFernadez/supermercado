<div class="py-12 bg-gray-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-4xl font-black text-gray-900 uppercase tracking-tighter">Utilidad Real</h2>
                <p class="text-gray-500 font-medium">Análisis de rentabilidad neta del negocio</p>
            </div>
            
            <div class="bg-white p-2 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-2">
                <input wire:model.live="dateFrom" type="date" class="border-none focus:ring-0 text-sm font-bold text-gray-600 bg-transparent">
                <span class="text-gray-300 font-black">/</span>
                <input wire:model.live="dateTo" type="date" class="border-none focus:ring-0 text-sm font-bold text-gray-600 bg-transparent">
            </div>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            
            <!-- Revenue Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/30 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-2">Ingresos Totales</p>
                    <h3 class="text-3xl font-black text-gray-900 tabular-nums">₲ {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-lg">{{ $salesCount }} Ventas</span>
                        <span class="text-[10px] text-gray-400 font-bold tracking-tight">Ticket Prom: ₲ {{ number_format($avgTicket, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/30 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-red-400 uppercase tracking-[0.2em] mb-2">Egresos Operativos</p>
                    <h3 class="text-3xl font-black text-gray-900 tabular-nums">₲ {{ number_format($totalExpenses, 0, ',', '.') }}</h3>
                    <p class="mt-4 text-[10px] text-gray-400 font-bold italic">* Incluye todos los gastos registrados en el periodo</p>
                </div>
            </div>

            <!-- Net Profit Card (The Star) -->
            <div class="bg-gray-900 rounded-[2.5rem] p-8 border border-gray-800 shadow-2xl shadow-indigo-200/50 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-2">Utilidad Neta Real</p>
                    <h3 class="text-4xl font-black text-white tabular-nums">₲ {{ number_format($netProfit, 0, ',', '.') }}</h3>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="px-3 py-1 bg-indigo-500 text-white text-xs font-black rounded-full shadow-lg shadow-indigo-500/50">
                            Margen: {{ number_format($profitMargin, 1) }}%
                        </div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Dinero Limpio</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-xl shadow-gray-200/30">
            <h4 class="text-xl font-black text-gray-900 uppercase tracking-tighter mb-8">Desglose de la Operación</h4>
            
            <div class="space-y-10">
                <!-- Revenue Line -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest">Ventas Brutas</span>
                        <span class="text-lg font-black text-gray-900">₲ {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-400 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Cost of Goods Line -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-black text-gray-400 uppercase tracking-widest text-orange-400">Costo de Mercadería (Reposición)</span>
                            <x-tooltip text="Lo que te costó a ti comprar los productos que vendiste" />
                        </div>
                        <span class="text-lg font-black text-gray-900">₲ {{ number_format($totalCost, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                        @php $costPercent = $totalRevenue > 0 ? ($totalCost / $totalRevenue) * 100 : 0; @endphp
                        <div class="h-full bg-orange-400 rounded-full" style="width: {{ $costPercent }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-tight">Representa el {{ number_format($costPercent, 1) }}% de tus ventas totales</p>
                </div>

                <!-- Operating Expenses Line -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-sm font-black text-gray-400 uppercase tracking-widest text-red-400">Gastos Operativos (Fijos/Variables)</span>
                        <span class="text-lg font-black text-gray-900">₲ {{ number_format($totalExpenses, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                        @php $expensePercent = $totalRevenue > 0 ? ($totalExpenses / $totalRevenue) * 100 : 0; @endphp
                        <div class="h-full bg-red-400 rounded-full" style="width: {{ $expensePercent }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-tight">Representa el {{ number_format($expensePercent, 1) }}% de tus ventas totales</p>
                </div>

                <!-- Summary Table -->
                <div class="mt-12 pt-10 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-4">
                        <div class="flex justify-between py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-bold text-gray-500 uppercase">Utilidad Bruta (Ventas - Costos)</span>
                            <span class="text-sm font-black text-gray-900">₲ {{ number_format($grossProfit, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-bold text-gray-500 uppercase">Total Gastos Operativos</span>
                            <span class="text-sm font-black text-red-500">- ₲ {{ number_format($totalExpenses, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-4 bg-gray-50 px-4 rounded-2xl">
                            <span class="text-sm font-black text-gray-900 uppercase">Utilidad Final</span>
                            <span class="text-xl font-black text-indigo-600">₲ {{ number_format($netProfit, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-[2rem] p-8 border border-indigo-100">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-white rounded-2xl text-indigo-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="space-y-2">
                                <p class="text-xs font-black text-indigo-900 uppercase tracking-widest">Análisis de Rentabilidad</p>
                                <p class="text-xs text-indigo-700 leading-relaxed">
                                    Por cada **₲ 1.000** que vendes, te quedan libres **₲ {{ number_format(($netProfit / ($totalRevenue ?: 1)) * 1000, 0) }}**. 
                                    @if($profitMargin > 30)
                                        <span class="font-bold">¡Tu margen es excelente!</span> Tienes un negocio muy saludable.
                                    @elseif($profitMargin > 15)
                                        <span class="font-bold">Tu margen es saludable.</span> Estás en el promedio del mercado retail.
                                    @else
                                        <span class="font-bold text-red-600">Tu margen es ajustado.</span> Considera revisar tus costos o aumentar el volumen de ventas.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
