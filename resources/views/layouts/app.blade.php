<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
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

        <!-- Dark mode init: runs before paint to avoid flash -->
        <script>
            (function() {
                const stored = localStorage.getItem('zonashop_theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (stored === 'dark' || (!stored && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <x-banner />

        <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

            {{-- Overlay for mobile --}}
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-black/60 lg:hidden"
                 style="display:none;"></div>

            {{-- Sidebar --}}
            @include('layouts.sidebar')

            {{-- Main content column --}}
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

                {{-- Topbar --}}
                @livewire('navigation-menu')

                {{-- Page Heading --}}
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{-- Page Content --}}
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @stack('scripts')
    </body>
</html>
