<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\JsonResponse;
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

        $user->notify(new VerifyEmailNotification());

        return response()->json($user, 201);
    }
}
