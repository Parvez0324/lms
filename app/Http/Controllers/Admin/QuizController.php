<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with(['course', 'questions', 'attempts'])->withCount(['questions', 'attempts']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('course', function ($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
        }

        $quizzes = $query->latest()->paginate(15)->withQueryString();
        $recentAttempts = QuizAttempt::with(['user', 'quiz.course'])->latest()->take(10)->get();

        if ($request->ajax() || $request->has('ajax')) {
            return view('admin.quizzes._table', compact('quizzes'))->render();
        }

        return view('admin.quizzes.index', compact('quizzes', 'recentAttempts'));
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['course', 'questions', 'attempts.user']);
        return view('admin.quizzes.show', compact('quiz'));
    }
}
