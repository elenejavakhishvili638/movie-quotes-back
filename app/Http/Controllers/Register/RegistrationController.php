<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Notifications\VerifyEmail;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $attributes = $request->validated();

        $password = $attributes['password'];

        $attributes['password'] = Hash::make($password);

        $user = User::create($attributes);

        auth()->login($user);

        return response()->json($user, 201);
    }
}
