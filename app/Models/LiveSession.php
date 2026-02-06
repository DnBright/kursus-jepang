<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'module_id',
        'instructor_id',
        'scheduled_at',
        'duration',
        'zoom_link',
        'meeting_id',
        'meeting_password',
        'max_participants',
        'status',
        'recording_url',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function attendances()
    {
        return $this->hasMany(SessionAttendance::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'session_attendances')->withTimestamps();
    }
}
