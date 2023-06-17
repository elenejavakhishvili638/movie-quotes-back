<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page', 1);
        $quotesPerPage = 5;

        $quotes = Quote::with('movie', 'user', 'comments.user')
            ->filter($searchTerm)
            ->latest()
            ->paginate($quotesPerPage, ['*'], 'page', $page);

        return new JsonResponse(QuoteResource::collection($quotes));
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
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $attributes['image'] = request()->file('image')->store('images');

        $quote = new Quote;

        $quote->setTranslations('body', [
            'en' => $attributes['body']['en'],
            'ka' => $attributes['body']['ka']
        ])->setAttribute('image', $attributes['image'])
            ->setAttribute('user_id', $attributes['user_id'])
            ->setAttribute('movie_id', $attributes['movie_id']);

        $quote->save();



        return response()->json($quote, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quote = Quote::with('comments.user', 'user')->find($id);
        return response()->json($quote);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteRequest $request, $id)
    {
        $attributes = $request->validated();
        $quote = Quote::find($id);

        if ($request->hasFile('image')) {
            $attributes['image'] = request()->file('image')->store('images');
        }

        $quote->setTranslations('body', [
            'en' => $attributes['body']['en'],
            'ka' => $attributes['body']['ka']
        ])
            ->setAttribute('movie_id', $attributes['movie_id'])
            ->setAttribute('user_id', $attributes['user_id']);

        if (isset($attributes['image'])) {
            $quote->setAttribute('image', $attributes['image']);
        }

        $quote->save();

        return response()->json($quote, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $quote = Quote::find($id);

        if ($quote) {
            $quote->delete();
            return response()->json([
                'message' => 'quote deleted successfully.'
            ], 200);
        }

        return response()->json([
            'message' => 'quote not found.'
        ], 404);
    }
}
