<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRoadmapStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'content_type',
        'content_id',
        'order',
        'title'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getContentAttribute()
    {
        switch ($this->content_type) {
            case 'module':
                return Module::find($this->content_id);
            case 'quiz':
                return Quiz::find($this->content_id);
            case 'lesson':
                return Lesson::find($this->content_id);
            default:
                return null;
        }
    }
}
