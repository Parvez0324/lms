<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CoursePlayerController extends Controller
{
    public function learn(Course $course, $lessonSlug = null)
    {
        $user = Auth::user();

        // Check if student is enrolled or if user is course instructor / admin
        $isEnrolled = $user->isEnrolledIn($course->id);
        $isOwner = $course->instructor_id === $user->id || $user->isAdmin();

        if (!$isEnrolled && !$isOwner) {
            return redirect()->route('courses.show', $course->slug)->with('error', 'Please enroll in this course to access the classroom.');
        }

        $course->load([
            'instructor',
            'sections.lessons',
            'sections.quizzes.questions',
        ]);

        // Collect all lessons in sequential order
        $allLessons = collect();
        foreach ($course->sections as $section) {
            foreach ($section->lessons as $lesson) {
                $allLessons->push($lesson);
            }
        }

        if ($allLessons->isEmpty()) {
            return redirect()->route('courses.show', $course->slug)->with('error', 'This course does not have any lessons published yet.');
        }

        // Determine active lesson
        $activeLesson = null;
        if ($lessonSlug) {
            $activeLesson = $allLessons->firstWhere('slug', $lessonSlug);
        }

        if (!$activeLesson) {
            // Find first incomplete lesson, or fallback to first lesson
            $completedLessonIds = LessonCompletion::where('user_id', $user->id)
                ->whereIn('lesson_id', $allLessons->pluck('id'))
                ->pluck('lesson_id')
                ->toArray();

            $firstIncomplete = $allLessons->first(function ($l) use ($completedLessonIds) {
                return !in_array($l->id, $completedLessonIds);
            });

            $activeLesson = $firstIncomplete ?: $allLessons->first();
        }

        // Determine Prev and Next lessons
        $currentIndex = $allLessons->search(function ($l) use ($activeLesson) {
            return $l->id === $activeLesson->id;
        });

        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < ($allLessons->count() - 1) ? $allLessons[$currentIndex + 1] : null;

        // Completed lesson IDs for checkmark indicators
        $completedLessonIds = LessonCompletion::where('user_id', $user->id)
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->pluck('lesson_id')
            ->toArray();

        $progress = $course->getStudentProgressPercentage($user->id);

        // Check if 100% complete and auto-issue Certificate
        $certificate = null;
        if ($progress >= 100) {
            $certificate = Certificate::firstOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                [
                    'certificate_code' => 'LMS-' . date('Y') . '-' . strtoupper(Str::random(6)),
                    'issued_at' => now(),
                ]
            );

            // Update enrollment status to completed
            Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->update(['status' => 'completed', 'completed_at' => now()]);
        }

        return view('student.learn', compact(
            'course',
            'activeLesson',
            'allLessons',
            'prevLesson',
            'nextLesson',
            'completedLessonIds',
            'progress',
            'certificate'
        ));
    }

    public function toggleComplete(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        $course = $lesson->section->course;

        $completion = LessonCompletion::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($completion) {
            $completion->delete();
            $message = 'Lesson marked as incomplete.';
        } else {
            LessonCompletion::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'completed_at' => now(),
            ]);
            $message = 'Lesson marked as completed! Great progress.';
        }

        // Auto redirect to next lesson if requested
        if ($request->has('redirect_next') && $request->redirect_next) {
            return redirect($request->redirect_next)->with('success', $message);
        }

        return back()->with('success', $message);
    }
}
