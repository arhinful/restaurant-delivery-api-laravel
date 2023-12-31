<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'quantity' => $this->quantity,
            'location' => $this->location,
            'gps' => $this->gps,
            'mobile_number' => $this->mobile_number,

            'delivery_status' => $this->delivery_status,
            'payment_status' => $this->payment_status,
            'payment_channel' => $this->payment_channel,
            'price' => $this->price,

            'created_at' => $this->formattedCreatedAt,
            'user' => UserResource::make($this->whenLoaded('user')),
            'menu_item' => MenuItemResource::make($this->whenLoaded('menuItem')),
        ];
    }
}
