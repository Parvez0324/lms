@extends('layouts.instructor')

@section('title', 'My Created Courses')

@section('instructor_content')
<div class="space-y-3.5 sm:space-y-4 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        status: '{{ request('status') }}',
        loading: false,
        async fetchCourses() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.status) params.append('status', this.status);
                params.append('ajax', '1');

                const response = await fetch('{{ route('instructor.courses.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('instructor-courses-table-container').innerHTML = html;
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
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">My Courses</h1>
            <p class="text-xs text-slate-500 font-normal mt-0.5">Manage your course catalog, curriculum lessons, and pricing</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('instructor.courses.create') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-all self-start sm:self-auto">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Create New Course</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-3 rounded-xl border border-slate-200/80 shadow-2xs">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchCourses()" placeholder="Live search courses by title..." 
                       class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-slate-800">
            </div>

            <div class="flex items-center space-x-2">
                <select x-model="status" @change="fetchCourses()" 
                        class="bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 rounded-lg py-1.5 pl-2.5 pr-7 focus:bg-white focus:border-brand-500">
                    <option value="">All Statuses</option>
                    <option value="published">Published Only</option>
                    <option value="draft">Drafts Only</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Courses List Table with Loading Overlay -->
    <div class="relative bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div x-show="loading" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
            <div class="flex items-center space-x-2 text-brand-600 font-semibold text-xs bg-white px-3 py-1.5 rounded-lg shadow-md border border-slate-200">
                <div class="w-3.5 h-3.5 border-2 border-brand-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Updating Courses...</span>
            </div>
        </div>

        <div id="instructor-courses-table-container">
            @include('instructor.courses._table')
        </div>
    </div>

</div>
@endsection
