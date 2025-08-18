<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUserState
 */
class UserState extends Model
{
    protected $fillable = [
        'phone_number',
        'state',
        'permanent_state'
    ];
}
