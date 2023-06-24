<?php

namespace App\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Http\Resources\MinimalUserResource;
use App\Http\Resources\MovieResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->getTranslations('body'),
            'image' => $this->image,
            'user' => new MinimalUserResource($this->whenLoaded('user')),
            'movie' => new MovieQuoteResource($this->whenLoaded('movie')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
        ];
    }
}
