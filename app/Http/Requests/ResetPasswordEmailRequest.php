<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordEmailRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => [
                'en' => 'This email is incorrect',
                'ka' => 'იმეილი არასწორია',
            ],
        ];
    }
}
