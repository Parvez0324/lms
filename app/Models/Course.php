<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'category_id',
        'title',
        'slug',
        'subtitle',
        'description',
        'level',
        'language',
        'price',
        'discount_price',
        'thumbnail',
        'preview_video_url',
        'requirements',
        'outcomes',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'requirements' => 'array',
        'outcomes' => 'array',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title) . '-' . Str::random(5);
            }
        });
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order', 'asc');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('order', 'asc');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withPivot('status', 'enrolled_at', 'completed_at');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Calculated Helpers
    public function getIsFreeAttribute(): bool
    {
        return $this->price <= 0;
    }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->discount_price !== null && $this->discount_price < $this->price) {
            return (float) $this->discount_price;
        }
        return (float) $this->price;
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) round($this->reviews()->avg('rating') ?: 5.0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function getTotalLessonsCountAttribute(): int
    {
        return $this->sections()->withCount('lessons')->get()->sum('lessons_count');
    }

    public function getTotalDurationMinutesAttribute(): int
    {
        return $this->lessons()->sum('duration_minutes') ?: 45;
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://'))) {
            return $this->thumbnail;
        }
        if ($this->thumbnail && file_exists(public_path('storage/' . $this->thumbnail))) {
            return asset('storage/' . $this->thumbnail);
        }
        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=60';
    }

    // Helper: calculate student progress percentage for a given student
    public function getStudentProgressPercentage($userId): int
    {
        $allLessonIds = Lesson::whereIn('section_id', $this->sections()->pluck('id'))->pluck('id');
        $totalLessons = $allLessonIds->count();
        if ($totalLessons === 0) return 0;

        $completedCount = LessonCompletion::where('user_id', $userId)
            ->whereIn('lesson_id', $allLessonIds)
            ->count();

        return (int) round(($completedCount / $totalLessons) * 100);
    }
}
