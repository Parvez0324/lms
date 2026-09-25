@extends('layouts.admin')

@section('title', 'Manage Instructors')

@section('admin_content')
<div class="space-y-3.5 max-w-7xl mx-auto font-sans"
     x-data="{ 
        createModalOpen: false, 
        editModalOpen: false,
        searchQuery: '{{ request('search') }}',
        loading: false,
        activeInstructor: { id: '', name: '', email: '', headline: '', phone: '', bio: '', status: 'active' },
        openEdit(inst) {
            this.activeInstructor = { ...inst };
            this.editModalOpen = true;
        },
        async fetchInstructors() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                params.append('ajax', '1');

                const response = await fetch('{{ route('admin.instructors.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('instructors-table-container').innerHTML = html;
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
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Instructor Directory</h1>
            <p class="text-xs text-slate-500 mt-0.5">Manage verified educators, assigned courses, and teaching performance</p>
        </div>
        <button @click="createModalOpen = true" 
                class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-all">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Add Instructor</span>
        </button>
    </div>

    <!-- Filters & Search Bar with AJAX -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-1 gap-2.5 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchInstructors()" placeholder="Live search by instructor name, email, or specialty..." 
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

        <div id="instructors-table-container">
            @include('admin.instructors._table')
        </div>
    </div>

    <!-- POPUP MODAL: Create Instructor -->
    <div x-show="createModalOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.away="createModalOpen = false" 
             class="bg-white w-full max-w-lg rounded-3xl border border-slate-200 shadow-2xl p-6 relative">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900">Add New Instructor</h3>
                    <p class="text-xs text-slate-400">Register a faculty member or educator</p>
                </div>
                <button @click="createModalOpen = false" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('admin.instructors.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
                        <input type="text" name="name" required placeholder="Dr. Sarah Connor" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" required placeholder="instructor@lms.com" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Specialty / Headline</label>
                        <input type="text" name="headline" placeholder="Lead Software Architect" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Bio Summary</label>
                    <textarea name="bio" rows="2" placeholder="Brief teaching background..." 
                              class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500">
                        <option value="active" selected>Active</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md shadow-rose-500/20">Save Instructor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- POPUP MODAL: Edit Instructor -->
    <div x-show="editModalOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.away="editModalOpen = false" 
             class="bg-white w-full max-w-lg rounded-3xl border border-slate-200 shadow-2xl p-6 relative">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900">Edit Instructor</h3>
                    <p class="text-xs text-slate-400">Modify faculty profile details</p>
                </div>
                <button @click="editModalOpen = false" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form :action="'/admin/instructors/' + activeInstructor.id" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
                        <input type="text" name="name" x-model="activeInstructor.name" required 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" x-model="activeInstructor.email" required 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">New Password (Optional)</label>
                        <input type="password" name="password" placeholder="Leave blank to keep" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Headline</label>
                        <input type="text" name="headline" x-model="activeInstructor.headline" 
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Bio Summary</label>
                    <textarea name="bio" rows="2" x-model="activeInstructor.bio" 
                              class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Status</label>
                    <select name="status" x-model="activeInstructor.status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-rose-500">
                        <option value="active">Active</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md shadow-rose-500/20">Update Instructor</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
