<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user, User $model = null): bool
    {
        return $user->hasRole('administrador');
    }

    public function view(User $user, User $model = null): bool
    {
        return $user->hasRole('administrador');
    }

    public function create(User $user, User $model = null): bool
    {
        return $user->hasRole('administrador');
    }

    public function update(User $user, User $model = null): bool
    {
        return $user->hasRole('administrador');
    }
}
