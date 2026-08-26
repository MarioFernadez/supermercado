<div>
    <x-page-header title="Taller de Desposte" section="Tienda › Carnicería" :badge="$sessions->total() . ' sesiones'">
        <x-slot name="actions">
            <a href="{{ route('admin.deboning.create') }}" wire:navigate class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Registrar Desposte
            </a>
        </x-slot>
    </x-page-header>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl text-sm font-bold text-green-700">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Card content -->
            <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-200/80 dark:bg-gray-800 dark:border-gray-700">
            <!-- Search -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow" placeholder="Buscar por materia prima...">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-widest">Materia Prima</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-widest">Carnicero</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-widest">Rendimiento / Cortes</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-black text-gray-500 uppercase tracking-widest">Merma</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-black text-gray-500 uppercase tracking-widest">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($sessions as $session)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $session->rawMaterial->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">Volumen: {{ number_format($session->total_weight_start, 2) }} Kg</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase">
                                            {{ substr($session->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-sm text-gray-700 font-medium">{{ $session->user->name ?? 'Usuario' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 mb-1">
                                        Total Útil: <span class="font-bold text-green-600">{{ number_format($session->total_weight_yield, 2) }} Kg</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($session->items as $item)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-800">
                                                {{ $item->product->name ?? 'Corte' }}: {{ number_format($item->weight, 2) }} Kg
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black {{ $session->waste_weight > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ number_format($session->waste_weight, 2) }} Kg
                                    </span>
                                    <div class="text-[10px] text-gray-400 mt-1 uppercase font-bold">Desperdicio</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    {{ $session->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <p class="text-sm font-medium">No se encontraron registros de desposte.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sessions->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
