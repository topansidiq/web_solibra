<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum Role: string
{
    case Admin = 'admin';
    case Librarian = 'librarian';
    case Member = 'member';
    case Master = 'master';

    public function label(): string
    {
        return match ($this) {
            self::Master => 'Master',
            self::Admin => 'Administrator',
            self::Librarian => 'Pustakawan',
            self::Member => 'Anggota',
        };
    }
}
