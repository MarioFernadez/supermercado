<div class="relative w-full" x-data="{ open: @entangle('showDropdown').live }" @click.outside="open = false">
    <div class="relative group">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        
        <input type="text" 
               wire:model.live.debounce.300ms="query"
               @keydown.enter="$wire.search()"
               placeholder="Buscar productos..." 
               class="w-full bg-[#F6F6F8] border-none rounded-full py-2.5 pl-10 pr-10 focus:ring-2 focus:ring-indigo-500 transition shadow-inner uppercase tracking-widest text-xs">

        @if(strlen($query) > 0)
            <button wire:click="clear" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        @endif
    </div>

    <!-- Dropdown Results -->
    <div x-show="open && {{ count($results) }} > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="absolute z-[100] mt-2 w-full bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden" 
         x-cloak>
        
        <div class="divide-y divide-gray-50 max-h-[400px] overflow-y-auto">
            @foreach($results as $product)
                <div class="w-full flex items-center gap-4 p-4 hover:bg-gray-50/80 transition text-left group relative">
                    <!-- Image and Info Link -->
                    <button wire:click="selectProduct('{{ $product->slug }}')" class="flex flex-1 items-center gap-4 text-left min-w-0">
                        <div class="h-16 w-16 bg-gray-50 rounded-xl border border-gray-100 flex-shrink-0 overflow-hidden">
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-indigo-500 transition-colors">
                                Ref: {{ $product->sku ?? 'N/A' }}
                            </div>
                            <h4 class="text-sm font-bold text-gray-900 truncate tracking-tight uppercase">{{ $product->name }}</h4>
                            <div class="text-sm font-bold text-emerald-600 mt-0.5">
                                ₲ {{ number_format($product->effective_price, 0, ',', '.') }}
                            </div>
                        </div>
                    </button>

                    <!-- Add to Cart Button -->
                    <button @click="addItem({
                        id: '{{ $product->id }}',
                        name: '{{ addslashes($product->name) }}',
                        price_sale: {{ $product->effective_price }},
                        image_url: '{{ $product->image_path ? Storage::url($product->image_path) : '' }}',
                        category: '{{ addslashes($product->category->name ?? 'Varios') }}'
                    })" 
                    class="h-10 w-10 flex items-center justify-center bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:scale-110 active:scale-95 transition transform flex-shrink-0"
                    title="Agregar al carrito">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </button>
                </div>
            @endforeach
        </div>

        <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
            <button wire:click="search" class="text-[10px] font-bold uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition">
                Ver todos los resultados para "{{ $query }}"
            </button>
        </div>
    </div>

    <!-- No Results State -->
    <div x-show="open && {{ count($results) }} === 0 && query.length >= 2" 
         class="absolute z-50 mt-2 w-full bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 text-center" 
         x-cloak>
        <div class="p-3 bg-gray-50 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3 text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <p class="text-sm font-bold text-gray-900 uppercase tracking-tighter line-clamp-1">No hay coincidencias para "{{ $query }}"</p>
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Intenta con otros términos</p>
    </div>
</div>
