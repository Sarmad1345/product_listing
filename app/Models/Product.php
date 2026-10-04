<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
