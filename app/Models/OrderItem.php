<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'listings_id', 'listing_name', 'check_in', 'check_out',
        'rooms', 'pets', 'laundry', 'price_per_night', 'nights', 'item_total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
