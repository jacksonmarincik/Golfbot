<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaySlot extends Model
{
    use HasFactory;
    protected $table = "day_slot";
    protected $fillable = [
        'user_setting_id', 
        'date',
        'time'
    ];
}
