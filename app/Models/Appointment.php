<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'fullname', 'email', 'phone', 'vehicle', 'date', 'service', 'workshop_id', 'workshop_name', 'pickup_address', 'user_lat', 'user_lng', 'details', 'status', 'amount', 'total_amount', 'advance_paid', 'payment_status', 'final_payment_status', 'razorpay_order_id', 'razorpay_payment_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
