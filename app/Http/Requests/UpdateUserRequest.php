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
            'username' =>  'sometimes|required|alpha_num|min:3|max:15',
            'email' =>  'sometimes|required|email|unique:users,email,' . $user->id,
            'image' =>  'sometimes|required|image',
            'password' => ['sometimes', 'alpha_num', 'min:8', 'max:15', 'confirmed'],
        ];
    }
}
