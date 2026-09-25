@extends('layouts.admin')

@section('title', 'Manage Enrollments')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans" 
     x-data="{ 
        enrollModalOpen: false,
        searchQuery: '{{ request('search') }}',
        statusFilter: '{{ request('status') }}',
        loading: false,
        async fetchEnrollments() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.statusFilter) params.append('status', this.statusFilter);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.enrollments.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('enrollments-table-container').innerHTML = html;
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
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Course Enrollments</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitor student course admissions and grant manual access</p>
        </div>
        <button @click="enrollModalOpen = true" 
                class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-all">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Manual Enrollment</span>
        </button>
    </div>

    <!-- Filters & Search Bar with AJAX -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchEnrollments()" placeholder="Live search by student name, email, or course..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
            </div>
            
            <select x-model="statusFilter" @change="fetchEnrollments()" 
                    class="bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 py-1.5 pl-3 pr-8 focus:bg-white focus:border-rose-500">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <!-- Table with Dynamic AJAX Loading Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm relative">
        <div x-show="loading" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10 transition-opacity" style="display: none;">
            <div class="flex items-center space-x-2 text-rose-600 font-bold text-xs">
                <div class="w-4 h-4 border-2 border-rose-600 border-t-transparent rounded-full animate-spin"></div>
                <span>Filtering...</span>
            </div>
        </div>

        <div id="enrollments-table-container">
            @include('admin.enrollments._table')
        </div>
    </div>

    <!-- POPUP MODAL: Manual Enroll Student -->
    <div x-show="enrollModalOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.away="enrollModalOpen = false" 
             class="bg-white w-full max-w-md rounded-3xl border border-slate-200 shadow-2xl p-6 relative">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900">Manual Enrollment</h3>
                    <p class="text-xs text-slate-400">Grant student instant course access</p>
                </div>
                <button @click="enrollModalOpen = false" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('admin.enrollments.store') }}" method="POST" class="space-y-3.5">
                @csrf

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Select Student</label>
                    <select name="user_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500">
                        <option value="">Choose a student...</option>
                        @foreach(\App\Models\User::where('role', 'student')->orderBy('name')->get() as $std)
                            <option value="{{ $std->id }}">{{ $std->name }} ({{ $std->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Select Course</label>
                    <select name="course_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500">
                        <option value="">Choose a course...</option>
                        @foreach(\App\Models\Course::orderBy('title')->get() as $crs)
                            <option value="{{ $crs->id }}">{{ $crs->title }} (${{ number_format($crs->effective_price, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Enrollment Status</label>
                    <select name="status" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500">
                        <option value="active" selected>Active (Enrolled)</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" @click="enrollModalOpen = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md shadow-rose-500/20">Enroll Now</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
