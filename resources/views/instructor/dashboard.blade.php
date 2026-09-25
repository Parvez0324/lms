@extends('layouts.instructor')

@section('title', 'Instructor Studio - KAN')

@section('instructor_content')
<div class="space-y-2.5 max-w-7xl mx-auto font-sans">
    
    <!-- Top Welcome Header (Compact, Sleek, Proportional) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex items-center space-x-2.5 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-amber-500 via-rose-500 to-indigo-600 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
            </div>
            <div class="min-w-0">
                <h1 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight truncate leading-tight">
                    Instructor Studio • {{ Auth::user()->name }} 🎓
                </h1>
                <p class="text-[11px] text-slate-500 font-normal truncate">
                    Manage your curriculum, video lessons, enrolled learners, and revenue
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-2 self-start sm:self-auto flex-shrink-0">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10.5px] font-semibold border border-emerald-200/60 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                Studio Live
            </span>
            <a href="{{ route('instructor.courses.create') }}" class="px-2.5 py-1 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-lg shadow-xs flex items-center space-x-1 transition-all">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                <span>New Course</span>
            </a>
        </div>
    </div>

    <!-- 4 Slim Metric KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5">
        
        <!-- 1. Total Earnings -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Total Revenue</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="dollar-sign" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">${{ number_format($totalEarnings, 2) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded border border-emerald-200/60">
                    <i data-lucide="trending-up" class="w-2.5 h-2.5"></i>
                    <span>Inflow</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Gross course revenue
            </div>
        </div>

        <!-- 2. Active Students -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-sky-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Enrolled Learners</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-sky-500 to-blue-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="users" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ number_format($totalStudents) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-sky-700 bg-sky-50 px-1 py-0.2 rounded border border-sky-200/60">
                    <i data-lucide="user-check" class="w-2.5 h-2.5"></i>
                    <span>Active</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Learners in your courses
            </div>
        </div>

        <!-- 3. Active Courses -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-indigo-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Published Courses</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="film" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ $totalCourses }} <span class="text-[11px] font-semibold text-slate-500">Live</span></div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-indigo-700 bg-indigo-50 px-1 py-0.2 rounded border border-indigo-200/60">
                    <i data-lucide="layers" class="w-2.5 h-2.5"></i>
                    <span>Published</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Live in public catalog
            </div>
        </div>

        <!-- 4. Total Lessons -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-rose-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Lessons & Media</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-rose-500 to-amber-500 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="video" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ $totalLessons }} <span class="text-[11px] font-semibold text-slate-500">Units</span></div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-rose-700 bg-rose-50 px-1 py-0.2 rounded border border-rose-200/60">
                    <i data-lucide="play-circle" class="w-2.5 h-2.5"></i>
                    <span>Ready</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Interactive video lessons
            </div>
        </div>

    </div>

    <!-- Main Content 2-Column Grid (7 Cols Left, 5 Cols Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-2.5">
        
        <!-- Left Column: My Courses (7 Cols) -->
        <div class="lg:col-span-7 space-y-2.5">
            
            <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-md bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i data-lucide="layers" class="w-3 h-3"></i>
                        </div>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">My Course Curriculum</h2>
                    </div>
                    <a href="{{ route('instructor.courses.index') }}" class="text-[11px] text-brand-600 hover:text-brand-700 font-semibold flex items-center space-x-0.5">
                        <span>All Courses</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($myCourses->take(3) as $course)
                        <div class="py-1.5 flex items-center justify-between gap-2">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                <img src="{{ $course->thumbnail_url }}" class="w-9 h-6.5 rounded-md object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                                <div class="min-w-0">
                                    <a href="{{ route('instructor.courses.show', $course->id) }}" class="font-semibold text-slate-900 hover:text-brand-600 block text-xs truncate">
                                        {{ $course->title }}
                                    </a>
                                    <span class="text-[10px] text-slate-400 font-normal block truncate">
                                        {{ $course->category->name ?? 'General' }} • {{ $course->sections_count }} sections • {{ $course->enrollments_count }} learners
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 flex-shrink-0">
                                <span class="px-1.5 py-0.5 text-[8.5px] font-bold uppercase tracking-wider rounded {{ $course->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                                <a href="{{ route('instructor.courses.show', $course->id) }}" class="p-1 text-slate-400 hover:text-brand-600 rounded hover:bg-slate-50 transition-colors" title="Manage Curriculum">
                                    <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center font-normal">You have not created any courses yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column: Recent Learners & Studio Quick Hub (5 Cols) -->
        <div class="lg:col-span-5 space-y-2.5">
            
            <!-- Recent Enrolled Students -->
            <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="user-check" class="w-3 h-3"></i>
                        </div>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">Recent Enrolled Learners</h2>
                    </div>
                    <a href="{{ route('instructor.students.index') }}" class="text-[11px] text-emerald-600 hover:text-emerald-700 font-semibold">View All</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentEnrollments->take(3) as $enrollment)
                        <div class="py-1.5 flex items-center justify-between gap-2">
                            <div class="flex items-center space-x-2 min-w-0">
                                <img src="{{ $enrollment->user->avatar_url }}" class="w-6 h-6 rounded-full object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                                <div class="min-w-0">
                                    <span class="font-semibold text-slate-900 block text-xs truncate">{{ $enrollment->user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal block truncate max-w-[140px] sm:max-w-xs">{{ $enrollment->course->title }}</span>
                                </div>
                            </div>
                            <span class="text-[9px] text-slate-400 font-normal flex-shrink-0">{{ $enrollment->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3 text-center font-normal">No students have enrolled yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Studio Quick Actions -->
            <div class="bg-white p-2.5 sm:px-3 sm:py-2 rounded-xl border border-slate-200/80 shadow-2xs flex items-center justify-between text-xs font-semibold text-slate-600">
                <a href="{{ route('instructor.courses.create') }}" class="flex items-center space-x-1 hover:text-brand-600 transition-colors">
                    <i data-lucide="plus" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>New Course</span>
                </a>
                <span>•</span>
                <a href="{{ route('instructor.assignments.index') }}" class="flex items-center space-x-1 hover:text-brand-600 transition-colors">
                    <i data-lucide="check-square" class="w-3.5 h-3.5 text-indigo-500"></i>
                    <span>Assignments</span>
                </a>
                <span>•</span>
                <a href="{{ route('instructor.students.index') }}" class="flex items-center space-x-1 hover:text-brand-600 transition-colors">
                    <i data-lucide="users" class="w-3.5 h-3.5 text-emerald-500"></i>
                    <span>Students</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
