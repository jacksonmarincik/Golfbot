<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $table = "user_setting";
    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'phone',
        'site_user_name',
        'site_url',
        'slot',
        'location',
        'category',
        'status',
        'site_location',
        'stop_booking'
    ];
}
