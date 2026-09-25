@extends('layouts.app')

@section('title', 'Playful Phonics, Numbers, Sing-Alongs & Early Learning - KAN')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden pt-10 pb-16 lg:pt-16 lg:pb-24 bg-gradient-to-b from-amber-50/70 via-rose-50/40 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <div class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-rose-100 border border-amber-200 text-amber-900 rounded-full text-xs font-black tracking-wide shadow-xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>🌟 JOYFUL EARLY LEARNING & INTERACTIVE ADVENTURES • KAN</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.15]">
                    Where Curious Little Minds 
                    <span class="bg-gradient-to-r from-amber-500 via-rose-500 to-sky-500 bg-clip-text text-transparent">
                        Sing, Play & Learn
                    </span> Joyfully
                </h1>

                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                    Interactive sing-along phonics, cheerful counting adventures, rainbow finger painting, and creative activity assignments designed by certified early childhood educators.
                </p>

                <!-- Search / CTA Bar -->
                <div class="max-w-xl mx-auto lg:mx-0 pt-2">
                    <form action="{{ route('courses.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 p-2 bg-white rounded-3xl shadow-xl shadow-amber-500/10 border border-slate-200">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="search" class="w-5 h-5"></i>
                            </div>
                            <input type="text" name="search" placeholder="Search Phonics, Numbers, Animals, Colors..." 
                                   class="w-full pl-11 pr-4 py-3 text-sm bg-transparent border-0 rounded-2xl focus:ring-0 text-slate-900 placeholder-slate-400">
                        </div>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-amber-500/25 transition-all flex items-center justify-center space-x-2">
                            <span>Explore Activities</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>

                <!-- Value Highlights -->
                <div class="pt-3 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs font-extrabold text-slate-700">
                    <div class="flex items-center space-x-1.5 bg-amber-50 text-amber-800 px-3 py-1.5 rounded-full border border-amber-200">
                        <i data-lucide="sparkles" class="w-4 h-4 text-amber-600"></i>
                        <span>Sing-Along Phonics</span>
                    </div>
                    <div class="flex items-center space-x-1.5 bg-rose-50 text-rose-800 px-3 py-1.5 rounded-full border border-rose-200">
                        <i data-lucide="palette" class="w-4 h-4 text-rose-600"></i>
                        <span>Creative Art Activities</span>
                    </div>
                    <div class="flex items-center space-x-1.5 bg-sky-50 text-sky-800 px-3 py-1.5 rounded-full border border-sky-200">
                        <i data-lucide="award" class="w-4 h-4 text-sky-600"></i>
                        <span>Glowing Star Certificates</span>
                    </div>
                </div>

            </div>

            <!-- Right Hero Card Visual -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md bg-white rounded-3xl shadow-2xl shadow-amber-500/10 border border-slate-200/90 p-5 overflow-hidden">
                    
                    <div class="relative z-10 space-y-4">
                        
                        <div class="relative rounded-2xl overflow-hidden aspect-video bg-slate-100 shadow-md group">
                            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop&q=80" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Phonics Alphabet Sing-Along">
                            <div class="absolute inset-0 bg-slate-900/30 flex items-center justify-center">
                                <div class="w-12 h-12 rounded-full bg-white/95 text-amber-500 flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                                    <i data-lucide="play" class="w-5 h-5 fill-amber-500 ml-0.5"></i>
                                </div>
                            </div>
                            <div class="absolute top-2.5 left-2.5 bg-amber-500 text-white text-[10px] font-black px-2.5 py-0.5 rounded-lg shadow-sm flex items-center space-x-1">
                                <i data-lucide="sparkles" class="w-3 h-3"></i>
                                <span>Featured Adventure</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-extrabold text-amber-600 uppercase tracking-wider flex items-center space-x-1">
                                    <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500"></i>
                                    <span>Alphabet Mastery</span>
                                </span>
                                <span class="font-extrabold text-slate-700">100% Super Star ⭐</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-400 via-rose-400 to-sky-400 h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="bg-amber-50/70 p-3.5 rounded-2xl border border-amber-200/80 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-400 to-rose-400 text-white flex items-center justify-center shadow-sm">
                                    <i data-lucide="award" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-extrabold text-slate-900">Star Certificate of Completion</div>
                                    <div class="text-[10px] text-amber-800 font-semibold">Phonics & Alphabet Sing-Along Fun</div>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-600 text-white text-[10px] font-black rounded-lg shadow-sm">
                                Verified
                            </span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Platform Statistics Banner -->
<section class="py-10 bg-slate-900 text-white border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-amber-400">{{ number_format($stats['total_students']) }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">Happy Little Learners</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400">{{ $stats['total_courses'] }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">Playful Courses</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-sky-400">{{ $stats['total_instructors'] }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">Caring Educators</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-3xl sm:text-4xl font-extrabold text-rose-400">{{ number_format($stats['total_certificates']) }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">Star Awards Issued</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-amber-600">Explore & Discover</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Featured Learning Adventures</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="mt-4 md:mt-0 inline-flex items-center space-x-2 text-sm font-bold text-amber-600 hover:text-amber-700">
                <span>View All Activities</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Course Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredCourses as $course)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <!-- Thumbnail & Badges -->
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute top-3 left-3 flex items-center space-x-2">
                            <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-lg bg-white/90 backdrop-blur-md text-slate-800 shadow-sm">
                                {{ $course->category->name ?? 'Early Learning' }}
                            </span>
                            @if($course->is_featured)
                                <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-lg bg-amber-500 text-white shadow-sm flex items-center space-x-1">
                                    <i data-lucide="star" class="w-3 h-3 fill-white"></i>
                                    <span>Popular</span>
                                </span>
                            @endif
                        </div>

                        <div class="absolute bottom-3 right-3">
                            <span class="px-3 py-1 text-xs font-black rounded-xl {{ $course->is_free ? 'bg-emerald-600 text-white' : 'bg-slate-900 text-white' }} shadow-md">
                                {{ $course->is_free ? 'FREE ACTIVITY' : '$' . number_format($course->effective_price, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Course Content Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                <span class="capitalize font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">Interactive Play</span>
                                <div class="flex items-center text-amber-500 font-bold space-x-1">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
                                    <span>{{ number_format($course->average_rating, 1) }}</span>
                                    <span class="text-slate-400 font-normal">({{ $course->reviews_count }})</span>
                                </div>
                            </div>

                            <a href="{{ route('courses.show', $course->slug) }}" class="block group-hover:text-amber-600 transition-colors">
                                <h3 class="text-lg font-extrabold text-slate-900 line-clamp-2 leading-snug">
                                    {{ $course->title }}
                                </h3>
                            </a>

                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                {{ $course->subtitle ?: Str::limit($course->description, 100) }}
                            </p>
                        </div>

                        <!-- Footer / Instructor & Stats -->
                        <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center space-x-2.5">
                                <img src="{{ $course->instructor->avatar_url }}" class="w-7 h-7 rounded-lg object-cover" alt="">
                                <span class="text-xs font-bold text-slate-700 truncate max-w-[120px]">{{ $course->instructor->name }}</span>
                            </div>

                            <div class="flex items-center space-x-3 text-xs text-slate-500 font-medium">
                                <span class="flex items-center space-x-1">
                                    <i data-lucide="play-circle" class="w-3.5 h-3.5 text-amber-500"></i>
                                    <span>{{ $course->total_lessons_count }} Lessons</span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Course Categories Grid -->
<section class="py-16 bg-slate-50/70 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-extrabold uppercase tracking-widest text-amber-600">Playful Themes</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Explore Fun Learning Categories</h2>
            <p class="text-sm text-slate-500 mt-2">Discover joyful courses across alphabet phonics, playful numbers, rainbow colors, animal safari, and catchy nursery rhymes.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category->slug]) }}" 
                   class="bg-white p-6 rounded-3xl border border-slate-200/80 hover:border-amber-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white flex items-center justify-center transition-colors mb-3">
                        <i data-lucide="{{ $category->icon ?: 'sparkles' }}" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 group-hover:text-amber-600 transition-colors">{{ $category->name }}</h4>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                    <span class="text-[11px] text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full mt-2 font-bold">{{ $category->courses_count }} Activities</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Platform Feature Highlights -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-gradient-to-br from-amber-50 to-rose-50/40 p-8 rounded-3xl border border-amber-100">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/25 mb-6">
                    <i data-lucide="video" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Sing-Along Video Classrooms</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Catchy nursery rhymes, friendly cartoon animations, tracing guides, and interactive sing-along adventures.
                </p>
            </div>

            <div class="bg-gradient-to-br from-rose-50 to-purple-50/40 p-8 rounded-3xl border border-rose-100">
                <div class="w-12 h-12 rounded-2xl bg-rose-500 text-white flex items-center justify-center shadow-lg shadow-rose-500/25 mb-6">
                    <i data-lucide="palette" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Creative Drawing & Activity Tasks</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Upload photos of colorful drawings, crafts, and finger paintings to receive personalized encouragement and teacher star grades.
                </p>
            </div>

            <div class="bg-gradient-to-br from-sky-50 to-emerald-50/40 p-8 rounded-3xl border border-sky-100">
                <div class="w-12 h-12 rounded-2xl bg-sky-500 text-white flex items-center justify-center shadow-lg shadow-sky-500/25 mb-6">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Glowing Star Awards</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Celebrate learning milestones with official print-ready star certificates with unique verification codes.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Call to action: Teach at KAN -->
<section class="py-16 bg-gradient-to-r from-amber-500 via-rose-500 to-sky-500 text-white relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
        <span class="px-3.5 py-1.5 bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider rounded-full">
            Educators & Creators Studio
        </span>
        <h2 class="text-3xl sm:text-4xl font-black tracking-tight">Teach & Inspire Young Learners at KAN</h2>
        <p class="text-white/95 text-base max-w-2xl mx-auto font-medium">
            Share your early childhood curriculum, musical stories, and creative games with parents and young learners worldwide.
        </p>
        <div class="pt-2">
            <a href="{{ route('register', ['role' => 'instructor']) }}" class="inline-flex items-center space-x-2 px-8 py-4 bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-sm rounded-2xl shadow-xl transition-all hover:scale-105">
                <i data-lucide="sparkles" class="w-5 h-5 text-amber-500"></i>
                <span>Join as Instructor</span>
            </a>
        </div>
    </div>
</section>
@endsection
