<div class="relative w-full" x-data="{ open: @entangle('showDropdown').live }" @click.outside="open = false">
    <div class="relative group">
        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-600 transition dark:text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        
        <input type="text" 
               wire:model.live.debounce.300ms="query"
               @keydown.enter="$wire.search()"
               placeholder="Buscar productos..." 
               class="w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 border-2 border-indigo-600 dark:border-indigo-500 rounded-full py-2.5 pl-11 pr-10 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition shadow-sm font-medium">

        @if(strlen($query) > 0)
            <button wire:click="clear" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition dark:text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        @endif
    </div>

    <!-- Dropdown Results -->
    <div x-show="open && {{ count($results) }} > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="absolute z-[100] mt-2 w-full bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden py-2" 
         x-cloak>
        
        <div class="max-h-[400px] overflow-y-auto no-scrollbar">
            @foreach($results as $product)
                <button wire:click="selectProduct('{{ $product->slug }}')" class="w-full flex items-center gap-4 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/60 transition text-left group">
                    <div class="w-9 h-9 rounded-full border border-gray-100 dark:border-gray-600 flex items-center justify-center flex-shrink-0 bg-white dark:bg-gray-800 shadow-sm transition">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wide truncate">{{ $product->name }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- No Results State -->
    <div x-show="open && {{ count($results) }} === 0 && $wire.query.length >= 2" 
         class="absolute z-[100] mt-2 w-full bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-700 p-6 text-center" 
         x-cloak>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No hay coincidencias para "{{ $query }}"</p>
    </div>
</div>
