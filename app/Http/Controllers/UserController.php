<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\UpdateEmailNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('likes');
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $attributes = $request->validated();

        $user = User::find($id);

        if ($request->hasFile('image')) {
            $attributes['image'] = request()->file('image')->store('images');
        }

        if (isset($attributes['image'])) {
            $user->setAttribute('image', $attributes['image']);
        }

        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }


        if (isset($attributes['email'])) {
            $newEmail = $attributes['email'];
            unset($attributes['email']);

            $originalEmail = $user->email;
            $user->email = $newEmail;

            $user->notify(new UpdateEmailNotification($newEmail));


            $user->email = $originalEmail;
        }

        $user->update($attributes);

        return response()->json($user, 201);
    }
}
