<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SalePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver ventas
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sale $sale): bool
    {
        // Admins pueden ver todas las ventas
        if ($user->role === 'admin') {
            return true;
        }

        // Cajeros solo pueden ver sus propias ventas
        return $user->id === $sale->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Todos los usuarios autenticados pueden crear ventas
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sale $sale): bool
    {
        // Admins pueden actualizar cualquier venta
        if ($user->role === 'admin') {
            return true;
        }

        // Cajeros solo pueden actualizar sus propias ventas del día actual
        return $user->id === $sale->user_id 
            && $sale->created_at->isToday();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sale $sale): bool
    {
        // Solo admins pueden eliminar ventas
        // Esto previene que cajeros eliminen ventas para ocultar errores
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sale $sale): bool
    {
        // Solo admins pueden restaurar ventas eliminadas
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sale $sale): bool
    {
        // Solo admins pueden eliminar permanentemente
        return $user->role === 'admin';
    }
}
