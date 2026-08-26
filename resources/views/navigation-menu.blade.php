<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex-shrink-0 shadow-sm">
    <div class="px-4 sm:px-6">
        <div class="flex justify-between h-12 items-center">

            {{-- Left: Hamburger (mobile) + Breadcrumb --}}
            <div class="flex items-center gap-3">
                {{-- Mobile hamburger --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden inline-flex items-center justify-center p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Breadcrumb dinámico --}}
                @php
                    $breadcrumbs = [];

                    $routeName = request()->route()?->getName() ?? '';

                    $sectionMap = [
                        'dashboard'              => ['', 'Dashboard'],
                        'pos.'                   => ['Ventas', 'Caja POS'],
                        'admin.web-orders.'      => ['Ventas', 'Pedidos Online'],
                        'admin.collections'      => ['Ventas', 'Cobranzas'],
                        'customers.'             => ['Ventas', 'Clientes'],
                        'products.'              => ['Tienda', 'Productos'],
                        'categories.'            => ['Tienda', 'Categorías'],
                        'purchases.'             => ['Tienda', 'Compras / Entradas'],
                        'suppliers.'             => ['Tienda', 'Proveedores'],
                        'admin.deboning.'        => ['Tienda', 'Taller de Desposte'],
                        'expenses.'              => ['Finanzas', 'Gastos'],
                        'reports.cash'           => ['Finanzas', 'Sesiones de Caja'],
                        'reports.cash-movements' => ['Finanzas', 'Sesiones de Caja'],
                        'reports.sales'          => ['Reportes', 'Detalle de Ventas'],
                        'reports.salesperson'    => ['Reportes', 'Ranking Vendedores'],
                        'reports.inventory'      => ['Reportes', 'Estado de Inventario'],
                        'reports.debtors'        => ['Reportes', 'Saldos de Clientes'],
                        'settings.'              => ['Configuración', 'Ajustes'],
                        'branches.'              => ['Configuración', 'Sucursales'],
                        'cash_registers.'        => ['Configuración', 'Puntos de Venta'],
                        'users.'                 => ['Configuración', 'Usuarios'],
                        'sellers.'               => ['Configuración', 'Vendedores'],
                        'pages.'                 => ['Configuración', 'Páginas (CMS)'],
                        'admin.media'            => ['Configuración', 'Gestor de Medios'],
                        'profile.'               => ['', 'Mi Perfil'],
                        'cash.'                  => ['', 'Mi Caja'],
                        'master.'                => ['', 'Master Control'],
                    ];

                    $section = '';
                    $page = config('app.name', 'ZonaShop');

                    foreach ($sectionMap as $prefix => [$sec, $pag]) {
                        if (str_starts_with($routeName, $prefix) || $routeName === $prefix) {
                            $section = $sec;
                            $page = $pag;
                            break;
                        }
                    }
                @endphp

                <div class="hidden lg:flex items-center gap-1.5 text-sm" style="font-family: 'Inter', sans-serif;">
                    @if($section)
                        <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $section }}</span>
                        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    @endif
                    <span class="text-gray-700 dark:text-gray-200 font-semibold">{{ $page }}</span>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-1.5">

                {{-- Dark Mode Toggle --}}
                <button
                    id="darkModeToggle"
                    onclick="toggleDarkMode()"
                    class="dark-mode-toggle p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                    title="Cambiar tema"
                    aria-label="Modo oscuro">
                    <svg id="iconSun" class="hidden w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg id="iconMoon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                {{-- Notifications --}}
                @livewire('admin.global-notifications')

                {{-- User Dropdown --}}
                <div class="ms-1 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-7 w-7 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button type="button"
                                    class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <div class="w-6 h-6 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black text-[10px]">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="hidden sm:block max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            @endif
                        </x-slot>

                        <x-slot name="content">
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

                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>


<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('zonashop_theme', isDark ? 'dark' : 'light');
        updateDarkIcons(isDark);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark } }));
    }

    function updateDarkIcons(isDark) {
        const sun  = document.getElementById('iconSun');
        const moon = document.getElementById('iconMoon');
        if (sun)  sun.classList.toggle('hidden', isDark);  // sun visible in LIGHT mode
        if (moon) moon.classList.toggle('hidden', !isDark); // moon visible in DARK mode
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateDarkIcons(document.documentElement.classList.contains('dark'));

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            if (!localStorage.getItem('zonashop_theme')) {
                document.documentElement.classList.toggle('dark', e.matches);
                updateDarkIcons(e.matches);
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: e.matches } }));
            }
        });
    });
</script>
