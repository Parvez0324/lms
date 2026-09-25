<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollments = $user->enrollments()
            ->with(['course.instructor', 'course.sections.lessons'])
            ->latest()
            ->get();

        $completedEnrollmentsCount = $enrollments->where('status', 'completed')->count();
        $inProgressCount = $enrollments->where('status', 'active')->count();
        $certificates = $user->certificates()->with('course.instructor')->latest()->get();
        $recentQuizAttempts = $user->quizAttempts()->with('quiz.course')->latest()->take(5)->get();

        return view('student.dashboard', compact(
            'enrollments',
            'completedEnrollmentsCount',
            'inProgressCount',
            'certificates',
            'recentQuizAttempts'
        ));
    }

    public function myCourses(Request $request)
    {
        $user = Auth::user();
        $query = $user->enrollments()
            ->with(['course.instructor', 'course.category', 'course.sections.lessons']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('instructor', function ($iq) use ($search) {
                      $iq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active' || $request->status === 'completed') {
                $query->where('status', $request->status);
            }
        }

        $enrollments = $query->latest()->paginate(9)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('student._my_courses_grid', compact('enrollments'))->render();
        }

        return view('student.my-courses', compact('enrollments'));
    }
}
