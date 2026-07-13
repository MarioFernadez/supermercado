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
    <nav class="flex-1 overflow-y-auto py-2 space-y-0.5 scrollbar-thin scrollbar-thumb-slate-700" style="font-family: 'Open Sans', Tahoma, sans-serif; font-size: 14px;">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white border-l-2 border-indigo-500' : 'text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        @if(App\Services\LicenseService::isEcommerceEnabled())
        <a href="{{ route('shop.index') }}" target="_blank"
            class="flex items-center gap-3 px-4 py-2.5 transition-all duration-150 text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span>Ver Sitio</span>
        </a>
        @endif

        {{-- GESTIÓN DE VENTAS --}}
        @php
            $isVentasActive = request()->routeIs('pos.*') || request()->routeIs('admin.web-orders.*') || request()->routeIs('admin.collections') || request()->routeIs('customers.*');
        @endphp
        <div x-data="{ open: {{ $isVentasActive ? 'true' : 'false' }} }" class="flex flex-col">
            <button @click="open = !open" 
                    class="flex items-center justify-between px-4 py-2.5 transition-all duration-150 {{ $isVentasActive ? 'bg-slate-800 text-white border-l-2 border-indigo-500' : 'text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3M14 4H18a2 2 0 012 2v4M8 21l4-4m0 0l4-4m-4 4V9"/>
                    </svg>
                    <span>Gestión de Ventas</span>
                </div>
                <svg :class="{'rotate-180': open}" class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse>
                <div class="flex flex-col pl-[2.25rem] pr-4 py-1.5 space-y-1 relative before:content-[''] before:absolute before:left-[1.125rem] before:top-0 before:bottom-0 before:w-[1px] before:bg-slate-700">
                    <a href="{{ route('pos.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('pos.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Caja POS (Vender)</a>
                    <a href="{{ route('admin.web-orders.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('admin.web-orders.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Pedidos Online</a>
                    @can('gerente')
                        <a href="{{ route('admin.collections') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('admin.collections') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Cobranzas</a>
                    @endcan
                    <a href="{{ route('customers.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('customers.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Clientes</a>
                </div>
            </div>
        </div>

        @can('gerente')
        {{-- TIENDA --}}
        @php
            $isTiendaActive = request()->routeIs('products.*') || request()->routeIs('categories.*') || request()->routeIs('purchases.*') || request()->routeIs('suppliers.*');
        @endphp
        <div x-data="{ open: {{ $isTiendaActive ? 'true' : 'false' }} }" class="flex flex-col">
            <button @click="open = !open" 
                    class="flex items-center justify-between px-4 py-2.5 transition-all duration-150 {{ $isTiendaActive ? 'bg-slate-800 text-white border-l-2 border-indigo-500' : 'text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Tienda</span>
                </div>
                <svg :class="{'rotate-180': open}" class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse>
                <div class="flex flex-col pl-[2.25rem] pr-4 py-1.5 space-y-1 relative before:content-[''] before:absolute before:left-[1.125rem] before:top-0 before:bottom-0 before:w-[1px] before:bg-slate-700">
                    <a href="{{ route('products.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('products.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Productos</a>
                    <a href="{{ route('categories.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('categories.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Categorías</a>
                    <a href="{{ route('purchases.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('purchases.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Compras / Entradas</a>
                    <a href="{{ route('suppliers.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('suppliers.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Proveedores</a>
                </div>
            </div>
        </div>
        @endcan

        {{-- FINANZAS --}}
        @php
            $isFinanzasActive = request()->routeIs('expenses.*') || request()->routeIs('reports.cash') || request()->routeIs('reports.cash-movements');
        @endphp
        <div x-data="{ open: {{ $isFinanzasActive ? 'true' : 'false' }} }" class="flex flex-col">
            <button @click="open = !open" 
                    class="flex items-center justify-between px-4 py-2.5 transition-all duration-150 {{ $isFinanzasActive ? 'bg-slate-800 text-white border-l-2 border-indigo-500' : 'text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Finanzas</span>
                </div>
                <svg :class="{'rotate-180': open}" class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse>
                <div class="flex flex-col pl-[2.25rem] pr-4 py-1.5 space-y-1 relative before:content-[''] before:absolute before:left-[1.125rem] before:top-0 before:bottom-0 before:w-[1px] before:bg-slate-700">
                    <a href="{{ route('expenses.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('expenses.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Gastos</a>
                    <a href="{{ route('reports.cash') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('reports.cash') || request()->routeIs('reports.cash-movements') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Sesiones de Caja</a>
                </div>
            </div>
        </div>

        @can('gerente')
        {{-- REPORTES --}}
        @php
            $isReportesActive = request()->routeIs('reports.sales') || request()->routeIs('reports.salesperson') || request()->routeIs('reports.inventory') || request()->routeIs('reports.debtors');
        @endphp
        <div x-data="{ open: {{ $isReportesActive ? 'true' : 'false' }} }" class="flex flex-col">
            <button @click="open = !open" 
                    class="flex items-center justify-between px-4 py-2.5 transition-all duration-150 {{ $isReportesActive ? 'bg-slate-800 text-white border-l-2 border-indigo-500' : 'text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Reportes</span>
                </div>
                <svg :class="{'rotate-180': open}" class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse>
                <div class="flex flex-col pl-[2.25rem] pr-4 py-1.5 space-y-1 relative before:content-[''] before:absolute before:left-[1.125rem] before:top-0 before:bottom-0 before:w-[1px] before:bg-slate-700">
                    <a href="{{ route('reports.sales') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('reports.sales') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Detalle de Ventas</a>
                    <a href="{{ route('reports.salesperson') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('reports.salesperson') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Ranking Vendedores</a>
                    <a href="{{ route('reports.inventory') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('reports.inventory') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Estado de Inventario</a>
                    <a href="{{ route('reports.debtors') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('reports.debtors') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Saldos de Clientes</a>
                </div>
            </div>
        </div>
        @endcan

        @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        {{-- CONFIGURACIÓN --}}
        @php
            $isConfigActive = request()->routeIs('settings.*') || request()->routeIs('branches.*') || request()->routeIs('cash_registers.*') || request()->routeIs('users.*') || request()->routeIs('sellers.*');
        @endphp
        <div x-data="{ open: {{ $isConfigActive ? 'true' : 'false' }} }" class="flex flex-col">
            <button @click="open = !open" 
                    class="flex items-center justify-between px-4 py-2.5 transition-all duration-150 {{ $isConfigActive ? 'bg-slate-800 text-white border-l-2 border-indigo-500' : 'text-slate-300 hover:bg-slate-800 hover:text-white border-l-2 border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Configuración</span>
                </div>
                <svg :class="{'rotate-180': open}" class="w-3 h-3 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-collapse>
                <div class="flex flex-col pl-[2.25rem] pr-4 py-1.5 space-y-1 relative before:content-[''] before:absolute before:left-[1.125rem] before:top-0 before:bottom-0 before:w-[1px] before:bg-slate-700">
                    @can('admin')
                        <a href="{{ route('settings.general') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('settings.general') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Ajustes Generales</a>
                        
                        @if(\App\Services\LicenseService::isEcommerceEnabled())
                        <a href="{{ route('settings.customization') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('settings.customization') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Personalización Web</a>
                        <a href="{{ route('settings.menus') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('settings.menus') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Menús Web</a>
                        <a href="{{ route('pages.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('pages.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Páginas (CMS)</a>
                        <a href="{{ route('admin.media') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('admin.media') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Gestor de Medios</a>
                        @endif
                        
                        <a href="{{ route('branches.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('branches.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Sucursales</a>
                        <a href="{{ route('cash_registers.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('cash_registers.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Puntos de Venta</a>
                        <a href="{{ route('users.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('users.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Usuarios</a>
                    @endcan

                    @can('gerente')
                        <a href="{{ route('sellers.index') }}" class="px-3 py-1.5 rounded text-[14px] transition-all duration-150 {{ request()->routeIs('sellers.*') ? 'text-white font-bold bg-slate-800/50' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">Vendedores</a>
                    @endcan
                </div>
            </div>
        </div>
        @endif

    </nav>

    {{-- Footer del sidebar --}}
    <div class="px-3 py-4 border-t border-slate-800">
        <div class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-400">
            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black text-xs flex-shrink-0" style="font-family: 'Open Sans', sans-serif;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0" style="font-family: 'Open Sans', Tahoma, sans-serif;">
                <p class="text-slate-200 font-semibold text-[14px] truncate">{{ auth()->user()->name }}</p>
                <p class="text-slate-500 text-[10px] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
