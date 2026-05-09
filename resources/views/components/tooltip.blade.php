@props(['text'])

<div x-data="{ open: false }" class="relative inline-block" @mouseenter="open = true" @mouseleave="open = false">
    <svg class="w-4 h-4 text-gray-300 cursor-help hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute z-50 w-64 px-4 py-3 text-xs font-bold text-white bg-gray-900 rounded-2xl shadow-2xl -left-28 bottom-full mb-2 pointer-events-none">
        {{ $text }}
        <div class="absolute w-3 h-3 bg-gray-900 rotate-45 left-1/2 -translate-x-1/2 -bottom-1.5"></div>
    </div>
</div>
