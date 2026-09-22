<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_id', 'guest_name', 'guest_first_name', 'guest_last_name',
        'guest_email', 'guest_phone', 'guest_address', 'guest_city', 'guest_province',
        'guest_postal_code', 'guest_vehicle_number', 'guest_id_proof',
        'subtotal', 'tax_amount', 'loyalty_discount', 'pet_fee_total', 'laundry_fee_total', 'grand_total',
        'stripe_payment_intent_id', 'stripe_charge_id', 'payment_status',
        'checkout_status', 'checked_out_at',
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
