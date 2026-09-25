@extends('layouts.app')

@section('title', $course->title . ' - KAN Early Learning')

@section('content')
<!-- Course Header Area (Warm Playful Gradient) -->
<div class="bg-gradient-to-r from-slate-900 via-amber-950 to-slate-900 text-white py-6 sm:py-8 lg:py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
            
            <!-- Left Header Details -->
            <div class="lg:col-span-8 space-y-5">
                
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-bold rounded-lg uppercase tracking-wider">
                        {{ $course->category->name ?? 'Early Learning' }}
                    </span>
                    <span class="px-3 py-1 bg-slate-800 text-slate-300 text-xs font-semibold rounded-lg capitalize">
                        Interactive Play
                    </span>
                    @if($course->is_featured)
                        <span class="px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-bold rounded-lg flex items-center space-x-1">
                            <i data-lucide="star" class="w-3 h-3 fill-amber-400"></i>
                            <span>Popular</span>
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    {{ $course->title }}
                </h1>

                @if($course->subtitle)
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-normal">
                        {{ $course->subtitle }}
                    </p>
                @endif

                <!-- Meta row -->
                <div class="flex flex-wrap items-center gap-6 pt-2 text-xs sm:text-sm text-slate-300">
                    <div class="flex items-center space-x-1 text-amber-400 font-bold">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <span>{{ number_format($course->average_rating, 1) }}</span>
                        <span class="text-slate-400 font-normal">({{ $course->reviews_count }} ratings)</span>
                    </div>

                    <div class="flex items-center space-x-1.5 text-slate-300">
                        <i data-lucide="users" class="w-4 h-4 text-emerald-400"></i>
                        <span>{{ $course->enrollments()->count() + 85 }} happy learners</span>
                    </div>

                    <div class="flex items-center space-x-1.5 text-slate-300">
                        <i data-lucide="globe" class="w-4 h-4 text-amber-400"></i>
                        <span>{{ $course->language }}</span>
                    </div>

                    <div class="flex items-center space-x-1.5 text-slate-300">
                        <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                        <span>Updated {{ $course->updated_at->format('M Y') }}</span>
                    </div>
                </div>

                <!-- Instructor attribution -->
                <div class="flex items-center space-x-3 pt-3">
                    <img src="{{ $course->instructor->avatar_url }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-amber-500/40" alt="">
                    <div>
                        <span class="text-xs text-slate-400 block">Guided by Educator</span>
                        <span class="text-sm font-bold text-white">{{ $course->instructor->name }}</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Main Body with Content & Sticky Card -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
        
        <!-- Left Column: Syllabus, Learning Outcomes, Description -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- What You'll Learn -->
            @if($course->outcomes && count($course->outcomes) > 0)
                <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
                    <h2 class="text-base font-bold text-slate-900 mb-3 flex items-center">
                        <i data-lucide="sparkles" class="w-4 h-4 mr-2 text-amber-500"></i>
                        What Little Learners Will Discover
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($course->outcomes as $outcome)
                            <div class="flex items-start space-x-2.5 text-xs text-slate-700">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600 mt-0.5 flex-shrink-0"></i>
                                <span>{{ $outcome }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Course Curriculum Section -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Activity Curriculum & Sing-Alongs</h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $course->sections->count() }} parts • {{ $course->total_lessons_count }} fun lessons • ~{{ $course->total_duration_minutes }} mins total runtime
                        </p>
                    </div>
                </div>

                <!-- Sections Accordion -->
                <div class="space-y-3" x-data="{ activeSection: 0 }">
                    @forelse($course->sections as $index => $section)
                        <div class="border border-slate-200/80 rounded-2xl overflow-hidden">
                            <button @click="activeSection = (activeSection === {{ $index }} ? null : {{ $index }})" 
                                     type="button" 
                                     class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100 transition-colors text-left">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="activeSection === {{ $index }} ? 'rotate-180' : ''"></i>
                                    <span class="text-sm font-bold text-slate-800">{{ $section->title }}</span>
                                </div>
                                <span class="text-xs text-slate-500 font-semibold">{{ $section->lessons->count() }} activities</span>
                            </button>

                            <!-- Lessons in section -->
                            <div x-show="activeSection === {{ $index }}" class="divide-y divide-slate-100 bg-white p-2">
                                @forelse($section->lessons as $lesson)
                                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors text-xs">
                                        <div class="flex items-center space-x-3">
                                            @if($lesson->content_type === 'video')
                                                <i data-lucide="play-circle" class="w-4 h-4 text-amber-500 flex-shrink-0"></i>
                                            @elseif($lesson->content_type === 'pdf')
                                                <i data-lucide="file-text" class="w-4 h-4 text-rose-500 flex-shrink-0"></i>
                                            @else
                                                <i data-lucide="palette" class="w-4 h-4 text-sky-500 flex-shrink-0"></i>
                                            @endif
                                            <span class="font-medium text-slate-800">{{ $lesson->title }}</span>
                                        </div>

                                        <div class="flex items-center space-x-3 text-slate-400">
                                            @if($lesson->is_preview)
                                                <span class="text-[10px] font-bold text-emerald-600 uppercase bg-emerald-50 px-2 py-0.5 rounded-md">Free Preview</span>
                                            @endif
                                            <span>{{ $lesson->duration_minutes }} min</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-3 text-xs text-slate-400 italic">No lessons in this module yet.</div>
                                @endforelse

                                <!-- Quizzes in section -->
                                @foreach($section->quizzes as $quiz)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50/60 hover:bg-amber-50 transition-colors text-xs border border-amber-100">
                                        <div class="flex items-center space-x-3 text-amber-900 font-bold">
                                            <i data-lucide="sparkles" class="w-4 h-4 text-amber-600 flex-shrink-0"></i>
                                            <span>Star Challenge: {{ $quiz->title }}</span>
                                        </div>
                                        <span class="text-[10px] uppercase font-bold text-amber-700">{{ $quiz->questions->count() }} Questions • {{ $quiz->pass_percentage }}% Pass Mark</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Curriculum details are being finalized by the instructor.</p>
                    @endforelse
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs space-y-2.5">
                <h2 class="text-base font-bold text-slate-900">About This Learning Course</h2>
                <div class="prose prose-slate max-w-none text-xs leading-relaxed text-slate-600">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>

            <!-- Instructor Bio -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-2xs space-y-2.5">
                <h2 class="text-base font-bold text-slate-900">Educator Profile</h2>
                <div class="flex items-start space-x-3.5">
                    <img src="{{ $course->instructor->avatar_url }}" class="w-12 h-12 rounded-xl object-cover ring-2 ring-amber-500/30 flex-shrink-0" alt="">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $course->instructor->name }}</h3>
                        <p class="text-[11px] font-semibold text-amber-600">{{ $course->instructor->headline ?: 'Certified Early Childhood Educator' }}</p>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            {{ $course->instructor->bio ?: 'Dedicated Montessori and play-based educator helping young minds blossom through joy and discovery.' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Sticky Pricing & Enrollment Card -->
        <div class="lg:col-span-4 lg:-mt-28 relative z-20">
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xl p-4 sm:p-5 space-y-4 sticky top-20">
                
                <!-- Video / Thumbnail Preview -->
                <div class="relative aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow group">
                    <img src="{{ $course->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                    @if($course->preview_video_url)
                        <a href="{{ $course->preview_video_url }}" target="_blank" class="absolute inset-0 bg-slate-900/30 flex items-center justify-center group-hover:bg-slate-900/10 transition-all">
                            <div class="w-12 h-12 rounded-full bg-white text-amber-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i data-lucide="play" class="w-5 h-5 fill-amber-500 ml-0.5"></i>
                            </div>
                        </a>
                    @endif
                </div>

                <!-- Price & CTA -->
                <div>
                    <div class="flex items-baseline space-x-3 mb-4">
                        @if($course->is_free)
                            <span class="text-3xl font-black text-emerald-600">FREE</span>
                        @else
                            <span class="text-3xl font-black text-slate-900">${{ number_format($course->effective_price, 2) }}</span>
                            @if($course->discount_price && $course->discount_price < $course->price)
                                <span class="text-lg font-bold text-slate-400 line-through">${{ number_format($course->price, 2) }}</span>
                                <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">Save ${{ number_format($course->price - $course->discount_price, 2) }}</span>
                            @endif
                        @endif
                    </div>

                    @auth
                        @if($isEnrolled)
                            <!-- Already Enrolled Button -->
                            <div class="space-y-3">
                                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3.5 text-center">
                                    <span class="text-xs font-bold text-amber-800 flex items-center justify-center space-x-1">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                                        <span>Enrolled • Keep Exploring!</span>
                                    </span>
                                    <div class="mt-2 text-[11px] text-amber-700 font-medium">Your Progress: {{ $progress }}% completed ⭐</div>
                                </div>
                                <a href="{{ route('student.course.learn', $course->slug) }}" 
                                   class="w-full flex items-center justify-center space-x-2 py-3.5 px-4 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-amber-500/25 transition-all">
                                    <i data-lucide="play-circle" class="w-5 h-5"></i>
                                    <span>Open Learning Studio</span>
                                </a>
                            </div>
                        @else
                            <!-- Enroll / Checkout Button -->
                            @if($course->is_free)
                                <form action="{{ route('student.course.enroll', $course->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center space-x-2 py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-emerald-600/25 transition-all">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        <span>Join Activity (Free)</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('student.course.checkout', $course->slug) }}" 
                                   class="w-full flex items-center justify-center space-x-2 py-3.5 px-4 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-amber-500/25 transition-all">
                                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                                    <span>Enroll in Adventure</span>
                                </a>
                            @endif
                        @endif
                    @else
                        <!-- Guest Prompt -->
                        <a href="{{ route('login') }}" 
                           class="w-full flex items-center justify-center space-x-2 py-3.5 px-4 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-amber-500/25 transition-all">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>Sign In to Start Learning</span>
                        </a>
                    @endauth
                </div>

                <!-- Course Includes List -->
                <div class="border-t border-slate-100 pt-5 space-y-3 text-xs text-slate-700 font-medium">
                    <div class="font-bold uppercase tracking-wider text-[11px] text-slate-400 mb-2">This Activity Includes:</div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="video" class="w-4 h-4 text-amber-500"></i>
                        <span>{{ $course->total_lessons_count }} cheerful sing-along videos</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="palette" class="w-4 h-4 text-rose-500"></i>
                        <span>Hands-on drawing & coloring assignments</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                        <span>Fun quiz games with star badges</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
                        <span>Official Star Award Certificate</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="infinity" class="w-4 h-4 text-sky-500"></i>
                        <span>Full lifetime access for curious minds</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
