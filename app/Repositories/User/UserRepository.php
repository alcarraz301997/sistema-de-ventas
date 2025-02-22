<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    public function getAll($pagination)
    {
        return User::paginate($pagination->per_page, ['*'], 'page', $pagination->page);;
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }
}