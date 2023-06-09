<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $movies = [];
        if (auth()->check()) {
            $searchTerm = $request->query('search');
            $movies = auth()->user()->movies()->latest()->filter($searchTerm)->get();
        }

        return response()->json($movies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): JsonResponse
    {
        $attributes = $request->validated();


        $attributes['image'] = request()->file('image')->store('images');

        $movie = new Movie;

        $movie->setTranslations('title', [
            'en' => $attributes['title']['en'],
            'ka' => $attributes['title']['ka']
        ])->setTranslations('description', [
            'en' => $attributes['description']['en'],
            'ka' => $attributes['description']['ka']
        ])->setTranslations('director', [
            'en' => $attributes['director']['en'],
            'ka' => $attributes['director']['ka']
        ])
            ->setAttribute('year', $attributes['year'])
            ->setAttribute('image', $attributes['image'])
            ->setAttribute('user_id', $attributes['user_id']);

        $movie->save();

        $movie->genres()->sync($request->genres);

        return response()->json($movie, 201);
    }

    /**
     * Display the specified resource.
     */

    public function show($id): JsonResponse
    {
        $movie = Movie::with(['quotes', 'genres'])->find($id);
        return response()->json($movie);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if ($movie) {
            $movie->delete();
            return response()->json([
                'message' => 'Movie deleted successfully.'
            ], 200);
        }

        return response()->json([
            'message' => 'Movie not found.'
        ], 404);
    }
}
