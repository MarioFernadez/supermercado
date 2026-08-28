<?php

namespace App\Policies;

use App\Models\CashSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CashSessionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver sesiones de caja
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CashSession $cashSession): bool
    {
        // Admins pueden ver todas las sesiones
        if ($user->role === 'admin') {
            return true;
        }

        // Usuarios solo pueden ver sus propias sesiones
        return $user->id === $cashSession->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Verificar que el usuario no tenga una sesión abierta
        $hasOpenSession = CashSession::where('user_id', $user->id)
            ->where('status', 'open')
            ->exists();

        return !$hasOpenSession;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CashSession $cashSession): bool
    {
        // Solo el dueño de la sesión puede actualizarla
        // Y solo si está abierta
        return $user->id === $cashSession->user_id 
            && $cashSession->status === 'open';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CashSession $cashSession): bool
    {
        // Solo admins pueden eliminar sesiones
        // Y solo si están cerradas (para mantener integridad)
        return $user->role === 'admin' 
            && $cashSession->status === 'closed';
    }

    /**
     * Determine whether the user can close the session.
     */
    public function close(User $user, CashSession $cashSession): bool
    {
        // Solo el dueño puede cerrar su sesión
        // Y solo si está abierta
        return $user->id === $cashSession->user_id 
            && $cashSession->status === 'open';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CashSession $cashSession): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CashSession $cashSession): bool
    {
        return $user->role === 'admin';
    }
}
