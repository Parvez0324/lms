@if($enrollments->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3.5">
        @foreach($enrollments as $enrollment)
            @php 
                $course = $enrollment->course; 
                $progress = $course->getStudentProgressPercentage(Auth::id());
            @endphp
            <div class="bg-white rounded-xl border border-slate-200/90 p-3 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between group hover:border-amber-300">
                <div class="space-y-2">
                    <!-- Thumbnail -->
                    <div class="relative aspect-video rounded-lg overflow-hidden bg-slate-100 ring-1 ring-slate-100">
                        <img src="{{ $course->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $course->title }}">
                        @if($progress >= 100)
                            <div class="absolute top-2 right-2 px-2 py-0.5 bg-emerald-600 text-white font-semibold text-[9px] uppercase rounded shadow-xs flex items-center space-x-1">
                                <i data-lucide="check" class="w-3 h-3"></i>
                                <span>Completed ⭐</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="space-y-1">
                        <span class="text-[9px] font-medium uppercase tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded inline-block">
                            {{ $course->category->name ?? 'Early Learning' }}
                        </span>
                        <h3 class="font-semibold text-slate-900 text-xs line-clamp-2 leading-snug group-hover:text-amber-600 transition-colors">
                            {{ $course->title }}
                        </h3>
                        <span class="text-[11px] text-slate-500 font-normal block truncate">Teacher: {{ $course->instructor->name }}</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1 pt-0.5">
                        <div class="flex justify-between text-[11px] font-medium">
                            <span class="text-amber-600 font-semibold">⭐ {{ $progress }}% Progress</span>
                            <span class="text-slate-400 font-normal">{{ $course->total_lessons_count }} Lessons</span>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-400 via-rose-400 to-sky-400 h-1.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-2 mt-2 border-t border-slate-100 flex items-center space-x-1.5">
                    <a href="{{ route('student.course.learn', $course->slug) }}" 
                       class="flex-1 flex items-center justify-center space-x-1.5 py-1.5 px-2.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-semibold text-xs rounded-lg shadow-xs transition-all">
                        <i data-lucide="play" class="w-3 h-3 fill-white"></i>
                        <span>{{ $progress >= 100 ? 'Replay' : 'Continue' }}</span>
                    </a>

                    @if($progress >= 100)
                        <a href="{{ route('student.course.certificate', $course->slug) }}" 
                           class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition-colors" title="View Star Certificate">
                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($enrollments->hasPages())
        <div class="pt-3">
            {{ $enrollments->links() }}
        </div>
    @endif
@else
    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 text-center space-y-2.5">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto">
            <i data-lucide="search-x" class="w-5 h-5"></i>
        </div>
        <h3 class="text-sm font-semibold text-slate-900">No matching enrolled courses found</h3>
        <p class="text-xs text-slate-500 font-normal max-w-sm mx-auto">Try adjusting your search query or filter tab.</p>
    </div>
@endif
