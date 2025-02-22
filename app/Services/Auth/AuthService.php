<?php

namespace App\Services\Auth;

use App\Constans\Error;
use App\Exceptions\ResponseException;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function login(string $email, string $password): ?array
    {
        try {
            $user = $this->userRepository->findByEmail($email);

            if (!$user || !Hash::check($password, $user->password)) throw new ResponseException(Error::TOKEN_EXPIRED, "Credenciales incorrectas.", "error");

            $token = $user->createToken('API Token')->plainTextToken;

            return [
                'user'  => $user,
                'token' => $token,
            ];
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}