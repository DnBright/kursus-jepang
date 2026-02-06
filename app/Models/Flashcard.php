<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'deck_name',
        'course_id',
        'card_type',
        'front',
        'back',
        'hint',
        'example_sentence',
        'audio_url',
        'image_url',
        'difficulty_level',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reviews()
    {
        return $this->hasMany(UserFlashcardReview::class);
    }
}
