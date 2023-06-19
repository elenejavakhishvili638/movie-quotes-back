<?php

namespace App\Http\Resources;

use App\Http\Resources\GenreResource;
use App\Http\Resources\QuoteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'title' => $this->getTranslations('title'),
            'image' => $this->image,
            'year' => $this->year,
            'description' => $this->getTranslations('description'),
            'director' =>  $this->getTranslations('director'),
            'quotes' => QuoteResource::collection($this->whenLoaded('quotes')),
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
        ];
    }
}
