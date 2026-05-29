<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            
            <div class="bg-gray-900 px-8 py-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Panel de Gestión Maestro</h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1 dark:text-gray-500">Configuración de Licencias y Límites</p>
                </div>
                <div class="bg-yellow-400 p-3 rounded-2xl shadow-lg shadow-yellow-500/20">
                    <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
            </div>

            <div class="p-8">
                @if (session()->has('message'))
                    <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl flex items-center dark:bg-emerald-900/30 dark:text-emerald-400" role="alert">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <p class="font-bold text-sm">{{ session('message') }}</p>
                    </div>
                @endif

                <form wire:submit.prevent="updateLicense" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Plan Tier -->
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 dark:text-gray-500">Nombre del Plan / Tier</label>
                            <input type="text" wire:model="tierName" 
                                   class="w-full bg-gray-50 border-gray-200 rounded-2xl px-5 py-4 text-gray-900 font-bold focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition duration-300 shadow-inner dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                            @error('tierName') <span class="text-red-500 text-xs mt-1 block font-bold tracking-tight">{{ $message }}</span> @enderror
                        </div>

                        <!-- Max Users -->
                        <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100 transition hover:shadow-md duration-300">
                            <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-4">Límite de Usuarios</label>
                            <div class="relative items-center flex">
                                <div class="absolute left-4 text-indigo-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <input type="number" wire:model="maxUsers" 
                                       class="w-full pl-14 pr-5 py-5 bg-white border-white rounded-2xl text-2xl font-black text-indigo-700 focus:ring-4 focus:ring-indigo-100 transition duration-300 shadow-sm dark:bg-gray-800 dark:text-indigo-400 dark:shadow-none">
                            </div>
                            @error('maxUsers') <span class="text-red-500 text-xs mt-2 block font-bold tracking-tight">{{ $message }}</span> @enderror
                            <p class="text-[9px] text-gray-400 mt-3 uppercase font-bold tracking-widest dark:text-gray-500">Afecta creación de Admin/Gerente/Cajero</p>
                        </div>

                        <!-- Max Registers -->
                        <div class="bg-purple-50/50 p-6 rounded-3xl border border-purple-100 transition hover:shadow-md duration-300">
                            <label class="block text-[10px] font-black text-purple-400 uppercase tracking-[0.2em] mb-4">Límite de Cajas</label>
                            <div class="relative items-center flex">
                                <div class="absolute left-4 text-purple-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="number" wire:model="maxCashRegisters" 
                                       class="w-full pl-14 pr-5 py-5 bg-white border-white rounded-2xl text-2xl font-black text-purple-700 focus:ring-4 focus:ring-purple-100 transition duration-300 shadow-sm dark:bg-gray-800 dark:shadow-none dark:text-gray-300">
                            </div>
                            @error('maxCashRegisters') <span class="text-red-500 text-xs mt-2 block font-bold tracking-tight">{{ $message }}</span> @enderror
                            <p class="text-[9px] text-gray-400 mt-3 uppercase font-bold tracking-widest dark:text-gray-500">Cajas abiertas simultáneamente</p>
                        </div>

                    </div>

                    <!-- Ecommerce Toggle -->
                    <div class="bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100 transition hover:shadow-md duration-300 flex items-center justify-between">
                        <div>
                            <label class="block text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-1">Catálogo E-commerce</label>
                            <p class="text-[9px] text-gray-500 font-bold tracking-widest uppercase dark:text-gray-400">Habilita la tienda online pública para este cliente</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="ecommerceEnabled" class="sr-only peer dark:bg-gray-900 dark:text-gray-300">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full bg-gray-900 hover:bg-black text-white font-black py-5 rounded-2xl transition duration-300 transform active:scale-[0.98] shadow-xl text-lg uppercase tracking-widest flex items-center justify-center group">
                            <span>Actualizar Licencia Maestra</span>
                            <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 pt-8 border-t border-gray-100 flex items-center justify-center dark:border-gray-700">
                    <div class="flex items-center space-x-2 text-gray-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-[10px] uppercase font-black tracking-[0.3em]">ZonaPOS Master Auth Layer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
