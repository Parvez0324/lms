<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'user_id',
        'submission_text',
        'file_path',
        'score',
        'grade',
        'feedback',
        'status',
        'graded_by',
        'graded_at',
    ];

    protected $casts = [
        'graded_at' => 'datetime',
        'score' => 'integer',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file_path) return null;
        if (str_starts_with($this->file_path, 'http')) return $this->file_path;
        return asset('storage/' . $this->file_path);
    }
}
