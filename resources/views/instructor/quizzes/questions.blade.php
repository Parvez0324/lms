@extends('layouts.instructor')

@section('title', 'Question Bank - ' . $quiz->title)

@section('instructor_content')
<div class="space-y-4 max-w-6xl mx-auto">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">{{ $quiz->title }}</h1>
            <p class="text-xs text-slate-500">Course: {{ $quiz->course->title }} • Pass Threshold: {{ $quiz->pass_percentage }}%</p>
        </div>
        <a href="{{ route('instructor.quizzes.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Quizzes</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
        
        <!-- Left Column: Add Question Form -->
        <div class="lg:col-span-5 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5 mr-1.5 text-purple-600"></i>
                Add Question
            </h3>

            <form action="{{ route('instructor.quizzes.questions.store', $quiz->id) }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Question Text</label>
                    <textarea name="question_text" rows="2" required placeholder="e.g. Which HTTP method is used to update a resource in REST?" 
                              class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500"></textarea>
                </div>

                <!-- 4 Options with Radio selector for correct answer -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-[11px] font-bold uppercase tracking-wider text-slate-700">
                        <span>Options</span>
                        <span class="text-[10px] text-purple-600 font-semibold normal-case">Check correct key</span>
                    </div>

                    @foreach([0 => 'Option A', 1 => 'Option B', 2 => 'Option C', 3 => 'Option D'] as $idx => $optLabel)
                        <div class="flex items-center space-x-2">
                            <input type="radio" name="correct_answer" value="{{ $idx }}" {{ $idx === 0 ? 'checked' : '' }} required class="h-3.5 w-3.5 text-purple-600 focus:ring-purple-500">
                            <input type="text" name="options[{{ $idx }}]" required placeholder="{{ $optLabel }}..." 
                                   class="flex-1 px-3 py-1 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500">
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Points Value</label>
                        <input type="number" name="points" value="1" min="1" required class="w-full px-3 py-1 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Explanation</label>
                        <input type="text" name="explanation" placeholder="Hint/reason..." class="w-full px-3 py-1 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-purple-500">
                    </div>
                </div>

                <button type="submit" class="w-full py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                    Add Question to Bank
                </button>
            </form>
        </div>

        <!-- Right Column: Existing Questions List -->
        <div class="lg:col-span-7 space-y-3">
            <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Questions in Bank</h3>
                <span class="px-2 py-0.5 bg-purple-50 text-purple-700 text-[11px] font-bold rounded-lg">{{ $quiz->questions->count() }} Questions</span>
            </div>

            <div class="space-y-2.5 max-h-[70vh] overflow-y-auto pr-1">
                @forelse($quiz->questions as $index => $question)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm space-y-2">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold text-slate-900 leading-snug">Q{{ $index + 1 }}. {{ $question->question_text }}</span>
                            <div class="flex items-center space-x-1.5 flex-shrink-0 ml-2">
                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded">{{ $question->points }} pt</span>
                                <form action="{{ route('instructor.quizzes.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Choices Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 text-xs">
                            @foreach($question->options as $optIdx => $option)
                                <div class="p-2 rounded-xl {{ (string)$optIdx === (string)$question->correct_answer || $option === $question->correct_answer ? 'bg-emerald-50 border border-emerald-300 text-emerald-800 font-bold' : 'bg-slate-50 text-slate-600' }}">
                                    <span class="uppercase font-bold mr-1 text-[11px]">{{ chr(65 + $optIdx) }}.</span> {{ $option }}
                                    @if((string)$optIdx === (string)$question->correct_answer || $option === $question->correct_answer)
                                        <span class="text-[9px] text-emerald-600 ml-1 font-bold">✓</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if($question->explanation)
                            <div class="text-[10px] text-slate-500 bg-slate-50 p-2 rounded-xl border border-slate-100">
                                <strong class="text-slate-700">Explanation:</strong> {{ $question->explanation }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-xs">
                        No questions in this quiz yet. Use the form on the left to add your first question!
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
