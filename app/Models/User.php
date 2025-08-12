<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 */

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
        'role',
        'phone_number',
        'is_phone_verified',
        'gender',
        'birth_date',
        'age',
        'id_type',
        'id_number',
        'address',
        'regence',
        'province',
        'member_status',
        'jobs',
        'education',
        'class_department',
        'email',
        'password',
        'status_account',
        'expired_date',
        'profile_picture',
    ];


    protected $casts = [
        'role' => Role::class,
        'expired_date' => 'date'
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

    public function otpCodes()
    {
        return $this->hasMany(OTP::class);
    }


    // @phpstan-ignore-next-line
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
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
