<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Models\Like;
use App\Models\Quote;

class LikeController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreLikeRequest $request, $id)
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }


        $existingLike = $quote->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {

            return response()->json(['error' => 'You have already liked this quote.'], 409);
        }


        $like = $quote->likes()->create(['user_id' => auth()->id()]);

        return response()->json($like, 201);
    }


    public function destroy($id)
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['message' => 'Quote not found.'], 404);
        }

        $like = $quote->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            return response()->json([
                'message' => 'Like deleted successfully.'
            ], 200);
        }

        return response()->json([
            'message' => 'Like not found.'
        ], 404);
    }
}
