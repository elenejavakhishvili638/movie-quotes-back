<?php

namespace App\Http\Resources;

use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'image' => $this->image,
            'movies' => MovieResource::collection($this->whenLoaded('movies')),
            // 'quotes' => QuoteResource::collection($this->whenLoaded('quotes')),
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
