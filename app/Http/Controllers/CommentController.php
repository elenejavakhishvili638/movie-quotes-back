<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(StoreCommentRequest $request, $id): JsonResponse
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }

        $comment = $quote->comments()->create($request->validated());

        return response()->json($comment, 201);
    }
}
