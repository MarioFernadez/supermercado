<div class="min-h-screen flex flex-col justify-center sm:justify-center items-center pt-0 bg-white sm:bg-gray-100 dark:bg-gray-800 sm:dark:bg-gray-900 px-4 sm:px-0">
    <div>
        {{ $logo ?? '' }}
    </div>

    <div class="w-full sm:max-w-md mt-0 sm:mt-6 px-4 py-8 sm:px-6 sm:py-4 bg-white dark:bg-gray-800 shadow-none sm:shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
