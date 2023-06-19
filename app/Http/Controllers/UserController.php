<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


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

        $user->update($attributes);

        return response()->json($user, 201);
    }
}
