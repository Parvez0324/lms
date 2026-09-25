@extends('layouts.instructor')

@section('title', 'Curriculum Builder - ' . $course->title)

@section('instructor_content')
<div class="space-y-4 max-w-6xl mx-auto" 
     x-data="{ 
        addSectionModal: false, 
        addLessonModal: false, 
        activeSectionId: null,
        activeSectionTitle: '',
        lessonContentType: 'video',
        openAddLesson(secId, secTitle) {
            this.activeSectionId = secId;
            this.activeSectionTitle = secTitle;
            this.addLessonModal = true;
            $nextTick(() => { if (window.lucide) lucide.createIcons(); });
        }
     }">
    
    <!-- Course Top Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center space-x-3.5 min-w-0">
            <img src="{{ $course->thumbnail_url }}" class="w-14 h-10 rounded-xl object-cover ring-1 ring-slate-200 flex-shrink-0" alt="">
            <div class="truncate">
                <h1 class="text-base sm:text-lg font-black text-slate-900 tracking-tight truncate">{{ $course->title }}</h1>
                <div class="flex items-center space-x-2 text-xs text-slate-500 mt-0.5 font-medium">
                    <span class="font-bold text-brand-600">{{ $course->category->name ?? 'General' }}</span>
                    <span>•</span>
                    <span>{{ $course->sections->count() }} sections</span>
                    <span>•</span>
                    <span>{{ $course->total_lessons_count }} lessons</span>
                    <span>•</span>
                    <span class="font-bold text-slate-900">${{ number_format($course->effective_price, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-2 flex-shrink-0">
            <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="px-3 py-1.5 text-slate-600 bg-slate-100 hover:bg-slate-200 font-bold text-xs rounded-xl flex items-center space-x-1 transition-colors">
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                <span>Preview</span>
            </a>
            <a href="{{ route('instructor.courses.edit', $course->id) }}" class="px-3 py-1.5 text-brand-600 bg-brand-50 hover:bg-brand-100 font-bold text-xs rounded-xl flex items-center space-x-1 transition-colors">
                <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('instructor.quizzes.create', $course->id) }}" class="px-3 py-1.5 text-purple-600 bg-purple-50 hover:bg-purple-100 font-bold text-xs rounded-xl flex items-center space-x-1 transition-colors">
                <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                <span>Add Quiz</span>
            </a>
            <button @click="addSectionModal = true" type="button" class="px-3.5 py-1.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/20 flex items-center space-x-1.5 transition-all">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>Add Section</span>
            </button>
        </div>
    </div>

    <!-- Curriculum Builder List -->
    <div class="space-y-3">
        @forelse($course->sections as $index => $section)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 space-y-3" x-data="{ editSection: false }">
                
                <!-- Section Header -->
                <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                    <div x-show="!editSection" class="flex items-center space-x-2.5">
                        <span class="w-6 h-6 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center font-black text-[11px]">
                            {{ $index + 1 }}
                        </span>
                        <h3 class="font-extrabold text-xs text-slate-900">{{ $section->title }}</h3>
                    </div>

                    <!-- Edit Section Title Form -->
                    <div x-show="editSection" class="flex-1 mr-4" style="display: none;">
                        <form action="{{ route('instructor.sections.update', $section->id) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $section->title }}" required class="flex-1 px-3 py-1 text-xs rounded-xl border border-slate-200">
                            <button type="submit" class="px-3 py-1 bg-emerald-600 text-white font-bold text-xs rounded-xl">Save</button>
                            <button type="button" @click="editSection = false" class="px-3 py-1 bg-slate-100 text-slate-600 text-xs rounded-xl">Cancel</button>
                        </form>
                    </div>

                    <div x-show="!editSection" class="flex items-center space-x-1.5">
                        <button type="button" 
                                @click="openAddLesson({{ $section->id }}, '{{ addslashes($section->title) }}')"
                                class="px-2.5 py-1 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold text-xs rounded-xl flex items-center space-x-1 transition-colors">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Add Lesson</span>
                        </button>
                        <button @click="editSection = true" class="p-1 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100">
                            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                        </button>
                        <form action="{{ route('instructor.sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('Delete this section and all its lessons?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-slate-100">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Lessons list in this section -->
                <div class="space-y-1.5">
                    @forelse($section->lessons as $lesson)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100/70 transition-colors text-xs">
                            <div class="flex items-center space-x-2.5">
                                @if($lesson->content_type === 'video')
                                    <div class="w-7 h-7 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="play-circle" class="w-3.5 h-3.5"></i>
                                    </div>
                                @elseif($lesson->content_type === 'pdf')
                                    <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                    </div>
                                @else
                                    <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="book" class="w-3.5 h-3.5"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $lesson->title }}</span>
                                    <div class="flex items-center space-x-2 text-[10px] text-slate-400 mt-0.5">
                                        <span class="uppercase font-semibold">{{ $lesson->content_type }}</span>
                                        <span>•</span>
                                        <span>{{ $lesson->duration_minutes }} mins</span>
                                        @if($lesson->is_preview)
                                            <span>•</span>
                                            <span class="text-emerald-600 font-bold uppercase">Free Preview</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-1">
                                <a href="{{ route('instructor.lessons.edit', $lesson->id) }}" class="p-1 text-slate-400 hover:text-brand-600 rounded-lg hover:bg-white" title="Edit Lesson">
                                    <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                                </a>
                                <form action="{{ route('instructor.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Delete this lesson?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-white" title="Delete Lesson">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-1.5 px-2 italic">No lessons in this section yet. Click "Add Lesson" above.</p>
                    @endforelse
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center space-y-2.5">
                <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Your course has no sections yet</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Create your first section (e.g. "Chapter 1: Getting Started") to begin adding lessons.</p>
                <button @click="addSectionModal = true" class="px-4 py-2 bg-brand-600 text-white font-bold text-xs rounded-xl shadow">Add First Section</button>
            </div>
        @endforelse
    </div>

    <!-- POPUP MODAL: Add Section -->
    <div x-show="addSectionModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="addSectionModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-sm text-slate-900">Create New Section</h3>
                <button @click="addSectionModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('instructor.sections.store', $course->id) }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Section Title</label>
                    <input type="text" name="title" required placeholder="e.g. Chapter 1: Introduction & Environment Setup" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                    <button type="button" @click="addSectionModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold bg-brand-600 hover:bg-brand-700 text-white rounded-xl shadow-md">Add Section</button>
                </div>
            </form>
        </div>
    </div>

    <!-- POPUP MODAL: Add Lesson -->
    <div x-show="addLessonModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="addLessonModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Add Lesson</h3>
                    <p class="text-xs text-slate-400">Section: <span class="text-brand-600 font-semibold" x-text="activeSectionTitle"></span></p>
                </div>
                <button @click="addLessonModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form :action="'/instructor/sections/' + activeSectionId + '/lessons'" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Lesson Title</label>
                    <input type="text" name="title" required placeholder="e.g. Setting up the Development Environment" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                </div>

                <!-- Content Type Selector -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Content Type</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label @click="lessonContentType = 'video'" :class="lessonContentType === 'video' ? 'border-brand-600 bg-brand-50 text-brand-900 font-bold' : 'border-slate-200 text-slate-600'" 
                               class="flex items-center justify-center p-2 border rounded-xl cursor-pointer text-xs transition-colors">
                            <input type="radio" name="content_type" value="video" x-model="lessonContentType" class="sr-only">
                            <i data-lucide="play-circle" class="w-3.5 h-3.5 mr-1 text-brand-600"></i> Video
                        </label>

                        <label @click="lessonContentType = 'pdf'" :class="lessonContentType === 'pdf' ? 'border-amber-600 bg-amber-50 text-amber-900 font-bold' : 'border-slate-200 text-slate-600'" 
                               class="flex items-center justify-center p-2 border rounded-xl cursor-pointer text-xs transition-colors">
                            <input type="radio" name="content_type" value="pdf" x-model="lessonContentType" class="sr-only">
                            <i data-lucide="file-text" class="w-3.5 h-3.5 mr-1 text-amber-600"></i> PDF Guide
                        </label>

                        <label @click="lessonContentType = 'article'" :class="lessonContentType === 'article' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 text-slate-600'" 
                               class="flex items-center justify-center p-2 border rounded-xl cursor-pointer text-xs transition-colors">
                            <input type="radio" name="content_type" value="article" x-model="lessonContentType" class="sr-only">
                            <i data-lucide="book" class="w-3.5 h-3.5 mr-1 text-blue-600"></i> Article
                        </label>
                    </div>
                </div>

                <!-- Video Specific Fields -->
                <div x-show="lessonContentType === 'video'" class="space-y-2">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Video URL (YouTube / Vimeo / MP4)</label>
                        <input type="url" name="video_url" placeholder="https://www.youtube.com/watch?v=..." 
                               class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Or Upload Video File (.mp4)</label>
                        <input type="file" name="video_file" accept="video/*" 
                               class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-brand-50 file:text-brand-700">
                    </div>
                </div>

                <!-- PDF Specific Field -->
                <div x-show="lessonContentType === 'pdf'" style="display: none;">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Upload PDF Document</label>
                    <input type="file" name="pdf_file" accept="application/pdf" 
                           class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-amber-50 file:text-amber-700">
                </div>

                <!-- Article Content Field -->
                <div x-show="lessonContentType === 'article'" style="display: none;">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Article Notes</label>
                    <textarea name="article_content" rows="4" placeholder="Write lecture text..." 
                              class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Duration (Mins)</label>
                        <input type="number" name="duration_minutes" value="10" min="1" required 
                               class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                    </div>

                    <div class="flex items-center pt-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_preview" value="1" class="h-3.5 w-3.5 text-brand-600 rounded border-slate-300">
                            <span class="ml-1.5 text-[11px] font-bold text-slate-700">Free Preview</span>
                        </label>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex justify-end space-x-2">
                    <button type="button" @click="addLessonModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-xl">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold bg-brand-600 hover:bg-brand-700 text-white rounded-xl shadow-md">Add Lesson</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
