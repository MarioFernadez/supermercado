<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-gray-800">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 font-sans">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight dark:text-white">Rendimiento por Vendedor</h2>
                    <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-2 dark:text-gray-400 font-normal">
                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                        Ranking y estadísticas operativas de vendedores
                    </p>
                </div>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8 p-6 bg-gray-50/50 border border-gray-100 rounded-3xl font-sans dark:border-gray-700 dark:bg-gray-900/50">
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Desde</label>
                    <input wire:model.live="dateFrom" type="date" class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Hasta</label>
                    <input wire:model.live="dateTo" type="date" class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Turno</label>
                    <select wire:model.live="filterShift" class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        <option value="">Todos los turnos</option>
                        <option value="mañana">☀️ Mañana</option>
                        <option value="tarde">🌤 Tarde</option>
                        <option value="noche">🌙 Noche</option>
                    </select>
                </div>
                <div class="flex items-end gap-2 lg:col-span-2">
                    <button wire:click="filterToday" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                        Hoy
                    </button>
                    <button wire:click="filterWeek" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                        Semana
                    </button>
                    <button wire:click="filterMonth" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                        Mes
                    </button>
                </div>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 font-sans">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-5 border-l-4 border-indigo-500 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Total Período</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white tabular-nums"><span class="text-sm font-normal text-gray-400 mr-0.5">₲</span>{{ format_pyg($this->salesTotal) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-5 border-l-4 border-blue-500 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Vendedores</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $this->salespersonStats->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-5 border-l-4 border-emerald-500 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Total Ventas</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $this->salespersonStats->sum('sales_count') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Period Banner -->
            <div class="flex flex-wrap items-center gap-2 mb-3 px-4 py-2.5 bg-blue-50/80 border border-blue-200/60 rounded-xl text-xs text-blue-700 dark:bg-blue-950/40 dark:border-blue-800/40 dark:text-blue-300">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>
                    <strong>Período:</strong>
                    {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') : '—' }}
                    al
                    {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d/m/Y') : '—' }}
                </span>
                @if($filterShift)
                    <span class="border-l border-blue-200 pl-2">
                        <strong>Turno:</strong> {{ ucfirst($filterShift) }}
                    </span>
                @endif
                <span class="border-l border-blue-200 pl-2">
                    <strong>{{ $this->salespersonStats->count() }}</strong> vendedor(es)
                </span>
                <span class="border-l border-blue-200 pl-2">
                    <strong>{{ $this->salespersonStats->sum('sales_count') }}</strong> ventas
                </span>
                <span class="border-l border-blue-200 pl-2 font-semibold tabular-nums">
                    <span class="text-[10px] opacity-75 mr-0.5">₲</span>{{ format_pyg($this->salesTotal) }}
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded-2xl border border-gray-100 shadow-sm font-sans dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-semibold tracking-wider border-b border-gray-100 dark:text-gray-400 dark:border-gray-700 dark:bg-gray-900/60">
                            <th class="px-6 py-4">Vendedor</th>
                            <th class="px-6 py-4">Código / Turno</th>
                            <th class="px-6 py-4 text-center">Operaciones</th>
                            <th class="px-6 py-4 text-right">Total Vendido</th>
                            <th class="px-6 py-4 text-right">Ticket Promedio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($this->salespersonStats as $i => $stat)
                            <tr class="group hover:bg-gray-50/60 transition duration-150 dark:hover:bg-gray-700/30">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center text-xs dark:bg-gray-900">
                                            @if($i === 0) 🥇 @elseif($i === 1) 🥈 @elseif($i === 2) 🥉 @else <span class="text-gray-400 font-semibold dark:text-gray-400">{{ $i + 1 }}</span> @endif
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition dark:text-white">{{ $stat->seller_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-gray-400 font-mono dark:text-gray-400">{{ $stat->seller_code }}</div>
                                    @if($stat->seller_shift)
                                        <div class="text-[10px] font-medium uppercase mt-0.5
                                            {{ $stat->seller_shift === 'mañana' ? 'text-amber-600 dark:text-amber-400' : ($stat->seller_shift === 'tarde' ? 'text-orange-600 dark:text-orange-400' : 'text-indigo-600 dark:text-indigo-400') }}">
                                            {{ $stat->seller_shift }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200/60 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800/40">
                                        {{ $stat->sales_count }} ventas
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white tabular-nums"><span class="text-xs text-gray-400 font-normal mr-0.5">₲</span>{{ format_pyg($stat->total_amount) }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-xs font-semibold text-gray-500 tabular-nums dark:text-gray-400"><span class="text-[10px] text-gray-400 font-normal mr-0.5">₲</span>{{ format_pyg($stat->average_ticket) }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic dark:text-gray-500">
                                    No hay datos de vendedores para este período.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
