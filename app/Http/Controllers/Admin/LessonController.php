<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::with(['section.course.instructor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('content_type', $request->type);
        }

        $lessons = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.lessons._table', compact('lessons'))->render();
        }

        return view('admin.lessons.index', compact('lessons'));
    }
}
