<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        // Gerente gate: admin OR gerente can pass
        \Illuminate\Support\Facades\Gate::define('gerente', function ($user) {
            return $user->isAdmin() || $user->isManager();
        });
    }
}
