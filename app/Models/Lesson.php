<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'instructor_id', 'title', 'type', 'content', 'duration', 'order', 'is_free'];

    public function instructor()
    {
        return $this->belongsTo(Sensei::class, 'instructor_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
