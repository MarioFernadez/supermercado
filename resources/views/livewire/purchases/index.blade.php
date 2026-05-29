<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 dark:bg-gray-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-tighter dark:text-white">Historial de Compras</h2>
                <div class="flex items-center gap-3">
                    <input type="text" wire:model.live="search" placeholder="Buscar por factura o proveedor..." class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 min-w-[300px] dark:border-gray-600 dark:shadow-none dark:bg-gray-900 dark:text-gray-300">
                    <a href="{{ route('purchases.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all text-sm uppercase tracking-widest dark:shadow-none">
                        Nueva Compra
                    </a>
                </div>
            </div>

            @if(session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/40 dark:text-green-400" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto border border-gray-100 rounded-xl dark:border-gray-700">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest dark:text-gray-500">
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Proveedor</th>
                            <th class="px-6 py-4">Factura / Ref.</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($purchases as $purchase)
                            <tr class="hover:bg-gray-50 transition-colors dark:hover:bg-gray-700">
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono dark:text-gray-400">{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $purchase->supplier->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $purchase->reference_number ?: 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-black text-gray-900 dark:text-white">₲ {{ number_format($purchase->total, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Completado</span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-400 dark:text-gray-500">{{ $purchase->user->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs dark:text-gray-500">No hay compras registradas.</td>
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
