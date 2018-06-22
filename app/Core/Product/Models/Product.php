<?php

namespace App\Core\Product\Models;

use App\Core\Review\Models\Review;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'detail', 'price', 'stock', 'discount'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
