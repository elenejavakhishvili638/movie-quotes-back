<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleRegistrationController extends Controller
{
    public function redirect(): JsonResponse
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
                'username' => $googleUser->name,
                'email' => $googleUser->email,
                'image' => $googleUser->avatar
            ]);
        } else {
            $user->updateOrCreate([
                'email' => $googleUser->email,
            ]);
        }

        Auth::login($user, true);
        session()->regenerate();
        $frontEndUrl = env('FRONTEND_URL', 'http://localhost:8081');
        return redirect($frontEndUrl);
    }
}
