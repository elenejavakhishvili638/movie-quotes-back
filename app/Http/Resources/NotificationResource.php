<?php

namespace App\Http\Resources;

use App\Http\Resources\ActionUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => $this->type,
            'created_at' => $this->created_at,
            'read_at' => $this->read_at,
            'user_id' => $this->user_id,
            'action_user_id' => $this->action_user_id,
            'actionUser' => new ActionUserResource($this->whenLoaded('actionUser')),
        ];
    }
}
