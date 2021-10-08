<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_card',
        'credit_card_expiration',
        'credit_card_cvv',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
