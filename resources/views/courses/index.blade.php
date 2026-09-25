@extends('layouts.app')

@section('title', 'Explore Courses - KAN LMS')

@section('content')
<div class="bg-slate-50 min-h-screen py-4 sm:py-5 font-sans"
     x-data="{
        searchQuery: '{{ request('search') }}',
        category: '{{ request('category') }}',
        level: '{{ request('level', 'all') }}',
        price: '{{ request('price') }}',
        sort: '{{ request('sort', 'featured') }}',
        loading: false,
        async fetchCourses() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.category) params.append('category', this.category);
                if (this.level && this.level !== 'all') params.append('level', this.level);
                if (this.price) params.append('price', this.price);
                if (this.sort) params.append('sort', this.sort);
                params.append('ajax', '1');

                const response = await fetch('{{ route('courses.index') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('public-courses-grid-container').innerHTML = html;
                if (window.lucide) {
                    lucide.createIcons();
                }
            } catch (e) {
                console.error('AJAX search error:', e);
            } finally {
                this.loading = false;
            }
        },
        resetFilters() {
            this.searchQuery = '';
            this.category = '';
            this.level = 'all';
            this.price = '';
            this.sort = 'featured';
            this.fetchCourses();
        }
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="mb-3.5 flex flex-col md:flex-row md:items-center md:justify-between gap-2.5">
            <div>
                <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight flex items-center space-x-2 rtl:space-x-reverse">
                    <i data-lucide="compass" class="w-5 h-5 text-blue-600"></i>
                    <span>{{ __('messages.explore_courses') }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('messages.categories_desc') }}</p>
            </div>

            <!-- Sorting Dropdown -->
            <div class="flex items-center space-x-2">
                <label class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Sort By:</label>
                <select x-model="sort" @change="fetchCourses()" 
                        class="text-xs font-semibold rounded-xl border border-slate-200 bg-white py-1.5 pl-2.5 pr-7 text-slate-700 focus:ring-amber-500 focus:border-amber-500">
                    <option value="featured">Featured Courses</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-5 items-start">
            
            <!-- Left Filter Sidebar -->
            <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/80 shadow-2xs space-y-3.5">
                
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-900 flex items-center">
                        <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 mr-1.5 text-amber-500"></i>
                        Filter Activities
                    </h3>
                    <button type="button" @click="resetFilters()" class="text-[11px] font-semibold text-rose-600 hover:underline">Reset</button>
                </div>

                <div class="space-y-3">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-slate-700 mb-1">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                            </div>
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchCourses()" placeholder="Phonics, Numbers, Colors, Art..." 
                                   class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-slate-700 mb-1">Category</label>
                        <div class="space-y-0.5 max-h-40 overflow-y-auto pr-1 text-xs">
                            <label class="flex items-center justify-between p-1 rounded-md hover:bg-slate-50 cursor-pointer">
                                <div class="flex items-center">
                                    <input type="radio" name="category" value="" x-model="category" @change="fetchCourses()" class="text-amber-500 focus:ring-amber-500 h-3.5 w-3.5">
                                    <span class="ml-2 text-slate-700 font-medium text-xs">All Categories</span>
                                </div>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center justify-between p-1 rounded-md hover:bg-slate-50 cursor-pointer">
                                    <div class="flex items-center">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" x-model="category" @change="fetchCourses()" class="text-amber-500 focus:ring-amber-500 h-3.5 w-3.5">
                                        <span class="ml-2 text-slate-700 font-medium text-xs">{{ $cat->name }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-semibold">({{ $cat->courses_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-slate-700 mb-1">Price</label>
                        <div class="space-y-0.5 text-xs">
                            <label class="flex items-center p-1 rounded-md hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="price" value="" x-model="price" @change="fetchCourses()" class="text-amber-500 focus:ring-amber-500 h-3.5 w-3.5">
                                <span class="ml-2 text-slate-700 font-medium text-xs">All Activities</span>
                            </label>
                            <label class="flex items-center p-1 rounded-md hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="price" value="free" x-model="price" @change="fetchCourses()" class="text-amber-500 focus:ring-amber-500 h-3.5 w-3.5">
                                <span class="ml-2 text-slate-700 font-medium text-xs">Free Activities</span>
                            </label>
                            <label class="flex items-center p-1 rounded-md hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="price" value="paid" x-model="price" @change="fetchCourses()" class="text-amber-500 focus:ring-amber-500 h-3.5 w-3.5">
                                <span class="ml-2 text-slate-700 font-medium text-xs">Paid Adventures</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Course Cards Grid with AJAX Container -->
            <div class="lg:col-span-3 relative">
                <div x-show="loading" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10 rounded-2xl transition-opacity" style="display: none;">
                    <div class="flex items-center space-x-2 text-amber-600 font-semibold text-xs bg-white px-3 py-1.5 rounded-lg shadow-md border border-slate-200">
                        <div class="w-3.5 h-3.5 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                        <span>Updating Activities...</span>
                    </div>
                </div>

                <div id="public-courses-grid-container">
                    @include('courses._grid')
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
