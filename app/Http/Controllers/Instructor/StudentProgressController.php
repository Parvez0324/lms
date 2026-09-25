<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProgressController extends Controller
{
    public function index(Request $request)
    {
        $courseIds = Auth::user()->courses()->pluck('id');

        $query = Enrollment::whereIn('course_id', $courseIds)->with(['user', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('course', function ($cq) use ($search) {
                    $cq->where('title', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $enrollments = $query->latest()->paginate(15)->withQueryString();
        $courses = Auth::user()->courses;

        if ($request->ajax() || $request->has('ajax')) {
            return view('instructor.students._table', compact('enrollments'))->render();
        }

        return view('instructor.students.index', compact('enrollments', 'courses'));
    }
}
