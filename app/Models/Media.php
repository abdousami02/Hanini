<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = ['name', 'user_id', 'folder_id', 'type', 'extension', 'size', 'original_file', 'image_variants'];

    protected $casts = [
        'image_variants' => 'array',
    ];
}
