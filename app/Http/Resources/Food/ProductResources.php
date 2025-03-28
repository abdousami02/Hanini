<?php

namespace App\Http\Resources\Food;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // "id": 44,
        // "image": "http://hanini-food.com/image/menu.jpg" // urlencode(),
        // "name": "Fool",
        // "price": 1234,
        // "price_promo": null,
        // "currency": "DA",
        // "reviews": 5,
        // "vendor_id": 23,
        // "vendor_name": "Machawi"

        return [
            'id'    => (int) $this->id,
            'image' => getEncodeImage($this->imageProduct()),
            'name'  => $this->name,
            'price' => (int) $this->price,
            "price_promo"=> null,
            'currency' => 'DA',
            "reviews"=> (int) 4.5,
            'description' => $this->description,
            "vendor_id"=> 23,
            "vendor_name"=> "Machawi"
        ];
    }
}
