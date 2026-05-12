<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2.5rem] p-6 md:p-10 border border-gray-100">
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10">
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Gestión de Sesión de Caja</h2>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    {{-- Badge de estado --}}
                    @if($currentSession)
                        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            Sesión Abierta
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-full">
                            Caja Cerrada
                        </span>
                    @endif
                </div>
            </div>

            @if (session()->has('message'))
                <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm flex items-center gap-3" role="alert">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-xs font-bold uppercase tracking-wide">{{ session('message') }}</span>
                </div>
            @endif


        {{-- Admin: All open sessions panel --}}
        @can('admin')
            @if($allSessions->isNotEmpty())
                <div class="mb-8 font-sans">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                        Sesiones activas en el sistema
                    </h3>

                    @if($allSessions->where('is_stale', true)->isNotEmpty())
                        <div class="bg-red-50 border border-red-100 px-4 py-3 mb-4 text-xs text-red-700 flex items-center gap-3 rounded-2xl shadow-sm">
                            <div class="bg-red-100 p-2 rounded-xl">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="font-medium">Hay <strong class="font-black">{{ $allSessions->where('is_stale', true)->count() }}</strong> sesión(es) críticas abiertas hace más de 24 horas.</span>
                        </div>
                    @endif

                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 uppercase text-[10px] tracking-widest font-black text-gray-400">
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-4 text-left">Usuario</th>
                                    <th class="px-6 py-4 text-left">Caja</th>
                                    <th class="px-6 py-4 text-left">Apertura</th>
                                    <th class="px-6 py-4 text-center">Duración</th>
                                    <th class="px-6 py-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($allSessions as $s)
                                    <tr class="hover:bg-gray-50/50 transition {{ $s->is_stale ? 'bg-red-50/30' : '' }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-700 font-black text-xs">
                                                    {{ substr($s->user?->name ?? '?', 0, 1) }}
                                                </div>
                                                <span class="font-bold text-gray-900">{{ $s->user?->name ?? '—' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $s->register?->name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-gray-400 font-mono text-[11px]">{{ $s->opened_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase {{ $s->is_stale ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $s->hours_open }} HORAS @if($s->is_stale) ⚠️ @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($s->user_id !== auth()->id())
                                                <button wire:click="forceCloseSession('{{ $s->id }}')"
                                                    wire:confirm="¿Cerrar forzadamente la sesión de {{ $s->user?->name }}? El monto de cierre quedará en 0."
                                                    class="text-[10px] bg-red-50 hover:bg-red-100 text-red-600 font-black uppercase tracking-wider px-3 py-1.5 rounded-xl transition border border-red-100">
                                                    Forzar cierre
                                                </button>
                                            @else
                                                <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest italic">Tu sesión</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endcan

        {{-- === APERTURA (sin sesión activa) === --}}
        @if(!$currentSession)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start font-sans">

                {{-- Formulario de apertura --}}
                <div class="lg:col-span-5 bg-white shadow-sm border border-gray-100 rounded-3xl overflow-hidden self-start">
                    <div class="bg-indigo-600 px-6 py-6 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-10">
                            <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div class="relative z-10">
                            <h2 class="text-white font-black text-xl leading-tight uppercase tracking-tight">Iniciar Turno</h2>
                            <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest mt-1 opacity-80">Apertura de Caja Registradora</p>
                        </div>
                    </div>

                    <div class="p-8">
                        <form wire:submit.prevent="openSession" class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Terminal / Caja Física</label>
                                <div class="relative group">
                                    <select wire:model="selectedRegisterId" class="appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-10 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="">-- Seleccionar Terminal --</option>
                                        @foreach($this->registers as $register)
                                            <option value="{{ $register->id }}" {{ $register->is_occupied ? 'disabled' : '' }}>
                                                {{ $register->name }}
                                                @if($register->is_occupied)
                                                    (Ocupada por {{ $register->current_user_name }})
                                                @else
                                                    (Disponible)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('selectedRegisterId') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Fondo de Caja (Monto Inicial)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-300 font-black text-lg font-mono tracking-tighter">₲</span>
                                    <input wire:model="openingAmount" type="text" x-money
                                        class="pl-10 shadow-sm border border-gray-200 rounded-2xl w-full py-4 px-4 text-gray-900 text-2xl font-black text-center focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-200"
                                        placeholder="0">
                                </div>
                                @error('openingAmount') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Notas Especiales</label>
                                <textarea wire:model="openingNotes"
                                    class="shadow-sm border border-gray-200 rounded-2xl w-full py-3 px-4 text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    rows="2" placeholder="Ej: Dos billetes de 100 mil..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-6 rounded-2xl transition shadow-lg hover:shadow-indigo-200 uppercase tracking-widest text-xs flex items-center justify-center gap-2 group">
                                <span>Abrir Caja Ahora</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Info / guía --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-8 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-gray-50 rounded-full -translate-y-12 translate-x-12"></div>
                        <div class="relative z-10">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-1 h-4 bg-indigo-500 rounded-full"></span>
                                Protocolo de Apertura
                            </h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black shrink-0">1</div>
                                    <div>
                                        <p class="text-xs font-black text-gray-900 uppercase tracking-wide mb-1">Select Terminal</p>
                                        <p class="text-xs text-gray-500 leading-relaxed">Elegí la caja física que usarás hoy.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black shrink-0">2</div>
                                    <div>
                                        <p class="text-xs font-black text-gray-900 uppercase tracking-wide mb-1">Cash Fund</p>
                                        <p class="text-xs text-gray-500 leading-relaxed">Contá el efectivo inicial disponible.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black shrink-0">3</div>
                                    <div>
                                        <p class="text-xs font-black text-gray-900 uppercase tracking-wide mb-1">Register Notes</p>
                                        <p class="text-xs text-gray-500 leading-relaxed">Anotá cualquier observación inicial.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 font-black shrink-0">✓</div>
                                    <div>
                                        <p class="text-xs font-black text-emerald-700 uppercase tracking-wide mb-1">Ready to Sell</p>
                                        <p class="text-xs text-gray-500 leading-relaxed">Una vez abierta, podés ir al POS.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50/50 border border-gray-100 rounded-3xl p-8">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Terminales del Sistema</h3>
                        @if($this->registers->isEmpty())
                            <p class="text-sm text-gray-400 italic">No hay cajas configuradas en la sucursal.</p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($this->registers as $register)
                                    <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm flex flex-col gap-1">
                                        <span class="text-xs font-black text-gray-900 uppercase tracking-tight truncate">{{ $register->name }}</span>
                                        @if($register->is_occupied)
                                            <span class="text-[9px] font-black text-red-500 uppercase tracking-widest bg-red-50 self-start px-1.5 py-0.5 rounded">Ocupada</span>
                                        @else
                                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 self-start px-1.5 py-0.5 rounded">Libre</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        {{-- === SESIÓN ACTIVA (cierre de caja) === --}}
        @else
            <div class="space-y-8 font-sans">
                <!-- KPI Dashboard -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Total Ventas --}}
                    <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Volumen de Ventas</span>
                            <h4 class="text-2xl font-black text-gray-900 font-mono tracking-tighter">₲ {{ format_pyg($totalSales) }}</h4>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-1 rounded-lg uppercase tracking-wide">{{ $salesCount }} Transacciones</span>
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Efectivo --}}
                    <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Ventas en Efectivo</span>
                            <h4 class="text-2xl font-black text-emerald-600 font-mono tracking-tighter">₲ {{ format_pyg($totalCashSales) }}</h4>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg uppercase tracking-wide">Cash Flow</span>
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Ingresos Extra --}}
                    <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Ingresos / Ajustes</span>
                            <h4 class="text-2xl font-black text-indigo-600 font-mono tracking-tighter">₲ {{ format_pyg($totalIn) }}</h4>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-lg uppercase tracking-wide">Aportes</span>
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Salidas --}}
                    <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Egresos / Gastos</span>
                            <h4 class="text-2xl font-black text-red-500 font-mono tracking-tighter">- ₲ {{ format_pyg($totalOut) }}</h4>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-red-700 bg-red-50 px-2 py-1 rounded-lg uppercase tracking-wide">Salidas</span>
                            <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center text-red-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions for Active Session --}}
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex gap-4">
                        <button wire:click="openMovementModal" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-black py-3 px-6 rounded-2xl transition text-xs uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Registrar Movimiento
                        </button>

                        <a href="{{ route('pos.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 px-6 rounded-2xl transition text-xs uppercase tracking-widest flex items-center gap-2 shadow-lg shadow-indigo-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            Ir a Vender
                        </a>
                    </div>
                    
                    @if($currentSession->closed_at)
                    <button class="bg-gray-800 hover:bg-black text-white font-black py-3 px-6 rounded-2xl transition text-xs uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Reimprimir Z-Report
                    </button>
                    @endif
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    {{-- Resumen de Auditoría --}}
                    <div class="lg:col-span-7 space-y-6">
                        <div class="bg-white border border-gray-100 shadow-sm rounded-[2rem] p-8 overflow-hidden relative">
                            <div class="absolute right-0 bottom-0 opacity-5 -mb-4 -mr-4">
                                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            
                            <div class="relative z-10">
                                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-8 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                                    Auditoría de Sesión en Vivo
                                </h3>

                                <div class="grid sm:grid-cols-2 gap-8 mb-10">
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Inicio del Turno</p>
                                        <p class="text-lg font-black text-gray-800 font-mono">{{ $currentSession->opened_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Fondo de Apertura</p>
                                        <p class="text-lg font-black text-indigo-600 font-mono">₲ {{ format_pyg($currentSession->opening_amount) }}</p>
                                    </div>
                                </div>

                                <div class="bg-indigo-950 rounded-[2rem] p-8 text-white flex flex-col sm:flex-row justify-between items-center gap-6 shadow-2xl shadow-indigo-200">
                                    <div class="text-center sm:text-left">
                                        <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Balance Esperado en Caja</p>
                                        <p class="text-3xl font-black font-mono tracking-tighter">₲ {{ format_pyg($currentSession->opening_amount + $totalCashSales + $totalIn - $totalOut) }}</p>
                                    </div>
                                    <div class="px-6 py-3 bg-indigo-800/50 rounded-2xl border border-indigo-700/50 text-[10px] font-black uppercase tracking-widest">
                                        Sync OK
                                    </div>
                                </div>
                                <p class="text-center text-[10px] text-gray-400 mt-6 font-medium italic">
                                    * Los movimientos y ventas se sincronizan automáticamente desde el módulo de ventas (POS).
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Formulario de Cierre --}}
                    <div class="lg:col-span-5 bg-white border border-gray-100 shadow-sm rounded-[2rem] overflow-hidden self-start">
                        <div class="bg-red-600 px-8 py-6 relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 opacity-10">
                                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <div class="relative z-10">
                                <h2 class="text-white font-black text-xl leading-tight uppercase tracking-tight">Finalizar Turno</h2>
                                <p class="text-red-100 text-[10px] font-bold uppercase tracking-widest mt-1 opacity-80">Proceder al Cierre de Caja</p>
                            </div>
                        </div>

                        <div class="p-8">
                            <form wire:submit.prevent="closeSession" class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Conteo Físico Recomentado</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3.5 text-gray-300 font-black text-lg font-mono tracking-tighter">₲</span>
                                        <input wire:model="closingAmount" type="text" x-money
                                            class="pl-10 shadow-sm border border-gray-200 rounded-2xl w-full py-4 px-4 text-gray-900 text-2xl font-black text-center focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition placeholder-gray-200"
                                            placeholder="0">
                                    </div>
                                    @error('closingAmount') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Observaciones de Cierre</label>
                                    <textarea wire:model="notes"
                                        class="shadow-sm border border-gray-200 rounded-2xl w-full py-3 px-4 text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                                        rows="3" placeholder="Discrepancias, billetes dañados, etc..."></textarea>
                                </div>

                                <div class="bg-red-50 border border-red-100 px-4 py-4 rounded-2xl flex items-start gap-3">
                                    <div class="bg-red-100 p-1.5 rounded-lg">
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <p class="text-[10px] text-red-800 font-bold uppercase leading-relaxed tracking-tight">
                                        Esta acción bloqueará nuevas ventas hasta la próxima apertura.
                                    </p>
                                </div>

                                <button type="submit"
                                    onclick="return confirm('¿Confirmar cierre definitivo sugerido?') ? true : false"
                                    class="w-full bg-red-600 hover:bg-black text-white font-black py-4 px-6 rounded-2xl transition shadow-lg hover:shadow-red-200 uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                                    <span>🔒 Ejecutar Cierre</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Modal para Movimientos de Caja --}}

        <x-dialog-modal wire:model="movementModal" maxWidth="lg" id="register-movement">
            <x-slot name="title">
                <span class="uppercase tracking-tight font-black">Registrar Movimiento de Efectivo</span>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Tipo de Movimiento</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="$set('movementType', 'in')" class="py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $movementType === 'in' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'bg-gray-50 text-gray-400 hover:bg-gray-100' }}">
                                Entrada (+)
                            </button>
                            <button wire:click="$set('movementType', 'out')" class="py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition {{ $movementType === 'out' ? 'bg-red-600 text-white shadow-lg shadow-red-100' : 'bg-gray-50 text-gray-400 hover:bg-gray-100' }}">
                                Salida (-)
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Monto del Movimiento</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-300 font-black text-lg font-mono">₲</span>
                            <input wire:model="movementAmount" type="text" x-money
                                class="pl-10 shadow-sm border border-gray-200 rounded-2xl w-full py-4 text-gray-900 text-2xl font-black text-center focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                placeholder="0">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Categoría (Opcional)</label>
                            <a href="{{ route('settings.cash-movement-categories') }}" target="_blank" class="text-[9px] text-indigo-600 hover:underline font-bold uppercase tracking-widest">
                                ⚙️ Gestionar
                            </a>
                        </div>
                        <select wire:model="movementCategory" class="shadow-sm border border-gray-200 rounded-2xl w-full py-2.5 px-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <option value="">Sin categoría</option>
                            @foreach($movementCategories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Descripción / Concepto</label>
                        <textarea wire:model="movementDescription" class="shadow-sm border border-gray-200 rounded-2xl w-full py-3 px-4 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" rows="2" placeholder="Ej: Pago de flete, aporte de socio..."></textarea>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('movementModal', false)">Cancelar</x-secondary-button>
                <button wire:click="registerMovement" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-xl transition text-xs uppercase tracking-widest shadow-lg shadow-indigo-100">
                    Guardar Movimiento
                </button>
            </x-slot>

        </x-dialog-modal>

        </div>
    </div>
</div>

