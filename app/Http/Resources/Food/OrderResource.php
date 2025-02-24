<?php

namespace App\Http\Resources\Food;

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
        // $address = (object) $this->shipping_address;
        // return [
        //     'id'        => $this->id,
        //     'seller_id' => $this->seller_id,
        //     // 'seller_name' => $this->sellerProfile->name,
        //     'shipping_address' => [
        //         'name'      => $address->name,
        //         'mobile'    => $address->phone_no,
        //         'address'   => $address->address,
        //         'state'     => $address->state,
        //     ],
        //     'total_amount' => $this->total,
        //     // 'shipping_cost' => 0,
        //     // 'total_payable' => $this->total,
        //     'date' => parseDate($this->date),
        // ];

        $orderDetails = (object) $this->orderDetails[0];
        $product = (object) $this->orderDetails[0]->product;

        return [
            'id'        => $this->id,
            'image'     => getEncodeImage($product->imageProduct()),
            'name'      => $product->name,
            'price'     => $orderDetails->pric,
            'qte'       => $orderDetails->qte,
            'date'      => parseDate($this->date),
            'status'    => $this->status,
            'status_text' => __($this->status),
            'total_amount' => $this->total,
            'currency'  => 'DA',
        ];
        
    }
}
