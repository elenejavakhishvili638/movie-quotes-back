<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function storeEmail(ResetPasswordEmailRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        $token = app('auth.password.broker')->createToken($user);
        $frontEndUrl = env('FRONTEND_URL', 'http://localhost:8081');
        $url = url($frontEndUrl . '/reset-password/' . $token . '?email=' . $attributes['email'] . '&modal=true');

        $user->notify(new ResetPasswordNotification($url));

        return response()->json(201);
    }

    public function update(ResetPasswordRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        return response()->json(201);
    }
}
