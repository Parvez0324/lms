@extends('layouts.instructor')

@section('title', 'Edit Quiz - ' . $quiz->title)

@section('instructor_content')
<div class="max-w-xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Edit Quiz</h1>
            <p class="text-xs text-slate-500">Course: {{ $quiz->course->title }}</p>
        </div>
        <a href="{{ route('instructor.quizzes.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('instructor.quizzes.update', $quiz->id) }}" method="POST" class="space-y-3.5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Quiz Title</label>
                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Attach to Section</label>
                    <select name="section_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                        <option value="">Course Final Assessment</option>
                        @foreach($sections as $sec)
                            <option value="{{ $sec->id }}" {{ $quiz->section_id == $sec->id ? 'selected' : '' }}>Section: {{ $sec->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Instructions / Description</label>
                <textarea name="description" rows="2" 
                          class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">{{ old('description', $quiz->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Passing Score (%)</label>
                    <input type="number" name="pass_percentage" value="{{ old('pass_percentage', $quiz->pass_percentage) }}" min="10" max="100" required 
                           class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Time Limit (Mins)</label>
                    <input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}" min="1" max="180" required 
                           class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100 flex justify-end space-x-2">
                <a href="{{ route('instructor.quizzes.index') }}" class="px-4 py-2 text-xs font-bold text-slate-500 rounded-xl hover:bg-slate-100">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
