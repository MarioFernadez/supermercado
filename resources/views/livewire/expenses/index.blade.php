<div>
    <x-page-header title="Gastos" section="Finanzas › Egresos">
        <x-slot name="actions">
            <div class="bg-red-50 border border-red-200/80 rounded-xl px-3.5 py-1.5 flex items-center gap-2.5 mr-1 dark:bg-red-900/20 dark:border-red-800/40">
                <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest dark:text-red-400">Total Periodo:</span>
                <span class="text-sm font-black text-red-700 dark:text-red-300">₲ {{ number_format($totalPeriod, 0, ',', '.') }}</span>
            </div>

            <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Registrar Gasto
            </button>

            <a href="{{ route('expenses.categories.index') }}" wire:navigate class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500" title="Gestionar Categorías">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </a>
        </x-slot>
    </x-page-header>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200/80 px-5 py-5 dark:bg-gray-800 dark:border-gray-700">

            <!-- Filters -->
            <div class="bg-gray-50/50 p-4 rounded-3xl border border-gray-100 mb-8 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Desde</label>
                        <input wire:model.live="dateFrom" type="date" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Hasta</label>
                        <input wire:model.live="dateTo" type="date" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Categoría</label>
                        <select wire:model.live="categoryId" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition dark:text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por descripción..." class="pl-9 w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm py-2 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl shadow-sm animate-pulse dark:bg-emerald-900/30 dark:text-emerald-400 dark:shadow-none" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto border border-gray-100 rounded-3xl shadow-sm dark:border-gray-700 dark:shadow-none">
                <table class="w-full text-left border-collapse font-sans">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-semibold tracking-wider border-b border-gray-100 dark:bg-gray-900/60 dark:text-gray-400 dark:border-gray-700">
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Categoría / Descripción</th>
                            <th class="px-6 py-4">Método / Ref</th>
                            <th class="px-6 py-4 text-right">Monto</th>
                            <th class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/40 transition group">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $expense->date->format('d/m/Y') }}</div>
                                    <div class="text-[11px] text-gray-400 font-normal dark:text-gray-500">{{ $expense->date->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-semibold text-indigo-600 uppercase tracking-wide dark:text-indigo-400">{{ $expense->category->name }}</div>
                                    <div class="text-sm text-gray-600 font-normal dark:text-gray-400">{{ $expense->description }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 bg-gray-50 text-gray-600 text-[10px] font-medium uppercase rounded border border-gray-200/80 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                                        {{ $expense->payment_method }}
                                    </span>
                                    @if($expense->reference)
                                        <div class="text-[11px] text-gray-400 mt-1 truncate max-w-[100px] dark:text-gray-500">{{ $expense->reference }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-semibold text-gray-900 tabular-nums dark:text-white"><span class="text-xs text-gray-400 font-normal mr-0.5">₲</span>{{ number_format($expense->amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1.5 transition">
                                        <button wire:click="edit('{{ $expense->id }}')" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-xl transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="delete('{{ $expense->id }}')" 
                                                wire:confirm="¿Estás seguro de eliminar este registro de gasto?"
                                                class="p-2 text-red-400 hover:bg-red-50 rounded-xl transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic font-medium dark:text-gray-500">No se encontraron gastos en este periodo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>

    <!-- Expense Modal -->
    <x-dialog-modal wire:model="isOpen" maxWidth="xl">
        <x-slot name="title">
            <div class="flex items-center gap-3 font-black uppercase tracking-tighter">
                {{ $expenseId ? 'Editar Gasto' : 'Registrar Nuevo Gasto' }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Fecha</label>
                        <input type="date" wire:model="form.date" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        @error('form.date') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Categoría</label>
                        <select wire:model="form.expense_category_id" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm font-bold dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">Seleccionar...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('form.expense_category_id') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Descripción del Gasto</label>
                    <input type="text" wire:model="form.description" placeholder="Ej: Pago Factura ANDE Marzo" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    @error('form.description') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Monto (₲)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 font-bold">₲</span>
                            <input type="number" wire:model="form.amount" placeholder="0" class="pl-8 w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-lg font-black text-gray-900 dark:border-gray-700 dark:text-white dark:bg-gray-900">
                        </div>
                        @error('form.amount') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Método de Pago</label>
                        <select wire:model="form.payment_method" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm font-bold dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="efectivo">Efectivo (Sale de Caja)</option>
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->name }}">{{ $pm->name }}</option>
                            @endforeach
                        </select>
                        @error('form.payment_method') <span class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1 dark:text-gray-500">Referencia / N° Comprobante (Opcional)</label>
                    <input type="text" wire:model="form.reference" placeholder="Ej: 001-001-000123" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center justify-between w-full">
                <div class="text-[10px] text-gray-400 font-medium max-w-[200px] dark:text-gray-500">
                    * Si el pago es en **Efectivo**, se restará automáticamente del saldo de la caja actual.
                </div>
                <div class="flex gap-2">
                    <x-secondary-button wire:click="$set('isOpen', false)" wire:loading.attr="disabled">
                        Cancelar
                    </x-secondary-button>

                    <button wire:click="store" class="bg-gray-900 hover:bg-black text-white font-black py-2.5 px-8 rounded-xl transition text-xs uppercase tracking-widest shadow-lg">
                        Guardar Registro
                    </button>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
