<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_id', 'guest_name', 'guest_email', 'guest_phone',
        'subtotal', 'tax_amount', 'loyalty_discount', 'grand_total',
        'stripe_payment_intent_id', 'stripe_charge_id', 'payment_status',
        'booking_type', 'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
