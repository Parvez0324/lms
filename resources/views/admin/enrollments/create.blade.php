@extends('layouts.admin')

@section('title', 'Manual Course Enrollment')

@section('admin_content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manual Course Enrollment</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Directly enroll a student into a specific course</p>
        </div>
        <a href="{{ route('admin.enrollments.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1.5 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.enrollments.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Select Student</label>
                <select name="user_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
                    <option value="">Choose a student...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Select Course</label>
                <select name="course_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
                    <option value="">Choose a course...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }} (${{ number_format($course->effective_price, 2) }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Enrollment Status</label>
                <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
                    <option value="active" selected>Active (Enrolled)</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md shadow-rose-500/20 transition-all flex items-center space-x-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Enroll Student</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
