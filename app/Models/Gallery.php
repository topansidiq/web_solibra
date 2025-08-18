<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGallery
 */
class Gallery extends Model
{
    protected $fillable = [
        'file',
        'type',
        'description',
    ];
}
