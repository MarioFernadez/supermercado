<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver clientes
    }

    public function view(User $user, Customer $customer): bool
    {
        return true; // Todos pueden ver clientes individuales
    }

    public function create(User $user): bool
    {
        return true; // Todos pueden crear clientes
    }

    public function update(User $user, Customer $customer): bool
    {
        return true; // Todos pueden actualizar clientes
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->role === 'admin'; // Solo admins pueden eliminar
    }

    public function restore(User $user, Customer $customer): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Customer $customer): bool
    {
        return $user->role === 'admin';
    }
}
