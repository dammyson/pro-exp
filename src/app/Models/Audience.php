<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UuidTrait;
use Illuminate\Notifications\Notifiable;

class Audience extends Authenticatable
{ 
    use HasApiTokens, HasFactory, Notifiable, UuidTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'pin',
        'status',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
