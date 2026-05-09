<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Header -->
            <div class="p-8 border-b border-gray-100 bg-white font-sans">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Movimientos de Caja</h2>
                        <p class="text-[10px] font-black text-gray-400 mt-1 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                            Auditoría de Ingresos y Gastos
                        </p>
                    </div>
                    <div class="flex items-center gap-4 bg-gray-50 px-6 py-3 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="text-right">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Período de Análisis</p>
                            <p class="text-xs font-black text-gray-700 font-mono">
                                {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-indigo-500 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="p-8 bg-gray-50/50 border-b border-gray-100 font-sans">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Ingresos -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-emerald-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-emerald-50 text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Ingresos</p>
                                <p class="text-xl font-bold text-gray-900">₲ {{ format_pyg($totalIn) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Gastos -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-red-50 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Gastos</p>
                                <p class="text-xl font-bold text-gray-900">₲ {{ format_pyg($totalOut) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Balance Neto -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-indigo-500 shadow-indigo-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Balance Neto</p>
                                <p class="text-xl font-bold text-indigo-600">₲ {{ format_pyg($netTotal) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" wire:model.live="startDate" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" wire:model.live="endDate" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select wire:model.live="filterType" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all">Todos</option>
                            <option value="in">Solo Ingresos</option>
                            <option value="out">Solo Gastos</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select wire:model.live="filterCategory" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                        <select wire:model.live="filterUser" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                    <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400">
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-4 text-left">Fecha/Hora</th>
                            <th class="px-6 py-4 text-left">Tipo</th>
                            <th class="px-6 py-4 text-left">Categoría</th>
                            <th class="px-6 py-4 text-left">Descripción</th>
                            <th class="px-6 py-4 text-left">Usuario</th>
                            <th class="px-6 py-4 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($movements as $movement)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $movement->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($movement->type === 'in')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Ingreso
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Gasto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $movement->getCategoryLabel() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $movement->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $movement->session->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $movement->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $movement->type === 'in' ? '+' : '-' }} ₲ {{ format_pyg($movement->amount) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm">No se encontraron movimientos en el período seleccionado</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($movements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
