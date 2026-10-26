<div class="py-6 bg-slate-50 min-h-screen font-sans dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header Principal Master Compacto -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 px-6 py-4 rounded-2xl shadow-lg border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="space-y-1 relative z-10">
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-black text-white tracking-tight">
                        Facturación Electrónica Nacional
                    </h1>
                    <span class="px-2 py-0.5 bg-sky-400/10 text-sky-300 text-[10px] font-black uppercase tracking-wider rounded-md border border-sky-400/20">
                        SIFEN v150
                    </span>
                    @if($sifen_environment === 'test')
                        <span class="px-2 py-0.5 bg-yellow-500/20 text-yellow-300 text-[10px] font-black uppercase tracking-wider rounded-md border border-yellow-500/40">
                            🧪 Pruebas
                        </span>
                    @else
                        <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-300 text-[10px] font-black uppercase tracking-wider rounded-md border border-emerald-500/40">
                            🛡️ Producción
                        </span>
                    @endif
                </div>
                <p class="text-slate-400 text-xs font-medium">
                    Gestión SIFEN (e-kuatia DNIT) · Emisión con CDC y Códigos QR.
                </p>
            </div>

            <!-- Botones de Acción Rápidos y Compactos -->
            <div class="flex flex-wrap items-center gap-2 relative z-10 shrink-0">
                <!-- Cargar Datos de Prueba -->
                <button wire:click="loadTestData"
                        type="button"
                        class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-black text-xs uppercase tracking-wider transition shadow flex items-center gap-1.5"
                        title="Cargar credenciales y parámetros de prueba del manual DNIT v150">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>Cargar Pruebas</span>
                </button>

                <!-- Limpiar Datos de Prueba -->
                <button wire:click="clearTestData"
                        wire:confirm="¿Estás seguro de limpiar los datos de prueba? Se vaciarán los campos para que ingreses los datos reales del negocio."
                        type="button"
                        class="px-3 py-2 bg-rose-950/40 hover:bg-rose-900/60 text-rose-300 hover:text-rose-100 border border-rose-500/30 rounded-xl font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5"
                        title="Limpiar datos de prueba y dejar campos en blanco">
                    <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>Limpiar</span>
                </button>

                <!-- Probar Ticket -->
                <a href="{{ route('master.sifen.print-test') }}"
                   target="_blank"
                   class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-emerald-400 hover:text-emerald-300 border border-emerald-500/30 rounded-xl font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5"
                   title="Imprimir ticket térmico KuDE de prueba">
                    <span>🖨️</span> Ticket 80mm
                </a>

                <!-- Link a Vista de Cliente -->
                <a href="{{ route('settings.invoicing') }}"
                   class="px-3 py-2 bg-slate-800/80 hover:bg-slate-700 text-sky-300 hover:text-sky-200 border border-sky-500/30 rounded-xl font-black text-xs uppercase tracking-wider transition flex items-center gap-1.5"
                   title="Abrir la interfaz que ve el cliente en Parámetros Tienda">
                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Panel Cliente</span>
                </a>
            </div>
        </div>

        <!-- Alertas de Sesión -->
        @if (session()->has('message'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-2xl flex items-center justify-between shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-xs font-bold">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Tabs de Navegación -->
        <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2 overflow-x-auto">
            <button wire:click="$set('activeTab', 'status')"
                    class="px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'status' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800' }}">
                <span>📊</span> Estado & Diagnóstico
            </button>
            <button wire:click="$set('activeTab', 'production_setup')"
                    class="px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'production_setup' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800' }}">
                <span>🚀</span> Paso a Producción & Certificado
                @if(!empty($productionReadiness['percentage']))
                    <span class="px-2 py-0.5 text-[10px] rounded-full {{ $productionReadiness['is_ready'] ? 'bg-emerald-400 text-emerald-950 font-black' : 'bg-amber-400/20 text-amber-600 dark:text-amber-300 font-bold' }}">
                        {{ $productionReadiness['percentage'] }}%
                    </span>
                @endif
            </button>
            <button wire:click="$set('activeTab', 'test_preview')"
                    class="px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'test_preview' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800' }}">
                <span>🖨️</span> Probar Impresión KuDE & XML
            </button>
            <button wire:click="$set('activeTab', 'settings')"
                    class="px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'settings' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800' }}">
                <span>⚙️</span> Todos los Parámetros
            </button>
            <button wire:click="$set('activeTab', 'history')"
                    class="px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'history' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800' }}">
                <span>📜</span> Comprobantes Emitidos ({{ $totalElectronicCount }})
            </button>
        </div>

        <!-- TAB 1: ESTADO & DIAGNÓSTICO -->
        @if($activeTab === 'status')
            <div class="space-y-8">
                <!-- Métricas principales -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/70 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="text-[11px] font-black uppercase tracking-wider text-slate-400">Emisión en POS</div>
                            <div class="mt-2 text-2xl font-black {{ $sifen_enabled ? 'text-emerald-500' : 'text-slate-400' }} flex items-center gap-2">
                                <span>{{ $sifen_enabled ? 'Activa' : 'Pausada' }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-2">
                                {{ $sifen_enabled ? 'Cada venta genera comprobante con CDC y QR.' : 'Ventas emiten tickets estándar internos.' }}
                            </p>
                        </div>
                        <button wire:click="toggleSifen"
                                type="button"
                                class="mt-4 w-full py-2 px-3 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $sifen_enabled ? 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800' }}">
                            {{ $sifen_enabled ? 'Pausar Emisión' : 'Activar Emisión' }}
                        </button>
                    </div>

                    <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200/70 dark:border-slate-800 shadow-sm">
                        <div class="text-[11px] font-black uppercase tracking-wider text-slate-400">Ambiente DNIT</div>
                        <div class="mt-2 text-xl font-black text-indigo-600 dark:text-indigo-400">
                            {{ strtoupper($sifen_environment) }}
                        </div>
                        <div class="mt-2 flex gap-1.5">
                            <button wire:click="setEnvironment('test')" class="px-2 py-1 text-[10px] font-black rounded-lg border {{ $sifen_environment === 'test' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border-slate-300' }}">Test</button>
                            <button wire:click="setEnvironment('production')" class="px-2 py-1 text-[10px] font-black rounded-lg border {{ $sifen_environment === 'production' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border-slate-300' }}">Producción</button>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/70 dark:border-slate-800 shadow-sm">
                        <div class="text-[11px] font-black uppercase tracking-wider text-slate-400">Último Comprobante</div>
                        <div class="mt-2 text-2xl font-black text-slate-900 dark:text-white tabular-nums">
                            {{ $sifen_establecimiento }}-{{ $sifen_punto_expedicion }}-{{ str_pad($sifen_ultimo_numero, 7, '0', STR_PAD_LEFT) }}
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2">
                            Timbrado N° {{ $sifen_timbrado }} (Serie {{ $sifen_serie }})
                        </p>
                    </div>

                    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/70 dark:border-slate-800 shadow-sm">
                        <div class="text-[11px] font-black uppercase tracking-wider text-slate-400">Total DTEs Emitidos</div>
                        <div class="mt-2 text-2xl font-black text-amber-500 tabular-nums">
                            {{ $totalElectronicCount }}
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2">
                            {{ $totalTestCount }} en modo prueba / homologación
                        </p>
                    </div>
                </div>

                <!-- Callout hacia Paso a Producción -->
                <div class="bg-gradient-to-r from-emerald-950/60 via-slate-900 to-indigo-950/50 p-6 rounded-3xl border border-emerald-500/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl shrink-0">
                            🚀
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">¿Ya tienes el Certificado Digital y Timbrado real de tu negocio?</h4>
                            <p class="text-xs text-slate-300 mt-0.5">
                                Accede al nuevo apartado para cargar tu archivo <strong>.p12</strong>, tu <strong>CSC</strong> oficial y tu <strong>Timbrado</strong> definitivo.
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('activeTab', 'production_setup')"
                            type="button"
                            class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl transition shadow-lg shrink-0">
                        Ir al Asistente de Producción
                    </button>
                </div>

                <!-- Tarjeta de Diagnóstico y Conectividad con Servidor SIFEN Test -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-8 shadow-sm space-y-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                Conectividad Web Services SIFEN (DNIT Paraguay)
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">
                                Verifica si el servidor local o VPS tiene acceso directo por HTTPS a los endpoints oficiales de recepción del SIFEN.
                            </p>
                        </div>
                        <button wire:click="testConnection"
                                type="button"
                                wire:loading.attr="disabled"
                                class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-wider transition shadow-md shadow-indigo-600/20 flex items-center gap-2">
                            <span wire:loading wire:target="testConnection" class="animate-spin text-sm">⏳</span>
                            <span wire:loading.remove wire:target="testConnection">📡</span>
                            Probar Conexión con SIFEN Test
                        </button>
                    </div>

                    @if($connectionTestResult)
                        <div class="p-5 rounded-2xl border {{ $connectionTestResult['success'] ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-900 dark:text-emerald-300' : 'bg-rose-500/10 border-rose-500/30 text-rose-900 dark:text-rose-300' }} space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-black text-xs uppercase tracking-wider flex items-center gap-2">
                                    {{ $connectionTestResult['success'] ? '✓ Conexión Exitosa con SIFEN' : '⚠️ Error de Comunicación con SIFEN' }}
                                </span>
                                <span class="text-xs font-mono font-bold">{{ $connectionTestResult['latency'] }}</span>
                            </div>
                            <div class="text-xs">{{ $connectionTestResult['message'] }}</div>
                            <div class="text-[10px] font-mono opacity-80 truncate">Endpoint probado: {{ $connectionTestResult['endpoint'] }}</div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 bg-slate-50 dark:bg-slate-950/60 rounded-2xl border border-slate-200/60 dark:border-slate-800 text-xs space-y-2">
                            <div class="font-bold text-slate-700 dark:text-slate-300">Ambiente de Pruebas (Test / Homologación):</div>
                            <div class="font-mono text-[11px] text-slate-500">https://sifen-test.set.gov.py/de/ws/sync/recibe.wsdl?wsdl</div>
                            <div class="text-[11px] text-slate-400">Consulta QR Test: https://ekuatia.set.gov.py/consultas-test/qr</div>
                        </div>
                        <div class="p-4 bg-slate-50 dark:bg-slate-950/60 rounded-2xl border border-slate-200/60 dark:border-slate-800 text-xs space-y-2">
                            <div class="font-bold text-slate-700 dark:text-slate-300">Ambiente de Producción:</div>
                            <div class="font-mono text-[11px] text-slate-500">https://sifen.set.gov.py/de/ws/sync/recibe.wsdl?wsdl</div>
                            <div class="text-[11px] text-slate-400">Consulta QR Prod: https://ekuatia.set.gov.py/consultas/qr</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB 2: PASO A PRODUCCIÓN & CERTIFICADO DIGITAL (NUEVO APARTADO) -->
        @if($activeTab === 'production_setup')
            <div class="space-y-8">
                
                <!-- Tarjeta de Bienvenida y Progreso de Requisitos -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-8 shadow-sm space-y-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-wider border border-emerald-500/20">
                                    Paso a Producción Oficial
                                </span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                Checklist de Requisitos para Facturar en Real
                            </h3>
                            <p class="text-xs text-slate-500">
                                Para emitir comprobantes tributarios con validez jurídica ante la DNIT necesitas cargar estos 4 elementos oficiales:
                            </p>
                        </div>

                        <!-- Barra de Progreso Circular / Porcentaje -->
                        <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-800 flex items-center gap-4 shrink-0">
                            <div>
                                <div class="text-[10px] font-black uppercase text-slate-400">Progreso Total</div>
                                <div class="text-2xl font-black {{ $productionReadiness['percentage'] === 100 ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ $productionReadiness['percentage'] }}%
                                </div>
                            </div>
                            <div class="w-32 bg-slate-200 dark:bg-slate-800 h-3 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $productionReadiness['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cuadrícula de Verificación de Requisitos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                        @foreach($productionReadiness['checks'] ?? [] as $check)
                            <div class="p-5 rounded-2xl border transition {{ $check['status'] ? 'bg-emerald-50/40 border-emerald-200/80 dark:bg-emerald-950/20 dark:border-emerald-900/40' : 'bg-slate-50 border-slate-200/70 dark:bg-slate-950/40 dark:border-slate-800' }}">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-slate-200">
                                        {{ $check['title'] }}
                                    </span>
                                    @if($check['status'])
                                        <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">✓</span>
                                    @else
                                        <span class="w-6 h-6 rounded-full bg-amber-400/20 text-amber-600 dark:text-amber-400 border border-amber-400/40 flex items-center justify-center text-xs font-bold">!</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-500 leading-normal">{{ $check['description'] }}</p>
                                <div class="mt-3 text-[10px] font-bold font-mono px-2 py-1 rounded {{ $check['status'] ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-slate-200/70 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                    {{ $check['detail'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- SECCIÓN 1: CARGA DEL CERTIFICADO DIGITAL (.p12 / .pfx) -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-8 shadow-sm space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
                        <span class="w-2.5 h-6 bg-indigo-600 rounded-full"></span>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                1. Cargar Certificado Digital de Firma Electrónica (.p12 / .pfx)
                            </h3>
                            <p class="text-xs text-slate-500">
                                Certificado cualificado de software expedido por un Prestador de Servicios de Confianza (PSC) habilitado en Paraguay (Bancard, E-Firma, etc.).
                            </p>
                        </div>
                    </div>

                    @if($certInfo && ($certInfo['valid'] ?? false))
                        <!-- Certificado Instalado y Verificado -->
                        <div class="p-6 bg-gradient-to-r from-emerald-500/10 via-slate-50 to-slate-50 dark:from-emerald-950/30 dark:via-slate-950 dark:to-slate-950 rounded-3xl border border-emerald-500/30 space-y-4">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-emerald-500/20 shrink-0">
                                        🛡️
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black uppercase text-emerald-700 dark:text-emerald-400">Certificado Instalado y Válido</span>
                                            <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 rounded text-[10px] font-mono font-bold">RSA 2048</span>
                                        </div>
                                        <h4 class="text-base font-black text-slate-900 dark:text-white mt-0.5">{{ $certInfo['subject_cn'] }}</h4>
                                        <p class="text-xs text-slate-500">RUC Vinculado: <strong>{{ $certInfo['subject_serial'] ?: 'Declarado en certificado' }}</strong> | Emisor: {{ $certInfo['issuer_o'] }}</p>
                                    </div>
                                </div>
                                <button wire:click="deleteCertificate"
                                        type="button"
                                        wire:confirm="¿Seguro que deseas eliminar el certificado instalado?"
                                        class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-xl text-xs font-black uppercase tracking-wider transition shrink-0 dark:bg-rose-950/40 dark:border-rose-900/50 dark:text-rose-400">
                                    🗑️ Eliminar Certificado
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                                <div class="p-3 bg-white dark:bg-slate-900 rounded-xl border border-slate-200/60 dark:border-slate-800">
                                    <div class="text-[10px] font-black uppercase text-slate-400">Válido Desde</div>
                                    <div class="font-mono font-bold text-slate-800 dark:text-slate-200 mt-0.5">{{ $certInfo['valid_from'] }}</div>
                                </div>
                                <div class="p-3 bg-white dark:bg-slate-900 rounded-xl border border-slate-200/60 dark:border-slate-800">
                                    <div class="text-[10px] font-black uppercase text-slate-400">Vence El</div>
                                    <div class="font-mono font-bold text-slate-800 dark:text-slate-200 mt-0.5">{{ $certInfo['valid_to'] }}</div>
                                </div>
                                <div class="p-3 bg-white dark:bg-slate-900 rounded-xl border border-slate-200/60 dark:border-slate-800">
                                    <div class="text-[10px] font-black uppercase text-slate-400">Días Restantes</div>
                                    <div class="font-mono font-black {{ $certInfo['days_remaining'] < 30 ? 'text-rose-500' : 'text-emerald-500' }} mt-0.5">
                                        {{ $certInfo['days_remaining'] }} días
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Formulario de Subida del Certificado -->
                        <form wire:submit.prevent="uploadCertificate" class="p-6 bg-slate-50 dark:bg-slate-950/60 rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                                        Selecciona el Archivo .p12 o .pfx
                                    </label>
                                    <input type="file" wire:model="certFile" accept=".p12,.pfx"
                                           class="w-full file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-2 text-xs text-slate-500">
                                    @error('certFile') <span class="text-rose-500 text-xs block mt-1 font-bold">{{ $message }}</span> @enderror
                                    <span class="text-[10px] text-slate-400 block mt-1">Formato PKCS#12 estándar (.p12 o .pfx) entregado por el proveedor de firma.</span>
                                </div>

                                <div>
                                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                                        Contraseña del Certificado
                                    </label>
                                    <input type="password" wire:model="certPasswordInput" placeholder="Ingresa la contraseña de tu certificado"
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-mono font-bold text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    @error('certPasswordInput') <span class="text-rose-500 text-xs block mt-1 font-bold">{{ $message }}</span> @enderror
                                    <span class="text-[10px] text-slate-400 block mt-1">La contraseña se prueba en el servidor para verificar que el par de claves sea válido.</span>
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        class="px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-wider transition shadow-lg shadow-indigo-600/30 flex items-center gap-2">
                                    <span wire:loading wire:target="uploadCertificate" class="animate-spin text-sm">⏳</span>
                                    <span>🔐</span> Instalar y Validar Certificado Digital
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                <!-- SECCIÓN 2: FORMULARIO DE CREDENCIALES OFICIALES DE LA EMPRESA -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-8 shadow-sm space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
                        <span class="w-2.5 h-6 bg-emerald-600 rounded-full"></span>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                2. Cargar Datos Oficiales del Contribuyente (Marangatu / DNIT)
                            </h3>
                            <p class="text-xs text-slate-500">
                                Completa estos campos exactamente como figuran en tu constancia de RUC y en el sistema Marangatu.
                            </p>
                        </div>
                    </div>

                    <form wire:submit.prevent="saveSettings" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">RUC Oficial (sin DV)</label>
                                <input type="text" wire:model="sifen_emisor_ruc" placeholder="Ej: 80012345"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_ruc') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Dígito Verificador (DV)</label>
                                <input type="text" wire:model="sifen_emisor_dv" placeholder="Ej: 2" maxlength="1"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_dv') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Tipo de Contribuyente</label>
                                <select wire:model="sifen_emisor_tipo_contribuyente"
                                        class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                    <option value="1">1 - Persona Física (Unipersonal)</option>
                                    <option value="2">2 - Persona Jurídica (S.A., S.R.L., etc.)</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Razón Social Oficial (Nombre exacto en RUC)</label>
                                <input type="text" wire:model="sifen_emisor_razon_social" placeholder="Ej: MI EMPRESA S.A."
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_razon_social') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Nombre de Fantasía Comercial</label>
                                <input type="text" wire:model="sifen_emisor_nombre_fantasia" placeholder="Ej: ZonaShop"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">N° Timbrado Oficial DNIT</label>
                                <input type="text" wire:model="sifen_timbrado" placeholder="Ej: 16543210"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_timbrado') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Fecha Inicio de Vigencia</label>
                                <input type="date" wire:model="sifen_timbrado_fecha_inicio"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Establecimiento y Punto (3 dígitos c/u)</label>
                                <div class="flex gap-2">
                                    <input type="text" wire:model="sifen_establecimiento" placeholder="001" maxlength="3"
                                           class="w-1/2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-3 py-3 font-mono font-bold text-center text-sm text-slate-900 dark:text-white">
                                    <input type="text" wire:model="sifen_punto_expedicion" placeholder="001" maxlength="3"
                                           class="w-1/2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-3 py-3 font-mono font-bold text-center text-sm text-slate-900 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">IdCSC Oficial (4 dígitos)</label>
                                <input type="text" wire:model="sifen_id_csc" placeholder="0001" maxlength="4"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-mono font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">Id asignado por Marangatu al solicitar el CSC.</span>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Código Secreto CSC Oficial (32 caracteres)</label>
                                <input type="text" wire:model="sifen_csc" placeholder="Ingresa tu código secreto CSC de 32 caracteres" maxlength="32"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-mono font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">Generado en el menú Facturación Electrónica -> Obtener CSC de Marangatu.</span>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Dirección Fiscal Declarada</label>
                                <input type="text" wire:model="sifen_emisor_direccion" placeholder="Calle principal y número"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Teléfono & Correo</label>
                                <input type="text" wire:model="sifen_emisor_telefono" placeholder="021123456"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white mb-2">
                                <input type="email" wire:model="sifen_emisor_email" placeholder="facturacion@empresa.com.py"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                    class="px-8 py-4 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-wider transition shadow-xl shadow-emerald-600/30 flex items-center gap-2">
                                <span>💾</span> Guardar Credenciales Oficiales
                            </button>
                        </div>
                    </form>
                </div>

                <!-- SECCIÓN 3: ACTIVACIÓN FINAL DE PRODUCCIÓN -->
                <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 rounded-3xl border border-emerald-500/40 p-8 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $sifen_environment === 'production' ? 'bg-emerald-400 animate-ping' : 'bg-amber-400' }}"></span>
                            <span class="text-xs font-black uppercase text-emerald-400 tracking-wider">
                                {{ $sifen_environment === 'production' ? 'SISTEMA OPERANDO EN PRODUCCIÓN' : 'SISTEMA ACTUALMENTE EN MODO PRUEBAS' }}
                            </span>
                        </div>
                        <h4 class="text-xl font-black text-white">
                            {{ $sifen_environment === 'production' ? 'Las ventas en caja emiten facturas oficiales con validez fiscal.' : 'Pasa al entorno de producción oficial cuando estés listo.' }}
                        </h4>
                        <p class="text-xs text-slate-300">
                            En producción oficial, los códigos CDC y QR generados son consultables públicamente en <code class="text-emerald-400">ekuatia.set.gov.py/consultas/</code>.
                        </p>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        @if($sifen_environment !== 'production')
                            <button wire:click="enableProductionMode"
                                    type="button"
                                    wire:confirm="¿Confirmas que deseas pasar al entorno de PRODUCCIÓN OFICIAL? A partir de ahora todos los comprobantes emitidos en el POS tendrán valor fiscal."
                                    class="px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-2xl transition shadow-2xl shadow-emerald-500/40 flex items-center gap-2">
                                <span>🚀</span> ACTIVAR MODO PRODUCCIÓN
                            </button>
                        @else
                            <button wire:click="setEnvironment('test')"
                                    type="button"
                                    class="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-black text-xs uppercase tracking-wider rounded-2xl transition border border-slate-700 flex items-center gap-2">
                                <span>🧪</span> Regresar a Modo Pruebas
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        @endif

        <!-- TAB 3: PROBAR IMPRESIÓN KUDE & XML -->
        @if($activeTab === 'test_preview')
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Columna Izquierda: Panel de Acciones de Prueba -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-6 shadow-sm space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                                <span>🧪</span> Comprobante de Prueba
                            </h3>
                            <button wire:click="generateNewTestDoc"
                                    type="button"
                                    class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                                🔄 Regenerar
                            </button>
                        </div>
                        <p class="text-xs text-slate-500">
                            Genera instantáneamente un CDC oficial de 44 dígitos, calcula el Módulo 11 de la DNIT, genera el Hash SHA-256 del QR y construye el XML v150 para que puedas probar la impresión en tu impresora térmica o visor PDF sin tocar ventas reales.
                        </p>

                        <!-- Botones de Impresión de Prueba -->
                        <div class="space-y-3 pt-2">
                            <a href="{{ route('master.sifen.print-test') }}"
                               target="_blank"
                               class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-wider transition shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-3">
                                <span>🖨️</span> Imprimir KuDE Térmico (80mm)
                            </a>
                            <a href="{{ route('master.sifen.print-test-a4') }}"
                               target="_blank"
                               class="w-full py-3.5 px-4 bg-slate-800 hover:bg-slate-700 text-white dark:bg-slate-800 dark:hover:bg-slate-700 rounded-2xl font-black text-xs uppercase tracking-wider transition flex items-center justify-center gap-3 border border-slate-700">
                                <span>📄</span> Ver Formato Completo A4
                            </a>
                            <button wire:click="viewXml($testDocument['xml'])"
                                    type="button"
                                    class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800/60 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-2xl font-black text-xs uppercase tracking-wider transition flex items-center justify-center gap-3">
                                <span>📑</span> Ver XML Oficial DE_v150
                            </button>
                        </div>

                        <!-- Datos del CDC Generado -->
                        @if($testDocument)
                            <div class="p-4 bg-slate-50 dark:bg-slate-950/70 rounded-2xl border border-slate-200/60 dark:border-slate-800 space-y-2 text-xs">
                                <div class="text-[10px] font-black uppercase text-slate-400">CDC Oficial Generado (44 dígitos):</div>
                                <div class="font-mono text-[11px] font-bold text-indigo-600 dark:text-indigo-400 break-all select-all">
                                    {{ $testDocument['cdc_formatted'] }}
                                </div>
                                <div class="text-[10px] font-black uppercase text-slate-400 pt-2">URL de Consulta QR:</div>
                                <div class="font-mono text-[9px] text-slate-500 break-all select-all">
                                    {{ $testDocument['qr_url'] }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Columna Derecha: Vista previa en vivo del Ticket KuDE Térmico (80mm) -->
                <div class="lg:col-span-7 flex justify-center">
                    <div class="w-[360px] bg-white text-black p-6 rounded-2xl shadow-2xl border-4 border-slate-300/80 font-mono text-[11px] leading-tight space-y-3 relative">
                        
                        <!-- Banner de Prueba Reglamentario SIFEN -->
                        <div class="bg-amber-100 border border-amber-300 p-2 text-center text-[10px] font-bold text-amber-900 rounded mb-2">
                            *** AMBIENTE DE PRUEBA ***<br>
                            SIN VALOR COMERCIAL NI FISCAL
                        </div>

                        <!-- Encabezado KuDE -->
                        <div class="text-center space-y-1 pb-2 border-b border-dashed border-gray-400">
                            <div class="text-xs font-black uppercase tracking-wider">KuDE DE FACTURA ELECTRÓNICA</div>
                            <div class="font-bold text-xs">{{ $testDocument['razon_social'] ?? 'EMPRESA DEMO SIFEN' }}</div>
                            <div>RUC: {{ $testDocument['emisor_ruc'] ?? '44444401-7' }}</div>
                            <div>{{ $sifen_emisor_direccion }}</div>
                            <div>Tel: {{ $sifen_emisor_telefono }} | {{ $sifen_emisor_ciudad_desc }}</div>
                        </div>

                        <!-- Timbrado y Factura -->
                        <div class="space-y-1 pb-2 border-b border-dashed border-gray-400 text-[10px]">
                            <div>Timbrado N°: <strong>{{ $testDocument['timbrado'] }}</strong></div>
                            <div>Factura Electrónica N°: <strong>{{ $testDocument['numero_factura'] }}</strong></div>
                            <div>Fecha / Hora: {{ $testDocument['fecha_emision'] }}</div>
                            <div>Condición: {{ $testDocument['condicion'] }}</div>
                            <div>Receptor: {{ $testDocument['cliente'] }}</div>
                            <div>RUC / CI: {{ $testDocument['cliente_ruc'] }}</div>
                        </div>

                        <!-- Tabla de Ítems -->
                        <table class="w-full text-[10px]">
                            <thead>
                                <tr class="border-b border-gray-400">
                                    <th class="text-left py-1">Cant</th>
                                    <th class="text-left py-1">Detalle</th>
                                    <th class="text-right py-1">Precio</th>
                                    <th class="text-right py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($testDocument['items'] ?? [] as $item)
                                    <tr class="align-top">
                                        <td class="py-1">{{ $item['quantity'] }}</td>
                                        <td class="py-1 pr-1 truncate max-w-[140px]">{{ $item['name'] }}</td>
                                        <td class="py-1 text-right">{{ number_format($item['price'], 0, '', '.') }}</td>
                                        <td class="py-1 text-right">{{ number_format($item['subtotal'], 0, '', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Totales y Liquidación IVA -->
                        <div class="pt-2 border-t border-dashed border-gray-400 space-y-1">
                            <div class="flex justify-between font-bold text-xs">
                                <span>TOTAL A PAGAR:</span>
                                <span>Gs. {{ number_format($testDocument['total'], 0, '', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] text-gray-700">
                                <span>Liquidación IVA 10%:</span>
                                <span>Gs. {{ number_format($testDocument['total_iva'], 0, '', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] text-gray-700">
                                <span>Liquidación IVA 5%:</span>
                                <span>Gs. 0</span>
                            </div>
                            <div class="flex justify-between text-[10px] text-gray-700">
                                <span>Exentas:</span>
                                <span>Gs. 0</span>
                            </div>
                        </div>

                        <!-- Bloque Código QR y CDC Oficial -->
                        <div class="pt-3 border-t border-dashed border-gray-400 text-center space-y-2">
                            <div class="flex justify-center">
                                <div class="w-32 h-32 flex items-center justify-center p-1 bg-white border border-gray-300 rounded">
                                    {!! $testDocument['qr_svg'] !!}
                                </div>
                            </div>
                            <div class="text-[9px] text-gray-600">
                                Consulte la validez de este comprobante en:<br>
                                <span class="text-indigo-600 underline">https://ekuatia.set.gov.py/consultas-test/</span>
                            </div>
                            <div class="text-[9px] font-bold tracking-widest text-gray-800 break-all bg-gray-100 p-1.5 rounded">
                                CDC: {{ $testDocument['cdc_formatted'] }}
                            </div>
                            <div class="text-[8px] text-gray-500 leading-normal">
                                ESTE DOCUMENTO ES UNA REPRESENTACIÓN GRÁFICA DE UN DOCUMENTO ELECTRÓNICO (XML)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB 4: TODOS LOS PARÁMETROS -->
        @if($activeTab === 'settings')
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-8 shadow-sm space-y-8">
                <form wire:submit.prevent="saveSettings" class="space-y-8">
                    
                    <!-- Sección Timbrado -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                            <span class="w-2 h-4 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-white">
                                1. Timbrado y Puntos de Expedición (SIFEN)
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">N° de Timbrado</label>
                                <input type="text" wire:model="sifen_timbrado"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_timbrado') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Inicio Vigencia</label>
                                <input type="date" wire:model="sifen_timbrado_fecha_inicio"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_timbrado_fecha_inicio') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Establecimiento (3 dígitos)</label>
                                <input type="text" wire:model="sifen_establecimiento" placeholder="001"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_establecimiento') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Punto Expedición (3 dígitos)</label>
                                <input type="text" wire:model="sifen_punto_expedicion" placeholder="001"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_punto_expedicion') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Serie (2 letras, ej: AA)</label>
                                <input type="text" wire:model="sifen_serie" placeholder="AA" maxlength="2"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white uppercase">
                                @error('sifen_serie') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Último N° Emitido</label>
                                <input type="number" wire:model="sifen_ultimo_numero"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_ultimo_numero') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección Datos del Emisor -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                            <span class="w-2 h-4 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-white">
                                2. Datos del Contribuyente Emisor (Registrado ante DNIT)
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">RUC Emisor (sin DV)</label>
                                <input type="text" wire:model="sifen_emisor_ruc" placeholder="44444401"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_ruc') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Dígito Verificador (DV)</label>
                                <input type="text" wire:model="sifen_emisor_dv" placeholder="7" maxlength="1"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_dv') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Tipo Contribuyente</label>
                                <select wire:model="sifen_emisor_tipo_contribuyente"
                                        class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                    <option value="1">1 - Persona Física</option>
                                    <option value="2">2 - Persona Jurídica</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Razón Social</label>
                                <input type="text" wire:model="sifen_emisor_razon_social"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">En ambiente de prueba, la DNIT exige obligatoriamente: "DOCUMENTO ELECTRÓNICO SIN VALOR COMERCIAL NI FISCAL - GENERADO EN AMBIENTE DE PRUEBA"</span>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Nombre de Fantasía</label>
                                <input type="text" wire:model="sifen_emisor_nombre_fantasia"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Dirección del Local</label>
                                <input type="text" wire:model="sifen_emisor_direccion"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Teléfono & Correo</label>
                                <input type="text" wire:model="sifen_emisor_telefono" placeholder="021123456"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white mb-2">
                                <input type="email" wire:model="sifen_emisor_email" placeholder="facturacion@empresa.com.py"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Código Actividad Económica</label>
                                <input type="text" wire:model="sifen_emisor_actividad_codigo" placeholder="47111"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Descripción Actividad Económica</label>
                                <input type="text" wire:model="sifen_emisor_actividad_desc"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Sección Código de Seguridad (CSC) para Código QR -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                            <span class="w-2 h-4 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-white">
                                3. Código de Seguridad del Contribuyente (CSC) para Hash del Código QR
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">IdCSC (4 dígitos)</label>
                                <input type="text" wire:model="sifen_id_csc" placeholder="0001" maxlength="4"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-mono font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">Por defecto en test: 0001</span>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1.5">Código Secreto CSC (32 caracteres alfanuméricos)</label>
                                <input type="text" wire:model="sifen_csc" placeholder="ABCD0000000000000000000000000000" maxlength="32"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3 font-mono font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">Valor oficial de test de la DNIT: ABCD0000000000000000000000000000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                                class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-wider transition shadow-xl shadow-indigo-600/30 flex items-center gap-2">
                            <span>💾</span> Guardar Parámetros SIFEN
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- TAB 5: HISTORIAL DE COMPROBANTES EMITIDOS -->
        @if($activeTab === 'history')
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800 p-8 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">
                            Documentos Tributarios Electrónicos Emitidos
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Listado de facturas procesadas con CDC oficial de 44 dígitos y código QR.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-3">Fecha</th>
                                <th class="py-3 px-3">N° Factura</th>
                                <th class="py-3 px-3">CDC (Código de Control)</th>
                                <th class="py-3 px-3">Cliente</th>
                                <th class="py-3 px-3 text-right">Total (Gs.)</th>
                                <th class="py-3 px-3 text-center">Estado</th>
                                <th class="py-3 px-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 font-semibold">
                            @forelse($electronicSales as $sale)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition">
                                    <td class="py-3 px-3 text-slate-500 font-mono text-[11px]">
                                        {{ $sale->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-900 dark:text-white font-black font-mono">
                                        {{ $sale->sifen_numero_factura ?: $sale->invoice_number }}
                                    </td>
                                    <td class="py-3 px-3 font-mono text-[10px] text-indigo-600 dark:text-indigo-400 max-w-[200px] truncate" title="{{ $sale->sifen_cdc }}">
                                        {{ $sale->formatted_cdc ?: $sale->sifen_cdc }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-700 dark:text-slate-300">
                                        {{ $sale->customer ? $sale->customer->name : 'Consumidor Final' }}
                                    </td>
                                    <td class="py-3 px-3 text-right font-black text-slate-900 dark:text-white">
                                        {{ format_pyg($sale->total) }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if($sale->sifen_estado === 'aprobado_test')
                                            <span class="px-2.5 py-1 bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 rounded-full text-[10px] font-black uppercase border border-yellow-500/20">
                                                Aprobado Test
                                            </span>
                                        @elseif($sale->sifen_estado === 'aprobado')
                                            <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full text-[10px] font-black uppercase border border-emerald-500/20">
                                                Aprobado SIFEN
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 bg-slate-500/10 text-slate-600 rounded-full text-[10px] font-black uppercase">
                                                {{ ucfirst($sale->sifen_estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-right space-x-2">
                                        <a href="{{ route('sales.ticket', $sale->id) }}"
                                           target="_blank"
                                           class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-[10px] font-black uppercase tracking-wider inline-flex items-center gap-1"
                                           title="Imprimir KuDE">
                                            🖨️ KuDE
                                        </a>
                                        @if($sale->sifen_xml)
                                            <button wire:click="viewXml({{ json_encode($sale->sifen_xml) }})"
                                                    type="button"
                                                    class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/40 dark:hover:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl text-[10px] font-black uppercase tracking-wider">
                                                XML
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-400 text-xs">
                                        No se han emitido documentos electrónicos todavía.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pt-4">
                    {{ $electronicSales->links() }}
                </div>
            </div>
        @endif

        <!-- Modal para Visualizar XML Oficial -->
        @if($showXmlModal)
            <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
                <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-4xl w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span>📑</span> Archivo XML Oficial (Schema DE_v150 SIFEN)
                        </h3>
                        <button wire:click="closeXmlModal" class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
                    </div>
                    <div class="bg-slate-950 p-4 rounded-2xl overflow-x-auto max-h-[60vh]">
                        <pre class="text-[11px] font-mono text-emerald-400 whitespace-pre">{{ $selectedSaleXml }}</pre>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button wire:click="closeXmlModal"
                                class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-bold text-xs uppercase">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
