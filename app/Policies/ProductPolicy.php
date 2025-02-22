<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrador') || $user->hasRole('vendedor');
    }

    public function view(User $user): bool
    {
        return $user->hasRole('administrador') || $user->hasRole('vendedor');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('administrador') || $user->hasRole('vendedor');
    }

    public function update(User $user): bool
    {
        return $user->hasRole('administrador') || $user->hasRole('vendedor');
    }

    public function increase(User $user): bool
    {
        return $user->hasRole('administrador') || $user->hasRole('vendedor');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('administrador');
    }
}
