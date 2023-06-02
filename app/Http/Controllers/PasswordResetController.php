<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordEmailRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function storeEmail(ResetPasswordEmailRequest $request)
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        $token = app('auth.password.broker')->createToken($user);
        $frontEndUrl = env('FRONTEND_URL', 'http://localhost:8081');
        $url = url($frontEndUrl . '/reset-password/' . $token . '?email=' . $attributes['email'] . '&email=true');

        $user->notify(new ResetPasswordNotification($url));

        return response()->json(201);
    }
}
