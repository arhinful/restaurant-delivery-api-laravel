<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->location,
            'image' => MediaResource::make($this->getFirstMedia('image')),
            'created_at' => $this->formattedCreatedAt,
            'restaurant' => RestaurantResource::make($this->whenLoaded('restaurant')),
            'orders' => OrderResource::collection($this->whenLoaded('orders'))
        ];
    }
}
