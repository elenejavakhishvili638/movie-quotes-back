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
    public function store(StoreCommentRequest $request, $id): JsonResponse
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        $comment = $quote->comments()->create($request->validated());

        $comment['sender'] = auth('sanctum')->user()->username;

        // event(new CommentSent($comment));
        $commentResource = new CommentResource($comment->load('user'));
        event(new CommentSent($commentResource));

        return response()->json($comment, 201);
    }
}
