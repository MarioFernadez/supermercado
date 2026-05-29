<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-gray-800">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 font-sans">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight dark:text-white">Historial de Cierres</h2>
                    <p class="text-[10px] font-black text-gray-400 mt-1 uppercase tracking-widest flex items-center gap-2 dark:text-gray-400">
                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                        Relación de Sesiones Finalizadas
                    </p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('reports.cash.print', ['from' => $dateFrom, 'to' => $dateTo, 'user_id' => $selectedUser]) }}" target="_blank" class="bg-gray-900 hover:bg-black text-white font-black py-2.5 px-6 rounded-xl transition shadow-lg flex items-center justify-center w-full uppercase tracking-widest text-[10px]">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir PDF
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 font-sans">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-indigo-500 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest dark:text-gray-400">Total Sesiones</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $sessions->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-emerald-500 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest dark:text-gray-400">Efectivo Real (Total)</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">₲ {{ format_pyg($sessions->sum('closing_amount')) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-orange-500 dark:bg-gray-800 dark:shadow-none">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-orange-50 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest dark:text-gray-400">Diferencia Neta</p>
                            <p class="text-xl font-bold {{ $sessions->sum('difference') < 0 ? 'text-red-500' : 'text-emerald-600' }}">₲ {{ format_pyg($sessions->sum('difference')) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8 p-6 bg-gray-50/50 border border-gray-100 rounded-3xl font-sans dark:bg-gray-900/50 dark:border-gray-700">
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Desde</label>
                    <input wire:model.live="dateFrom" type="date" class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Hasta</label>
                    <input wire:model.live="dateTo" type="date" class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 dark:text-gray-400">Cajero</label>
                    <select wire:model.live="selectedUser" class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                        <option value="">-- Todos --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button wire:click="filterToday" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white dark:shadow-none">
                        Hoy
                    </button>
                    <button wire:click="filterWeek" class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white dark:shadow-none">
                        Semana
                    </button>
                </div>
            </div>

            <!-- Cash Sessions Table -->
            <div class="w-full font-sans">
                <!-- Desktop Table -->
                <div class="hidden md:block bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:shadow-none">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400 dark:bg-gray-900 dark:text-gray-400">
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="px-4 py-4 text-left">Usuario</th>
                                <th class="px-4 py-4 text-left">Apertura</th>
                                <th class="px-4 py-4 text-left">Cierre</th>
                                <th class="px-4 py-4 text-right">Inicial</th>
                                <th class="px-4 py-4 text-right">Calculado</th>
                                <th class="px-4 py-4 text-right">Real</th>
                                <th class="px-4 py-4 text-right">Dif.</th>
                                <th class="px-4 py-4 text-left">Notas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($sessions as $session)
                                <tr class="hover:bg-gray-50 border-b border-gray-200 dark:hover:bg-gray-700 dark:border-gray-700">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $session->user?->name ?? 'Usuario Eliminado' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $session->opened_at->format('d/m H:i') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $session->closed_at ? $session->closed_at->format('d/m H:i') : '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 text-right dark:text-gray-400">₲ {{ format_pyg($session->opening_amount) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 text-right dark:text-gray-400">₲ {{ format_pyg($session->calculated_amount) }}</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right dark:text-white">₲ {{ format_pyg($session->closing_amount) }}</td>
                                    <td class="px-4 py-3 text-sm font-bold text-right {{ $session->difference < 0 ? 'text-red-600' : ($session->difference > 0 ? 'text-green-600' : 'text-gray-400') }}">
                                        {{ $session->difference > 0 ? '+' : '' }}₲ {{ format_pyg($session->difference) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500 italic truncate max-w-xs dark:text-gray-400">{{ $session->notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No hay cierres de caja registrados en este periodo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden grid grid-cols-1 gap-4">
                    @forelse($sessions as $session)
                        <div class="bg-white border rounded-lg p-4 shadow-sm relative dark:bg-gray-800 dark:shadow-none">
                            <!-- Header: User & Date -->
                            <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-50">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg leading-tight dark:text-white">{{ $session->user?->name ?? 'Usuario Eliminado' }}</h3>
                                    <div class="text-xs text-gray-500 mt-1 dark:text-gray-400">
                                        {{ $session->opened_at->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-400 dark:text-gray-400">Diferencia</div>
                                    <span class="font-bold text-base {{ $session->difference < 0 ? 'text-red-600' : ($session->difference > 0 ? 'text-green-600' : 'text-gray-400') }}">
                                        {{ $session->difference > 0 ? '+' : '' }}₲ {{ format_pyg($session->difference) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Time Info -->
                            <div class="flex justify-between text-xs text-gray-500 mb-3 bg-gray-50 p-2 rounded dark:text-gray-400 dark:bg-gray-900">
                                <div>
                                    <span class="block text-gray-400 dark:text-gray-400">Apertura</span>
                                    <span class="font-mono text-gray-700 dark:text-gray-300">{{ $session->opened_at->format('H:i') }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-gray-400 dark:text-gray-400">Cierre</span>
                                    <span class="font-mono text-gray-700 dark:text-gray-300">{{ $session->closed_at ? $session->closed_at->format('H:i') : 'Activa' }}</span>
                                </div>
                            </div>

                            <!-- Financial Grid -->
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div>
                                    <span class="block text-xs text-gray-400 dark:text-gray-400">Inicial</span>
                                    <span class="text-gray-600 dark:text-gray-400">₲ {{ format_pyg($session->opening_amount) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-xs text-gray-400 dark:text-gray-400">Real (Conteo)</span>
                                    <span class="font-bold text-gray-900 dark:text-white">₲ {{ format_pyg($session->closing_amount) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 dark:text-gray-400">Calculado Sistema</span>
                                    <span class="text-gray-600 dark:text-gray-400">₲ {{ format_pyg($session->calculated_amount) }}</span>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($session->notes)
                                <div class="mt-3 pt-3 border-t border-gray-50 text-xs text-gray-500 italic bg-yellow-50 p-2 rounded dark:text-gray-400 dark:bg-yellow-900/30">
                                    "{{ $session->notes }}"
                                </div>
                            @endif
                        </div>
                    @empty
                         <div class="px-4 py-6 text-center text-gray-500 bg-gray-50 rounded-lg dark:text-gray-400 dark:bg-gray-900">No hay cierres de caja registrados en este periodo.</div>
                    @endforelse
                </div>
            </div>
            <div class="mt-4">
                {{ $sessions->links() }}
            </div>
        </div>
    </div>
</div>
