<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['username'])->orWhere('username', $attributes['username'])->first();

        if ($user && Hash::check($attributes['password'], $user->password)) {
            Auth::login($user);

            session()->regenerate();

            return response()->json(auth()->user());
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
}
