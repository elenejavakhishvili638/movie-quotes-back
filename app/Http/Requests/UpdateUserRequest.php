<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $user = User::findOrFail(request()->route('id'));

        return [
            'username' =>  'sometimes|required',
            'email' =>  'sometimes|required|email|unique:users,email,' . $user->id,
            'image' =>  'sometimes|required|image',
        ];
    }
}
