@extends('layouts.instructor')

@section('title', 'Enrolled Students & Progress')

@section('instructor_content')
<div class="space-y-3.5 sm:space-y-4 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        courseId: '{{ request('course_id') }}',
        loading: false,
        async fetchStudents() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.courseId) params.append('course_id', this.courseId);
                params.append('ajax', '1');

                const response = await fetch('{{ route('instructor.students.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('students-table-container').innerHTML = html;
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
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Student Progress Tracker</h1>
            <p class="text-xs text-slate-500 font-normal mt-0.5">Track student learning velocity and course completion rates</p>
        </div>

        <!-- Filter Controls -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchStudents()" placeholder="Live search students..." 
                       class="w-full sm:w-56 pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-slate-800">
            </div>

            <select x-model="courseId" @change="fetchStudents()" 
                    class="bg-white border border-slate-200 text-xs font-semibold text-slate-700 rounded-xl py-1.5 pl-3 pr-8 focus:border-brand-500">
                <option value="">All My Courses</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table with Loading Overlay -->
    <div class="relative bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div x-show="loading" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
            <div class="flex items-center space-x-2 text-brand-600 font-semibold text-xs bg-white px-3 py-1.5 rounded-lg shadow-md border border-slate-200">
                <div class="w-3.5 h-3.5 border-2 border-brand-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering Students...</span>
            </div>
        </div>

        <div id="students-table-container">
            @include('instructor.students._table')
        </div>
    </div>

</div>
@endsection
