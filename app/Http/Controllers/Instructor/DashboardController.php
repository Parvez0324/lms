<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courseIds = $user->courses()->pluck('id');

        $totalCourses = $user->courses()->count();
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id');
        $totalEarnings = Payment::whereIn('course_id', $courseIds)->where('status', 'completed')->sum('amount');
        
        $totalLessons = \App\Models\Lesson::whereHas('section', function($q) use ($courseIds) {
            $q->whereIn('course_id', $courseIds);
        })->count();

        $myCourses = $user->courses()
            ->with(['category', 'enrollments'])
            ->withCount(['enrollments', 'sections'])
            ->latest()
            ->take(5)
            ->get();

        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->latest()
            ->take(6)
            ->get();

        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'totalEarnings',
            'totalLessons',
            'myCourses',
            'recentEnrollments'
        ));
    }
}
