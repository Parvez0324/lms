@extends('layouts.admin')

@section('title', 'Platform Reports & Analytics')

@section('admin_content')
<div class="space-y-2.5 max-w-7xl mx-auto font-sans">
    
    <!-- Top Header (Compact & Proportional) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex items-center space-x-2.5 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-rose-500 via-indigo-600 to-sky-500 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="bar-chart-3" class="w-3.5 h-3.5"></i>
            </div>
            <div class="min-w-0">
                <h1 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight truncate leading-tight">
                    Reports & Financial Analytics
                </h1>
                <p class="text-[11px] text-slate-500 font-normal truncate">
                    Platform enrollment velocity, gross sales, and top performing curriculum
                </p>
            </div>
        </div>

        <button onclick="window.print()" class="inline-flex items-center space-x-1 px-2.5 py-1 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-lg border border-slate-200 shadow-2xs transition-colors self-start sm:self-auto flex-shrink-0">
            <i data-lucide="printer" class="w-3.5 h-3.5 text-slate-500"></i>
            <span>Print Report</span>
        </button>
    </div>

    <!-- 4 Slim Metric KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5">
        
        <!-- 1. Total Platform Sales -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Platform Sales</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="dollar-sign" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">${{ number_format($totalRevenue, 2) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded border border-emerald-200/60">
                    <i data-lucide="trending-up" class="w-2.5 h-2.5"></i>
                    <span>Inflow</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Continuous gross sales
            </div>
        </div>

        <!-- 2. Active Students -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-sky-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Total Students</span>
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
                Registered learners
            </div>
        </div>

        <!-- 3. Total Enrollments -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-amber-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Course Enrollments</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="book-open" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ number_format($totalEnrollments) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-amber-700 bg-amber-50 px-1 py-0.2 rounded border border-amber-200/60">
                    <span>Joined</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Across all curriculum
            </div>
        </div>

        <!-- 4. Certificates Awarded -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-purple-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Certificates Awarded</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-purple-500 to-violet-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="award" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ number_format($totalCertificates) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-purple-700 bg-purple-50 px-1 py-0.2 rounded border border-purple-200/60">
                    <span>Issued</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Completed credentials
            </div>
        </div>

    </div>

    <!-- Top Performing Courses Table -->
    <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
        <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
            <div class="flex items-center space-x-1.5">
                <div class="w-5 h-5 rounded-md bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="trophy" class="w-3 h-3"></i>
                </div>
                <h2 class="text-[11px] font-bold uppercase tracking-wider text-slate-900">Top Performing Courses by Enrollment</h2>
            </div>
            <span class="text-[10px] font-semibold text-slate-400">Top 5 Curriculum</span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($topCourses as $course)
                <div class="py-1.5 flex items-center justify-between gap-2">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <img src="{{ $course->thumbnail_url }}" class="w-9 h-6.5 rounded-md object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                        <div class="min-w-0">
                            <span class="font-semibold text-slate-900 block leading-tight text-xs truncate">{{ $course->title }}</span>
                            <span class="text-[10px] text-slate-400 font-normal block truncate">{{ $course->instructor->name }} • {{ $course->category->name ?? 'General' }}</span>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 flex items-center space-x-2">
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-amber-50 text-amber-700 border border-amber-200/60">
                            {{ $course->enrollments_count }} Enrollments
                        </span>
                        <span class="text-xs font-bold text-slate-900 block">${{ number_format($course->effective_price, 2) }}</span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-2 text-center font-normal">No courses data available.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
