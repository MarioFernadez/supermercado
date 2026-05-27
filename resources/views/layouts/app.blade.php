<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ZonaShop') }}</title>

        @php
            $favicon = \App\Models\StoreSetting::where('key', 'shop_favicon_path')->first()?->value;
        @endphp
        @if($favicon)
            <link rel="icon" type="image/x-icon" href="{{ Storage::url($favicon) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @if(auth()->check() && \App\Services\LicenseService::isNearExpiration() && !request()->routeIs('settings.billing'))
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 text-white px-4 py-3 shadow-md relative z-50 font-sans">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 shrink-0 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p class="text-xs font-black uppercase tracking-wider">
                                Atención: Su suscripción vencerá en {{ \App\Services\LicenseService::getDaysRemaining() }} días (el {{ \App\Services\LicenseService::getExpiresAt()->format('d/m/Y') }}).
                            </p>
                        </div>
                        <a href="{{ route('settings.billing') }}" class="inline-flex items-center px-4 py-1.5 bg-white text-orange-600 hover:bg-orange-50 text-[10px] font-black uppercase tracking-widest rounded-xl transition duration-300 shadow shadow-orange-700/20 shrink-0">
                            Ver Detalles / Pagar
                        </a>
                    </div>
                </div>
            @endif

            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
