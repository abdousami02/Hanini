<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'variation', 'price', 'tax', 'discount','coupon_discount','shipping_cost', 'qte','is_refundable'];

    protected $casts = [
        'shipping_cost' => 'array',
        'coupon_discount' => 'array',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
