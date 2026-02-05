<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Sensei extends Authenticatable
{
    use Notifiable;

    protected $guard = 'sensei';

    protected $fillable = [
        'name',
        'email',
        'password',
        'title',
        'specialization',
        'bio',
        'phone_number',
        'avatar_url',
        'social_links',
        'status',
        'years_of_experience',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];
}
