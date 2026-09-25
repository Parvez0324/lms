@extends('layouts.student')

@section('title', 'My Enrolled Courses - KAN')

@section('student_content')
<div class="space-y-3.5 sm:space-y-4 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        status: '{{ request('status', '') }}',
        loading: false,
        async fetchMyCourses() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.status) params.append('status', this.status);
                params.append('ajax', '1');

                const response = await fetch('{{ route('student.my-courses') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('my-courses-container').innerHTML = html;
                if (window.lucide) {
                    lucide.createIcons();
                }
            } catch (e) {
                console.error('AJAX search error:', e);
            } finally {
                this.loading = false;
            }
        },
        setStatus(newStatus) {
            this.status = newStatus;
            this.fetchMyCourses();
        }
     }">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/90 shadow-2xs">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center space-x-2">
                <span>📚</span>
                <span>My Enrolled Courses</span>
            </h1>
            <p class="text-xs text-slate-500 font-normal mt-0.5">Resume your fun activities, review sing-alongs, and track your star progress</p>
        </div>
        <a href="{{ route('courses.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-xl shadow-xs transition-all self-start sm:self-auto">
            <i data-lucide="compass" class="w-4 h-4"></i>
            <span>Browse More Activities</span>
        </a>
    </div>

    <!-- Live Search & Filter Bar -->
    <div class="bg-white p-3 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchMyCourses()" placeholder="Live search my courses or teachers..." 
                       class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-slate-800">
            </div>

            <!-- Status Tabs -->
            <div class="flex items-center space-x-1 bg-slate-100/80 p-1 rounded-xl">
                <button type="button" @click="setStatus('')" 
                        class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all"
                        :class="status === '' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-500 hover:text-slate-800'">
                    All Courses
                </button>
                <button type="button" @click="setStatus('active')" 
                        class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all"
                        :class="status === 'active' ? 'bg-amber-500 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-800'">
                    In Progress
                </button>
                <button type="button" @click="setStatus('completed')" 
                        class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all"
                        :class="status === 'completed' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-500 hover:text-slate-800'">
                    Completed ⭐
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Courses Grid with Loading Overlay -->
    <div class="relative min-h-[150px]">
        <div x-show="loading" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] flex items-center justify-center z-10 rounded-xl" style="display: none;">
            <div class="flex items-center space-x-2 text-amber-600 font-semibold text-xs bg-white px-3 py-1.5 rounded-lg shadow-md border border-slate-200">
                <div class="w-3.5 h-3.5 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Updating My Courses...</span>
            </div>
        </div>

        <div id="my-courses-container">
            @include('student._my_courses_grid')
        </div>
    </div>

</div>
@endsection
