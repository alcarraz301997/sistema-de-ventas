<?php

namespace App\Services;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        try {
            return $this->userRepository->getAll();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUserById(int $id): ?User
    {
        try {
            $user = $this->userRepository->findById($id);
            if (!$user) throw new ResponseException(Error::CLIENT_ERROR, 'Usuario no encontrado');
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createUser(array $data): User
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function updateUser(int $id, array $data): User
    {
        try {
            $user = $this->userRepository->findById($id);
            $this->userRepository->update($user, $data);
            return $user->refresh();
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}