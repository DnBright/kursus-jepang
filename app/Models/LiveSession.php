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

    public function getCalculatedStatusAttribute()
    {
        $now = now();
        $start = $this->scheduled_at;
        $end = (clone $start)->addMinutes($this->duration);

        if ($now->between($start, $end)) {
            return 'live';
        } elseif ($now->lt($start)) {
            return 'upcoming';
        } else {
            return 'completed';
        }
    }

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
        return $this->belongsTo(Sensei::class, 'instructor_id');
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
