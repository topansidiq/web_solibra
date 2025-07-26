<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'start_at',
        'end_at',
        'description',
        'location',
        'status',
    ];
}
