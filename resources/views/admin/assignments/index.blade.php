@extends('layouts.admin')

@section('title', 'Student Assignments & Grading')

@section('admin_content')
<div class="space-y-2.5 max-w-7xl mx-auto font-sans" x-data="{
    createModalOpen: false,
    gradeModalOpen: false,
    activeSubmission: null,
    searchQuery: '{{ request('search') }}',
    courseId: '{{ request('course_id') }}',
    statusFilter: '{{ request('status') }}',
    loading: false,
    async fetchSubmissions() {
        this.loading = true;
        try {
            const params = new URLSearchParams();
            if (this.searchQuery) params.append('search', this.searchQuery);
            if (this.courseId) params.append('course_id', this.courseId);
            if (this.statusFilter) params.append('status', this.statusFilter);
            params.append('ajax', '1');

            const response = await fetch('{{ route('admin.assignments.index') }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await response.text();
            document.getElementById('submissions-table-container').innerHTML = html;
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
                    Review student artwork submissions, assign grades, and award stars & feedback
                </p>
            </div>
        </div>

        <button @click="createModalOpen = true" 
                class="inline-flex items-center space-x-1 px-2.5 py-1 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-lg shadow-xs transition-all self-start sm:self-auto flex-shrink-0">
            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
            <span>New Assignment</span>
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
                Across all activities
            </div>
        </div>

        <!-- Needs Review -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-rose-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Needs Review</span>
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
                Awaiting grading
            </div>
        </div>

        <!-- Graded & Starred -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Graded & Starred</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="award" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-emerald-600 tracking-tight leading-none">{{ number_format($gradedCount) }}</div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1 py-0.2 rounded border border-emerald-200/60">
                    <span>Graded</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Feedback awarded
            </div>
        </div>

        <!-- Reviewed Rate -->
        <div class="bg-white px-3 py-2 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs hover:border-indigo-300 transition-all flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <span class="text-[9.5px] font-bold uppercase tracking-wider text-slate-400">Reviewed Rate</span>
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 text-white flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                </div>
            </div>
            <div class="mt-1 flex items-baseline justify-between">
                <div class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-none">
                    {{ $totalSubmissions > 0 ? round(($gradedCount / $totalSubmissions) * 100) : 100 }}%
                </div>
                <span class="inline-flex items-center space-x-0.5 text-[9px] font-bold text-indigo-700 bg-indigo-50 px-1 py-0.2 rounded border border-indigo-200/60">
                    <span>Done</span>
                </span>
            </div>
            <div class="mt-0.5 text-[10px] text-slate-500 font-normal">
                Completion velocity
            </div>
        </div>

    </div>

    <!-- Live Filters & Search Bar -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 flex-col sm:flex-row gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSubmissions()" placeholder="Live search by student name, email, or activity..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
            </div>

            <select x-model="courseId" @change="fetchSubmissions()" 
                    class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl py-1.5 pl-3 pr-8 focus:bg-white focus:border-amber-500">
                <option value="">All Courses</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                @endforeach
            </select>

            <select x-model="statusFilter" @change="fetchSubmissions()" 
                    class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl py-1.5 pl-3 pr-8 focus:bg-white focus:border-amber-500">
                <option value="">All Statuses</option>
                <option value="submitted">Pending Review</option>
                <option value="graded">Graded</option>
            </select>
        </div>
    </div>

    <!-- Submissions Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" id="submissions-table-container">
        @include('admin.assignments._table')
    </div>

    <!-- Modal 1: Create New Assignment -->
    <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="createModalOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="createModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="createModalOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900 flex items-center space-x-2">
                        <span>🎨</span>
                        <span>Create Activity Assignment</span>
                    </h3>
                    <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('admin.assignments.store') }}" method="POST" class="space-y-4 pt-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Select Course *</label>
                        <select name="course_id" required class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Activity Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Draw Your Favorite Animal or Trace Letter A" 
                               class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Description & Instructions</label>
                        <textarea name="description" rows="3" placeholder="Tell students and parents what fun activity to draw or complete..." 
                                  class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Max Star Points *</label>
                            <input type="number" name="points" value="100" min="1" max="1000" required 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Due Date (Optional)</label>
                            <input type="date" name="due_date" 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-xs rounded-xl shadow-md">Create Activity</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal 2: Grade Submission & Award Feedback -->
    <div x-show="gradeModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="gradeModalOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="gradeModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="gradeModalOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center space-x-2">
                            <span>⭐</span>
                            <span>Grade Student Activity</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="activeSubmission ? activeSubmission.student_name + ' • ' + activeSubmission.assignment_title : ''"></p>
                    </div>
                    <button @click="gradeModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form :action="activeSubmission ? activeSubmission.action_url : '#'" method="POST" class="space-y-4 pt-4">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Score (Points) *</label>
                            <input type="number" name="score" required min="0" :max="activeSubmission ? activeSubmission.max_points : 100" :value="activeSubmission ? activeSubmission.current_score || activeSubmission.max_points : 100" 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Grade / Star Badge</label>
                            <input type="text" name="grade" placeholder="e.g. ⭐⭐⭐ Super Star! or A+" :value="activeSubmission ? activeSubmission.current_grade : '⭐⭐⭐ Super Star!'" 
                                   class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Teacher Feedback & Encouragement</label>
                        <textarea name="feedback" rows="3" placeholder="Great coloring! Your drawing is so colorful and bright. Keep up the awesome work! ⭐" 
                                  :value="activeSubmission ? activeSubmission.current_feedback : ''"
                                  class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="gradeModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md flex items-center space-x-1.5">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Save Grade & Award Stars</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection
