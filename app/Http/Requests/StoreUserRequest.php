<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'alpha_num',
                'min:3',
                'max:15',
            ],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'alpha_num', 'min:8', 'max:15', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => [
                'en' => 'This email is already used',
                'ka' => 'ეს იმეილი უკვე გამოყენებულია',
            ],
        ];
    }
}
