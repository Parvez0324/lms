@if($courses->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @foreach($courses as $course)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex flex-col overflow-hidden group">
                
                <!-- Thumbnail -->
                <div class="relative aspect-video overflow-hidden bg-slate-100">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    <div class="absolute top-2.5 left-2.5">
                        <span class="px-2 py-0.5 text-[9px] font-extrabold uppercase tracking-wider rounded-md bg-white/95 backdrop-blur-md text-slate-800 shadow-xs">
                            {{ $course->category->name ?? 'Early Learning' }}
                        </span>
                    </div>

                    @if($course->is_featured)
                        <div class="absolute top-2.5 right-2.5">
                            <span class="px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-md bg-amber-500 text-white shadow-xs flex items-center space-x-0.5">
                                <i data-lucide="star" class="w-2.5 h-2.5 fill-white"></i>
                                <span>Popular</span>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Course Body Details -->
                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                    
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span class="capitalize flex items-center text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md font-bold text-[11px]">
                                <i data-lucide="sparkles" class="w-3 h-3 mr-1 text-amber-500"></i>
                                Fun Learning
                            </span>
                            <span class="flex items-center text-amber-500 font-bold">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400 mr-1"></i>
                                {{ number_format($course->average_rating, 1) }} ({{ $course->reviews->count() }})
                            </span>
                        </div>

                        <a href="{{ route('courses.show', $course->slug) }}" class="block">
                            <h3 class="font-extrabold text-slate-900 text-base leading-snug group-hover:text-amber-600 transition-colors line-clamp-2">
                                {{ $course->title }}
                            </h3>
                        </a>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $course->subtitle ?: Str::limit($course->description, 90) }}
                        </p>
                    </div>

                    <!-- Instructor Info & Price Footer -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <img class="w-7 h-7 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" 
                                 src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}">
                            <span class="text-xs font-semibold text-slate-700 truncate">{{ $course->instructor->name }}</span>
                        </div>

                        <div class="text-right flex-shrink-0">
                            @if($course->is_free)
                                <span class="text-sm font-black text-emerald-600">FREE</span>
                            @else
                                <div class="flex items-baseline space-x-1.5">
                                    <span class="text-base font-black text-slate-900">${{ number_format($course->effective_price, 2) }}</span>
                                    @if($course->discount_price && $course->discount_price < $course->price)
                                        <span class="text-xs text-slate-400 line-through">${{ number_format($course->price, 2) }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <div class="pt-6">
            {{ $courses->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center space-y-4">
        <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto">
            <i data-lucide="sparkles" class="w-8 h-8"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900">No activities found matching your search</h3>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">Try searching for Phonics, ABCs, Numbers, Counting, Colors, or Finger Painting.</p>
        <button type="button" @click="resetFilters()" class="inline-block px-5 py-2.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-bold text-xs rounded-xl shadow-md">
            Reset All Filters
        </button>
    </div>
@endif
