@extends('layouts.student')

@section('title', 'My Activity Assignments & Homework')

@section('student_content')
<div class="space-y-5 max-w-7xl mx-auto" x-data="{
    submitModalOpen: false,
    activeAssignment: null
}">
    
    <!-- Top Welcome Header (Compact) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-gradient-to-r from-amber-400 via-rose-400 to-sky-400 p-4 sm:p-5 rounded-2xl text-white shadow-md shadow-amber-500/15">
        <div class="space-y-1">
            <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-white/20 text-[10px] font-extrabold tracking-wide">
                <span>🎨 FUN ACTIVITIES</span>
            </div>
            <h1 class="text-lg sm:text-xl font-black tracking-tight text-white">My Creative Assignments</h1>
            <p class="text-xs text-white/95 font-medium">Draw, color, and upload your fun activities to collect glowing teacher stars!</p>
        </div>

        <a href="{{ route('courses.index') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs rounded-xl shadow-sm flex items-center space-x-1.5 self-start sm:self-auto transition-transform hover:scale-102">
            <i data-lucide="compass" class="w-3.5 h-3.5 text-amber-500"></i>
            <span>Browse Catalog</span>
        </a>
    </div>

    <!-- Active Assignments Grid (Compact Responsive 3-4 Column Grid) -->
    <div class="space-y-3">
        <h2 class="text-base font-extrabold text-slate-900 flex items-center space-x-2">
            <span>⭐</span>
            <span>Course Activities & Fun Challenges</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($assignments as $assignment)
                @php 
                    $submission = $assignment->submissions->first();
                @endphp
                <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between space-y-3 hover:border-amber-300 transition-colors">
                    <div class="space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 truncate">
                                {{ $assignment->course->title }}
                            </span>
                            <span class="text-[11px] font-bold text-amber-500 flex items-center flex-shrink-0">
                                ⭐ {{ $assignment->points }} Stars
                            </span>
                        </div>

                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $assignment->title }}</h3>
                        
                        @if($assignment->description)
                            <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-3">{{ $assignment->description }}</p>
                        @endif

                        @if($assignment->due_date)
                            <span class="text-[10px] text-slate-400 block font-medium">
                                📅 Target: {{ $assignment->due_date->format('M d, Y') }}
                            </span>
                        @endif
                    </div>

                    <!-- Submission Status / Results -->
                    <div class="pt-3 border-t border-slate-100">
                        @if($submission)
                            @if($submission->status === 'graded')
                                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-2.5 space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-emerald-800">{{ $submission->grade ?: '⭐ Graded' }}</span>
                                        <span class="text-[11px] font-extrabold text-emerald-700">{{ $submission->score }} / {{ $assignment->points }} Stars</span>
                                    </div>
                                    @if($submission->feedback)
                                        <p class="text-[10px] text-emerald-700 italic line-clamp-2">"{{ $submission->feedback }}"</p>
                                    @endif
                                </div>
                            @else
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-2.5 flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-amber-800">⏳ Submitted • Reviewing</span>
                                    <button @click="submitModalOpen = true; activeAssignment = {{ json_encode([
                                        'id' => $assignment->id,
                                        'title' => $assignment->title,
                                        'action_url' => route('student.assignments.submit', $assignment->id)
                                    ]) }}" class="text-[11px] font-bold text-amber-700 underline hover:text-amber-900">
                                        Update
                                    </button>
                                </div>
                            @endif
                        @else
                            <button @click="submitModalOpen = true; activeAssignment = {{ json_encode([
                                'id' => $assignment->id,
                                'title' => $assignment->title,
                                'action_url' => route('student.assignments.submit', $assignment->id)
                            ]) }}" class="w-full py-2 px-3 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-xs rounded-xl shadow-xs flex items-center justify-center space-x-1.5 transition-all">
                                <i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i>
                                <span>Upload Artwork</span>
                            </button>
                        @endif
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white p-8 sm:p-12 rounded-2xl border border-slate-200 text-center space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">No pending activities</h3>
                    <p class="text-xs text-slate-400">Enroll in fun learning courses to unlock drawing assignments and earn stars!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Submit Activity Modal -->
    <div x-show="submitModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="submitModalOpen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="submitModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="submitModalOpen" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 p-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center space-x-1.5">
                            <span>🎨</span>
                            <span>Submit Activity Work</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="activeAssignment ? activeAssignment.title : ''"></p>
                    </div>
                    <button @click="submitModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <form :action="activeAssignment ? activeAssignment.action_url : '#'" method="POST" enctype="multipart/form-data" class="space-y-3.5 pt-3.5">
                    @csrf
                    
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Photo of Drawing / Worksheet *</label>
                        <input type="file" name="file" accept="image/*,.pdf" 
                               class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50 p-2 file:mr-2.5 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-amber-100 file:text-amber-800">
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Formats: JPG, PNG, PDF (Up to 20MB)</span>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Student Note or Description (Optional)</label>
                        <textarea name="submission_text" rows="2" placeholder="Tell the teacher about your drawing or what you enjoyed most!" 
                                  class="w-full text-xs rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="submitModalOpen = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-4 py-1.5 bg-gradient-to-r from-amber-500 to-rose-500 hover:from-amber-600 hover:to-rose-600 text-white font-extrabold text-xs rounded-xl shadow-xs flex items-center space-x-1.5">
                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            <span>Submit to Teacher</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
