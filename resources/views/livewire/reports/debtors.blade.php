<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6 dark:bg-gray-800">
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter dark:text-white">Saldos de Clientes</h2>
                    <p class="text-sm text-gray-500 font-medium dark:text-gray-400">Estado de cuentas pendientes de cobro</p>
                </div>
                
                <div class="bg-amber-50 border border-amber-100 rounded-2xl px-6 py-4 flex items-center gap-4 shadow-sm dark:bg-amber-900/30 dark:border-amber-800/50 dark:shadow-none">
                    <div class="p-3 bg-white rounded-xl text-amber-600 shadow-sm dark:bg-gray-800 dark:shadow-none dark:text-amber-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Deuda Total en la Calle</p>
                        <p class="text-3xl font-black text-gray-900 tabular-nums dark:text-white">₲ {{ number_format($totalDebt, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="relative max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Filtrar por nombre o RUC..." class="pl-10 block w-full border-gray-200 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm py-3 shadow-sm dark:border-gray-700 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                </div>
            </div>

            <div class="overflow-hidden border border-gray-100 rounded-3xl shadow-sm dark:border-gray-700 dark:shadow-none">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 uppercase text-[10px] font-black tracking-widest border-b border-gray-100 dark:bg-gray-900 dark:text-gray-400 dark:border-gray-700">
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Último Movimiento</th>
                            <th class="px-6 py-4 text-right">Saldo Pendiente</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($debtors as $debtor)
                            <tr class="hover:bg-amber-50/20 transition group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-gray-900 group-hover:text-indigo-600 transition dark:text-white">{{ $debtor->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono dark:text-gray-400">{{ $debtor->ruc }} · {{ $debtor->phone }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $lastTx = $debtor->transactions->sortByDesc('created_at')->first();
                                    @endphp
                                    @if($lastTx)
                                        <div class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $lastTx->created_at->diffForHumans() }}</div>
                                        <div class="text-[10px] text-gray-400 dark:text-gray-400">{{ $lastTx->description }}</div>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-lg font-black text-red-600 tabular-nums">₲ {{ number_format($debtor->balance, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('customers.index', ['search' => $debtor->ruc]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-indigo-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Gestionar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic dark:text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-lg font-bold">¡Increíble! No hay saldos pendientes.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8 bg-gray-50 rounded-2xl p-6 border border-dashed border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-white rounded-lg text-indigo-500 shadow-sm dark:bg-gray-800 dark:shadow-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-xs text-gray-500 space-y-1 dark:text-gray-400">
                        <p class="font-bold text-gray-700 uppercase tracking-widest mb-1 dark:text-gray-300">Nota sobre Saldos:</p>
                        <p>• Los clientes aparecen en esta lista si su saldo acumulado es mayor a ₲ 0.</p>
                        <p>• El saldo se calcula restando todos los <strong class="text-gray-700 dark:text-gray-300">Créditos (Pagos)</strong> de los <strong class="text-gray-700 dark:text-gray-300">Débitos (Ventas a Crédito)</strong>.</p>
                        <p>• Presiona "Gestionar" para ver el detalle completo de la cuenta y registrar nuevos cobros.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
