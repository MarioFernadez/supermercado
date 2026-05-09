<div class="py-12" x-data="{ openModal: @entangle('showPaymentModal') }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Gestión de Cobranzas</h2>
                    <p class="text-gray-500 text-sm">Listado de clientes con saldos pendientes por cobrar</p>
                </div>
                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="Buscar cliente..." class="border-gray-200 rounded-2xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 min-w-[300px] pl-10 py-3">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            @if(session()->has('message'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl" role="alert">
                    <p class="font-bold">Atención</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($customers as $customer)
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-20 h-20 bg-gray-50 rounded-full group-hover:scale-150 transition-transform"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $customer->name }}</h3>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-4">RUC: {{ $customer->ruc }}</p>
                            
                            <div class="bg-red-50 rounded-2xl p-4 mb-6">
                                <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Saldo Pendiente</p>
                                <p class="text-2xl font-black text-red-600 tabular-nums">₲ {{ number_format($customer->balance, 0, ',', '.') }}</p>
                            </div>

                            <button wire:click="openPaymentModal('{{ $customer->id }}')" class="w-full bg-gray-900 hover:bg-indigo-600 text-white font-bold py-3 px-4 rounded-2xl transition-all shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Registrar Cobro
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="bg-emerald-50 text-emerald-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">¡Sin deudas pendientes!</h3>
                        <p class="text-gray-400 text-sm">Todos tus clientes están al día con sus pagos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div x-show="openModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>

            <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full max-w-lg p-8 bg-white rounded-3xl shadow-2xl">
                
                @if($selectedCustomer)
                <div class="mb-6">
                    <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase mb-1">Registrar Pago</h2>
                    <p class="text-gray-500 text-sm">Cliente: <span class="font-bold text-gray-900">{{ $selectedCustomer['name'] }}</span></p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Monto a Cobrar</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-400 font-bold">₲</span>
                            <input type="number" wire:model="paymentAmount" class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-2xl text-lg font-black focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                        <p class="mt-1 text-[10px] text-red-400 font-bold italic">Saldo máximo: ₲ {{ number_format($selectedCustomer['balance'], 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Método de Pago</label>
                        <select wire:model="paymentMethod" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="efectivo">Efectivo (Entra a Caja)</option>
                            <option value="pos">POS / Tarjeta (Entra a Caja)</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Descripción / Nota</label>
                        <textarea wire:model="paymentDescription" rows="2" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button @click="openModal = false" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition-all">
                            Cancelar
                        </button>
                        <button wire:click="registerPayment" class="flex-[2] px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-100">
                            Confirmar Cobro
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
