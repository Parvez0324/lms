<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->courses()
            ->with(['category', 'sections.lessons'])
            ->withCount(['enrollments', 'sections']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $courses = $query->latest()->paginate(10)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('instructor.courses._table', compact('courses'))->render();
        }

        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'level' => ['required', 'in:beginner,intermediate,advanced,all_levels'],
            'language' => ['nullable', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'preview_video_url' => ['nullable', 'url'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:draft,published'],
            'outcomes' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
        ]);

        $data['language'] = $request->input('language') ?: 'English';

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses', 'public');
            $data['thumbnail'] = $path;
        }

        // Process bullet points for outcomes and requirements
        if ($request->filled('outcomes')) {
            $data['outcomes'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->outcomes))));
        }

        if ($request->filled('requirements')) {
            $data['requirements'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->requirements))));
        }

        $data['instructor_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);

        $course = Course::create($data);

        return redirect()->route('instructor.courses.show', $course->id)->with('success', 'Course created! Now let\'s build your curriculum sections and lessons.');
    }

    public function show(Course $course)
    {
        $this->authorizeCourse($course);
        $course->load(['category', 'sections.lessons', 'sections.quizzes.questions', 'enrollments.user']);
        
        return view('instructor.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorizeCourse($course);
        $categories = Category::where('is_active', true)->get();

        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'level' => ['required', 'in:beginner,intermediate,advanced,all_levels'],
            'language' => ['nullable', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'preview_video_url' => ['nullable', 'url'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:draft,published'],
            'outcomes' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
        ]);

        $data['language'] = $request->input('language') ?: ($course->language ?: 'English');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses', 'public');
            $data['thumbnail'] = $path;
        }

        if ($request->filled('outcomes')) {
            $data['outcomes'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->outcomes))));
        }

        if ($request->filled('requirements')) {
            $data['requirements'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->requirements))));
        }

        $course->update($data);

        return redirect()->route('instructor.courses.show', $course->id)->with('success', 'Course details updated successfully!');
    }

    public function destroy(Course $course)
    {
        $this->authorizeCourse($course);
        $course->delete();

        return redirect()->route('instructor.courses.index')->with('success', 'Course removed.');
    }

    protected function authorizeCourse(Course $course)
    {
        if ($course->instructor_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
