<div class="min-h-screen flex flex-col justify-center sm:justify-center items-center pt-0 bg-gray-50/50 sm:bg-gray-100/70 dark:bg-gray-900 px-4 sm:px-0">
    <div>
        {{ $logo ?? '' }}
    </div>

    <div class="w-full sm:max-w-md mt-0 sm:mt-6 px-6 py-8 sm:px-8 sm:py-8 bg-white dark:bg-gray-800 shadow-sm sm:shadow-xl border border-gray-100 dark:border-gray-700/80 overflow-hidden rounded-2xl sm:rounded-3xl font-sans">
        {{ $slot }}
    </div>
</div>
