<div class="py-12 font-sans">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Script para abrir WhatsApp de forma automatizada tras activar la gracia -->
        @if(session()->has('grace_activated') && session()->has('whatsapp_url'))
            <script>
                window.open("{{ session('whatsapp_url') }}", "_blank");
            </script>
        @endif

        <!-- Alerta de Bloqueo por Sesión / Expiración -->
        @if(session()->has('error') || $isExpired)
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 text-red-900 p-6 rounded-r-3xl shadow-sm space-y-4">
                <div class="flex items-start gap-4">
                    <div class="bg-red-100 p-3 rounded-2xl text-red-600 shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 012 11.5a6 6 0 0110.158-4.227c-.015.228-.027.458-.027.69a10.024 10.024 0 00.323 2.502H2.5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h10.977zM8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-black uppercase tracking-wider text-red-700">Sistema Bloqueado por Falta de Pago</h3>
                        <p class="text-xs text-red-800/80 leading-relaxed mt-1">
                            Tu período de suscripción mensual ha expirado. Las funciones de facturación (POS), Inventarios y Reportes han sido inhabilitadas temporalmente. Realiza el pago para desbloquear el sistema.
                        </p>
                    </div>
                </div>

                <!-- Bloque dinámico del Comodín de Gracia Híbrido -->
                @if($canActivateGracePeriod)
                    <div class="bg-white/80 backdrop-blur-sm border border-orange-200 rounded-2xl p-5 mt-4 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
                        <div class="space-y-1 text-left">
                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-orange-100 text-orange-700">Comodín de Emergencia Disponible</span>
                            <h4 class="text-xs font-black text-gray-900 uppercase">¿Necesitas facturar de urgencia hoy?</h4>
                            <p class="text-[11px] text-gray-500 font-medium">Activa una prórroga inmediata por 3 días. Esto desbloqueará el POS al instante y abrirá WhatsApp para notificar a soporte.</p>
                        </div>
                        <button wire:click="activateGracePeriod" 
                                class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-black py-2.5 px-6 rounded-xl transition text-[10px] uppercase tracking-widest shadow-md shadow-orange-100 shrink-0">
                            Activar 3 Días de Gracia
                        </button>
                    </div>
                @else
                    <div class="bg-red-100/50 border border-red-200 rounded-2xl p-4 mt-4 text-xs font-bold text-red-800 leading-relaxed flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>El comodín de tiempo de gracia de este ciclo ya fue utilizado. El sistema permanecerá bloqueado permanentemente hasta registrar un pago oficial.</span>
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2.5rem] p-6 md:p-10 border border-gray-100">
            
            <!-- Encabezado -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Estado de Suscripción</h2>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-1">Control de Licencias y Auditoría de Facturación</p>
                </div>

                <div class="flex items-center gap-3">
                    @if($isExpired)
                        <span class="px-4 py-1.5 bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-widest rounded-full flex items-center gap-2">
                            <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                            Vencido
                        </span>
                    @elseif($isNearExpiration)
                        <span class="px-4 py-1.5 bg-orange-100 text-orange-700 text-[10px] font-black uppercase tracking-widest rounded-full flex items-center gap-2 animate-pulse">
                            <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                            Próximo a Vencer
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            Activo / Al Día
                        </span>
                    @endif
                </div>
            </div>

            <!-- KPIs de Suscripción -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
                <!-- Plan Tier -->
                <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-100 rounded-full opacity-20 group-hover:scale-125 transition-transform duration-500"></div>
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Plan Contratado</p>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none uppercase">{{ $tierName }}</h3>
                    <div class="mt-4 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Límites maestros activos</div>
                </div>

                <!-- Fecha de Habilitación -->
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Fecha de Inicio</p>
                    <h3 class="text-2xl font-bold text-gray-800 leading-none font-mono">{{ $enabledAt->format('d/m/Y') }}</h3>
                    <div class="mt-4 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Habilitación inicial</div>
                </div>

                <!-- Fecha de Vencimiento -->
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Próximo Vencimiento</p>
                    <h3 class="text-2xl font-bold text-gray-800 leading-none font-mono {{ $isExpired ? 'text-red-600' : ($isNearExpiration ? 'text-orange-600' : '') }}">{{ $expiresAt->format('d/m/Y') }}</h3>
                    <div class="mt-4 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Ciclo mensual actual</div>
                </div>

                <!-- Días Restantes -->
                <div class="p-6 rounded-3xl border relative overflow-hidden group 
                     {{ $isExpired ? 'bg-red-50/50 border-red-100' : ($isNearExpiration ? 'bg-orange-50/50 border-orange-100' : 'bg-emerald-50/50 border-emerald-100') }}">
                    <p class="text-[10px] font-black uppercase tracking-widest mb-1 
                       {{ $isExpired ? 'text-red-400' : ($isNearExpiration ? 'text-orange-400' : 'text-emerald-400') }}">Tiempo de Servicio</p>
                    
                    @if($isExpired)
                        <h3 class="text-2xl font-black text-red-600 leading-none uppercase">EXPIRADO</h3>
                        <div class="mt-4 text-[9px] font-black text-red-500 uppercase tracking-wider">Servicio bloqueado</div>
                    @else
                        <h3 class="text-2xl font-bold text-gray-900 leading-none font-mono 
                            {{ $isNearExpiration ? 'text-orange-600' : 'text-emerald-700' }}">{{ $daysRemaining }} Días</h3>
                        <div class="mt-4 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Faltan para el vencimiento</div>
                    @endif
                </div>
            </div>

            <!-- Límites y Uso de Licencia -->
            <div class="mb-10">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-amber-500 rounded-full"></span>
                    Límites de Uso y Licencias Contratadas
                </h3>
                @php $stats = \App\Services\LicenseService::getUsageStats(); @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Usuarios -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition duration-300">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Usuarios Habilitados</p>
                            <h4 class="text-3xl font-black text-gray-900 tracking-tight">
                                {{ $stats['users']['current'] }} <span class="text-gray-300 font-medium">/</span> {{ $stats['users']['max'] }}
                            </h4>
                            <p class="text-[10px] font-bold {{ $stats['users']['available'] > 0 ? 'text-emerald-600' : 'text-red-500' }} uppercase">
                                {{ $stats['users']['available'] }} cupos libres
                            </p>
                        </div>
                        <div class="bg-indigo-50 text-indigo-600 p-4 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Cajas Registradoras -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex items-center justify-between group hover:border-purple-200 transition duration-300">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-purple-500 uppercase tracking-widest">Cajas Registradoras (POS)</p>
                            <h4 class="text-3xl font-black text-gray-900 tracking-tight">
                                {{ $stats['cash_registers']['current'] }} <span class="text-gray-300 font-medium">/</span> {{ $stats['cash_registers']['max'] }}
                            </h4>
                            <p class="text-[10px] font-bold {{ $stats['cash_registers']['available'] > 0 ? 'text-emerald-600' : 'text-red-500' }} uppercase">
                                {{ $stats['cash_registers']['available'] }} disponibles
                            </p>
                        </div>
                        <div class="bg-purple-50 text-purple-600 p-4 rounded-2xl group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Sucursales -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex items-center justify-between group hover:border-amber-200 transition duration-300">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Sucursales Autorizadas</p>
                            <h4 class="text-3xl font-black text-gray-900 tracking-tight">
                                {{ $stats['branches']['current'] }} <span class="text-gray-300 font-medium">/</span> {{ $stats['branches']['max'] }}
                            </h4>
                            <p class="text-[10px] font-bold {{ $stats['branches']['available'] > 0 ? 'text-emerald-600' : 'text-red-500' }} uppercase">
                                {{ $stats['branches']['available'] }} sucursales libres
                            </p>
                        </div>
                        <div class="bg-amber-50 text-amber-600 p-4 rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Historial de Pagos (Auditoría del Cliente) -->
                <div class="lg:col-span-8 space-y-4">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-indigo-600 rounded-full"></span>
                        Historial de Comprobantes de Pago
                    </h3>

                    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-50 uppercase text-[9px] tracking-widest font-black text-gray-400 border-b border-gray-100">
                                <tr>
                                    <th class="px-5 py-4 text-left">Fecha de Pago</th>
                                    <th class="px-5 py-4 text-center">Método</th>
                                    <th class="px-5 py-4 text-left">Notas / Referencia</th>
                                    <th class="px-5 py-4 text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 font-medium">
                                @forelse($payments as $p)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-5 py-4 font-mono font-bold text-gray-500">{{ $p->payment_date->format('d/m/Y') }}</td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="inline-flex px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider {{ $p->payment_method === 'transferencia' ? 'bg-indigo-50 text-indigo-700' : 'bg-emerald-50 text-emerald-700' }}">
                                                {{ $p->payment_method }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 text-[11px] leading-relaxed max-w-[280px] truncate" title="{{ $p->notes }}">{{ $p->notes ?? '—' }}</td>
                                        <td class="px-5 py-4 text-right font-black text-gray-900 tabular-nums">Gs. {{ number_format($p->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-12 text-center text-gray-400 font-bold uppercase tracking-wider leading-loose">No se reportan transacciones registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Instrucciones de Pago y Soporte -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">¿Cómo realizar tu pago?</h3>
                        
                        <div class="space-y-4 text-xs leading-relaxed text-gray-600 font-medium">
                            <p>Realiza tu transferencia bancaria a los siguientes datos del proveedor:</p>
                            
                            <div class="bg-white p-4 rounded-2xl border border-gray-100 space-y-2 font-bold text-gray-900">
                                <div>
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">Banco</span>
                                    Banco Familiar S.A.
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">Nº de Cuenta</span>
                                    0-1234567-8
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">Titular de Cuenta</span>
                                    Soteweb Tecnología
                                </div>
                                <div>
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">RUC / CI</span>
                                    8000000-1
                                </div>
                            </div>

                            <p class="text-[10px] text-gray-400 leading-normal italic">
                                * Una vez realizada la transferencia, envía el comprobante bancario haciendo clic en el botón de abajo para que el proveedor reactive el servicio de inmediato.
                            </p>

                            @php
                                $whatsapp_message = "Hola, he realizado la transferencia bancaria correspondiente a la suscripción mensual de ZonaPOS de mi comercio. Adjunto el comprobante de pago.";
                                $whatsapp_link = "https://wa.me/595981762444?text=" . urlencode($whatsapp_message);
                            @endphp

                            <a href="{{ $whatsapp_link }}" target="_blank"
                               class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3 px-4 rounded-xl transition text-xs uppercase tracking-widest shadow-lg shadow-emerald-100/50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412s-1.239 6.164-3.485 8.412c-2.245 2.247-5.231 3.487-8.412 3.487-2.045 0-4.039-.526-5.803-1.522l-6.101 1.605c-.097.026-.194.039-.291.039-.42 0-.792-.262-.914-.663zm3.765-18.423c-.347-.771-.711-.787-1.04-.801-.269-.012-.577-.012-.885-.012s-.808.115-1.231.577c-.423.462-1.616 1.578-1.616 3.849 0 2.27 1.654 4.464 1.885 4.772.231.308 3.256 4.972 7.888 6.971 3.854 1.664 4.639 1.333 5.486 1.256.847-.077 2.733-.513 3.118-.975.385-.462.385-1.385.269-1.578-.115-.192-.423-.308-.885-.539s-2.733-1.347-3.156-1.5c-.424-.154-.731-.231-1.04.231s-1.193 1.5-1.463 1.809c-.269.308-.539.346-1.001.115s-1.95-.719-3.712-2.289c-1.371-1.222-2.296-2.731-2.566-3.193s-.029-.714.202-.943c.208-.207.462-.539.693-.808.231-.269.308-.462.462-.77.154-.308.077-.577-.038-.808z"/></svg>
                                Enviar Comprobante
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
