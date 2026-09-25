<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function store(Request $request, Course $course)
    {
        if ($course->instructor_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $maxOrder = $course->sections()->max('order') ?: 0;

        $course->sections()->create([
            'title' => $request->title,
            'order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Curriculum section added!');
    }

    public function update(Request $request, Section $section)
    {
        if ($section->course->instructor_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $section->update(['title' => $request->title]);

        return back()->with('success', 'Section updated!');
    }

    public function destroy(Section $section)
    {
        if ($section->course->instructor_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $section->delete();
        return back()->with('success', 'Section deleted.');
    }
}
