@extends('layouts.instructor')

@section('title', 'Manage Quizzes')

@section('instructor_content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Course Quizzes & Assessments</h1>
            <p class="text-xs text-slate-500 mt-1">Build evaluations, add multiple choice questions, and monitor student test results</p>
        </div>
    </div>

    <!-- Quizzes Loop per Course -->
    <div class="space-y-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $course->thumbnail_url }}" class="w-10 h-7 rounded-lg object-cover" alt="">
                        <div>
                            <h3 class="font-bold text-sm text-slate-900">{{ $course->title }}</h3>
                            <span class="text-[11px] text-slate-400">{{ $course->quizzes->count() }} quizzes configured</span>
                        </div>
                    </div>

                    <a href="{{ route('instructor.quizzes.create', $course->id) }}" class="px-3.5 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold text-xs rounded-xl flex items-center space-x-1 transition-colors">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Create Quiz</span>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($course->quizzes as $quiz)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <h4 class="font-bold text-slate-900">{{ $quiz->title }}</h4>
                                <div class="flex items-center space-x-2 text-[11px] text-slate-400 mt-0.5">
                                    <span>Pass Score: <strong class="text-emerald-600">{{ $quiz->pass_percentage }}%</strong></span>
                                    <span>•</span>
                                    <span>Time Limit: {{ $quiz->time_limit_minutes }} mins</span>
                                    <span>•</span>
                                    <span class="text-purple-600 font-semibold">{{ $quiz->questions->count() }} Questions</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-1.5">
                                <a href="{{ route('instructor.quizzes.questions', $quiz->id) }}" class="px-2.5 py-1 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-lg flex items-center space-x-1 shadow-sm transition-all">
                                    <i data-lucide="list-plus" class="w-3.5 h-3.5"></i>
                                    <span>Questions ({{ $quiz->questions->count() }})</span>
                                </a>
                                <a href="{{ route('instructor.quizzes.edit', $quiz->id) }}" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Quiz">
                                    <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                                </a>
                                <form action="{{ route('instructor.quizzes.destroy', $quiz->id) }}" method="POST" class="inline-flex m-0 p-0" onsubmit="return confirm('Delete this quiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-7 h-7 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Delete Quiz">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 italic">No quizzes created for this course yet.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400 text-xs">
                No courses available. Create a course first before building quizzes.
            </div>
        @endforelse
    </div>

</div>
@endsection
