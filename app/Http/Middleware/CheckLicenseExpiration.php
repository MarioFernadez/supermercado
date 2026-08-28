<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\LicenseService;

class CheckLicenseExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está autenticado, pasa al flujo estándar
        if (!auth()->check()) {
            return $next($request);
        }

        // El desarrollador/proveedor nunca es bloqueado
        if (auth()->user()->isDeveloper()) {
            return $next($request);
        }

        // Si la licencia no ha expirado, pasa con normalidad
        if (!LicenseService::isExpired()) {
            return $next($request);
        }

        // Rutas exceptuadas del bloqueo
        if (
            $request->routeIs('logout') ||
            $request->routeIs('settings.billing') ||
            $request->routeIs('master.*') ||
            $request->routeIs('livewire.update') ||
            $request->hasHeader('X-Livewire')
        ) {
            return $next($request);
        }

        // Redirige al panel de suscripción e historial con un mensaje de advertencia
        return redirect()->route('settings.billing')->with('error', 'El sistema se encuentra bloqueado por vencimiento de licencia. Por favor, regularice su pago.');
    }
}
