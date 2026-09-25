@extends('layouts.admin')

@section('title', 'Course Dossier - ' . $course->title)

@section('admin_content')
<div class="space-y-6 max-w-7xl mx-auto">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $course->title }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Instructor: {{ $course->instructor->name }} • Category: {{ $course->category->name ?? 'None' }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-sm flex items-center space-x-1.5 transition-colors">
                <i data-lucide="external-link" class="w-4 h-4 text-slate-500"></i>
                <span>Public View</span>
            </a>
            <a href="{{ route('admin.courses.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <!-- Overview KPIs -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[10px] uppercase font-bold text-slate-400">Status</span>
            <div class="text-lg font-black text-slate-900 capitalize mt-1">{{ $course->status }}</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[10px] uppercase font-bold text-slate-400">Price</span>
            <div class="text-lg font-black text-emerald-600 mt-1">{{ $course->is_free ? 'FREE' : '$' . number_format($course->effective_price, 2) }}</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[10px] uppercase font-bold text-slate-400">Total Enrolled</span>
            <div class="text-lg font-black text-amber-600 mt-1">{{ $course->enrollments->count() }} Students</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
            <span class="text-[10px] uppercase font-bold text-slate-400">Avg Rating</span>
            <div class="text-lg font-black text-indigo-600 mt-1">★ {{ number_format($course->average_rating, 1) }}</div>
        </div>
    </div>

    <!-- Curriculum Breakdown -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
            <i data-lucide="layers" class="w-4 h-4 mr-2 text-rose-600"></i>
            Curriculum Sections & Lessons
        </h3>

        <div class="space-y-4">
            @forelse($course->sections as $section)
                <div class="bg-slate-50 border border-slate-200/80 p-4 rounded-2xl">
                    <div class="flex items-center justify-between font-bold text-slate-900 text-xs mb-3">
                        <span>Section: {{ $section->title }}</span>
                        <span class="text-slate-400 font-medium">{{ $section->lessons->count() }} lessons</span>
                    </div>

                    <div class="divide-y divide-slate-200/60 bg-white rounded-xl border border-slate-200/60 px-3">
                        @foreach($section->lessons as $lesson)
                            <div class="py-2.5 flex items-center justify-between text-xs text-slate-700">
                                <div class="flex items-center space-x-2.5">
                                    <i data-lucide="play-circle" class="w-4 h-4 text-rose-600"></i>
                                    <span class="font-medium">{{ $lesson->title }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 uppercase font-semibold">{{ $lesson->duration_minutes }} mins • {{ $lesson->content_type }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">No curriculum sections created yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
