<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $quotes = Quote::with('movie', 'user', 'comments.user')
            ->filter($searchTerm)
            ->latest()
            ->get();

        return response()->json($quotes);
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
    public function store(StoreQuoteRequest $request)
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
    public function show(Quote $quote)
    {
        //
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
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
