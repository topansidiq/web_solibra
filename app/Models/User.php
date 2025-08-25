<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 */
/**
 * @mixin \Eloquent
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

    public function isMaster(): bool
    {
        return $this->role === Role::Master;
    }

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

    /**
     * Get the user's favorite books.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Book>
     */
    public function favoriteBooks()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'book_id')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
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


    /**
     * App\Models\User
     *
     * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Borrow[] $borrows
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
