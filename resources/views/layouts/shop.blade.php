<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', $settings['store_name'] ?? config('app.name', 'ZonaShop'))</title>
        <meta name="description" content="@yield('meta_description', 'Descubre los mejores productos en ' . ($settings['store_name'] ?? 'nuestra tienda') . '. Calidad y mejores precios.')">

        @if(isset($settings['shop_favicon_path']) && $settings['shop_favicon_path'])
            <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['shop_favicon_path']) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            :root {
                --theme-primary: {{ $settings['shop_primary_color'] ?? '#4f46e5' }};
                --theme-primary-hover: {{ $settings['shop_primary_color_hover'] ?? '#4338ca' }};
            }

            /* Sobrescribir colores Indigo nativos de Tailwind en el sitio */
            .bg-indigo-600 {
                background-color: var(--theme-primary) !important;
            }
            .bg-indigo-700 {
                background-color: var(--theme-primary-hover) !important;
            }
            .hover\:bg-indigo-700:hover {
                background-color: var(--theme-primary-hover) !important;
            }
            .hover\:bg-indigo-600:hover {
                background-color: var(--theme-primary) !important;
            }
            .text-indigo-500 {
                color: var(--theme-primary) !important;
            }
            .text-indigo-600 {
                color: var(--theme-primary) !important;
            }
            .text-indigo-700 {
                color: var(--theme-primary-hover) !important;
            }
            .hover\:text-indigo-600:hover {
                color: var(--theme-primary) !important;
            }
            .hover\:text-indigo-700:hover {
                color: var(--theme-primary-hover) !important;
            }
            .border-indigo-600 {
                border-color: var(--theme-primary) !important;
            }
            .border-indigo-100 {
                border-color: color-mix(in srgb, var(--theme-primary) 10%, transparent) !important;
            }
            .bg-indigo-50\/30 {
                background-color: color-mix(in srgb, var(--theme-primary) 5%, transparent) !important;
            }
            .bg-indigo-50 {
                background-color: color-mix(in srgb, var(--theme-primary) 8%, transparent) !important;
            }
            .bg-indigo-900\/20 {
                background-color: color-mix(in srgb, var(--theme-primary) 20%, transparent) !important;
            }
            .bg-indigo-900\/30 {
                background-color: color-mix(in srgb, var(--theme-primary) 30%, transparent) !important;
            }
            .from-indigo-100 {
                --tw-gradient-from: color-mix(in srgb, var(--theme-primary) 15%, transparent) !important;
                --tw-gradient-to: color-mix(in srgb, var(--theme-primary) 15%, transparent) !important;
                --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
            }
            .to-indigo-50 {
                --tw-gradient-to: color-mix(in srgb, var(--theme-primary) 5%, transparent) !important;
            }
            .shadow-indigo-100\/50 {
                --tw-shadow-color: color-mix(in srgb, var(--theme-primary) 15%, transparent) !important;
                --tw-shadow: 0 25px 50px -12px var(--tw-shadow-color) !important;
            }
            .shadow-indigo-100 {
                --tw-shadow-color: color-mix(in srgb, var(--theme-primary) 15%, transparent) !important;
                --tw-shadow: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color) !important;
            }
            .group:hover .group-hover\:text-indigo-600 {
                color: var(--theme-primary) !important;
            }
            .group:hover .group-hover\:text-indigo-400 {
                color: var(--theme-primary) !important;
            }
            .group\/title:hover .group-hover\/title\:text-indigo-600 {
                color: var(--theme-primary) !important;
            }
            .focus\:border-indigo-500:focus {
                border-color: var(--theme-primary) !important;
            }
            .focus\:ring-indigo-500:focus {
                --tw-ring-color: var(--theme-primary) !important;
            }
            .ring-indigo-500 {
                --tw-ring-color: var(--theme-primary) !important;
            }
            .border-indigo-600 {
                border-color: var(--theme-primary) !important;
            }
            .border-2.border-indigo-600 {
                border-color: var(--theme-primary) !important;
            }
            .hover\:bg-indigo-600:hover {
                background-color: var(--theme-primary) !important;
            }
            .hover\:text-white:hover {
                color: #ffffff !important;
            }
            .hover\:border-indigo-600:hover {
                border-color: var(--theme-primary) !important;
            }

            body { font-family: 'Outfit', sans-serif; }
            [x-cloak] { display: none !important; }
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
            
            /* Premium Animations */
            .img-zoom-hover { transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
            .group:hover .img-zoom-hover { transform: scale(1.1); }
            
            .cart-ready-animation { animation: cartBounce 0.5s ease; }
            @keyframes cartBounce {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.4); }
            }
            
            /* Skeleton Pulse */
            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: skeleton-loading 1.5s infinite;
            }
            @keyframes skeleton-loading {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }

            h1, h2, h3, h4, .font-black { letter-spacing: -0.02em; }
        </style>
        
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <!-- Dark Mode Init (before paint to avoid flash) -->
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
    <body class="antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100" 
          x-data="cartManager" 
          x-init="initCart()"
          style="transition: background-color 0.3s ease, color 0.3s ease;">
        
        <!-- Top Bar -->
        @if($settings['top_bar_enabled'] ?? false)
            <div class="w-full text-center py-2.5 px-4 text-xs font-semibold relative transition-all duration-300 flex items-center justify-center gap-2" 
                 style="background-color: {{ $settings['top_bar_bg_color'] ?? '#002f6c' }}; color: {{ $settings['top_bar_text_color'] ?? '#ffffff' }}; z-index: 51;">
                <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
                    {!! $settings['top_bar_text'] ?? '' !!}
                </div>
            </div>
        @endif

        <!-- Header -->
        <header class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Main Header Content -->
                <div class="flex justify-between items-center h-16 sm:h-20" x-show="!showMobileSearch">
                    <!-- Mobile Hamburger Button -->
                    <div class="flex items-center gap-2 md:hidden mr-2">
                        <button @click="openMobileMenu = true" class="p-2 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition" title="Ver Categorías">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>

                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('shop.index') }}" class="flex items-center gap-2">
                            @if($settings['shop_logo_path'] ?? false)
                                <img src="{{ Storage::url($settings['shop_logo_path']) }}" alt="Logo" class="h-12 w-auto">
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-indigo-600 rounded-xl text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tighter">{{ $settings['store_name'] ?? 'ZONASHOP' }}</span>
                                </div>
                            @endif
                        </a>
                    </div>

                    <!-- Search Bar & Categories Dropdown (Desktop) -->
                    <div class="hidden md:flex items-center flex-1 max-w-xl mx-12 gap-3" x-data="{ openCatMenu: false }">
                        <!-- Category Dropdown Button -->
                        <div class="relative">
                            <button @click="openCatMenu = !openCatMenu" 
                                    class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-600 border border-gray-100 rounded-2xl text-xs font-bold uppercase tracking-widest text-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-indigo-400 transition shadow-sm">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                <span>Categorías</span>
                            </button>
                            <!-- Dropdown List -->
                            @php
                                $globalCategories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
                            @endphp
                            <div x-show="openCatMenu" 
                                 @click.away="openCatMenu = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute left-0 mt-3 w-64 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-2xl p-3 z-50 overflow-hidden"
                                 x-cloak>
                                <div class="max-h-80 overflow-y-auto no-scrollbar space-y-1">
                                    @foreach($globalCategories as $cat)
                                    <a href="{{ route('shop.category', $cat) }}" 
                                       class="flex items-center justify-between px-4 py-2.5 rounded-2xl text-xs font-bold uppercase tracking-widest text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-indigo-400 transition">
                                        <span>{{ $cat->name }}</span>
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <livewire:shop.search />
                        </div>
                    </div>

                    <!-- Nav Actions -->
                    <div class="flex items-center gap-2">
                        <!-- Mobile Search Toggle -->
                        <button @click="showMobileSearch = true" class="md:hidden p-2 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                        <!-- Social Media Icons -->
                        <div class="hidden sm:flex items-center gap-2 border-r border-gray-100 dark:border-gray-700 pr-3 mr-1">
                            @if($settings['shop_facebook'] ?? false)
                                <a href="{{ $settings['shop_facebook'] }}" target="_blank" class="p-2 text-gray-400 dark:text-gray-500 hover:text-blue-600 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($settings['shop_instagram'] ?? false)
                                <a href="{{ $settings['shop_instagram'] }}" target="_blank" class="p-2 text-gray-400 dark:text-gray-500 hover:text-pink-600 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($settings['shop_tiktok'] ?? false)
                                <a href="{{ $settings['shop_tiktok'] }}" target="_blank" class="p-2 text-gray-400 dark:text-gray-500 hover:text-black dark:hover:text-white transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.9-.32-1.98-.23-2.81.33-.85.51-1.44 1.43-1.58 2.41-.14.99.11 2.05.7 2.87.68.9 1.74 1.49 2.87 1.6 1.13.04 2.31-.33 3.12-1.14.81-.84 1.21-2.03 1.25-3.2.03-4.47-.02-8.94.02-13.41z"/></svg>
                                </a>
                            @endif
                        </div>

                        <!-- Dark Mode Toggle -->
                        <button
                            id="shopDarkToggle"
                            onclick="toggleShopDark()"
                            class="p-2 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800"
                            title="Cambiar tema">
                            <svg id="shopIconSun" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg id="shopIconMoon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>

                        @if($settings['shop_show_pricelist'] ?? false)
                        <a href="{{ route('shop.pricelist.download') }}" class="p-2 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition" title="Descargar Lista de Precios">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                        @endif
                        <!-- Cart Trigger -->
                        <button @click="showCart = true" 
                                class="relative p-2 text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition"
                                :class="{ 'cart-ready-animation': cartAnimate }">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span x-show="itemsCount > 0" 
                                  x-text="itemsCount"
                                  class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-bold h-4 w-4 rounded-full flex items-center justify-center border-2 border-white dark:border-gray-900"></span>
                        </button>
                    </div>
                </div>

                <!-- Mobile Search Container -->
                <div class="flex items-center h-16 sm:h-20 gap-4" x-show="showMobileSearch" x-cloak x-transition>
                    <div class="flex-1">
                        <livewire:shop.search />
                    </div>
                    <button @click="showMobileSearch = false" class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-500 transition font-bold text-sm uppercase">
                        Cerrar
                    </button>
                </div>
            </div>
        </header>

        <!-- Mobile Categories Slide-over -->
        <div x-show="openMobileMenu" 
             class="fixed inset-0 overflow-hidden z-[60]" 
             x-cloak>
            <div class="absolute inset-0 overflow-hidden">
                <div @click="openMobileMenu = false" class="absolute inset-0 bg-gray-950/40 backdrop-blur-[2px] transition-opacity"></div>
                
                <section class="absolute inset-y-0 left-0 pr-10 max-w-full flex">
                    <div class="w-screen max-w-xs" 
                         x-show="openMobileMenu"
                         x-transition:enter="transform transition ease-in-out duration-300"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full">
                        
                        <div class="h-full flex flex-col bg-white dark:bg-gray-900 shadow-2xl overflow-hidden">
                            <!-- Header -->
                            <div class="py-5 px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-indigo-600 rounded-lg text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                    </div>
                                    <span class="text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-white">Categorías</span>
                                </div>
                                <button @click="openMobileMenu = false" class="text-gray-400 hover:text-gray-500 p-2 rounded-full hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <!-- List -->
                            <div class="flex-1 overflow-y-auto px-4 py-6 no-scrollbar space-y-1 bg-gray-50/50 dark:bg-gray-900/50">
                                <a href="{{ route('shop.index') }}" 
                                   class="flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-bold uppercase tracking-widest bg-indigo-600 text-white shadow-md shadow-indigo-600/10">
                                    <span>Ver Todo</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                <div class="h-[1px] bg-gray-100 dark:bg-gray-800 my-4"></div>
                                @foreach($globalCategories as $cat)
                                <a href="{{ route('shop.category', $cat) }}" 
                                   class="flex items-center justify-between px-4 py-3.5 rounded-2xl text-xs font-bold uppercase tracking-widest text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                                    <span>{{ $cat->name }}</span>
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                @endforeach
                            </div>

                            <!-- Footer Info -->
                            <div class="p-6 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
                                <span class="block text-[9px] text-gray-400 font-bold uppercase tracking-widest text-center">{{ $settings['store_name'] ?? 'ZONASHOP' }} © 2026</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Cart Slide-over -->
        <div x-show="showCart" 
             class="fixed inset-0 overflow-hidden z-[60]" 
             x-cloak>
            <div class="absolute inset-0 overflow-hidden">
                <div @click="showCart = false" class="absolute inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
                
                <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                    <div class="w-screen max-w-md" 
                         x-show="showCart"
                         x-transition:enter="transform transition ease-in-out duration-300"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full">
                        
                        <div class="h-full flex flex-col bg-white dark:bg-gray-900 shadow-2xl overflow-hidden">
                            <!-- Fixed Header -->
                            <div class="py-6 px-4 sm:px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-white dark:bg-gray-900 z-10">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white uppercase tracking-tighter">Mi Carrito</h2>
                                <button @click="showCart = false" class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-300 p-2 rounded-full hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <!-- Scrollable Body (Products + Form) -->
                            <div class="flex-1 overflow-y-auto px-4 sm:px-6 py-6 custom-scrollbar">
                                <template x-if="items.length === 0">
                                    <div class="text-center py-20">
                                        <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6 text-gray-300 dark:text-gray-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        </div>
                                        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Tu carrito está vacío</p>
                                        <button @click="showCart = false" class="mt-6 text-indigo-600 font-bold text-xs uppercase underline">Seguir comprando</button>
                                    </div>
                                </template>

                                <div x-show="items.length > 0">
                                    <!-- Product List -->
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-100">
                                            <template x-for="item in items" :key="item.cartKey">
                                                <li class="py-6 flex gap-4">
                                                    <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl border border-gray-100 bg-gray-50 shadow-sm">
                                                        <img :src="item.image" class="h-full w-full object-cover">
                                                    </div>
                                                    
                                                    <div class="flex flex-1 flex-col">
                                                        <div>
                                                            <div class="flex justify-between text-base font-bold text-gray-900">
                                                                <h3 x-text="item.name" class="line-clamp-1 text-sm uppercase tracking-tight"></h3>
                                                                <p class="ml-4 whitespace-nowrap text-sm tabular-nums text-indigo-600">₲ <span x-text="formatPrice(item.price * item.quantity)"></span></p>
                                                            </div>
                                                            <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-gray-400" x-text="item.category"></p>
                                                        </div>
                                                        <div class="flex flex-1 items-end justify-between">
                                                            <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-800 rounded-xl p-1 border border-gray-100 dark:border-gray-700">
                                                                <button @click="updateQty(item.cartKey, -1)" class="p-1 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition text-gray-400 hover:text-indigo-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></button>
                                                                <span class="font-bold w-4 text-center text-xs tabular-nums text-gray-900 dark:text-white" x-text="item.quantity"></span>
                                                                <button @click="updateQty(item.cartKey, 1)" class="p-1 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition text-gray-400 hover:text-indigo-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></button>
                                                            </div>
                                                            <button @click="removeItem(item.cartKey)" class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600 transition">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>

                                    <!-- Divider: Delivery Info -->
                                    <div class="mt-12 mb-8 flex items-center gap-4">
                                        <div class="h-[1px] flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Datos de Entrega</h3>
                                        <div class="h-[1px] flex-1 bg-gray-100 dark:bg-gray-800"></div>
                                    </div>

                                    <!-- Customer Form -->
                                    <div class="space-y-5 pb-8">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Nombre Completo</label>
                                            <div class="relative group">
                                                <input type="text" 
                                                     x-model="customerName"
                                                    @input="localStorage.setItem('zonashop_customer_name', customerName)"
                                                    placeholder="Ej: Juan Pérez" 
                                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-transparent dark:border-gray-700 rounded-2xl text-sm focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition font-bold uppercase placeholder:font-normal placeholder:normal-case text-gray-900 dark:text-white placeholder-gray-400">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">WhatsApp / Teléfono</label>
                                            <div class="relative group">
                                                <input type="text" 
                                                    x-model="customerPhone"
                                                    @input="localStorage.setItem('zonashop_customer_phone', customerPhone)"
                                                    placeholder="Ej: 0981 123 456" 
                                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-transparent dark:border-gray-700 rounded-2xl text-sm focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition font-bold tabular-nums text-gray-900 dark:text-white placeholder-gray-400">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Dirección de Entrega</label>
                                            <div class="relative group">
                                                <textarea 
                                                    x-model="customerAddress"
                                                    @input="localStorage.setItem('zonashop_customer_address', customerAddress)"
                                                    rows="2"
                                                    placeholder="Ciudad, Barrio, Calle..." 
                                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-transparent dark:border-gray-700 rounded-2xl text-sm focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition font-bold uppercase placeholder:font-normal placeholder:normal-case text-gray-900 dark:text-white placeholder-gray-400"></textarea>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Método de Pago</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <button @click="paymentMethod = 'efectivo'" 
                                                        :class="paymentMethod === 'efectivo' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-50 dark:bg-gray-800 text-gray-400'"
                                                        class="px-4 py-3 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition">
                                                    Efectivo
                                                </button>
                                                <button @click="paymentMethod = 'transferencia'" 
                                                        :class="paymentMethod === 'transferencia' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-gray-50 dark:bg-gray-800 text-gray-400'"
                                                        class="px-4 py-3 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition">
                                                    Transferencia
                                                </button>
                                            </div>
                                        </div>

                                        <template x-if="formIncomplete && items.length > 0">
                                            <div class="flex items-center gap-2 p-3 bg-red-50 dark:bg-red-900/20 rounded-xl text-red-600 animate-bounce">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                <span class="text-[10px] font-bold uppercase tracking-tight">Completa todos los datos para finalizar</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Fixed Footer -->
                            <div class="border-t border-gray-100 dark:border-gray-800 py-6 px-4 sm:px-6 bg-white dark:bg-gray-900 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] dark:shadow-[0_-10px_40px_rgba(0,0,0,0.3)] z-10" x-show="items.length > 0">
                                <div class="flex justify-between items-end mb-6">
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total a pagar</p>
                                        <p class="text-3xl font-bold text-gray-900 dark:text-white tabular-nums">₲ <span x-text="formatPrice(total)"></span></p>
                                    </div>
                                    <p class="text-[9px] text-gray-400 uppercase font-bold text-right max-w-[120px] leading-tight">Envío a coordinar por WhatsApp</p>
                                </div>
                                
                                <button @click="openReviewModal()" 
                                        class="w-full group relative flex items-center justify-center gap-3 px-6 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-xl shadow-indigo-100 dark:shadow-none transition-all transform active:scale-95 overflow-hidden">
                                    <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                    <span class="relative z-10 text-base font-bold uppercase tracking-widest">Revisar Pedido</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Order Review Modal -->
        <div x-show="showReviewModal" 
             class="fixed inset-0 overflow-y-auto z-[70]" 
             x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div @click="showReviewModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>
                
                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-800">
                    <div class="bg-white dark:bg-gray-900 px-6 py-8">
                        <div class="text-center mb-6">
                            <div class="h-16 w-16 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-tighter">Confirmar Pedido</h3>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Revisa los detalles antes de finalizar</p>
                        </div>

                        <div class="space-y-6">
                            <!-- Items Summary -->
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-4">
                                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Detalle de Productos</p>
                                <div class="max-h-40 overflow-y-auto space-y-2 no-scrollbar">
                                    <template x-for="item in items" :key="item.cartKey">
                                        <div class="flex justify-between text-xs font-bold">
                                            <span class="text-gray-600" x-text="item.quantity + 'x ' + item.name"></span>
                                            <span class="text-gray-900 tabular-nums" x-text="'₲ ' + formatPrice(item.price * item.quantity)"></span>
                                        </div>
                                    </template>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between">
                                    <span class="text-xs font-bold uppercase tracking-widest text-gray-900">Total</span>
                                    <span class="text-lg font-bold text-indigo-600 tabular-nums" x-text="'₲ ' + formatPrice(total)"></span>
                                </div>
                            </div>

                            <!-- Payment Method & Data -->
                            <div class="p-4 rounded-2xl border-2" :class="paymentMethod === 'transferencia' ? 'border-indigo-100 bg-indigo-50/30' : 'border-emerald-100 bg-emerald-50/30'">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 rounded-xl" :class="paymentMethod === 'transferencia' ? 'bg-indigo-100 text-indigo-600' : 'bg-emerald-100 text-emerald-600'">
                                        <svg x-show="paymentMethod === 'transferencia'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        <svg x-show="paymentMethod === 'efectivo'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Método de Pago</p>
                                        <p class="text-sm font-bold text-gray-900 uppercase" x-text="paymentMethod"></p>
                                    </div>
                                </div>

                                <template x-if="paymentMethod === 'transferencia'">
                                    <div class="mt-4 p-4 bg-white rounded-xl border border-indigo-100 shadow-sm">
                                        <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest mb-2">Instrucciones de Pago:</p>
                                        <p class="text-xs text-gray-700 leading-relaxed font-bold whitespace-pre-line" x-text="paymentInstructions"></p>
                                    </div>
                                </template>

                                <template x-if="paymentMethod === 'efectivo'">
                                    <p class="text-xs text-gray-500 font-bold leading-relaxed px-1">Coordinaremos el cobro en efectivo al momento de la entrega o retiro en el local.</p>
                                </template>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-3">
                            <button @click="showReviewModal = false" class="px-6 py-4 bg-gray-50 text-gray-400 font-bold text-[10px] uppercase tracking-widest rounded-2xl hover:bg-gray-100 transition">
                                Modificar
                            </button>
                            <button @click="whatsappCheckout()" class="flex items-center justify-center gap-2 px-6 py-4 bg-emerald-500 text-white font-bold text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-600 transition shadow-lg shadow-emerald-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.24-.581-.487-.503-.669-.512-.174-.01-.373-.012-.572-.012-.199 0-.523.074-.797.371-.273.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                Finalizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main x-data="{
            showAddedToast: false,
            productAddedName: ''
        }" @product-added.window="showAddedToast = true; productAddedName = $event.detail; setTimeout(() => showAddedToast = false, 3000)">
            {{ $slot }}

            <!-- Toast Notification -->
            <div x-show="showAddedToast" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-4"
                 class="fixed bottom-6 left-6 right-6 sm:left-auto sm:right-6 sm:w-80 bg-gray-900 text-white p-4 rounded-2xl shadow-2xl z-50 flex items-center gap-3 border border-white/10"
                 x-cloak>
                <div class="h-10 w-10 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-400">¡Agregado!</p>
                    <p class="text-sm font-bold line-clamp-1" x-text="productAddedName"></p>
                </div>
            </div>
        </main>
        <!-- Benefits Bar (Estilo Sport Style) -->
        @if(isset($settings['benefits_enabled']) && $settings['benefits_enabled'] === '1')
            <section class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 py-12 transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        
                        <!-- Benefit 1 -->
                        <div class="flex flex-col items-center text-center p-4 group">
                            <div class="h-16 w-16 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200 mb-4">
                                <svg class="w-7 h-7 text-[var(--theme-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base tracking-tight">{{ $settings['benefit_1_title'] ?? 'Compra segura' }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-[220px]">{{ $settings['benefit_1_subtitle'] ?? 'Pago protegido con encriptación SSL' }}</p>
                        </div>

                        <!-- Benefit 2 -->
                        <div class="flex flex-col items-center text-center p-4 group">
                            <div class="h-16 w-16 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200 mb-4">
                                <svg class="w-7 h-7 text-[var(--theme-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M3 14.25h12v5.25m0 0h3.75M18 14.25h3v1.5a1.5 1.5 0 0 1-3 0v-1.5Zm-10.5-6h.008v.008H7.5V8.25Zm2.25 0h.008v.008H9.75V8.25Zm2.25 0h.008v.008H12V8.25ZM3.75 6h16.5a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5H3.75A1.5 1.5 0 0 1 2.25 10.5v-3A1.5 1.5 0 0 1 3.75 6Z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base tracking-tight">{{ $settings['benefit_2_title'] ?? 'Envío a todo el país' }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-[220px]">{{ $settings['benefit_2_subtitle'] ?? 'Despachamos a todos los departamentos' }}</p>
                        </div>

                        <!-- Benefit 3 -->
                        <div class="flex flex-col items-center text-center p-4 group">
                            <div class="h-16 w-16 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200 mb-4">
                                <svg class="w-7 h-7 text-[var(--theme-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base tracking-tight">{{ $settings['benefit_3_title'] ?? 'Cambios fáciles' }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-[220px]">{{ $settings['benefit_3_subtitle'] ?? '15 días para cambiar' }}</p>
                        </div>

                        <!-- Benefit 4 -->
                        <div class="flex flex-col items-center text-center p-4 group">
                            <div class="h-16 w-16 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200 mb-4">
                                <svg class="w-7 h-7 text-[var(--theme-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0 1 18 0v6" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3v5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3v5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 19c-1.5 1.5-3 2.5-5 2" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base tracking-tight">{{ $settings['benefit_4_title'] ?? 'Atención al cliente' }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-[220px]">{{ $settings['benefit_4_subtitle'] ?? 'Soporte por WhatsApp' }}</p>
                        </div>

                    </div>
                </div>
            </section>
        @endif

        <!-- Footer -->
        <footer class="bg-slate-900 dark:bg-gray-950 pt-16 pb-8 mt-20 transition-colors duration-300 text-slate-400">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-12 mb-16">
                    <!-- Brand & About -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-2">
                            @if($settings['shop_logo_path'] ?? false)
                                <img src="{{ Storage::url($settings['shop_logo_path']) }}" alt="Logo" class="h-10 w-auto brightness-0 invert">
                            @else
                                <span class="text-2xl font-bold text-white tracking-tighter">{{ $settings['store_name'] ?? 'ZONASHOP' }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            {{ $settings['shop_description'] ?? 'Tu tienda de confianza con los mejores productos y precios del mercado. Calidad garantizada en cada compra.' }}
                        </p>
                        <!-- Social Icons (Footer version) -->
                        <div class="flex items-center gap-3">
                            @if($settings['shop_facebook'] ?? false)
                                <a href="{{ $settings['shop_facebook'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition shadow-sm border border-slate-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($settings['shop_instagram'] ?? false)
                                <a href="{{ $settings['shop_instagram'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-pink-600 hover:text-white transition shadow-sm border border-slate-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($settings['shop_tiktok'] ?? false)
                                <a href="{{ $settings['shop_tiktok'] }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-black hover:text-white transition shadow-sm border border-slate-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.9-.32-1.98-.23-2.81.33-.85.51-1.44 1.43-1.58 2.41-.14.99.11 2.05.7 2.87.68.9 1.74 1.49 2.87 1.6 1.13.04 2.31-.33 3.12-1.14.81-.84 1.21-2.03 1.25-3.2.03-4.47-.02-8.94.02-13.41z"/></svg>
                                </a>
                            @endif
                            <a href="{{ route('login') }}" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition shadow-sm border border-slate-700" title="Panel de Administración">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </a>
                        </div>
                    </div>



                    <!-- Contacto -->
                    <div>
                        <h4 class="text-sm font-bold text-white uppercase tracking-widest mb-6">Contacto</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-indigo-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-sm text-slate-400 font-medium">{{ $settings['store_address'] ?? 'Para configurar dirección vaya a ajustes' }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span class="text-sm text-slate-400 font-medium">{{ $settings['store_phone'] ?? 'S/N' }}</span>
                            </li>
                            @if($settings['shop_whatsapp'] ?? false)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.24-.581-.487-.503-.669-.512-.174-.01-.373-.012-.572-.012-.199 0-.523.074-.797.371-.273.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                <span class="text-sm text-slate-400 font-medium">+595 {{ $settings['shop_whatsapp'] }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Horario -->
                    <div>
                        <h4 class="text-sm font-bold text-white uppercase tracking-widest mb-6">Horario</h4>
                        <ul class="space-y-4">
                            @if($settings['shop_schedule'] ?? false)
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-slate-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm text-slate-400 font-medium whitespace-pre-line">{{ $settings['shop_schedule'] }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Mapa / Ubicacion -->
                    @if($settings['shop_maps_iframe'] ?? false)
                    <div>
                        <h4 class="text-sm font-bold text-white uppercase tracking-widest mb-6">Ubicación</h4>
                        <div class="rounded-2xl overflow-hidden shadow-lg h-40 border border-slate-700">
                            {!! $settings['shop_maps_iframe'] !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="bg-black/40 border-t border-white/5 py-8 mt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">© {{ date('Y') }} Todos los derechos reservados.</p>
                    <div class="flex items-center gap-6">
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">
                            Powered by <a href="https://soteweb.com" target="_blank" class="text-white hover:text-indigo-400 transition">Soteweb</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        @livewireScripts
        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            // Shop dark mode toggle
            function toggleShopDark() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('zonashop_theme', isDark ? 'dark' : 'light');
                updateShopIcons(isDark);
            }

            function updateShopIcons(isDark) {
                const sun  = document.getElementById('shopIconSun');
                const moon = document.getElementById('shopIconMoon');
                if (sun)  sun.classList.toggle('hidden', !isDark);
                if (moon) moon.classList.toggle('hidden', isDark);
            }

            document.addEventListener('DOMContentLoaded', function() {
                updateShopIcons(document.documentElement.classList.contains('dark'));

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                    if (!localStorage.getItem('zonashop_theme')) {
                        document.documentElement.classList.toggle('dark', e.matches);
                        updateShopIcons(e.matches);
                    }
                });
            });
        </script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('cartManager', () => ({
                    items: [],
                    showCart: false,
                    showMobileSearch: false,
                    openMobileMenu: false,
                    cartAnimate: false,
                    whatsappNumber: '{{ $settings['shop_whatsapp'] ?? '981123456' }}',
                    storeName: '{{ $settings['store_name'] ?? 'ZonaShop' }}',
                    paymentInstructions: @json($settings['shop_payment_instructions'] ?? 'Sin instrucciones configuradas'),
                    customerName: '',
                    customerPhone: '',
                    customerAddress: '',
                    paymentMethod: 'efectivo',
                    showReviewModal: false,
                    formIncomplete: false,

                    initCart() {
                        const saved = localStorage.getItem('zonashop_cart');
                        if (saved) {
                            this.items = JSON.parse(saved);
                        }
                        this.customerName = localStorage.getItem('zonashop_customer_name') || '';
                        this.customerPhone = localStorage.getItem('zonashop_customer_phone') || '';
                        this.customerAddress = localStorage.getItem('zonashop_customer_address') || '';

                        // Lock background scroll when drawers are open to prevent double scrollbars
                        this.$watch('showCart', value => {
                            this.updateBodyScroll();
                        });
                        this.$watch('openMobileMenu', value => {
                            this.updateBodyScroll();
                        });
                    },

                    updateBodyScroll() {
                        document.body.style.overflow = (this.showCart || this.openMobileMenu) ? 'hidden' : '';
                    },

                    saveCart() {
                        localStorage.setItem('zonashop_cart', JSON.stringify(this.items));
                    },

                    addItem(product) {
                        const cartKey = product.variation_id ? `v${product.variation_id}` : `p${product.id}`;
                        const existing = this.items.find(i => i.cartKey === cartKey);
                        if (existing) {
                            existing.quantity++;
                        } else {
                            this.items.push({
                                cartKey: cartKey,
                                id: product.id,
                                variation_id: product.variation_id || null,
                                name: product.name,
                                price: product.price_sale,
                                image: product.image_url,
                                category: product.category,
                                quantity: 1
                            });
                        }
                        this.saveCart();
                        
                        // Trigger Animation
                        this.cartAnimate = true;
                        setTimeout(() => { this.cartAnimate = false; }, 600);

                        window.dispatchEvent(new CustomEvent('product-added', { detail: product.name }));
                    },

                    removeItem(cartKey) {
                        this.items = this.items.filter(i => i.cartKey !== cartKey);
                        this.saveCart();
                    },

                    updateQty(cartKey, delta) {
                        const item = this.items.find(i => i.cartKey === cartKey);
                        if (item) {
                            item.quantity += delta;
                            if (item.quantity <= 0) {
                                this.removeItem(cartKey);
                            } else {
                                this.saveCart();
                            }
                        }
                    },

                    get itemsCount() {
                        return this.items.reduce((total, item) => total + item.quantity, 0);
                    },

                    get total() {
                        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
                    },

                    formatPrice(price) {
                        return new Intl.NumberFormat('es-PY', { style: 'decimal' }).format(price);
                    },

                    openReviewModal() {
                        if (!this.customerName.trim() || !this.customerPhone.trim() || !this.customerAddress.trim()) {
                            this.formIncomplete = true;
                            return;
                        }
                        this.formIncomplete = false;
                        this.showReviewModal = true;
                    },

                    whatsappCheckout() {
                        this.showReviewModal = false;
                        
                        // Dispatch global event to Livewire
                        Livewire.dispatch('request-cart-checkout', {
                            items: this.items, 
                            customerName: this.customerName, 
                            customerPhone: this.customerPhone, 
                            customerAddress: this.customerAddress,
                            paymentMethod: this.paymentMethod
                        });
                    }
                }));

                window.addEventListener('checkout-processed', (event) => {
                    const url = event.detail.url;
                    // Clear cart and redirect
                    const cartEl = document.querySelector('[x-data="cartManager"]');
                    if (cartEl && cartEl.__x) {
                        const cart = cartEl.__x.$data;
                        cart.items = [];
                        cart.saveCart();
                        cart.showCart = false;
                    }
                    window.open(url, '_blank');
                });
            });

            // Shop Dark Mode Toggle
            function toggleShopDark() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('zonashop_theme', isDark ? 'dark' : 'light');
                updateShopDarkIcons(isDark);
            }

            function updateShopDarkIcons(isDark) {
                const sun  = document.getElementById('shopIconSun');
                const moon = document.getElementById('shopIconMoon');
                if (sun)  sun.classList.toggle('hidden', isDark);  // sun visible in LIGHT mode
                if (moon) moon.classList.toggle('hidden', !isDark); // moon visible in DARK mode
            }

            document.addEventListener('DOMContentLoaded', function() {
                updateShopDarkIcons(document.documentElement.classList.contains('dark'));
            });
        </script>
    </body>
</html>
