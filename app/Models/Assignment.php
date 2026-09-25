<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'points',
        'due_date',
        'attachment_path',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'points' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function submissionForUser($userId)
    {
        return $this->submissions()->where('user_id', $userId)->first();
    }
}
