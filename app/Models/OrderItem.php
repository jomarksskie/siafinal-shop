<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'line_total',
    ];

    // ✅ each order item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ✅ each order item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
