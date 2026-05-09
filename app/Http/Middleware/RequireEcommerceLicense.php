<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireEcommerceLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\App\Services\LicenseService::isEcommerceEnabled()) {
            return response()->view('errors.ecommerce-disabled', [], 403);
            // Alternatively, redirect to login: return redirect()->route('login');
        }

        return $next($request);
    }
}
