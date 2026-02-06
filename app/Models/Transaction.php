<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'package_type',
        'status',
        'payment_method',
        'payment_proof',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
