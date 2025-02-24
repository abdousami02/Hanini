<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'mobile', 'email', 'address', 'status'];


    public function user()
    {
        $this->belongsTo(User::class);
    }
}
