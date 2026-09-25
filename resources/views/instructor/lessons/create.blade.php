@extends('layouts.instructor')

@section('title', 'Add Lesson')

@section('instructor_content')
<div class="max-w-xl mx-auto space-y-4" x-data="{ contentType: 'video' }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Add Lesson</h1>
            <p class="text-xs text-slate-500">Section: {{ $section->title }}</p>
        </div>
        <a href="{{ route('instructor.courses.show', $section->course_id) }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('instructor.lessons.store', $section->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
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
                    <label @click="contentType = 'video'" :class="contentType === 'video' ? 'border-brand-600 bg-brand-50 text-brand-900 font-bold' : 'border-slate-200 text-slate-600'" 
                           class="flex items-center justify-center p-2 border rounded-xl cursor-pointer text-xs transition-colors">
                        <input type="radio" name="content_type" value="video" x-model="contentType" class="sr-only">
                        <i data-lucide="play-circle" class="w-3.5 h-3.5 mr-1 text-brand-600"></i> Video
                    </label>

                    <label @click="contentType = 'pdf'" :class="contentType === 'pdf' ? 'border-amber-600 bg-amber-50 text-amber-900 font-bold' : 'border-slate-200 text-slate-600'" 
                           class="flex items-center justify-center p-2 border rounded-xl cursor-pointer text-xs transition-colors">
                        <input type="radio" name="content_type" value="pdf" x-model="contentType" class="sr-only">
                        <i data-lucide="file-text" class="w-3.5 h-3.5 mr-1 text-amber-600"></i> PDF Guide
                    </label>

                    <label @click="contentType = 'article'" :class="contentType === 'article' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 text-slate-600'" 
                           class="flex items-center justify-center p-2 border rounded-xl cursor-pointer text-xs transition-colors">
                        <input type="radio" name="content_type" value="article" x-model="contentType" class="sr-only">
                        <i data-lucide="book" class="w-3.5 h-3.5 mr-1 text-blue-600"></i> Article
                    </label>
                </div>
            </div>

            <!-- Video Specific Fields -->
            <div x-show="contentType === 'video'" class="space-y-2">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Video URL</label>
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
            <div x-show="contentType === 'pdf'" style="display: none;">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-0.5">Upload PDF Document</label>
                <input type="file" name="pdf_file" accept="application/pdf" 
                       class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-amber-50 file:text-amber-700">
            </div>

            <!-- Article Content Field -->
            <div x-show="contentType === 'article'" style="display: none;">
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
                <a href="{{ route('instructor.courses.show', $section->course_id) }}" class="px-4 py-2 text-xs font-bold text-slate-500 rounded-xl hover:bg-slate-100">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md">Add Lesson</button>
            </div>
        </form>
    </div>
</div>
@endsection
