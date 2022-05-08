<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'user_id',
        'phone',
        'email',
        'type',
        'status',
        'token',
        'valid_until'
    ];
}
