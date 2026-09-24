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
        'checkout_status', 'checked_in_at', 'checked_out_at', 'cancelled_at', 'cancellation_reason',
        'booking_type', 'notes'
    ];

    /**
     * Where this booking sits in the stay lifecycle.
     *
     * Four of the five states are stored in checkout_status. "no_show" is
     * derived instead: a booking still waiting to be checked in after its last
     * check-out date has passed is one nobody turned up for. Deriving it keeps
     * it correct without a nightly job flipping rows.
     *
     * @return 'cancelled'|'checked_out'|'checked_in'|'no_show'|'awaiting'
     */
    public function stayState(): string
    {
        if (in_array($this->checkout_status, ['cancelled', 'checked_out', 'checked_in'], true)) {
            return $this->checkout_status;
        }

        $lastCheckOut = $this->items->max('check_out');

        if ($lastCheckOut && \Carbon\Carbon::parse($lastCheckOut)->endOfDay()->isPast()) {
            return 'no_show';
        }

        return 'awaiting';
    }

    public function stayLabel(): string
    {
        return [
            'cancelled'   => 'Cancelled',
            'checked_out' => 'Checked out',
            'checked_in'  => 'In house',
            'no_show'     => 'No show',
            'awaiting'    => 'Awaiting arrival',
        ][$this->stayState()];
    }

    /** Only a stay that has not ended, been cancelled or been used can be checked in. */
    public function canCheckIn(): bool
    {
        return $this->stayState() === 'awaiting';
    }

    public function canCheckOut(): bool
    {
        return $this->stayState() === 'checked_in';
    }

    public function canCancel(): bool
    {
        return in_array($this->stayState(), ['awaiting', 'checked_in', 'no_show'], true);
    }

    /**
     * Rooms actually booked, not the number of line items.
     *
     * One line item can hold several rooms of the same type, so counting rows
     * would report a six-room booking as one room.
     */
    public function roomCount(): int
    {
        return (int) $this->items->sum('rooms');
    }

    /**
     * Whether the guest themselves may cancel this booking.
     *
     * Narrower than canCancel(): staff can still cancel a stay that is already
     * in house or was a no-show, but once a guest has arrived — or their dates
     * have passed — cancelling is a front-desk decision, not a self-service one.
     */
    public function canCustomerCancel(): bool
    {
        return $this->stayState() === 'awaiting';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
