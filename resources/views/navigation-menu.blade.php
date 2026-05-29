<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex-shrink-0">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Left: Hamburger (mobile) --}}
            <div class="flex items-center gap-3">
                {{-- Mobile hamburger to open sidebar --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Page title slot (optional) --}}
                <span class="hidden lg:block text-sm font-semibold text-gray-500 dark:text-gray-400">
                    {{ config('app.name', 'ZonaShop') }}
                </span>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-2">

                {{-- Dark Mode Toggle --}}
                <button
                    id="darkModeToggle"
                    onclick="toggleDarkMode()"
                    class="dark-mode-toggle p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                    title="Cambiar tema"
                    aria-label="Modo oscuro">
                    <!-- Sun icon (visible in dark mode) -->
                    <svg id="iconSun" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon icon (visible in light mode) -->
                    <svg id="iconMoon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
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

                            <!-- Authentication -->
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
