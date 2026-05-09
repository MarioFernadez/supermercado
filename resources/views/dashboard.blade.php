<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Operational Modules (Accessible to Everyone) -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 border-l-4 border-indigo-500 pl-3 mb-4">Operaciones de Caja</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- POS Card -->
                    <a href="{{ route('pos.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-xl font-bold text-gray-900">Punto de Venta</h4>
                                    <p class="text-sm text-gray-500 mt-1">Realizar ventas y facturación rápida.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Cash Session Card -->
                    <a href="{{ route('cash.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-xl font-bold text-gray-900">Caja y Turnos</h4>
                                    <p class="text-sm text-gray-500 mt-1">Apertura, arqueo y cierre de caja.</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Customers Card -->
                    <a href="{{ route('customers.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-xl font-bold text-gray-900">Clientes</h4>
                                    <p class="text-sm text-gray-500 mt-1">Gestión de cartera de clientes y RUC.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Administration Modules (Admin Only) -->
            @can('admin')
            <div class="mb-8 anim-enter-up" style="animation-delay: 100ms">
                <h3 class="text-lg font-medium text-gray-900 border-l-4 border-orange-500 pl-3 mb-4">Administración</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <a href="{{ route('products.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow md:col-span-2 flex items-center p-6 group">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Productos e Inventario</h4>
                            <p class="text-xs text-gray-500">Gestión de stock, precios y códigos.</p>
                        </div>
                    </a>

                    <a href="{{ route('categories.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow flex items-center p-6 group">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Categorías</h4>
                            <p class="text-xs text-gray-500">Organización.</p>
                        </div>
                    </a>

                    <a href="{{ route('users.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 hover:shadow flex items-center p-6 group">
                        <div class="p-3 rounded-full bg-pink-100 text-pink-600 group-hover:bg-pink-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Usuarios</h4>
                            <p class="text-xs text-gray-500">Accesos y roles.</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 border-l-4 border-teal-500 pl-3 mb-4">Reportes y Finanzas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('reports.sales') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow flex justify-between items-center group">
                        <div>
                            <h4 class="font-bold text-gray-800">Reporte de Ventas</h4>
                            <div class="text-sm text-gray-500 mt-1">Historial detallado y exportación.</div>
                        </div>
                        <div class="h-10 w-10 bg-teal-50 rounded-full flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </a>

                    <a href="{{ route('reports.cash') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow flex justify-between items-center group">
                        <div>
                            <h4 class="font-bold text-gray-800">Reporte de Cierres</h4>
                            <div class="text-sm text-gray-500 mt-1">Auditoría de arqueos de caja.</div>
                        </div>
                        <div class="h-10 w-10 bg-teal-50 rounded-full flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </a>
                </div>
            </div>
            @endcan

        </div>
    </div>
</x-app-layout>
