<?php

namespace App\Http\Controllers;

use App\Events\CommentSent;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;


class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Quote $quote): JsonResponse
    {
        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        $comment = $quote->comments()->create($request->validated());

        $commentResource = new CommentResource($comment->load('user'));
        event(new CommentSent($commentResource));

        return response()->json($comment, 201);
    }
}
