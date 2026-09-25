<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $courses = Auth::user()->courses()->with(['quizzes.questions', 'quizzes.attempts'])->get();
        return view('instructor.quizzes.index', compact('courses'));
    }

    public function create(Course $course)
    {
        $this->authorizeCourse($course);
        $sections = $course->sections;
        return view('instructor.quizzes.create', compact('course', 'sections'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'description' => ['nullable', 'string'],
            'pass_percentage' => ['required', 'integer', 'min:10', 'max:100'],
            'time_limit_minutes' => ['required', 'integer', 'min:1', 'max:180'],
        ]);

        $data['course_id'] = $course->id;
        $data['order'] = ($course->quizzes()->max('order') ?: 0) + 1;

        $quiz = Quiz::create($data);

        return redirect()->route('instructor.quizzes.questions', $quiz->id)->with('success', 'Quiz created! Now add test questions to your quiz bank.');
    }

    public function edit(Quiz $quiz)
    {
        $this->authorizeCourse($quiz->course);
        $sections = $quiz->course->sections;
        return view('instructor.quizzes.edit', compact('quiz', 'sections'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $this->authorizeCourse($quiz->course);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'section_id' => ['nullable', 'exists:sections,id'],
            'description' => ['nullable', 'string'],
            'pass_percentage' => ['required', 'integer', 'min:10', 'max:100'],
            'time_limit_minutes' => ['required', 'integer', 'min:1', 'max:180'],
        ]);

        $quiz->update($data);

        return redirect()->route('instructor.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function manageQuestions(Quiz $quiz)
    {
        $this->authorizeCourse($quiz->course);
        $quiz->load(['questions', 'course']);
        return view('instructor.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $this->authorizeCourse($quiz->course);

        $request->validate([
            'question_text' => ['required', 'string'],
            'options' => ['required', 'array', 'min:2'],
            'options.*' => ['required', 'string'],
            'correct_answer' => ['required'],
            'explanation' => ['nullable', 'string'],
            'points' => ['required', 'integer', 'min:1'],
        ]);

        $order = ($quiz->questions()->max('order') ?: 0) + 1;

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $request->question_text,
            'options' => array_values($request->options),
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'points' => $request->points,
            'order' => $order,
        ]);

        return back()->with('success', 'Question added to quiz successfully!');
    }

    public function deleteQuestion(Question $question)
    {
        $this->authorizeCourse($question->quiz->course);
        $question->delete();

        return back()->with('success', 'Question deleted.');
    }

    public function destroy(Quiz $quiz)
    {
        $this->authorizeCourse($quiz->course);
        $quiz->delete();

        return redirect()->route('instructor.quizzes.index')->with('success', 'Quiz deleted.');
    }

    protected function authorizeCourse(Course $course)
    {
        if ($course->instructor_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
    }
}
