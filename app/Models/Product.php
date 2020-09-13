<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'images_urls' => 'array',
    ];
    protected $fillable = [
        'description', 'images_urls'
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

}
