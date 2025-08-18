<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperInformation
 */
class Information extends Model
{
    use HasFactory;

    protected $table = 'informations';

    protected $fillable = [
        'title',
        'author',
        'description',
        'images'
    ];
}
