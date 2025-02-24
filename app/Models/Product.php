<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'name', 'description', 'image', 'price', 'is_active', 'per_day'];


    public function getMedia(){
        return $this->belongsTo(Media::class, 'image');
    }

    public function imageProduct()
    {
        return $this->getMedia->original_file;
    }

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class);
    }
}
