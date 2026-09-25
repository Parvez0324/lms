<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizEngineController extends Controller
{
    public function showQuiz(Quiz $quiz)
    {
        $user = Auth::user();
        $course = $quiz->course;

        if (!$user->isEnrolledIn($course->id) && $course->instructor_id !== $user->id && !$user->isAdmin()) {
            return redirect()->route('courses.show', $course->slug)->with('error', 'You must be enrolled to take this quiz.');
        }

        $quiz->load(['questions', 'course']);
        $previousAttempt = $quiz->userAttempt($user->id);

        return view('student.quiz', compact('quiz', 'previousAttempt'));
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $quiz->load('questions');

        $userAnswers = $request->input('answers', []);
        $score = 0;
        $totalPoints = 0;

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $submittedAnswer = $userAnswers[$question->id] ?? null;

            // Check if submitted answer matches correct answer
            if ($submittedAnswer !== null && ((string)$submittedAnswer === (string)$question->correct_answer || $submittedAnswer === $question->correct_answer)) {
                $score += $question->points;
            }
        }

        $percentage = $totalPoints > 0 ? round(($score / $totalPoints) * 100, 2) : 0;
        $isPassed = $percentage >= $quiz->pass_percentage;

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'score' => $score,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'user_answers' => $userAnswers,
            'completed_at' => now(),
        ]);

        return redirect()->route('student.quiz.result', $attempt->id)->with($isPassed ? 'success' : 'error', $isPassed ? 'Congratulations! You passed the quiz!' : 'You scored below the passing threshold. Review your answers below.');
    }

    public function quizResult(QuizAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id() && !Auth::user()->isAdmin() && $attempt->quiz->course->instructor_id !== Auth::id()) {
            abort(403);
        }

        $attempt->load(['quiz.questions', 'quiz.course']);
        return view('student.quiz-result', compact('attempt'));
    }
}
