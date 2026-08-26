{{-- Sidebar — Estilo Auténtico PrestaShop 8 con Acordeón y Flyouts Flotantes --}}
<aside id="sidebar"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    x-data="{ 
        collapsed: localStorage.getItem('sidebar_collapsed') === '1',
        activeGroup: null 
    }"
    x-init="$watch('collapsed', v => localStorage.setItem('sidebar_collapsed', v ? '1' : '0'))"
    :style="collapsed ? 'width: 58px;' : 'width: 220px;'"
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-[#1e293b] border-r border-slate-750/80 shadow-lg transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto"
    style="width: 220px;">

    {{-- Logo + Toggle --}}
    <div class="flex items-center justify-between h-14 px-3.5 bg-[#0f172a]/70 border-b border-slate-700/60 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 min-w-0" x-show="!collapsed">
            <x-application-mark class="h-6 w-auto flex-shrink-0" />
            <div class="flex flex-col leading-none min-w-0">
                <span class="text-white font-black text-sm tracking-tight whitespace-nowrap">Zona<span class="text-indigo-400">Shop</span></span>
                <span class="text-[8.5px] font-bold text-slate-400 uppercase tracking-widest">Backoffice</span>
            </div>
        </a>
        <a href="{{ route('dashboard') }}" x-show="collapsed" class="flex items-center justify-center w-full" title="ZonaShop Backoffice">
            <x-application-mark class="h-6 w-auto flex-shrink-0" />
        </a>
        <button @click="collapsed = !collapsed"
            class="flex-shrink-0 p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/60 transition"
            :title="collapsed ? 'Expandir menú lateral' : 'Colapsar menú lateral'">
            <svg x-show="!collapsed" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="collapsed" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    {{-- Navigation List --}}
    <nav class="flex-1 overflow-y-auto overflow-x-visible py-2 scrollbar-thin scrollbar-thumb-slate-600"
         style="font-family: 'Inter', 'Open Sans', system-ui, sans-serif; font-size: 13px;">

    @php
        $topLinkClass = fn($active) =>
            'flex items-center gap-3 px-3.5 py-2.5 transition-colors duration-150 border-l-[3px] whitespace-nowrap ' .
            ($active
                ? 'bg-slate-800 text-white font-semibold border-indigo-500 shadow-inner'
                : 'text-slate-300 hover:bg-slate-800/70 hover:text-white border-transparent');

        $groupBtnClass = fn($active) =>
            'w-full flex items-center justify-between px-3.5 py-2.5 transition-colors duration-150 border-l-[3px] whitespace-nowrap ' .
            ($active
                ? 'bg-slate-800 text-white font-semibold border-indigo-500'
                : 'text-slate-300 hover:bg-slate-800/70 hover:text-white border-transparent');

        $subLinkClass = fn($active) =>
            'block px-3 py-1.5 rounded-lg transition-colors duration-150 whitespace-nowrap text-[12.5px] ' .
            ($active
                ? 'text-white font-bold bg-indigo-600/30'
                : 'text-slate-300 hover:text-white hover:bg-slate-700/50');
    @endphp

    {{-- ════════════════════════════════════════════════
         SECCIÓN: INICIO
    ═════════════════════════════════════════════════ --}}
    <div x-show="!collapsed" class="px-3.5 pt-2 pb-1 text-[10px] font-black text-slate-400 uppercase tracking-wider">
        Inicio
    </div>

    {{-- Dashboard --}}
    <div class="relative group/flyout">
        <a href="{{ route('dashboard') }}" wire:navigate
           class="{{ $topLinkClass(request()->routeIs('dashboard')) }}"
           title="Inicio / Dashboard">
            <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span x-show="!collapsed" class="truncate font-medium">Dashboard</span>
        </a>
        {{-- Flyout Tooltip when Collapsed --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 px-3 py-1.5 bg-slate-900 border border-slate-700 text-white text-xs font-semibold rounded-lg shadow-xl whitespace-nowrap hidden group-hover/flyout:block z-[9999]">
            Dashboard
        </div>
    </div>

    @if(App\Services\LicenseService::isEcommerceEnabled())
    <div class="relative group/flyout">
        <a href="{{ route('shop.index') }}" target="_blank"
           class="{{ $topLinkClass(false) }}"
           title="Ver Tienda Online">
            <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span x-show="!collapsed" class="truncate font-medium">Ver Tienda</span>
            <span x-show="!collapsed" class="ml-auto text-[10px] bg-indigo-500/20 text-indigo-300 px-1.5 py-0.5 rounded font-mono">web</span>
        </a>
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 px-3 py-1.5 bg-slate-900 border border-slate-700 text-white text-xs font-semibold rounded-lg shadow-xl whitespace-nowrap hidden group-hover/flyout:block z-[9999]">
            Ver Tienda Online ↗
        </div>
    </div>
    @endif

    {{-- ════════════════════════════════════════════════
         SECCIÓN: VENDER (SELL)
    ═════════════════════════════════════════════════ --}}
    <div x-show="!collapsed" class="px-3.5 pt-4 pb-1 text-[10px] font-black text-slate-400 uppercase tracking-wider">
        Vender
    </div>

    {{-- 1. PEDIDOS & POS --}}
    @php
        $pedidosActive = request()->routeIs('pos.*')
            || request()->routeIs('admin.web-orders.*')
            || request()->routeIs('reports.cash')
            || request()->routeIs('reports.cash-movements');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $pedidosActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Pedidos / Caja' : ''"
                class="{{ $groupBtnClass($pedidosActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Pedidos & POS</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                <a href="{{ route('pos.index') }}" class="{{ $subLinkClass(request()->routeIs('pos.*')) }}">
                    ⚡ Punto de Venta (POS)
                </a>
                @if(hasModule('restaurant'))
                <a href="{{ route('pos.index') }}" class="{{ $subLinkClass(false) }}">
                    🍽️ Salón y Mesas
                </a>
                @endif
                @if(\App\Services\LicenseService::isEcommerceEnabled())
                <a href="{{ route('admin.web-orders.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('admin.web-orders.*')) }}">
                    🌐 Pedidos Online
                </a>
                @endif
                <a href="{{ route('reports.cash') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('reports.cash') || request()->routeIs('reports.cash-movements')) }}">
                    💵 Sesiones de Caja
                </a>
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Pedidos & POS
            </div>
            <div class="p-1 space-y-0.5">
                <a href="{{ route('pos.index') }}" class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">⚡ Punto de Venta (POS)</a>
                @if(hasModule('restaurant'))
                <a href="{{ route('pos.index') }}" class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🍽️ Salón y Mesas</a>
                @endif
                @if(\App\Services\LicenseService::isEcommerceEnabled())
                <a href="{{ route('admin.web-orders.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🌐 Pedidos Online</a>
                @endif
                <a href="{{ route('reports.cash') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">💵 Sesiones de Caja</a>
            </div>
        </div>
    </div>

    {{-- 2. CATÁLOGO --}}
    @can('gerente')
    @php
        $catalogoActive = request()->routeIs('products.*')
            || request()->routeIs('categories.*')
            || request()->routeIs('settings.units');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $catalogoActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Catálogo' : ''"
                class="{{ $groupBtnClass($catalogoActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Catálogo</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                <a href="{{ route('products.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('products.*') && !request()->routeIs('products.print-labels')) }}">
                    📦 Productos
                </a>
                <a href="{{ route('categories.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('categories.*')) }}">
                    🏷️ Categorías
                </a>
                <a href="{{ route('products.print-labels') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('products.print-labels')) }}">
                    🖨️ Etiquetas & Barcodes
                </a>
                <a href="{{ route('settings.units') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('settings.units')) }}">
                    ⚖️ Unidades de Medida
                </a>
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Catálogo
            </div>
            <div class="p-1 space-y-0.5">
                <a href="{{ route('products.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">📦 Productos</a>
                <a href="{{ route('categories.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🏷️ Categorías</a>
                <a href="{{ route('products.print-labels') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🖨️ Etiquetas & Barcodes</a>
                <a href="{{ route('settings.units') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">⚖️ Unidades de Medida</a>
            </div>
        </div>
    </div>
    @endcan

    {{-- 3. CLIENTES --}}
    @php
        $clientesActive = request()->routeIs('customers.*')
            || request()->routeIs('admin.collections');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $clientesActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Clientes' : ''"
                class="{{ $groupBtnClass($clientesActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Clientes</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                <a href="{{ route('customers.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('customers.*')) }}">
                    👥 Directorio Clientes
                </a>
                @can('gerente')
                <a href="{{ route('admin.collections') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('admin.collections')) }}">
                    💳 Cuentas & Cobranzas
                </a>
                @endcan
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Clientes
            </div>
            <div class="p-1 space-y-0.5">
                <a href="{{ route('customers.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">👥 Directorio Clientes</a>
                @can('gerente')
                <a href="{{ route('admin.collections') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">💳 Cuentas & Cobranzas</a>
                @endcan
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         SECCIÓN: GESTIÓN Y OPERACIONES
    ═════════════════════════════════════════════════ --}}
    @can('gerente')
    <div x-show="!collapsed" class="px-3.5 pt-4 pb-1 text-[10px] font-black text-slate-400 uppercase tracking-wider">
        Gestión
    </div>

    {{-- CARNICERÍA / DESPOSTE (Si aplica) --}}
    @if(hasModule('meat_deboning'))
    <div class="relative group/flyout">
        <a href="{{ route('admin.deboning.index') }}" wire:navigate
           class="{{ $topLinkClass(request()->routeIs('admin.deboning.*')) }}"
           title="Taller de Desposte">
            <svg class="w-4 h-4 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879a3 3 0 11-4.242-4.242L12 5m0 7l-7 7"/>
            </svg>
            <span x-show="!collapsed" class="truncate font-medium">Taller Desposte</span>
            <span x-show="!collapsed" class="ml-auto text-[9px] bg-red-500/20 text-red-300 px-1.5 py-0.5 rounded font-black">CARNE</span>
        </a>
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 px-3 py-1.5 bg-slate-900 border border-slate-700 text-white text-xs font-semibold rounded-lg shadow-xl whitespace-nowrap hidden group-hover/flyout:block z-[9999]">
            🥩 Taller de Desposte
        </div>
    </div>
    @endif

    {{-- COMPRAS & PROVEEDORES --}}
    @php
        $comprasActive = request()->routeIs('purchases.*')
            || request()->routeIs('suppliers.*');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $comprasActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Compras' : ''"
                class="{{ $groupBtnClass($comprasActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Compras</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                <a href="{{ route('purchases.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('purchases.*')) }}">
                    📥 Facturas de Compra
                </a>
                <a href="{{ route('suppliers.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('suppliers.*')) }}">
                    🏭 Proveedores
                </a>
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Compras
            </div>
            <div class="p-1 space-y-0.5">
                <a href="{{ route('purchases.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">📥 Facturas de Compra</a>
                <a href="{{ route('suppliers.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🏭 Proveedores</a>
            </div>
        </div>
    </div>

    {{-- FINANZAS & GASTOS --}}
    @php
        $finanzasActive = request()->routeIs('expenses.*')
            || request()->routeIs('expenses.categories.*');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $finanzasActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Finanzas' : ''"
                class="{{ $groupBtnClass($finanzasActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Finanzas</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                <a href="{{ route('expenses.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('expenses.*') && !request()->routeIs('expenses.categories.*')) }}">
                    💸 Gastos & Egresos
                </a>
                <a href="{{ route('expenses.categories.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('expenses.categories.*')) }}">
                    📂 Categorías de Gastos
                </a>
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Finanzas
            </div>
            <div class="p-1 space-y-0.5">
                <a href="{{ route('expenses.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">💸 Gastos & Egresos</a>
                <a href="{{ route('expenses.categories.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">📂 Categorías de Gastos</a>
            </div>
        </div>
    </div>
    @endcan

    {{-- ════════════════════════════════════════════════
         SECCIÓN: CONFIGURAR (CONFIGURE)
    ═════════════════════════════════════════════════ --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
    <div x-show="!collapsed" class="px-3.5 pt-4 pb-1 text-[10px] font-black text-slate-400 uppercase tracking-wider">
        Configurar
    </div>

    {{-- REPORTES & ESTADÍSTICAS --}}
    @can('gerente')
    @php
        $reportesActive = request()->routeIs('reports.sales')
            || request()->routeIs('reports.salesperson')
            || request()->routeIs('reports.inventory')
            || request()->routeIs('reports.debtors');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $reportesActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Estadísticas' : ''"
                class="{{ $groupBtnClass($reportesActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Estadísticas</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                <a href="{{ route('reports.sales') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('reports.sales')) }}">
                    📊 Detalle de Ventas
                </a>
                <a href="{{ route('reports.salesperson') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('reports.salesperson')) }}">
                    🏆 Ranking Vendedores
                </a>
                <a href="{{ route('reports.inventory') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('reports.inventory')) }}">
                    📦 Estado de Inventario
                </a>
                <a href="{{ route('reports.debtors') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('reports.debtors')) }}">
                    📋 Saldos Deudores
                </a>
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Estadísticas & Reportes
            </div>
            <div class="p-1 space-y-0.5">
                <a href="{{ route('reports.sales') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">📊 Detalle de Ventas</a>
                <a href="{{ route('reports.salesperson') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🏆 Ranking Vendedores</a>
                <a href="{{ route('reports.inventory') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">📦 Estado de Inventario</a>
                <a href="{{ route('reports.debtors') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">📋 Saldos Deudores</a>
            </div>
        </div>
    </div>
    @endcan

    {{-- PARÁMETROS DE LA TIENDA --}}
    @php
        $tiendaParamActive = request()->routeIs('settings.general')
            || request()->routeIs('settings.billing')
            || request()->routeIs('settings.quotation')
            || request()->routeIs('settings.restaurant')
            || request()->routeIs('settings.customization')
            || request()->routeIs('pages.*')
            || request()->routeIs('admin.media');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $tiendaParamActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Parámetros Tienda' : ''"
                class="{{ $groupBtnClass($tiendaParamActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Parámetros Tienda</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                @can('admin')
                <a href="{{ route('settings.general') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('settings.general')) }}">
                    ⚙️ Ajustes Generales
                </a>
                <a href="{{ route('settings.billing') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('settings.billing')) }}">
                    🧾 Datos de Facturación
                </a>
                <a href="{{ route('settings.quotation') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('settings.quotation')) }}">
                    💱 Cotizaciones Divisas
                </a>
                @if(hasModule('restaurant'))
                <a href="{{ route('settings.restaurant') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('settings.restaurant')) }}">
                    🍽️ Mesas & Mozos
                </a>
                @endif
                @if(\App\Services\LicenseService::isEcommerceEnabled())
                <a href="{{ route('settings.customization') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('settings.customization') || request()->routeIs('pages.*') || request()->routeIs('admin.media')) }}">
                    🎨 Personalización Web
                </a>
                @endif
                @endcan
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Parámetros Tienda
            </div>
            <div class="p-1 space-y-0.5">
                @can('admin')
                <a href="{{ route('settings.general') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">⚙️ Ajustes Generales</a>
                <a href="{{ route('settings.billing') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🧾 Facturación</a>
                <a href="{{ route('settings.quotation') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">💱 Cotizaciones Divisas</a>
                @if(hasModule('restaurant'))
                <a href="{{ route('settings.restaurant') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🍽️ Mesas & Mozos</a>
                @endif
                @if(\App\Services\LicenseService::isEcommerceEnabled())
                <a href="{{ route('settings.customization') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🎨 Personalización Web</a>
                @endif
                @endcan
            </div>
        </div>
    </div>

    {{-- PARÁMETROS AVANZADOS / ADMINISTRACIÓN --}}
    @php
        $adminActive = request()->routeIs('branches.*')
            || request()->routeIs('cash_registers.*')
            || request()->routeIs('users.*')
            || request()->routeIs('sellers.*')
            || request()->routeIs('master.*');
    @endphp
    <div class="relative group/flyout" x-data="{ open: {{ $adminActive ? 'true' : 'false' }} }">
        <button @click="!collapsed && (open = !open)"
                :title="collapsed ? 'Parámetros Avanzados' : ''"
                class="{{ $groupBtnClass($adminActive) }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-400 group-hover/flyout:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span x-show="!collapsed" class="truncate font-medium">Administración</span>
            </div>
            <svg x-show="!collapsed"
                 :class="open ? 'rotate-180' : ''"
                 class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 text-slate-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Expanded Accordion --}}
        <div x-show="open && !collapsed" x-collapse>
            <div class="pb-1.5 pt-0.5 space-y-0.5 pl-10 pr-2.5">
                @can('admin')
                <a href="{{ route('branches.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('branches.*')) }}">
                    🏢 Sucursales
                </a>
                <a href="{{ route('cash_registers.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('cash_registers.*')) }}">
                    💻 Puntos de Venta (Cajas)
                </a>
                <a href="{{ route('users.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('users.*')) }}">
                    🔑 Usuarios & Roles
                </a>
                @endcan

                @can('gerente')
                <a href="{{ route('sellers.index') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('sellers.*')) }}">
                    💼 Vendedores & Comisiones
                </a>
                @endcan

                @if(auth()->user()->isDeveloper())
                <a href="{{ route('master.licensing') }}" wire:navigate class="{{ $subLinkClass(request()->routeIs('master.licensing')) }}">
                    ⚡ Master Licensing
                </a>
                @endif
            </div>
        </div>

        {{-- Collapsed Flyout Floating Menu --}}
        <div x-show="collapsed" class="absolute left-full top-0 ml-1.5 w-52 bg-slate-900 border border-slate-700 shadow-2xl rounded-xl py-2 hidden group-hover/flyout:block z-[9999]">
            <div class="px-3.5 py-1.5 text-[11px] font-black text-indigo-400 uppercase tracking-wider border-b border-slate-800">
                Administración
            </div>
            <div class="p-1 space-y-0.5">
                @can('admin')
                <a href="{{ route('branches.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🏢 Sucursales</a>
                <a href="{{ route('cash_registers.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">💻 Puntos de Venta</a>
                <a href="{{ route('users.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">🔑 Usuarios</a>
                @endcan
                @can('gerente')
                <a href="{{ route('sellers.index') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">💼 Vendedores</a>
                @endcan
                @if(auth()->user()->isDeveloper())
                <a href="{{ route('master.licensing') }}" wire:navigate class="block px-3 py-1.5 text-xs text-slate-200 hover:bg-slate-800 hover:text-white rounded-lg">⚡ Master Licensing</a>
                @endif
            </div>
        </div>
    </div>
    @endif

    </nav>

    {{-- User Profile Footer --}}
    <div class="flex-shrink-0 px-3 py-2.5 bg-[#0f172a]/60 border-t border-slate-700/60">
        <div class="flex items-center gap-2.5 px-1 py-1 rounded-lg">
            <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-indigo-600 to-indigo-400 flex items-center justify-center text-white font-black text-xs flex-shrink-0 shadow-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div x-show="!collapsed" class="flex-1 min-w-0">
                <p class="text-slate-200 font-semibold text-xs truncate leading-tight">{{ auth()->user()->name }}</p>
                <p class="text-slate-400 text-[10px] truncate leading-none mt-0.5">{{ auth()->user()->role_label ?? 'Administrador' }}</p>
            </div>
        </div>
    </div>

</aside>
