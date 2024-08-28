<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCriteria extends Model
{
    use HasFactory;
    protected $table = "booking_criteria";
    protected $fillable = [
        'user_setting_id', 
        'location',
        'category',
        'p_name',
    ];

}
