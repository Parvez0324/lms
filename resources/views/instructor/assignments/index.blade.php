@extends('layouts.instructor')

@section('title', 'Student Assignments & Activity Grading')

@section('instructor_content')
<div class="space-y-2.5 max-w-7xl mx-auto font-sans" x-data="{
    createModalOpen: false,
    gradeModalOpen: false,
    activeSubmission: null,
    searchQuery: '{{ request('search') }}',
    courseId: '{{ request('course_id') }}',
    status: '{{ request('status') }}',
    loading: false,
    async fetchSubmissions() {
        this.loading = true;
        try {
            const params = new URLSearchParams();
            if (this.searchQuery) params.append('search', this.searchQuery);
            if (this.courseId) params.append('course_id', this.courseId);
            if (this.status) params.append('status', this.status);
            params.append('ajax', '1');

            const response = await fetch('{{ route('instructor.assignments.index') }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await response.text();
            document.getElementById('instructor-assignments-table-container').innerHTML = html;
            if (window.lucide) {
                lucide.createIcons();
            }
        } catch (e) {
            console.error('AJAX search error:', e);
        } finally {
            this.loading = false;
        }
    }
}">
    
    <!-- Top Header (Compact & Proportional) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex items-center space-x-2.5 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-amber-500 via-rose-500 to-indigo-600 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <i data-lucide="palette" class="w-3.5 h-3.5"></i>
            </div>
            <div class="min-w-0">
                <h1 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight truncate leading-tight">
                    Assignments & Student Grading
                </h1>
                <p class="text-[11px] text-slate-500 font-normal truncate">
                    Review student activity submissions, grade their work, and award feedback
                </p>
            </div>
        </div>

        <button @click="createModalOpen = true" 
                class="inline-flex items-center space-x-1 px-2.5 py-1 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-lg shadow-xs transition-all self-start sm:self-auto flex-shrink-0">
            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
            <span>New Activity</span>
        </button>
    </div>

    <!-- 4 Slim Metric KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5">
        
        <!-- Total Submissions -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-amber-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Total Submissions</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="file-check" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ number_format($totalSubmissions) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-amber-700 bg-amber-50 px-1 py-0.2 rounded border border-amber-200/60">
                    <span>Total</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                In your courses
            </div>
        </div>

        <!-- Awaiting Review -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-rose-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Awaiting Review</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-rose-500 to-pink-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-rose-600 tracking-tight leading-none">{{ number_format($pendingGrading) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-rose-700 bg-rose-50 px-1 py-0.2 rounded border border-rose-200/60">
                    <span>Pending</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Needs teacher review
            </div>
        </div>

        <!-- Graded -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Graded & Starred</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="award" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-emerald-600 tracking-tight leading-none">{{ number_format(max(0, $totalSubmissions - $pendingGrading)) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded border border-emerald-200/60">
                    <span>Graded</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                With stars & feedback
            </div>
        </div>

        <!-- Active Courses -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-indigo-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Activity Courses</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="book-open" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">{{ $myCourses->count() }} <span class="text-[11px] font-semibold text-slate-500">Courses</span></div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-indigo-700 bg-indigo-50 px-1 py-0.2 rounded border border-indigo-200/60">
                    <span>Live</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                With assignments
            </div>
        </div>

    </div>

    <!-- Live Filters & Search -->
    <div class="bg-white p-2.5 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSubmissions()" placeholder="Live search by student name or activity title..." 
                       class="w-full pl-8 pr-3 py-1 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-slate-800">
            </div>

            <div class="flex items-center space-x-2">
                <select x-model="courseId" @change="fetchSubmissions()" 
                        class="bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 rounded-lg py-1 pl-2 pr-6 focus:bg-white focus:border-amber-500">
                    <option value="">All Courses</option>
                    @foreach($myCourses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                    @endforeach
                </select>

                <select x-model="status" @change="fetchSubmissions()" 
                        class="bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 rounded-lg py-1 pl-2 pr-6 focus:bg-white focus:border-amber-500">
                    <option value="">All Statuses</option>
                    <option value="submitted">⏳ Needs Review</option>
                    <option value="graded">⭐ Graded</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table of Submissions with Loading Overlay -->
    <div class="relative bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div x-show="loading" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
            <div class="flex items-center space-x-2 text-amber-600 font-semibold text-xs bg-white px-3 py-1.5 rounded-lg shadow-md border border-slate-200">
                <div class="w-3.5 h-3.5 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering Submissions...</span>
            </div>
        </div>

        <div id="instructor-assignments-table-container">
            @include('instructor.assignments._table')
        </div>
    </div>

    <!-- Create Modal -->
    <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="createModalOpen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="createModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="createModalOpen" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-extrabold text-slate-900 flex items-center space-x-1.5">
                        <span>🎨</span>
                        <span>Create Activity Assignment</span>
                    </h3>
                    <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <form action="{{ route('instructor.assignments.store') }}" method="POST" class="space-y-3.5 pt-3.5">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Course *</label>
                        <select name="course_id" required class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                            @foreach($myCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Draw and Color Your Favorite Safari Animal" 
                               class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Activity Instructions</label>
                        <textarea name="description" rows="2" placeholder="Explain the drawing or activity steps for students..." 
                                  class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Max Star Points *</label>
                            <input type="number" name="points" value="100" min="1" max="1000" required 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Due Date</label>
                            <input type="date" name="due_date" 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="createModalOpen = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-4 py-1.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-xs rounded-xl shadow-xs">Create Activity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Grade Modal -->
    <div x-show="gradeModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="gradeModalOpen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="gradeModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="gradeModalOpen" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center space-x-1.5">
                            <span>⭐</span>
                            <span>Grade Activity</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="activeSubmission ? activeSubmission.student_name : ''"></p>
                    </div>
                    <button @click="gradeModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <form :action="activeSubmission ? activeSubmission.action_url : '#'" method="POST" class="space-y-3.5 pt-3.5">
                    @csrf
                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Score (Points) *</label>
                            <input type="number" name="score" required min="0" :max="activeSubmission ? activeSubmission.max_points : 100" :value="activeSubmission ? activeSubmission.current_score || activeSubmission.max_points : 100" 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Star Award / Grade</label>
                            <input type="text" name="grade" placeholder="e.g. ⭐⭐⭐ Super Star!" :value="activeSubmission ? activeSubmission.current_grade : '⭐⭐⭐ Super Star!'" 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Teacher Feedback</label>
                        <textarea name="feedback" rows="2" placeholder="Wonderful work! You used so many nice colors! ⭐" 
                                  :value="activeSubmission ? activeSubmission.current_feedback : ''"
                                  class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="gradeModalOpen = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-xs">Save Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
