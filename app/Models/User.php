<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'preferred_timezone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get all of the creator for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function creator(): HasMany
    {
        return $this->hasMany(Appointment::class, 'creator_id');
    }

    /**
     * Get all of the receiver for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receiver(): HasMany
    {
        return $this->hasMany(Appointment::class, 'receiver_id');
    }
}
