<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'id_number',
        'role',
        'email',
        'password',
        'phone_number',
        'profile_picture',
        'gender',
        'place_birth',
        'birth_date',
        'last_education',
        'job'
    ];

    protected $casts = [
        'role' => Role::class
    ];

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    public function isLibrarian(): bool
    {
        return $this->role === Role::Librarian;
    }

    public function isMember(): bool
    {
        return $this->role === Role::Member;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
