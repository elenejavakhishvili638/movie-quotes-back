<?php

namespace App\Http\Controllers;

use App\Events\LikeSent;
use App\Events\UnlikeSent;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request, Quote $quote): JsonResponse
    {
        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        $existingLike = $quote->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {
            return response()->json(['error' => 'You have already liked this quote.'], 409);
        }
        $like = $quote->likes()->create($request->validated());
        $likeResource = new LikeResource($like->load('user'));
        event(new LikeSent($likeResource));

        return response()->json($like, 201);
    }


    public function destroy(Quote $quote): JsonResponse
    {
        if (!$quote) {
            return response()->json(['message' => 'Quote not found.'], 404);
        }

        $like = $quote->likes()->where('user_id', auth()->id())->first();
        event(new UnlikeSent($like));

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
