<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $totalCertificates = Certificate::count();
        $totalLessons = \App\Models\Lesson::count();
        $totalQuizzes = Quiz::count();
        $completionRate = $totalEnrollments > 0 ? round(($totalCertificates / $totalEnrollments) * 100) : 0;

        $recentEnrollments = Enrollment::with(['user', 'course.category'])->latest()->take(5)->get();
        $recentPayments = Payment::with(['user', 'course'])->latest()->take(5)->get();
        $recentCourses = Course::with(['instructor', 'category'])->latest()->take(5)->get();
        $topCourses = Course::withCount('enrollments')
            ->with(['instructor', 'category'])
            ->orderBy('enrollments_count', 'desc')
            ->take(3)
            ->get();

        $categories = Category::withCount('courses')->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalInstructors',
            'totalCourses',
            'totalEnrollments',
            'totalRevenue',
            'totalCertificates',
            'totalLessons',
            'totalQuizzes',
            'completionRate',
            'recentEnrollments',
            'recentPayments',
            'recentCourses',
            'topCourses',
            'categories'
        ));
    }
}
