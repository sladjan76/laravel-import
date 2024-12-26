<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends ImportableModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sku',
        'name',
        'category',
        'price',
        'stock'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'sku', 'sku');
    }

}
