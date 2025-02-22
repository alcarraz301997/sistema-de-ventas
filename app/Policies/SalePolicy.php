<?php

namespace App\Policies;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SalePolicy
{
    public function report(User $user): bool
    {
        return $user->hasRole('administrador');
    }

    public function store(User $user): bool
    {
        return $user->hasRole('administrador') || $user->hasRole('vendedor');
    }
}
