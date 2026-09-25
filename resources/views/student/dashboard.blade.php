@extends('layouts.student')

@section('title', 'Student Dashboard - KAN')

@section('student_content')
<div class="space-y-2.5 max-w-7xl mx-auto font-sans">
    
    <!-- Top Welcome Header (Playful, Compact & Sleek) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 bg-gradient-to-r from-amber-400 via-rose-400 to-sky-400 px-3.5 py-2 rounded-xl text-white shadow-xs">
        <div class="space-y-0.5 min-w-0">
            <div class="inline-flex items-center space-x-1 px-2 py-0.2 rounded-full bg-white/20 backdrop-blur-xs text-[9.5px] font-bold tracking-wide">
                <span>⭐ LITTLE EXPLORER PORTAL</span>
            </div>
            <h1 class="text-sm sm:text-base font-bold tracking-tight text-white truncate leading-tight">
                Welcome back, {{ Auth::user()->name }}! 🌟
            </h1>
            <p class="text-[11px] text-white/90 font-normal truncate">
                Continue your learning adventures, songs, and earn Star Awards!
            </p>
        </div>

        <div class="flex items-center space-x-1.5 self-start sm:self-auto flex-shrink-0">
            <a href="{{ route('student.assignments.index') }}" class="px-2.5 py-1 bg-white/20 hover:bg-white/30 text-white font-semibold text-xs rounded-lg backdrop-blur-xs border border-white/30 flex items-center space-x-1 transition-all">
                <i data-lucide="palette" class="w-3.5 h-3.5"></i>
                <span>Activities</span>
            </a>
            <a href="{{ route('courses.index') }}" class="px-2.5 py-1 bg-white hover:bg-slate-50 text-slate-900 font-semibold text-xs rounded-lg shadow-2xs flex items-center space-x-1 transition-all">
                <i data-lucide="compass" class="w-3.5 h-3.5 text-amber-500"></i>
                <span>Catalog</span>
            </a>
        </div>
    </div>

    <!-- 3 Slim Metric KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
        
        <!-- In Progress -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:border-amber-300 transition-colors flex items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">In Progress</span>
                <div class="text-base sm:text-lg font-black text-amber-500 leading-none">{{ $inProgressCount }}</div>
                <span class="text-[10px] text-amber-600 font-normal block">Active adventures</span>
            </div>
            <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0">
                <i data-lucide="play-circle" class="w-4 h-4"></i>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition-colors flex items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Completed</span>
                <div class="text-base sm:text-lg font-black text-emerald-600 leading-none">{{ $completedEnrollmentsCount }}</div>
                <span class="text-[10px] text-emerald-600 font-normal block">Activities finished</span>
            </div>
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
            </div>
        </div>

        <!-- Star Awards -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:border-rose-300 transition-colors flex items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider block">Star Awards</span>
                <div class="text-base sm:text-lg font-black text-rose-500 leading-none">{{ $certificates->count() }}</div>
                <span class="text-[10px] text-rose-500 font-normal block">Earned certificates</span>
            </div>
            <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center flex-shrink-0">
                <i data-lucide="award" class="w-4 h-4"></i>
            </div>
        </div>

    </div>

    <!-- Active Learning Grid -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center space-x-1.5">
                <span>📚</span>
                <span>My Active Courses</span>
            </h2>
            <a href="{{ route('student.my-courses') }}" class="text-[11px] font-semibold text-amber-600 hover:text-amber-700">View All</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2.5">
            @forelse($enrollments as $enrollment)
                @php 
                    $course = $enrollment->course; 
                    $progress = $course->getStudentProgressPercentage(Auth::id());
                @endphp
                <div class="bg-white rounded-xl border border-slate-200/80 p-2.5 shadow-2xs hover:shadow-xs transition-all flex flex-col justify-between group hover:border-amber-300">
                    <div class="space-y-1.5">
                        <div class="relative aspect-video rounded-lg overflow-hidden bg-slate-100 ring-1 ring-slate-100">
                            <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $course->title }}">
                            @if($progress >= 100)
                                <div class="absolute top-1.5 right-1.5 px-1.5 py-0.2 bg-emerald-600 text-white font-bold text-[8.5px] uppercase rounded shadow-xs flex items-center space-x-0.5">
                                    <i data-lucide="check" class="w-2.5 h-2.5 text-white"></i>
                                    <span>Completed ⭐</span>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-0.5">
                            <span class="text-[8.5px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded inline-block">
                                {{ $course->category->name ?? 'Early Learning' }}
                            </span>
                            <h3 class="font-semibold text-slate-900 text-xs line-clamp-1 group-hover:text-amber-600 transition-colors">
                                {{ $course->title }}
                            </h3>
                            <span class="text-[10px] text-slate-400 font-normal block truncate">Teacher: {{ $course->instructor->name }}</span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-0.5 pt-0.5">
                            <div class="flex justify-between text-[10px]">
                                <span class="text-amber-600 font-semibold">⭐ {{ $progress }}%</span>
                                <span class="text-slate-400 font-normal">{{ $course->total_lessons_count }} Lessons</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-400 via-rose-400 to-sky-400 h-1 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-1.5 mt-1.5 border-t border-slate-100 flex items-center space-x-1.5">
                        <a href="{{ route('student.course.learn', $course->slug) }}" 
                           class="flex-1 flex items-center justify-center space-x-1 py-1 px-2 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-lg shadow-xs transition-all">
                            <i data-lucide="play" class="w-3 h-3 fill-white"></i>
                            <span>{{ $progress >= 100 ? 'Replay' : 'Continue' }}</span>
                        </a>

                        @if($progress >= 100)
                            <a href="{{ route('student.course.certificate', $course->slug) }}" 
                               class="p-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition-colors flex-shrink-0" title="View Star Certificate">
                                <i data-lucide="award" class="w-3.5 h-3.5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-5 rounded-xl border border-slate-200 text-center space-y-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mx-auto">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900">You have no active courses yet</h3>
                    <p class="text-[11px] text-slate-500 font-normal max-w-sm mx-auto">Explore phonics, numbers, animal songs, and finger painting to start your learning journey!</p>
                    <a href="{{ route('courses.index') }}" class="inline-block px-3 py-1 bg-gradient-to-r from-amber-500 to-rose-500 text-white font-semibold text-xs rounded-lg shadow-xs">
                        Explore Courses
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Certificates & Star Awards Shelf -->
    @if($certificates->count() > 0)
        <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs p-2.5 sm:p-3 space-y-2">
            <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-1.5">
                <i data-lucide="award" class="w-3.5 h-3.5 text-amber-500"></i>
                <span>Earned Star Certificates</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                @foreach($certificates as $cert)
                    <div class="bg-gradient-to-tr from-amber-50/50 to-rose-50/30 p-2 rounded-lg border border-amber-200/70 flex items-center justify-between hover:border-amber-400 transition-colors">
                        <div class="flex items-center space-x-2 min-w-0">
                            <div class="w-6 h-6 rounded-md bg-gradient-to-tr from-amber-400 to-rose-400 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                                <i data-lucide="award" class="w-3 h-3"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-semibold text-xs text-slate-900 truncate">{{ $cert->course->title }}</h4>
                                <span class="font-mono text-[8.5px] text-amber-700 block font-normal uppercase truncate">{{ $cert->certificate_code }}</span>
                            </div>
                        </div>
                        <a href="{{ route('student.course.certificate', $cert->course->slug) }}" class="p-1 text-amber-600 hover:bg-amber-100/50 rounded transition-colors flex-shrink-0" title="View Star Certificate">
                            <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
