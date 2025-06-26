<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'main_category' => $this->main_category,
            'created_at' => $this->created_date,
            
            // Include the user name (if relationship is loaded)
            'owner_name' => [
                'name' => $this->user->name ?? null,
            ],
        ];
    }
}
