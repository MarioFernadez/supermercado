<div class="py-10 bg-slate-50 min-h-screen font-sans dark:bg-slate-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(!$isMasterEnabled)
            <!-- MÓDULO BLOQUEADO POR EL MASTER -->
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 p-12 text-center shadow-xl space-y-4 max-w-2xl mx-auto my-12">
                <div class="w-20 h-20 rounded-3xl bg-amber-500/10 text-amber-500 mx-auto flex items-center justify-center text-4xl shadow-inner border border-amber-500/20">
                    🔒
                </div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Módulo de Facturación Electrónica Inactivo
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-lg mx-auto">
                    El servicio de facturación electrónica integrada con <strong>SIFEN (DNIT Paraguay)</strong> no se encuentra habilitado para su cuenta o plan actual.
                </p>
                <div class="pt-4">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                        Comuníquese con el administrador del sistema (Master) para solicitar la activación de este módulo.
                    </p>
                </div>
            </div>
        @else
            <!-- CABECERA PRINCIPAL CLIENTE COMPACTA -->
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 px-6 py-4 rounded-2xl shadow-lg border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 relative overflow-hidden">
                <div class="space-y-1 relative z-10">
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-black text-white tracking-tight">
                            Facturación Electrónica Nacional
                        </h1>
                        <span class="px-2 py-0.5 bg-indigo-500/20 text-indigo-300 text-[10px] font-black uppercase tracking-wider rounded-md border border-indigo-400/30">
                            SIFEN v150
                        </span>
                        @if($sifen_environment === 'test')
                            <span class="px-2 py-0.5 bg-amber-400/20 text-amber-300 text-[10px] font-black uppercase tracking-wider rounded-md border border-amber-400/30">
                                🧪 Pruebas
                            </span>
                        @else
                            <span class="px-2 py-0.5 bg-emerald-400/20 text-emerald-300 text-[10px] font-black uppercase tracking-wider rounded-md border border-emerald-400/30">
                                🛡️ Producción
                            </span>
                        @endif
                    </div>
                    <p class="text-slate-400 text-xs font-medium">
                        Emisión con CDC y Códigos QR según la normativa de la DNIT Paraguay.
                    </p>
                </div>

                <!-- Interruptor Principal Activar / Desactivar Facturación -->
                <div class="flex items-center gap-2 relative z-10 shrink-0">
                    <button wire:click="toggleSifen"
                            type="button"
                            class="px-4 py-2 rounded-xl font-black text-xs uppercase tracking-wider transition shadow flex items-center gap-2 border {{ $sifen_enabled ? 'bg-emerald-600 hover:bg-emerald-500 text-white border-emerald-400/40 shadow-emerald-900/40' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 border-slate-700' }}">
                        <span class="relative flex h-2.5 w-2.5">
                            @if($sifen_enabled)
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                            @endif
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $sifen_enabled ? 'bg-emerald-200' : 'bg-slate-500' }}"></span>
                        </span>
                        <span>{{ $sifen_enabled ? 'Activa en POS' : 'Inactiva' }}</span>
                    </button>

                    <div class="flex items-center gap-1 bg-slate-950/60 p-0.5 rounded-xl border border-slate-800 text-[10px] font-bold">
                        <button wire:click="setEnvironment('test')"
                                class="px-2.5 py-1 rounded-lg transition {{ $sifen_environment === 'test' ? 'bg-amber-500 text-slate-950 font-black' : 'text-slate-400 hover:text-white' }}">
                            Test
                        </button>
                        <button wire:click="setEnvironment('production')"
                                class="px-2.5 py-1 rounded-lg transition {{ $sifen_environment === 'production' ? 'bg-emerald-500 text-slate-950 font-black' : 'text-slate-400 hover:text-white' }}">
                            Producción
                        </button>
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✓</span>
                        <span class="text-xs font-bold">{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            <!-- SECCIÓN 1: APARTADO DE PRUEBAS (MIENTRAS NO TENGAS TUS DATOS OFICIALES) -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-full text-[10px] font-black uppercase tracking-wider border border-amber-500/20">
                                Simulador & Test
                            </span>
                            <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                Probar con Datos de Prueba
                            </h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            ¿Aún no tienes tu RUC o Timbrado de la SET? Carga los datos de prueba de la DNIT con 1 clic para probar ventas y emisión de tickets térmicos con Código QR.
                        </p>
                    </div>

                    <!-- Botones de Acción de Prueba -->
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <button wire:click="loadTestData"
                                type="button"
                                class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-black uppercase tracking-wider transition shadow-sm flex items-center gap-1.5">
                            <span>⚡</span> Cargar Datos de Prueba
                        </button>

                        <button wire:click="clearTestData"
                                type="button"
                                wire:confirm="¿Deseas limpiar los datos de prueba para ingresar los datos reales de tu negocio?"
                                class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-black uppercase tracking-wider transition flex items-center gap-1.5">
                            <span>🧹</span> Limpiar Datos de Prueba
                        </button>

                        <a href="{{ route('master.sifen.print-test') }}"
                           target="_blank"
                           class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-black uppercase tracking-wider transition shadow-sm flex items-center gap-1.5">
                            <span>🖨️</span> Imprimir Ticket de Prueba (80mm)
                        </a>
                    </div>
                </div>

                @if($sifen_environment === 'test')
                    <div class="p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/40 rounded-2xl flex items-center gap-3 text-xs text-amber-800 dark:text-amber-300">
                        <span class="text-xl">⚠️</span>
                        <div>
                            <strong>Modo Pruebas Activado:</strong> Las facturas y tickets emitidos llevan el aviso legal obligatorio: <em>"DOCUMENTO ELECTRÓNICO SIN VALOR COMERCIAL NI FISCAL - GENERADO EN AMBIENTE DE PRUEBA"</em>.
                        </div>
                    </div>
                @endif
            </div>

            <!-- SECCIÓN 2: FORMULARIO SIMPLE PARA COMPLETAR LOS DATOS QUE FALTAN -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-8">
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📝</span> Mis Datos Fiscales & Credenciales Oficiales
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Cuando hayas obtenido tus credenciales oficiales de la DNIT y Marangatu, completa estos campos y guarda los cambios.
                    </p>
                </div>

                <form wire:submit.prevent="saveSettings" class="space-y-8">
                    
                    <!-- A. DATOS DE LA EMPRESA -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                            <span>🏢</span> A. Datos de tu Negocio / Empresa
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">RUC Oficial (sin guión)</label>
                                <input type="text" wire:model="sifen_emisor_ruc" placeholder="Ej: 80012345"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_ruc') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Dígito Verificador (DV)</label>
                                <input type="text" wire:model="sifen_emisor_dv" placeholder="Ej: 2" maxlength="1"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_dv') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Tipo Contribuyente</label>
                                <select wire:model="sifen_emisor_tipo_contribuyente"
                                        class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                                    <option value="1">Persona Física (Unipersonal)</option>
                                    <option value="2">Persona Jurídica (Empresa S.A./S.R.L.)</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Razón Social Oficial (Nombre exacto en RUC)</label>
                                <input type="text" wire:model="sifen_emisor_razon_social" placeholder="Ej: COMERCIAL EL SOL S.A."
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_emisor_razon_social') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Nombre Comercial de Fantasía</label>
                                <input type="text" wire:model="sifen_emisor_nombre_fantasia" placeholder="Ej: Supermercado El Sol"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Dirección del Local</label>
                                <input type="text" wire:model="sifen_emisor_direccion" placeholder="Calle y número del local"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Ciudad</label>
                                <input type="text" wire:model="sifen_emisor_ciudad_desc" placeholder="Ej: Asunción"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- B. DATOS DEL TIMBRADO -->
                    <div class="space-y-4 pt-2">
                        <h4 class="text-xs font-black uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                            <span>📄</span> B. Timbrado Oficial de Facturación Electrónica (DNIT)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">N° Timbrado</label>
                                <input type="text" wire:model="sifen_timbrado" placeholder="Ej: 16543210"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                                @error('sifen_timbrado') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Inicio de Vigencia</label>
                                <input type="date" wire:model="sifen_timbrado_fecha_inicio"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-bold text-sm text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Establecimiento (3 dígitos)</label>
                                <input type="text" wire:model="sifen_establecimiento" placeholder="001" maxlength="3"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-mono font-bold text-center text-sm text-slate-900 dark:text-white">
                                @error('sifen_establecimiento') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Punto Expedición (3 dígitos)</label>
                                <input type="text" wire:model="sifen_punto_expedicion" placeholder="001" maxlength="3"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-mono font-bold text-center text-sm text-slate-900 dark:text-white">
                                @error('sifen_punto_expedicion') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- C. CÓDIGO SECRETO DEL CONTRIBUYENTE (CSC) -->
                    <div class="space-y-4 pt-2">
                        <h4 class="text-xs font-black uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                            <span>🔑</span> C. Código Secreto del Contribuyente (CSC - Marangatu)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">IdCSC (4 dígitos)</label>
                                <input type="text" wire:model="sifen_id_csc" placeholder="0001" maxlength="4"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-mono font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">Normalmente: 0001</span>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Código Secreto CSC (32 caracteres)</label>
                                <input type="text" wire:model="sifen_csc" placeholder="Ingresa tu código secreto CSC otorgado por Marangatu" maxlength="32"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 font-mono font-bold text-sm text-slate-900 dark:text-white">
                                <span class="text-[10px] text-slate-400">Se obtiene en Marangatu en: Facturación Electrónica -> Obtener CSC.</span>
                            </div>
                        </div>
                    </div>

                    <!-- D. CERTIFICADO DIGITAL (.P12/.PFX) -->
                    <div class="space-y-4 pt-2">
                        <h4 class="text-xs font-black uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                            <span>🛡️</span> D. Certificado Digital de Firma Electrónica (.p12 / .pfx)
                        </h4>

                        @if($certInfo && ($certInfo['valid'] ?? false))
                            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">✅</span>
                                    <div>
                                        <div class="text-xs font-bold text-emerald-800 dark:text-emerald-300">Certificado Instalado: {{ $certInfo['subject_cn'] }}</div>
                                        <div class="text-[11px] text-slate-500">Emisor: {{ $certInfo['issuer_o'] }} | Vence: {{ $certInfo['valid_to'] }} ({{ $certInfo['days_remaining'] }} días restantes)</div>
                                    </div>
                                </div>
                                <button wire:click="deleteCertificate"
                                        type="button"
                                        wire:confirm="¿Seguro que deseas quitar el certificado?"
                                        class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold border border-rose-200">
                                    Quitar Certificado
                                </button>
                            </div>
                        @else
                            <div class="p-4 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Archivo de Certificado (.p12 o .pfx)</label>
                                    <input type="file" wire:model="certFile" accept=".p12,.pfx"
                                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                                    @error('certFile') <span class="text-rose-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black uppercase text-slate-500 mb-1">Contraseña del Certificado</label>
                                    <div class="flex gap-2">
                                        <input type="password" wire:model="certPasswordInput" placeholder="Contraseña del archivo .p12"
                                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs">
                                        <button wire:click="uploadCertificate" type="button"
                                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shrink-0">
                                            Instalar
                                        </button>
                                    </div>
                                    @error('certPasswordInput') <span class="text-rose-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- BOTÓN GUARDAR -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <p class="text-xs text-slate-400">
                            * Los cambios surtirán efecto de inmediato en todas las cajas y puntos de venta del negocio.
                        </p>
                        <button type="submit"
                                class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-wider transition shadow-lg shadow-emerald-600/30">
                            💾 Guardar Mis Datos
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</div>
