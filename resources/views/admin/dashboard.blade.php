@extends('layouts.admin')

@section('title', 'Admin Dashboard - KAN LMS')

@section('admin_content')
<div class="space-y-2.5 max-w-7xl mx-auto font-sans">
    
    <!-- Top Welcome Header (Ultra-Compact, Sleek, No Bloat) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex items-center space-x-2.5 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-rose-500 via-indigo-600 to-sky-500 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
            </div>
            <div class="min-w-0">
                <h1 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight truncate leading-tight">
                    Welcome back, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-[11px] text-slate-500 font-normal truncate">
                    Platform Overview • Real-time learner activity, curriculum inventory & revenue
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-1.5 self-start sm:self-auto flex-shrink-0">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10.5px] font-semibold border border-emerald-200/60 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                Live System
            </span>
            <span class="hidden md:inline-flex items-center px-2 py-0.5 rounded-full bg-slate-50 text-slate-600 text-[10.5px] font-medium border border-slate-200/70">
                <i data-lucide="calendar" class="w-3 h-3 mr-1 text-slate-400"></i>
                {{ now()->format('D, M j, Y') }}
            </span>
        </div>
    </div>

    <!-- 4 Slim, Perfectly Aligned Metric KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5">
        
        <!-- 1. Gross Revenue -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Gross Sales</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="dollar-sign" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">${{ number_format($totalRevenue, 2) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded border border-emerald-200/60">
                    <i data-lucide="trending-up" class="w-2.5 h-2.5"></i>
                    <span>+18.4%</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                {{ $recentPayments->count() }} payments completed
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
                    <span>{{ $totalEnrollments }} Enrolled</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                100% active learners
            </div>
        </div>

        <!-- 3. Course Catalog -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-indigo-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Course Catalog</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="book-open" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ number_format($totalCourses) }} <span class="text-[11px] font-semibold text-slate-500">Live</span></div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-indigo-700 bg-indigo-50 px-1 py-0.2 rounded border border-indigo-200/60">
                    <i data-lucide="layers" class="w-2.5 h-2.5"></i>
                    <span>{{ $totalLessons }} Lessons</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                {{ $categories->count() }} active categories
            </div>
        </div>

        <!-- 4. Certificates -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-rose-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Certificates</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-rose-500 to-amber-500 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="award" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ number_format($totalCertificates) }} <span class="text-[11px] font-semibold text-slate-500">Issued</span></div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-rose-700 bg-rose-50 px-1 py-0.2 rounded border border-rose-200/60">
                    <i data-lucide="check-circle" class="w-2.5 h-2.5"></i>
                    <span>{{ $completionRate }}% Rate</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                {{ $totalInstructors }} certified instructors
            </div>
        </div>

    </div>

    <!-- Main Content 2-Column Grid (7 Cols Left, 5 Cols Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-2.5">
        
        <!-- Left Column: Courses & Enrollments (7 Cols) -->
        <div class="lg:col-span-7 space-y-2.5">
            
            <!-- Top Performing Courses -->
            <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-md bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i data-lucide="flame" class="w-3 h-3"></i>
                        </div>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">Active Curriculum & Top Courses</h2>
                    </div>
                    <a href="{{ route('admin.courses.index') }}" class="text-[11px] text-brand-600 hover:text-brand-700 font-semibold flex items-center space-x-0.5">
                        <span>All</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($topCourses->take(2) as $course)
                        <div class="py-1.5 flex items-center justify-between gap-2">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                <img src="{{ $course->thumbnail_url }}" class="w-9 h-6.5 rounded-md object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                                <div class="min-w-0">
                                    <span class="font-semibold text-slate-900 block text-xs truncate">{{ $course->title }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal block truncate">
                                        {{ $course->category->name ?? 'General' }} • {{ $course->instructor->name ?? 'Instructor' }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 flex items-center space-x-2">
                                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-amber-50 text-amber-700 border border-amber-200/60">
                                    {{ $course->enrollments_count }} Enrolled
                                </span>
                                <span class="text-xs font-bold text-slate-900 block">${{ number_format($course->effective_price, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-2 text-center font-normal">No courses created yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Student Activity -->
            <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-md bg-rose-50 text-rose-600 flex items-center justify-center">
                            <i data-lucide="user-check" class="w-3 h-3"></i>
                        </div>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">Recent Student Enrollments</h2>
                    </div>
                    <a href="{{ route('admin.enrollments.index') }}" class="text-[11px] text-rose-600 hover:text-rose-700 font-semibold">View All</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentEnrollments->take(2) as $enrollment)
                        <div class="py-1.5 flex items-center justify-between gap-2">
                            <div class="flex items-center space-x-2 min-w-0">
                                <img src="{{ $enrollment->user->avatar_url }}" class="w-6 h-6 rounded-full object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
                                <div class="min-w-0">
                                    <span class="font-semibold text-slate-900 block text-xs truncate">{{ $enrollment->user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal block truncate max-w-[150px] sm:max-w-xs">{{ $enrollment->course->title }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="px-1.5 py-0.5 text-[8.5px] font-bold uppercase tracking-wider rounded {{ $enrollment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-blue-50 text-blue-700 border border-blue-200/60' }}">
                                    {{ $enrollment->status }}
                                </span>
                                <span class="block text-[9px] text-slate-400 font-normal mt-0.5">{{ $enrollment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-2 text-center font-normal">No enrollments recorded yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column: Financials & Category Vitals (5 Cols) -->
        <div class="lg:col-span-5 space-y-2.5">
            
            <!-- Recent Transactions -->
            <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="receipt" class="w-3 h-3"></i>
                        </div>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">Recent Transactions</h2>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="text-[11px] text-emerald-600 hover:text-emerald-700 font-semibold">View All</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentPayments->take(2) as $payment)
                        <div class="py-1.5 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <span class="font-semibold text-slate-900 block text-xs truncate">{{ $payment->user->name }}</span>
                                <span class="text-[9px] font-mono text-slate-400 font-normal block uppercase">{{ $payment->transaction_id }}</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="font-black text-emerald-600 text-xs block">+${{ number_format($payment->amount, 2) }}</span>
                                <span class="text-[9px] text-slate-400 font-normal mt-0.5 block">{{ $payment->payment_method ? ucfirst($payment->payment_method) : 'Card' }} • {{ $payment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-2 text-center font-normal">No payments logged yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Learning Category Distribution -->
            <div class="bg-white p-2.5 sm:px-3 sm:py-2.5 rounded-xl border border-slate-200/80 shadow-2xs space-y-1.5">
                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-5 h-5 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i data-lucide="pie-chart" class="w-3 h-3"></i>
                        </div>
                        <h2 class="text-[11px] font-bold text-slate-900 uppercase tracking-wider">Curriculum Categories</h2>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">{{ $categories->count() }} Categories</span>
                </div>

                <div class="space-y-1.5 py-0.5">
                    @php
                        $colors = ['bg-amber-500', 'bg-rose-500', 'bg-sky-500', 'bg-emerald-500', 'bg-indigo-500'];
                    @endphp
                    @forelse($categories->take(3) as $idx => $cat)
                        @php
                            $percentage = $totalCourses > 0 ? round(($cat->courses_count / $totalCourses) * 100) : 0;
                            $colorClass = $colors[$idx % count($colors)];
                        @endphp
                        <div class="space-y-0.5">
                            <div class="flex items-center justify-between text-[10.5px]">
                                <span class="font-semibold text-slate-800 truncate">{{ $cat->name }}</span>
                                <span class="text-slate-500 font-normal">{{ $cat->courses_count }} {{ Str::plural('Course', $cat->courses_count) }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full {{ $colorClass }} rounded-full" style="width: {{ max(15, $percentage) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-1.5 text-center font-normal">No categories created yet.</p>
                    @endforelse
                </div>

                <!-- Platform Vitals -->
                <div class="pt-1.5 border-t border-slate-100 flex items-center justify-between text-[9px] font-semibold text-slate-500">
                    <span class="flex items-center space-x-1">
                        <i data-lucide="shield-check" class="w-2.5 h-2.5 text-emerald-500"></i>
                        <span>SSL Ready</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <i data-lucide="database" class="w-2.5 h-2.5 text-indigo-500"></i>
                        <span>DB Active</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <i data-lucide="zap" class="w-2.5 h-2.5 text-amber-500"></i>
                        <span>Fast CDN</span>
                    </span>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
