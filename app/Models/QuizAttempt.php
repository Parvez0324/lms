<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'total_points',
        'percentage',
        'is_passed',
        'user_answers',
        'completed_at',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'user_answers' => 'array',
        'percentage' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
