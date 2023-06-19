<?php

namespace App\Http\Resources;

use App\Http\Resources\LikeResource;
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
            'google_id' => $this->google_id,
            'email_verified_at' => $this->email_verified_at,
            'username' => $this->username,
            'email' => $this->email,
            'image' => $this->image,
            'like' => LikeResource::collection($this->whenLoaded('likes'))
        ];
    }
}
