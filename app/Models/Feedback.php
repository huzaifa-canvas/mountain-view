<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'order_id',
        'order_number',
        'guest_name',
        'guest_email',
        'category',
        'message',
        'screenshot_path',
        'contact_me'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
