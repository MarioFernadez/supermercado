<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Section: Header -->
        <div class="mb-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Cotizaciones de Moneda</h3>
            <p class="mt-1 text-sm text-gray-600">
                Defina el valor de cambio en Guaraníes (PYG) para las monedas extranjeras aceptadas.
                <br>
                <strong>Nota:</strong> Estos valores se utilizarán para calcular pagos en moneda extranjera en el POS.
            </p>
        </div>

        <div class="mt-2 text-center">
            <form wire:submit.prevent="save">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6 text-left">
                        <div class="grid grid-cols-6 gap-6">
                            
                            <!-- USD -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="usd" class="block text-sm font-medium text-gray-700">Dólar Americano (USD)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">U$</span>
                                    </div>
                                    <input type="number" step="any" wire:model="usd" id="usd" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">PYG</span>
                                    </div>
                                </div>
                                @error('usd') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- BRL -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="brl" class="block text-sm font-medium text-gray-700">Real Brasileño (BRL)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">R$</span>
                                    </div>
                                    <input type="number" step="any" wire:model="brl" id="brl" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">PYG</span>
                                    </div>
                                </div>
                                @error('brl') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- ARS -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="ars" class="block text-sm font-medium text-gray-700">Peso Argentino (ARS)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" step="any" wire:model="ars" id="ars" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">PYG</span>
                                    </div>
                                </div>
                                @error('ars') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- EUR -->
                            <div class="col-span-6 sm:col-span-3">
                                <label for="eur" class="block text-sm font-medium text-gray-700">Euro (EUR)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">€</span>
                                    </div>
                                    <input type="number" step="any" wire:model="eur" id="eur" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">PYG</span>
                                    </div>
                                </div>
                                @error('eur') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Guardar Cotizaciones
                        </button>
                    </div>
                </div>
            </form>

             @if (session()->has('message'))
                <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p class="font-bold">Guardado</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
