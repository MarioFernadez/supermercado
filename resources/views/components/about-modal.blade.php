<div x-data="{ show: false }"
     @open-about-modal.window="show = true"
     @keydown.escape.window="show = false"
     x-cloak>

    {{-- Backdrop --}}
    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[99999] bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">

        {{-- Dialog Box --}}
        <div x-show="show"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.away="show = false"
             class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden font-sans relative">

            {{-- Ambient glow --}}
            <div class="absolute -top-10 -right-10 w-36 h-36 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>

            {{-- Header --}}
            <div class="bg-gradient-to-r from-[#1e282c] to-[#253238] px-6 py-5 text-white flex items-center justify-between border-b border-slate-700/80">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#25b9d7] to-emerald-400 flex items-center justify-center text-white font-black text-lg shadow-md">
                        ZS
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-black tracking-tight">ZonaShop / ZonaPOS</h3>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-[#25b9d7]/20 text-[#25b9d7] border border-[#25b9d7]/40">
                                v2.5 Pro
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-300 font-medium mt-0.5">Sistema Integral de Gestión Comercial</p>
                    </div>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-lg hover:bg-slate-700/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 space-y-5 text-xs text-slate-600 dark:text-slate-300">

                {{-- Sistema Dual POS + E-commerce --}}
                <div class="bg-slate-50 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/70">
                    <h4 class="text-[11px] font-black uppercase tracking-wider text-slate-800 dark:text-slate-100 mb-2 flex items-center gap-1.5">
                        <span>🎯</span> Modalidad de Operación Dual
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                        <div class="bg-white dark:bg-slate-900 p-3 rounded-xl border border-slate-200/80 dark:border-slate-800">
                            <p class="font-bold text-slate-900 dark:text-white flex items-center gap-1 text-xs">
                                ⚡ <span>Punto de Venta (POS)</span>
                            </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-snug">
                                Ventas rápidas en mostrador, lectores de código de barra, balanzas, tickets y control de caja.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-slate-900 p-3 rounded-xl border border-slate-200/80 dark:border-slate-800">
                            <p class="font-bold text-slate-900 dark:text-white flex items-center gap-1 text-xs">
                                🌐 <span>Tienda Online Web</span>
                            </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-snug">
                                Catálogo e-commerce con recepción de pedidos por WhatsApp sincronizado en tiempo real.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Desarrollador y Contacto --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Producto Digital Desarrollado Por</span>
                        <span class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                            Soteweb Tecnología
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/595981762444?text=Hola%20Soteweb,%20solicito%20asistencia%20sobre%20ZonaShop"
                           target="_blank"
                           class="flex items-center gap-2.5 p-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 transition group">
                            <span class="text-base">📲</span>
                            <div class="truncate">
                                <p class="text-[9.5px] uppercase font-bold text-emerald-600 dark:text-emerald-400">WhatsApp Directo</p>
                                <p class="font-bold text-xs font-mono">+595 981 762444</p>
                            </div>
                        </a>

                        {{-- Correo --}}
                        <a href="mailto:dominios@soteweb.com"
                           class="flex items-center gap-2.5 p-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:hover:bg-blue-900/50 border border-blue-200 dark:border-blue-800/60 text-blue-800 dark:text-blue-300 transition group">
                            <span class="text-base">✉️</span>
                            <div class="truncate">
                                <p class="text-[9.5px] uppercase font-bold text-blue-600 dark:text-blue-400">Correo Electrónico</p>
                                <p class="font-bold text-xs truncate">dominios@soteweb.com</p>
                            </div>
                        </a>

                        {{-- Ubicación --}}
                        <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <span class="text-base">📍</span>
                            <div>
                                <p class="text-[9.5px] uppercase font-bold text-slate-400">Ubicación</p>
                                <p class="font-bold text-xs text-slate-700 dark:text-slate-200">Encarnación, Paraguay 🇵🇾</p>
                            </div>
                        </div>

                        {{-- Sitio Web --}}
                        <a href="https://soteweb.com"
                           target="_blank"
                           class="flex items-center gap-2.5 p-2.5 rounded-xl bg-purple-50 hover:bg-purple-100 dark:bg-purple-950/40 dark:hover:bg-purple-900/50 border border-purple-200 dark:border-purple-800/60 text-purple-800 dark:text-purple-300 transition">
                            <span class="text-base">🌐</span>
                            <div class="truncate">
                                <p class="text-[9.5px] uppercase font-bold text-purple-600 dark:text-purple-400">Sitio Web Oficial</p>
                                <p class="font-bold text-xs truncate">soteweb.com ↗</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="bg-slate-50 dark:bg-slate-950/60 px-6 py-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <p class="text-[10px] text-slate-400 font-mono">
                    © {{ date('Y') }} Soteweb Tecnología. Todos los derechos reservados.
                </p>
                <button @click="show = false"
                        type="button"
                        class="px-4 py-1.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 font-bold text-xs rounded-xl transition">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
