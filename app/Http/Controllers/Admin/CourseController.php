<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'category'])->withCount(['enrollments', 'sections']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $courses = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.courses._table', compact('courses'))->render();
        }

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        $course->load(['instructor', 'category', 'sections.lessons', 'sections.quizzes', 'enrollments.user', 'payments.user', 'reviews.user']);
        return view('admin.courses.show', compact('course'));
    }

    public function togglePublish(Course $course)
    {
        $course->status = $course->status === 'published' ? 'draft' : 'published';
        $course->save();

        return back()->with('success', 'Course status updated to ' . $course->status);
    }

    public function toggleFeatured(Course $course)
    {
        $course->is_featured = !$course->is_featured;
        $course->save();

        return back()->with('success', 'Course featured status updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
