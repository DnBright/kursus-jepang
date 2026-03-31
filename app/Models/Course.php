<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'level', 'price', 'thumbnail', 'instructor_id'];

    public function instructor()
    {
        return $this->belongsTo(Sensei::class, 'instructor_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function studentsCount()
    {
        // Assuming selected_package in users table matches course title for now
        // A more robust way would be looking at approved transactions
        return User::where('selected_package', $this->title)
            ->where('payment_status', 'approved')
            ->count();
    }
}
