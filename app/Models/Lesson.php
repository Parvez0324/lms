<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'content_type',
        'video_url',
        'video_path',
        'pdf_path',
        'article_content',
        'duration_minutes',
        'order',
        'is_preview',
        'is_published',
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title) . '-' . Str::random(4);
            }
        });
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, Section::class, 'id', 'id', 'section_id', 'course_id');
    }

    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function isCompletedBy($userId): bool
    {
        return $this->completions()->where('user_id', $userId)->exists();
    }
}
