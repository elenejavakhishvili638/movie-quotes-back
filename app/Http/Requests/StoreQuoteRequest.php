<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreQuoteRequest extends FormRequest
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
            'body.en' => [
                'required',
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'body.ka' => [
                'required',
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'image' =>  ['required', 'image'],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'movie_id' => ['required', Rule::exists('movies', 'id')],
        ];
    }
    public function messages()
    {
        return [
            'image.image' => [
                'en' => 'The image field must be an image.',
                'ka' => 'სურათის ფორმატი არასწორია',
            ],
        ];
    }
}
