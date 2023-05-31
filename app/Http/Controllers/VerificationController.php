<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Log;

class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        auth()->logout();

        return response()->json(201);
    }
}
