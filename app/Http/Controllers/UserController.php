<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(PaginateRequest $request)
    {
        $users = $this->userService->getAll($request);
        return $this->response($users, 'OK');
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return $this->response($user, 'OK');
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->createUser($request->all());
        return $this->response($user, 'Usuario creado.');
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->all());
        return $this->response($user, 'Usuario editado.');
    }
}
