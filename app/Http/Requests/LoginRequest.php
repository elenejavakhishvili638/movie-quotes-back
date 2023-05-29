<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'min:3',, function ($attribute, $value, $fail) {
                $user = User::where('email', $value)->orWhere('username', $value)->first();
                if (!$user) {
                    return $fail(__('validation.custom.invalid_username', ['attribute' => __('validation.attributes.username')]));
                }
            }],
            'password' => ['required']
        ];
    }
}
