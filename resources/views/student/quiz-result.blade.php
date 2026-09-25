@extends('layouts.app')

@section('title', 'Quiz Result - ' . $attempt->quiz->title . ' | KAN')

@section('content')
<div class="bg-slate-900 text-white min-h-[90vh] py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Result Summary Banner -->
        <div class="bg-slate-950/90 p-8 rounded-3xl border {{ $attempt->is_passed ? 'border-emerald-500/50' : 'border-rose-500/50' }} shadow-2xl text-center space-y-4">
            
            <div class="w-16 h-16 rounded-2xl {{ $attempt->is_passed ? 'bg-emerald-500/20 text-emerald-400 ring-4 ring-emerald-500/10' : 'bg-rose-500/20 text-rose-400 ring-4 ring-rose-500/10' }} flex items-center justify-center mx-auto text-3xl">
                <i data-lucide="{{ $attempt->is_passed ? 'check-circle' : 'alert-circle' }}" class="w-8 h-8"></i>
            </div>

            <div>
                <span class="text-xs uppercase font-extrabold tracking-widest {{ $attempt->is_passed ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $attempt->is_passed ? 'Assessment Passed' : 'Assessment Not Passed' }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mt-1">{{ $attempt->quiz->title }}</h1>
                <p class="text-xs text-slate-400 mt-1">Course: {{ $attempt->quiz->course->title }}</p>
            </div>

            <!-- Score Pill -->
            <div class="flex items-center justify-center space-x-6 pt-2">
                <div>
                    <span class="text-[11px] text-slate-400 uppercase font-bold block">Your Score</span>
                    <span class="text-3xl font-black {{ $attempt->is_passed ? 'text-emerald-400' : 'text-rose-400' }}">{{ $attempt->percentage }}%</span>
                </div>
                <div class="h-8 w-px bg-slate-800"></div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase font-bold block">Points Earned</span>
                    <span class="text-3xl font-black text-white">{{ $attempt->score }} / {{ $attempt->total_points }}</span>
                </div>
                <div class="h-8 w-px bg-slate-800"></div>
                <div>
                    <span class="text-[11px] text-slate-400 uppercase font-bold block">Passing Grade</span>
                    <span class="text-3xl font-black text-slate-300">{{ $attempt->quiz->pass_percentage }}%</span>
                </div>
            </div>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('student.quiz.show', $attempt->quiz->id) }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-2xl transition-colors flex items-center space-x-1.5">
                    <i data-lucide="rotate-ccw" class="w-4 h-4 text-slate-400"></i>
                    <span>Retake Quiz</span>
                </a>
                <a href="{{ route('student.course.learn', $attempt->quiz->course->slug) }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-2xl shadow-lg transition-all flex items-center space-x-1.5">
                    <span>Back to Classroom &rarr;</span>
                </a>
            </div>

        </div>

        <!-- Question-by-Question Breakdown -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 px-2 flex items-center space-x-1.5">
                <i data-lucide="list-checks" class="w-4 h-4 text-indigo-400"></i>
                <span>Question Review & Explanations</span>
            </h3>

            @foreach($attempt->quiz->questions as $index => $q)
                @php
                    $userAns = $attempt->user_answers[$q->id] ?? null;
                    $isCorrect = $userAns !== null && ((string)$userAns === (string)$q->correct_answer || $userAns === $q->correct_answer);
                @endphp
                <div class="bg-slate-950/80 p-6 rounded-3xl border {{ $isCorrect ? 'border-emerald-500/30' : 'border-rose-500/30' }} space-y-3 text-xs">
                    <div class="flex items-start justify-between">
                        <span class="font-bold text-white text-sm leading-relaxed">
                            <span class="{{ $isCorrect ? 'text-emerald-400' : 'text-rose-400' }} font-black mr-1">Q{{ $index + 1 }}.</span>
                            {{ $q->question_text }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $isCorrect ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-300' }}">
                            {{ $isCorrect ? '✓ Correct (+'.$q->points.' pts)' : '✗ Incorrect' }}
                        </span>
                    </div>

                    <!-- Choices -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                        @foreach($q->options as $optIndex => $option)
                            @php
                                $isThisCorrect = (string)$optIndex === (string)$q->correct_answer || $option === $q->correct_answer;
                                $isThisChosen = (string)$optIndex === (string)$userAns || $option === $userAns;
                            @endphp
                            <div class="p-3 rounded-2xl flex items-center justify-between {{ $isThisCorrect ? 'bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 font-bold' : ($isThisChosen ? 'bg-rose-500/20 border border-rose-500/40 text-rose-300' : 'bg-slate-900 text-slate-400') }}">
                                <span><strong class="uppercase mr-1">{{ chr(65 + $optIndex) }}.</strong> {{ $option }}</span>
                                @if($isThisCorrect)
                                    <span class="text-[10px] font-black text-emerald-400">✓ Correct</span>
                                @elseif($isThisChosen)
                                    <span class="text-[10px] font-bold text-rose-400">✗ Your Choice</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if($q->explanation)
                        <div class="bg-slate-900/80 p-3 rounded-2xl text-slate-300 text-[11px] border border-slate-800 flex items-start space-x-2">
                            <i data-lucide="info" class="w-4 h-4 text-indigo-400 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <strong class="text-indigo-400 font-bold">Explanation:</strong> {{ $q->explanation }}
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
