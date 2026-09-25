@extends('layouts.app')

@section('title', 'Technical Quiz - ' . $quiz->title . ' | KAN')

@section('content')
<div class="bg-slate-900 text-white min-h-[90vh] py-10" x-data="{ 
    timeLeft: {{ $quiz->time_limit_minutes * 60 }},
    formatTime() {
        let m = Math.floor(this.timeLeft / 60);
        let s = this.timeLeft % 60;
        return `${m}:${s < 10 ? '0' : ''}${s}`;
    },
    init() {
        let timer = setInterval(() => {
            if (this.timeLeft > 0) {
                this.timeLeft--;
            } else {
                clearInterval(timer);
                document.getElementById('quizForm').submit();
            }
        }, 1000);
    }
}">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Quiz Header with Live Countdown Timer -->
        <div class="bg-slate-950/90 p-5 sm:p-6 rounded-3xl border border-indigo-500/30 shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sticky top-20 z-30 backdrop-blur-md">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-400 flex items-center space-x-1">
                    <i data-lucide="help-circle" class="w-3.5 h-3.5 mr-1"></i>
                    <span>Knowledge Assessment</span>
                </span>
                <h1 class="text-xl font-bold text-white mt-0.5">{{ $quiz->title }}</h1>
                <span class="text-xs text-slate-400">Course: {{ $quiz->course->title }} • Pass Mark: {{ $quiz->pass_percentage }}%</span>
            </div>

            <!-- Countdown Timer Badge -->
            <div class="flex items-center space-x-2 bg-indigo-500/10 border border-indigo-500/30 px-4 py-2 rounded-2xl flex-shrink-0">
                <i data-lucide="clock" class="w-4 h-4 text-indigo-400"></i>
                <span class="text-xs text-slate-300 font-semibold">Time Remaining:</span>
                <span class="font-mono font-black text-sm text-indigo-300" x-text="formatTime()"></span>
            </div>
        </div>

        @if($previousAttempt)
            <div class="bg-slate-950/60 p-4 rounded-2xl border border-slate-800 text-xs flex items-center justify-between">
                <div class="text-slate-300">
                    Previous Attempt: <strong class="{{ $previousAttempt->is_passed ? 'text-emerald-400' : 'text-rose-400' }}">{{ $previousAttempt->percentage }}% ({{ $previousAttempt->is_passed ? 'PASSED' : 'FAILED' }})</strong>
                </div>
                <span class="text-slate-500">{{ $previousAttempt->created_at->diffForHumans() }}</span>
            </div>
        @endif

        <!-- Quiz Questions Form -->
        <form id="quizForm" action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST" class="space-y-6">
            @csrf

            @forelse($quiz->questions as $qIndex => $question)
                <div class="bg-slate-950/80 p-6 sm:p-7 rounded-3xl border border-slate-800 space-y-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-base font-bold text-white leading-relaxed">
                            <span class="text-indigo-400 font-black mr-1">Q{{ $qIndex + 1 }}.</span>
                            {{ $question->question_text }}
                        </h3>
                        <span class="text-[10px] font-extrabold text-indigo-400 bg-indigo-500/20 px-2.5 py-1 rounded-full">{{ $question->points }} pts</span>
                    </div>

                    <!-- Choices List -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        @foreach($question->options as $optIndex => $option)
                            <label class="flex items-center p-4 rounded-2xl bg-slate-900/90 hover:bg-slate-850 border border-slate-800 hover:border-indigo-400/60 cursor-pointer transition-all group">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optIndex }}" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-700 bg-slate-800">
                                <span class="ml-3 text-xs sm:text-sm text-slate-200 font-medium group-hover:text-white">
                                    <strong class="uppercase text-indigo-400 mr-1.5 font-bold">{{ chr(65 + $optIndex) }}.</strong>
                                    {{ $option }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-slate-950/60 p-10 rounded-3xl border border-slate-800 text-center text-xs text-slate-400">
                    No questions configured for this quiz yet.
                </div>
            @endforelse

            <div class="pt-4 flex justify-between items-center">
                <a href="{{ route('student.course.learn', $quiz->course->slug) }}" class="px-4 py-2 text-xs font-bold text-slate-400 hover:text-white">← Return to Classroom</a>
                <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-2xl shadow-xl shadow-indigo-600/25 transition-all flex items-center space-x-2">
                    <span>Submit Assessment</span>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
