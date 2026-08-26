<div x-data="{
        isOpen: @entangle('isOpen'),
        openPalette() {
            this.isOpen = true;
            $wire.open();
            this.$nextTick(() => {
                const el = document.getElementById('command-palette-input');
                if (el) el.focus();
            });
        },
        closePalette() {
            this.isOpen = false;
            $wire.close();
        }
    }"
    @keydown.window.prevent.ctrl.k="openPalette()"
    @keydown.window.prevent.cmd.k="openPalette()"
    @open-command-palette.window="openPalette()"
    @keydown.escape.window="closePalette()"
    x-cloak>

    {{-- Backdrop Modal --}}
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] bg-slate-900/60 backdrop-blur-sm flex items-start justify-center pt-16 sm:pt-24 px-4"
         style="display: none;">

        {{-- Dialog Box --}}
        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.away="closePalette()"
             class="w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-250 dark:border-slate-700 overflow-hidden flex flex-col max-h-[80vh]">

            {{-- Search Header --}}
            <div class="flex items-center px-4 py-3.5 border-b border-slate-100 dark:border-slate-800 gap-3">
                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="command-palette-input"
                       type="text"
                       wire:model.live.debounce.150ms="query"
                       placeholder="Escribe una acción, producto, cliente o sección..."
                       class="w-full bg-transparent border-none text-slate-800 dark:text-slate-100 placeholder-slate-400 text-sm focus:outline-none focus:ring-0">
                <kbd class="hidden sm:inline-block px-2 py-0.5 text-[10px] font-mono font-semibold text-slate-400 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded shadow-xs">
                    ESC
                </kbd>
            </div>

            {{-- Results Content --}}
            <div class="flex-1 overflow-y-auto p-2 space-y-4 text-xs scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-700">

                {{-- Secciones y Navegación --}}
                @if(count($filteredNav) > 0)
                <div>
                    <div class="px-3 py-1.5 text-[10px] font-black text-slate-400 uppercase tracking-wider">
                        Navegación y Acciones
                    </div>
                    <div class="space-y-0.5">
                        @foreach($filteredNav as $item)
                        <a href="{{ $item['url'] }}"
                           wire:navigate
                           @click="closePalette()"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:text-indigo-600 dark:hover:text-indigo-400 transition group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-base">{{ $item['icon'] }}</span>
                                <span class="font-semibold text-xs">{{ $item['title'] }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-mono bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 group-hover:text-indigo-600">
                                {{ $item['category'] }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Productos Encontrados --}}
                @if(count($products) > 0)
                <div>
                    <div class="px-3 py-1.5 text-[10px] font-black text-emerald-500 uppercase tracking-wider flex items-center justify-between">
                        <span>📦 Productos en Inventario</span>
                        <span class="text-[9px] text-slate-400">Total: {{ count($products) }}</span>
                    </div>
                    <div class="space-y-0.5">
                        @foreach($products as $p)
                        <a href="{{ route('products.index') }}?search={{ urlencode($p->sku ?? $p->name) }}"
                           wire:navigate
                           @click="closePalette()"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 transition group">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="p-1 rounded bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 text-xs">📦</span>
                                <div class="truncate">
                                    <p class="font-semibold text-xs text-slate-800 dark:text-slate-100 group-hover:text-emerald-600 truncate">{{ $p->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-mono">{{ $p->sku ?? 'Sin SKU' }}</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                <p class="font-bold text-xs text-slate-900 dark:text-white tabular-nums">₲ {{ number_format($p->price_sale, 0, ',', '.') }}</p>
                                <p class="text-[10px] {{ $p->stock <= $p->min_stock ? 'text-red-500 font-bold' : 'text-slate-400' }}">Stock: {{ $p->stock }} {{ $p->unit_type ?? 'un' }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Clientes Encontrados --}}
                @if(count($customers) > 0)
                <div>
                    <div class="px-3 py-1.5 text-[10px] font-black text-blue-500 uppercase tracking-wider flex items-center justify-between">
                        <span>👥 Clientes</span>
                        <span class="text-[9px] text-slate-400">Total: {{ count($customers) }}</span>
                    </div>
                    <div class="space-y-0.5">
                        @foreach($customers as $c)
                        <a href="{{ route('customers.index') }}?search={{ urlencode($c->name) }}"
                           wire:navigate
                           @click="closePalette()"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-blue-950/40 transition group">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="p-1 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-600 text-xs">👤</span>
                                <div class="truncate">
                                    <p class="font-semibold text-xs text-slate-800 dark:text-slate-100 group-hover:text-blue-600 truncate">{{ $c->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-mono">{{ $c->document_number ?? $c->phone ?? 'Sin doc' }}</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                @if($c->current_balance > 0)
                                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-900/30 px-2 py-0.5 rounded">
                                    Debe: ₲ {{ number_format($c->current_balance, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="text-[10px] text-emerald-600 font-semibold">Al día</span>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Estado Vacío --}}
                @if(trim($query) !== '' && count($filteredNav) === 0 && count($products) === 0 && count($customers) === 0)
                <div class="py-8 text-center text-slate-400">
                    <p class="text-2xl mb-1">🔍</p>
                    <p class="font-semibold text-xs text-slate-600 dark:text-slate-300">No se encontraron resultados para "{{ $query }}"</p>
                    <p class="text-[11px] text-slate-400 mt-1">Prueba con otro término, SKU, número de teléfono o sección.</p>
                </div>
                @endif

            </div>

            {{-- Footer Toolbar --}}
            <div class="px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1"><kbd class="font-mono bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-1.5 py-0.5 rounded shadow-2xs">↵</kbd> seleccionar</span>
                    <span class="flex items-center gap-1"><kbd class="font-mono bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-1.5 py-0.5 rounded shadow-2xs">ESC</kbd> cerrar</span>
                </div>
                <div class="font-mono text-[10px] text-indigo-500 font-bold">
                    ZonaShop Spotlight
                </div>
            </div>

        </div>
    </div>
</div>
