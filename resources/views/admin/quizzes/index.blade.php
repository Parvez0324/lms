@extends('layouts.admin')

@section('title', 'Manage Quizzes & Question Bank')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        loading: false,
        async fetchQuizzes() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.quizzes.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('quizzes-table-container').innerHTML = html;
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
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Quizzes & Assessment Bank</h1>
            <p class="text-xs text-slate-500 mt-0.5">Review course quizzes, question banks, and student submission test scores</p>
        </div>
    </div>

    <!-- Live Search Bar -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchQuizzes()" placeholder="Live search by quiz title or course..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
            </div>
        </div>
    </div>

    <!-- Quizzes Table with AJAX Loading Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm relative">
        <div x-show="loading" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10 transition-opacity" style="display: none;">
            <div class="flex items-center space-x-2 text-rose-600 font-bold text-xs">
                <div class="w-4 h-4 border-2 border-rose-600 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering...</span>
            </div>
        </div>

        <div id="quizzes-table-container">
            @include('admin.quizzes._table')
        </div>
    </div>

    <!-- Recent Student Attempts -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 mb-4 flex items-center">
            <i data-lucide="activity" class="w-4 h-4 mr-2 text-rose-600"></i>
            Recent Quiz Submissions
        </h3>

        <div class="divide-y divide-slate-100">
            @forelse($recentAttempts as $attempt)
                <div class="py-3.5 flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $attempt->user->avatar_url }}" class="w-8 h-8 rounded-xl object-cover ring-1 ring-slate-200" alt="">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $attempt->user->name }}</span>
                            <span class="text-[11px] text-slate-400 font-medium">{{ $attempt->quiz->title }} • {{ $attempt->quiz->course->title }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-sm block {{ $attempt->is_passed ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $attempt->percentage }}% ({{ $attempt->score }}/{{ $attempt->total_points }} pts)
                        </span>
                        <span class="text-[10px] uppercase font-extrabold {{ $attempt->is_passed ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $attempt->is_passed ? 'PASSED' : 'FAILED' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-6 text-center">No student test attempts recorded yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
