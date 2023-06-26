<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return response()->json(201);
    }

    public function verifyNewEmail(Request $request)
    {
        if (!URL::hasValidSignature($request)) {
            return response()->json(["errors" => ["message" => "Invalid/Expired url provided."]], 401);
        }

        $token = $request->route('token');

        $newEmailDetails = Cache::get($token);

        if (!$newEmailDetails) {
            return response()->json(["errors" => ["message" => "Invalid/Expired token provided."]], 401);
        }

        $user = User::find($newEmailDetails['user_id']);

        if (!$user || $request->route('hash') != sha1($newEmailDetails['new_email'])) {
            return response()->json(["errors" => ["message" => "Invalid/Expired url provided."]], 401);
        }

        $user->email = $newEmailDetails['new_email'];
        $user->save();

        Cache::forget($token);

        return response()->json(['status' => 'Email updated successfully.']);
    }

    public function resend(Request $request)
    {
        $user = Auth::user(); 

        $user->notify(new VerifyEmailNotification());

        return response(['message' => 'Verification link resent.']);
    }
}
