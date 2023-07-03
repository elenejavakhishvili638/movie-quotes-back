<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class StoreMovieRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = Auth::id();
        return [
            'title.en' => [
                'required',
                Rule::unique('movies', 'title->en')->where('user_id', $userId), 
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'title.ka' => [
                'required',
                Rule::unique('movies', 'title->ka')->where('user_id', $userId), 
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'description.en' => [
                'required',
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'description.ka' => [
                'required',
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'director.en' => [
                'required',
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'director.ka' => [
                'required',
                'regex:/^[\p{Georgian}0-9\s\p{P}]*$/u',
            ],
            'image' =>  ['required', 'image'],
            'year' => ['required'],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'genres' => 'required',
            'genres.*' => 'exists:genres,id',
        ];
    }

    public function messages()
    {
        return [
            'title.en.unique' => [
                'en' => 'Movie already exists',
                'ka' => 'ამ სათაურით ფილმი უკვე არსებობს',
            ],
            'title.ka.unique' => [
                'en' => 'Movie already exists',
                'ka' => 'ამ სათაურით ფილმი უკვე არსებობს',
            ],
        ];
    }
}
