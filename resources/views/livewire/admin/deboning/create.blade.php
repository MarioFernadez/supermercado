<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.deboning.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-500 hover:text-indigo-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Nuevo Desposte</h2>
                    <p class="text-sm text-gray-500 mt-1">Registra la conversión de materia prima en cortes finales.</p>
                </div>
            </div>
        </div>

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm flex items-center gap-3">
                <div class="text-red-700 font-bold text-sm">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="bg-white shadow-xl rounded-[2rem] overflow-hidden border border-gray-100">
                <div class="p-8 space-y-8">
                    
                    <!-- Sección 1: Materia Prima -->
                    <div>
                        <h3 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                            <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                            Materia Prima (Origen)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Seleccionar Producto Base</label>
                                <select wire:model.live="raw_material_product_id" class="w-full shadow-sm text-sm border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Seleccione una materia prima --</option>
                                    @foreach($this->raw_materials as $raw)
                                        <option value="{{ $raw->id }}">{{ $raw->name }} (Stock: {{ number_format($raw->stock, 2) }} Kg)</option>
                                    @endforeach
                                </select>
                                @error('raw_material_product_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Peso a Despostar (Kg)</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <input type="number" step="0.001" wire:model.live="total_weight_start" class="w-full pr-12 text-sm border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 font-bold text-lg" placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold sm:text-sm">Kg</span>
                                    </div>
                                </div>
                                @error('total_weight_start') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Cortes Obtenidos -->
                    <div class="bg-slate-50 -mx-8 px-8 py-6 border-y border-gray-100">
                        <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-3">
                            <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                                Cortes Obtenidos (Rendimiento)
                            </h3>
                            <button type="button" wire:click="addItem" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 bg-indigo-100 hover:bg-indigo-200 px-3 py-1.5 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Añadir Corte
                            </button>
                        </div>
                        
                        @error('items') 
                            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-xl text-sm font-bold">{{ $message }}</div> 
                        @enderror

                        <div class="space-y-3">
                            @foreach($items as $index => $item)
                                <div class="flex items-start gap-4" wire:key="item-{{ $index }}">
                                    <div class="flex-1">
                                        <select wire:model.live="items.{{ $index }}.product_id" class="w-full shadow-sm text-sm border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">-- Seleccionar corte final --</option>
                                            @foreach($this->cut_products as $cut)
                                                <option value="{{ $cut->id }}">{{ $cut->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('items.'.$index.'.product_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="w-40 relative rounded-xl shadow-sm">
                                        <input type="number" step="0.001" wire:model.live="items.{{ $index }}.weight" class="w-full pr-12 text-sm border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 font-bold" placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 font-bold text-xs">Kg</span>
                                        </div>
                                        @error('items.'.$index.'.weight') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <button type="button" wire:click="removeItem({{ $index }})" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition mt-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sección 3: Resumen y Merma -->
                    <div class="bg-white rounded-xl border-2 {{ $this->waste_weight < 0 ? 'border-red-500' : 'border-dashed border-gray-200' }} p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-black text-gray-900">Resumen de Merma</h3>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Rendimiento Total</p>
                                <p class="text-2xl font-black text-gray-900">{{ number_format($this->total_yield, 2) }} Kg</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-gray-100 rounded-full h-4 overflow-hidden flex">
                                @if($total_weight_start > 0)
                                    @php
                                        $yieldPct = min(100, ($this->total_yield / $total_weight_start) * 100);
                                        $wastePct = max(0, 100 - $yieldPct);
                                    @endphp
                                    <div class="bg-green-500 h-full transition-all" style="width: {{ $yieldPct }}%"></div>
                                    <div class="bg-red-500 h-full transition-all" style="width: {{ $wastePct }}%"></div>
                                @endif
                            </div>
                            <div class="w-48 text-right">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Merma (Desperdicio)</p>
                                <p class="text-2xl font-black {{ $this->waste_weight < 0 ? 'text-red-600' : 'text-red-500' }}">
                                    {{ number_format($this->waste_weight, 2) }} Kg
                                </p>
                            </div>
                        </div>
                        @if($this->waste_weight < 0)
                            <p class="text-red-500 text-xs font-bold mt-2">Error: El peso de los cortes es mayor al peso de la materia prima.</p>
                        @endif
                    </div>

                    <!-- Notas -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Notas u Observaciones (Opcional)</label>
                        <textarea wire:model="notes" rows="2" class="w-full shadow-sm text-sm border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: Mucha grasa en la media res recibida..."></textarea>
                    </div>

                </div>
                
                <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 text-right">
                    <button type="submit" class="inline-flex justify-center items-center gap-2 py-3 px-8 border border-transparent shadow-lg shadow-indigo-200 text-sm font-black rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition uppercase tracking-widest disabled:opacity-50" wire:loading.attr="disabled" {{ $this->waste_weight < 0 ? 'disabled' : '' }}>
                        <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg wire:loading wire:target="save" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardar y Actualizar Stock
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
