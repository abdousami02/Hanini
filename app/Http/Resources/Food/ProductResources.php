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
        return [
            'id'    => (int) $this->id,
            'image' => getEncodeImage($this->imageProduct()),
            'name'  => $this->name,
            'price' => (int) $this->price,
            'currency' => 'DA',
            'description' => $this->description,
        ];
    }
}
