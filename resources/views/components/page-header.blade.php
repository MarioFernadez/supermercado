@props([
    'title' => '',
    'section' => '',
    'badge' => null,
])

<div class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 px-4 sm:px-6 lg:px-8 py-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            @if($section)
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5 dark:text-gray-500" style="font-family: 'Inter', sans-serif;">
                    {{ $section }}
                </p>
            @endif
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-black text-gray-900 tracking-tight dark:text-white" style="font-family: 'Inter', sans-serif;">
                    {{ $title }}
                </h1>
                @if($badge)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-900/40 dark:text-indigo-300 dark:border-indigo-800">
                        {{ $badge }}
                    </span>
                @endif
            </div>
        </div>

        @if(isset($actions) && $actions->isNotEmpty())
            <div class="flex flex-wrap items-center gap-2">
                {{ $actions }}
            </div>
        @elseif(isset($slot) && !empty(trim($slot)))
            <div class="flex flex-wrap items-center gap-2">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
