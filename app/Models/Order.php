<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 
        'user_id', 
        'code',
        // 'billing_address', 
        'shipping_address',
        'status',
        'payment_type',
        'payment_status',
        'payment_details',
        'sub_total',
        'discount', 
        'coupon_discount',
        'total_tax',
        'total_amount',
        'shipping_cost',
        'total_payable',
        'date',
        'viewed',
        'is_mailed',
        'shipping_method',
        
        // 'trx_id',
        // 'tax_method',
        // 'delivery_viewed',
        // 'payment_status_viewed',
        // 'commission_calculated',
        // 'is_cancelled',
        // 'is_deleted',
        // 'pickup_hub_id',
        // 'is_refundable',
        // 'created_by',
        // 'is_draft',
        // 'offline_method_id',
        // 'offline_method_file',
        // 'cancel_request',
        // 'cancel_request_at',
        // 'delivery_hero_assign_at',
        // 'is_coupon_system_active',

        // 'maystro_id', 
        // 'maystro_db_id',
        // 'maystro_status',
        // 'paid_to_store',
        // 'paid_to_store_at',
        // 'paid_to_store_by',
        // 'payment_recieved',
        // 'payment_recieved_at',
        // 'payment_recieved_by'
    ];
    protected $casts = [
        // 'billing_address' => 'array',
        'shipping_address' => 'array',
        'payment_details' => 'array',
        // 'offline_method_file' => 'array',
        // 'tax_method' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
