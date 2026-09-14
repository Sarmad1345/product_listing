<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'image',
        'seller_name',
        'seller_avatar',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
