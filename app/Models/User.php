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
        'email',
        'password',
        'role',
        'status', // Still keeping status for legacy/ban purposes
        'payment_status',
        'selected_package',
    ];

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
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
    public function sensei()
    {
        return $this->hasOne(Sensei::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function hasActivePackage($package)
    {
        return $this->transactions()
            ->where('package_type', $package)
            ->where('status', 'approved')
            ->exists();
    }

    public function hasPendingPackage($package)
    {
        return $this->transactions()
            ->where('package_type', $package)
            ->where('status', 'pending')
            ->exists();
    }
}
