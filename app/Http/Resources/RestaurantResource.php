<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'location' => $this->location,
            'created_at' => $this->formattedCreatedAt,
            'menu_items' => $this->whenLoaded('menuItems'),
            'orders' => $this->whenLoaded('orders')
        ];
    }
}
