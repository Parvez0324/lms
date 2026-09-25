<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = AssignmentSubmission::with(['assignment.course', 'user', 'grader'])->latest();

        if ($request->filled('course_id')) {
            $query->whereHas('assignment', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('assignment', function ($aq) use ($search) {
                    $aq->where('title', 'like', "%{$search}%");
                });
            });
        }

        $submissions = $query->paginate(15)->withQueryString();
        $courses = Course::orderBy('title')->get();
        $assignments = Assignment::with('course')->latest()->get();

        $totalSubmissions = AssignmentSubmission::count();
        $pendingGrading = AssignmentSubmission::where('status', 'submitted')->count();
        $gradedCount = AssignmentSubmission::where('status', 'graded')->count();

        if ($request->ajax()) {
            return view('admin.assignments._table', compact('submissions'));
        }

        return view('admin.assignments.index', compact(
            'submissions',
            'courses',
            'assignments',
            'totalSubmissions',
            'pendingGrading',
            'gradedCount'
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

        $assignment = Assignment::create([
            'course_id' => $request->course_id,
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

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }
}
