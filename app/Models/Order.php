<?php

namespace App\Models;

class Order extends ImportableModel
{
    protected $fillable = [
        'order_date',
        'channel',
        'sku',
        'item_description',
        'origin',
        'so_num',
        'cost',
        'shipping_cost',
        'total_price'
    ];

    protected $casts = [
        'order_date' => 'date',
        'cost' => 'double',
        'shipping_cost' => 'double',
        'total_price' => 'double'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('so_num', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('item_description', 'like', "%{$search}%")
                ->orWhere('channel', 'like', "%{$search}%")
                ->orWhere('origin', 'like', "%{$search}%");
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'sku', 'sku');
    }
}
