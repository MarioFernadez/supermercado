<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg dark:bg-gray-800">
            <!-- Header -->
            <div class="p-8 border-b border-gray-100 bg-white font-sans dark:border-gray-700 dark:bg-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight dark:text-white">Movimientos de Caja</h2>
                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-2 dark:text-gray-400 font-normal">
                            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                            Auditoría detallada de ingresos y gastos
                        </p>
                    </div>
                    <div class="flex items-center gap-4 bg-gray-50 px-6 py-3 rounded-2xl border border-gray-100 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:shadow-none">
                        <div class="text-right">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 dark:text-gray-400">Período de Análisis</p>
                            <p class="text-xs font-black text-gray-700 font-mono dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-indigo-500 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="p-6 bg-gray-50/50 border-b border-gray-100 font-sans dark:border-gray-700 dark:bg-gray-900/50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Ingresos -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-5 border-l-4 border-emerald-500 dark:bg-gray-800 dark:shadow-none">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Total Ingresos</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white tabular-nums"><span class="text-sm font-normal text-gray-400 mr-0.5">₲</span>{{ format_pyg($totalIn) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Gastos -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-5 border-l-4 border-red-500 dark:bg-gray-800 dark:shadow-none">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-red-50 text-red-600 dark:bg-red-900/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Total Gastos</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white tabular-nums"><span class="text-sm font-normal text-gray-400 mr-0.5">₲</span>{{ format_pyg($totalOut) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Balance Neto -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-5 border-l-4 border-indigo-500 dark:bg-gray-800 dark:shadow-none">
                        <div class="flex items-center">
                            <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wider dark:text-indigo-400">Balance Neto</p>
                                <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400 tabular-nums"><span class="text-sm font-normal text-indigo-400/80 mr-0.5">₲</span>{{ format_pyg($netTotal) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="p-6 bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700 font-sans">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Date From -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-gray-300">Desde</label>
                        <input type="date" wire:model.live="startDate" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-gray-300">Hasta</label>
                        <input type="date" wire:model.live="endDate" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-gray-300">Tipo</label>
                        <select wire:model.live="filterType" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                            <option value="all">Todos</option>
                            <option value="in">Solo Ingresos</option>
                            <option value="out">Solo Gastos</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-gray-300">Categoría</label>
                        <select wire:model.live="filterCategory" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Todas</option>
                            @if($filterType === 'in' || $filterType === 'all')
                                <optgroup label="Ingresos">
                                    @foreach($categories['in'] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                            @if($filterType === 'out' || $filterType === 'all')
                                <optgroup label="Gastos">
                                    @foreach($categories['out'] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1 dark:text-gray-300">Usuario</label>
                        <select wire:model.live="filterUser" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Todos</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Movements Table -->
            <div class="overflow-x-auto font-sans">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50/80 uppercase text-[11px] tracking-wider font-semibold text-gray-500 dark:bg-gray-900/60 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left">Fecha/Hora</th>
                            <th class="px-6 py-4 text-left">Tipo</th>
                            <th class="px-6 py-4 text-left">Categoría</th>
                            <th class="px-6 py-4 text-left">Descripción</th>
                            <th class="px-6 py-4 text-left">Usuario</th>
                            <th class="px-6 py-4 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($movements as $movement)
                            <tr class="hover:bg-gray-50/60 transition-colors dark:hover:bg-gray-700/30">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">
                                    {{ $movement->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($movement->type === 'in')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Ingreso
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-50 text-red-700 border border-red-200/60 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Gasto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $movement->getCategoryLabel() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $movement->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $movement->session->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold tabular-nums {{ $movement->type === 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                    <span class="text-xs font-normal opacity-75 mr-0.5">{{ $movement->type === 'in' ? '+' : '-' }} ₲</span>{{ format_pyg($movement->amount) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic dark:text-gray-500">
                                    No se encontraron movimientos en el período seleccionado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($movements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
