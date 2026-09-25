<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');

        $assignments = Assignment::with(['course.instructor', 'submissions' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])
        ->whereIn('course_id', $enrolledCourseIds)
        ->latest()
        ->get();

        $mySubmissions = AssignmentSubmission::with(['assignment.course', 'grader'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('student.assignments.index', compact('assignments', 'mySubmissions'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $user = Auth::user();

        // Ensure student is enrolled in course
        if (!$user->isEnrolledIn($assignment->course_id) && !$user->isAdmin()) {
            abort(403, 'You must be enrolled in this course to submit activities.');
        }

        $request->validate([
            'submission_text' => 'nullable|string|max:5000',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        $submission = AssignmentSubmission::updateOrCreate([
            'assignment_id' => $assignment->id,
            'user_id' => $user->id,
        ], [
            'submission_text' => $request->submission_text,
            'file_path' => $filePath ?: ($assignment->submissionForUser($user->id)?->file_path),
            'status' => 'submitted',
            'score' => null,
            'grade' => null,
            'feedback' => null,
            'graded_by' => null,
            'graded_at' => null,
        ]);

        return redirect()->back()->with('success', '🎉 Activity submitted! Your teacher will review and award your stars soon!');
    }
}
