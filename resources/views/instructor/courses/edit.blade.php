@extends('layouts.instructor')

@section('title', 'Edit Course - ' . $course->title)

@section('instructor_content')
<div class="space-y-4 max-w-6xl mx-auto">
    
    <!-- Top Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Edit Course Details</h1>
            <p class="text-xs text-slate-500">Modify metadata, pricing, description, and media</p>
        </div>
        <a href="{{ route('instructor.courses.show', $course->id) }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Curriculum Builder</span>
        </a>
    </div>

    <!-- Smart 2-Column Course Edit Form -->
    <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            
            <!-- Left Column: Core Content & Learning Outcomes (7 cols) -->
            <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
                    <i data-lucide="file-text" class="w-3.5 h-3.5 mr-1.5 text-brand-600"></i>
                    Course Information
                </h3>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Course Title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}" required 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500 text-slate-900">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Subtitle / Short Hook</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $course->subtitle) }}" 
                           class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500 text-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">What Students Will Learn</label>
                        <textarea name="outcomes" rows="3" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">{{ is_array($course->outcomes) ? implode("\n", $course->outcomes) : $course->outcomes }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Prerequisites / Requirements</label>
                        <textarea name="requirements" rows="3" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">{{ is_array($course->requirements) ? implode("\n", $course->requirements) : $course->requirements }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Course Description</label>
                    <textarea name="description" rows="4" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">{{ old('description', $course->description) }}</textarea>
                </div>
            </div>

            <!-- Right Column: Settings, Media & Publishing (5 cols) -->
            <div class="lg:col-span-5 space-y-4">
                
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
                        <i data-lucide="sliders" class="w-3.5 h-3.5 mr-1.5 text-brand-600"></i>
                        Specifications & Pricing
                    </h3>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Category</label>
                            <select name="category_id" class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                                <option value="">Select Domain...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $course->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Difficulty Level</label>
                            <select name="level" required class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                                <option value="beginner" {{ $course->level === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ $course->level === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ $course->level === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="all_levels" {{ $course->level === 'all_levels' ? 'selected' : '' }}>All Levels</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2.5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Language</label>
                            <select name="language" class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                                <option value="English" {{ ($course->language ?? 'English') === 'English' ? 'selected' : '' }}>English</option>
                                <option value="Arabic" {{ ($course->language ?? '') === 'Arabic' ? 'selected' : '' }}>Arabic (العربية)</option>
                                <option value="Hindi" {{ ($course->language ?? '') === 'Hindi' ? 'selected' : '' }}>Hindi (हिंदी)</option>
                                <option value="Urdu" {{ ($course->language ?? '') === 'Urdu' ? 'selected' : '' }}>Urdu (اردو)</option>
                                <option value="Spanish" {{ ($course->language ?? '') === 'Spanish' ? 'selected' : '' }}>Spanish (Español)</option>
                                <option value="French" {{ ($course->language ?? '') === 'French' ? 'selected' : '' }}>French (Français)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Price ($ USD)</label>
                            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $course->price) }}" required 
                                   class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Discount Price ($)</label>
                            <input type="number" step="0.01" min="0" name="discount_price" value="{{ old('discount_price', $course->discount_price) }}" placeholder="Optional"
                                   class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Thumbnail (Upload new to replace)</label>
                        <input type="file" name="thumbnail" accept="image/*" 
                               class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-brand-50 file:text-brand-700">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Preview Video URL</label>
                        <input type="url" name="preview_video_url" value="{{ old('preview_video_url', $course->preview_video_url) }}" placeholder="https://www.youtube.com/watch?v=..." 
                               class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1">Status</label>
                        <select name="status" required class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-slate-50 font-bold text-slate-800 focus:bg-white focus:border-brand-500">
                            <option value="published" {{ $course->status === 'published' ? 'selected' : '' }}>Published (Live to Students)</option>
                            <option value="draft" {{ $course->status === 'draft' ? 'selected' : '' }}>Draft (Work in progress)</option>
                        </select>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between space-x-2">
                        <a href="{{ route('instructor.courses.show', $course->id) }}" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200">Cancel</a>
                        <button type="submit" class="flex-1 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/20 transition-all flex items-center justify-center space-x-2">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection
