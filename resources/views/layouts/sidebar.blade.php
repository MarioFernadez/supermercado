{{-- Sidebar — Estilo PrestaShop con acordeón --}}
<aside id="sidebar"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    x-data="{ collapsed: localStorage.getItem('sidebar_collapsed') === '1' }"
    x-init="$watch('collapsed', v => localStorage.setItem('sidebar_collapsed', v ? '1' : '0'))"
    :style="collapsed ? 'width:56px' : 'width:224px'"
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-[#0d1424] border-r border-slate-800 transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto overflow-hidden"
    style="width:224px">

    {{-- Logo + Collapse --}}
    <div class="flex items-center justify-between px-4 py-4 border-b border-slate-800 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 min-w-0" x-show="!collapsed">
            <x-application-mark class="h-7 w-auto flex-shrink-0" />
            <div class="flex flex-col leading-none min-w-0">
                <span class="text-white font-black text-[15px] tracking-tight whitespace-nowrap">Zona<span class="text-indigo-400">Shop</span></span>
                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">v2.0</span>
            </div>
        </a>
        <a href="{{ route('dashboard') }}" x-show="collapsed" class="flex items-center justify-center w-full">
            <x-application-mark class="h-7 w-auto flex-shrink-0" />
        </a>
        <button @click="collapsed = !collapsed"
            class="flex-shrink-0 ml-2 p-1 rounded text-slate-500 hover:text-slate-300 hover:bg-slate-800 transition"
            :title="collapsed ? 'Expandir menú' : 'Colapsar menú'">
            <svg x-show="!collapsed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="collapsed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-2 scrollbar-thin scrollbar-thumb-slate-700"
         style="font-family: 'Inter', 'Open Sans', sans-serif; font-size: 13px;">

    @php
        /* ──────────────────────────────────────────────
         * Helper closures for DRY class generation
         * ────────────────────────────────────────────── */
        // Top-level item (direct link, no children)
        $topLink = fn($active) =>
            'flex items-center gap-3 px-4 py-2.5 transition-all duration-150 border-l-[3px] whitespace-nowrap ' .
            ($active
                ? 'bg-slate-800/80 text-white border-indigo-500'
                : 'text-slate-300 hover:bg-slate-800/60 hover:text-white border-transparent');

        // Accordion parent button
        $groupBtn = fn($active) =>
            'w-full flex items-center justify-between px-4 py-2.5 transition-all duration-150 border-l-[3px] whitespace-nowrap ' .
            ($active
                ? 'bg-slate-800/80 text-white border-indigo-500'
                : 'text-slate-300 hover:bg-slate-800/60 hover:text-white border-transparent');

        // Sub-item link
        $subLink = fn($active) =>
            'block px-3 py-1.5 rounded transition-all duration-150 whitespace-nowrap text-[12.5px] ' .
            ($active
                ? 'text-white font-semibold bg-indigo-600/20'
                : 'text-slate-400 hover:text-white hover:bg-slate-800/60');
    @endphp

    {{-- ── Dashboard (directo) ─────────────────────── --}}
    <a href="{{ route('dashboard') }}" wire:navigate
       class="{{ $topLink(request()->routeIs('dashboard')) }}"
       title="Dashboard">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span x-show="!collapsed" class="truncate font-medium">Dashboard</span>
    </a>

    @if(App\Services\LicenseService::isEcommerceEnabled())
    <a href="{{ route('shop.index') }}" target="_blank"
       class="{{ $topLink(false) }}"
       title="Ver Sitio">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        <span x-show="!collapsed" class="truncate font-medium">Ver Sitio</span>
    </a>
    @endif

    {{-- ════════════════════════════════════════════════
         VENTAS  (acordeón)
    ═════════════════════════════════════════════════ --}}
    @php
        $ventasActive = request()->routeIs('pos.*')
            || request()->routeIs('admin.web-orders.*')
            || request()->routeIs('admin.collections')
            || request()->routeIs('customers.*');
    @endphp
    <div x-data="{ open: {{ $ventasActive ? 'true' : 'false' }} }">

        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Ventas' : ''"
                class="{{ $groupBtn($ventasActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M14 4H18a2 2 0 012 2v4M8 21l4-4m0 0l4-4m-4 4V9"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Ventas</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-11 pr-3">
                <a href="{{ route('pos.index') }}" class="{{ $subLink(request()->routeIs('pos.*')) }}">Caja POS (Vender)</a>

                @if(\App\Services\LicenseService::isEcommerceEnabled())
                <a href="{{ route('admin.web-orders.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('admin.web-orders.*')) }}">Pedidos Online</a>
                @endif

                @can('gerente')
                <a href="{{ route('admin.collections') }}" wire:navigate class="{{ $subLink(request()->routeIs('admin.collections')) }}">Cobranzas</a>
                @endcan

                <a href="{{ route('customers.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('customers.*')) }}">Clientes</a>

                @if(hasModule('restaurant'))
                <a href="{{ route('pos.index') }}" class="{{ $subLink(false) }}">🍽️ Mesas / POS</a>
                @endif
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         TIENDA  (acordeón) — solo managers/admins
    ═════════════════════════════════════════════════ --}}
    @can('gerente')
    @php
        $tiendaActive = request()->routeIs('products.*')
            || request()->routeIs('categories.*')
            || request()->routeIs('purchases.*')
            || request()->routeIs('suppliers.*')
            || request()->routeIs('admin.deboning.*');
    @endphp
    <div x-data="{ open: {{ $tiendaActive ? 'true' : 'false' }} }">

        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Tienda' : ''"
                class="{{ $groupBtn($tiendaActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Tienda</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-11 pr-3">
                <a href="{{ route('products.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('products.*')) }}">Productos</a>
                <a href="{{ route('categories.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('categories.*')) }}">Categorías</a>
                <a href="{{ route('purchases.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('purchases.*')) }}">Compras / Entradas</a>
                <a href="{{ route('suppliers.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('suppliers.*')) }}">Proveedores</a>
                @if(hasModule('meat_deboning'))
                <a href="{{ route('admin.deboning.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('admin.deboning.*')) }}">Taller de Desposte</a>
                @endif
            </div>
        </div>
    </div>
    @endcan

    {{-- ════════════════════════════════════════════════
         FINANZAS  (acordeón)
    ═════════════════════════════════════════════════ --}}
    @php
        $finanzasActive = request()->routeIs('expenses.*')
            || request()->routeIs('reports.cash')
            || request()->routeIs('reports.cash-movements');
    @endphp
    <div x-data="{ open: {{ $finanzasActive ? 'true' : 'false' }} }">

        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Finanzas' : ''"
                class="{{ $groupBtn($finanzasActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Finanzas</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-11 pr-3">
                <a href="{{ route('expenses.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('expenses.*')) }}">Gastos</a>
                <a href="{{ route('reports.cash') }}" wire:navigate class="{{ $subLink(request()->routeIs('reports.cash') || request()->routeIs('reports.cash-movements')) }}">Sesiones de Caja</a>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         REPORTES  (acordeón)
    ═════════════════════════════════════════════════ --}}
    @can('gerente')
    @php
        $reportesActive = request()->routeIs('reports.sales')
            || request()->routeIs('reports.salesperson')
            || request()->routeIs('reports.inventory')
            || request()->routeIs('reports.debtors');
    @endphp
    <div x-data="{ open: {{ $reportesActive ? 'true' : 'false' }} }">

        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Reportes' : ''"
                class="{{ $groupBtn($reportesActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Reportes</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-11 pr-3">
                <a href="{{ route('reports.sales') }}" wire:navigate class="{{ $subLink(request()->routeIs('reports.sales')) }}">Detalle de Ventas</a>
                <a href="{{ route('reports.salesperson') }}" wire:navigate class="{{ $subLink(request()->routeIs('reports.salesperson')) }}">Ranking Vendedores</a>
                <a href="{{ route('reports.inventory') }}" wire:navigate class="{{ $subLink(request()->routeIs('reports.inventory')) }}">Estado de Inventario</a>
                <a href="{{ route('reports.debtors') }}" wire:navigate class="{{ $subLink(request()->routeIs('reports.debtors')) }}">Saldos de Clientes</a>
            </div>
        </div>
    </div>
    @endcan

    {{-- ════════════════════════════════════════════════
         CONFIGURACIÓN  (acordeón)
    ═════════════════════════════════════════════════ --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
    @php
        $configActive = request()->routeIs('settings.*')
            || request()->routeIs('branches.*')
            || request()->routeIs('cash_registers.*')
            || request()->routeIs('users.*')
            || request()->routeIs('sellers.*')
            || request()->routeIs('pages.*')
            || request()->routeIs('admin.media');
    @endphp
    <div x-data="{ open: {{ $configActive ? 'true' : 'false' }} }">

        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Configuración' : ''"
                class="{{ $groupBtn($configActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Configuración</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-11 pr-3">
                @can('admin')
                <a href="{{ route('settings.general') }}" wire:navigate class="{{ $subLink(request()->routeIs('settings.*')) }}">Ajustes Generales</a>

                @if(\App\Services\LicenseService::isEcommerceEnabled())
                <a href="{{ route('settings.customization') }}" wire:navigate class="{{ $subLink(request()->routeIs('settings.customization') || request()->routeIs('pages.*') || request()->routeIs('admin.media') || request()->routeIs('settings.menus')) }}">Personalización Web</a>
                @endif

                <a href="{{ route('branches.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('branches.*')) }}">Sucursales</a>
                <a href="{{ route('cash_registers.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('cash_registers.*')) }}">Puntos de Venta</a>
                <a href="{{ route('users.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('users.*')) }}">Usuarios</a>

                @if(hasModule('restaurant'))
                <a href="{{ route('settings.restaurant') }}" wire:navigate class="{{ $subLink(request()->routeIs('settings.restaurant')) }}">🍽️ Restaurante</a>
                @endif
                @endcan

                @can('gerente')
                <a href="{{ route('sellers.index') }}" wire:navigate class="{{ $subLink(request()->routeIs('sellers.*')) }}">Vendedores</a>
                @endcan
            </div>
        </div>
    </div>
    @endif

    </nav>

    {{-- Footer --}}
    <div class="flex-shrink-0 px-3 py-3 border-t border-slate-800">
        <div class="flex items-center gap-3 px-2 py-2 rounded-lg">
            <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black text-xs flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div x-show="!collapsed" class="flex-1 min-w-0">
                <p class="text-slate-200 font-semibold text-[13px] truncate">{{ auth()->user()->name }}</p>
                <p class="text-slate-500 text-[10px] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

</aside>
