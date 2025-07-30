<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsApp extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'message',
        'direction',
        'processed'
    ];
}
