<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'customer_name',
        'contact_number',
        'room_type',
        'room_capacity',
        'payment_type',
        'from_date',
        'to_date',
        'num_days',
        'sub_total',
        'additional_charge',
        'discount_amount',
        'total_bill',
        'reservation_time',
    ];

    public $timestamps = false;
}