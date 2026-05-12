<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-indigo-100 text-indigo-700">
                        v2.0
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Resumen') }}
                    </x-nav-link>
                    <!-- Comercial Dropdown -->
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('pos.*') || request()->routeIs('admin.web-orders.*') || request()->routeIs('admin.collections') || request()->routeIs('customers.*') ? 'text-indigo-600 font-bold' : '' }}">
                                        {{ __('Ventas') }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('pos.index') }}">
                                    {{ __('Caja POS (Vender)') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.web-orders.index') }}">
                                    {{ __('Pedidos Online') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('admin.collections') }}">
                                    {{ __('Cobranzas (Créditos)') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-100 dark:border-gray-600"></div>
                                <x-dropdown-link href="{{ route('customers.index') }}">
                                    {{ __('Clientes') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    @can('gerente')
                        <!-- Stock Dropdown -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('products.*') || request()->routeIs('categories.*') || request()->routeIs('purchases.*') || request()->routeIs('suppliers.*') ? 'text-indigo-600 font-bold' : '' }}">
                                            {{ __('Tienda') }}
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('products.index') }}">
                                        {{ __('Productos') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('categories.index') }}">
                                        {{ __('Categorías') }}
                                    </x-dropdown-link>
                                    <div class="border-t border-gray-100 dark:border-gray-600"></div>
                                    <x-dropdown-link href="{{ route('purchases.index') }}">
                                        {{ __('Compras / Entradas') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('suppliers.index') }}">
                                        {{ __('Proveedores') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Finanzas Dropdown -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('expenses.*') || request()->routeIs('reports.cash*') || request()->routeIs('reports.profit') ? 'text-indigo-600 font-bold' : '' }}">
                                            {{ __('Finanzas') }}
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('expenses.index') }}">
                                         {{ __('Gastos') }}
                                     </x-dropdown-link>
                                     <div class="border-t border-gray-100 dark:border-gray-600"></div>
                                    <x-dropdown-link href="{{ route('reports.cash') }}">
                                        {{ __('Sesiones de Caja') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('reports.cash-movements') }}">
                                        {{ __('Movimientos de Caja') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('reports.profit') }}">
                                        {{ __('Utilidad Real') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endcan
                    
                    @can('gerente')
                        <!-- Reportes Dropdown -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('reports.*') && !request()->routeIs('reports.cash*') && !request()->routeIs('reports.profit') ? 'text-indigo-600 font-bold' : '' }}">
                                            {{ __('Reportes') }}
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('reports.sales') }}">
                                        {{ __('Detalle de Ventas') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('reports.salesperson') }}">
                                        {{ __('Ranking Vendedores') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('reports.inventory') }}">
                                        {{ __('Estado de Inventario') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('reports.debtors') }}">
                                        {{ __('Saldos de Clientes') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endcan



                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                        <!-- Configuración Dropdown -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('settings.*') || request()->routeIs('users.*') || request()->routeIs('sellers.*') || request()->routeIs('cash_registers.*') ? 'text-indigo-600 font-bold' : '' }}">
                                            {{ __('Configuración') }}
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    @can('admin')
                                        <x-dropdown-link href="{{ route('settings.general') }}">
                                            {{ __('Ajustes Generales') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('cash_registers.index') }}">
                                            {{ __('Puntos de Venta (Cajas)') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('settings.quotation') }}">
                                            {{ __('Cotizaciones Monedas') }}
                                        </x-dropdown-link>
                                        @if(\App\Services\LicenseService::isEcommerceEnabled())
                                            <x-dropdown-link href="{{ route('settings.banners') }}">
                                                {{ __('Banners de Tienda') }}
                                            </x-dropdown-link>
                                        @endif
                                        <div class="border-t border-gray-100 dark:border-gray-600"></div>
                                        <x-dropdown-link href="{{ route('users.index') }}">
                                            {{ __('Usuarios del Sistema') }}
                                        </x-dropdown-link>
                                    @endcan
                                    
                                    @can('gerente')
                                        <x-dropdown-link href="{{ route('sellers.index') }}">
                                            {{ __('Vendedores') }}
                                        </x-dropdown-link>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    @if(\App\Services\LicenseService::isEcommerceEnabled())
                        <x-nav-link href="{{ route('shop.index') }}" target="_blank" class="bg-indigo-50 !text-indigo-600 px-3 rounded-lg border-indigo-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            {{ __('Ir a Tienda') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notifications -->
                @livewire('admin.global-notifications')

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administrar Cuenta') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            @if(auth()->user()->isDeveloper())
                                <x-dropdown-link href="{{ route('master.licensing') }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-800 font-bold">
                                    🗝️ {{ __('Master Control') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                            @endif

                            @if(auth()->user()->isAdmin() || auth()->user()->isManager() || auth()->user()->isCashier())
                                <x-dropdown-link href="{{ route('cash.index') }}">
                                    {{ __('Mi Caja') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Resumen') }}
            </x-responsive-nav-link>
            <!-- Comercial -->
            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50">Comercial</div>
            <x-responsive-nav-link href="{{ route('pos.index') }}" :active="request()->routeIs('pos.index')">
                {{ __('Caja POS (Vender)') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.web-orders.index') }}" :active="request()->routeIs('admin.web-orders.index')">
                {{ __('Pedidos Online') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('admin.collections') }}" :active="request()->routeIs('admin.collections')">
                {{ __('Cobranzas (Créditos)') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('customers.index') }}" :active="request()->routeIs('customers.index')">
                {{ __('Clientes') }}
            </x-responsive-nav-link>

            @can('gerente')
                <!-- Almacén -->
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50 mt-2">Tienda</div>
                <x-responsive-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.index')">
                    {{ __('Productos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.index')">
                    {{ __('Categorías') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('purchases.index') }}" :active="request()->routeIs('purchases.index')">
                    {{ __('Compras / Entradas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers.index')">
                    {{ __('Proveedores') }}
                </x-responsive-nav-link>

                <!-- Finanzas -->
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50 mt-2">Finanzas</div>
                <x-responsive-nav-link href="{{ route('expenses.index') }}" :active="request()->routeIs('expenses.index')">
                    {{ __('Gastos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reports.cash') }}" :active="request()->routeIs('reports.cash')">
                    {{ __('Sesiones de Caja') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reports.cash-movements') }}" :active="request()->routeIs('reports.cash-movements')">
                    {{ __('Movimientos de Caja') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reports.profit') }}" :active="request()->routeIs('reports.profit')">
                    {{ __('Utilidad Real') }}
                </x-responsive-nav-link>

                <!-- Reportes -->
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50 mt-2">Reportes</div>
                <x-responsive-nav-link href="{{ route('reports.sales') }}" :active="request()->routeIs('reports.sales')">
                    {{ __('Detalle de Ventas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reports.salesperson') }}" :active="request()->routeIs('reports.salesperson')">
                    {{ __('Ranking Vendedores') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reports.inventory') }}" :active="request()->routeIs('reports.inventory')">
                    {{ __('Estado de Inventario') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reports.debtors') }}" :active="request()->routeIs('reports.debtors')">
                    {{ __('Saldos de Clientes') }}
                </x-responsive-nav-link>
            @endcan

            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                <!-- Configuración -->
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-gray-900/50 mt-2">Sistema</div>
                @can('admin')
                    <x-responsive-nav-link href="{{ route('settings.general') }}" :active="request()->routeIs('settings.general')">
                        {{ __('Ajustes Generales') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('cash_registers.index') }}" :active="request()->routeIs('cash_registers.index')">
                        {{ __('Cajas / Puntos de Venta') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('settings.quotation') }}" :active="request()->routeIs('settings.quotation')">
                        {{ __('Cotización Monedas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                        {{ __('Usuarios') }}
                    </x-responsive-nav-link>
                @endcan

                @can('gerente')
                    <x-responsive-nav-link href="{{ route('sellers.index') }}" :active="request()->routeIs('sellers.index')">
                        {{ __('Vendedores') }}
                    </x-responsive-nav-link>
                @endcan
            @endif


        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                @if(auth()->user()->isDeveloper())
                    <x-responsive-nav-link href="{{ route('master.licensing') }}" class="bg-yellow-50 text-yellow-800 font-bold border-l-4 border-yellow-400">
                        {{ __('🗝️ Master Control') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif
                @if(auth()->user()->isAdmin() || auth()->user()->isManager() || auth()->user()->isCashier())
                    <x-responsive-nav-link href="{{ route('cash.index') }}" :active="request()->routeIs('cash.index')">
                        {{ __('Mi Caja') }}
                    </x-responsive-nav-link>
                @endif

                @if(\App\Services\LicenseService::isEcommerceEnabled())
                    <x-responsive-nav-link href="{{ route('shop.index') }}" target="_blank" class="bg-indigo-50 text-indigo-700 font-bold border-l-4 border-indigo-400">
                        {{ __('🛍️ Ir a Tienda') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->

            </div>
        </div>
    </div>
</nav>
