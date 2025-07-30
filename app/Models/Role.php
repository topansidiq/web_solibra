<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum Role: string
{
    case Admin = 'admin';
    case Librarian = 'librarian';
    case Member = 'member';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Librarian => 'Pustakawan',
            self::Member => 'Anggota',
        };
    }
}
