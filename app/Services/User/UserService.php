<?php

namespace App\Services\User;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll($pagination)
    {
        return $this->userRepository->getAll($pagination);
    }

    public function getUserById($id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data): User
    {
        return DB::transaction(fn() => $this->userRepository->create($data));
    }

    public function updateUser(int $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {
            $user = $this->userRepository->findById($id) ?? throw new ResponseException(Error::CLIENT_ERROR, 'Usuario no encontrado.');
            $this->userRepository->update($user, $data);
            return $user->refresh();
        });
    }
}