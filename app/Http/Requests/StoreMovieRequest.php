<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreMovieRequest extends FormRequest
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
            'title.en' => [
                'required',
                'unique:movies,title->en',
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'title.ka' => [
                'required',
                'unique:movies,title->ka',
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'description.en' => [
                'required',
                'unique:movies,description->en',
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'description.ka' => [
                'required',
                'unique:movies,description->ka',
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'director.en' => [
                'required',
                'unique:movies,director->en',
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'director.ka' => [
                'required',
                'unique:movies,director->ka',
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'image' =>  ['required', 'image'],
            'year' => ['required'],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ];
    }
}
