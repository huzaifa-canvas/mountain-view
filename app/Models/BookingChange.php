<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One recorded move of a booking's dates.
 *
 * Written whenever a stay is rescheduled, so both the guest and the front desk
 * can see what the booking looked like before and who changed it.
 */
class BookingChange extends Model
{
    protected $fillable = [
        'order_id', 'changed_by', 'changed_by_name',
        'from_check_in', 'from_check_out', 'to_check_in', 'to_check_out',
        'from_total', 'to_total',
    ];

    protected $casts = [
        'from_check_in'  => 'date',
        'from_check_out' => 'date',
        'to_check_in'    => 'date',
        'to_check_out'   => 'date',
        'from_total'     => 'decimal:2',
        'to_total'       => 'decimal:2',
    ];

    /** What the change cost or saved; positive means the guest owes more. */
    public function totalDifference(): ?float
    {
        if ($this->from_total === null || $this->to_total === null) {
            return null;
        }

        return round((float) $this->to_total - (float) $this->from_total, 2);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /** How many days the stay moved, negative when it was brought forward. */
    public function shiftInDays(): int
    {
        return (int) $this->from_check_in->diffInDays($this->to_check_in, false);
    }
}
