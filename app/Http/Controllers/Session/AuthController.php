<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['username'])->orWhere('username', $attributes['username'])->first();

        $remember = request()->has('remember');

        if ($user && Hash::check($attributes['password'], $user->password)) {
            Auth::login($user, $remember);

            session()->regenerate();

            return response()->json(auth()->user());
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
