<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_number','status','subtotal','total',
        'payment_provider','payment_ref','delivery_details'
    ];

    protected $casts = [
        'delivery_details' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

