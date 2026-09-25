<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $totalStudents = User::where('role', 'student')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalCertificates = Certificate::count();

        // Top Performing Courses by Enrollment
        $topCourses = Course::withCount('enrollments')
            ->with(['instructor', 'category'])
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        // Category breakdown
        $categories = Category::withCount('courses')->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalStudents',
            'totalInstructors',
            'totalCourses',
            'totalEnrollments',
            'totalCertificates',
            'topCourses',
            'categories'
        ));
    }
}
