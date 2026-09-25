<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'section_id',
        'title',
        'description',
        'pass_percentage',
        'time_limit_minutes',
        'order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order', 'asc');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function userAttempt($userId)
    {
        return $this->attempts()->where('user_id', $userId)->latest()->first();
    }

    public function isPassedBy($userId): bool
    {
        return $this->attempts()->where('user_id', $userId)->where('is_passed', true)->exists();
    }
}
