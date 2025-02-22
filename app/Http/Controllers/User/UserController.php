<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(PaginateRequest $request)
    {
        $this->authorize('view', User::class);
        $users = $this->userService->getAll($request);
        return $this->response($users, 'OK');
    }

    public function show($id)
    {
        $this->authorize('viewAny', User::class);
        $user = $this->userService->getUserById($id);
        return $this->response($user, 'OK');
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);
        $user = $this->userService->createUser($request->all());
        return $this->response($user, 'Usuario creado.');
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $this->authorize('update', User::class);
        $user = $this->userService->updateUser($id, $request->all());
        return $this->response($user, 'Usuario editado.');
    }
}
