@extends('layouts.admin')

@section('title', 'Instructor Profile - ' . $instructor->name)

@section('admin_content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $instructor->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Instructor profile, published courses, and enrollment statistics</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-sm transition-colors">
                Edit Instructor
            </a>
            <a href="{{ route('admin.instructors.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center space-x-1 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Info Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center space-x-4">
                <img class="w-16 h-16 rounded-2xl object-cover ring-2 ring-indigo-500/20" src="{{ $instructor->avatar_url }}" alt="">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">{{ $instructor->name }}</h3>
                    <p class="text-xs text-indigo-600 font-bold">{{ $instructor->headline ?: 'Instructor' }}</p>
                    <span class="inline-block mt-2 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md {{ $instructor->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                        {{ $instructor->status }}
                    </span>
                </div>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed pt-2">
                {{ $instructor->bio ?: 'No biography written yet.' }}
            </p>

            <div class="pt-4 border-t border-slate-100 space-y-3 text-xs text-slate-500">
                <div class="flex justify-between">
                    <span class="font-medium">Email:</span>
                    <span class="text-slate-800 font-semibold">{{ $instructor->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Total Courses:</span>
                    <span class="text-indigo-600 font-bold">{{ $instructor->courses->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Joined:</span>
                    <span class="text-slate-800 font-semibold">{{ $instructor->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Created Courses List -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900 flex items-center">
                <i data-lucide="film" class="w-4 h-4 mr-2 text-indigo-600"></i>
                Courses Taught by Instructor
            </h3>

            <div class="divide-y divide-slate-100">
                @forelse($instructor->courses as $course)
                    <div class="py-3.5 flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $course->thumbnail_url }}" class="w-12 h-9 rounded-xl object-cover ring-1 ring-slate-200" alt="">
                            <div>
                                <a href="{{ route('admin.courses.show', $course->id) }}" class="font-bold text-slate-900 hover:text-rose-600 transition-colors block">
                                    {{ $course->title }}
                                </a>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $course->category->name ?? 'General' }} • {{ $course->total_lessons_count }} lessons</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-900 block">${{ number_format($course->effective_price, 2) }}</span>
                            <span class="text-[10px] text-emerald-600 font-bold">{{ $course->enrollments->count() }} students</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Instructor has not created any courses yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
