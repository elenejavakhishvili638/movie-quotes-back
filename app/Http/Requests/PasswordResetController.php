<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;


class PasswordResetController extends Controller
{

    public function storeEmail(ResetPasswordEmailRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        $token = app('auth.password.broker')->createToken($user);
        $url = url('/reset-password/' . $token . '?email=' . $attributes['email']);
        $user->notify(new ResetPasswordNotification($url));

        return redirect()->route('verifyEmail.confirmation');
    }

    public function showReset(Request $request, string $token): View
    {
        $email = $request->query('email');
        return view('resetPassword.reset', ['token' => $token, 'email' => $email]);
    }

    public function update(ResetPasswordRequest $request): mixed
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


        return view('resetPassword.update');
    }
}
