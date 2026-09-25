<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.enrollments._table', compact('enrollments'))->render();
        }

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->orderBy('name')->get();
        $courses = Course::where('status', 'published')->orderBy('title')->get();

        return view('admin.enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'status' => ['required', 'in:active,completed,cancelled'],
        ]);

        Enrollment::updateOrCreate(
            ['user_id' => $request->user_id, 'course_id' => $request->course_id],
            ['status' => $request->status, 'enrolled_at' => now()]
        );

        return redirect()->route('admin.enrollments.index')->with('success', 'Student enrolled into course successfully!');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return back()->with('success', 'Enrollment revoked.');
    }
}
