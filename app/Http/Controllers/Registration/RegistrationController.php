<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function store(StoreUserRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $password = $attributes['password'];

        $attributes['password'] = Hash::make($password);

        $user = User::create($attributes);

        auth()->login($user);

        return response()->json($user, 201);
    }
}
