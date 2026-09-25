<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function create(Section $section)
    {
        $this->authorizeSection($section);
        return view('instructor.lessons.create', compact('section'));
    }

    public function store(Request $request, Section $section)
    {
        $this->authorizeSection($section);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content_type' => ['required', 'in:video,pdf,article'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'video_file' => ['nullable', 'mimes:mp4,mov,avi,webm', 'max:51200'], // 50MB
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:20480'], // 20MB
            'article_content' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'is_preview' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('video_file')) {
            $data['video_path'] = $request->file('video_file')->store('lessons/videos', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_path'] = $request->file('pdf_file')->store('lessons/pdfs', 'public');
        }

        $data['section_id'] = $section->id;
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(4);
        $data['order'] = ($section->lessons()->max('order') ?: 0) + 1;
        $data['is_preview'] = $request->boolean('is_preview');
        $data['is_published'] = true;

        Lesson::create($data);

        return redirect()->route('instructor.courses.show', $section->course_id)->with('success', 'Lesson added to section successfully!');
    }

    public function edit(Lesson $lesson)
    {
        $this->authorizeSection($lesson->section);
        return view('instructor.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $this->authorizeSection($lesson->section);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content_type' => ['required', 'in:video,pdf,article'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'video_file' => ['nullable', 'mimes:mp4,mov,avi,webm', 'max:51200'],
            'pdf_file' => ['nullable', 'mimes:pdf', 'max:20480'],
            'article_content' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'is_preview' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('video_file')) {
            $data['video_path'] = $request->file('video_file')->store('lessons/videos', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_path'] = $request->file('pdf_file')->store('lessons/pdfs', 'public');
        }

        $data['is_preview'] = $request->boolean('is_preview');

        $lesson->update($data);

        return redirect()->route('instructor.courses.show', $lesson->section->course_id)->with('success', 'Lesson updated successfully!');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorizeSection($lesson->section);
        $courseId = $lesson->section->course_id;
        $lesson->delete();

        return redirect()->route('instructor.courses.show', $courseId)->with('success', 'Lesson removed.');
    }

    protected function authorizeSection(Section $section)
    {
        if ($section->course->instructor_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
    }
}
