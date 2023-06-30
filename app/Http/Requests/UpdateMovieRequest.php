<?php

namespace App\Http\Requests;

use App\Models\Movie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
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
        $movie = Movie::findOrFail(request()->route('id'));

        return [
            'title.en' => [
                'required',
                'unique:movies,title->en,' . $movie->id,
                'regex:/^[a-zA-Z0-9\s\p{P}]*$/',
            ],
            'title.ka' => [
                'required',
                'unique:movies,title->ka,' . $movie->id,
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
            'image' =>  'sometimes|required|image',
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
                'en' => 'This title is already used',
                'ka' => 'ეს ფილმი უკვე გამოყენებულია',
            ],
            'title.ka.unique' => [
                'en' => 'This title is already used',
                'ka' => 'ეს ფილმი უკვე გამოყენებულია',
            ],
        ];
    }
}
