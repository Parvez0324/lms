<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $myCourseIds = Course::where('instructor_id', Auth::id())->pluck('id');

        $query = AssignmentSubmission::with(['assignment.course', 'user', 'grader'])
            ->whereHas('assignment', function ($q) use ($myCourseIds) {
                $q->whereIn('course_id', $myCourseIds);
            })->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('assignment', function ($aq) use ($search) {
                    $aq->where('title', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('course_id')) {
            $query->whereHas('assignment', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(15)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('instructor.assignments._table', compact('submissions'))->render();
        }

        $myCourses = Course::where('instructor_id', Auth::id())->orderBy('title')->get();
        $myAssignments = Assignment::whereIn('course_id', $myCourseIds)->with('course')->latest()->get();

        $totalSubmissions = AssignmentSubmission::whereHas('assignment', function ($q) use ($myCourseIds) {
            $q->whereIn('course_id', $myCourseIds);
        })->count();

        $pendingGrading = AssignmentSubmission::whereHas('assignment', function ($q) use ($myCourseIds) {
            $q->whereIn('course_id', $myCourseIds);
        })->where('status', 'submitted')->count();

        return view('instructor.assignments.index', compact(
            'submissions',
            'myCourses',
            'myAssignments',
            'totalSubmissions',
            'pendingGrading'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points' => 'required|integer|min:1|max:1000',
            'due_date' => 'nullable|date',
        ]);

        // Ensure instructor owns course
        $course = Course::where('id', $request->course_id)->where('instructor_id', Auth::id())->firstOrFail();

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points,
            'due_date' => $request->due_date,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Assignment "' . $assignment->title . '" created successfully!');
    }

    public function grade(Request $request, AssignmentSubmission $submission)
    {
        // Ensure submission belongs to instructor's course
        if ($submission->assignment->course->instructor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'score' => 'required|integer|min:0|max:' . ($submission->assignment->points ?: 100),
            'grade' => 'nullable|string|max:50',
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->update([
            'score' => $request->score,
            'grade' => $request->grade ?: ($request->score >= 80 ? '⭐ Excellent Job!' : '🌱 Good Effort!'),
            'feedback' => $request->feedback,
            'status' => 'graded',
            'graded_by' => Auth::id(),
            'graded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Grade & feedback awarded to ' . $submission->user->name . ' successfully!');
    }
}
