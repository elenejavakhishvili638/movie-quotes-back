<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function store()
    {

        $user = User::create();

        auth()->login($user);

        return response()->json($user, 201);
    }
}
