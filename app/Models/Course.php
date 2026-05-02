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

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function studentsCount()
    {
        // Count users who have approved transactions for this course
        // Using package_type from transactions that matches course level or title
        return Transaction::where('package_type', $this->title)
            ->orWhere('package_type', $this->level)
            ->where('status', 'approved')
            ->distinct('user_id')
            ->count('user_id');
    }

    public function enrolledStudents()
    {
        // Get actual enrolled students
        return User::whereHas('transactions', function($query) {
            $query->where(function($q) {
                $q->where('package_type', $this->title)
                  ->orWhere('package_type', $this->level);
            })->where('status', 'approved');
        })->get();
    }
}
