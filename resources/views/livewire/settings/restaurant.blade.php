<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight dark:text-white flex items-center gap-2">
                🍽️ Configuración de Restaurante
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Mesas -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-base font-bold text-gray-900 mb-4 dark:text-indigo-400">Plano de Mesas</h2>
                
                @if (session()->has('table_message'))
                    <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-xl mb-4">{{ session('table_message') }}</div>
                @endif

                <form wire:submit.prevent="addTable" class="flex gap-2 mb-6">
                    <input type="text" wire:model="newTableName" placeholder="Nombre de la Mesa (Ej: Mesa 1, VIP, Barra)" class="flex-1 border-gray-200 rounded-xl text-xs py-2 px-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition">Agregar</button>
                </form>

                <ul class="space-y-2">
                    @forelse($tables as $table)
                        <li class="flex items-center justify-between bg-gray-50/70 p-3 rounded-xl border border-gray-100 dark:bg-gray-900 dark:border-gray-700">
                            <span class="font-semibold text-xs text-gray-900 dark:text-gray-200">{{ $table->name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $table->status == 'available' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300' }}">
                                    {{ $table->status == 'available' ? 'Libre' : 'Ocupada' }}
                                </span>
                                <button wire:click="deleteTable({{ $table->id }})" class="text-rose-500 hover:text-rose-700 p-1" title="Eliminar Mesa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="text-xs text-gray-400 text-center py-6 italic">No hay mesas configuradas aún.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Mozos -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-base font-bold text-gray-900 mb-4 dark:text-fuchsia-400">Mozos / Camareros</h2>
                
                @if (session()->has('waiter_message'))
                    <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-xl mb-4">{{ session('waiter_message') }}</div>
                @endif

                <form wire:submit.prevent="addWaiter" class="flex gap-2 mb-6">
                    <input type="text" wire:model="newWaiterName" placeholder="Nombre del Mozo" class="flex-1 border-gray-200 rounded-xl text-xs py-2 px-3 focus:ring-2 focus:ring-fuchsia-500/20 focus:border-fuchsia-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
                    <button type="submit" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition">Agregar</button>
                </form>

                <ul class="space-y-2">
                    @forelse($waiters as $waiter)
                        <li class="flex items-center justify-between bg-gray-50/70 p-3 rounded-xl border border-gray-100 dark:bg-gray-900 dark:border-gray-700">
                            <span class="font-semibold text-xs {{ $waiter->active ? 'text-gray-900 dark:text-gray-200' : 'text-gray-400 line-through' }}">{{ $waiter->name }}</span>
                            <div class="flex items-center gap-2">
                                <button wire:click="toggleWaiter({{ $waiter->id }})" class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $waiter->active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $waiter->active ? 'Activo' : 'Inactivo' }}
                                </button>
                                <button wire:click="deleteWaiter({{ $waiter->id }})" class="text-rose-500 hover:text-rose-700 p-1" title="Eliminar Mozo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="text-xs text-gray-400 text-center py-6 italic">No hay mozos configurados.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
