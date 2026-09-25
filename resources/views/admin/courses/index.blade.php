@extends('layouts.admin')

@section('title', 'Manage All Courses')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        categoryId: '{{ request('category_id') }}',
        statusFilter: '{{ request('status') }}',
        loading: false,
        async fetchCourses() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.categoryId) params.append('category_id', this.categoryId);
                if (this.statusFilter) params.append('status', this.statusFilter);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.courses.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('courses-table-container').innerHTML = html;
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
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Course Oversight</h1>
            <p class="text-xs text-slate-500 mt-0.5">Review all published, draft, and featured courses across the platform</p>
        </div>

        <a href="{{ route('instructor.courses.create') }}" class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-xl shadow-xs flex items-center space-x-1.5 transition-all self-start sm:self-auto">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Create New Course</span>
        </a>
    </div>

    <!-- Filters & Search with AJAX -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 flex-col sm:flex-row gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchCourses()" placeholder="Live search courses by title..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
            </div>

            <select x-model="categoryId" @change="fetchCourses()" 
                    class="bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 py-1.5 pl-3 pr-8 focus:bg-white focus:border-rose-500">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select x-model="statusFilter" @change="fetchCourses()" 
                    class="bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 py-1.5 pl-3 pr-8 focus:bg-white focus:border-rose-500">
                <option value="">All Statuses</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
    </div>

    <!-- Courses Table with AJAX Loading Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm relative">
        <div x-show="loading" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10 transition-opacity" style="display: none;">
            <div class="flex items-center space-x-2 text-rose-600 font-bold text-xs">
                <div class="w-4 h-4 border-2 border-rose-600 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering...</span>
            </div>
        </div>

        <div id="courses-table-container">
            @include('admin.courses._table')
        </div>
    </div>
</div>
@endsection
