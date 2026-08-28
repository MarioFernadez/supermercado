<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 dark:bg-gray-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Historial de Compras</h2>
                <div class="flex items-center gap-3">
                    <input type="text" wire:model.live="search" placeholder="Buscar por factura o proveedor..." class="border-gray-200 rounded-xl shadow-xs text-xs focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 min-w-[280px] py-2 px-3 dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                    <a href="{{ route('purchases.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl text-xs shadow-sm transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Nueva Compra
                    </a>
                </div>
            </div>

            @if(session()->has('message'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl text-xs dark:bg-emerald-900/30 dark:text-emerald-400" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto border border-gray-100 rounded-2xl shadow-xs dark:border-gray-700">
                <table class="w-full text-left font-sans">
                    <thead class="bg-gray-50/80 uppercase text-[11px] tracking-wider font-semibold text-gray-500 dark:bg-gray-900/60 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Proveedor</th>
                            <th class="px-6 py-4">Factura / Ref.</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @forelse($purchases as $purchase)
                            <tr class="hover:bg-gray-50/60 transition-colors dark:hover:bg-gray-700/40">
                                <td class="px-6 py-4 text-xs text-gray-500 font-mono dark:text-gray-400">{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $purchase->supplier->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $purchase->invoice_number ?? 'S/N' }}</span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-gray-900 dark:text-white tabular-nums">
                                    <span class="text-xs font-normal text-gray-400 mr-0.5">₲</span>{{ number_format($purchase->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-0.5 text-xs rounded-full font-semibold {{ $purchase->status === 'received' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300' }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400">{{ $purchase->user->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-xs italic dark:text-gray-500">
                                    No hay compras registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</div>
