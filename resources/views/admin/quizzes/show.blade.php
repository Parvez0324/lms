@extends('layouts.admin')

@section('title', 'Quiz Details - ' . $quiz->title)

@section('admin_content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $quiz->title }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Course: {{ $quiz->course->title }} • Pass Threshold: {{ $quiz->pass_percentage }}%</p>
        </div>
        <a href="{{ route('admin.quizzes.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back</span>
        </a>
    </div>

    <!-- Questions Bank List -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Questions Bank ({{ $quiz->questions->count() }} Questions)</h3>

        <div class="space-y-4">
            @forelse($quiz->questions as $index => $q)
                <div class="bg-slate-50 border border-slate-200/80 p-5 rounded-2xl space-y-3">
                    <div class="flex items-start justify-between">
                        <span class="text-xs font-bold text-slate-900 leading-snug">Q{{ $index + 1 }}. {{ $q->question_text }}</span>
                        <span class="text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded">{{ $q->points }} pt(s)</span>
                    </div>

                    <!-- Choices -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        @foreach($q->options as $optIndex => $option)
                            <div class="p-2.5 rounded-xl {{ (string)$optIndex === (string)$q->correct_answer || $option === $q->correct_answer ? 'bg-emerald-50 border border-emerald-300 text-emerald-800 font-bold' : 'bg-white border border-slate-200 text-slate-600' }}">
                                <span class="uppercase font-bold mr-1">{{ chr(65 + $optIndex) }}.</span> {{ $option }}
                            </div>
                        @endforeach
                    </div>

                    @if($q->explanation)
                        <div class="text-[11px] text-slate-600 bg-white p-3 rounded-xl border border-slate-200/80">
                            <strong class="text-slate-900">Explanation:</strong> {{ $q->explanation }}
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-xs text-slate-400 py-6 text-center">No questions added to this quiz yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
