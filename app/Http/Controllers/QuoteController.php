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
    public function index(Request $request): JsonResponse
    {
        $searchTerm = $request->query('search');
        $quotesPerPage = 5;

        $quotes = Quote::with('movie', 'user', 'comments.user', 'likes')
            ->filter($searchTerm)
            ->latest()
            ->paginate($quotesPerPage);

        return new JsonResponse(QuoteResource::collection($quotes));
    }

    public function show(Quote $quote): JsonResponse
    {
        $quote->load(['user', 'comments.user', 'likes']);
        return response()->json(new QuoteResource($quote));
    }

    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $attributes['image'] = request()->file('image')->store('images');

        $quote = Quote::create($attributes);

        return response()->json($quote, 201);
    }

    public function update(UpdateQuoteRequest $request, $id): JsonResponse
    {
        $attributes = $request->validated();
        $quote = Quote::find($id);

        if ($request->hasFile('image')) {
            $attributes['image'] = request()->file('image')->store('images');
        }

        $quote->update($attributes);

        return response()->json($quote, 201);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        // $quote = Quote::find($id);

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
