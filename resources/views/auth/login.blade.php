<x-guest-layout>
    <x-authentication-card>
        <div class="mb-8 text-center sm:mb-6">
            <h1 class="text-3xl font-black text-gray-900 dark:text-gray-100 sm:text-2xl uppercase tracking-tighter">
                Bienvenido a <span class="text-green-500">{{ \App\Services\LicenseService::isEcommerceEnabled() ? 'ZonaShop' : 'ZonaPOS' }}</span>
            </h1>
            
            <div class="mt-2">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-green-50 text-green-700 border border-green-100 dark:bg-green-950/40 dark:text-green-400 dark:border-green-900/60 shadow-sm">
                    {{ \App\Services\LicenseService::isEcommerceEnabled() ? 'Catálogo E-commerce' : 'Sistemas POS' }}
                </span>
            </div>

            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400 font-medium">
                Ingresa tus credenciales para acceder
            </p>
        </div>

        <x-validation-errors class="mb-4" />

        @if(request('expired'))
            <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-900 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2.5 shadow-sm dark:bg-amber-950/40 dark:border-amber-900/60 dark:text-amber-300">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Tu sesión ha expirado por inactividad. Por favor, inicia sesión nuevamente para continuar.</span>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Usuario / Email') }}" class="font-bold text-xs uppercase tracking-widest text-gray-400" />
                <x-input id="email" class="block mt-1 w-full py-3 sm:py-2 px-4 rounded-xl border-gray-200 focus:ring-green-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-5">
                <x-label for="password" value="{{ __('Contraseña') }}" class="font-bold text-xs uppercase tracking-widest text-gray-400" />
                <x-input id="password" class="block mt-1 w-full py-3 sm:py-2 px-4 rounded-xl border-gray-200 focus:ring-green-500" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
                </label>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-4 sm:py-2 bg-green-500 border border-transparent rounded-xl sm:rounded-md font-black text-sm text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-lg shadow-green-500/30 transition ease-in-out duration-150">
                    {{ __('Iniciar Sesión') }}
                </button>
            </div>
            
            <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
                ZonaPOS® es un producto digital desarrollado por <a href="https://soteweb.com" target="_blank" class="text-green-500 hover:text-green-600 font-bold hover:underline">Soteweb Tecnología</a>
                <div class="mt-2 flex justify-center items-center gap-1">
                    Made in <img src="https://flagcdn.com/w20/py.png" srcset="https://flagcdn.com/w40/py.png 2x" width="20" alt="Paraguay">
                </div>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
