<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $movies = [];
        Log::info('sss'.auth()->user());
        if (auth()->check()) {
            $searchTerm = $request->query('search');
            $movies = MovieResource::collection(
                auth()->user()->movies()
                    ->with([
                        'quotes' => function ($query) {
                            $query->latest();
                        },
                        'genres',
                        'quotes.comments.user',
                        'quotes.user',
                        'quotes.likes'
                    ])
                    ->latest()
                    ->filter($searchTerm)
                    ->get()
            );
        }

        return response()->json($movies);
    }

    public function store(StoreMovieRequest $request): JsonResponse
    {
        $attributes = $request->validated();


        $attributes['image'] = request()->file('image')->store('images');
        $movie = Movie::create($attributes);
        $movie->genres()->sync($request->genres);

        return response()->json($movie, 201);
    }


    public function show($id): JsonResponse
    {
        $movie = Movie::with(['quotes.comments.user', 'genres', 'quotes.user', 'quotes.likes'])->find($id);
        return response()->json(new MovieResource($movie));
    }


    public function update(UpdateMovieRequest $request, $id): JsonResponse
    {
        $attributes = $request->validated();

        $movie = Movie::find($id);

        if ($request->hasFile('image')) {
            $attributes['image'] = request()->file('image')->store('images');
        }

        $movie->update($attributes);

        $movie->genres()->sync($request->genres);

        return response()->json($movie, 201);
    }

    public function destroy($id): JsonResponse
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
