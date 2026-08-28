@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 pt-5 pb-4 border-b border-gray-100 dark:border-gray-700/80 bg-gray-50/40 dark:bg-gray-900/30">
        <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
            {{ $title }}
        </div>
    </div>

    <div class="px-6 py-5 text-sm text-gray-600 dark:text-gray-400">
        {{ $content }}
    </div>

    <div class="flex flex-row justify-end items-center gap-2 px-6 py-3.5 bg-gray-50/80 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700/80 text-end">
        {{ $footer }}
    </div>
</x-modal>
