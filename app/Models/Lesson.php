<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'title', 'type', 'content', 'duration', 'order', 'is_free'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
