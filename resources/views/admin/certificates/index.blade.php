@extends('layouts.admin')

@section('title', 'Issued Certificates')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        loading: false,
        issueModalOpen: false,
        async fetchCertificates() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.certificates.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('certificates-table-container').innerHTML = html;
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
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Issued Certificates</h1>
            <p class="text-xs text-slate-500 mt-0.5">Audit and manually issue star certificates to students upon course milestones</p>
        </div>

        <button type="button" @click="issueModalOpen = true" 
                class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-xl shadow-xs flex items-center space-x-1.5 transition-all self-start sm:self-auto">
            <i data-lucide="award" class="w-4 h-4"></i>
            <span>Issue Certificate to Student</span>
        </button>
    </div>

    <!-- Live Search Bar -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchCertificates()" placeholder="Live search by certificate code, student, or course..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition-all">
            </div>
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

        <div id="certificates-table-container">
            @include('admin.certificates._table')
        </div>
    </div>

    <!-- Modal: Issue Certificate Directly to Student -->
    <div x-show="issueModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;">
        <div @click.away="issueModalOpen = false" 
             class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 space-y-4 animate-scale-in">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <i data-lucide="award" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Issue Certificate</h3>
                        <p class="text-[10px] text-slate-500">Award official digital credential to a student</p>
                    </div>
                </div>
                <button @click="issueModalOpen = false" type="button" class="text-slate-400 hover:text-slate-600 p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('admin.certificates.store') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Select Student</label>
                    <select name="user_id" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-slate-900">
                        <option value="">-- Choose Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Select Course</label>
                    <select name="course_id" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-slate-900">
                        <option value="">-- Choose Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-2 flex items-center justify-end space-x-2">
                    <button type="button" @click="issueModalOpen = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-black text-xs rounded-xl shadow-md transition-all">
                        Award Certificate &rarr;
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
