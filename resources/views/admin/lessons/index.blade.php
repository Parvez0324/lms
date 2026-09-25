@extends('layouts.admin')

@section('title', 'All Lessons & Media')

@section('admin_content')
<div class="space-y-4 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        type: '{{ request('type') }}',
        loading: false,
        async fetchLessons() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.type) params.append('type', this.type);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.lessons.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('lessons-table-container').innerHTML = html;
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
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Lessons & Learning Media</h1>
            <p class="text-xs text-slate-500 mt-0.5">Cross-course media inspector for video lectures, PDF resources, and readings</p>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchLessons()" placeholder="Live search lessons by title..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
            </div>

            <select x-model="type" @change="fetchLessons()" 
                    class="bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 py-2 pl-3 pr-8 focus:bg-white focus:border-rose-500">
                <option value="">All Content Types</option>
                <option value="video">Video Lessons</option>
                <option value="pdf">PDF Documents</option>
                <option value="article">Articles / Text</option>
            </select>
        </div>
    </div>

    <!-- Table Container with Loading Overlay -->
    <div class="relative bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs">
        <div x-show="loading" class="absolute inset-0 bg-white/75 backdrop-blur-[1px] flex items-center justify-center z-10" style="display: none;">
            <div class="flex items-center space-x-2 text-rose-600 font-bold text-xs bg-white px-3.5 py-1.5 rounded-xl shadow-md border border-slate-200">
                <div class="w-3.5 h-3.5 border-2 border-rose-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering Lessons...</span>
            </div>
        </div>

        <div id="lessons-table-container">
            @include('admin.lessons._table')
        </div>
    </div>

</div>
@endsection
