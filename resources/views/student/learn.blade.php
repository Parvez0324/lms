<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $activeLesson->title }} - {{ $course->title }} | KAN</title>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        }
    </style>
</head>
<body class="h-full bg-slate-950 text-slate-100 flex flex-col antialiased" x-data="{ sidebarOpen: true, activeTab: 'notes' }">
    
    <!-- Top Classroom Header -->
    <header class="h-16 bg-slate-900 border-b border-slate-800 px-4 sm:px-6 flex items-center justify-between z-20 flex-shrink-0">
        
        <!-- Left: Course Title & Back -->
        <div class="flex items-center space-x-3.5 min-w-0">
            <a href="{{ route('student.my-courses') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors flex-shrink-0" title="Back to Enrolled Courses">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
            <div class="truncate">
                <h1 class="text-sm font-bold text-white truncate flex items-center space-x-1.5">
                    <span class="text-indigo-400">📚</span>
                    <span>{{ $course->title }}</span>
                </h1>
                <span class="text-[11px] text-slate-400 truncate block font-medium">Lesson: {{ $activeLesson->title }}</span>
            </div>
        </div>

        <!-- Right: Progress Meter & Certificate & Sidebar Toggle -->
        <div class="flex items-center space-x-3.5 flex-shrink-0">
            
            <!-- Progress Pill -->
            <div class="hidden sm:flex items-center space-x-3 bg-slate-800/80 px-3.5 py-1.5 rounded-xl border border-slate-700/80">
                <div class="w-24 bg-slate-700 h-2 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>
                <span class="text-xs font-bold text-indigo-400">{{ $progress }}% Complete</span>
            </div>

            <!-- Certificate Button (unlocked if >= 100%) -->
            @if($progress >= 100 || $certificate)
                <a href="{{ route('student.course.certificate', $course->slug) }}" 
                   class="px-3.5 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-500/20 flex items-center space-x-1.5">
                    <i data-lucide="award" class="w-4 h-4"></i>
                    <span>Certificate</span>
                </a>
            @endif

            <!-- Sidebar Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors" title="Toggle Course Syllabus">
                <i data-lucide="sidebar" class="w-4 h-4"></i>
            </button>

        </div>

    </header>

    <!-- Main Classroom Area -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- Left Area: Player & Content Tabs -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-slate-950">
            
            <!-- Media / Video Container -->
            <div class="w-full bg-black flex items-center justify-center relative aspect-video max-h-[62vh]">
                @if($activeLesson->content_type === 'video')
                    @if($activeLesson->video_path)
                        <video controls autoplay class="w-full h-full max-h-[62vh]" src="{{ asset('storage/' . $activeLesson->video_path) }}"></video>
                    @elseif($activeLesson->video_url)
                        @php
                            $videoUrl = $activeLesson->video_url;
                            if (str_contains($videoUrl, 'watch?v=')) {
                                $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                            } elseif (str_contains($videoUrl, 'youtu.be/')) {
                                $videoUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $videoUrl);
                            }
                        @endphp
                        <iframe class="w-full h-full" src="{{ $videoUrl }}" title="{{ $activeLesson->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @else
                        <!-- Video Placeholder -->
                        <div class="text-center p-8 space-y-3">
                            <div class="w-16 h-16 rounded-3xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center mx-auto ring-4 ring-indigo-500/10">
                                <i data-lucide="play" class="w-8 h-8 fill-indigo-400 ml-1"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white flex items-center justify-center space-x-2">
                                <span>{{ $activeLesson->title }}</span>
                            </h3>
                            <p class="text-xs text-slate-400">Technical lecture stream • {{ $activeLesson->duration_minutes }} minutes</p>
                        </div>
                    @endif
                @elseif($activeLesson->content_type === 'pdf')
                    <!-- Printable / PDF Sheet Preview -->
                    <div class="text-center p-8 space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center mx-auto">
                            <i data-lucide="file-text" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">{{ $activeLesson->title }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Technical Documentation & Reference Slides (PDF)</p>
                        </div>
                        @if($activeLesson->pdf_path)
                            <a href="{{ asset('storage/' . $activeLesson->pdf_path) }}" target="_blank" download 
                               class="inline-flex items-center space-x-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs rounded-2xl shadow-lg transition-all">
                                <i data-lucide="download" class="w-4 h-4"></i>
                                <span>Download PDF Material</span>
                            </a>
                        @endif
                    </div>
                @else
                    <!-- Text Lesson Preview -->
                    <div class="text-center p-8 space-y-3">
                        <div class="w-16 h-16 rounded-3xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center mx-auto">
                            <i data-lucide="book-open" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">{{ $activeLesson->title }}</h3>
                        <p class="text-xs text-slate-400">Read the technical documentation below</p>
                    </div>
                @endif
            </div>

            <!-- Navigation & Action Control Toolbar -->
            <div class="bg-slate-900 border-y border-slate-800 p-4 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                
                <!-- Prev Lesson -->
                <div>
                    @if($prevLesson)
                        <a href="{{ route('student.course.lesson', ['course' => $course->slug, 'lesson' => $prevLesson->slug]) }}" 
                           class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs rounded-xl flex items-center space-x-1.5 transition-colors">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            <span>Previous Lesson</span>
                        </a>
                    @else
                        <span class="text-xs text-slate-600 font-medium cursor-not-allowed">First Lesson</span>
                    @endif
                </div>

                <!-- Complete & Continue Button -->
                @php $isCompleted = in_array($activeLesson->id, $completedLessonIds); @endphp
                <form action="{{ route('student.lesson.complete', $activeLesson->id) }}" method="POST">
                    @csrf
                    @if($nextLesson)
                        <input type="hidden" name="redirect_next" value="{{ route('student.course.lesson', ['course' => $course->slug, 'lesson' => $nextLesson->slug]) }}">
                    @endif
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-2xl font-bold text-xs shadow-lg flex items-center space-x-2 transition-all {{ $isCompleted ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-indigo-600/25' }}">
                        <i data-lucide="{{ $isCompleted ? 'check-circle-2' : 'circle' }}" class="w-4 h-4"></i>
                        <span>{{ $isCompleted ? 'Completed (Click to Unmark)' : 'Mark Lesson Complete' }}</span>
                    </button>
                </form>

                <!-- Next Lesson -->
                <div>
                    @if($nextLesson)
                        <a href="{{ route('student.course.lesson', ['course' => $course->slug, 'lesson' => $nextLesson->slug]) }}" 
                           class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs rounded-xl flex items-center space-x-1.5 transition-colors">
                            <span>Next Lesson</span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    @else
                        @if($progress >= 100)
                            <a href="{{ route('student.course.certificate', $course->slug) }}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-extrabold text-xs rounded-xl shadow-lg">
                                🎓 View Certificate
                            </a>
                        @else
                            <span class="text-xs text-slate-500 font-medium">Final Lesson</span>
                        @endif
                    @endif
                </div>

            </div>

            <!-- Notes & Lesson Details Tabs -->
            <div class="p-6 sm:p-8 max-w-4xl space-y-6">
                <div class="flex items-center space-x-4 border-b border-slate-800 pb-3">
                    <button @click="activeTab = 'notes'" :class="activeTab === 'notes' ? 'text-indigo-400 border-b-2 border-indigo-400 font-extrabold' : 'text-slate-400 hover:text-white'" class="pb-3 text-xs uppercase tracking-wider transition-colors flex items-center space-x-1.5">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        <span>Lesson Overview & Notes</span>
                    </button>
                    <button @click="activeTab = 'instructor'" :class="activeTab === 'instructor' ? 'text-indigo-400 border-b-2 border-indigo-400 font-extrabold' : 'text-slate-400 hover:text-white'" class="pb-3 text-xs uppercase tracking-wider transition-colors flex items-center space-x-1.5">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        <span>Instructor Bio</span>
                    </button>
                </div>

                <!-- Notes Content -->
                <div x-show="activeTab === 'notes'" class="prose prose-invert max-w-none text-xs leading-relaxed text-slate-300">
                    @if($activeLesson->article_content)
                        {!! nl2br(e($activeLesson->article_content)) !!}
                    @else
                        <p class="text-slate-400">
                            {{ $activeLesson->title }} - Work through the video lecture and accompanying materials. Click <strong>Mark Lesson Complete</strong> once you finish to track your progress toward your certificate.
                        </p>
                    @endif

                    @if($activeLesson->pdf_path)
                        <div class="mt-4 p-4 bg-slate-900 rounded-2xl border border-slate-800 flex items-center justify-between">
                            <div class="flex items-center space-x-3 text-xs">
                                <i data-lucide="file-text" class="w-5 h-5 text-indigo-400"></i>
                                <span>Attached Resource: {{ basename($activeLesson->pdf_path) }}</span>
                            </div>
                            <a href="{{ asset('storage/' . $activeLesson->pdf_path) }}" target="_blank" download class="px-3 py-1.5 bg-indigo-500/20 text-indigo-300 rounded-xl text-xs font-bold hover:bg-indigo-500/30">
                                Download File
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Instructor Tab -->
                <div x-show="activeTab === 'instructor'" style="display: none;" class="flex items-start space-x-4">
                    <img src="{{ $course->instructor->avatar_url }}" class="w-12 h-12 rounded-2xl object-cover ring-2 ring-indigo-500/40" alt="">
                    <div>
                        <h4 class="font-bold text-white text-sm">{{ $course->instructor->name }}</h4>
                        <span class="text-xs text-indigo-400">{{ $course->instructor->headline ?: 'Senior Instructor' }}</span>
                        <p class="text-xs text-slate-400 mt-2">{{ $course->instructor->bio ?: 'Experienced engineering instructor passionate about hands-on technical education.' }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Syllabus Sidebar -->
        <aside x-show="sidebarOpen" class="w-80 sm:w-96 bg-slate-900 border-l border-slate-800 flex flex-col flex-shrink-0 overflow-y-auto">
            
            <div class="p-4 border-b border-slate-800 flex items-center justify-between">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-300 flex items-center space-x-1.5">
                    <i data-lucide="layers" class="w-4 h-4 text-indigo-400"></i>
                    <span>Course Curriculum</span>
                </h3>
                <span class="text-[11px] text-indigo-400 font-bold">{{ $allLessons->count() }} Lessons</span>
            </div>

            <!-- Curriculum Tree -->
            <div class="divide-y divide-slate-800/80">
                @foreach($course->sections as $sIndex => $section)
                    <div class="py-3" x-data="{ secOpen: true }">
                        <button @click="secOpen = !secOpen" type="button" class="w-full px-4 py-2 flex items-center justify-between text-left hover:bg-slate-800/50 transition-colors">
                            <span class="text-xs font-bold text-slate-200">Section {{ $sIndex + 1 }}: {{ $section->title }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="secOpen ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="secOpen" class="space-y-1 px-2 pt-1">
                            @foreach($section->lessons as $lesson)
                                @php 
                                    $isDone = in_array($lesson->id, $completedLessonIds);
                                    $isActive = $lesson->id === $activeLesson->id;
                                @endphp
                                <a href="{{ route('student.course.lesson', ['course' => $course->slug, 'lesson' => $lesson->slug]) }}" 
                                   class="flex items-center justify-between p-2.5 rounded-2xl text-xs transition-colors {{ $isActive ? 'bg-indigo-600/20 text-white font-bold border border-indigo-500/40' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                                    <div class="flex items-center space-x-2.5 truncate">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 {{ $isDone ? 'bg-emerald-500 text-white font-bold text-[10px]' : 'border border-slate-600' }}">
                                            @if($isDone)
                                                ✓
                                            @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                            @endif
                                        </div>
                                        <span class="truncate">{{ $lesson->title }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500 flex-shrink-0 ml-2">{{ $lesson->duration_minutes }}m</span>
                                </a>
                            @endforeach

                            <!-- Quizzes under section -->
                            @foreach($section->quizzes as $quiz)
                                @php $passed = $quiz->isPassedBy(Auth::id()); @endphp
                                <a href="{{ route('student.quiz.show', $quiz->id) }}" 
                                   class="flex items-center justify-between p-2.5 rounded-2xl text-xs bg-slate-800/40 hover:bg-slate-800 text-slate-300 font-semibold border border-slate-700/40 transition-colors">
                                    <div class="flex items-center space-x-2 truncate">
                                        <i data-lucide="help-circle" class="w-3.5 h-3.5 text-indigo-400"></i>
                                        <span class="truncate">Quiz: {{ $quiz->title }}</span>
                                    </div>
                                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full {{ $passed ? 'bg-emerald-500/20 text-emerald-400' : 'bg-indigo-500/20 text-indigo-300' }}">
                                        {{ $passed ? 'Passed' : 'Take Quiz' }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </aside>

    </div>

    <!-- Lucide Init -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
