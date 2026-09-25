@extends('layouts.app')

@section('title', __('messages.app_name') . ' - ' . __('messages.tagline'))

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden pt-4 sm:pt-6 lg:pt-8 pb-10 sm:pb-12 lg:pb-14 bg-gradient-to-b from-blue-50/60 via-slate-50 to-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-start">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-3.5 sm:space-y-4 text-center lg:text-start pt-1">
                
                <!-- Pill Badge -->
                <div class="inline-flex items-center space-x-2 rtl:space-x-reverse px-3 py-1 bg-blue-50 border border-blue-200/80 text-blue-800 rounded-full text-[11px] font-extrabold tracking-wide shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>🌟 {{ __('messages.hero_badge') }}</span>
                </div>

                <!-- Balanced Heading -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black tracking-tight text-slate-900 leading-[1.18]">
                    {{ __('messages.index_hero_title') }}
                    <span class="bg-gradient-to-r from-blue-600 via-sky-500 to-indigo-600 bg-clip-text text-transparent block sm:inline">
                        {{ __('messages.index_hero_accent') }}
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-xs sm:text-sm lg:text-[15px] text-slate-600 max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">
                    {{ __('messages.index_hero_sub') }}
                </p>

                <!-- Search / CTA Bar -->
                <div class="max-w-xl mx-auto lg:mx-0 pt-0.5">
                    <form action="{{ route('courses.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 p-1.5 bg-white rounded-2xl shadow-lg shadow-blue-500/5 border border-slate-200">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 start-0 ps-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </div>
                            <input type="text" name="search" placeholder="{{ __('messages.search_placeholder') }}" 
                                   class="w-full ps-10 pe-3.5 py-2 text-xs sm:text-sm bg-transparent border-0 rounded-xl focus:ring-0 text-slate-900 placeholder-slate-400 font-medium outline-none">
                        </div>
                        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-blue-600/20 transition-all flex items-center justify-center space-x-2 rtl:space-x-reverse cursor-pointer">
                            <span>{{ __('messages.btn_explore_courses') }}</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 rtl:rotate-180"></i>
                        </button>
                    </form>
                </div>

                <!-- Value Highlights -->
                <div class="pt-1 flex flex-wrap items-center justify-center lg:justify-start gap-2 sm:gap-2.5 text-xs font-semibold text-slate-700">
                    <div class="flex items-center space-x-1.5 rtl:space-x-reverse bg-blue-50/80 text-blue-800 px-2.5 py-1 rounded-xl border border-blue-200/60 text-[11px] font-bold">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-blue-600"></i>
                        <span>{{ __('messages.highlight_interactive') }}</span>
                    </div>
                    <div class="flex items-center space-x-1.5 rtl:space-x-reverse bg-indigo-50/80 text-indigo-800 px-2.5 py-1 rounded-xl border border-indigo-200/60 text-[11px] font-bold">
                        <i data-lucide="clipboard-check" class="w-3.5 h-3.5 text-indigo-600"></i>
                        <span>{{ __('messages.highlight_quizzes') }}</span>
                    </div>
                    <div class="flex items-center space-x-1.5 rtl:space-x-reverse bg-emerald-50/80 text-emerald-800 px-2.5 py-1 rounded-xl border border-emerald-200/60 text-[11px] font-bold">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>{{ __('messages.highlight_certs') }}</span>
                    </div>
                </div>

            </div>

            <!-- Right Hero Card Visual -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md bg-white rounded-2xl shadow-xl shadow-blue-500/8 border border-slate-200/90 p-4 overflow-hidden">
                    
                    <div class="relative z-10 space-y-3.5">
                        
                        <!-- Featured Course Mockup -->
                        <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-100 shadow-xs group">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Master Full-Stack & Cloud Architecture">
                            <div class="absolute inset-0 bg-slate-900/30 flex items-center justify-center">
                                <div class="w-10 h-10 rounded-full bg-white/95 text-blue-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i data-lucide="play" class="w-4 h-4 fill-blue-600 ms-0.5"></i>
                                </div>
                            </div>
                            <div class="absolute top-2 start-2 bg-blue-600 text-white text-[9.5px] font-black px-2 py-0.5 rounded-md shadow-xs flex items-center space-x-1 rtl:space-x-reverse">
                                <i data-lucide="sparkles" class="w-2.5 h-2.5"></i>
                                <span>Featured Masterclass</span>
                            </div>
                        </div>

                        <!-- Progress Bar Card -->
                        <div>
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="font-bold text-blue-700 uppercase tracking-wider flex items-center space-x-1 rtl:space-x-reverse">
                                    <i data-lucide="star" class="w-3 h-3 text-amber-500 fill-amber-500"></i>
                                    <span>Curriculum Mastery</span>
                                </span>
                                <span class="font-bold text-slate-700">100% Completed</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 via-sky-400 to-emerald-400 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>

                        <!-- Verified Certificate Badge Card -->
                        <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200/80 flex items-center justify-between">
                            <div class="flex items-center space-x-2.5 rtl:space-x-reverse">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-sky-500 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                                    <i data-lucide="award" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-slate-900 leading-tight">Certificate of Completion</div>
                                    <div class="text-[9.5px] text-slate-500 font-medium">Digital Verification & QR Validated</div>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-600 text-white text-[9.5px] font-black rounded-md shadow-xs flex-shrink-0">
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
<section class="py-7 sm:py-8 bg-slate-900 text-white border-y border-slate-800 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x rtl:md:divide-x-reverse divide-slate-800">
            <div class="pt-4 md:pt-0">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-blue-400">{{ number_format($stats['total_students']) }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">{{ __('messages.stat_students_label') }}</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-sky-400">{{ $stats['total_courses'] }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">{{ __('messages.stat_courses_label') }}</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-indigo-300">{{ $stats['total_instructors'] }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">Expert Educators</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-emerald-400">{{ number_format($stats['total_certificates']) }}+</div>
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">{{ __('messages.stat_certificates_label') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-10 sm:py-12 bg-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-6">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600">{{ __('messages.featured_sub') }}</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">{{ __('messages.featured_courses') }}</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="mt-3 md:mt-0 inline-flex items-center space-x-1.5 rtl:space-x-reverse text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700">
                <span>{{ __('messages.view_all') }}</span>
                <i data-lucide="arrow-right" class="w-4 h-4 rtl:rotate-180"></i>
            </a>
        </div>

        <!-- Course Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($featuredCourses as $course)
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <!-- Thumbnail & Badges -->
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute top-3 start-3 flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-lg bg-white/90 backdrop-blur-md text-slate-800 shadow-xs">
                                {{ $course->category->name ?? 'Skill Pathway' }}
                            </span>
                            @if($course->is_featured)
                                <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-lg bg-blue-600 text-white shadow-xs flex items-center space-x-1 rtl:space-x-reverse">
                                    <i data-lucide="star" class="w-3 h-3 fill-white"></i>
                                    <span>{{ __('messages.popular_badge') }}</span>
                                </span>
                            @endif
                        </div>

                        <div class="absolute bottom-3 end-3">
                            <span class="px-3 py-1 text-xs font-black rounded-xl {{ $course->is_free ? 'bg-emerald-600 text-white' : 'bg-slate-900 text-white' }} shadow-md">
                                {{ $course->is_free ? 'FREE' : '$' . number_format($course->effective_price, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Course Content Body -->
                    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                <span class="capitalize font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">Curriculum</span>
                                <div class="flex items-center text-amber-500 font-bold space-x-1 rtl:space-x-reverse">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
                                    <span>{{ number_format($course->average_rating, 1) }}</span>
                                    <span class="text-slate-400 font-normal">({{ $course->reviews_count }})</span>
                                </div>
                            </div>

                            <a href="{{ route('courses.show', $course->slug) }}" class="block group-hover:text-blue-600 transition-colors">
                                <h3 class="text-base font-bold text-slate-900 line-clamp-2 leading-snug">
                                    {{ $course->title }}
                                </h3>
                            </a>

                            <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                                {{ $course->subtitle ?: Str::limit($course->description, 90) }}
                            </p>
                        </div>

                        <!-- Footer / Instructor & Stats -->
                        <div class="pt-3.5 mt-3.5 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center space-x-2.5 rtl:space-x-reverse">
                                <img src="{{ $course->instructor->avatar_url }}" class="w-7 h-7 rounded-lg object-cover" alt="">
                                <span class="text-xs font-bold text-slate-700 truncate max-w-[120px]">{{ $course->instructor->name }}</span>
                            </div>

                            <div class="flex items-center space-x-3 rtl:space-x-reverse text-xs text-slate-500 font-medium">
                                <span class="flex items-center space-x-1 rtl:space-x-reverse">
                                    <i data-lucide="play-circle" class="w-3.5 h-3.5 text-blue-500"></i>
                                    <span>{{ $course->total_lessons_count }} {{ __('messages.lessons_count') }}</span>
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
<section class="py-10 sm:py-12 bg-slate-50/70 border-t border-slate-200/80 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-6">
            <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600">{{ __('messages.categories_sub') }}</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">{{ __('messages.explore_categories') }}</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('messages.categories_desc') }}</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category->slug]) }}" 
                   class="bg-white p-4.5 rounded-2xl border border-slate-200/80 hover:border-blue-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col items-center text-center group">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center transition-colors mb-2">
                        <i data-lucide="{{ $category->icon ?: 'sparkles' }}" class="w-5 h-5"></i>
                    </div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $category->name }}</h4>
                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                    <span class="text-[10px] text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full mt-2 font-bold">{{ $category->courses_count }} Courses</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Platform Feature Highlights -->
<section class="py-10 sm:py-12 bg-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            
            <div class="bg-gradient-to-br from-blue-50 to-sky-50/40 p-5 rounded-2xl border border-blue-100">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-500/25 mb-3">
                    <i data-lucide="video" class="w-4.5 h-4.5"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1">{{ __('messages.feature_curriculum') }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    {{ __('messages.feature_curriculum_desc') }} Video streaming, resource downloads, and multi-format lesson delivery.
                </p>
            </div>

            <div class="bg-gradient-to-br from-indigo-50 to-purple-50/40 p-5 rounded-2xl border border-indigo-100">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/25 mb-3">
                    <i data-lucide="clipboard-check" class="w-4.5 h-4.5"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1">{{ __('messages.feature_quizzes') }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    {{ __('messages.feature_quizzes_desc') }} Instant test scores, grading rubrics, and detailed evaluation feedback.
                </p>
            </div>

            <div class="bg-gradient-to-br from-emerald-50 to-teal-50/40 p-5 rounded-2xl border border-emerald-100">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/25 mb-3">
                    <i data-lucide="award" class="w-4.5 h-4.5"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1">{{ __('messages.stat_certificates_label') }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Issue automated, verifiable digital certificates equipped with unique validation codes and secure public URLs.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Call to action: Teach at KAN LMS -->
<section class="py-10 sm:py-12 bg-gradient-to-r from-blue-700 via-sky-600 to-indigo-700 text-white relative overflow-hidden font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-3.5">
        <span class="px-3 py-1 bg-white/20 border border-white/30 text-white text-[11px] font-bold uppercase tracking-wider rounded-full">
            Instructor Studio
        </span>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight">{{ __('messages.cta_teach_title') }}</h2>
        <p class="text-white/90 text-xs sm:text-sm max-w-xl mx-auto font-medium leading-relaxed">
            {{ __('messages.cta_teach_sub') }}
        </p>
        <div class="pt-1.5">
            <a href="{{ route('register', ['role' => 'instructor']) }}" class="inline-flex items-center space-x-2 rtl:space-x-reverse px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs sm:text-sm rounded-xl shadow-xl transition-all hover:scale-105">
                <i data-lucide="sparkles" class="w-4 h-4 text-blue-600"></i>
                <span>{{ __('messages.btn_join_instructor') }}</span>
            </a>
        </div>
    </div>
</section>
@endsection
