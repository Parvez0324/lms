<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        $featuredCourses = Course::where('status', 'published')
            ->where('is_featured', true)
            ->with(['instructor', 'category', 'reviews', 'sections.lessons'])
            ->take(6)
            ->get();

        if ($featuredCourses->isEmpty()) {
            $featuredCourses = Course::where('status', 'published')
                ->with(['instructor', 'category', 'reviews', 'sections.lessons'])
                ->take(6)
                ->get();
        }

        $categories = Category::where('is_active', true)
            ->withCount(['courses' => function ($q) {
                $q->where('status', 'published');
            }])
            ->take(8)
            ->get();

        $stats = [
            'total_students' => User::where('role', 'student')->count() + 1250,
            'total_courses' => Course::where('status', 'published')->count() + 45,
            'total_instructors' => User::where('role', 'instructor')->count() + 28,
            'total_certificates' => Certificate::count() + 850,
        ];

        return view('welcome', compact('featuredCourses', 'categories', 'stats'));
    }

    public function indexCourses(Request $request)
    {
        $query = Course::where('status', 'published')
            ->with(['instructor', 'category', 'reviews', 'sections.lessons']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('instructor', function ($iq) use ($search) {
                      $iq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Level Filter
        if ($request->filled('level') && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        // Price Filter
        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->where('price', '<=', 0);
            } elseif ($request->price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Sorting
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('is_featured', 'desc')->latest();
        }

        $courses = $query->paginate(9)->withQueryString();
        $categories = Category::where('is_active', true)->withCount('courses')->get();

        if ($request->ajax() || $request->has('ajax')) {
            return view('courses._grid', compact('courses'))->render();
        }

        return view('courses.index', compact('courses', 'categories'));
    }

    public function showCourse($slug)
    {
        $course = Course::where('slug', $slug)
            ->with([
                'instructor',
                'category',
                'sections.lessons',
                'sections.quizzes.questions',
                'reviews.user',
            ])
            ->firstOrFail();

        $isEnrolled = false;
        $progress = 0;

        if (auth()->check()) {
            $isEnrolled = auth()->user()->isEnrolledIn($course->id);
            if ($isEnrolled) {
                $progress = $course->getStudentProgressPercentage(auth()->id());
            }
        }

        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('courses.show', compact('course', 'isEnrolled', 'progress', 'relatedCourses'));
    }

    public function verifyCertificate(Request $request, $code = null)
    {
        $searchCode = $code ?: $request->input('code');
        $certificate = null;
        $searched = false;

        if ($searchCode) {
            $searched = true;
            $certificate = Certificate::where('certificate_code', trim($searchCode))
                ->with(['user', 'course.instructor'])
                ->first();
        }

        return view('certificate-verify', compact('certificate', 'searchCode', 'searched'));
    }
}
