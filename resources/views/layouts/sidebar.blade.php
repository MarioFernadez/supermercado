{{-- Sidebar Lateral Vertical --}}
<aside id="sidebar"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col bg-[#0d1424] border-r border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-mark class="h-8 w-auto" />
            <div class="flex flex-col leading-none">
                <span class="text-white font-black text-base tracking-tight">Zona<span class="text-indigo-400">Shop</span></span>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">v2.0</span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 scrollbar-thin scrollbar-thumb-slate-700">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        @if(App\Services\LicenseService::isEcommerceEnabled())
        <a href="{{ route('shop.index') }}" target="_blank"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 text-slate-300 hover:bg-slate-800 hover:text-white">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Ver Sitio
        </a>
        @endif

        {{-- GESTIÓN DE VENTAS --}}
        <div class="pt-4 pb-1">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Gestión de Ventas</p>
        </div>

        <a href="{{ route('pos.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('pos.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M14 4H18a2 2 0 012 2v4M8 21l4-4m0 0l4-4m-4 4V9"/>
            </svg>
            Caja POS (Vender)
        </a>

        <a href="{{ route('admin.web-orders.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('admin.web-orders.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Pedidos Online
        </a>

        @can('gerente')
        <a href="{{ route('admin.collections') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('admin.collections') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Cobranzas
        </a>
        @endcan

        <a href="{{ route('customers.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('customers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Clientes
        </a>

        @can('gerente')
        {{-- TIENDA --}}
        <div class="pt-4 pb-1">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Tienda</p>
        </div>

        <a href="{{ route('products.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Productos
        </a>

        <a href="{{ route('categories.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Categorías
        </a>

        <a href="{{ route('purchases.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('purchases.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Compras / Entradas
        </a>

        <a href="{{ route('suppliers.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('suppliers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Proveedores
        </a>

        {{-- FINANZAS --}}
        <div class="pt-4 pb-1">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Finanzas</p>
        </div>

        <a href="{{ route('expenses.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('expenses.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Gastos
        </a>

        <a href="{{ route('reports.cash') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('reports.cash') || request()->routeIs('reports.cash-movements') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M14 4H18a2 2 0 012 2v4M8 21l4-4m0 0l4-4m-4 4V9"/>
            </svg>
            Sesiones de Caja
        </a>



        {{-- REPORTES --}}
        <div class="pt-4 pb-1">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Reportes</p>
        </div>

        <a href="{{ route('reports.sales') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('reports.sales') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Detalle de Ventas
        </a>

        <a href="{{ route('reports.salesperson') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('reports.salesperson') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            Ranking Vendedores
        </a>

        <a href="{{ route('reports.inventory') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('reports.inventory') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Estado de Inventario
        </a>

        <a href="{{ route('reports.debtors') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('reports.debtors') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Saldos de Clientes
        </a>
        @endcan

        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        {{-- CONFIGURACIÓN --}}
        <div class="pt-4 pb-1">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Configuración</p>
        </div>

        @can('admin')
        <a href="{{ route('settings.general') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('settings.general') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Ajustes Generales
        </a>

        @if(\App\Services\LicenseService::isEcommerceEnabled())
        <a href="{{ route('settings.customization') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('settings.customization') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Personalización Web
        </a>
        @endif

        <a href="{{ route('branches.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('branches.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Sucursales
        </a>

        <a href="{{ route('cash_registers.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('cash_registers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3"/>
            </svg>
            Puntos de Venta
        </a>

        <a href="{{ route('users.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Usuarios
        </a>
        @endcan

        @can('gerente')
        <a href="{{ route('sellers.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
            {{ request()->routeIs('sellers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Vendedores
        </a>
        @endcan
        @endif

    </nav>

    {{-- Footer del sidebar --}}
    <div class="px-3 py-4 border-t border-slate-800">
        <div class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-400">
            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black text-xs flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-slate-200 font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-slate-500 text-[10px] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
